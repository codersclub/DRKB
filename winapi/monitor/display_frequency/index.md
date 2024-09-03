---
Title: Как узнать частоту обновления монитора?
Author: p0s0l
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как узнать частоту обновления монитора?
=======================================

    function GetDisplayFrequency: Integer; 
     
    var 
     DeviceMode: TDeviceMode; 
     
    begin 
     EnumDisplaySettings(nil, Cardinal(-1), DeviceMode); 
     Result := DeviceMode.dmDisplayFrequency; 
    end;

