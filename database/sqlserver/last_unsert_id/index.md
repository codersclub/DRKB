---
Title: Узнать автоинкрементное поле после вставки
Author: Vit
Date: 01.01.2007
---


Узнать автоинкрементное поле после вставки
==========================================

    Insert into MyTable
      (Field1, Field2, Field3)
    Values
      ('Value for field1', 'Value for field2', 0)
     
    Select @@identity as 'New number for inserted row'

Вообще-то правильнее использовать Identity\_Scope(), но разница будет
только если на таблице стоит триггер:

    Insert into MyTable
      (Field1, Field2, Field3)
    Values
      ('Value for field1', 'Value for field2', 0)
     
    Select identity_scope() as 'New number for inserted row'
