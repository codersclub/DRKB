---
Title: Пример вызова хранимой процедуры с указанием переменных
Author: Vit
Date: 01.01.2007
---


Пример вызова хранимой процедуры с указанием переменных
=======================================================

    Declare @MyVariable1 varchar(50), @MyVariable2 varchar(50)
     
    Select @MyVariable1='dir', @MyVariable2='test'
     
    Exec MyStroredProcedure
      @StroredProcedureVariable1=@MyVariable1,
      @StroredProcedureVariable2=@MyVariable2
