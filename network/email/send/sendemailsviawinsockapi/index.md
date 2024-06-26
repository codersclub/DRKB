---
Title: Send e-mails via WinSock API
Author: TauxCanolf
Date: 01.01.2007
---


Send e-mails via WinSock API
=============================

Вариант 1:

Author: Melih SARICA (Non ZERO)

Date: 17.01.2004

Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>

    unit SMTP_Connections;
    // *********************************************************************
    //     Unit Name          : SMTP_Connections                           *
    //     Author             : Melih SARICA (Non ZERO)                    *
    //     Date               : 01/17/2004                                 *
    //**********************************************************************
     
    interface
     
    uses
      Classes, StdCtrls;
     
    const
      WinSock = 'wsock32.dll';
      Internet = 2;
      Stream  = 1;
      fIoNbRead = $4004667F;
      WinSMTP = $0001;
      LinuxSMTP = $0002;
     
    type
     
      TWSAData = packed record
        wVersion: Word;
        wHighVersion: Word;
        szDescription: array[0..256] of Char;
        szSystemStatus: array[0..128] of Char;
        iMaxSockets: Word;
        iMaxUdpDg: Word;
        lpVendorInfo: PChar;
      end;
      PHost = ^THost;
      THost = packed record
        Name: PChar;
        aliases: ^PChar;
        addrtype: Smallint;
        Length: Smallint;
        addr: ^Pointer;
      end;
     
      TSockAddr = packed record
        Family: Word;
        Port: Word;
        Addr: Longint;
        Zeros: array[0..7] of Byte;
      end;
     
     
    function WSAStartup(Version:word; 
                        Var Data:TwsaData):integer; stdcall; far; external winsock;
    function socket(Family,Kind,Protocol:integer):integer; stdcall; far; external winsock;
    function shutdown(Socket,How:Integer):integer; stdcall; far; external winsock;
    function closesocket(socket:Integer):integer; stdcall; far; external winsock;
    function WSACleanup:integer; stdcall; far; external winsock;
    function bind(Socket:Integer; Var SockAddr:TSockAddr; 
                  AddrLen:integer):integer; stdcall; far; external winsock;
    function listen(socket,flags:Integer):integer; stdcall; far; external winsock;
    function connect(socket:Integer; Var SockAddr:TSockAddr; 
                     AddrLen:integer):integer; stdcall; far; external winsock;
    function accept(socket:Integer; Var SockAddr:TSockAddr; 
                    Var AddrLen:Integer):integer; stdcall; far; external winsock;
    function WSAGetLastError:integer; stdcall; far; external winsock;
    function recv(socket:integer; data:pchar; datalen,
                  flags:integer):integer; stdcall; far; external winsock;
    function send(socket:integer; var data; datalen,
                  flags:integer):integer; stdcall; far; external winsock;
    function gethostbyname(HostName:PChar):PHost; stdcall; far; external winsock;
    function WSAIsBlocking:boolean; stdcall; far; external winsock;
    function WSACancelBlockingCall:integer; stdcall; far; external winsock;
    function ioctlsocket(socket:integer; cmd: Longint; 
                         var arg: longint): Integer; stdcall; far; external winsock;
    function gethostname(name:pchar; size:integer):integer; stdcall; far; external winsock;
     
    procedure _authSendMail(MailServer,uname,upass,mFrom,mFromName,mToName,
                            Subject:string;mto,mbody:TStringList);
    function ConnectServer(mhost:string;mport:integer):integer;
    function ConnectServerwin(mhost:string;mport:integer):integer;
    function DisConnectServer:integer;
    function Stat: string;
    function SendCommand(Command: String): string;
    function SendData(Command: String): string;
    function SendCommandWin(Command: String): string;
    function ReadCommand: string;
    function encryptB64(s:string):string;
     
    var
      mconnHandle: Integer;
      mFin, mFOut: Textfile;
      EofSock: Boolean;
      mactive: Boolean;
      mSMTPErrCode: Integer;
      mSMTPErrText: string;
      mMemo: TMemo;
     
    implementation
     
    uses
      SysUtils, Sockets, IdBaseComponent,
      IdCoder, IdCoder3to4, IdCoderMIME, IniFiles,Unit1;
     
    var
      mClient: TTcpClient;
     
    procedure _authSendMail(MailServer, uname, upass, mFrom, mFromName,
      mToName, Subject: string; mto, mbody: TStringList);
    var
      tmpstr: string;
      cnt: Integer;
      mstrlist: TStrings;
      RecipientCount: Integer;
    begin
      if ConnectServerWin(Mailserver, 25) = 250 then
      begin
        Sendcommandwin('AUTH LOGIN ');
        SendcommandWin(encryptB64(uname));
        SendcommandWin(encryptB64(upass));
        SendcommandWin('MAIL FROM: ' + mfrom);
        for cnt := 0 to mto.Count - 1 do
          SendcommandWin('RCPT TO: ' + mto[cnt]);
        Sendcommandwin('DATA');
        SendData('Subject: ' + Subject);
        SendData('From: "' + mFromName + '" <' + mfrom + '>');
        SendData('To: ' + mToName);
        SendData('Mime-Version: 1.0');
        SendData('Content-Type: multipart/related; boundary="Esales-Order";');
        SendData('     type="text/html"');
        SendData('');
        SendData('--Esales-Order');
        SendData('Content-Type: text/html;');
        SendData('        charset="iso-8859-9"');
        SendData('Content-Transfer-Encoding: QUOTED-PRINTABLE');
        SendData('');
        for cnt := 0 to mbody.Count - 1 do
          SendData(mbody[cnt]);
        Senddata('');
        SendData('--Esales-Order--');
        Senddata(' ');
        mSMTPErrText := SendCommand(crlf + '.' + crlf);
        try
          mSMTPErrCode := StrToInt(Copy(mSMTPErrText, 1, 3));
        except
        end;
        SendData('QUIT');
        DisConnectServer;
      end;
    end;
     
     
    function Stat: string;
    var
      s: string;
    begin
      s := ReadCommand;
      Result := s;
    end;
     
    function EchoCommand(Command: string): string;
    begin
      SendCommand(Command);
      Result := ReadCommand;
    end;
     
    function ReadCommand: string;
    var
      tmp: string;
    begin
      repeat
        ReadLn(mfin, tmp);
        if Assigned(mmemo) then
          mmemo.Lines.Add(tmp);
      until (Length(tmp) < 4) or (tmp[4] <> '-');
      Result := tmp
    end;
     
    function SendData(Command: string): string;
    begin
      Writeln(mfout, Command);
    end;
     
    function SendCommand(Command: string): string;
    begin
      Writeln(mfout, Command);
      Result := stat;
    end;
     
    function SendCommandWin(Command: string): string;
    begin
      Writeln(mfout, Command + #13);
      Result := stat;
    end;
     
    function FillBlank(Source: string; number: Integer): string;
    var
      a: Integer;
    begin
      Result := '';
      for a := Length(trim(Source)) to number do
        Result := Result + ' ';
    end;
     
    function IpToLong(ip: string): Longint;
    var
      x, i: Byte;
      ipx: array[0..3] of Byte;
      v: Integer;
    begin
      Result := 0;
      Longint(ipx) := 0;
      i := 0;
      for x := 1 to Length(ip) do
        if ip[x] = '.' then
        begin
          Inc(i);
          if i = 4 then Exit;
        end
      else
      begin
        if not (ip[x] in ['0'..'9']) then Exit;
        v := ipx[i] * 10 + Ord(ip[x]) - Ord('0');
        if v > 255 then Exit;
        ipx[i] := v;
      end;
      Result := Longint(ipx);
    end;
     
    function HostToLong(AHost: string): Longint;
    var
      Host: PHost;
    begin
      Result := IpToLong(AHost);
      if Result = 0 then
      begin
        Host := GetHostByName(PChar(AHost));
        if Host <> nil then Result := Longint(Host^.Addr^^);
      end;
    end;
     
    function LongToIp(Long: Longint): string;
    var
      ipx: array[0..3] of Byte;
      i: Byte;
    begin
      Longint(ipx) := long;
      Result       := '';
      for i := 0 to 3 do Result := Result + IntToStr(ipx[i]) + '.';
      SetLength(Result, Length(Result) - 1);
    end;
     
    procedure Disconnect(Socket: Integer);
    begin
      ShutDown(Socket, 1);
      CloseSocket(Socket);
    end;
     
    function CallServer(Server: string; Port: Word): Integer;
    var
      SockAddr: TSockAddr;
    begin
      Result := socket(Internet, Stream, 0);
      if Result = -1 then Exit;
      FillChar(SockAddr, SizeOf(SockAddr), 0);
      SockAddr.Family := Internet;
      SockAddr.Port := swap(Port);
      SockAddr.Addr := HostToLong(Server);
      if Connect(Result, SockAddr, SizeOf(SockAddr)) <> 0 then
      begin
        Disconnect(Result);
        Result := -1;
      end;
    end;
     
    function OutputSock(var F: TTextRec): Integer; far;
    begin
      if F.BufPos <> 0 then
      begin
        Send(F.Handle, F.BufPtr^, F.BufPos, 0);
        F.BufPos := 0;
      end;
      Result := 0;
    end;
     
    function InputSock(var F: TTextRec): Integer; far;
    var
      Size: Longint;
    begin
      F.BufEnd := 0;
      F.BufPos := 0;
      Result := 0;
      repeat
        if (IoctlSocket(F.Handle, fIoNbRead, Size) < 0) then
        begin
          EofSock := True;
          Exit;
        end;
      until (Size >= 0);
      F.BufEnd := Recv(F.Handle, F.BufPtr, F.BufSize, 0);
      EofSock  := (F.Bufend = 0);
    end;
     
     
    function CloseSock(var F: TTextRec): Integer; far;
    begin
      Disconnect(F.Handle);
      F.Handle := -1;
      Result   := 0;
    end;
     
    function OpenSock(var F: TTextRec): Integer; far;
    begin
      if F.Mode = fmInput then
      begin
        EofSock := False;
        F.BufPos := 0;
        F.BufEnd := 0;
        F.InOutFunc := @InputSock;
        F.FlushFunc := nil;
      end
      else
      begin
        F.Mode := fmOutput;
        F.InOutFunc := @OutputSock;
        F.FlushFunc := @OutputSock;
      end;
      F.CloseFunc := @CloseSock;
      Result := 0;
    end;
     
    procedure AssignCrtSock(Socket:integer; Var Input,Output:TextFile);
     begin
      with TTextRec(Input) do
      begin
        Handle := Socket;
        Mode := fmClosed;
        BufSize := SizeOf(Buffer);
        BufPtr := @Buffer;
        OpenFunc := @OpenSock;
      end;
      with TTextRec(Output) do
      begin
        Handle := Socket;
        Mode := fmClosed;
        BufSize := SizeOf(Buffer);
        BufPtr := @Buffer;
        OpenFunc := @OpenSock;
      end;
      Reset(Input);
      Rewrite(Output);
     end;
     
    function ConnectServer(mhost: string; mport: Integer): Integer;
    var
      tmp: string;
    begin
      mClient := TTcpClient.Create(nil);
      mClient.RemoteHost := mhost;
      mClient.RemotePort := IntToStr(mport);
      mClient.Connect;
      mconnhandle := callserver(mhost, mport);
      if (mconnHandle<>-1) then
      begin
        AssignCrtSock(mconnHandle, mFin, MFout);
        tmp := stat;
        tmp := SendCommand('HELO bellona.com.tr');
        if Copy(tmp, 1, 3) = '250' then
        begin
          Result := StrToInt(Copy(tmp, 1, 3));
        end;
      end;
    end;
     
    function ConnectServerWin(mhost: string; mport: Integer): Integer;
    var
      tmp: string;
    begin
      mClient := TTcpClient.Create(nil);
      mClient.RemoteHost := mhost;
      mClient.RemotePort := IntToStr(mport);
      mClient.Connect;
      mconnhandle := callserver(mhost, mport);
      if (mconnHandle<>-1) then
      begin
        AssignCrtSock(mconnHandle, mFin, MFout);
        tmp := stat;
        tmp := SendCommandWin('HELO bellona.com.tr');
        if Copy(tmp, 1, 3) = '250' then
        begin
          Result := StrToInt(Copy(tmp, 1, 3));
        end;
      end;
    end;
     
    function DisConnectServer: Integer;
    begin
      closesocket(mconnhandle);
      mClient.Disconnect;
      mclient.Free;
    end;
     
    function encryptB64(s: string): string;
    var
      hash1: TIdEncoderMIME;
      p: string;
    begin
      if s <> '' then
      begin
        hash1 := TIdEncoderMIME.Create(nil);
        p := hash1.Encode(s);
        hash1.Free;
      end;
      Result := p;
    end;
     
    end.
     
    {***************************************************}
    { How to use it}
    {***************************************************}
     
    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        Memo1: TMemo;
        procedure Button1Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    uses
      SMTP_Connections;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      mto, mbody: TStringList;
      MailServer, uname, upass, mFrom, mFromName,
      mToName, Subject: string;
    begin
      mMemo := Memo1; // to output server feedback
      //..........................
      MailServer := 'mail.xyz.net';
      uname := 'username';
      upass := 'password';
      mFrom :=  'user@xyz.net';
      mFromName := 'forename surname';
      mToName := '';
      Subject := 'Your Subject';
      //..........................
      mto := TStringList.Create;
      mbody := TStringList.Create;
      try
        mto.Add('anybody@xyz.net');
        mbody.Add('Test Mail');
        //Send Mail.................
        _authSendMail(MailServer, uname, upass, mFrom, mFromName, 
            mToName, Subject, mto, mbody);
        //..........................
      finally
        mto.Free;
        mbody.Free;
      end;
    end;
     
    end.

------------------------------------------------------------------------

Вариант 2:

Author: TauxCanolf

Source: <https://forum.sources.ru>

    function _RegReadString(_hkey:longint;
                            const ValueName:string; 
                            var Value:string;
                            const SubKey:string):Boolean;
    var Key:HKey; BufLen,Typed:DWord;
    begin
     Result:=False; Value:=EmptyStr;
     if RegOpenKeyEx(_hkey,pchar(subkey),0,KEY_READ,Key)=ERROR_SUCCESS then
      begin
       Typed:=REG_SZ;
       BufLen:=$FFFF; SetLength(Value,BufLen);
       if RegQueryValueEx(Key,PChar(ValueName),
         nil,@Typed,@Value[1],@BufLen)=ERROR_SUCCESS then
        begin
         if BufLen>0 then SetLength(Value,BufLen-1) else Value:=EmptyStr;
         Result:=True;
        end;
       RegCloseKey(Key);
      end;
    end;
     
    function _HostToIP(Name: string):string;
    var  
     wsdata : TWSAData;
      hostName : array [0..255] of char;   
     hostEnt : PHostEnt;   
     addr : PChar;   
    begin  
      WSAStartup ($0101, wsdata);   
      gethostname (hostName, sizeof (hostName));   
      StrPCopy(hostName, Name);   
      hostEnt := gethostbyname (hostName);   
      if Assigned (hostEnt) then   
        if Assigned (hostEnt^.h_addr_list) then   
        begin   
          addr := hostEnt^.h_addr_list^;   
          if Assigned (addr) then
          begin   
            Result := Format ('%d.%d.%d.%d', [byte (addr [0]),   
                              byte (addr [1]),
                              byte (addr [2]),
                              byte (addr [3])]);
          end;
        end;   
      WSACleanup;   
    end;
     
    function GetSMTPServer:string;
    var s,j:string;
    begin
      result := '';
      _regreadstring(hkey_current_user,'Default Mail Account',s,
              'Software\Microsoft\Internet Account Manager');
      if s = '' then exit;
      _regreadstring(hkey_current_user,'SMTP Server',j,
              'Software\Microsoft\Internet Account Manager\Accounts\' + s);
      result := j;
    end;
     
    procedure SendStr(Sock:cardinal;str: String);
    var
      I: Integer;
    begin
      for I:=1 to Length(str) do
      if send(sock,str[I],1,0)=SOCKET_ERROR then exit;
    end;
     
    procedure ConnectAndSend(from,_to,st:string);
    var
      wsadata:  TWSADATA;
      sin: TSockAddrIn;
      sock: TSocket;
      MySmtp : String;
      iaddr: Integer;
      buf: array[0..255] of char;
    begin
      MySmtp := _HostToIP(getsmtpserver);
      WSAStartUp(257, wsadata);
      sock:=socket(AF_INET,SOCK_STREAM,IPPROTO_IP);
      sin.sin_family := AF_INET;
      htons(25);
      sin.sin_port := htons(25);
      iaddr:=inet_addr(PChar(MySmtp));
      sin.sin_addr.S_addr:=iaddr;
      connect(sock,sin,sizeof(sin));
      recv(sock,buf,sizeof(buf),0);
      sendstr(sock,'HELO google.com'+#13#10);
      recv(sock,buf,sizeof(buf),0);
      sendstr(sock,'MAIL FROM: '+from+#13#10);
      recv(sock,buf,sizeof(buf),0);
      sendstr(sock,'RCPT TO: '+_to+#13#10);
      recv(sock,buf,sizeof(buf),0);
      sendstr(sock,'DATA'+#13#10);
      recv(sock,buf,sizeof(buf),0);
      sendstr(sock,st);
      sendstr(sock,#13#10'.'#13#10);
      recv(sock,buf,sizeof(buf),0);
      sendstr(sock,'QUIT'#13#10);
      recv(sock,buf,sizeof(buf),0);
      closesocket(sock);
    end;

