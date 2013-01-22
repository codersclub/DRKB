---
Title: PWideChar -> String
Date: 01.01.2007
---


PWideChar -> String
===================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Конвертация PWideChar в String
     
    Автор:       Gua, gua@ukr.net, ICQ:141585495, Simferopol
    Copyright:   Andre .v.d. Merwe
    Дата:        18 июля 2002 г.
    ********************************************** }
     
    function PWideToString(pw : PWideChar) : string;
    var
      p : PChar;
      iLen : integer;
    begin
       iLen := lstrlenw( pw ) + 1;
       GetMem( p, iLen );
     
       WideCharToMultiByte( CP_ACP, 0, pw, iLen, p, iLen * 2, nil, nil );
     
       Result := p;
       FreeMem( p, iLen );
    end;
