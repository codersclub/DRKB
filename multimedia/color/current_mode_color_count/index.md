---
Title: Как можно узнать количество цветов текущего режима?
Date: 01.01.2007
---


Как можно узнать количество цветов текущего режима?
===================================================

::: {.date}
01.01.2007
:::

GetDeviceCaps(Form1.Canvas.Handle, BITSPIXEL) *

GetDeviceCaps(Form1.Canvas.Handle, PLANES)

Для получения общего количества битов, используемых для получения цвета
используются следующие значения.

1 = 2 colors bpp

4 = 16 colors bpp

8 = 256 colors bpp

15 = 32768 colors (возвращает 16 на большинстве драйверов) bpp

16 = 65535 colors bpp

24 = 16,777,216 colors bpp

32 = 16,777,216 colors (то же, что и 24) bpp

Вы можете использовать:

NumberOfColors := (1 shl

(GetDeviceCaps(Form1.Canvas.Handle, BITSPIXEL) *

GetDeviceCaps(Form1.Canvas.Handle, PLANES));

для подсчета общего количества используемых цветов.

Взято с <https://delphiworld.narod.ru>
