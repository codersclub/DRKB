---
Title: Использование case
Author: Vit
Date: 01.01.2007
---


Использование case
==================

Оператор выбора Case работает немного по другому чем в классических
языках. В классических языках Case выбирает какой оператор запускать, а
в T-SQL он выбирает выражение которое надо использовать для вычисления
чего-то. Case выступает в ввиде функции которая возвращает результат в
зависимости от условия. Имеет 2 формы написания:

**Форма 1.**

    Declare @m int

    Set @m=Month(GetDate())
     
    Select
      @m as MonthNumber, 
      Case @m
        When  1 Then 'Январь'
        When  2 Then 'Февраль'
        When 12 Then 'Декабрь'
        Else 'Не зима'
      End as MonthName

**Форма 2.**

    Declare @m int

    Set @m=Month(GetDate())
     
    Select
      @m as MonthNumber, 
      Case 
        When @m=1 Then 'Январь'
        When @m=2 Then 'Февраль'
        When @m=12 Then 'Декабрь'
        When @m is Null Then 'Неизвестно'
        Else 'Не зима'
      End as MonthName

Можно использовать Case для присвоения

    Set @MyVar=
      Case  
        When @m=1 Then 'Январь'
        When @m=2 Then 'Февраль'
        When @m=12 Then 'Декабрь'
        When @m is Null Then 'Неизвестно'
        Else 'Не зима'
      End

Можно использовать в операциях сравнения, сортировки, группировки и функциях:

    Select 
      dbo.MyFunction( 
        Case  
          When @m=1 Then 'Январь'
          When @m=2 Then 'Февраль'
          When @m=12 Then 'Декабрь'
          When @m is Null Then 'Неизвестно'
          Else 'Не зима'
        End),
      Case When MyField=0 Then 'False' else 'True' End,
      Count(*) 
    From MyTable
    Where Case
      When MyField1=0 Then Field2 else Field3 End
    Group by Case
      When MyField=0 Then 'False' else 'True' End
    Order By Case
      When MyField=0 Then 'False' else 'True' End 

