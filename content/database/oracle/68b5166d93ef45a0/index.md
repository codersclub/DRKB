---
Title: Как настроить Personal Oracle с русским языком на корректную работу с числами и BDE
Date: 01.01.2007
---


Как настроить Personal Oracle с русским языком на корректную работу с числами и BDE
===================================================================================

::: {.date}
01.01.2007
:::

прописать в

\\HKEY\_LOCAL\_MACHINE\\SOFTWARE\\ORACLE параметр:

NLS\_NUMERIC\_CHARACTERS = \'.,\'

или

после соединения с ORACLE выполнить

    ALTER SESSION SET NLS_NUMERIC_CHARACTERS = '.,' 

Взято с <https://delphiworld.narod.ru>
