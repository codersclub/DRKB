---
Title: Присвоение форме выбранного окна свойства Disabled / Enabled
Author: p0s0l
Date: 01.01.2007
---


Присвоение форме выбранного окна свойства Disabled / Enabled
============================================================

::: {.date}
01.01.2007
:::

    {в конце процедуры: false для запрета true для разрешения}
    EnableWindow(FindWindow(Nil,Pchar('Название Окна')), false);

Автор: p0s0l

Взято с Vingrad.ru <https://forum.vingrad.ru>
