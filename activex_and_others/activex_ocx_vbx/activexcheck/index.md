---
Title: Как узнать, установлен ли ActiveX на машине?
Author: 
Date: 01.01.2007
Keywords: 
Description: 
---

Как узнать, установлен ли ActiveX на машине?
============================================

::: {.date}
01.01.2007
:::

Вариант 1:

    { ... }
    var
      strOLE: string;
    begin
      strOLE = "YourCOMServer.Application" {your ProgID}
      if (CLSIDFromProgID(PWideChar(WideString(strOLE), ClassID) = S_OK) then
        begin
          { //ActiveX установлен ... }
        end;
    end;

------------------------------------------------------------------------
Вариант 2:

    { ... }
    const
      cKEY = '\SOFTWARE\Classes\CLSID\%s\InprocServer32'
      var
      sKey: string;
      sComServer: string;
      exists: boolean;
      Reg: TRegistry;
    begin
      Reg := TRegistry.Create;
      try
        Reg.RootKey := HKEY_LOCAL_MACHINE;
        sKey := format(cKEY, [GuidToString(ClassID)]);
        if Reg.OpenKey(sKey, False) then
        begin
          sComServer := Reg.ReadString('');
          if FileExists(sComServer) then
          begin
            { //ActiveX установлен ... }
          end;
        end;
      finally
        Reg.free;
      end;
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
