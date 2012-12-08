---
Title: Преодоление барьера в 8000 символов в динамическом SQL
Author: Vit
Date: 01.01.2007
---


Преодоление барьера в 8000 символов в динамическом SQL
======================================================

::: {.date}
01.01.2007
:::

    Declare @sql1 varchar(8000), @sql2 varchar(8000)
    Set @sql1='Select * From MyTable'
    Set @sql2='Where MyField=''Something'''
     
    Exec (@sql1+@sql2)

Автор: Vit
