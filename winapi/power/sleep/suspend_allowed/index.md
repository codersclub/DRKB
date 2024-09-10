---
Title: Поддерживает ли система suspend?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---

Поддерживает ли система suspend?
================================

    function SuspendAllowed: Boolean;
    type
      TIsPwrSuspendAllowed = function: Boolean;
      stdcall;
    var
      hPowrprof: HMODULE;
      IsPwrSuspendAllowed: TIsPwrSuspendAllowed;
    begin
      Result := False;
      hPowrprof := LoadLibrary('powrprof.dll');
      if hPowrprof <> 0 then
      begin
        try
          @IsPwrSuspendAllowed := GetProcAddress(hPowrprof, 'IsPwrSuspendAllowed');
          if @IsPwrSuspendAllowed <> nil then
          begin
            Result := IsPwrSuspendAllowed;
          end;
        finally
          FreeLibrary(hPowrprof);
        end;
      end;
    end;

