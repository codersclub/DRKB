---
Title: Как определить цвет произвольной точки экрана?
Author: Baa
Date: 01.01.2007
---


Как определить цвет произвольной точки экрана?
==============================================

::: {.date}
01.01.2007
:::

    var
    DC: HDC;
    Color: Cardinal;
    begin
    DC := CreateDC ('MONITOR', nil, nil, nil);
    Color := GetPixel(DC, 300, 300);
    DeleteDC(DC);
    end;

Автор: Baa

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

    var
    DC: HDC;
    Color: Cardinal;
    begin
    DC :=GetDC(0);
    Color := GetPixel(DC, 300, 300);
    ReleaseDC(0,DC);
    end;

Автор: Mikel

Взято с Vingrad.ru <https://forum.vingrad.ru>
