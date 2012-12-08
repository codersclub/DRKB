---
Title: Как перевести компьютер в Stend by или Hibernate?
Date: 01.01.2007
---


Как перевести компьютер в Stend by или Hibernate?
=================================================

::: {.date}
01.01.2007
:::

    {
      The SetSuspendState function suspends the system by shutting power down.
      Depending on the Hibernate parameter,
      the system either enters a suspend (sleep) state or hibernation.
     
      Syntax:
    }
     
     function SetSuspendState(
       Hibernate: Boolean,
       ForceCritical: Boolean,
       DisableWakeEvent: Boolean);
     
     
    {  Parameters:
     
       Hibernate: If this parameter is TRUE, the system hibernates.
                  If the parameter is FALSE, the system is suspended.
       ForceCritical: If this parameter is TRUE, the system suspends operation immediately;
                      if it is FALSE, the system broadcasts a PBT_APMQUERYSUSPEND event to
                      each application to request permission to suspend operation.
       DisableWakeEvent: If this parameter is TRUE, the system disables all wake events.
                         If the parameter is FALSE, any system wake events remain enabled.
     
     
      Windows NT/2000/XP: Included in Windows 2000 and later.
      Windows 95/98/Me: Included in Windows 98 and later.
    }
     
    var
      _SetSuspendState: function (Hibernate, ForceCritical, DisableWakeEvent: BOOL): BOOL
      stdcall = nil;
     
      function LinkAPI(const module, functionname: string): Pointer; forward;
     
    function SetSuspendState(Hibernate, ForceCritical,
      DisableWakeEvent: Boolean): Boolean;
    begin
      if not Assigned(_SetSuspendState) then
        @_SetSuspendState := LinkAPI('POWRPROF.dll', 'SetSuspendState');
      if Assigned(_SetSuspendState) then
        Result := _SetSuspendState(Hibernate, ForceCritical,
          DisableWakeEvent)
      else
        Result := False;
    end;
     
    function LinkAPI(const module, functionname: string): Pointer;
    var
      hLib: HMODULE;
    begin
      hLib := GetModulehandle(PChar(module));
      if hLib = 0 then
        hLib := LoadLibrary(PChar(module));
      if hLib <> 0 then
        Result := getProcAddress(hLib, PChar(functionname))
      else
        Result := nil;
    end;
     
    // Example Call:
    // Beispielaufruf:
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      SetSuspendState(True, False, False);
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>

------------------------------------------------------------------------

    procedure TForm1.Button1Click(Sender: TObject);
     begin
       SendMessage(Handle, WM_SYSCOMMAND, SC_SCREENSAVE, 1);
     end

Взято с сайта: <https://www.swissdelphicenter.ch>
