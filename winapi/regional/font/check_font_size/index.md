---
Title: Как узнать размеры шрифтов в Windows?
Author: Song
Date: 01.01.2007
---

Как узнать размеры шрифтов в Windows?
=====================================

::: {.date}
01.01.2007
:::

GetTextMetrics()

Автор: Song

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

Как определить, какой шрифт установлен в системе, большой или маленький

Следующуя функция возвращает true, если маленькие шрифты установлены в
системе. Так же можно заменить строку \'Result := (GetDeviceCaps(DC,
logpixelsx) = 96);\' на \'Result := (GetDeviceCaps(DC, logpixelsx) =
120);\' чтобы определять - установлены ли в системе крупные шрифты.

    Function UsesSmallFonts: boolean; 
    var 
    DC: HDC; 
    begin 
    DC := GetDC(0); 
    Result := (GetDeviceCaps(DC, logpixelsx) = 96); 
    ReleaseDC(0, DC); 
    end;

Взято из <https://forum.sources.ru>
