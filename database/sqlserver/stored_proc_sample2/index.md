---
Title: Пример вызова хранимой процедуры с возвращаемой переменной
Author: Vit
Date: 01.01.2007
---


Пример вызова хранимой процедуры с возвращаемой переменной
==========================================================

    Declare @MyInVariable varchar(50) --переменная для ввода данных 
    Declare @MyOutVariable varchar(50) --переменная для вывода данных 
     
    Set @MyVariable='dir'
     
    Exec MyStoredProcedure 
      @InternalInVar=@MyInVariable, 
      @InternalOutVar=@MyOutVariable output
     
    Select @MyOutVariable

Обратите внимание что переменные для вывода данных всегда
"присваиваются" внутренним переменным при вызове, хотя логика работы как раз обратная -
при выполнении процедуры значению внешней переменной @MyOutVariable
присваивается значение внутренней (внутрипроцедурной) переменной
@InternalOutVar.
