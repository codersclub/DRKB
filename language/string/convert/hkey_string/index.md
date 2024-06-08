---
Title: HKey -> String
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


HKey -> String
==============

    const
      HKEYNames: array[0..6] of string =
        ('HKEY_CLASSES_ROOT', 
         'HKEY_CURRENT_USER', 
         'HKEY_LOCAL_MACHINE',      
         'HKEY_USERS',
         'HKEY_PERFORMANCE_DATA', 
         'HKEY_CURRENT_CONFIG', 
         'HKEY_DYN_DATA');
     
    function HKEYToStr(const Key: HKEY): string;
    begin
      if (key < HKEY_CLASSES_ROOT) or (key > HKEY_CLASSES_ROOT+6) then
        Result := ''
      else
        Result := HKEYNames[key - HKEY_CLASSES_ROOT];
    end;

