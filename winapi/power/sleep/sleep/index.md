---
Title: Приостановить компьютер (Sleep)
Date: 01.01.2007
---

Приостановить компьютер (Sleep)
===============================

Вариант 1:

Author: Даниил Карапетян (delphi4all@narod.ru)

У компьютеров ATX есть функция Sleep. Эта программа заставляет компьютер
"заснуть".

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      SetSystemPowerState(true, true);
    end;

Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)

------------------------------------------------------------------------
Вариант 2:

Author: DeMoN-777, DeMoN-777@yandex.ru

Date: 21.09.2002

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Переход в Спящий режим (WinNT)
     
    Зависимости: Windows, system
    Автор:       DeMoN-777, DeMoN-777@yandex.ru, ICQ:169281983, Санкт-Петербург
    Copyright:   @
    Дата:        21 сентября 2002 г.
    ***************************************************** }
     
    procedure NTSleep;
    var
      hToken: THandle;
      tkp: TTokenPrivileges;
      ReturnLength: Cardinal;
    begin
      if OpenProcessToken(GetCurrentProcess(), TOKEN_ADJUST_PRIVILEGES or
        TOKEN_QUERY, hToken) then
      begin
        LookupPrivilegeValue(nil, 'SeShutdownPrivilege', tkp.Privileges[0].Luid);
        tkp.PrivilegeCount := 1; // one privelege to set
        tkp.Privileges[0].Attributes := SE_PRIVILEGE_ENABLED;
        if AdjustTokenPrivileges(hToken, False, tkp, 0, nil, ReturnLength) then
          SetSystemPowerState(true, true);
      end;
    end;
