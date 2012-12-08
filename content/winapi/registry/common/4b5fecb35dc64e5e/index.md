---
Title: Запись строки в реестр без использования класса TRegistry
Date: 01.01.2007
---

Запись строки в реестр без использования класса TRegistry
=========================================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Запись строки в реестр без использования класса TRegistry
     
    Функция записывает в реестр информацию в виде строки.
     
    Входные параметры:
    RootKey - идентификатор корневого раздела реестра, например
    HKEY_CLASSES_ROOT, HKEY_CURRENT_USER, HKEY_LOCAL_MACHINE и т.д.
     
    Key - имя раздела реестра, если он не существует, то автоматически
    создаётся
     
    Name - имя параметра, для записи параметра "По умолчанию" ("Default"),
    эта строка должна быть пустой
     
    Value - значение параметра
     
    В случае успеха функция возвращает True, или False при возникновении
    ошибки записи в реестр
     
    Зависимости: Windows
    Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
    Copyright:   Dimka Maslov
    Дата:        13 мая 2002 г.
    ***************************************************** }
     
    function RegWriteStr(RootKey: HKEY; Key, Name, Value: string): Boolean;
    var
      Handle: HKEY;
      Res: LongInt;
    begin
      Result := False;
      Res := RegCreateKeyEx(RootKey, PChar(Key), 0, nil, REG_OPTION_NON_VOLATILE,
        KEY_ALL_ACCESS, nil, Handle, nil);
      if Res <> ERROR_SUCCESS then
        Exit;
      Res := RegSetValueEx(Handle, PChar(Name), 0, REG_SZ, PChar(Value),
        Length(Value) + 1);
      Result := Res = ERROR_SUCCESS;
      RegCloseKey(Handle);
    end;
