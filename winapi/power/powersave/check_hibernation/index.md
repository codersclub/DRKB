---
Title: Поддерживает ли система Hibernation?
Date: 01.01.2007
---


Поддерживает ли система Hibernation?
====================================

::: {.date}
01.01.2007
:::

    function HibernateAllowed: Boolean;
    type
      TIsPwrHibernateAllowed = function: Boolean;
      stdcall;
    var
      hPowrprof: HMODULE;
      IsPwrHibernateAllowed: TIsPwrHibernateAllowed;
    begin
      Result := False;
      if IsNT4Or95 then Exit;
      hPowrprof := LoadLibrary('powrprof.dll');
      if hPowrprof <> 0 then
      begin
        try
          @IsPwrHibernateAllowed := GetProcAddress(hPowrprof, 'IsPwrHibernateAllowed');
          if @IsPwrHibernateAllowed <> nil then
          begin
            Result := IsPwrHibernateAllowed;
          end;
        finally
          FreeLibrary(hPowrprof);
        end;
      end;
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
