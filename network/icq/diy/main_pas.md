---
Title: Модуль Main.pas
Author: Alexander Vaga, alexander_vaga@hotmail.com
Date: 22.05.2002
Source: <https://delphiworld.narod.ru>
---

Main.pas
========

статья: [ICQ2000 - сделай сам](./)

    {* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    Author:       Alexander Vaga
    EMail:        alexander_vaga@hotmail.com
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
     
    {$A-,B+,C+,D+,E-,F-,G+,H+,I+,J+,K-,L+,M+,N+,O-,P+,Q-,R-,S-,T-,U-,V+,W-,X+,Y+,Z1}
    unit Main;
    interface
    uses
      Windows, Messages, SysUtils, Graphics,
      Forms, Dialogs, ComCtrls, Buttons, ToolWin,
      ExtCtrls, Menus, ImgList, ScktComp, Controls,
      StdCtrls, Classes, inifiles,
      Types, Packet;
     
    type
      TForm1 = class(TForm)
        MainT: TTimer;
        StatusMenu: TPopupMenu;
        OnlineConnected1: TMenuItem;
        FreeForChat1: TMenuItem;
        sep1: TMenuItem;
        Away1: TMenuItem;
        NAExtendedAway1: TMenuItem;
        sep2: TMenuItem;
        OccupiedUrgentMsgs1: TMenuItem;
        DNDDoNotDisturb1: TMenuItem;
        sep3: TMenuItem;
        PrivacyInvisible1: TMenuItem;
        OfflineDiscconnect1: TMenuItem;
        Panel1: TPanel;
        Panel3: TPanel;
        Splitter1: TSplitter;
        CLI: TClientSocket;
        BG: TPanel;
        Memo: TMemo;
        StatusBtn: TButton;
        procedure FormCreate(Sender: TObject);
        procedure FormClose(Sender: TObject; var Action: TCloseAction);
        procedure InitUser;
        procedure InitLogs;
        procedure CloseLogs;
        procedure ConnectMode(Mode : boolean);
        procedure MainTTimer(Sender: TObject);
        procedure OnlineConnected1Click(Sender: TObject);
        procedure Away1Click(Sender: TObject);
        procedure DNDDoNotDisturb1Click(Sender: TObject);
        procedure PrivacyInvisible1Click(Sender: TObject);
        procedure OfflineDiscconnect1Click(Sender: TObject);
        procedure OccupiedUrgentMsgs1Click(Sender: TObject);
        procedure FreeForChat1Click(Sender: TObject);
        procedure NAExtendedAway1Click(Sender: TObject);
        procedure CLIConnect(Sender: TObject; Socket: TCustomWinSocket);
        procedure CLI_ReadData(Sender: TObject; Socket: TCustomWinSocket);
        procedure CLIDisconnect(Sender: TObject; Socket: TCustomWinSocket);
        procedure PacketSend(p:PPack);
        procedure ShowUserONStatus(p:PPack);
        procedure SNAC_15_3(p:PPack);
        procedure SNAC_4_7(p:PPack);
        procedure icq_Login(Status : longint);
        procedure SetStatus(Status:longint);
        procedure StatusChange(Status:longint);
        procedure AuthorizePart(p:PPack);
        procedure WorkPart(p:PPack);
        procedure DoMsg(on_off:boolean;typemes,lenmes:integer; data:PCharArray; r_uin:longint; DateTime:TDateTime);
        procedure DoSimpleMsg(r_uin:longint; Text:string);
        procedure ClearFIFO;
        procedure debugFILE(tmp:PPack; Direction:char);
        procedure LogMessage(s:string);
        procedure StatusBtnClick(Sender: TObject);
      private{ Private declarations }
      public { Public declarations }
      protected { Protected declarations }
      published { Published declarations }
     end;
     
    var Form1 : TForm1;
        UIN           : longint;
        NICK          : string;
        PASSWORD      : string;
        ICQStatus     : longint;
        DIM_IP        : IPArray;
        Local_IP      : string;
        Local_Name    : string;
        SEQ           : word;
        FLAP          : FLAP_HDR;
        FLAP_DATA     : TByteArray;
        Index         : integer;
        NeedBytes     : integer;
        sCOOKIE       : string;
        Cookie        : word;
        WorkAddress   : string;
        WorkPort      : integer;
        log,mess      : text;
     
    const
        isLogged   : boolean = false;
        isAuth     : boolean = true;
        isHDR      : boolean = true;
        HeadFIFO   : PFLAP_Item = nil;
     
    implementation
     
    {$R *.DFM}
     
    (****************************************************************)
    procedure TForm1.PacketSend(p:PPack);
    begin
           SetLengthPacket(p);
           CLI.socket.sendbuf(p^.data,p^.length);
           debugFILE(p,'>');
           PacketDelete(p);
    end;
     
    (****************************************************************)
    procedure TForm1.ConnectMode(Mode : boolean);
    begin
         case Mode of
          true: begin
            isLogged := true;
            case ICQStatus of
              STATE_ONLINE:      StatusBtn.Caption := 'online';
              STATE_AWAY:        StatusBtn.Caption := 'away';
              STATE_DND:         StatusBtn.Caption := 'dnd';
              STATE_OCCUPIED:    StatusBtn.Caption := 'occupied';
              STATE_FREEFORCHAT: StatusBtn.Caption := 'freeforchat';
              STATE_N_A:         StatusBtn.Caption := 'na';
              STATE_INVISIBLE:   StatusBtn.Caption := 'invisible';
              else               StatusBtn.Caption := 'offline';
            end;
          end;
          false: begin
            If CLI.Active then CLI.Close;
            ClearFIFO;
            isLogged := false;
            StatusBtn.Caption := 'offline';
          end;
         end; 
    end;
     
    (****************************************************************)
    procedure TForm1.FormCreate(Sender: TObject);
    begin
        InitUser;
        InitLogs;
    end;
     
    (****************************************************************)
    procedure TForm1.debugFILE(tmp:PPack; Direction:char);
    begin
         writeln(log,DateTimeToStr(Now)+' =================================');
         writeln(log,Direction+'FLAP: '+inttohex(tmp^.Sign,2)+' '+
              inttohex(tmp^.ChID,2)+' '+inttohex(swap(tmp^.SEQ),4)+' '+
              inttohex(swap(tmp^.Len),4)+' '+'['+inttostr(swap(tmp^.Len))+']');
         writeln(log,Direction+'SNACK:  $'+inttohex(swap(tmp^.SNAC.FamilyID),4)+
                         ':'+inttohex(swap(tmp^.SNAC.SubTypeID),4)+
                  ' flags:$'+inttohex(swap(word(tmp^.SNAC.Flags)),4)+
                    ' ref:$'+inttohex(DSwap(tmp^.SNAC.RequestID),8));
         writeln(log,Dim2Str(@(tmp^.FLAP_BODY),swap(tmp^.FLAP.Len)));
         writeln(log,Dim2Hex(@(tmp^.FLAP_BODY),swap(tmp^.FLAP.Len)));
         writeln(log,'');
    end;
     
    (****************************************************************)
    procedure TForm1.CLIDisconnect(Sender: TObject; Socket: TCustomWinSocket);
    begin
         M(Memo,'Disconnected: '+Socket.RemoteAddress);
    end;
     
    (****************************************************************)
    procedure TForm1.CLIConnect(Sender: TObject; Socket: TCustomWinSocket);
    begin
         M(Memo,'Connected: '+Socket.RemoteAddress);
    end;
     
    (****************************************************************)
    procedure TForm1.CLI_ReadData(Sender: TObject; Socket: TCustomWinSocket);
    var num,Bytes,fact : integer;
        pFIFO,CurrFIFO : PFLAP_Item;
        buf : array[0..100] of byte;
    begin
         num := Socket.ReceiveLength;
         if isHDR then begin
           if num>=6 then begin
             Socket.ReceiveBuf(FLAP,6);
             NeedBytes := swap(FLAP.Len);
             Index := 0;
             isHDR := not isHDR;
           end else begin
                 M(memo,'!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!');
                 Socket.ReceiveBuf(buf,num);
                 M(Memo,Dim2Hex(@(buf),num));
                 M(memo,'!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!');
               end;
     
         end else begin  
             Bytes := NeedBytes;
             fact := Socket.ReceiveBuf(FLAP_DATA[Index],Bytes);
             inc(Index,fact);
             dec(NeedBytes,fact);
             if NeedBytes = 0 then begin
               New(pFIFO);
               pFIFO^.FLAP := FLAP;
               pFIFO^.Next := nil;
               GetMem(pFIFO^.DATA,Index);
               move(FLAP_DATA,PFIFO^.Data^,swap(FLAP.Len));
               // AddToLast
               CurrFIFO:=HeadFIFO;
               if HeadFIFO<>nil then begin
                 while CurrFIFO<>nil do
                   if CurrFIFO^.Next=nil then begin
                     CurrFIFO^.Next:=pFIFO;
                     break;
                   end else CurrFIFO:=CurrFIFO^.Next;
               end else HeadFIFO:=pFIFO; // list is empty
               isHDR := not isHDR; 
             end;
         end;
    end;
     
    (****************************************************************)
    procedure TForm1.MainTTimer(Sender: TObject);
    var FindFIFO : PFLAP_Item;
        tmp : PPack;
    begin
         MainT.Enabled := false;
         while HeadFIFO<>nil do begin
           // Get HeadFIFO
           FindFIFO := HeadFIFO;
           if HeadFIFO^.Next=nil then HeadFIFO := nil
           else HeadFIFO := HeadFIFO^.Next;
     
           // creating new packet
           tmp := PacketNew;
           // Fill the packet
           PacketAppend(tmp,@FindFIFO^.FLAP,sizeof(FLAP_HDR));
           PacketAppend(tmp,FindFIFO^.DATA,swap(FindFIFO^.FLAP.Len));
           // Release packet`s memory
           FreeMem(FindFIFO^.DATA,swap(FindFIFO^.FLAP.Len));
           Dispose(FindFIFO);
           //
           debugFILE(tmp,'<');
           if isAuth then AuthorizePart(tmp)
           else WorkPart(tmp);
           // Deleting packet
           PacketDelete(tmp);
         end;
         MainT.Enabled := true;
    end;
     
    (****************************************************************)
    procedure TForm1.AuthorizePart(p:PPack);
    var ss : string;
        T : integer;
        tmp : PPack;
    begin
         PacketGoto(p,sizeof(FLAP_HDR)); // goto FLAP_DATA
     
         // Authorize Server ACK
         if (swap(p^.Len)=4)and
            (swap(p^.SNAC.FamilyID)=0)and
            (swap(p^.SNAC.SubTypeID)=1) then begin
            M(Memo,'<Authorize Server CONNECT');
     
           // Auth Request (Login)
           SEQ := random($7FFF);
           tmp := CreatePacket(1,SEQ);
           PacketAppend32(tmp,DSwap(1));
           TLVAppendStr(tmp,$1,s(UIN));
           TLVAppendStr(tmp,$2,Calc_Pass(PASSWORD));
           TLVAppendStr(tmp,$3,'ICQ Inc. - Product of ICQ (TM).2000a.4.31.1.3143.85');
           TLVAppendWord(tmp,$16,$010A);
           TLVAppendWord(tmp,$17,$0004); // for 2000a
           TLVAppendWord(tmp,$18,$001F);
           TLVAppendWord(tmp,$19,$0001);
           TLVAppendWord(tmp,$1A,$0C47);
           TLVAppendDWord(tmp,$14,$00000055);
           TLVAppendStr(tmp,$0F,'en');
           TLVAppendStr(tmp,$0E,'us');
           PacketSend(tmp);
           M(Memo,'>Auth Request (Login)');
     
         end else  // Auth Response (COOKIE or ERROR)
         if (TLVReadStr(p,ss)=1){and(ss=s(UIN))}then begin
            T := TLVReadStr(p,ss);
            case T of
              5: begin // BOS-IP:PORT
                M(Memo,'<Auth Responce (COOKIE)');
                WorkAddress := copy(ss,1,pos(':',ss)-1);
                WorkPort := strtoint(copy(ss,pos(':',ss)+1,length(ss)-pos(':',ss)));
                if (TLVReadStr(p,sCOOKIE)=6)then begin;;;;
                  // Empty packet for disconnect
                  tmp:=CreatePacket(4,SEQ); // ChID=4
                  PacketSend(tmp);
                  // Disconnect from Autorize Server
                  OfflineDiscconnect1Click(self);
                  isAuth := false;
                  // Connecting to BOS
                  CLI.Address := WorkAddress;
                  CLI.Host := '';
                  CLI.Port := WorkPort;
                  M(Memo,'');
                  M(Memo,'>>> Connecting to BOS: '+ss);
                  CLI.Open;
                end;
              end;
              4,8: begin
                   M(Memo,'<Auth ERROR');
                   M(Memo,'TLV($'+inttohex(T,2)+') ERROR');
                   M(Memo,'STRING: '+ss);
                   if pos('http://',ss)>0 then begin
                   end;
                   TLVReadStr(p,ss); M(Memo,ss);
                   OfflineDiscconnect1Click(self);
                   M(Memo,'');
                 end;
            end;
         end;
    end;
     
    (****************************************************************)
    procedure TForm1.WorkPart(p:PPack);
    var ss,ss2,sErr : string;
    //    T : integer;
        tmp : PPack;
        i : integer;
    begin
         if p^.FLAP.ChID = 4 then begin // SERVER GONNA DISCONNECT
           PacketGoto(p,sizeof(FLAP_HDR));
           TLVReadStr(p,ss); M(Memo,ss);
           TLVReadStr(p,ss2); M(Memo,ss2);
           OfflineDiscconnect1Click(self);
           sErr:='Str1: ';
           for i:=1 to length(ss) do sErr:=sErr+inttohex(byte(ss[i]),2)+' ';
           sErr:=sErr+#13#10+'Str2: '+ss2+#13#10+#13#10;
           ShowMessage('Another Computer Use YOUR UIN!'#13#10+#13#10+
                       sErr+'...i gonna to disconnect');
           exit;
         end;
     
         PacketGoto(p,sizeof(FLAP_HDR)+sizeof(SNAC_HDR));
         // BOS Connection ACK
         if (swap(p^.Len)=4)and
            (swap(p^.SNAC.FamilyID)=0)and
            (swap(p^.SNAC.SubTypeID)=1) then begin
            M(Memo,'<BOS connection ACK');
     
           // BOS Sign-ON  (COOKIE)
           SEQ := random($7FFF);
           tmp := CreatePacket(1,SEQ);
           PacketAppend32(tmp,DSwap(1));
           TLVAppendStr(tmp,$6,sCOOKIE);
           PacketSend(tmp);
           M(Memo,'>BOS Sign-ON (COOKIE)');
     
         end else  // BOS-Host ready
         if (swap(p^.SNAC.FamilyID)=1)and
            (swap(p^.SNAC.SubTypeID)=3) then begin
            M(Memo,'<BOS-Host ready');
     
           // I`m ICQ client, not AIM
           tmp := CreatePacket(2,SEQ);
           SNACAppend(tmp,$1,$17);
           PacketAppend32(tmp,dswap($00010003));
           PacketAppend32(tmp,dswap($00020001));
           PacketAppend32(tmp,dswap($00030001));
           PacketAppend32(tmp,dswap($00150001));
           PacketAppend32(tmp,dswap($00040001));
           PacketAppend32(tmp,dswap($00060001));
           PacketAppend32(tmp,dswap($00090001));
           PacketAppend32(tmp,dswap($000A0001));
           PacketSend(tmp);
           M(Memo,'>"I`m ICQ client, not AIM"');
     
         end else // ACK to "I`m ICQ Client"
         if (swap(p^.SNAC.FamilyID)=$1)and // ACK
            (swap(p^.SNAC.SubTypeID)=$18) then begin
            M(Memo,'<ACK to "I`m ICQ client"');
     
           // Rate Information Request
           tmp := CreatePacket(2,SEQ);
           SNACAppend(tmp,$1,$6);
           PacketSend(tmp);
           M(Memo,'>Rate Information Request');
     
         end else // Rate Information Response
         if (swap(p^.SNAC.FamilyID)=$1)and
            (swap(p^.SNAC.SubTypeID)=$7) then begin
            M(Memo,'<Rate Information Response');
     
           // ACK to Rate Information Response
           tmp := CreatePacket(2,SEQ);
           SNACAppend(tmp,$1,$8);
           PacketAppend32(tmp,DSwap($00010002));
           PacketAppend32(tmp,DSwap($00030004));
           PacketAppend16(tmp,Swap($0005));
           PacketSend(tmp);
           M(Memo,'>ACK to Rate Response');
     
           // Request Personal Info
           tmp := CreatePacket(2,SEQ);
           SNACAppend(tmp,$1,$0E);
           PacketSend(tmp);
           M(Memo,'>Request Personal Info');
     
           // Request Rights for Location service
           tmp := CreatePacket(2,SEQ);
           SNACAppend(tmp,$2,$02);
           PacketSend(tmp);
           M(Memo,'>Request Rights for Location service');
     
           // Request Rights for Buddy List
           tmp := CreatePacket(2,SEQ);
           SNACAppend(tmp,$3,$02);
           PacketSend(tmp);
           M(Memo,'>Request Rights for Buddy List');
     
           // Request Rights for ICMB
           tmp := CreatePacket(2,SEQ);
           SNACAppend(tmp,$4,$04);
           PacketSend(tmp);
           M(Memo,'>Request Rights for ICMB');
     
           // Request BOS Rights
           tmp := CreatePacket(2,SEQ);
           SNACAppend(tmp,$9,$02);
           PacketSend(tmp);
           M(Memo,'>Request BOS Rights');
     
         end else  // Personal Information
         if (swap(p^.SNAC.FamilyID)=$1)and
            (swap(p^.SNAC.SubTypeID)=$F) then begin
            M(Memo,'<Personal Information');
     
         end else  // Rights for location service
         if (swap(p^.SNAC.FamilyID)=$2)and
            (swap(p^.SNAC.SubTypeID)=$3) then begin
            M(Memo,'<Rights for location service');
     
         end else  // Rights for byddy list
         if (swap(p^.SNAC.FamilyID)=$3)and
            (swap(p^.SNAC.SubTypeID)=$3) then begin
            M(Memo,'<Rights for byddy list');
     
         end else  // Rights for ICMB
         if (swap(p^.SNAC.FamilyID)=$4)and
            (swap(p^.SNAC.SubTypeID)=$5) then begin
            M(Memo,'<Rights for ICMB');
     
         end else // BOS Rights
         if (swap(p^.SNAC.FamilyID)=$9)and
            (swap(p^.SNAC.SubTypeID)=$3) then begin
            M(Memo,'<BOS Rights');
     
           // Set ICMB parameters
           tmp := CreatePacket(2,SEQ);
           SNACAppend(tmp,$4,$2);
           PacketAppend16(tmp,swap($0));
           PacketAppend32(tmp,dswap($3));
           PacketAppend16(tmp,swap($1F40));
           PacketAppend16(tmp,swap($03E7));
           PacketAppend16(tmp,swap($03E7));
           PacketAppend16(tmp,swap($0));
           PacketAppend16(tmp,swap($0));
           PacketSend(tmp);
           M(Memo,'>Set ICMB parameters');
     
           // Set User Info (capability)
           tmp := CreatePacket(2,SEQ);
           SNACAppend(tmp,$2,$4);      // tlv(5)=capability
           TLVAppendStr(tmp,5,#$09#$46#$13#$49#$4C#$7F#$11#$D1+
                              #$82#$22#$44#$45#$53#$54#$00#$00+
                              #$09#$46#$13#$44#$4C#$7F#$11#$D1+
                              #$82#$22#$44#$45#$53#$54#$00#$00);
           PacketSend(tmp);
           M(Memo,'>Set User Info (capability)');
     
           // Send Contact List
           tmp := CreatePacket(2,SEQ);
           SNACAppend(tmp,$3,$4);
           PacketAppendB_String(tmp,s(UIN)); 
           // PacketAppendB_String(tmp,s(someUIN)); 
           PacketSend(tmp);
           M(Memo,'>Send Contact List (1)');
     
           case ICQStatus of
           STATE_INVISIBLE: begin
               // Send Visible List
               tmp := CreatePacket(2,SEQ);
               SNACAppend(tmp,$9,$5);
               PacketSend(tmp);
               M(Memo,'>Send Visible List (0)');
             end;
           else begin
               // Send Invisible List
               tmp := CreatePacket(2,SEQ);
               SNACAppend(tmp,$9,$7);
               PacketSend(tmp);
               M(Memo,'>Send Invisible List (0)');
             end;
           end;//case
     
           ConnectMode(true);
           SetStatus(ICQStatus);
           M(Memo,'>Set Status Code');
     
           // Client Ready
           tmp := CreatePacket(2,SEQ);
           SNACAppend(tmp,$1,$2);
           PacketAppend32(tmp,dswap($00010003));
           PacketAppend32(tmp,dswap($0110028A));
           PacketAppend32(tmp,dswap($00020001));
           PacketAppend32(tmp,dswap($0101028A));
           PacketAppend32(tmp,dswap($00030001));
           PacketAppend32(tmp,dswap($0110028A));
           PacketAppend32(tmp,dswap($00150001));
           PacketAppend32(tmp,dswap($0110028A));
           PacketAppend32(tmp,dswap($00040001));
           PacketAppend32(tmp,dswap($0110028A));
           PacketAppend32(tmp,dswap($00060001));
           PacketAppend32(tmp,dswap($0110028A));
           PacketAppend32(tmp,dswap($00090001));
           PacketAppend32(tmp,dswap($0110028A));
           PacketAppend32(tmp,dswap($000A0003));
           PacketAppend32(tmp,dswap($0110028A));
           PacketSend(tmp);
           M(Memo,'>Client Ready');
     
           // Get offline messages
           tmp := CreatePacket(2,SEQ);
           SNACAppend(tmp,$15,$2);
           PacketAppend32(tmp,dswap($0001000A));
           PacketAppend16(tmp,swap($0800));
           PacketAppend32(tmp,UIN);
           PacketAppend16(tmp,swap($3C00));
           PacketAppend16(tmp,swap($0200));
           PacketSend(tmp);
           M(Memo,'>Get offline messages');
     
           // Get Banner Address
           tmp := CreatePacket(2,SEQ);
           SNACAppend(tmp,$15,$2);
           PacketAppend16(tmp,swap($0001));
           ss:='<key>BannersIP</key>';
           PacketAppend16(tmp,swap(14+length(ss)+1));
           PacketAppend16(tmp,swap($2100));
           PacketAppend32(tmp,UIN);
           PacketAppend16(tmp,swap($D007)); // Type
           PacketAppend16(tmp,swap($0300)); // Cookie
           PacketAppend16(tmp,swap($9808)); // SubType = xml-style (LNTS)
           PacketAppendString(tmp,ss); // '<key>BannersIP</key>'
           PacketSend(tmp);
           M(Memo,'>Get Banner Address');
     
         end else  // Reject notification
         if (swap(p^.SNAC.FamilyID)=$3)and
            (swap(p^.SNAC.SubTypeID)=$0A) then begin
            M(Memo,'');
            M(Memo,'<Reject from UIN: '+PacketReadB_String(p));
            M(Memo,'');
     
         end else  // UIN ON-line
         if (swap(p^.SNAC.FamilyID)=$3)and
            (swap(p^.SNAC.SubTypeID)=$0B) then begin
            M(Memo,'');
            ShowUserONStatus(p);
            M(Memo,'');
     
         end else  // UIN OFF-line ???
         if (swap(p^.SNAC.FamilyID)=$3)and
            (swap(p^.SNAC.SubTypeID)=$0C) then begin
            M(Memo,'');
            M(Memo,'<UIN OFF-line: '+PacketReadB_String(p));
            M(Memo,'');
     
         end else  // SNAC 15,3  Meny purposes (offlines messages)
         if (swap(p^.SNAC.FamilyID)=$15)and
            (swap(p^.SNAC.SubTypeID)=$3) then begin
            M(Memo,'');
            SNAC_15_3(p);
            M(Memo,'');
     
         end else  // SNAC 4,7  Incoming message
         if (swap(p^.SNAC.FamilyID)=$4)and
            (swap(p^.SNAC.SubTypeID)=$7) then begin
            M(Memo,'');
            SNAC_4_7(p);
            M(Memo,'');
     
         end else begin
                    M(Memo,'');
                    M(Memo,'???? Unrecognized SNAC: ????????');
                    M(Memo,'???? SNAC [$'+inttohex(swap(p^.SNAC.FamilyID),2)+':$'+
                                    inttohex(swap(p^.SNAC.SubTypeID),2)+']');
                    M(Memo,'');
                  end;
    end;
     
    (****************************************************************)
    procedure TForm1.ShowUserONStatus(p:PPack);
    var T : word;
        k,cnt : integer;
        UINonline,TLV : string;
        r_ip,r_r_ip,r_status : longint;
    begin
          UINonline := PacketReadB_String(p);
          M(Memo,'<UIN ON-line: '+UINonline);
          PacketRead16(p);
          cnt := swap(PacketRead16(p));
          for k:=1 to cnt do begin
            T := TLVReadStr(p,TLV);
            case T of
            6:  begin // STATUS
                move(TLV[1],IPArray(r_status),4);
                r_status := DSwap(r_status);
                M(Memo,'#'+s(k)+' TLV($'+inttohex(T,2)+')'+
                        ' STATUS: $'+inttohex(r_status,8));
                end;
            $A: begin // IP
                move(TLV[1],IPArray(r_ip),4);
                M(Memo,'#'+s(k)+' TLV($'+inttohex(T,2)+')'+
                       ' IP: '+IPToStr(IPArray(r_ip)));
                end;
            $C: begin // REAL_IP
                move(TLV[1],IPArray(r_r_ip),4);
                M(Memo,'#'+s(k)+' TLV($'+inttohex(T,2)+')'+
                       ' Real IP: '+IPToStr(IPArray(r_r_ip)));
                end;
                //else M(Memo,'??? #'+s(k)+' TLV($'+inttohex(T,2)+')');
            end;
          end;
    end;
     
    (****************************************************************)
    procedure TForm1.SNAC_15_3(p:PPack);
    var MessageType : word;
        {myUIN,}hisUIN : longint;
        SubType : array[0..3] of byte;
        MessageSubType : longint absolute SubType;
        year,month,day,hour,minute,typemes,{subtypemes,}lenmes : word;
        tmp : PPack;
        sTemp,URL : string;
    begin
         PacketRead32(p);
         PacketRead16(p);
         {myUIN := }PacketRead32(p);
         MessageType := swap(PacketRead16(p));
         {Cookie := }swap(PacketRead16(p));
         //M(Memo,'<Cookie: $'+inttohex(Cookie,4));
         case MessageType of
         $DA07: begin
                SubType[3] := 0;
                SubType[2] := PacketRead8(p);
                SubType[1] := PacketRead8(p);
                SubType[0] := PacketRead8(p);
                if(MessageSubType and $FF)<>$0A then begin
                  M(Memo,'<FAIL: SubType:$'+inttohex(MessageSubType,4));
                end;
                case MessageSubType of
                $A2080A: begin // Banner URL
                          sTemp := PacketReadString(p);
                          sTemp[pos('<',sTemp)] :='_';
                          URL := 'http://'+copy(sTemp,pos('>',sTemp)+1,pos('<',sTemp)-pos('>',sTemp)-1);
                          M(Memo,'<Banner HTML-Server: '+URL);
                         end;
                else M(Memo,'<??? SNAC 15,3; Type:$DA07; SubType: $'+inttohex(MessageSubType,6));
                end;//
                end;
     
         $4200: begin // END of offline messages
                //M(Memo,'<Message-Type: $'+inttohex(MessageType,4));
                M(Memo,'<End of OFFline messages');
                tmp := CreatePacket(2,SEQ);
                SNACAppend(tmp,$15,$2);
                PacketAppend16(tmp,swap($0001)); // TLV(1)
                PacketAppend32(tmp,dswap($000A0800));
                PacketAppend32(tmp,UIN);
                PacketAppend16(tmp,swap($3E00)); // ACK
                PacketAppend16(tmp,swap($0200));
                PacketSend(tmp);
                //M(Memo,'>ACK it');
                end;
         $4100: begin // OFFLINE MESSAGE
                hisUIN := PacketRead32(p); // LE
                //M(Memo,'<Message-Type: $'+inttohex(MessageType,4));
                M(Memo,'<OFFLINE MESSAGE from UIN: '+s(hisUIN));
                year := PacketRead16(p);
                month := PacketRead8(p);
                day := PacketRead8(p);
                hour := PacketRead8(p);
                minute := PacketRead8(p);
                typemes := PacketRead8(p);
                {subtypemes := }PacketRead8(p);
                lenmes := PacketRead16(p);
                DoMsg(false,typemes,lenmes,PCharArray(@(p^.data[p^.cursor])),
                      hisUIN,UTC2LT(year,month,day,hour,minute));
                end;
         else M(Memo,'<??? SNAC 15,3; Type: $'+inttohex(MessageType,4));
         end;//case
    end;
     
    (****************************************************************)
    procedure TForm1.SNAC_4_7(p:PPack);  // INCOMING MESSAGES
    var i,cnt,T,MessageFormat,SubMode,SubMode2,Empty : word;
        {myUIN,}hisUIN : longint;
        SubType : array[0..3] of byte;
        MessageSubType : longint absolute SubType;
        tmp,tmp2,tmp3 : PPack;
        sTemp : string;
        dTemp : TByteArray;
        typemes,{subtypemes,}unk,modifier,lenmes : word;
     
        //for snac 4,0B  (ack for msg-2 type)
        d1,d2 : longint;
        ACK : TByteArray;
        ind : word;
     
    begin
         d1:=PacketRead32(p);
         d2:=PacketRead32(p);
         MessageFormat := swap(PacketRead16(p));
         sTemp := PacketReadB_String(p);
         ind:=0;
         PLONG(@(ACK[ind]))^:=d1; inc(ind,4);
         PLONG(@(ACK[ind]))^:=d2; inc(ind,4);
         PWORD(@(ACK[ind]))^:=swap(MessageFormat);inc(ind,2);
         PBYTE(@(ACK[ind]))^:=length(sTemp);inc(ind,1);
         MOVE(sTemp[1],ACK[ind],length(sTemp));inc(ind,length(sTemp));
         PWORD(@(ACK[ind]))^:=swap($0003);inc(ind,2);
     
         try hisUIN := strtoint(sTemp); except hisUIN:=0; end;
         M(Memo,'<From: '+sTemp);
         PacketRead16(p); //warning level? garbage of OSCAR protocol
         cnt := swap(PacketRead16(p)); // num of TLVs
         for i:=1 to cnt do
           if TLVReadStr(p,sTemp)=6 then begin { this is a HIS STATUS } end;
         case MessageFormat of
         $0001: begin
                //M(Memo,'<Message-format: 1 (SIMPLY message)');
                TLVReadStr(p,sTemp);
                // copy TLV(2) to TMP
                tmp := PacketNew;
                PacketAppend(tmp,@(sTemp[1]),length(sTemp));
                PacketGoto(tmp,0); // goto !!!!!
                // work it
                PacketRead16(tmp);
                PacketRead16(tmp);
                PacketRead8(tmp);
                PacketRead16(tmp);
                lenmes := swap(PacketRead16(tmp))-4;
                PacketRead32(tmp);
     
                PacketRead(tmp,@sTemp[1],lenmes);
                SetLength(sTemp,lenmes);
                DoSimpleMsg(hisUIN,sTemp);
     
                // delete TMP
                PacketDelete(tmp);
                end;
         $0002: begin
                //M(Memo,'<Message-format: 2 (ADVANCED message)');
                TLVReadStr(p,sTemp);
                // copy TLV(5) to TMP
                tmp := PacketNew;
                PacketAppend(tmp,@(sTemp[1]),length(sTemp));
                PacketGoto(tmp,0); // goto !!!!!
                // work it
                SubMode := swap(PacketRead16(tmp));
                PacketRead32(tmp);
                PacketRead32(tmp);
                PacketRead(tmp,@dTemp,16); //capability 16 bytes
                case SubMode of
                $0000: begin
                       //M(Memo,'SubMode: $0000 NORMAL');
                       {T := }TLVReadWord(tmp,SubMode2);// 0001-normal 0002-file reply
                       TLVReadWord(tmp,Empty);// TLV(F) empty
                       T := TLVReadStr(tmp,sTemp);
                       if T=$2711 then begin
     
                       MOVE(sTemp[1],ACK[ind],47);inc(ind,47);
                       PLONG(@(ACK[ind]))^:=0; inc(ind,4);
     
                       //******************************************
                       tmp2 := PacketNew;
                       PacketAppend(tmp2,@(sTemp[1]),length(sTemp));
                       PacketGoto(tmp2,0); // goto !!!!!
                       PacketRead(tmp2,@dTemp,26);
                       PacketRead8(tmp2);
                       PacketRead16(tmp2);
                       PacketRead16(tmp2);
                       PacketRead16(tmp2);
                       PacketRead(tmp2,@dTemp,12);
                       typemes := PacketRead8(tmp2);
                       {subtypemes := }PacketRead8(tmp2);
                       unk:=swap(PacketRead16(tmp2));//0200
                       modifier:=swap(PacketRead16(tmp2));//0100
                       M(Memo,'Unk: $'+inttohex(unk,4));
                       M(Memo,'Modifier: $'+inttohex(modifier,4));
     
                       lenmes := PacketRead16(tmp2);
                       DoMsg(true,typemes,lenmes,PCharArray(@(tmp2^.data[tmp2^.cursor])),
                             hisUIN,Now2DateTime);
                       // delete TMP2
                       PacketDelete(tmp2);
     
                       PWORD(@(ACK[ind]))^:=1; inc(ind,2);
                       PBYTE(@(ACK[ind]))^:=0; inc(ind,1);
                       PLONG(@(ACK[ind]))^:=0; inc(ind,4);
                       PLONG(@(ACK[ind]))^:=-1; inc(ind,4);
     
                       // Sending Ack
                       tmp3 := CreatePacket($2,SEQ);
                       SNACAppend(tmp3,$4,$0B);
                       PacketAppend(tmp3,@ACK[0],ind);
                       PacketSend(tmp3);
                       //******************************************
                       end;// IF
                       end;  //Submode:$0000
                $0001: M(Memo,'SubMode:$0001 ??? message canceled ???');
                $0002: M(Memo,'SubMode:$0002 FILE-ACK (not yet)');
                end;//case SubMode
                // delete TMP
                PacketDelete(tmp);
                end;
         $0004: begin
                //M(Memo,'<Message-format: 4 (url or contacts or auth-req or userAddedYou)');
                TLVReadStr(p,sTemp);
                // copy TLV(5) to TMP
                tmp := PacketNew;
                PacketAppend(tmp,@(sTemp[1]),length(sTemp));
                PacketGoto(tmp,0); // goto !!!!!
                // work it
                hisUIN := PacketRead32(tmp);
                typemes := PacketRead8(tmp);
                {subtypemes := }PacketRead8(tmp);
                lenmes := PacketRead16(tmp);
                DoMsg(true,typemes,lenmes,PCharArray(@(tmp^.data[tmp^.cursor])),
                      hisUIN,Now2DateTime);
                // delete TMP
                PacketDelete(tmp);
                end;
           else M(Memo,'<??? SNAC 4,7; Message-format: '+s(MessageFormat));
         end;//case MessageFormat
    end;
     
    (****************************************************************)
    procedure TForm1.DoMsg(on_off:boolean;typemes,lenmes:integer; data:PCharArray; r_uin:longint; DateTime:TDateTime);
    var i,pos1,pos2 : integer;
        sTemp,sLog,sNN,sDT : string;
        LTemp : array[1..6] of string;
    begin
         if (lenmes-1)=0 then exit;
         setlength(sTemp,lenmes-1);   // -1 for final string char #0
         move(data^,sTemp[1],lenmes-1);
     
         for i:=1 to 6 do LTemp[i]:='';
         if (typemes <> TYPE_MSG)and(typemes<>0) then begin
             if sTemp[length(sTemp)]<>#$FE then sTemp:=sTemp+#$FE;
             pos2:=0;
             for i:=1 to 6 do begin
               pos1 := pos2+1;
               pos2 := pos(#$FE,sTemp);
               if pos2 = 0 then break;
               LTemp[i] := copy(sTemp,pos1,pos2-pos1);
               sTemp[pos2] := #$FF;
             end;
         end;
         sNN := '';
         case on_off of
           true: sDT := '<-[A] ';
           false: sDT := '<-[O] ';
         end;
         sDT := sDT+DateTimeToStr(DateTime)+' ';
         case typemes of
         0,TYPE_MSG:
            FmtStr(sLog,sNN+' ['+s(r_uin)+'] "%s"',[sTemp]);
         TYPE_ADDED:
            FmtStr(sLog,'UIN:%d has added you to their contact list.'+
                        'Nick:%s  FName:%s LName:%s E-mail:%s',
                        [r_uin,LTemp[1],LTemp[2],LTemp[3],LTemp[4]]);
         TYPE_AUTH_REQ:
            FmtStr(sLog,'UIN:%d has requested your authorization.'+
                        'Nick:%s  FName:%s LName:%s E-mail:%s '#13#10'Reason:"%s"',
                        [r_uin,LTemp[1],LTemp[2],LTemp[3],LTemp[4],LTemp[6]]);
         TYPE_URL:
            FmtStr(sLog,'URL: UIN:%d, '#13#10'URL:%s, '#13#10'Description:"%s"',
                        [r_uin,LTemp[2],LTemp[1]]);
         TYPE_WEBPAGER:
            FmtStr(sLog,'WebPager: UIN:%d, Nick:%s, EMail:%s, '#13#10'"%s"',
                        [r_uin,LTemp[1],LTemp[4],LTemp[6]]);
         TYPE_EXPRESS:
            FmtStr(sLog,'MailExpress: UIN:%d, Nick:%s, EMail:%s, '#13#10'"%s"',
                        [r_uin,LTemp[1],LTemp[4],LTemp[6]]);
         else FmtStr(sLog,'Instant message type %d from UIN:%d, '#13#10'Message:"%s"',
                        [typemes,r_uin,sTemp]);
         end;//case
         sLog := sDT+sLog;
         M(Memo,sLog); LogMessage(sLog);
    end;
     
    (****************************************************************)
    procedure TForm1.DoSimpleMsg(r_uin:longint; Text:string);
    var sLog : string;
    begin
         sLog:= '<-[S] '+DateTimeToStr(Now)+' '+'['+s(r_uin)+'] "'+Text+'"';
         M(Memo,sLog);   LogMessage(sLog);
    end;
    (****************************************************************)
    procedure TForm1.SetStatus(Status:longint);
    var tmp : PPack;
    begin
           ICQStatus := Status;
           // Set Status Code
           tmp := CreatePacket(2,SEQ);
           SNACAppend(tmp,$1,$1E);
           TLVAppendDWord(tmp,6,ICQStatus);
           TLVAppendWord(tmp,8,$0000);
           // imitation TLV(C)
           PacketAppend32(tmp,dswap($000C0025)); // TLV(C)
           StrToIP(Get_my_IP,DIM_IP);
           PacketAppend(tmp,@DIM_IP,4); // IP address
           PacketAppend32(tmp,dswap(28000+random(1000)));// Port
           PacketAppend8(tmp,$04);
           PacketAppend16(tmp,swap($0007));
           PacketAppend16(tmp,swap($466B));
           PacketAppend16(tmp,swap($AE68));
           PacketAppend32(tmp,dswap($00000050));
           PacketAppend32(tmp,dswap($00000003));
           PacketAppend32(tmp,dswap(SecsSince1970));
           PacketAppend32(tmp,dswap(SecsSince1970));
           PacketAppend32(tmp,dswap(SecsSince1970));
           PacketAppend16(tmp,swap($0000));
           PacketSend(tmp);
           case ICQStatus of
             STATE_ONLINE:      StatusBtn.Caption := 'online';
             STATE_AWAY:        StatusBtn.Caption := 'away';
             STATE_DND:         StatusBtn.Caption := 'dnd';
             STATE_OCCUPIED:    StatusBtn.Caption := 'occupied';
             STATE_FREEFORCHAT: StatusBtn.Caption := 'freeforchat';
             STATE_N_A:         StatusBtn.Caption := 'na';
             STATE_INVISIBLE:   StatusBtn.Caption := 'invisible';
             else               StatusBtn.Caption := 'offline';
           end;
    end;
     
    (****************************************************************)
    procedure TForm1.StatusChange(Status:longint);
    var tmp : PPack;
    begin
         if(not OL)then begin
           Get_My_IP;
           if not OL then begin
             M(Memo,'OFF-line');
             exit;
           end;
         end;
         if (not CLI.Active) then icq_Login(Status)
         else if (not isLogged) then exit  // logging now ...
         else begin
           ICQStatus := Status;
           case ICQStatus of
           STATE_INVISIBLE: begin
               // Send Visible List
               tmp := CreatePacket(2,SEQ);
               SNACAppend(tmp,$9,$5);
               PacketSend(tmp);
               M(Memo,'>Send Visible List (0)');
             end;
           else begin
               // Send Invisible List
               tmp := CreatePacket(2,SEQ);
               SNACAppend(tmp,$9,$7);
               PacketSend(tmp);
               M(Memo,'>Send Invisible List (0)');
             end;
           end;//case
           // Set Status Code
           tmp := CreatePacket(2,SEQ);
           SNACAppend(tmp,$1,$1E);
           TLVAppendDWord(tmp,6,ICQStatus);
           PacketSend(tmp);
           case ICQStatus of
             STATE_ONLINE:      StatusBtn.Caption := 'online';
             STATE_AWAY:        StatusBtn.Caption := 'away';
             STATE_DND:         StatusBtn.Caption := 'dnd';
             STATE_OCCUPIED:    StatusBtn.Caption := 'occupied';
             STATE_FREEFORCHAT: StatusBtn.Caption := 'freeforchat';
             STATE_N_A:         StatusBtn.Caption := 'na';
             STATE_INVISIBLE:   StatusBtn.Caption := 'invisible';
             else               StatusBtn.Caption := 'offline';
           end;
         end;
    end;
     
    (****************************************************************)
    procedure TForm1.OnlineConnected1Click(Sender: TObject);
    begin
         StatusChange(STATE_ONLINE);
    end;
     
    (****************************************************************)
    procedure TForm1.Away1Click(Sender: TObject);
    begin
          StatusChange(STATE_AWAY);
    end;
     
    (****************************************************************)
    procedure TForm1.DNDDoNotDisturb1Click(Sender: TObject);
    begin
          StatusChange(STATE_DND);
    end;
     
    (****************************************************************)
    procedure TForm1.PrivacyInvisible1Click(Sender: TObject);
    begin
          StatusChange(STATE_INVISIBLE);
    end;
     
    (****************************************************************)
    procedure TForm1.OfflineDiscconnect1Click(Sender: TObject);
    begin
         ConnectMode(false);
    end;
     
    (****************************************************************)
    procedure TForm1.OccupiedUrgentMsgs1Click(Sender: TObject);
    begin
          StatusChange(STATE_OCCUPIED);
    end;
     
    (****************************************************************)
    procedure TForm1.FreeForChat1Click(Sender: TObject);
    begin
          StatusChange(STATE_FREEFORCHAT);
    end;
     
    (****************************************************************)
    procedure TForm1.NAExtendedAway1Click(Sender: TObject);
    begin
          StatusChange(STATE_N_A);
    end;
     
    (****************************************************************)
    procedure TForm1.icq_Login(Status : longint);
    begin
         randomize;
         SEQ := random($7FFF);
         Local_IP := Get_my_IP;
         StrToIP(Local_IP,DIM_IP);
         ICQStatus := status;
         if CLI.Active then CLI.Close;
         isAuth := true;
         isHDR := true;
         CLI.Address :='';
         CLI.Host := 'login.icq.com';
         CLI.Port := 5190;
         M(Memo,'>>>>>>>>>>  login.icq.com:5190 <<<<<<<<<<<');
         CLI.Open;
    end;
     
    (****************************************************************)
    procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
    begin
         OfflineDiscconnect1Click(self);
         CloseLogs;
    end;
     
    (****************************************************************)
    procedure TForm1.InitLogs;
    begin
         assignfile(mess,s(UIN)+'.mes');
         try  if FileExists(s(UIN)+'.mes') then append(mess)
              else rewrite(mess);
         M(Memo,DateTimeToStr(Now));
         except end;
         assignfile(log,s(UIN)+'.log');
         try if FileExists(s(UIN)+'.log') then append(log)
             else rewrite(log);
         except end;
    end;
     
    (****************************************************************)
    procedure TForm1.CloseLogs;
    begin
         try closefile(mess); except end;
         try closefile(log);  except end;
    end;
     
    (****************************************************************)
    procedure TForm1.LogMessage(s:string);
    begin
         try writeln(mess,s); except end;
    end;
     
    (****************************************************************)
    procedure TForm1.InitUser;
    var cfg : TIniFile;
    begin
         cfg := TIniFile.Create(ExtractFilePath(ParamStr(0))+'nICQ.ini');
         try
         UIN := cfg.ReadInteger('User','Uin',0);
         NICK := cfg.ReadString('User','Nick','');
         PASSWORD := cfg.ReadString('User','Password','');
         finally cfg.Free; end;
         Caption := NICK+' : '+s(UIN);
    end;
     
    (****************************************************************)
    procedure TForm1.ClearFIFO;
    var Find : PFLAP_Item;
    begin
       repeat
         Find := HeadFIFO;
         if HeadFIFO<>nil then begin
           if HeadFIFO^.Next<>nil then
             HeadFIFO := HeadFIFO^.Next
           else HeadFIFO := nil;
         end;
         if Find<>nil then begin
           FreeMem(Find^.DATA,swap(Find^.FLAP.Len));
           Dispose(Find);
         end;
       until Find=nil;
    end;
     
    (****************************************************************)
     
    procedure TForm1.StatusBtnClick(Sender: TObject);
    begin
         StatusMenu.Popup(Left+Width-20,Top+Height-50);
    end;
     
    end.
