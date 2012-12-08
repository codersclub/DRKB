---
Title: Как узнать частоту обновления монитора?
Author: p0s0l
Date: 01.01.2007
---


Как узнать частоту обновления монитора?
=======================================

::: {.date}
01.01.2007
:::

    function GetDisplayFrequency: Integer; 

     
    var 
     DeviceMode: TDeviceMode; 
     
    begin 
     EnumDisplaySettings(nil, Cardinal(-1), DeviceMode); 
     Result := DeviceMode.dmDisplayFrequency; 
    end;

Автор: p0s0l

Взято с Vingrad.ru <https://forum.vingrad.ru>
