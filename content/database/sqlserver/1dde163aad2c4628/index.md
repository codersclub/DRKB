---
Title: Поиск по мемо-полям
Date: 01.01.2007
---


Поиск по мемо-полям
===================

::: {.date}
01.01.2007
:::

В MS SQL Server 2000 включена специальная версия MS Index Server,
которая позволяет построить по текстовым (включая BLOB) полям
полнотекстовый индекс и расширения SQL, позволяющие строить запросы по
этому индексу, например:

    SELECT ProductName
      FROM Products
     WHERE CONTAINS(ProductName, 'spread NEAR Boysenberry')

Тенцер А. Л.

ICQ UIN 15925834

tolik\@katren.nsk.ru
