---
Title: Как имитировать нажатие левой кнопки мыши?
Author: Song, Spawn
Date: 01.01.2007
---


Как имитировать нажатие левой кнопки мыши?
==========================================

::: {.date}
01.01.2007
:::

    mouse_event(MOUSEEVENTF_LEFTDOWN,0,0,0,0);
    Application.ProcessMessages;
    mouse_event(MOUSEEVENTF_LEFTUP,0,0,0,0); 

Автор: Song, Spawn

Взято с Vingrad.ru <https://forum.vingrad.ru>
