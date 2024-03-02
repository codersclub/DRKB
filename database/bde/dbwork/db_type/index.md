---
Title: Определение типа базы данных
Date: 01.01.2007
Author: OAmiry/Borland
Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)

---


Определение типа базы данных
============================

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


Взято из Советов по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)

Сборник Kuliba
