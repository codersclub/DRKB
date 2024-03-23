---
Title: Как настроить Personal Oracle с русским языком на корректную работу с числами и BDE
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как настроить Personal Oracle с русским языком на корректную работу с числами и BDE
===================================================================================

прописать в `\HKEY_LOCAL_MACHINE\SOFTWARE\ORACLE` параметр:
`NLS_NUMERIC_CHARACTERS = '.,'`

или

после соединения с ORACLE выполнить

    ALTER SESSION SET NLS_NUMERIC_CHARACTERS = '.,' 

