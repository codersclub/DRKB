---
Title: Поиск по мемо-полям
Date: 01.01.2007
Author: Тенцер А. Л., tolik@katren.nsk.ru
---


Поиск по мемо-полям
===================

В MS SQL Server 2000 включена специальная версия MS Index Server,
которая позволяет построить по текстовым (включая BLOB) полям
полнотекстовый индекс и расширения SQL, позволяющие строить запросы по
этому индексу, например:

    SELECT ProductName
      FROM Products
     WHERE CONTAINS(ProductName, 'spread NEAR Boysenberry')

Тенцер А. Л.  
ICQ UIN 15925834  
tolik@katren.nsk.ru
