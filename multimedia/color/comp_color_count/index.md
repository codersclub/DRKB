---
Title: Число цветов (цветовая палитра) у данного компьютера
Date: 01.01.2007
---


Число цветов (цветовая палитра) у данного компьютера
====================================================

::: {.date}
01.01.2007
:::

Эта функция возвращает число бит на точку у данного компьютера. Так,
например, 8 - 256 цветов, 4 - 16 цветов \...

    function GetDisplayColors : integer;
    var tHDC  : hdc;
    begin
     tHDC:=GetDC(0);
     result:=GetDeviceCaps(tHDC, 12)* GetDeviceCaps(tHDC, 14);
     ReleaseDC(0, tHDC);
    end;

Зайцев О.В.

Владимиров А.М.

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------

    1 shl GetDeviceCaps( Canvas.Handle, BITSPIXEL );

Взято с <https://delphiworld.narod.ru>
