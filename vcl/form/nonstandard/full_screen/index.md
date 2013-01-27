---
Title: Как сделать, чтобы окно было на весь экран?
Author: Baa
Date: 01.01.2007
---


Как сделать, чтобы окно было на весь экран?
===========================================

::: {.date}
01.01.2007
:::

    PostMessage(Application.Handle, WM_SYSCOMMAND, SC_MAXIMIZE, 1); 

Автор: Baa

Взято с Vingrad.ru <https://forum.vingrad.ru>
