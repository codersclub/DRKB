---
Title: Закрыть выбранное окно
Author: Radmin
Date: 01.01.2007
---


Закрыть выбранное окно
======================

::: {.date}
01.01.2007
:::

    PostMessage(FindWindow(Nil, Pchar('Название Окна')), WM_QUIT, 0, 0);

Автор: Radmin

Взято с Vingrad.ru <https://forum.vingrad.ru>
