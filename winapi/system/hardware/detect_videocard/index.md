---
Title: Определение видеокарты
Author: Gua, gua@ukr.net
Date: 18.07.2002
---

Определение видеокарты
======================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Определение видеокарты
     
    Зависимости: Windows
    Автор:       Gua, gua@ukr.net, ICQ:141585495, Simferopol
    Copyright:   Gua
    Дата:        18 июля 2002 г.
    ********************************************** }
     
    function GetDisplayDevice: string;
    var
      lpDisplayDevice: TDisplayDevice;
    begin
      lpDisplayDevice.cb := sizeof(lpDisplayDevice);
      EnumDisplayDevices(nil, 0, lpDisplayDevice, 0);
      Result:=lpDisplayDevice.DeviceString;
    end;
