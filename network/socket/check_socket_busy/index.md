---
Title: Определить, занят ли порт сокета
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Определить, занят ли порт сокета
================================

    var SockAddrIn : TSockAddrIn;
        FSocket    : TSocket;
     
      ...
     
      If  bind(FSocket, SockAddrIn, SizeOf(SockAddrIn)) <> 0 Then
      begin
        обрабатываем WSAGetLastError
      end;

