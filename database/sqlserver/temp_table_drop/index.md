---
Title: Удалить временную таблицу по имени
Author: Vit
Date: 01.01.2007
---


Удалить временную таблицу по имени
==================================

::: {.date}
01.01.2007
:::

Причём не выдавать ошибку если такой таблицы нет.

      Execute('if exists 
              (select * from tempdb..sysobjects 
               where id = OBJECT_ID(''tempdb..'+@TableName+''')) drop table '+@TableName)

Автор: Vit

 
