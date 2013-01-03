---
Title: Пример создания хранимой процедуры
Author: Vit
Date: 01.01.2007
---


Пример создания хранимой процедуры
==================================

::: {.date}
01.01.2007
:::

    Create Procedure MyStoredProcedure
      @Parameter1 varchar(50),
      @Parameter2 int,
      @OutputParameter varchar(100) output
    As
    Begin
       Set @Parameter1=isNull(@Parameter1, '')
       Set @OutputParameter=@Parameter1+cast(@Parameter2 as varchar(10))
       Return 0
    End

Примечания:

1\) Begin..End для обрамления процедуры не обязательны. Дельфи приучил
меня

их использовать и мне легче читать с ними код, но вполне можно обходится
и без них. На ваше усмотрение:

 

    Create Procedure MyStoredProcedure
      @Parameter1 varchar(50),
      @Parameter2 int,
      @OutputParameter varchar(100) output
    As
       Set @Parameter1=isNull(@Parameter1, '')
       Set @OutputParameter=@Parameter1+cast(@Parameter2 as varchar(10))
       Return 0

 

2\) Хранимая процедура всегда должна создаваться отдельным SQL запросом.
Нельзя создать одним запросом несколько хранимых процедур. При написании
скрипта для Query Analyser для создания нескольких процедур можно
использовать директиву GO, которая воспринимается Query Analyser\'ом как
разделить отдельных запросов:

    Create Procedure MyStoredProcedure
      @Parameter1 varchar(50),
      @Parameter2 int,
      @OutputParameter varchar(100) output
    As
    Begin
       Set @Parameter1=isNull(@Parameter1, '')
       Set @OutputParameter=@Parameter1+cast(@Parameter2 as varchar(10))
       Return 0
    End
    Go
     
    Create Procedure MyStoredProcedure2
    As
    Select GetDate()
    Go

Директива GO не является оператором SQL и при выполнения запроса из
клиентского приложения не будет пониматься. Кроме того директиву GO
невозможно закоментировать.

------------------------------------------------------------------------

Пример её вызова:

    Declare @Param1 varchar(50), @Param2 int, @OutputParam varchar(100)
     
    Select @Param1='Просто строка ', @Param2=2
     
    Exec MyStoredProcedure
      @Parameter1=@Param1,
      @Parameter2=@Param2,
      @OutputParameter=@OutputParam output
     
    Select @OutputParam

Автор: Vit
