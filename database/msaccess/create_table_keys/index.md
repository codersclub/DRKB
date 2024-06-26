---
Title: Программное создание таблиц и ключей (первичных и вторичных) для БД Access
Date: 30.07.2003
Author: Дима
Source: http://www.olap.ru/desc/microsoft/borland_ado.asp + msdn
---


Программное создание таблиц и ключей (первичных и вторичных) для БД Access
==========================================================================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Программное создание таблиц/ключей(первичных и вторичных) для бд Access
     
    В принципе данный пример описан на сайте 
    http://www.olap.ru/desc/microsoft/borland_ado.asp,за
    исключением создания ключей. Там же можно прочитать, о том 
    как включить ссылку на библиотеку типов ADOX(Для этого следует 
    выбрать Project | Import Type Library главного меню среды
    разработки Delphi, а затем из списка доступных библиотек 
    типов выбрать Microsoft ADO Ext. 2.5 for DDL and Security. 
    Чтобы избежать конфликтов с именами уже имеющихся классов Delphi
    (например, TTable), следует переименовать классы ADOX, заменив 
    имена на что-нибудь типа TADOXxxx. Затем нужно убрать 
    отметку из опции Generate Component Wrapper — в данном случае нам нужен
    только файл *.pas, содержащий интерфейс для доступа к 
    объектам ADOX, а затем нажать кнопку Create Unit. Это приведет 
    к созданию файла ADOX_TLB.PAS, содержащего интерфейс к библиотеке
    типов ADOX. Создав этот файл, мы должны сослаться на него, 
    а также на модуль ADODB в предложении Uses главного модуля нашего проекта).
     
    Создаются 2 таблицы (Otdel,Departament).Поле NumDepartament в 
    таблице Otdel является внешним ключем к полю NumDepartament в 
    таблице NumDepartament. Поля NumDepartament и NumOtdel в 
    таблицах Departament и Otdel сответственно являются первичными ключами.
     
    Зависимости: Библиотека типов ADOX
    Автор:       Дима
    Copyright:   http://www.olap.ru/desc/microsoft/borland_ado.asp + msdn
    Дата:        30 июля 2003 г.
    ***************************************************** }
     
    var
      Catalog: _Catalog;
      Table: _Table;
      Column: _Column;
      FKKey: _Key;
    begin
      Catalog := CoCatalog.Create;
      try
        Catalog.Set_ActiveConnection('Provider=Microsoft.Jet.OLEDB.4.0;' +
          'Data Source=' + DatabaseName + ';Persist Security Info=False');
        //DatabaseName - Путь к файлу с базой данных (C:\1\12.mdb)
        //=============================================DOLGNOST=========================
        Table := CoTable.Create;
        try
          Table.Name := 'Dolgnost';
          Table.ParentCatalog := Catalog;
          Column := CoColumn.Create;
          try
            with Column do
            begin
              ParentCatalog := Catalog;
              Name := 'NumDolgnost';
              Type_ := adInteger;
            end;
            Table.Columns.Append(Column, 0, 0);
          finally
            Column := nil;
          end;
          with Table.Columns do
          begin
            Append('NameDolgnost', adVarWChar, 50);
          end;
          Catalog.Tables.Append(Table);
        finally
          Table := nil;
        end;
        //=============================================DEPARTAMENT======================
        Table := CoTable.Create;
        try
          Table.Name := 'Departament';
          Table.ParentCatalog := Catalog;
          Column := CoColumn.Create;
          try
            with Column do
            begin
              ParentCatalog := Catalog;
              Name := 'NumDepartament';
              Type_ := adInteger;
            end;
            Table.Columns.Append(Column, 0, 0);
          finally
            Column := nil;
          end;
          with Table.Columns do
          begin
            Append('NameDepartament', adVarWChar, 50);
          end;
          Catalog.Tables.Append(Table);
        finally
          Table := nil;
        end;
        //==============================Создание первичных ключей=======================
            //Otdel
        FKKey := CoKey.Create;
        try
          with FKKey do
          begin
            Name := 'PKNumOtdel';
            Type_ := adKeyPrimary;
            Columns.Append('NumOtdel', adInteger, 0);
          end;
          Catalog.Tables['Otdel'].Keys.Append(FKKey, 0, EmptyParam, '', '');
        finally
          FKKey := nil;
        end;
        //Departament
        FKKey := CoKey.Create;
        try
          with FKKey do
          begin
            Name := 'PKNumDepartament';
            Type_ := adKeyPrimary;
            Columns.Append('NumDepartament', adInteger, 0);
          end;
          Catalog.Tables['Departament'].Keys.Append(FKKey, 0, EmptyParam, '', '');
        finally
          FKKey := nil;
        end;
        //==============================Создание вторичных ключей=======================
            //Otdel
        FKKey := CoKey.Create;
        try
          with FKKey do
          begin
            Name := 'FKNumOtdel';
            Type_ := adKeyForeign;
            Columns.Append('NumDepartament', adInteger, 0);
            RelatedTable := 'Departament';
            Columns['NumDepartament'].RelatedColumn := 'NumDepartament';
            UpdateRule := adRICascade;
          end;
          Catalog.Tables['Otdel'].Keys.Append(FKKey, 0, EmptyParam, '', '');
        finally
          FKKey := nil;
        end;
      finally
        Catalog = nil;
      end;

 

------------------------------------------------------------------------

**Примечание от Vit.**

Это не самый лучший способ...  

Гораздо универсальнее и надёжнее
воспользоваться стандартными средствами SQL и создать необходимые
изменения при помощи запросов SQL, в частности

- Create Table
- Create  Index
- Create Clustered Index
- Alter Table
- и т.п.

Этот способ обеспечит более гибкое управление и даст возможность
использовать все тонкости реализации той или иной базы данных, в том
числе и MS Access
