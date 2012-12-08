---
Title: Как заставить BDE сохранять в БД поле времени с сотыми долями секунды
Date: 01.01.2007
---


Как заставить BDE сохранять в БД поле времени с сотыми долями секунды
=====================================================================

::: {.date}
01.01.2007
:::

Если руками, то в BDE Administrator (BDE Configuration Utility).

Если при инсталляции твоей программы, то -

В пункте Make Registry Changes InstallShield\'а создай ключ

HKEY\_LOCAL\_MACHINE\\SOFTWARE\\Borland\\Database
Engine\\Settings\\SYSTEM\\FORMATS\\TIME\\MILSECONDS=TRUE

Взято с <https://delphiworld.narod.ru>
