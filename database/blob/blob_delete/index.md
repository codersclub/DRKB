---
Title: Как удалить данные из BLOB-поля?
Author: Vit
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как удалить данные из BLOB-поля?
================================

Только с использованием SQL

    UPDATE MyTable
    Set MyBlobField = Null
    WHERE SomeField = 'Somevalue'
