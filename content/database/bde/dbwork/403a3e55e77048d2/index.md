---
Title: Определение типа базы данных
Date: 01.01.2007
---


Определение типа базы данных
============================

::: {.date}
01.01.2007
:::

    {uses должен включать в себя db, dbitypes, dbiprocs }
     
    procedure TForm1.FormCreate(Sender: TObject);
    var
     
      rDB: DBDesc;
    begin
     
    { Первый аргумент DbiGetDatabaseDesc - имя псевдонима базы данных
    типа PChar }
      Check(DbiGetDatabaseDesc('IBLOCAL', @rDB));
    { член szDbType структуры DBDesc содержит информацию о типе
    базы данных и имеет тип PChar }
      ShowMessage('Database имеет тип: ' + StrPas(rDB.szDbType));
     
    { Совет: Если вам просто необходимо узнать -
    SQL server это или нет, используйте свойсто TDatabase
    IsSQLBased }
    end;

OAmiry/Borland

Взято из Советов по Delphi от [Валентина
Озерова](mailto:mailto:webmaster@webinspector.com)

Сборник Kuliba
