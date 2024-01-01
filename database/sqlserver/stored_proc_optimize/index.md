---
Title: Оптимизация хранимых процедур
Author: Vit
Date: 01.01.2007
---


Оптимизация хранимых процедур
=============================

::: {.date}
01.01.2007
:::

Используйте практику добавления SET NOCOUNT ON в каждую процедуру,
это позволит сэкономить время их выполнения и трафик, так как применение
директивы указывает процедуре не подсчитывать количество строк которое
затронула каждая операция.

Пример:

    Create Procedure MyStoredProcedure
      @Parameter1 varchar(50),
      @Parameter2 int,
      @OutputParameter varchar(100) output
    As
    Begin
      Set nocount ON
      Set @Parameter1=isNull(@Parameter1, '')
      Set @OutputParameter=@Parameter1+cast(@Parameter2 as varchar(10))
      Set nocount OFF
      Return 0
    End

Автор: Vit
