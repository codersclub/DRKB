---
Title: String \> HKEY
Date: 01.01.2007
---


String \> HKEY
==============

::: {.date}
01.01.2007
:::

    const
      HKEYNames: array[0..6] of string =
        ('HKEY_CLASSES_ROOT', 
         'HKEY_CURRENT_USER', 
         'HKEY_LOCAL_MACHINE',      
         'HKEY_USERS',
         'HKEY_PERFORMANCE_DATA', 
         'HKEY_CURRENT_CONFIG', 
         'HKEY_DYN_DATA');
     
    function StrToHKEY(const KEY: string): HKEY;
    var
      i: Byte;
    begin
      Result := $0;
      for i := Low(HKEYNames) to High(HKEYNames) do
      begin
        if SameText(HKEYNames[i], KEY) then
          Result := HKEY_CLASSES_ROOT + i;
      end;
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
