Как конвертировать RGB в TColor?
================================

::: {.date}
01.01.2007
:::

    function RGBToColor(R,G,B:Byte): TColor; 
    begin 
           Result:=B Shl 16 Or
           G Shl 8 Or
           R;
    end; 

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------

RGB -\> TColor

RGB(r,g,b:byte):tcolor

TColor -\> RGB

GetRValue(color:tcolor)

GetGValue(color:tcolor)

GetBValue(color:tcolor)

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>
