---
Title: Вставить сразу несколько строк в таблицу одним запросом
Author: Vit
Date: 01.01.2007
---


Вставить сразу несколько строк в таблицу одним запросом
=======================================================

    Insert into MyTable
      (Field1, Field2, Field3)
    Select Value1, Value2, Value3
    Union All
    Select Value4, Value5, Value6
    ...
