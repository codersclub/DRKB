---
Title: Как узнать IP-адрес?
Date: 01.01.2007
Source: <https://blackman.wp-club.net/>
---


Как узнать IP-адрес?
====================

Можно посмотреть в реестре:

HKEY\_LOCAL\_MACHINE\\System\\CurrentControlSet\\Services\\Class\\NetTrans\\  
(для 98-винды)

Ищем параметр "IPAddress".

Программно можно определить следующим образом:

    var
      WSAData: TWSAData;
      p: PHostEnt;
      Name: array[0..$FF] of Char;
    begin
      WSAStartup($0101, WSAData);
      GetHostName(name, $FF);
      p := GetHostByName(Name);
      showmessage(inet_ntoa(PInAddr(p.h_addr_list^)^));
      WSACleanup;
    end;

