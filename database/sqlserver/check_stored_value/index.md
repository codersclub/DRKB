---
Title: Проверить, есть ли значение в таблице
Author: Vit
Date: 01.01.2007
---


Проверить, есть ли значение в таблице
=====================================

Наличие значения проверяется:

    If Exists (Select * From MyTable Where Field1=1)
      Begin
         Update MyTable
         Set Field2=666
         Where Field1=1
      End
    Else
      Begin
         Insert into MyTable (Field1, Field2)
         Values (1, 666)
      End

Соответственно отсутствие значения проверяется:

    If not Exists (Select * From MyTable Where Field1=1)
      Begin
         Insert into MyTable (Field1, Field2)
         Values (1, 666)
      End
    Else
      Begin
         Update MyTable
         Set Field2=666
         Where Field1=1
      End 
