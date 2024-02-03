---
Title: Запретить в выбранном окне кнопку закрытия x
Author: Radmin
Date: 01.01.2007
---


Запретить в выбранном окне кнопку закрытия x
============================================

::: {.date}
01.01.2007
:::

     
    EnableMenuItem(GetSystemMenu(FindWindow(Nil, Pchar('Название Окна')),False)
     ,SC_CLOSE,MF_BYCOMMAND or MF_GRAYED);

Автор: Radmin

Взято с Vingrad.ru <https://forum.vingrad.ru>
