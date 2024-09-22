---
Title: Получение имени конфигурации HardWare profile
Date: 01.01.2007
---

Получение имени конфигурации HardWare profile
=============================================

    function GettingHWProfileName: string;  //Win95OSR2 or later and NT4.0 or later
    var
      pInfo:  tagHW_PROFILE_INFOA;
    begin
      GetCurrentHwProfile(pInfo);
      Result:=pInfo.szHwProfileName;
    end;
