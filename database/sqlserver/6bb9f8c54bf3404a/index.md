---
Title: Пример вызова динамического SQL с возвращаемой переменной
Author: Vit
Date: 01.01.2007
---


Пример вызова динамического SQL с возвращаемой переменной
=========================================================

::: {.date}
01.01.2007
:::

    Declare @sql nvarchar(4000)
    Declare @ParmDefinition nvarchar(4000) 
     
    Set @ParmDefinition = N'@InParameter varchar(9), @Count int output'
    Set @Sql=N'Select @count=count(*) From MyTable with (nolock)'
    Set @Sql=@Sql+N'WHERE MyField = @InParameter'
     
    Exec sp_executesql @sql, @ParmDefinition, @count=@result output, @InParameter=@MyInParam
     
    Select @result

Примечание

Заменить nvarchar на varchar нельзя!

Автор: Vit
