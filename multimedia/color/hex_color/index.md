---
Title: Как получить hex-значение данного цвета?
Author: Vit
Date: 01.01.2007
---


Как получить hex-значение данного цвета?
========================================

Вариант 1:

GetRValue, GetGValue, GetBValue - дадут тебе байты цветов, затем тебе
надо их перевести в hex...

Author: Vit

Source: Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

Вариант 2:

    IntToHex(Color);

Author: neutrino

Source: Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

Вариант 3:

В модуле graphics имеются две недокументированные функции:

    function ColorToString(Color: TColor): string;

Если значение TColor является именованным цветом, функция возвращает имя
цвета ("clRed"). В противном случае возвращается шестнадцатиричное
значение цвета в виде строки.

    function StringToColor(S: string): TColor;

Данная функция преобразует "clRed" или "$0000FF" во внутреннее
значение цвета.

Author: Pegas

Source: Vingrad.ru <https://forum.vingrad.ru>
