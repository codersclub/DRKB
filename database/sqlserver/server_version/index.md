---
Title: Как узнать версию сервера?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как узнать версию сервера?
==========================

Эта функция получает подключенную версию MS SQL Server.
Она возвращает информацию о версии в трех параметрах OUT.

    VerNum      : double   eg. 7.00623
    VerStrShort : string   eg. '7.00.623'
    VerStrLong  : string   eg. 'Microsoft SQL Server  7.00 - 7.00.623 (Intel X86)
                                Nov 27 1998 22:20:07
                                Copyright (c) 1988-1998 Microsoft Corporation
                                Enterprise Edition on
                                Windows NT 5.0 (Build 2195: Service Pack 1)'

Я тестировал его с MSSQL 7 и MSSQL 2000.
Я предполагаю, что это должно сработать и для остальных.
Буду признателен за любые отзывы и исправления для разных версий.

Полученный им параметр TQuery представляет собой компонент TQuery,
подключенный к открытому соединению с базой данных.

    procedure GetSqlVersion(Query: TQuery;
      out VerNum: double;
      out VerStrShort: string;
      out VerStrLong: string);
    var
      sTmp, sValue: string;
      i: integer;
    begin
      // @@Version does not return a Cursor.
      // Read the value from the Record Buffer
      // Can be used to read all sys functions from MS Sql
      sValue := '';
      Query.SQL.Text := 'select @@Version';
      Query.Open;
      SetLength(sValue, Query.RecordSize + 1);
      Query.GetCurrentRecord(PChar(sValue));
      SetLength(sValue, StrLen(PChar(sValue)));
      Query.Close;
     
      if sValue <> '' then
        VerStrLong := sValue
      else
      begin
        // Don't know this version
        VerStrLong := '?';
        VerNum := 0.0;
        VerStrShort := '?.?.?.?';
      end;
     
      if VerStrLong <> '' then
      begin
        sTmp := trim(copy(VerStrLong, pos('-', VerStrLong) + 1, 1024));
        VerStrShort := copy(sTmp, 1, pos(' ', sTmp) - 1);
        sTmp := copy(VerStrShort, 1, pos('.', VerStrShort));
     
        for i := length(sTmp) + 1 to length(VerStrShort) do
        begin
          if VerStrShort[i] <> '.' then
            sTmp := sTmp + VerStrShort[i];
        end;
     
        VerNum := StrToFloat(sTmp);
      end;
    end;

