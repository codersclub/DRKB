---
Title: Число цветов (цветовая палитра) у данного компьютера
Date: 01.01.2007
---


Число цветов (цветовая палитра) у данного компьютера
====================================================

Вариант 1:

Author: Зайцев О.В., Владимиров А.М.

Source: <https://forum.sources.ru>

Эта функция возвращает число бит на точку у данного компьютера. Так,
например, 8 - 256 цветов, 4 - 16 цветов ...

    function GetDisplayColors : integer;
    var tHDC  : hdc;
    begin
     tHDC:=GetDC(0);
     result:=GetDeviceCaps(tHDC, 12) * GetDeviceCaps(tHDC, 14);
     ReleaseDC(0, tHDC);
    end;

------------------------------------------------------------------------

Вариант 2:

Source: <https://delphiworld.narod.ru>

    1 shl GetDeviceCaps( Canvas.Handle, BITSPIXEL );

