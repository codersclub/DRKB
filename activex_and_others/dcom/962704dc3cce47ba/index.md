---
Title: Как узнать, доступен ли DCOM?
Date: 01.01.2007
---


Как узнать, доступен ли DCOM?
=============================

::: {.date}
01.01.2007
:::

    function IsDCOMEnabled: Boolean;
    var
      Ts: string;
      R: TRegistry;
    begin
      r := TRegistry.Create;
      r.RootKey := HKEY_LOCAL_MACHINE;
      r.OpenKey('Software\Microsoft\OLE', False);
      ts := AnsiUpperCase(R.ReadString('EnableDCOM'));
      r.Free;
      Result := (Ts = 'Y');
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>

------------------------------------------------------------------------

    function IsDCOMInstalled: Boolean;
    var
      OLE32: HModule;
    begin
      Result := not (IsWin95 or IsWin95OSR2);
      if not Result then
      begin
        OLE32 := LoadLibrary(COLE32DLL);
        if OLE32 > 0 then
        try
          Result := GetProcAddress(OLE32, PChar('CoCreateInstanceEx')) <> nil;
        finally
          FreeLibrary(OLE32);
        end;
      end;
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
