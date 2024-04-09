---
Title: Возведение в степень для больших чисел
Author: Vit
Date: 01.01.2007
---


Возведение в степень для больших чисел
======================================

Стандартные функции T-SQL не поддерживают возведение в степень если
результат не вмещается в тип int, несмотря на то что сам T-SQL вполне
поддерживает большие числа (bigint)

    @Base bigint, @Exp int
     
    ...
     
      Declare 
        @Result bigint,
        @j int
      set @j=0
      Set @Result=1
      while @j<@Exp
        begin
          Set @Result=@Result*@Base
          set @j=@j+1
         end
      Return @Result
