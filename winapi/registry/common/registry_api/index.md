---
Title: Как работать с реестром средствами API?
Author: i-s-v
Date: 01.01.2007
---

Как работать с реестром средствами API?
=======================================

::: {.date}
01.01.2007
:::

Создать подраздел в реестре:

RegCreateKey (Key:HKey; SubKey: PChar; var Result: HKey): Longint;

Key - указывает на \"корневой\" раздел реестра, в Delphi1 доступен
только один - HKEY\_CLASSES\_ROOT, а в Delphi3 - все.

SubKey - имя раздела - строится по принципу пути к файлу в DOS (пример
subkey1\\subkey2\\ \...). Если такой раздел уже существует, то он
открывается.

В любом случае при успешном вызове Result содержит Handle на раздел.

Об успешности вызова судят по возвращаемому значению, если
ERROR\_SUCCESS, то успешно, если иное - ошибка.

Открыть подраздел:

RegOpenKey(Key: HKey; SubKey: PChar; var Result: HKey): Longint;

Раздел Key

Подраздел SubKey

Возвращает Handle на подраздел в переменной Result. Если раздела с таким
именем нет, то он не создается.

Возврат - код ошибки или ERROR\_SUCCESS, если успешно.

Закрывает раздел:

RegCloseKey(Key: HKey): Longint;

Закрывает раздел, на который ссылается Key.

Возврат - код ошибки или ERROR\_SUCCESS, если успешно.

Удалить подраздел:

RegDeleteKey(Key: HKey; SubKey: PChar): Longint;

Удалить подраздел Key\\SubKey.

Возврат - код ошибки или ERROR\_SUCCESS, если нет ошибок.

Получить имена всех подразделов раздела Key:

RegEnumKey(Key:HKey; index: Longint; Buffer: PChar; cb: Longint):
Longint;

Key - Handle на открытый или созданный раздел

Buffer - указатель на буфер

cb - размер буфера

index - индекс, должен быть равен 0 при первом вызове RegEnumKey.
Типичное использование - в цикле While, где index увеличивается до тех
пор, пока очередной вызов RegEnumKey не завершится ошибкой

Возвращает текстовую строку, связанную с ключом Key\\SubKey:

RegQueryValue(Key: HKey; SubKey: PChar; Value: PChar; var cb: Longint):
Longint;

Ключ\\подключ Key\\SubKey.

Value - буфер для строки

cb - размер, на входе - размер буфера, на выходе - длина возвращаемой
строки.

Возврат - код ошибки.

Задать новое значение ключу Key\\SubKey:

RegSetValue(Key: HKey; SubKey: PChar; ValType: Longint; Value: PChar;
cb: Longint): Longint;

Ключ\\подключ Key\\SubKey.

ValType - тип задаваемой переменной,

Value - буфер для переменной

cb - размер буфера. В Windows 3.1 допустимо только Value=REG\_SZ.

Возврат - код ошибки или ERROR\_SUCCESS, если нет ошибок.

Удаляет значение lpValueName находящееся в ключе hKey:

RegDeleteValue(HKEY hKey, LPCTSTR lpValueName);

hKey - ключ. hKey должен был быть открыт с доступом KEY\_SET\_VALUE
процедурой RegOpenKey.

lpValueName - значение, находящееся в ключе hKey.

Возвращает ERROR\_SUCCESS если успешно.

Выдает список значений у ключа hKey:

LONG RegEnumValue( HKEY hKey, DWORD dwIndex, LPTSTR lpValueName, LPDWORD
lpcbValueName, LPDWORD lpReserved, LPDWORD lpType, LPBYTE lpData,
LPDWORD lpcbData);

hKey - ключ.

dwIndex - этот параметр должен быть 0 при первом вызове, а далее по
анологии с RegEnumKey (т.е. можно использовать в цикле),

lpValueName - буфер для названия значения

lpcbValueName - размер lpValueName

lpReserved должно быть всегда 0

lpType - буфер для названия типа (int)

lpData - буфер для данных

lpcbData-размер для lpData

Примечание:

При каждой новом вызове функции после предыдущего нужно заново
переназначить lpcbValueName.

lpcbValueName = sizeof(lpValueName)

Примеры:

    { Создаем список всех подразделов указанного раздела }
    procedure TForm1.Button1Click(Sender: TObject);
    var
      MyKey: HKey; { Handle для работы с разделом }
      Buffer: array[0 .. 1000] of char; { Буфер }
      Err, { Код ошибки }
      index: longint; { Индекс подраздела }
    begin
      Err := RegOpenKey(HKEY_CLASSES_ROOT, 'DelphiUnit', MyKey); { Открыли раздел }
      if Err <> ERROR_SUCCESS then
      begin
        MessageDlg('Нет такого раздела !!', mtError, [mbOk], 0);
        exit;
      end;
      index := 0;
      {Определили имя первого подраздела }
      Err := RegEnumKey(MyKey, index, Buffer, Sizeof(Buffer));
      while err = ERROR_SUCCESS do { Цикл, пока есть подразделы }
      begin
        memo1.lines.add(StrPas(Buffer)); { Добавим имя подраздела в список }
        inc(index); { Увеличим номер подраздела }
        Err := RegEnumKey(MyKey, index, Buffer, Sizeof(Buffer)); { Запрос }
      end;
      RegCloseKey(MyKey); { Закрыли подраздел }
    end;

Взято с <https://delphiworld.narod.ru>

------------------------------------------------------------------------

Реестр предназначен для хранения системных переменных и позволяет
зарегистрировать файлы программы, что обеспечивает их показ в проводнике
с соответствующей иконкой, вызов программы при щелчке на этом файле,
добавление ряда команд в меню, вызываемое при нажатии правой кнопки мыши
над файлом. Кроме того, в реестр можно внести некую свою информацию
(переменные, константы, данные о инсталлированной программы \...).
Программу можно добавить в список деинсталляции, что позволит удалить ее
из менеджера \"Установка/Удаление программ\" панели управления.

Для работы с реестром применяется ряд функций API :

RegCreateKey (Key: HKey; SubKey: PChar; var Result: HKey): Longint;

Создать подраздел в реестре. Key указывает на \"корневой\" раздел
реестра, в Delphi1 доступен только один - HKEY\_CLASSES\_ROOT, в в
Delphi3 - все. SubKey - имя раздела - строится по принципу пути к файлу
в DOS (пример subkey1\\subkey2\\ \...). Если такой раздел уже
существует, то он открывается (в любом случае при успешном вызове Result
содержит Handle на раздел). Об успешности вызова судят по возвращаемому
значению, если ERROR\_SUCCESS, то успешно, если иное - ошибка.

RegOpenKey(Key: HKey; SubKey: PChar; var Result: HKey): Longint;

Открыть подраздел Key\\SubKey и возвращает Handle на него в переменной
Result. Если раздела с таким именем нет, то он не создается. Возврат -
код ошибки или ERROR\_SUCCESS, если успешно.

RegCloseKey(Key: HKey): Longint;

Закрывает раздел, на который ссылается Key. Возврат - код ошибки или
ERROR\_SUCCESS, если успешно.

RegDeleteKey(Key: HKey; SubKey: PChar): Longint;

Удалить подраздел Key\\SubKey. Возврат - код ошибки или ERROR\_SUCCESS,
если нет ошибок.

RegEnumKey(Key: HKey; index: Longint; Buffer: PChar;cb: Longint):
Longint;

Получить имена всех подразделов раздела Key, где Key - Handle на
открытый или созданный раздел (см. RegCreateKey и RegOpenKey), Buffer -
указатель на буфер, cb - размер буфера, index - индекс, должен быть
равен 0 при первом вызове RegEnumKey. Типичное использование - в цикле
While, где index увеличивается до тех пор, пока очередной вызов
RegEnumKey не завершится ошибкой (см. пример).

RegQueryValue(Key: HKey; SubKey: PChar; Value: PChar; var cb: Longint):
Longint;

Возвращает текстовую строку, связанную с ключом Key\\SubKey.Value -
буфер для строки; cb- размер, на входе - размер буфера, на выходе -
длина возвращаемой строки. Возврат - код ошибки.

RegSetValue(Key: HKey; SubKey: PChar; ValType: Longint; Value: PChar;
cb: Longint): Longint;

Задать новое значение ключу Key\\SubKey, ValType - тип задаваемой
переменной, Value - буфер для переменной, cb - размер буфера. В Windows
3.1 допустимо только Value=REG\_SZ. Возврат - код ошибки или
ERROR\_SUCCESS, если нет ошибок.

Примеры :

    {  Создаем список всех подразделов указанного раздела }
    procedure TForm1.Button1Click(Sender: TObject);
    var
     MyKey        : HKey;        { Handle для работы с разделом }
     Buffer        : array[0..1000] of char; { Буфер }
     Err, { Код ошибки }
    index        : longint; { Индекс подраздела }
    begin
     Err:=RegOpenKey(HKEY_CLASSES_ROOT,'DelphiUnit',MyKey); { Открыли раздел }
     if Err<> ERROR_SUCCESS then 
      begin
        MessageDlg('Нет такого раздела !!',mtError,[mbOk],0);
        exit;
      end;
     index:=0;
     {Определили имя первого подраздела }
     Err:=RegEnumKey(MyKey,index,Buffer,Sizeof(Buffer)); 
     while err=ERROR_SUCCESS do { Цикл, пока есть подразделы }
      begin
        memo1.lines.add(StrPas(Buffer)); { Добавим имя подраздела в список }
        inc(index); { Увеличим номер подраздела }
        Err:=RegEnumKey(MyKey,index,Buffer,Sizeof(Buffer)); { Запрос }
      end;
     RegCloseKey(MyKey); { Закрыли подраздел }
    end;

Источник: <https://dmitry9.nm.ru/info/>

------------------------------------------------------------------------

Автор: i-s-v

    unit apiregistry;
     
    interface
     
    uses Windows;
     
    function RegSetString(RootKey: HKEY; Name: string; Value: string): boolean;
    function RegSetMultiString(RootKey: HKEY; Name: string; Value: string): boolean;
    function RegSetExpandString(RootKey: HKEY; Name: string; Value: string): boolean;
    function RegSetDWORD(RootKey: HKEY; Name: string; Value: Cardinal): boolean;
    function RegSetBinary(RootKey: HKEY; Name: string; Value: array of Byte): boolean;
    function RegGetString(RootKey: HKEY; Name: string; var Value: string): boolean;
    function RegGetMultiString(RootKey: HKEY; Name: string; var Value: string): boolean;
    function RegGetExpandString(RootKey: HKEY; Name: string; var Value: string): boolean;
    function RegGetDWORD(RootKey: HKEY; Name: string; var Value: Cardinal): boolean;
    function RegGetBinary(RootKey: HKEY; Name: string; var Value: string): boolean;
    function RegGetValueType(RootKey: HKEY; Name: string; var Value: Cardinal): boolean;
    function RegValueExists(RootKey: HKEY; Name: string): boolean;
    function RegKeyExists(RootKey: HKEY; Name: string): boolean;
    function RegDelValue(RootKey: HKEY; Name: string): boolean;
    function RegDelKey(RootKey: HKEY; Name: string): boolean;
    function RegConnect(MachineName: string; RootKey: HKEY; var RemoteKey: HKEY): boolean;
    function RegDisconnect(RemoteKey: HKEY): boolean;
    function RegEnumKeys(RootKey: HKEY; Name: string; var KeyList: string): boolean;
    function RegEnumValues(RootKey: HKEY; Name: string; var ValueList: string): boolean;
     
    implementation
     
    function LastPos(Needle: Char; Haystack: string): integer;
    begin
      for Result := Length(Haystack) downto 1 do
        if Haystack[Result] = Needle then
          Break;
    end;
     
    function RegConnect(MachineName: string; RootKey: HKEY; var RemoteKey: HKEY):
      boolean;
    begin
      Result := (RegConnectRegistry(PChar(MachineName), RootKey, RemoteKey) =
        ERROR_SUCCESS);
    end;
     
    function RegDisconnect(RemoteKey: HKEY): boolean;
    begin
      Result := (RegCloseKey(RemoteKey) = ERROR_SUCCESS);
    end;
     
    function RegSetValue(RootKey: HKEY; Name: string; ValType: Cardinal; PVal:
      Pointer; ValSize: Cardinal): boolean;
    var
      SubKey: string;
      n: integer;
      dispo: DWORD;
      hTemp: HKEY;
    begin
      Result := False;
      n := LastPos('\', Name);
      if n > 0 then
      begin
        SubKey := Copy(Name, 1, n - 1);
        if RegCreateKeyEx(RootKey, PChar(SubKey), 0, nil, REG_OPTION_NON_VOLATILE,
          KEY_WRITE,
          nil, hTemp, @dispo) = ERROR_SUCCESS then
        begin
          SubKey := Copy(Name, n + 1, Length(Name) - n);
          Result := (RegSetValueEx(hTemp, PChar(SubKey), 0, ValType, PVal, ValSize)
            = ERROR_SUCCESS);
          RegCloseKey(hTemp);
        end;
      end;
    end;
     
    function RegGetValue(RootKey: HKEY; Name: string; ValType: Cardinal; var PVal:
      Pointer;
      var ValSize: Cardinal): boolean;
    var
      SubKey: string;
      n: integer;
      MyValType: DWORD;
      hTemp: HKEY;
      Buf: Pointer;
      BufSize: Cardinal;
    begin
      Result := False;
      n := LastPos('\', Name);
      if n > 0 then
      begin
        SubKey := Copy(Name, 1, n - 1);
        if RegOpenKeyEx(RootKey, PChar(SubKey), 0, KEY_READ, hTemp) = ERROR_SUCCESS
          then
        begin
          SubKey := Copy(Name, n + 1, Length(Name) - n);
          if RegQueryValueEx(hTemp, PChar(SubKey), nil, @MyValType, nil, @BufSize) =
            ERROR_SUCCESS then
          begin
            GetMem(Buf, BufSize);
            if RegQueryValueEx(hTemp, PChar(SubKey), nil, @MyValType, Buf, @BufSize)
              = ERROR_SUCCESS then
            begin
              if ValType = MyValType then
              begin
                PVal := Buf;
                ValSize := BufSize;
                Result := True;
              end
              else
              begin
                FreeMem(Buf);
              end;
            end
            else
            begin
              FreeMem(Buf);
            end;
          end;
          RegCloseKey(hTemp);
        end;
      end;
    end;
     
    function RegSetString(RootKey: HKEY; Name: string; Value: string): boolean;
    begin
      Result := RegSetValue(RootKey, Name, REG_SZ, PChar(Value + #0), Length(Value)
        + 1);
    end;
     
    function RegSetMultiString(RootKey: HKEY; Name: string; Value: string): boolean;
    begin
      Result := RegSetValue(RootKey, Name, REG_MULTI_SZ, PChar(Value + #0#0),
      Length(Value) + 2);
    end;
     
    function RegSetExpandString(RootKey: HKEY; Name: string; Value: string):
      boolean;
    begin
      Result := RegSetValue(RootKey, Name, REG_EXPAND_SZ, PChar(Value + #0),
        Length(Value) + 1);
    end;
     
    function RegSetDword(RootKey: HKEY; Name: string; Value: Cardinal): boolean;
    begin
      Result := RegSetValue(RootKey, Name, REG_DWORD, @Value, SizeOf(Cardinal));
    end;
     
    function RegSetBinary(RootKey: HKEY; Name: string; Value: array of Byte):
      boolean;
    begin
      Result := RegSetValue(RootKey, Name, REG_BINARY, @Value[Low(Value)],
        length(Value));
    end;
     
    function RegGetString(RootKey: HKEY; Name: string; var Value: string): boolean;
    var
      Buf: Pointer;
      BufSize: Cardinal;
    begin
      Result := False;
      if RegGetValue(RootKey, Name, REG_SZ, Buf, BufSize) then
      begin
        Dec(BufSize);
        SetLength(Value, BufSize);
        if BufSize > 0 then
          CopyMemory(@Value[1], Buf, BufSize);
        FreeMem(Buf);
        Result := True;
      end;
    end;
     
    function RegGetMultiString(RootKey: HKEY; Name: string; var Value: string):
      boolean;
    var
      Buf: Pointer;
      BufSize: Cardinal;
    begin
      Result := False;
      if RegGetValue(RootKey, Name, REG_MULTI_SZ, Buf, BufSize) then
      begin
        Dec(BufSize);
        SetLength(Value, BufSize);
        if BufSize > 0 then
          CopyMemory(@Value[1], Buf, BufSize);
        FreeMem(Buf);
        Result := True;
      end;
    end;
     
    function RegGetExpandString(RootKey: HKEY; Name: string; var Value: string):
      boolean;
    var
      Buf: Pointer;
      BufSize: Cardinal;
    begin
      Result := False;
      if RegGetValue(RootKey, Name, REG_EXPAND_SZ, Buf, BufSize) then
      begin
        Dec(BufSize);
        SetLength(Value, BufSize);
        if BufSize > 0 then
          CopyMemory(@Value[1], Buf, BufSize);
        FreeMem(Buf);
        Result := True;
      end;
    end;
     
    function RegGetDWORD(RootKey: HKEY; Name: string; var Value: Cardinal): boolean;
    var
      Buf: Pointer;
      BufSize: Cardinal;
    begin
      Result := False;
      if RegGetValue(RootKey, Name, REG_DWORD, Buf, BufSize) then
      begin
        CopyMemory(@Value, Buf, BufSize);
        FreeMem(Buf);
        Result := True;
      end;
    end;
     
    function RegGetBinary(RootKey: HKEY; Name: string; var Value: string): boolean;
    var
      Buf: Pointer;
      BufSize: Cardinal;
    begin
      Result := False;
      if RegGetValue(RootKey, Name, REG_BINARY, Buf, BufSize) then
      begin
        SetLength(Value, BufSize);
        CopyMemory(@Value[1], Buf, BufSize);
        FreeMem(Buf);
        Result := True;
      end;
    end;
     
    function RegValueExists(RootKey: HKEY; Name: string): boolean;
    var
      SubKey: string;
      n: integer;
      hTemp: HKEY;
    begin
      Result := False;
      n := LastPos('\', Name);
      if n > 0 then
      begin
        SubKey := Copy(Name, 1, n - 1);
        if RegOpenKeyEx(RootKey, PChar(SubKey), 0, KEY_READ, hTemp) = ERROR_SUCCESS
          then
        begin
          SubKey := Copy(Name, n + 1, Length(Name) - n);
          Result := (RegQueryValueEx(hTemp, PChar(SubKey), nil, nil, nil, nil) =
            ERROR_SUCCESS);
          RegCloseKey(hTemp);
        end;
      end;
    end;
     
    function RegGetValueType(RootKey: HKEY; Name: string; var Value: Cardinal):
      boolean;
    var
      SubKey: string;
      n: integer;
      hTemp: HKEY;
      ValType: Cardinal;
    begin
      Result := False;
      Value := REG_NONE;
      n := LastPos('\', Name);
      if n > 0 then
      begin
        SubKey := Copy(Name, 1, n - 1);
        if (RegOpenKeyEx(RootKey, PChar(SubKey), 0, KEY_READ, hTemp) = ERROR_SUCCESS)
          then
        begin
          SubKey := Copy(Name, n + 1, Length(Name) - n);
          Result := (RegQueryValueEx(hTemp, PChar(SubKey), nil, @ValType, nil, nil)
            = ERROR_SUCCESS);
          if Result then
            Value := ValType;
          RegCloseKey(hTemp);
        end;
      end;
    end;
     
    function RegKeyExists(RootKey: HKEY; Name: string): boolean;
    var
      SubKey: string;
      n: integer;
      hTemp: HKEY;
    begin
      Result := False;
      n := LastPos('\', Name);
      if n > 0 then
      begin
        SubKey := Copy(Name, 1, n - 1);
        if RegOpenKeyEx(RootKey, PChar(SubKey), 0, KEY_READ, hTemp) = ERROR_SUCCESS
          then
        begin
          Result := True;
          RegCloseKey(hTemp);
        end;
      end;
    end;
     
    function RegDelValue(RootKey: HKEY; Name: string): boolean;
    var
      SubKey: string;
      n: integer;
      hTemp: HKEY;
    begin
      Result := False;
      n := LastPos('\', Name);
      if n > 0 then
      begin
        SubKey := Copy(Name, 1, n - 1);
        if RegOpenKeyEx(RootKey, PChar(SubKey), 0, KEY_WRITE, hTemp) = ERROR_SUCCESS
          then
        begin
          SubKey := Copy(Name, n + 1, Length(Name) - n);
          Result := (RegDeleteValue(hTemp, PChar(SubKey)) = ERROR_SUCCESS);
          RegCloseKey(hTemp);
        end;
      end;
    end;
     
    function RegDelKey(RootKey: HKEY; Name: string): boolean;
    var
      SubKey: string;
      n: integer;
      hTemp: HKEY;
    begin
      Result := False;
      n := LastPos('\', Name);
      if n > 0 then
      begin
        SubKey := Copy(Name, 1, n - 1);
        if RegOpenKeyEx(RootKey, PChar(SubKey), 0, KEY_WRITE, hTemp) = ERROR_SUCCESS
          then
        begin
          SubKey := Copy(Name, n + 1, Length(Name) - n);
          Result := (RegDeleteKey(hTemp, PChar(SubKey)) = ERROR_SUCCESS);
          RegCloseKey(hTemp);
        end;
      end;
    end;
     
    function RegEnum(RootKey: HKEY; Name: string; var ResultList: string; const
      DoKeys: Boolean): boolean;
    var
      i: integer;
      iRes: integer;
      s: string;
      hTemp: HKEY;
      Buf: Pointer;
      BufSize: Cardinal;
    begin
      Result := False;
      ResultList := '';
      if RegOpenKeyEx(RootKey, PChar(Name), 0, KEY_READ, hTemp) = ERROR_SUCCESS then
      begin
        Result := True;
        BufSize := 1024;
        GetMem(buf, BufSize);
        i := 0;
        iRes := ERROR_SUCCESS;
        while iRes = ERROR_SUCCESS do
        begin
          BufSize := 1024;
          if DoKeys then
            iRes := RegEnumKeyEx(hTemp, i, buf, BufSize, nil, nil, nil, nil)
          else
            iRes := RegEnumValue(hTemp, i, buf, BufSize, nil, nil, nil, nil);
          if iRes = ERROR_SUCCESS then
          begin
            SetLength(s, BufSize);
            CopyMemory(@s[1], buf, BufSize);
            if ResultList = '' then
              ResultList := s
            else
              ResultList := Concat(ResultList, #13#10,s);
           inc(i);
          end;
        end;
        FreeMem(buf);
        RegCloseKey(hTemp);
      end;
    end;
     
    function RegEnumValues(RootKey: HKEY; Name: string; var ValueList: string):
      boolean;
    begin
      Result := RegEnum(RootKey, Name, ValueList, False);
    end;
     
    function RegEnumKeys(RootKey: HKEY; Name: string; var KeyList: string): boolean;
    begin
      Result := RegEnum(RootKey, Name, KeyList, True);
    end;
     
    end.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
