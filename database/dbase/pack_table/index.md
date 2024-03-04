---
Title: Как паковать таблицу?
Date: 01.01.2007
---


Как паковать таблицу?
=====================

Вариант 1.

    function dgPackParadoxTable(Tbl: TTable; Db: TDatabase): DBIResult;
    {Packs a Paradox table by calling the BDE DbiDoRestructure function. The TTable passed as the first parameter must be closed. The TDatabase passed as the second parameter must be connected.}
    var
      TblDesc: CRTblDesc;
    begin
      Result := DBIERR_NA;
      FillChar(TblDesc, SizeOf(CRTblDesc), 0);
      StrPCopy(TblDesc.szTblName, Tbl.TableName);
      TblDesc.bPack := True;
      Result := DbiDoRestructure(Db.Handle, 1, @TblDesc, nil, nil, nil, False);
    end;

Source: Delphi Knowledge Base: <https://www.baltsoft.com/>

------------------------------------------------------------------------

Вариант 2.

    uses
      DbiProcs;
     
    with Table do
    begin
      OldState := Active;
      Close;
      Exclusive := True;
      Open;
     
      DbiPackTable(DBHandle, Handle, nil, nil, True);
      {^ здесь можно добавить check()}
     
      Close;
      Exclusive := False;
      Active := OldState;
      { при желании можно сохранить закладку }
    end;

Author: Nomadic

Source: <https://delphiworld.narod.ru>
