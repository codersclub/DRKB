---
Title: Как програмно имитировать нажатие Ctrl-Esc?
Author: TwoK
Date: 01.01.2007
---


Как програмно имитировать нажатие Ctrl-Esc?
===========================================

::: {.date}
01.01.2007
:::

    SendMessage(Handle,WM_SYSCOMMAND,SC_TASKLIST,0); 

Автор: TwoK

Взято с Vingrad.ru <https://forum.vingrad.ru>
