---
Title: Переход в ждущий режим под Windows NT
Author: DeMoN-777, DeMoN-777@yandex.ru
Date: 21.06.2002
---

Переход в ждущий режим под Windows NT
=====================================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Переход в ждущий режим под WinNT
     
    Зависимости: Windows
    Автор:       DeMoN-777, DeMoN-777@yandex.ru, Санкт-Петербург
    Copyright:   @
    Дата:        21 июня 2002 г.
    ***************************************************** }
     
    procedure NTWait;
    var
      hToken: THandle;
      tkp: TTokenPrivileges;
      ReturnLength: Cardinal;
    begin
      if OpenProcessToken(GetCurrentProcess(), TOKEN_ADJUST_PRIVILEGES or
        TOKEN_QUERY, hToken) then
      begin
        LookupPrivilegeValue(nil, 'SeShutdownPrivilege', tkp.Privileges[0].Luid);
        tkp.PrivilegeCount := 1;
        tkp.Privileges[0].Attributes := SE_PRIVILEGE_ENABLED;
        if AdjustTokenPrivileges(hToken, False, tkp, 0, nil, ReturnLength) then
          SetSystemPowerState(true, true);
      end;
    end;
