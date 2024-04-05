---
Title: Как назначить пароль на таблицу?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как назначить пароль на таблицу?
================================

    uses Unit2;
    // ..
    TablePasswort(Table1, 'secret');
     
    unit Unit2;
     
    interface
     
    uses
      BDE, SysUtils, DBTables, Windows;
     
    function TablePasswort(var table: TTable; password: string): Boolean;
     
    implementation
     
    function StrToOem(const AnsiStr: string): string;
    begin
      SetLength(result, Length(AnsiStr));
      if Length(result) > 0 then
        CharToOem(PChar(AnsiStr), PChar(result))
    end;
     
    function TablePasswort(var table: ttable; password: string): Boolean;
    var
      pTblDesc: pCRTblDesc;
      hDb: hDBIDb;
    begin
      result := false;
      with table do
      begin
        if Active and (not Exclusive) then
          Close;
        if (not Exclusive) then
          Exclusive := true;
        if (not Active) then
          Open;
        hDb := DBHandle;
        Close
      end;
      GetMem(pTblDesc, sizeof(CRTblDesc));
      FillChar(pTblDesc^, sizeof(CRTblDesc), 0);
      with pTblDesc^ do
      begin
        StrPCopy(szTblName, StrToOem(table.tablename));
        szTblType := szParadox;
        StrPCopy(szPassword, StrToOem(password));
        bPack := true;
        bProtected := true
      end;
      if DbiDoRestructure(hDb, 1, pTblDesc, nil, nil, nil, false) <> DBIERR_NONE then
        exit;
      if pTblDesc <> nil then
        FreeMem(pTblDesc, sizeof(CRTblDesc));
      result := true
    end;
     
    end.

