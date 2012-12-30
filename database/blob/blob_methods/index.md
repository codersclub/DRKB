---
Title: Приемы работы с BLOB (OLE/Memo) полями
Author: Vit
Date: 01.01.2007
---


Приемы работы с BLOB (OLE/Memo) полями
======================================

::: {.date}
01.01.2007
:::

Загрузка файла из TImage:

          QAll.Edit;
          QAll.FieldByName('Logo').assign(Image.Picture);
          QAll.post; 

Чтение файла из таблицы в TImage:

      Image.Picture.assign(QAll.FieldByName('Logo')); 

Загрузка данных в поле:

    (Table1.DataSource2.Fields.Field[01] As TBlobField).LoadFromStream  

Загрузка данных через параметры:

Запрос

    Insert into MyTable (MyBlobField)
    Values (:Something) 

В коде:

    (Query1.parameters.parambyname('Something') as TBlobField).LoadFromFile ...
    (Query1.parameters.parambyname('Something') as TBlobField).LoadFromStream ...
    (Query1.parameters.parambyname('Something') as TBlobField).assign ... 

Автор: Vit

Взято из <https://forum.sources.ru>
