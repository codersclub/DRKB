---
Title: Как узнать номер автоинкремента при вставке новой записи?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как узнать номер автоинкремента при вставке новой записи?
=========================================================

Допустим, у нас имеется таблица в MsAccess: Test,
с полями: (id=autoinc, name=text);

Для начала нам нужна функция, подобная приведенной ниже:

    function GetLastInsertID: integer;
    begin
      // datResult = TADODataSet
      datResult.Active := False;
      datResult.CommandText := 'select @@IDENTITY as [ID]';
      datResult.Active := True;
      Result := datResult.FieldByName('id').AsInteger;
      datResult.Active := False;
    end;

Для добавления записи нужно сделать вставку SQL, как показано ниже:

    procedure InsertRec;
    begin
      // datCommand = TADOCommand
      datCommand.CommandText := 'insert into [test] ( [name] ) values ( "Test" )';
      datCommand.Execute;
    end;

Теперь для того, чтобы узнать ID последней вставленной автоинкрементной записи,
достаточно вызвать приведенную выше функцию GetLastInsertID.
(обратите внимание, что процедура GetLastInsertIDd работает только после процедуры InsertRec!)

    procedure Test;
    begin
      InsertRec;
      Showmessage(format('lastinsertid : %d', [GetLastInsertID]));
    end;

Надеюсь, вы справитесь с этой задачей.
У меня это работает, если что - не стесняйтесь задавать любые вопросы.

