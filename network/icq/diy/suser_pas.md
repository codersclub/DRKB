---
Title: Модуль SUser.pas
Author: Alexander Vaga, alexander_vaga@hotmail.com
Date: 22.05.2002
Source: <https://delphiworld.narod.ru>
---


SUser.pas
=========

статья: [ICQ2000 - сделай сам](./)

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
     
    unit SUser;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls, ComCtrls, Menus, Animate, ExtCtrls, Grids, AppEvnts,
      Typess,Packet,Main,UInfo;
     
    type
      TSearchUser = class(TForm)
        GroupBox1: TGroupBox;
        SearchBtn: TButton;
        StopSearchBtn: TButton;
        SearchPage: TPageControl;
        EMAIL: TTabSheet;
        DETAILS: TTabSheet;
        ICQn: TTabSheet;
        Label1: TLabel;
        GroupBox2: TGroupBox;
        Label2: TLabel;
        EMAILed: TEdit;
        GroupBox3: TGroupBox;
        Label3: TLabel;
        Label4: TLabel;
        Label5: TLabel;
        NICKed: TEdit;
        FIRSTed: TEdit;
        LASTed: TEdit;
        GroupBox4: TGroupBox;
        Label6: TLabel;
        UINed: TEdit;
        Label7: TLabel;
        FoundUsers: TStringGrid;
        FoundLabel: TLabel;
        FoundPopupMenu: TPopupMenu;
        AddToCList: TMenuItem;
        Panel1: TPanel;
        SUAnime: TAnimatedImage;
        Info: TMenuItem;
        ApplicationEvents1: TApplicationEvents;
        procedure SearchBtnClick(Sender: TObject);
        procedure StopSearchBtnClick(Sender: TObject);
        procedure FormClose(Sender: TObject; var Action: TCloseAction);
        procedure META_Search_User(NN,FN,LN : string);
        procedure META_Search_UIN(sUIN : string);
        procedure META_Search_Mail(Mail : string);
        procedure FormCreate(Sender: TObject);
        procedure AddToCListClick(Sender: TObject);
        procedure InfoClick(Sender: TObject);
        procedure ApplicationEvents1Message(var Msg: tagMSG;
          var Handled: Boolean);
      private
        { Private declarations }
      public
        Failure : boolean;
        Cookie : word;
        { Public declarations }
      end;
     
    implementation
    {$R *.DFM}
     
    type TFoundList = array[0..50] of TListRecord;
    var FoundList : TFoundList;
        FoundNum : integer;
     
    procedure TSearchUser.SearchBtnClick(Sender: TObject);
    var i : integer;
    begin
         FoundLabel.Caption := 'OFF-line mode is now!';
         if (not OL) or (not isLogged) then exit;
         FoundLabel.Caption := 'Found: ?';
         EndOfSearch := true;
         Failure := false;
         FoundNum := 0;
         FoundLabel.Caption := 'Found: '+s(FoundNum)+' user(s)';
         FoundUsers.RowCount := 2;
     
         case SearchPage.ActivePageIndex of
          0: META_Search_Mail(EMAILed.Text);
          1: META_Search_User(NICKed.Text,FIRSTed.Text,LASTed.Text);
          2: META_Search_UIN(UINed.Text);
         end;
     
         SearchBtn.Enabled := false;
         SUAnime.Active := true;
         while not EndOfSearch do Application.ProcessMessages;
         SUAnime.Active := false;
         SearchBtn.Enabled := true;
         FoundLabel.Caption := 'Found: '+s(FoundNum)+' user(s)';
         if FoundNum > 0 then begin
            for i:=0 to FoundNum-1 do begin
               with FoundUsers,FoundList[i] do begin
                  case STATUS of
                    0: Cells[0,i+1] := 'O';
                    1: Cells[0,i+1] := '+';
                    2: Cells[0,i+1] := '?';
                    else Cells[0,i+1] := '.';
                  end;
                  Cells[1,i+1] := s(UIN);
                  Cells[2,i+1] := NICK;
                  Cells[3,i+1] := FIRST;
                  Cells[4,i+1] := LAST;
                  Cells[5,i+1] := PRI_E_MAIL;
                  case AUTH of
                    0: Cells[6,i+1] := 'Author.';
                    1: Cells[6,i+1] := 'Always';
                    else Cells[6,i+1] := 'Mode: '+s(AUTH);
                  end;
                  if i=FoundNum-1 then break;
                  RowCount := RowCount + 1;
               end;
            end;
         end else begin
            Foundusers.RowCount := 2;
            FoundUsers.Cells[0,1] := '';
            FoundUsers.Cells[1,1] := '';
            FoundUsers.Cells[2,1] := '';
            FoundUsers.Cells[3,1] := '';
            FoundUsers.Cells[4,1] := '';
            FoundUsers.Cells[5,1] := '';
            FoundUsers.Cells[6,1] := '';
            EndOfSearch := true;
         end;
         if Failure then FoundLabel.Caption := '!!! Failure !!!';
    end;
     
    procedure TSearchUser.StopSearchBtnClick(Sender: TObject);
    begin
         EndOfSearch := true;
         SearchBtn.Enabled := true;
    end;
     
    procedure TSearchUser.FormClose(Sender: TObject; var Action: TCloseAction);
    begin
         EndOfSearch := true;
         Destroy;
    end;
     
    procedure TSearchUser.META_Search_User(NN,FN,LN : string);
    var p,a : PPack;
    begin
         if (NN='')and(FN='')and(LN='') then exit;
         EndOfSearch := false;
     
         a := PacketNew;
         PacketGoto(a,2); // a[0..1] = len
         PacketAppend32(a,main.UIN);
         PacketAppend16(a,swap($D007));
         Cookie := random($FF) shl 8;
         PacketAppend16(a,swap(Cookie));
         PacketAppend16(a,swap($1505));
     
         PacketAppendString(a,FN);
         PacketAppendString(a,LN);
         PacketAppendString(a,NN);
     
         PacketBegin(a);
         PacketAppend16(a,a.length-2);
     
         P:=CreatePacket(2,SEQ);
         SNACAppend(p,$15,$2);
         TLVAppend(p,1,a.length,@a.data);
         PacketDelete(a);
         Form1.PacketSend(p);
         M(Form1.Memo,'>Search Detail: Nick:'+NN+'   First:'+FN+'   Last:'+LN+'   '+
                      'Cookie:$'+inttohex(Cookie,4));
    end;
     
    procedure TSearchUser.META_Search_UIN(sUIN : string);
    var p,a : PPack;
        i : integer;
    begin
         if (sUIN='')then exit;
         for i:=1 to length(sUIN) do if (sUIN[i]<'0')or(sUIN[i]>'9') then exit;
         EndOfSearch := false;
     
         a := PacketNew;
         PacketGoto(a,2); // a[0..1] = len
         PacketAppend32(a,main.UIN);
         PacketAppend16(a,swap($D007));
         Cookie := random($FF) shl 8;
         PacketAppend16(a,swap(Cookie));
         PacketAppend16(a,swap($1F05));
         try PacketAppend32(a,strtoint(sUIN));
         except PacketAppend32(a,10000000); end;
         PacketBegin(a);
         PacketAppend16(a,a.length-2);
     
         P:=CreatePacket(2,SEQ);
         SNACAppend(p,$15,$2);
         TLVAppend(p,1,a.length,@a.data);
         PacketDelete(a);
         Form1.PacketSend(p);
         M(Form1.Memo,'>Search UIN: '+sUIN+'   '+
                      'Cookie:$'+inttohex(Cookie,4));
    end;
     
    procedure TSearchUser.META_Search_Mail(Mail : string);
    var p,a : PPack;
    begin
         if (Mail='')or(pos('@',Mail)=0) then exit;
         EndOfSearch := false;
     
         a := PacketNew;
         PacketGoto(a,2);// a[0..1] = len
         PacketAppend32(a,main.UIN);
         PacketAppend16(a,swap($D007));
         Cookie := random($FF) shl 8;
         PacketAppend16(a,swap(Cookie));
         PacketAppend16(a,swap($2905));
         PacketAppendString(a,Mail);
     
         PacketBegin(a);
         PacketAppend16(a,a.length-2);
     
         P:=CreatePacket(2,SEQ);
         SNACAppend(p,$15,$2);
         TLVAppend(p,1,a.length,@a.data);
         PacketDelete(a);
         Form1.PacketSend(p);
         M(Form1.Memo,'>Search E-Mail: '+Mail+'   '+
                            'Cookie:$'+inttohex(Cookie,4));
    end;
     
    procedure TSearchUser.FormCreate(Sender: TObject);
    begin
         with FoundUsers do begin
            Cells[0,0] := 'St';
            Cells[1,0] := 'UIN';
            Cells[2,0] := 'Nick Name';
            Cells[3,0] := 'First Name';
            Cells[4,0] := 'Last Name';
            Cells[5,0] := 'E-Mail';
            Cells[6,0] := 'Authorization';
         end;
    end;
     
    procedure TSearchUser.AddToCListClick(Sender: TObject);
    var Y : integer;
        node : TTreeNode;
        tmp : PPack;
    begin
         Y := FoundUsers.Selection.Top;
         if FoundNum = 0 then exit;
     
    // copy to Contact List
         ContactList[CLNum] := FoundList[Y-1];
         if ContactList[CLNum].NICK = '' then
            ContactList[CLNum].NICK := s(ContactList[CLNum].UIN) ;
     
         ContactList[CLNum].EXTRA.ICON_INDEX := simply_icq;
         ContactList[CLNum].EXTRA.MES_IS := false;
     
    // add to TTreeView
         node := Form1.CL.Items.AddObject(nil,ContactList[CLNum].NICK,@ContactList[CLNum]);
         node.ImageIndex := ContactList[CLNum].EXTRA.ICON_INDEX;
         node.SelectedIndex := ContactList[CLNum].EXTRA.ICON_INDEX;
     
         inc(CLNum);
     
         Form1.CL.AlphaSort;
         Form1.WriteToContactList(ContactList[CLNum-1]);
     
    // Add to Contact List
         tmp := CreatePacket(2,SEQ);
         SNACAppend(tmp,$3,$4);
         PacketAppendB_String(tmp,s(ContactList[CLNum-1].UIN));
         Form1.PacketSend(tmp);
         M(Form1.Memo,'>Add To Contact List: '
                     +s(ContactList[CLNum-1].UIN));
    // ... a useru ob etom ne obiazatelno znat :^)
    end;
     
    procedure TSearchUser.InfoClick(Sender: TObject);
    var  TUI : TUserInfo;
         Y : integer;
    begin
         Y := FoundUsers.Selection.Top;
         if FoundNum = 0 then exit;
     
         Application.CreateForm(TUserInfo,TUI);
         TUI.AutoRetrieve := true;
         TUI.Caption := 'Info:  '+s(FoundList[Y-1].UIN)+'   ( '+FoundList[Y-1].NICK+' )';
         TUI.UIRecord := FoundList[Y-1];
         TUI.Show;
    end;
     
    procedure TSearchUser.ApplicationEvents1Message(var Msg: tagMSG;
      var Handled: Boolean);
    var  PBuff : PSearchRec;
         i : integer;
         IsAlways : boolean;
    begin
         if Msg.message = msg_SInfo then begin
           if (Msg.wParam = Cookie)then begin
             Handled := false;
             PBuff := PSearchRec(Msg.lParam);
             if FoundNum = 50 then exit;
             IsAlways := false;
             for i:=0 to FoundNum-1 do
             if FoundUsers.Cells[1,i+1] = s(PBuff^.uin) then begin
                IsAlways := true;
                break;
             end;
             if not IsAlways then
             with PBuff^ do begin
               if uin <> 999999999 then begin
                 FoundList[FoundNum].UIN := uin;
                 FoundList[FoundNum].NICK := nick;
                 FoundList[FoundNum].FIRST := first;
                 FoundList[FoundNum].LAST := last;
                 FoundList[FoundNum].PRI_E_MAIL := email;
                 FoundList[FoundNum].AUTH := auth;
                 FoundList[FoundNum].STATUS := status;
                 inc(FoundNum);
               end else Failure := true;
             end;
             Dispose(PBuff);
           end;
         end;
    end;
     
     
    end.
     
     
