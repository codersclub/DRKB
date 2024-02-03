---
Title: INSERT, UPDATE и DELETE
Date: 01.01.2007
---


INSERT, UPDATE и DELETE
=======================

::: {.date}
01.01.2007
:::

**INSERT**

В дополнение к стандартным возможностям, MS SQL Server позволяет
вставить в таблицу набор данных, полученный в результате выполнения
хранимой процедуры, при помощи синтаксиса:

    INSERT author_sales EXECUTE get_author_sales

**UPDATE и DELETE**

Сервер поддерживает расширенный синтаксис

    UPDATE MyTable 
      SET Name = 'Иванов'
     FROM MyTable T INNER JOIN AnotherTable A ON T.Id = A.MyTableId
      AND A.SomeField = 20
