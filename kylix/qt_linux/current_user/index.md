---
Title: Как получить имя текущего пользователя?
Date: 01.01.2007
---


Как получить имя текущего пользователя?
=======================================

::: {.date}
01.01.2007
:::

    function GetCurrentUser: string; 
    var 
      pwrec: PPasswordRecord; 
    begin 
      pwrec := getpwuid(getuid); 
      Result := pwrec.pw_name; 
    end; 

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
