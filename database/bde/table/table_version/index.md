---
Title: Как узнать версию таблицы
Date: 01.01.2007
---


Как узнать версию таблицы
=========================

::: {.date}
01.01.2007
:::

    function GetTableVersion(Table: TTable): Longint;
    var
      hCursor: hDBICur;
      DT:      TBLFullDesc;
    begin
      Check(DbiOpenTableList(Table.DBHandle, True, False,
        PChar(Table.TableName), hCursor));
      Check(DbiGetNextRecord(hCursor, dbiNOLOCK, @DT, nil));
      Result := DT.tblExt.iRestrVersion;
      Check(DbiCloseCursor(hCursor));
    end; 

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
