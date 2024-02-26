---
Title: Запись картинки в ADO-таблицу
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Запись картинки в ADO-таблицу
=============================

    ADOQuery1.Edit;
    TBLOBField(ADOQuery1.FieldByName('myField')).LoadFromFile('c:\my.bmp');
    ADOQuery1.Post;

---
**Примечание Vit:**

>Похоже имеется ввиду запросы вида "Select * From..."
