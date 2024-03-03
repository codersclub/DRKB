---
Title: Как записать файл в BLOB-поле?
Author: Vit
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как записать файл в BLOB-поле?
==============================

1) Через таблицу:

    (table1.fieldbyname('ddd') as TBlobField).loadfromfile('dddss');

(Для некоторых баз данных через BDE так можно загрузить не более 64k)

2) Через параметры в запросе...

    ADOquery1.sql.text:='Insert into myTable (a) Values (:b)';
    ADOQuery1.parameters.parseSQL(ADOquery1.sql.text, true);
    ADOQuery1.parameters.parambyname('b').LoadFromFile('MyFile');
    ADOQuery1.execsql; 
