---
Title: Отображение формы выбранного окна
Author: Radmin
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Отображение формы выбранного окна
=================================

    {
     SW_MAXIMIZE - Развёрнуть форму
     SW_MINIMIZE - Минимизировать форму
     SW_SHOW - Показать форму
     SW_HIDE - Спрятать форму
    }
    ShowWindow(FindWindow(Nil,Pchar('Название Окна')),SW_MAXIMIZE);

