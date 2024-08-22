---
Title: Присвоение форме выбранного окна свойства Disabled / Enabled
Author: p0s0l
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Присвоение форме выбранного окна свойства Disabled / Enabled
============================================================

    {в конце процедуры: false для запрета, true для разрешения}
    EnableWindow(FindWindow(Nil,Pchar('Название Окна')), false);

