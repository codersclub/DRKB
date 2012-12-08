---
Title: Установка / снятие Debug привелегии у текущего процесса
Date: 01.01.2007
---

Установка / снятие Debug привелегии у текущего процесса
=======================================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Установка/снятие Debug привелегии у текущего процесса
     
    Функция устанавливает/снимает отладочные привелегии у 
    текущего процесса (можно выбрать и другой, изменив 
    GetCurrentProcess на нужный Handle ).
     
    Актуально для совместного использования с ToolHelp - т.е. получения информации о процессах.
     
    Зависимости: Windows
    Автор:       Мироводин Дмитрий (адаптация), mirovodin@mail.ru
    Copyright:   2000 Jeffrey Richter
    Дата:        20 октября 2003 г.
    ********************************************** }
     
    Function EnableDebugPrivilege(Const Value: Boolean): Boolean;
    Const
      SE_DEBUG_NAME = 'SeDebugPrivilege';
    Var
      hToken : THandle;
      tp : TOKEN_PRIVILEGES;
      d : DWORD;
    Begin
      Result := False;
      If OpenProcessToken(GetCurrentProcess(), TOKEN_ADJUST_PRIVILEGES, hToken) Then
        Begin
          tp.PrivilegeCount := 1;
          LookupPrivilegeValue(Nil, SE_DEBUG_NAME, tp.Privileges[0].Luid);
          If Value Then
            tp.Privileges[0].Attributes := $00000002
          Else
            tp.Privileges[0].Attributes := $80000000;
          AdjustTokenPrivileges(hToken, False, tp, SizeOf(TOKEN_PRIVILEGES), Nil, d);
          If GetLastError = ERROR_SUCCESS Then
            Begin
              Result := True;
            End;
          CloseHandle(hToken);
        End;
    End; 

Пример использования:

    // После этого можно смотреть информация о таких системных модулях как: 
    //winlogon.exe и servises.exe и д.р.
    EnableDebugPrivilege(True); // вкрючить
     
    EnableDebugPrivilege(False); // выключить 
