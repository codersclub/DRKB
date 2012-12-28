---
Title: Как создать dBASE таблицу во время выполнения
Date: 01.01.2007
---


Как создать dBASE таблицу во время выполнения
=============================================

::: {.date}
01.01.2007
:::

Данная процедура полезна для создания временных таблиц :

     procedure MakeDataBase;
     begin
       with TTable.Create(nil) do
       begin
         DatabaseName  := 'c:\temp';  (* alias *)
         TableName     := 'test.dbf';
         TableType     := ttDBase;
         with FieldDefs do
         begin
           Add('F_NAME', ftString,20,false);
           Add('L_NAME', ftString,30,false);
         end;
         CreateTable;
         { create a calculated index }
         with IndexDefs do
         begin
           Clear;
           { don't forget ixExpression in calculated indexes! }
           AddIndex('name','Upper(L_NAME)+Upper(F_NAME)',[ixExpression]);
         end;
       end;
     end;

Взято с <https://delphiworld.narod.ru>