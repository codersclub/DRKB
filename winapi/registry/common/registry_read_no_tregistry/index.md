---
Title: Чтение строки из реестра без использования класса TRegistry
Author: Dimka Maslov, mainbox@endimus.ru
Date: 13.05.2002
---

Чтение строки из реестра без использования класса TRegistry
===========================================================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Чтение строки из реестра без использования класса TRegistry
     
    Входные параметры:
    RootKey - идентификатор корневого раздела реестра, например
    HKEY_CLASSES_ROOT, HKEY_CURRENT_USER, HKEY_LOCAL_MACHINE и т.д.
     
    Key - имя раздела реестра,
     
    Name - имя параметра, для чтения параметра "По умолчанию" ("Default"),
    эта строка должна быть пустой
     
    Success - (необязательный параметр) адрес логической переменной, в которую
    будет Тrue в случае успеха или False в случае ошибки.
     
    В случае успеха функция возвращает значение параметра, или
    пустую строку при возникновении ошибки чтения из реестра
     
    Зависимости: Windows
    Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
    Copyright:   Dimka Maslov
    Дата:        13 мая 2002 г.
    ***************************************************** }
     
    function RegQueryStr(RootKey: HKEY; Key, Name: string;
      Success: PBoolean = nil): string;
    var
      Handle: HKEY;
      Res: LongInt;
      DataType, DataSize: DWORD;
    begin
      if Assigned(Success) then
        Success^ := False;
      Res := RegOpenKeyEx(RootKey, PChar(Key), 0, KEY_QUERY_VALUE, Handle);
      if Res <> ERROR_SUCCESS then
        Exit;
      Res := RegQueryValueEx(Handle, PChar(Name), nil, @DataType, nil, @DataSize);
      if (Res <> ERROR_SUCCESS) or (DataType <> REG_SZ) then
      begin
        RegCloseKey(Handle);
        Exit;
      end;
      SetString(Result, nil, DataSize - 1);
      Res := RegQueryValueEx(Handle, PChar(Name), nil, @DataType,
        PByte(@Result[1]), @DataSize);
      if Assigned(Success) then
        Success^ := Res = ERROR_SUCCESS;
      RegCloseKey(Handle);
    end;

Пример использования: 
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      edit1.Text := RegQueryStr(HKEY_CLASSES_ROOT, 'AVIFile\shell\open\command', '');
    end;
