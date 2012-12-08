---
Title: Определение версии системных DLL
Date: 01.01.2007
---


Определение версии системных DLL
================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Определение версии системных DLL
     
    Функция предназначена для определение версии системных DLL. Кодирование версии осуществляется вспомогательной функцией MakeVersion (см. код).
     
    Зависимости: Windows
    Автор:       Almaz, az_spb@mail.ru, Санкт-Петербург
    Copyright:   Собственное написание Almaz
    Дата:        12 мая 2002 г.
    ********************************************** }
     
    function MakeVersion(Major, Minor: Word): Integer; // Функция кодирование версии
    begin
      Result := MAKELONG(Minor, Major);
    end;
     
    function GetDllVersion(FileName: PChar): Integer;
    type
      TDllVersionInfo = packed record
        cbSize: DWORD;
        dwMajorVersion: DWORD;
        dwMinorVersion: DWORD;
        dwBuildNumber: DWORD;
        dwPlatformID: DWORD;
      end;
      PDllVersionInfo = ^TDllVersionInfo;
     
    var
      Lib: THandle;
      DllGetVersion: function (Info: PDllVersionInfo): HRESULT; stdcall;
      Info: TDllVersionInfo;
      WasLoaded: Boolean;
    begin
      Result := 0;
      try
        // Получение ссылки на DLL, если она уже загружена
        Lib := GetModuleHandle(FileName); 
        if Lib = 0 then
        begin
          // Загрузка DLL, если она еще не загружена
          Lib := LoadLibrary('SHELL32.DLL');
          WasLoaded := True;
        end else WasLoaded := False;
        if Lib <> 0 then
        try
          // Получение адреса функции DllGetVersion
          DllGetVersion := GetProcAddress(Lib, 'DllGetVersion'); 
          if Assigned(DllGetVersion) then
          begin
            // Подготовка структуры для функции
            ZeroMemory(@Info, SizeOf(Info));
            Info.cbSize := SizeOf(Info);
            // Вызов функции DllGetVersion
            if DllGetVersion(@Info) = NOERROR then
              Result := MakeVersion(Info.dwMajorVersion, Info.dwMinorVersion);
          end;
        finally
          // Если DLL была загружена этой функцией - то выгружаем 
          if WasLoaded then FreeLibrary(Lib);
        end;
      except
      end;
    end; 

Пример использования:

    // Закодированные MakeVersion версии можно просто сравнивать
    if GetDLLVersion('SHELL32.DLL') > MakeVersion(5, 0) then 
      ...
     
    // Вот так можно вывести версию DLL
     
    var
      V: Integer;
    begin
      V := GetDLLVersion('SHLDOC32.DLL');
      ShowMessage(IntToStr(HIWORD(V)) + '.' + IntToStr(LOWORD(V)));
    end; 
