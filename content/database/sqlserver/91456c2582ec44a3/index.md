---
Title: Получить размеры таблиц
Author: Vit
Date: 01.01.2007
---


Получить размеры таблиц
=======================

::: {.date}
01.01.2007
:::

Если в таблицах есть ключи, то работает такой код:

      Select SubString(o.name, 1, 30) as Table_Name,
             i.[rows] as Number_of_Rows
      From sysobjects o
      Left Outer Join sysindexes i on o.id = i.id
      Where o.xtype = 'u' and i.indid < 2
      Order by o.name

Автор: Vit
