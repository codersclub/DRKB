---
Title: Выполнение SQL, заданного строкой
Author: Vit
Date: 01.01.2007
---


Выполнение SQL, заданного строкой
=================================

    Declare @sql varchar(8000)

    Set @sql='Select * From MyTable'
    Exec (@sql)
