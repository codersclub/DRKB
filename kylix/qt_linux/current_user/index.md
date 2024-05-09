---
Title: Как получить имя текущего пользователя?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как получить имя текущего пользователя?
=======================================

    function GetCurrentUser: string; 
    var 
      pwrec: PPasswordRecord; 
    begin 
      pwrec := getpwuid(getuid); 
      Result := pwrec.pw_name; 
    end; 

