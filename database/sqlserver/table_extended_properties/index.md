---
Title: Прочитать расширенное свойство таблицы
Author: Vit
Date: 01.01.2007
---


Прочитать расширенное свойство таблицы
======================================

    SELECT * FROM ::FN_LISTEXTENDEDPROPERTY(NULL, 'user','dbo','table', 'MyTable', 'column', 'MyIndex')
