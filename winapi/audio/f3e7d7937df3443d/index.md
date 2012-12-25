---
Title: Как определить, установлена ли звуковая карта?
Date: 01.01.2007
---


Как определить, установлена ли звуковая карта?
==============================================

::: {.date}
01.01.2007
:::

    { ... }
    if WaveOutGetNumDevs > 0 then
      ShowMessage('Wave-Device present')
    else
      ShowMessage('No Wave-Device present');
    { ... }

------------------------------------------------------------------------

    function IsSoundCardInstalled: Boolean;
    type
      SCFunc = function: UInt; stdcall;
    var
      LibInst: LongInt;
      EntryPoint: SCFunc;
    begin
      Result := False;
      LibInst := LoadLibrary(PChar('winmm.dll'));
      try
        if LibInst <> 0 then
        begin
          EntryPoint := GetProcAddress(LibInst, 'waveOutGetNumDevs');
          if (EntryPoint <> 0) then
            Result := True;
        end;
      finally
        if (LibInst <> 0) then
          FreeLibrary(LibInst);
      end;
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
