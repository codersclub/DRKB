---
Title: Как удалить данные из BLOB-поля?
Author: Vit
Date: 01.01.2007
---


Как удалить данные из BLOB-поля?
================================

::: {.date}
01.01.2007
:::

Только с использованием SQL

    UPDATE MyTable
    Set MyBlobField = Null
    WHERE SomeField = 'Somevalue'

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>
