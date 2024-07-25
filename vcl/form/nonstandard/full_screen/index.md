---
Title: Как сделать, чтобы окно было на весь экран?
Author: Baa
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как сделать, чтобы окно было на весь экран?
===========================================

    PostMessage(Application.Handle, WM_SYSCOMMAND, SC_MAXIMIZE, 1); 

