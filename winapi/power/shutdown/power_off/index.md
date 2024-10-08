---
Title: PowerOff
Date: 01.01.2003
---


PowerOff
========

Вариант 1:

Author: DeMoN-777, DeMoN-777@yandex.ru

Date: 21.06.2002

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Power off (Убивает процессы)
     
    Зависимости: Windows
    Автор:       DeMoN-777, DeMoN-777@yandex.ru, Санкт-Петербург
    Copyright:   @
    Дата:        21 июня 2002 г.
    ***************************************************** }
     
    procedure Shutdown2;
    var
      hToken: THandle;
      tkp: _TOKEN_PRIVILEGES;
      DUMMY: PTokenPrivileges;
      DummyRL: Cardinal;
    begin
      DUMMY := nil;
      if not OpenProcessToken(
        GetCurrentProcess(),
        TOKEN_ADJUST_PRIVILEGES or TOKEN_QUERY,
        hToken
        ) then
        raise TShutdownEx.Create('OpenProcessToken failed');
     
      if (not LookupPrivilegeValue(nil, 'SeShutdownPrivilege',
        tkp.Privileges[0].Luid)) then
        raise TShutdownEx.Create('LookupPrivilegeValue failed');
     
      tkp.PrivilegeCount := 1;
      tkp.Privileges[0].Attributes := $0002; //SE_PRIVILEGE_ENABLED = $00002
     
      AdjustTokenPrivileges(hToken, FALSE, tkp, 0, Dummy, DummyRL);
     
      if (GetLastError() <> ERROR_SUCCESS) then
        raise TShutdownEx.Create('AdjustTokenPrivileges failed');
     
      if (not ExitWindowsEx(EWX_SHUTDOWN or EWX_FORCE, 0)) then
        raise TShutdownEx.Create('ExitWindowsEx failed');
    end;


------------------------------------------------------------------------
Вариант 2:

Author: DeMoN-777, DeMoN-777@yandex.ru

Date: 21.06.2002

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Power off (не убивает процессы)
     
    Зависимости: Windows
    Автор:       DeMoN-777, DeMoN-777@yandex.ru, Санкт-Петербург
    Copyright:   @
    Дата:        21 июня 2002 г.
    ***************************************************** }
     
    procedure ExitWinNT(AShutdown: Boolean);
    var
      hToken: THandle;
      tkp: TTokenPrivileges;
      ReturnLength, What: Cardinal;
    begin
      if AShutdown then
        What := EWX_SHUTDOWN or EWX_POWEROFF
      else
        What := EWX_REBOOT;
      if OpenProcessToken(GetCurrentProcess(), TOKEN_ADJUST_PRIVILEGES or
        TOKEN_QUERY, hToken) then
      begin
        LookupPrivilegeValue(nil, 'SeShutdownPrivilege', tkp.Privileges[0].Luid);
        tkp.PrivilegeCount := 1;
        tkp.Privileges[0].Attributes := SE_PRIVILEGE_ENABLED;
        if AdjustTokenPrivileges(hToken, False, tkp, 0, nil, ReturnLength) then
          ExitWindowsEx(What, 0)
      end
    end;

Пример использования: 
     
    ExitWinNT(True); 


------------------------------------------------------------------------

Вариант 3:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Сегодня мы напишем прогу на WinApi, выключающую W2k, и занимающую всего
10 Кб!

    program reboot;
     
    uses
      Windows, messages;
     
    procedure RebootSystem;
    var
      handle_: THandle;
      n: DWORD;
      luid: TLargeInteger;
      priv: TOKEN_PRIVILEGES;
      ver: TOSVERSIONINFO;
    begin
      ver.dwOSVersionInfoSize := Sizeof(ver);
      GetVersionEx(ver);
      if ver.dwPlatformId=VER_PLATFORM_WIN32_NT then
      begin
        if OpenProcessToken(GetCurrentProcess, TOKEN_ADJUST_PRIVILEGES, handle_) then
          if LookupPrivilegeValue(nil, 'SeShutdownPrivilege', luid) then
          begin
            priv.PrivilegeCount := 1;
            priv.Privileges[0].Attributes := SE_PRIVILEGE_ENABLED;
            priv.Privileges[0].Luid := luid;
            AdjustTokenPrivileges(handle_, false, priv, 0, nil, n);
          end
          else
            writeln('Ошибка')
        else
          writeln('Ошибка ');
      end
      else
        writeln('Ошибка ');
      if not ExitWindowsEx(EWX_POWEROFF,1) then
        writeln('Ошибка');
    end;
     
    begin
      RebootSystem;
    end.


------------------------------------------------------------------------
Вариант 4:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    procedure NTShutdown;
    var
      TokenHandle: Cardinal;
      RetLength: Cardinal;
      TP: TTokenPrivileges;
    begin
      OpenProcessToken(GetCurrentProcess(), TOKEN_ADJUST_PRIVILEGES
        or TOKEN_QUERY, TokenHandle);
      if LookupPrivilegeValue(nil, 'SeShutdownPrivilege',
        TP.Privileges[0].Luid) then
      begin
        TP.PrivilegeCount := 1;
        TP.Privileges[0].Attributes := SE_PRIVILEGE_ENABLED;
        RetLength := 0;
        if AdjustTokenPrivileges(TokenHandle, FALSE, TP, 0, nil, RetLength) then
        begin
          if not SetProcessShutdownParameters($4FF, SHUTDOWN_NORETRY) then
          begin
            MessageBox(0, 'Shutdown failed', nil, MB_OK or MB_ICONSTOP);
          end
          else
          begin
            ExitWindowsEx(EWX_FORCE or EWX_SHUTDOWN, 0);
          end;
          exit;
        end;
      end;
      MessageBox(0, 'Access denied', nil, MB_OK or MB_ICONSTOP);
    end;


------------------------------------------------------------------------
Вариант 5:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Выключить монитор - это классно, но можно сделать ещё круче - программно
завершить работу компьютера. Выглядеть это будет примерно так, с
использованием различных режимов выключения:

    ExitWindowsEx(EWX_LOGOFF or ewx_force,0);

завершает работу всех запущенных в системе процессов, сохраняя данные
приложения, вызвавшего эту функцию

    ExitWindowsEx(EWX_SHUTDOWN or ewx_force,0);

останавливает работу системы в безопасный момент времени. Все буферы
очищаются с сохранением данных на диске, все процессы останавливаются

    ExitWindowsEx(EWX_REBOOT or ewx_force,0);

перезагрузка системы

    ExitWindowsEx(EWX_FORCE or ewx_force,0);

завершает работу всех запущенных в системе приложений, не посылая им
сообщения WM\_QUERYENDSESSION и WM\_ENDSESSIO. Это может вызвать потерю
не сохраненных данных

    ExitWindowsEx(EWX_POWEROFF or ewx_force,0);

завершает работу компьютера с выключением питания, если система
поддерживает автоуправление питанием

    ExitWindowsEx(EWX_FORCEIFHUNG or ewx_force,0);

завершает работу всех запущенных в системе приложений если система висит

Ещё вариант перезагрузки:

    mov  al,0F0h  
    out  64h,al


------------------------------------------------------------------------
Вариант 6:

Author: Vit

Source: Vingrad.ru <https://forum.vingrad.ru>

    ExitWindowsEx(EWX_FORCE,0);

или

Запуск из коммандной строки

    rundll32 krnl386.exe,exitkernel

только под XP все это работает плохо. Надо думать...

