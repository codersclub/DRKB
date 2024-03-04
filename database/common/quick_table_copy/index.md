---
Title: Быстрое копирование таблиц
Date: 01.01.2007
Source: <https://blackman.wp-club.net/>
---


Быстрое копирование таблиц
==========================

Из книги Стива Тейксейра и Пачеко \'Delphi 4. Руководство разработчика\'
я взял функцию для быстрого копирования
таблиц вместе со всеми дополнительными файлами:

Вот она:

    procedure QuickCopyTable(T: TTable;DestTblName:string;Overwrite: boolean);
    // только для не SQL-ых, т.е не промышленных  БД (dBase, Paradox ..)
    var DBType: DBIName;
       WasOpen:boolean;
       NumCopied:word;
    begin
     WasOpen:=T.Active;
     if not WasOpen then T.Open;
     Check(DbiGetProp(hDBIObj(T.Handle),drvDRIVERTYPE,@DBType,SizeOf(DBINAME),
        NumCopied));
     Check(DbiCopyTable(T.DBHandle, Overwrite, PChar(T.TableName),DBType, PChar(DestTblName)));
     T.Active:=WasOpen;
    end;

