---
Title: Как определить цвет произвольной точки экрана?
Author: Baa
Date: 01.01.2007
---


Как определить цвет произвольной точки экрана?
==============================================

Вариант 1:

Author: Baa

Source: Vingrad.ru <https://forum.vingrad.ru>

    var
    DC: HDC;
    Color: Cardinal;
    begin
    DC := CreateDC ('MONITOR', nil, nil, nil);
    Color := GetPixel(DC, 300, 300);
    DeleteDC(DC);
    end;

------------------------------------------------------------------------

Вариант 2:

Author: Mikel

Source: Vingrad.ru <https://forum.vingrad.ru>

    var
    DC: HDC;
    Color: Cardinal;
    begin
    DC :=GetDC(0);
    Color := GetPixel(DC, 300, 300);
    ReleaseDC(0,DC);
    end;

