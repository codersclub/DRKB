---
Title: Как выключить компьютер с любой версией Windows?
Date: 01.01.2007
---

Как выключить компьютер с любой версией Windows?
=========================================

::: {.date}
01.01.2007
:::


    function GetWinVersion: String;
    var 
      VersionInfo : TOSVersionInfo;
      OSName      : String;
    begin 
      // устанавливаем размер записи
      VersionInfo.dwOSVersionInfoSize := SizeOf( TOSVersionInfo );
     
      if Windows.GetVersionEx( VersionInfo ) then 
         begin 
            with VersionInfo do 
            begin 
               case dwPlatformId of 
                  VER_PLATFORM_WIN32s   : OSName := 'Win32s';
                  VER_PLATFORM_WIN32_WINDOWS : OSName := 'Windows 95';
                  VER_PLATFORM_WIN32_NT      : OSName := 'Windows NT';
               end; // case dwPlatformId
               Result := OSName + ' Version ' + IntToStr( dwMajorVersion ) + '.' + IntToStr( dwMinorVersion ) +
                         #13#10' (Build ' + IntToStr( dwBuildNumber ) + ': ' + szCSDVersion + ')';
            end; // with VersionInfo
         end // if GetVersionEx
      else 
         Result := '';
    end;
     
    procedure ShutDown;
    const 
      SE_SHUTDOWN_NAME = 'SeShutdownPrivilege';   // Borland forgot this declaration
    var 
      hToken       : THandle;
      tkp          : TTokenPrivileges;
      tkpo         : TTokenPrivileges;
      zero         : DWORD;
    begin 
      if Pos( 'Windows NT', GetWinVersion) = 1 then // we've got to do a whole buch of things
         begin 
            zero := 0;
            if not OpenProcessToken( GetCurrentProcess(), TOKEN_ADJUST_PRIVILEGES or TOKEN_QUERY, hToken) then 
               begin 
                 MessageBox( 0, 'Exit Error', 'OpenProcessToken() Failed', MB_OK );
                 Exit;
               end; // if not OpenProcessToken( GetCurrentProcess(), TOKEN_ADJUST_PRIVILEGES or TOKEN_QUERY, hToken)
            if not OpenProcessToken( GetCurrentProcess(), TOKEN_ADJUST_PRIVILEGES or TOKEN_QUERY, hToken) then 
               begin 
                 MessageBox( 0, 'Exit Error', 'OpenProcessToken() Failed', MB_OK );
                 Exit;
               end; // if not OpenProcessToken( GetCurrentProcess(), TOKEN_ADJUST_PRIVILEGES or TOKEN_QUERY, hToken)
      
      
            // SE_SHUTDOWN_NAME
            if not LookupPrivilegeValue( nil, 'SeShutdownPrivilege', tkp.Privileges[ 0 ].Luid ) then 
               begin 
                  MessageBox( 0, 'Exit Error', 'LookupPrivilegeValue() Failed', MB_OK );
                  Exit;
               end; // if not LookupPrivilegeValue( nil, 'SeShutdownPrivilege', tkp.Privileges[0].Luid )
            tkp.PrivilegeCount := 1;
            tkp.Privileges[ 0 ].Attributes := SE_PRIVILEGE_ENABLED;
      
            AdjustTokenPrivileges( hToken, False, tkp, SizeOf( TTokenPrivileges ), tkpo, zero );
            if Boolean( GetLastError() ) then 
               begin 
                  MessageBox( 0, 'Exit Error', 'AdjustTokenPrivileges() Failed', MB_OK );
                  Exit;
               end // if Boolean( GetLastError() )
            else 
               ExitWindowsEx( EWX_FORCE or EWX_SHUTDOWN, 0 );
          end // if OSVersion = 'Windows NT'
      else 
         begin // just shut the machine down
           ExitWindowsEx( EWX_FORCE or EWX_SHUTDOWN, 0 );
         end; // else
    end;

©Drkb::01682

Взято из [http://forum.sources.ru](http://forum.sources.ru) (.weblink target=weblink)

---

exitkernel очень радикальный способ потому что не сохраняются настройки рабочего стола, ini файлы и другие установки, зато быстро 

Есть способ намного лучше: ф-ия SHExitWindowsEx из shell32.dll,
С неё всё good. Это запуск из-под WinExec()

Программно же только с получением привелегии.

Замечу также что флаг EWX_FORCE необходим только для принудительного завершения при выдаче каких либо сообщений или модальных окон, что воспрепятствует завершению, например, "К компьютеру подключены пользователи. Данные могут быть утярены. Вы хотите завершить работу?" или сообщение, которое автор указал в вопросе.

Если нет таких сообщений EWX_FORCE не обязателен. Также есть отдельные флаги для выключение компьютера (по умолчанию - перезагрузка) или завершения сетевого сеанса. 

©Drkb::01683

Автор: Song

Взято с Vingrad.ru [http://forum.vingrad.ru](http://forum.vingrad.ru) (.weblink target=weblink)

------

```delphi
function MyExitWindows(RebootParam: Longword): Boolean;
var 
  TTokenHd: THandle;
  TTokenPvg: TTokenPrivileges;
  cbtpPrevious: DWORD;
  rTTokenPvg: TTokenPrivileges;
  pcbtpPreviousRequired: DWORD;
  tpResult: Boolean;
const 
  SE_SHUTDOWN_NAME = 'SeShutdownPrivilege';
begin 
  if Win32Platform = VER_PLATFORM_WIN32_NT then 
  begin 
     tpResult := OpenProcessToken(GetCurrentProcess(),
                                  TOKEN_ADJUST_PRIVILEGES or TOKEN_QUERY,
                                  TTokenHd);
     if tpResult then 
     begin 
       tpResult := LookupPrivilegeValue(nil,
                                        SE_SHUTDOWN_NAME,
                                        TTokenPvg.Privileges[0].Luid);
       TTokenPvg.PrivilegeCount := 1;
       TTokenPvg.Privileges[0].Attributes := SE_PRIVILEGE_ENABLED;
       cbtpPrevious := SizeOf(rTTokenPvg);
       pcbtpPreviousRequired := 0;
       if tpResult then 
         Windows.AdjustTokenPrivileges(TTokenHd,
                                       False,
                                       TTokenPvg,
                                       cbtpPrevious,
                                       rTTokenPvg,
                                       pcbtpPreviousRequired);
     end;
  end;
  Result := ExitWindowsEx(RebootParam, 0);
end;
 
// Example to shutdown Windows:
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  MyExitWindows(EWX_POWEROFF or EWX_FORCE);
end;
 
// Example to reboot Windows:
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  MyExitWindows(EWX_REBOOT or EWX_FORCE);
end;
 
 
// Parameters for MyExitWindows()
```

Drkb::01684

[http://delphiworld.narod.ru/](http://delphiworld.narod.ru/) (.weblink target=weblink)

DelphiWorld 6.0

------

```delphi
program Shutdown;

{$APPTYPE CONSOLE}
 
uses 
  SysUtils,
  Windows;
 
// Shutdown Program
// (c) 2000 NeuralAbyss Software
// www.neuralabyss.com
 
var 
  logoff: Boolean = False;
  reboot: Boolean = False;
  warn: Boolean = False;
  downQuick: Boolean = False;
  cancelShutdown: Boolean = False;
  powerOff: Boolean = False;
  timeDelay: Integer = 0;
 
function HasParam(Opt: Char): Boolean;
var 
  x: Integer;
begin 
  Result := False;
  for x := 1 to ParamCount do 
     if (ParamStr(x) = '-' + opt) or (ParamStr(x) = '/' + opt) then Result := True;
end;
 
function GetErrorstring: string;
var 
  lz: Cardinal;
  err: array[0..512] of Char;
begin 
  lz := GetLastError;
  FormatMessage(FORMAT_MESSAGE_FROM_SYSTEM, nil, lz, 0, @err, 512, nil);
  Result := string(err);
end;
 
procedure DoShutdown;
var 
  rl, flgs: Cardinal;
  hToken: Cardinal;
  tkp: TOKEN_PRIVILEGES;
begin 
  flgs := 0;
  if downQuick then flgs := flgs or EWX_FORCE;
  if not reboot then flgs := flgs or EWX_SHUTDOWN;
  if reboot then flgs := flgs or EWX_REBOOT;
  if poweroff and (not reboot) then flgs := flgs or EWX_POWEROFF;
  if logoff then flgs := (flgs and (not (EWX_REBOOT or EWX_SHUTDOWN or EWX_POWEROFF))) or 
       EWX_LOGOFF;
  if Win32Platform = VER_PLATFORM_WIN32_NT then 
  begin 
    if not OpenProcessToken(GetCurrentProcess, TOKEN_ADJUST_PRIVILEGES or TOKEN_QUERY,
      hToken) then 
      Writeln('Cannot open process token. [' + GetErrorstring + ']')
    else 
    begin 
      if LookupPrivilegeValue(nil, 'SeShutdownPrivilege', tkp.Privileges[0].Luid) then 
      begin 
        tkp.Privileges[0].Attributes := SE_PRIVILEGE_ENABLED;
        tkp.PrivilegeCount           := 1;
        AdjustTokenPrivileges(hToken, False, tkp, 0, nil, rl);
        if GetLastError <> ERROR_SUCCESS then 
          Writeln('Error adjusting process privileges.');
      end 
      else 
        Writeln('Cannot find privilege value. [' + GetErrorstring + ']');
    end;
    {   if CancelShutdown then
          if AbortSystemShutdown(nil) = False then
            Writeln('Cannot abort. [' + GetErrorstring + ']')
          else
           Writeln('Cancelled.')
       else
       begin
         if InitiateSystemShutdown(nil, nil, timeDelay, downQuick, Reboot) = False then
            Writeln('Cannot go down. [' + GetErrorstring + ']')
         else
            Writeln('Shutting down!');
       end;
    } 
  end;
  //     else begin
  ExitWindowsEx(flgs, 0);
  //     end;
end;
 
begin 
  Writeln('Shutdown v0.3 for Win32 (similar to the Linux version)');
  Writeln('(c) 2000 NeuralAbyss Software. All Rights Reserved.');
  if HasParam('?') or (ParamCount = 0) then 
  begin 
     Writeln('Usage:    shutdown [-akrhfnc] [-t secs]');
     Writeln('                  -k:      dont really shutdown, only warn.');
     Writeln('                  -r:      reboot after shutdown.');
     Writeln('                  -h:      halt after shutdown.');
     Writeln('                  -p:      power off after shutdown');
     Writeln('                  -l:      log off only');
     Writeln('                  -n:      kill apps that dont want to die.');
     Writeln('                  -c:      cancel a running shutdown.');
  end 
  else 
  begin 
     if HasParam('k') then warn := True;
     if HasParam('r') then reboot := True;
     if HasParam('h') and reboot then 
     begin 
       Writeln('Error: Cannot specify -r and -h parameters together!');
       Exit;
     end;
     if HasParam('h') then reboot := False;
     if HasParam('n') then downQuick := True;
     if HasParam('c') then cancelShutdown := True;
     if HasParam('p') then powerOff := True;
     if HasParam('l') then logoff := True;
     DoShutdown;
  end;
end.
```

©Drkb::01685

[http://delphiworld.narod.ru/](http://delphiworld.narod.ru/){.weblink target=_blank}

DelphiWorld 6.0
