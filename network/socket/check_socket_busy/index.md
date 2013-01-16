---
Title: Определить, занят ли порт сокета
Date: 01.01.2007
---


Определить, занят ли порт сокета
================================

::: {.date}
01.01.2007
:::

    var SockAddrIn : TSockAddrIn;
        FSocket    : TSocket;
     
      ...
     
      If  bind(FSocket, SockAddrIn, SizeOf(SockAddrIn)) <> 0 Then
      begin
        обрабатываем WSAGetLastError
      end;

Взято с <https://delphiworld.narod.ru>
