---
Title: Синхронизация завершения работы Windows
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Синхронизация завершения работы Windows
=======================================

    { 
    Works only on Windows NT/2000/XP systems 
    }
     
     function TimedShutDown(Computer: string; Msg: string; Time: Word; Force: Boolean; Reboot: Boolean): Boolean;
     var
       rl: Cardinal;
       hToken: Cardinal;
       tkp: TOKEN_PRIVILEGES;
     begin
       //get user privileges to shutdown the machine, we are talking about win nt and 2k here 
       if not OpenProcessToken(GetCurrentProcess, TOKEN_ADJUST_PRIVILEGES or TOKEN_QUERY, hToken) then
         ShowMessage('Cannot open process token.')
       else
       begin
         if LookupPrivilegeValue(nil, 'SeShutdownPrivilege', tkp.Privileges[0].Luid) then
         begin
           tkp.Privileges[0].Attributes := SE_PRIVILEGE_ENABLED;
           tkp.PrivilegeCount := 1;
           AdjustTokenPrivileges(hToken, False, tkp, 0, nil, rl);
           if GetLastError <> ERROR_SUCCESS then
            ShowMessage('Error adjusting process privileges.');
         end
       else
         ShowMessage('Cannot find privilege value.');
       end;
     
       Result := InitiateSystemShutdown(PChar(Computer), PChar(Msg), Time, Force, Reboot)
     end;
     
     //Start shut down 
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       if not TimedShutDown('\\computername', 'you have to shutdown', 30, true, true) then
         ShowMessage('function failed...');
     end;
     
     //Abort shut down 
     procedure TForm1.Button2Click(Sender: TObject);
     begin
       AbortSystemShutdown('\\computername');
     end;

