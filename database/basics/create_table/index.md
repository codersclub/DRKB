---
Title: Создание таблицы
Date: 01.01.2007
---


Создание таблицы
================

::: {.date}
01.01.2007
:::

Как создать таблицу ?

Вариантов несколько:

1\) Сделать это с помошью менеджера соответствующей базы данных, например
таблицу для Paradox создать в Paradox\'e

2\) С помощью Database Desktop - утилита, постовляемая с BDE и
большинством борландовских продуктов. Я не думаю что вы встретите
проблемы при создании таблицы - там всё очень просто.

3\) Из программы.

Здесь 2 варианта, вариант первый, использовать метод CreateTable у
таблицы, вот пример из справки по Дельфи как Борланд предлагает это
делать:

    with Table1 do begin
      Active := False;  
      DatabaseName := 'DBDEMOS';
      TableType := ttParadox;
      TableName := 'CustInfo';
      { Don't overwrite an existing table }
      if not Table1.Exists then begin
        { The Table component must not be active }
        { First, describe the type of table and give }
        { it a name }
        { Next, describe the fields in the table }
        with FieldDefs do begin
          Clear;
          with AddFieldDef do begin
            Name := 'Field1';
            DataType := ftInteger;
            Required := True;
          end;
          with AddFieldDef do begin
     
            Name := 'Field2';
            DataType := ftString;
            Size := 30;
          end;
        end;
        { Next, describe any indexes }
        with IndexDefs do begin
          Clear;
          { The 1st index has no name because it is
          { a Paradox primary key }
          with AddIndexDef do begin
            Name := '';
            Fields := 'Field1';
            Options := [ixPrimary];
          end;
          with AddIndexDef do begin
            Name := 'Fld2Indx';
            Fields := 'Field2';
            Options := [ixCaseInsensitive];
          end;
        end;
        { Call the CreateTable method to create the table }
        CreateTable;
      end;
    end;

Есть другой метод, который нравится мне гораздо больше, он проще в
реализации и работает стабильнее - выполнить Query типа "Create
Table". Этот способ я разберу позже, когда мы будем рассматривать
работу с запросами.
