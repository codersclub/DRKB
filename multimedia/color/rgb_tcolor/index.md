---
Title: Как конвертировать RGB в TColor?
Author: Vit
Date: 01.01.2007
---


Как конвертировать RGB в TColor?
================================

Вариант 1:

    function RGBToColor(R,G,B:Byte): TColor; 
    begin 
           Result:=B Shl 16 Or
           G Shl 8 Or
           R;
    end; 

Source: <https://forum.sources.ru>

------------------------------------------------------------------------

Вариант 2:

> Как разбить цвет на составляющие и наоборот?

RGB -\> TColor:

    RGB(r,g,b:byte):tcolor

TColor -\> RGB:

    GetRValue(color:tcolor)
    GetGValue(color:tcolor)
    GetBValue(color:tcolor)

Author: Vit

Source: Vingrad.ru <https://forum.vingrad.ru>
