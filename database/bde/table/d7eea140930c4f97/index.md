---
Title: Копирование таблицы с помощью DBE
Date: 01.01.2007
---


Копирование таблицы с помощью DBE
=================================

::: {.date}
01.01.2007
:::

    function CopyTable(tbl: TTable; dest: string): boolean;
    var
      psrc, pdest: array[0..DBIMAXTBLNAMELEN] of char;
      rslt: DBIResult;
    begin
      Result := False;
      StrPCopy(pdest, dest);
      with tbl do
      begin
        try
          DisableControls;
          StrPCopy(psrc, TableName);
          rslt := DbiCopyTable(DBHandle, True, psrc, nil, pdest);
          Result := (rslt = 0);
        finally
          Refresh;
          EnableControls;
        end;
      end;
    end;

Взято с <https://delphiworld.narod.ru>
