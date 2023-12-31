---
Title: Как узнать версию сервера?
Date: 01.01.2007
---


Как узнать версию сервера?
==========================

::: {.date}
01.01.2007
:::

This function gets the connected MS SQL Server version. It returns the
version info in 3 OUT parameters.

       VerNum                        : double        eg. 7.00623

       VerStrShort        : string                eg. \'7.00.623\'

       VerStrLong        : string                eg. \'Microsoft SQL
Server  7.00 - 7.00.623 (Intel X86)        Nov 27 1998
22:20:07                                                            
Copyright (c) 1988-1998 Microsoft Corporation        Enterprise Edition
on                                                                  
Windows NT 5.0 (Build 2195: Service Pack 1)\'

I have tested it with MSSQL 7 and MSSQL 2000. I assume it should work
for the others. Any feedback and fixes for different versions would be
appreciated.

The TQuery parameter that it recieves is a TQuery component that is
connected to an open database connection.

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

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
