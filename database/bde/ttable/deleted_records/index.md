---
Title: Как показать удаленные записи
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как показать удаленные записи
=============================

    procedure DeletedRecords(Table: TTable; SioNo: Boolean);
    begin
      Table.DisableControls;
      try
        Check(DbiSetProp(hDBIObj(Table.Handle), curSOFTDELETEON, Longint(SioNo)));
      finally
        Table.EnableControls;
      end;
      Table.Refresh;
    end; 

