---
Title: Как заставить BDE сохранять в БД поле времени с сотыми долями секунды
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как заставить BDE сохранять в БД поле времени с сотыми долями секунды
=====================================================================

Если руками, то в BDE Administrator (BDE Configuration Utility).

Если при инсталляции твоей программы, то:

В пункте Make Registry Changes InstallShield'а создай ключ

    HKEY_LOCAL_MACHINE\SOFTWARE\Borland\Database Engine\Settings\SYSTEM\FORMATS\TIME\MILSECONDS=TRUE

