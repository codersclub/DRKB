---
Title: Как послать широковещательный UDP-пакет?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как послать широковещательный UDP-пакет?
========================================

    procedure TMainForm.FormCreate(Sender: TObject); 
    var Init:TWSAData; 
        SockOpt:BOOL; 
        Sock:TSocket; 
        Target:TSockAddrIn; 
    begin 
      WSAStartup($101,Init); 
      Sock:=Socket(PF_INET,SOCK_DGRAM,IPPROTO_UDP); 
      SockOpt:=TRUE; 
      SetSockOpt(Sock,SOL_SOCKET,SO_BROADCAST,PChar(@SockOpt),SizeOf(SockOpt)) ; 
      Target.sin_port:=htons(8167);//номер порта 
      Target.sin_addr.S_addr:=INADDR_BROADCAST; 
      Target.sa_family:=AF_INET; 
      SendTo(Sock,Data,DataBytes,0,Target,SizeOf(Target)); 
      WSACleanup; 
    end;

