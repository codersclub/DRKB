---
Title: Запись картинки в ADO-таблицу
Date: 01.01.2007
---


Запись картинки в ADO-таблицу
=============================

::: {.date}
01.01.2007
:::

    ADOQuery1.Edit;
    TBLOBField(ADOQuery1.FieldByName('myField')).LoadFromFile('c:\my.bmp');
    ADOQuery1.Post;

Взято с <https://delphiworld.narod.ru>

Примечание Vit

Похоже имеется ввиду запросы вида \"Select * From...\"
