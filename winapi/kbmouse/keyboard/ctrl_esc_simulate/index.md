---
Title: Как програмно имитировать нажатие Ctrl-Esc?
Author: TwoK
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как програмно имитировать нажатие Ctrl-Esc?
===========================================

    SendMessage(Handle,WM_SYSCOMMAND,SC_TASKLIST,0); 

