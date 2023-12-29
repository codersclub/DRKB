---
Title: Как записать файл в BLOB-поле?
Author: Vit
Date: 01.01.2007
---


Как записать файл в BLOB-поле?
==============================

::: {.date}
01.01.2007
:::

1)Через таблицу:


     
    (table1.fieldbyname('ddd') as TBlobField).loadfromfile('dddss');

(Для некоторых баз данных через BDE так можно загрузить не более 64k)

2\) через параметры в запросе...


     
    ADOquery1.sql.text:='Insert into myTable (a) Values (:b)';
    ADOQuery1.parameters.parseSQL(ADOquery1.sql.text, true);
    ADOQuery1.parameters.parambyname('b').LoadFromFile('MyFile');
    ADOQuery1.execsql; 

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>
