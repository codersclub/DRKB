---
Title: Закрыть выбранное окно
Author: Radmin
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Закрыть выбранное окно
======================

    PostMessage(FindWindow(Nil, Pchar('Название Окна')), WM_QUIT, 0, 0);

