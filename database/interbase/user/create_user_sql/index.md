---
Title: Можно ли создать пользователя БД при помощи SQL-команды?
Date: 01.01.2007
Author: [Дмитрий Кузьменко](mailto:delphi@demo.ru)
---


Можно ли создать пользователя БД при помощи SQL-команды?
========================================================

Нет.  
Единственно правильный способ - использовать Server Manager.
(Tasks \| User Security), либо утилиту командной строки GSEC,
либо IB user API (для IB 5.x).

См. www.ibase.ru/download.htm, www.borland.com/devsupport/bde/.

Cоставитель: Дмитрий Кузьменко
