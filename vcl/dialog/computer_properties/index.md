---
Title: Как вывести окно свойств компьютеpа?
Date: 01.01.2007
Source: <https://blackman.wp-club.net/>
---


Как вывести окно свойств компьютеpа?
====================================

    ShellExecute(Application.Handle, 'open', 'sysdm.cpl', nil, nil,sw_ShowNormal);

