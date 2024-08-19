---
Title: Поменять заголовок выбранного окна
Author: Radmin
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Поменять заголовок выбранного окна
==================================

    SetWindowText(FindWindow(Nil,Pchar('Старый Заголовок')),
                  pchar('Новый заголовок'));

