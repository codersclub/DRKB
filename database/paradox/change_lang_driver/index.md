---
Title: Как изменить языковый драйвер в runtime?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как изменить языковый драйвер в runtime?
========================================

    procedure SetLanguage(Tbl: TTable; Lang: DbiName);
    var
      pOptDesc: pFLDDesc;
      pOptData: pBYTE;
      hDb: hDbiDb;
      TblDesc: CRTblDesc;
      Dir: string;
    begin
      pOptDesc := AllocMem(sizeof(FLDDesc));
      pOptData := AllocMem(20);
      SetLength(Dir, dbiMaxNameLen + 1);
      Tbl.Active := True;
      Check(DbiGetDirectory(Tbl.DBHandle, False, PChar(Dir)));
      SetLength(Dir, StrLen(PChar(Dir)));
      try
        FillChar(TblDesc, sizeof(CRTblDesc), #0);
        Tbl.DisableControls;
        Tbl.Close;
        Check(DbiOpenDatabase(nil, nil, dbiReadWrite, dbiOpenExcl, nil, 0, nil, nil,
          hDb));
        Check(DbiSetDirectory(hDb, PChar(Dir)));
        pOptDesc.iOffset := 0;
        pOptDesc.iLen := Length(Lang) + 1;
        StrPCopy(pOptDesc.szName, 'LANGDRIVER');
        StrPCopy(PChar(pOptData), Lang);
        TblDesc.iOptParams := 1;
        TblDesc.pfldOptParams := pOptDesc;
        TblDesc.pOptData := pOptData;
        StrPCopy(TblDesc.szTblName, Tbl.TableName);
        StrCopy(TblDesc.szTblType, szParadox);
        Check(DbiDoRestructure(hDb, 1, @TblDesc, nil, nil, nil, False));
      finally
        Check(DbiCloseDatabase(hDb));
        FreeMem(pOptDesc, sizeof(FLDDesc));
        FreeMem(pOptData, 20);
        Tbl.EnableControls;
      end;
    end;

