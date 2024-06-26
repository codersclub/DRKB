---
Title: Посылка Raw IP-пакетов
Author: Erwin Molendijk
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Посылка Raw IP-пакетов
======================

Используя данный исходник можно конструировать собственные пакеты
содержащие внутри всё, что угодно. Можно самостоятельно указывать в
пакете IP-адрес получателя и отправителя, порт назначения и т.д. Если Вы
не знаете, что это такое, то лучше не эксперементировать. Единственный
недостаток, то, что скорее всего данный пример будет работать только в
Windows 2000. Так же исходник позволяет произвести SYN flood и IP
spoofing.

Необходимо зайти в систему под Администратором.

Совместимость: Delphi 5.x (или выше)

    { 
    Raw Packet Sender 
    using: Delphi + Winsock 2 
     
    Copyright (c) 2000 by E.J.Molendijk (xes@dds.nl) 
     
    ---------------------------------------------------------------------- 
    Перед использованием измените значения SrcIP+SrcPort+ 
    DestIP+DestPort на нужные! 
    ---------------------------------------------------------------------- 
     
    } 
    unit main; 
     
    interface 
     
    uses 
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, 
      StdCtrls, OleCtrls, Registry; 
     
    Const 
      SrcIP       = '123.123.123.1'; 
      SrcPort     = 1234; 
      DestIP      = '123.123.123.2'; 
      DestPort    = 4321; 
     
      Max_Message = 4068; 
      Max_Packet  = 4096; 
     
    type 
     
      TPacketBuffer = Array[0..Max_Packet-1] of byte; 
     
      TForm1 = class(TForm) 
        Button1: TButton; 
        Memo1: TMemo; 
        procedure Button1Click(Sender: TObject); 
      private 
        { Private declarations } 
      public 
        { Public declarations } 
        procedure SendIt; 
      end; 
     
    // Заголовок IP пакета
    type 
      T_IP_Header = record 
        ip_verlen       : Byte; 
        ip_tos          : Byte; 
        ip_totallength  : Word; 
        ip_id            : Word; 
        ip_offset       : Word; 
        ip_ttl          : Byte; 
        ip_protocol     : Byte; 
        ip_checksum     : Word; 
        ip_srcaddr      : LongWord; 
        ip_destaddr     : LongWord; 
      end; 
     
    // Заголовок UDP пакета 
    Type 
      T_UDP_Header = record 
        src_portno    : Word; 
        dst_portno    : Word; 
        udp_length    : Word; 
        udp_checksum  : Word; 
      end; 
     
    // Некоторые объявления типов для Winsock 2 
      u_char  = Char; 
      u_short = Word; 
      u_int   = Integer; 
      u_long  = Longint; 
     
      SunB = packed record 
        s_b1, s_b2, s_b3, s_b4: u_char; 
      end; 
      SunW = packed record 
        s_w1, s_w2: u_short; 
      end; 
      in_addr = record 
        case integer of 
          0: (S_un_b: SunB); 
          1: (S_un_w: SunW); 
          2: (S_addr: u_long); 
      end; 
      TInAddr = in_addr; 
      Sockaddr_in = record 
        case Integer of 
          0: (sin_family: u_short; 
              sin_port: u_short; 
              sin_addr: TInAddr; 
              sin_zero: array[0..7] of Char); 
          1: (sa_family: u_short; 
              sa_data: array[0..13] of Char) 
      end; 
      TSockAddr = Sockaddr_in; 
      TSocket = u_int; 
     
    const 
      WSADESCRIPTION_LEN     =   256; 
      WSASYS_STATUS_LEN      =   128; 
     
    type 
      PWSAData = ^TWSAData; 
      WSAData = record // !!! also WSDATA 
        wVersion: Word; 
        wHighVersion: Word; 
        szDescription: array[0..WSADESCRIPTION_LEN] of Char; 
        szSystemStatus: array[0..WSASYS_STATUS_LEN] of Char; 
        iMaxSockets: Word; 
        iMaxUdpDg: Word; 
        lpVendorInfo: PChar; 
      end; 
      TWSAData = WSAData; 
     
    // Определяем необходимые функции winsock 2 
    function closesocket(s: TSocket): Integer; stdcall; 
    function socket(af, Struct, protocol: Integer): TSocket; stdcall; 
    function sendto(s: TSocket; var Buf; len, flags: Integer; var addrto: TSockAddr; 
      tolen: Integer): Integer; stdcall;{} 
    function setsockopt(s: TSocket; level, optname: Integer; optval: PChar; 
      optlen: Integer): Integer; stdcall; 
    function inet_addr(cp: PChar): u_long; stdcall; {PInAddr;}  { TInAddr } 
    function htons(hostshort: u_short): u_short; stdcall; 
    function WSAGetLastError: Integer; stdcall; 
    function WSAStartup(wVersionRequired: word; var WSData: TWSAData): Integer; stdcall; 
    function WSACleanup: Integer; stdcall; 
     
    const 
      AF_INET         = 2;                // internetwork: UDP, TCP, etc. 
     
      IP_HDRINCL      = 2;                // включаем заголовок IP пакета 
     
      SOCK_RAW        = 3;                // интерфейс raw-протокола 
     
      IPPROTO_IP      = 0;                // dummy for IP 
      IPPROTO_TCP     = 6;                // tcp 
      IPPROTO_UDP     = 17;               // user datagram protocol 
      IPPROTO_RAW     = 255;              // raw IP пакет 
     
      INVALID_SOCKET = TSocket(NOT(0)); 
      SOCKET_ERROR                  = -1; 
     
    var 
      Form1: TForm1; 
     
    implementation 
     
    // Импортируем функции Winsock 2 
    const WinSocket = 'WS2_32.DLL'; 
     
    function closesocket;       external    winsocket name 'closesocket'; 
    function socket;            external    winsocket name 'socket'; 
    function sendto;            external    winsocket name 'sendto'; 
    function setsockopt;        external    winsocket name 'setsockopt'; 
    function inet_addr;         external    winsocket name 'inet_addr'; 
    function htons;             external    winsocket name 'htons'; 
    function WSAGetLastError;   external    winsocket name 'WSAGetLastError'; 
    function WSAStartup;        external    winsocket name 'WSAStartup'; 
    function WSACleanup;        external    winsocket name 'WSACleanup'; 
     
     
    {$R *.DFM} 
     
    // 
    // Function: checksum 
    // 
    // Description: 
    //    This function calculates the 16-bit one's complement sum 
    //    for the supplied buffer 
    // 
    function CheckSum(Var Buffer; Size : integer) : Word; 
    type 
      TWordArray = Array[0..1] of Word; 
    var 
      ChkSum : LongWord; 
      i      : Integer; 
    begin 
      ChkSum := 0; 
      i := 0; 
      While Size > 1 do begin 
        ChkSum := ChkSum + TWordArray(Buffer)[i]; 
        inc(i); 
        Size := Size - SizeOf(Word); 
      end; 
     
      if Size=1 then ChkSum := ChkSum + Byte(TWordArray(Buffer)[i]); 
     
      ChkSum := (ChkSum shr 16) + (ChkSum and $FFFF); 
      ChkSum := ChkSum + (Chksum shr 16); 
     
      Result := Word(ChkSum); 
    end; 
     
     
    procedure BuildHeaders( 
      FromIP      : String; 
      iFromPort   : Word; 
      ToIP        : String; 
      iToPort     : Word; 
      StrMessage  : String; 
      Var Buf         : TPacketBuffer; 
      Var remote      : TSockAddr; 
      Var iTotalSize  : Word 
    ); 
    Var 
      dwFromIP    : LongWord; 
      dwToIP      : LongWord; 
     
      iIPVersion  : Word; 
      iIPSize     : Word; 
      ipHdr       : T_IP_Header; 
      udpHdr      : T_UDP_Header; 
     
      iUdpSize    : Word; 
      iUdpChecksumSize : Word; 
      cksum       : Word; 
     
      Ptr         : ^Byte; 
     
      procedure IncPtr(Value : Integer); 
      begin 
        ptr := pointer(integer(ptr) + Value); 
      end; 
     
    begin 
       // преобразуем ip адреса 
     
       dwFromIP    := inet_Addr(PChar(FromIP)); 
       dwToIP      := inet_Addr(PChar(ToIP)); 
     
        // Инициализируем заголовок IP пакета 
        // 
        iTotalSize := sizeof(ipHdr) + sizeof(udpHdr) + length(strMessage); 
     
        iIPVersion := 4; 
        iIPSize := sizeof(ipHdr) div sizeof(LongWord); 
        // 
        // IP version goes in the high order 4 bits of ip_verlen. The 
        // IP header length (in 32-bit words) goes in the lower 4 bits. 
        // 
        ipHdr.ip_verlen := (iIPVersion shl 4) or iIPSize; 
        ipHdr.ip_tos := 0;                         // IP type of service 
        ipHdr.ip_totallength := htons(iTotalSize); // Total packet len 
        ipHdr.ip_id := 0;                 // Unique identifier: set to 0 
        ipHdr.ip_offset := 0;             // Fragment offset field 
        ipHdr.ip_ttl := 128;              // время жизни пакета 
        ipHdr.ip_protocol := $11;         // Protocol(UDP) 
        ipHdr.ip_checksum := 0 ;          // IP checksum 
        ipHdr.ip_srcaddr := dwFromIP;     // Source address 
        ipHdr.ip_destaddr := dwToIP;      // Destination address 
        // 
        // Инициализируем заголовок UDP пакета 
        // 
        iUdpSize := sizeof(udpHdr) + length(strMessage); 
     
        udpHdr.src_portno := htons(iFromPort) ; 
        udpHdr.dst_portno := htons(iToPort) ; 
        udpHdr.udp_length := htons(iUdpSize) ; 
        udpHdr.udp_checksum := 0 ; 
        // 
        // Build the UDP pseudo-header for calculating the UDP checksum. 
        // The pseudo-header consists of the 32-bit source IP address, 
        // the 32-bit destination IP address, a zero byte, the 8-bit 
        // IP protocol field, the 16-bit UDP length, and the UDP 
        // header itself along with its data (padded with a 0 if 
        // the data is odd length). 
        // 
        iUdpChecksumSize := 0; 
     
        ptr := @buf[0]; 
        FillChar(Buf, SizeOf(Buf), 0); 
     
        Move(ipHdr.ip_srcaddr, ptr^, SizeOf(ipHdr.ip_srcaddr)); 
        IncPtr(SizeOf(ipHdr.ip_srcaddr)); 
     
        iUdpChecksumSize := iUdpChecksumSize + sizeof(ipHdr.ip_srcaddr); 
     
        Move(ipHdr.ip_destaddr, ptr^, SizeOf(ipHdr.ip_destaddr)); 
        IncPtr(SizeOf(ipHdr.ip_destaddr)); 
     
        iUdpChecksumSize := iUdpChecksumSize + sizeof(ipHdr.ip_destaddr); 
     
        IncPtr(1); 
     
        Inc(iUdpChecksumSize); 
     
        Move(ipHdr.ip_protocol, ptr^, sizeof(ipHdr.ip_protocol)); 
        IncPtr(sizeof(ipHdr.ip_protocol)); 
        iUdpChecksumSize := iUdpChecksumSize + sizeof(ipHdr.ip_protocol); 
     
        Move(udpHdr.udp_length, ptr^, sizeof(udpHdr.udp_length)); 
        IncPtr(sizeof(udpHdr.udp_length)); 
        iUdpChecksumSize := iUdpChecksumSize + sizeof(udpHdr.udp_length); 
     
        move(udpHdr, ptr^, sizeof(udpHdr)); 
        IncPtr(sizeof(udpHdr)); 
        iUdpChecksumSize := iUdpCheckSumSize + sizeof(udpHdr); 
     
        Move(StrMessage[1], ptr^, Length(strMessage)); 
        IncPtr(Length(StrMessage)); 
     
        iUdpChecksumSize := iUdpChecksumSize + length(strMessage); 
     
        cksum := checksum(buf, iUdpChecksumSize); 
        udpHdr.udp_checksum := cksum; 
     
        // 
        // Now assemble the IP and UDP headers along with the data 
        //  so we can send it 
        // 
        FillChar(Buf, SizeOf(Buf), 0); 
        Ptr := @Buf[0]; 
     
        Move(ipHdr, ptr^, SizeOf(ipHdr));      IncPtr(SizeOf(ipHdr)); 
        Move(udpHdr, ptr^, SizeOf(udpHdr));    IncPtr(SizeOf(udpHdr)); 
        Move(StrMessage[1], ptr^, length(StrMessage)); 
     
        // Apparently, this SOCKADDR_IN structure makes no difference. 
        // Whatever we put as the destination IP addr in the IP header 
        // is what goes. Specifying a different destination in remote 
        // will be ignored. 
        // 
        remote.sin_family := AF_INET; 
        remote.sin_port := htons(iToPort); 
        remote.sin_addr.s_addr := dwToIP; 
    end; 
     
    procedure TForm1.SendIt; 
    Var 
      sh          : TSocket; 
      bOpt        : Integer; 
      ret         : Integer; 
      Buf         : TPacketBuffer; 
      Remote      : TSockAddr; 
      Local       : TSockAddr; 
      iTotalSize  : Word; 
      wsdata      : TWSAdata; 
     
    begin 
      // Startup Winsock 2 
      ret := WSAStartup($0002, wsdata); 
      if ret<>0 then begin 
        memo1.lines.add('WSA Startup failed.'); 
        exit; 
      end; 
      with memo1.lines do begin 
        add('WSA Startup:'); 
        add('Desc.:  '+wsData.szDescription); 
        add('Status: '+wsData.szSystemStatus); 
      end; 
     
      try 
        // Создаём сокет 
        sh := Socket(AF_INET, SOCK_RAW, IPPROTO_UDP); 
        if (sh = INVALID_SOCKET) then begin 
          memo1.lines.add('Socket() failed: '+IntToStr(WSAGetLastError)); 
          exit; 
        end; 
        Memo1.lines.add('Socket Handle = '+IntToStr(sh)); 
     
        // Option: Header Include 
        bOpt := 1; 
        ret := SetSockOpt(sh, IPPROTO_IP, IP_HDRINCL, @bOpt, SizeOf(bOpt)); 
        if ret = SOCKET_ERROR then begin 
          Memo1.lines.add('setsockopt(IP_HDRINCL) failed: '+IntToStr(WSAGetLastError)); 
          exit; 
        end; 
     
        // строим пакет 
        BuildHeaders( SrcIP,  SrcPort, 
                      DestIP, DestPort, 
                      'THIS IS A TEST PACKET', 
                      Buf, Remote, iTotalSize ); 
     
        // Отправляем пакет 
        ret := SendTo(sh, buf, iTotalSize, 0, Remote, SizeOf(Remote)); 
        if ret = SOCKET_ERROR then 
          Memo1.Lines.Add('sendto() failed: '+IntToStr(WSAGetLastError)) 
         else 
          Memo1.Lines.Add('send '+IntToStr(ret)+' bytes.'); 
     
        // Закрываем сокет 
        CloseSocket(sh); 
      finally 
        // Закрываем Winsock 2 
        WSACleanup; 
      end; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      SendIt; 
    end; 
     
    end.

