---
Title: Модификация настроек BDE
Date: 01.01.2007
---


Модификация настроек BDE
========================

Вариант 1.

>Is there a way to change the IDAPI.CFG file from Delphi coding using the
>BDE API, since I wish to avoid having my users utilize the BDECFG.EXE
>utility?

**Answer:**

Here is a unit that is supposed to allow changing the config file:

    unit CFGTOOL;
     
    interface
     
    uses
      SysUtils, Classes, DB, DbiProcs, DbiTypes, DbiErrs;
     
    type
      TBDEConfig = class(TComponent)
      private
        FLocalShare: Boolean;
        FMinBufSize: Integer;
        FMaxBufSize: Integer;
        FSystemLangDriver: string;
        FParadoxLangDriver: string;
        FMaxFileHandles: Integer;
        FNetFileDir: string;
        FTableLevel: string;
        FBlockSize: Integer;
        FDefaultDriver: string;
        FStrictIntegrity: Boolean;
        FAutoODBC: Boolean;
     
        procedure Init;
        procedure SetLocalShare(Value: Boolean);
        procedure SetMinBufSize(Value: Integer);
        procedure SetMaxBufSize(Value: Integer);
        procedure SetSystemLangDriver(Value: string);
        procedure SetParadoxLangDriver(Value: string);
        procedure SetMaxFileHandles(Value: Integer);
        procedure SetNetFileDir(Value: string);
        procedure SetTableLevel(Value: string);
        procedure SetBlockSize(Value: Integer);
        procedure SetDefaultDriver(Value: string);
        procedure SetAutoODBC(Value: Boolean);
        procedure SetStrictIntegrity(Value: Boolean);
        procedure UpdateCFGFile(path, item, value: string);
     
      protected
     
      public
        constructor Create(AOwner: TComponent); override;
        destructor Destroy; override;
      published
        property LocalShare: Boolean read FLocalShare write SetLocalShare;
        property MinBufSize: Integer read FMinBufSize write SetMinBufSize;
        property MaxBufSize: Integer read FMaxBufSize write SetMaxBufSize;
        property SystemLangDriver: string read FSystemLangDriver write
          SetSystemLangDriver;
        property ParadoxLangDriver: string read FParadoxLangDriver write
          SetParadoxLangDriver;
        property MaxFileHandles: Integer read FMaxFileHandles write SetMaxFileHandles;
        property NetFileDir: string read FNetFileDir write SetNetFileDir;
        property TableLevel: string read FTableLevel write SetTableLevel;
        property BlockSize: Integer read FBlockSize write SetBlockSize;
        property DefaultDriver: string read FDefaultDriver write SetDefaultDriver;
        property AutoODBC: Boolean read FAutoODBC write SetAutoODBC;
        property StrictIntegrity: Boolean read FStrictIntegrity write SetStrictIntegrity;
     
      end;
     
    procedure Register;
     
    implementation
     
    function StrToBoolean(Value: string): Boolean;
    begin
      if (UpperCase(Value) = 'TRUE') or (UpperCase(Value) = 'ON') or
        (UpperCase(Value) = 'YES') or (UpperCase(Value) = '.T.') then
        Result := True
      else
        Result := False;
    end;
     
    function BooleanToStr(Value: Boolean): string;
    begin
      if Value then
        Result := 'TRUE'
      else
        Result := 'FALSE';
    end;
     
    procedure Register;
    begin
      RegisterComponents('Data Access', [TBDEConfig]);
    end;
     
    procedure TBDEConfig.Init;
    var
      h: hDBICur;
      pCfgDes: pCFGDesc;
      n, v: string;
    begin
      Check(DbiOpenCfgInfoList(nil, dbiREADWRITE, cfgPersistent, '\SYSTEM\INIT', h));
      GetMem(pCfgDes, sizeof(CFGDesc));
      try
        FillChar(pCfgDes^, sizeof(CFGDesc), #0);
        while (DbiGetNextRecord(h, dbiWRITELOCK, pCfgDes, nil) = DBIERR_NONE) do
        begin
          n := StrPas(pCfgDes^.szNodeName);
          v := StrPas(pCfgDes^.szValue);
          if n = 'LOCAL SHARE' then
            FLocalShare := StrToBoolean(v)
          else if n = 'MINBUFSIZE' then
            FMinBufSize := StrToInt(v)
          else if n = 'MAXBUFSIZE' then
            FMaxBufSize := StrToInt(v)
          else if n = 'MAXFILEHANDLES' then
            FMaxFileHandles := StrToInt(v)
          else if n = 'LANGDRIVER' then
            FSystemLangDriver := v
          else if n = 'AUTO ODBC' then
            FAutoODBC := StrToBoolean(v)
          else if n = 'DEFAULT DRIVER' then
            FDefaultDriver := v;
        end;
        if (h <> nil) then
          DbiCloseCursor(h);
        Check(DbiOpenCfgInfoList(nil, dbiREADWRITE, cfgPersistent,
          '\DRIVERS\PARADOX\INIT', h));
        FillChar(pCfgDes^, sizeof(CFGDesc), #0);
        while (DbiGetNextRecord(h, dbiWRITELOCK, pCfgDes, nil) = DBIERR_NONE) do
        begin
          n := StrPas(pCfgDes^.szNodeName);
          v := StrPas(pCfgDes^.szValue);
          if n = 'NET DIR' then
            FNetFileDir := v
          else if n = 'LANGDRIVER' then
            FParadoxLangDriver := v;
        end;
        if (h <> nil) then
          DbiCloseCursor(h);
        Check(DbiOpenCfgInfoList(nil, dbiREADWRITE, cfgPersistent,
          '\DRIVERS\PARADOX\TABLE CREATE', h));
        FillChar(pCfgDes^, sizeof(CFGDesc), #0);
        while (DbiGetNextRecord(h, dbiWRITELOCK, pCfgDes, nil) = DBIERR_NONE) do
        begin
          n := StrPas(pCfgDes^.szNodeName);
          v := StrPas(pCfgDes^.szValue);
          if n = 'LEVEL' then
            FTableLevel := v
          else if n = 'BLOCK SIZE' then
            FBlockSize := StrToInt(v)
          else if n = 'STRICTINTEGRITY' then
            FStrictIntegrity := StrToBoolean(v);
        end;
      finally
        FreeMem(pCfgDes, sizeof(CFGDesc));
        if (h <> nil) then
          DbiCloseCursor(h);
      end;
    end;
     
    procedure TBDEConfig.SetLocalShare(Value: Boolean);
    begin
      UpdateCfgFile('\SYSTEM\INIT', 'LOCAL SHARE', BooleanToStr(Value));
      FLocalShare := Value;
    end;
     
    procedure TBDEConfig.SetMinBufSize(Value: Integer);
    begin
      UpdateCfgFile('\SYSTEM\INIT', 'MINBUFSIZE', IntToStr(Value));
      FMinBufSize := Value;
    end;
     
    procedure TBDEConfig.SetMaxBufSize(Value: Integer);
    begin
      UpdateCfgFile('\SYSTEM\INIT', 'MAXBUFSIZE', IntToStr(Value));
      FMaxBufSize := Value;
    end;
     
    procedure TBDEConfig.SetSystemLangDriver(Value: string);
    begin
      UpdateCfgFile('\SYSTEM\INIT', 'LANGDRIVER', Value);
      FSystemLangDriver := Value;
    end;
     
    procedure TBDEConfig.SetParadoxLangDriver(Value: string);
    begin
      UpdateCfgFile('\DRIVERS\PARADOX\INIT', 'LANGDRIVER', Value);
      FParadoxLangDriver := Value;
    end;
     
    procedure TBDEConfig.SetMaxFileHandles(Value: Integer);
    begin
      UpdateCfgFile('\SYSTEM\INIT', 'MAXFILEHANDLES', IntToStr(Value));
      FMaxFileHandles := Value;
    end;
     
    procedure TBDEConfig.SetNetFileDir(Value: string);
    begin
      UpdateCfgFile('\DRIVERS\PARADOX\INIT', 'NET DIR', Value);
      FNetFileDir := Value;
    end;
     
    procedure TBDEConfig.SetTableLevel(Value: string);
    begin
      UpdateCfgFile('\DRIVERS\PARADOX\TABLE CREATE', 'LEVEL', Value);
      FTableLevel := Value;
    end;
     
    procedure TBDEConfig.SetBlockSize(Value: Integer);
    begin
      UpdateCfgFile('\DRIVERS\PARADOX\TABLE CREATE', 'BLOCK SIZE', IntToStr(Value));
      FBlockSize := Value;
    end;
     
    procedure TBDEConfig.SetStrictIntegrity(Value: Boolean);
    begin
      UpdateCfgFile('\DRIVERS\PARADOX\TABLE CREATE', 'STRICTINTEGRITY',
        BooleanToStr(Value));
      FStrictIntegrity := Value;
    end;
     
    procedure TBDEConfig.SetDefaultDriver(Value: string);
    begin
      UpdateCfgFile('\SYSTEM\INIT', 'DEFAULT DRIVER', Value);
      FDefaultDriver := Value;
    end;
     
    procedure TBDEConfig.SetAutoODBC(Value: Boolean);
    begin
      UpdateCfgFile('\SYSTEM\INIT', 'AUTO ODBC', BooleanToStr(Value));
      FAutoODBC := Value;
    end;
     
    procedure TBDEConfig.UpdateCFGFile;
    var
      h: hDbiCur;
      pCfgDes: pCFGDesc;
      pPath: array[0..127] of char;
    begin
      StrPCopy(pPath, Path);
      Check(DbiOpenCfgInfoList(nil, dbiREADWRITE, cfgPersistent, pPath, h));
      GetMem(pCfgDes, sizeof(CFGDesc));
      try
        FillChar(pCfgDes^, sizeof(CFGDesc), #0);
        while (DbiGetNextRecord(h, dbiWRITELOCK, pCfgDes, nil) = DBIERR_NONE) do
        begin
          if StrPas(pCfgDes^.szNodeName) = item then
          begin
            StrPCopy(pCfgDes^.szValue, value);
            Check(DbiModifyRecord(h, pCfgDes, True));
          end;
        end;
      finally
        FreeMem(pCfgDes, sizeof(CFGDesc));
        if (h <> nil) then
          DbiCloseCursor(h);
      end;
    end;
     
    constructor TBDEConfig.Create(AOwner: TComponent);
    begin
      inherited Create(AOwner);
      Init;
    end;
     
    destructor TBDEConfig.Destroy;
    begin
      inherited Destroy;
    end;
     
    end.

------------------------------------------------------------------------

Вариант 2.

Problem/Question/Abstract:

>How can my program access the idapi.cfg file and probably change its
>INIT (Local Share etc.) section?

**Answer:**

For 32bit only. You can of course use the registry to determine the
default CFG File instead of passing it as a parameter here:

    procedure ModifyCFG(const ACFGFile, AValue, AEntry, ACFGPath: string; SaveAsWin31:
      bool);
    var
      hCfg: hDBICfg;
      pRecBuf, pTmpRec: pByte;
      pFields: pFLDDesc;
      Count: word;
      i: integer;
      Save: boolean;
      Reg: TRegistry;
    const
      RegSaveWIN31: array[bool] of string = ('WIN32', 'WIN31');
    begin
      hCfg := nil;
      pFields := nil;
      pRecBuf := nil;
      Save := False;
      Check(DbiOpenConfigFile(PChar(ACFGFile), False, hCfg));
      try
        Check(DbiCfgPosition(hCfg, PChar(ACfgPath))); {neccessary...?}
        Check(DbiCfgGetRecord(hCfg, PChar(ACfgPath), Count, nil, nil));
        pRecBuf := AllocMem(succ(Count) * 128); {128 additional safety...}
        pFields := AllocMem(Count * sizeof(FLDDesc));
        Check(DbiCfgGetRecord(hCfg, PChar(ACfgPath), Count, pFields, pRecBuf));
        for i := 1 to Count do
        begin
          if StrPas(pFields^.szName) = AEntry then
          begin
            pTmpRec := pRecBuf;
            Inc(pTmpRec, 128 * (i - 1));
            StrPCopy(PChar(pTmpRec), AValue);
          end;
          inc(pFields);
        end;
        dec(pFields, Count);
        Check(DbiCfgModifyRecord(hCfg, PChar(ACfgPath), Count, pFields, pRecBuf));
        Save := True;
      finally
        if hCfg <> nil then
          Check(DbiCloseConfigFile(hCfg, Save, True, SaveAsWin31));
        if pRecBuf <> nil then
          FreeMem(pRecBuf, succ(Count) * 128);
        if pFields <> nil then
          FreeMem(pFields, Count * sizeof(FLDDesc));
      end;
      {update registry SAVECONFIG value}
      Reg := TRegistry.Create;
      try
        Reg.RootKey := HKEY_LOCAL_MACHINE;
        if not Reg.OpenKey('SOFTWARE\Borland\Database Engine', False) then
          ShowMessage('Configuration Path not found')
        else
        begin
          Reg.LazyWrite := False;
          Reg.WriteString('SAVECONFIG', RegSaveWIN31[SaveAsWin31]);
          Reg.CloseKey;
        end;
      finally
        Reg.Free;
      end;
      {DbiExit/Init to re-read cfg... make absolutely sure there are no active 
            DB components when doing this (it's is best done by a loader app)}
      Session.Close;
      Session.Open;
    end;

ACFGPath would be '\SYSTEM\INIT\', AEntry would be 'LOCAL SHARE'
und AValue would be 'TRUE' or 'FALSE'.

Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
