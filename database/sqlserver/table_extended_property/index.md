---
Title: Добавить расширенное свойство к таблице
Author: Vit
Date: 01.01.2007
---


Добавить расширенное свойство к таблице
=======================================

    EXEC sp_addextendedproperty 'PropertyName', 'PropertyValue', 'user', dbo, 'table', MyTable, 'column', MyField
