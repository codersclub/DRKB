---
Title: Как узнать размеры шрифтов в Windows?
Date: 01.01.2007
---

Как узнать размеры шрифтов в Windows?
=====================================

Вариант 1:

Author: Song

Source: Vingrad.ru <https://forum.vingrad.ru>

    GetTextMetrics()


------------------------------------------------------------------------

Вариант 2:

Source: <https://forum.sources.ru>

> Как определить, какой шрифт установлен в системе, большой или маленький

Следующуя функция возвращает true, если маленькие шрифты установлены в
системе. Так же можно заменить строку

    Result := (GetDeviceCaps(DC, logpixelsx) = 96);

на
    Result := (GetDeviceCaps(DC, logpixelsx) = 120);

чтобы определять - установлены ли в системе крупные шрифты.

    Function UsesSmallFonts: boolean; 
    var 
      DC: HDC; 
    begin 
      DC := GetDC(0); 
      Result := (GetDeviceCaps(DC, logpixelsx) = 96); 
      ReleaseDC(0, DC); 
    end;

