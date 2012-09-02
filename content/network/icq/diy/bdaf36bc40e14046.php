<h1>SendMess.pas</h1>
<div class="date">01.01.2007</div>


<pre>
{* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
Author:       Alexander Vaga
EMail:        primary:   icq2000cc@hobi.ru
              secondary: alexander_vaga@hotmail.com
Web:          http://icq2000cc.hobi.ru
Creation:     May, 2002
Legal issues: Copyright (C) 2002 by Alexander Vaga
              Kyiv, Ukraine
 
              This software is provided 'as-is', without any express or
              implied warranty.  In no event will the author be held liable
              for any  damages arising from the use of this software.
 
              Permission is granted to anyone to use this software for any
              purpose, including commercial applications, and to alter it
              and redistribute it freely.
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *}
 
unit SendMess;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics,
  Controls, Forms, Dialogs,  StdCtrls, Animate,
  ExtCtrls, AppEvnts, ComCtrls, Inifiles, ToolWin,
  Types,Packet,Main, RxCombos;
 
const PostSendInterval = 1000; //1 secs
type
  TMessageTo = class(TForm)
    SendMemo: TMemo;
    ApplicationEvents1: TApplicationEvents;
    SendTimer: TTimer;
    Panel2: TPanel;
    Panel1: TPanel;
    SendAnime: TAnimatedImage;
    SendButton: TButton;
    Label3: TLabel;
    Chars: TEdit;
    CancelButton: TButton;
    MesFmtBox: TCheckBox;
    BGCombo: TColorComboBox;
    Label4: TLabel;
    FGCombo: TColorComboBox;
    Label5: TLabel;
    Panel3: TPanel;
    NNEd: TEdit;
    Label1: TLabel;
    ICQEd: TEdit;
    Label2: TLabel;
    ToolBar1: TToolBar;
    UINi: TToolButton;
    procedure CancelButtonClick(Sender: TObject);
    procedure SendButtonClick(Sender: TObject);
    procedure ApplicationEvents1Message(var Msg: tagMSG;
      var Handled: Boolean);
    procedure SendTimerTimer(Sender: TObject);
    procedure SendMemoKeyUp(Sender: TObject; var Key: Word;
      Shift: TShiftState);
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
    procedure FormShow(Sender: TObject);
    procedure FGComboChange(Sender: TObject);
    procedure BGComboChange(Sender: TObject);
    procedure CalcChars;
  private
    { Private declarations }
    SEQ1, SEQ2 : word;
    CharCount : integer;
  public
    { Public declarations }
    User : PListRecord;
    FromWhom : longint;
  end;
 
implementation
{$R *.DFM}
 
const FG=0;BG=1;
function GetColor(Memo:TMemo;Mode:byte):longint;
begin
     Result:=0;
     case Mode of
     FG:Result:=ColorToRGB(Memo.Font.Color);
     BG:Result:=ColorToRGB(Memo.Color);
     end;
     GetColor:=DSWAP(Result);
end;
 
procedure TMessageTo.CancelButtonClick(Sender: TObject);
begin
     Close;
end;
 
procedure TMessageTo.SendButtonClick(Sender: TObject);
var sNN,sMess,sUIN : string;
    tmp : PPack;
    sTmp : string;
    d1,d2 : longint;
    buf : TByteArray;
    ind,indmem : word;
const capab : string{16}= #$09#$46#$13#$49#$4C#$7F#$11#$D1+
                          #$82#$22#$44#$45#$53#$54#$00#$00;
      blok : string{26} = #$1B#$00#$07#$00#$00#$00#$00#$00+
                          #$00#$00#$00#$00#$00#$00#$00#$00+
                          #$00#$00#$00#$00#$00#$00#$03#$00+
                          #$00#$00;
     x:word=0;
begin
     sNN := NNEd.Text;
     sUIN := ICQEd.Text;
     if SendMemo.Lines.Count = 0 then exit;
     sMess := SendMemo.Text;
//     if CharCount &gt; 1024 then exit;
 
     tmp := CreatePacket(2,SEQ);
     SNACAppend(tmp,$4,$6);
     d1:=random($7FFFFFFF);
     d2:=random($7FFFFFFF);
     SEQ1:=dswap(d1);
     SEQ2:=dswap(d2);
     PacketAppend32(tmp,dswap(d1));
     PacketAppend32(tmp,dswap(d2));
 
     case MesFmtBox.Checked of
     true:
      begin // advanced message
        PacketAppend16(tmp,swap($0002));
        PacketAppendB_String(tmp,sUIN);
        ind:=0;fillchar(buf,sizeof(buf),'^');
        PLONG(@(buf[ind]))^:=dswap($0005FFFF);inc(ind,4);// TLV(5)+len
        PWORD(@(buf[ind]))^:=0;inc(ind,2);
        PLONG(@(buf[ind]))^:=dswap(d1);inc(ind,4);
        PLONG(@(buf[ind]))^:=dswap(d2);inc(ind,4);
        MOVE(capab[1],buf[ind],length(capab));inc(ind,length(capab));
        PLONG(@(buf[ind]))^:=dswap($000A0002);inc(ind,4);//TLV(A)=$0001
        PWORD(@(buf[ind]))^:=swap($0001);inc(ind,2);
        PLONG(@(buf[ind]))^:=dswap($000F0000);inc(ind,4);//TLV(F)empty
 
        PLONG(@(buf[ind]))^:=dswap($2711FFFF);inc(ind,4);// TLV(2711)+len
        indmem:=ind-2;
        MOVE(blok[1],buf[ind],length(blok));inc(ind,length(blok));
        PBYTE(@(buf[ind]))^:=0;inc(ind,1);
        PWORD(@(buf[ind]))^:=swap($FFFF);inc(ind,2);
        PWORD(@(buf[ind]))^:=swap($0E00);inc(ind,2);
        PWORD(@(buf[ind]))^:=swap($FFFF);inc(ind,2);
        PLONG(@(buf[ind]))^:=$0;inc(ind,4);
        PLONG(@(buf[ind]))^:=$0;inc(ind,4);
        PLONG(@(buf[ind]))^:=$0;inc(ind,4);//12 bytes=0
        PBYTE(@(buf[ind]))^:=1;inc(ind,1); // msg-type
        PBYTE(@(buf[ind]))^:=0;inc(ind,1); //sub_msg-type
        PWORD(@(buf[ind]))^:=swap($0000);inc(ind,2);
        PWORD(@(buf[ind]))^:=swap($0100);inc(ind,2);
 
        PWORD(@(buf[ind]))^:=length(sMess)+1;inc(ind,2);//LE len sMess+1
        move(sMess[1],buf[ind],length(sMess));inc(ind,length(sMess));
        PBYTE(@(buf[ind]))^:=0;inc(ind,1); //#00
        PLONG(@(buf[ind]))^:=dswap(GetColor(SendMemo,FG));inc(ind,4);//dswap($00FF0000);//FG
        PLONG(@(buf[ind]))^:=dswap(GetColor(SendMemo,BG));inc(ind,4);//dswap($08080800);//BG
 
        PWORD(@(buf[2]))^:=swap(ind-4);//len TLV(5)
        x:=length(blok)+27+length(sMess)+9;
        PWORD(@(buf[indmem]))^:=swap(x);//len TLV(2711)-!!!!!!!!!!!!
        PacketAppend(tmp,@buf,ind);
        // ack request ?
        PacketAppend32(tmp,dswap($00030000));// TLV(3)empry
      end;
     false:
      begin // simple message
        PacketAppend16(tmp,swap($0001));
        PacketAppendB_String(tmp,sUIN);
        PacketAppend16(tmp,swap(2));//tlv(2)
        PacketAppend16(tmp,swap(13+length(sMess)));//len tlv(2)
        PacketAppend32(tmp,dswap($05010001));
        PacketAppend16(tmp,swap($0101));
        PacketAppend8(tmp,$01);//7 bytes
        PacketAppend16(tmp,swap(4+length(sMess)));//lenmsg+4
        PacketAppend32(tmp,dswap($0)); //4 bytes=0
        PacketAppend(tmp,@(sMess[1]),length(sMess));
        PacketAppend16(tmp,swap($0006));//tlv(6)
        PacketAppend16(tmp,0);//len tlv(6)=0
      end;
     end;//case
     Form1.PacketSend(tmp);
     M(SendMemo,'Sending...');
     case MesFmtBox.Checked of
     true:  sTmp := '[A] ';
     false: sTmp := '[S] ';
     end;
     sTmp := '-&gt;'+sTmp+DateTimeToStr(Now)+' '+sNN+' ['+sUIN+']  "'+sMess+'"';
     M(Form1.Memo,sTmp);  Form1.LogMessage(sTmp);
 
     if MesFmtBox.Checked then begin
       SendAnime.Active := true;
       SendMemo.Enabled := false;
       SendButton.Enabled := false;
       MesFmtBox.Enabled := false;
     end else Close;
end;
 
procedure TMessageTo.ApplicationEvents1Message(var Msg: tagMSG;
  var Handled: Boolean);
begin
     if Msg.message = msg_OnSrv then begin
       if (Msg.wParam = SEQ1)and(Msg.lParam = SEQ2) then begin
         SendAnime.Active := false;
         M(SendMemo,'&lt;Srv`s ACK&gt;');
         Handled := true;
       end;
     end;
     if Msg.message = msg_Sent then begin
       if (Msg.wParam = SEQ1)and(Msg.lParam = SEQ2) then begin
         SendAnime.Active := false;
         SendTimer.Interval := PostSendInterval;
         SendTimer.Enabled := true;
         M(SendMemo,'Message sent... ');
         Handled := true;
       end;
     end;
     if Msg.message = msg_SentErr then begin
       if (Msg.wParam = SEQ1)and(Msg.lParam = SEQ2) then begin
         SendAnime.Active := false;
         M(SendMemo,'Server`s Error... try SIMPLY message-format');
         SendMemo.Enabled := true;
         SendButton.Enabled := true;
         MesFmtBox.Enabled := true;
         Handled := true;
       end;
     end;
end;
 
procedure TMessageTo.SendTimerTimer(Sender: TObject);
begin
     SendTimer.Enabled := false;
     Close;
end;
 
procedure TMessageTo.CalcChars;
begin
     CharCount := length(SendMemo.Text);
     case CharCount of
     0..1023: with Chars do begin Font.Color := clGreen;  Color := clMenu; end;
         else with Chars do begin Font.Color := clYellow; Color := clRed;  end;
     end;
     Chars.Text := inttostr(CharCount);
end;
 
procedure TMessageTo.SendMemoKeyUp(Sender: TObject; var Key: Word;
  Shift: TShiftState);
begin
     CalcChars;
end;
 
procedure TMessageTo.FormClose(Sender: TObject; var Action: TCloseAction);
begin
     User^.EXTRA.BG := ColorToString(SendMemo.Color);
     User^.EXTRA.FG := ColorToString(SendMemo.Font.Color);
     Destroy;
end;
 
procedure TMessageTo.FormShow(Sender: TObject);
var sNN : string;
begin
     SendMemo.Color:=StringToColor(User^.EXTRA.BG);
     BGCombo.ColorValue:=SendMemo.Color;
     SendMemo.Font.Color:=StringToColor(User^.EXTRA.FG);
     FGCombo.ColorValue:=SendMemo.Font.Color;
     if User^.EXTRA.ICON_INDEX = simply_icq then
       UINi.ImageIndex := offline else
       UINi.ImageIndex := User^.EXTRA.ICON_INDEX;
     if (ICQStatus = STATE_INVISIBLE)or
        (User^.EXTRA.ICON_INDEX = simply_icq)then begin
        MesFmtBox.Enabled := false;
        MesFmtBox.Checked := false;
     end else begin
        MesFmtBox.Enabled := true;
        MesFmtBox.Checked := true;
     end;
     sNN := NNed.Text;
     CalcChars;
end;
 
procedure TMessageTo.FGComboChange(Sender: TObject);
begin
     SendMemo.Font.Color:=FGCombo.ColorValue;
     SendMemo.SetFocus;
end;
 
procedure TMessageTo.BGComboChange(Sender: TObject);
begin
     SendMemo.Color:=BGCombo.ColorValue;
     SendMemo.SetFocus;
end;
 
end.
 
</pre>

