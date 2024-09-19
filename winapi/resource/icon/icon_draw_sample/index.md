---
Title: Пример работы с DrawIcon(Ex)
Author: cully
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---

Пример работы с DrawIcon(Ex)
============================

    DrawIcon(Canvas.Handle, 5, 5, Application.Icon.Handle);
    DrawIconEx(Canvas.Handle, 40, 40, Application.Icon.Handle,
               0, 0, 0, Canvas.Brush.Handle, DI_NORMAL); 

