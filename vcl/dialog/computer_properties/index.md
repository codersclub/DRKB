---
Title: Как вывести окно свойств компьютеpа?
Date: 01.01.2007
---


Как вывести окно свойств компьютеpа?
====================================

::: {.date}
01.01.2007
:::

    ShellExecute(Application.Handle, 'open', 'sysdm.cpl', nil, nil,sw_ShowNormal);

Взято с сайта <https://blackman.wp-club.net/>
