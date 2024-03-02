---
Title: Функция для быстрого копирования таблиц вместе со всеми дополнительными файлами
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Функция для быстрого копирования таблиц вместе со всеми дополнительными файлами
===============================================================================

    // Только для не SQL-ых, т.е не промышленных БД (dBase, Paradox ..)
    // Путь нужно задавать только АНГЛИЙСКИМИ буквами
    procedure QuickCopyTable(T: TTable; DestTblName: string; Overwrite: boolean);
    var
      DBType: DBIName;
      WasOpen: boolean;
      NumCopied: word;
    begin
      WasOpen := T.Active;
      if not WasOpen then
        T.Open;
      Check(DbiGetProp(hDBIObj(T.Handle),drvDRIVERTYPE, @DBType,SizeOf(DBINAME), NumCopied));
      Check(DbiCopyTable(T.DBHandle, Overwrite, PChar(T.TableName),DBType, PChar(DestTblName)));
      T.Active := WasOpen;
    end;

