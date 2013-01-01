---
Title: Как узнать номер автоинкремента при вставке новой записи?
Date: 01.01.2007
---


Как узнать номер автоинкремента при вставке новой записи?
=========================================================

::: {.date}
01.01.2007
:::

We have a table in MsAccess like :

Test, Fields (id=autoinc, name=text);

First we have to have a function like the one below :

    function GetLastInsertID: integer;
    begin
      // datResult = TADODataSet
      datResult.Active := False;
      datResult.CommandText := 'select @@IDENTITY as [ID]';
      datResult.Active := True;
      Result := datResult.FieldByName('id').AsInteger;
      datResult.Active := False;
    end;

Now before getting the last inserted record record id = autoincrement
field, in other words calling the above function. You have to do a SQL
insert like the following

    procedure InsertRec;
    begin
      // datCommand = TADOCommand
      datCommand.CommandText := 'insert into [test] ( [name] ) values ( "Test" )';
      datCommand.Execute;
    end;

Now if we like to know which is the last autoinc value ( notice that the
getlastinsertid proc. only works after the insertrec proc)

    procedure Test;
    begin
      InsertRec;
      Showmessage(format('lastinsertid : %d', [GetLastInsertID]));
    end;

Hope you can make this work, it works for me, any questions feel free to
ask

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
