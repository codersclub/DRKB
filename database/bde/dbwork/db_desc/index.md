---
Title: Как узнать путь базы данных и её имя?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как узнать путь базы данных и её имя?
=====================================

Делается это при помощи dbiGetDatabaseDesc:

     
    uses BDE;
    .....
     
    procedure ShowDatabaseDesc(DBName: string);
    const
      DescStr = 'Driver Name: %s'#13#10'AliasName: %s'#13#10 +
        'Text: %s'#13#10'Physical Name/Path: %s';
    var
      dbDes: DBDesc;
    begin
      dbiGetDatabaseDesc(PChar(DBName), @dbDes);
      with dbDes do
        ShowMessage(Format(DescStr, [szDbType, szName, szText, szPhyName]));
    end;

