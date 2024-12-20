---
Title: Демонстрационный пример хука и подмены API в приложениях
Author: Александр (Rouse\_) Багель
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Демонстрационный пример хука и подмены API в приложениях
========================================================

    ////////////////////////////////////////////////////////////////////////////////
    //
    //  ****************************************************************************
    //  * Unit Name : HookDLL
    //  * Purpose   : Демонстрационный пример хука и подмены API в приложениях...
    //  * Author    : Александр (Rouse_) Багель
    //  * Version   : 1.00
    //  ****************************************************************************
    //
     
    library HookDLL;
     
    uses
      Windows,
      Messages,
      Winsock;
     
    const
      GlobMapID = 'Global Hook for API Interception {2E662583-74C4-45DB-B6DF-FE318C94258D}';
     
    const // Константы нотификаций
      NOTIFY_DLL_INJECT = 1;
      NOTIFY_API_CALL = 2;
      NOTIFY_API_INTERCEPT_SUCCESS = 3;
      NOTIFY_API_INTERCEPT_FAILED = 4;
     
    type
      // Структура для нотификации приложения
      TLogData = record
        AppName: ShortString; // Имя приложения
        FuncName: String[8];  // Имя функции
        FuncPointer: Integer; // Адрес функции
        IP: String[15];       // IP адрес
        Port: Cardinal;       // Порт
        Buff: array [0..$FFFF] of Char; // Содержимое буффера
        BuffSize: Word;       // Размер буфера
      end;
     
      // Структура с рабочей информацией хука
      PShareInf = ^TShareInf;
      TShareInf = record
        AppWndHandle: HWND;
        OldHookHandle: HHOOK;
        hm:THandle;
      end;
     
      // Структуры для работы с таблицей импорта
      TIIDUnion = record
        case Integer of
          0: (Characteristics: DWORD);
          1: (OriginalFirstThunk: DWORD);
        end;
     
      PImageImportDescriptor = ^TImageImportDescriptor;
      TImageImportDescriptor = record
        Union: TIIDUnion;
        TimeDateStamp: DWORD;
        ForwarderChain: DWORD;
        Name: DWORD;
        FirstThunk: DWORD;
      end;
     
      PImageThunkData = ^TImageThunkData32;
      TImageThunkData32 = packed record
        _function : PDWORD;
      end;
     
      function ImageDirectoryEntryToData(Base: Pointer; MappedAsImage: ByteBool;
        DirectoryEntry: Word; var Size: ULONG): Pointer; stdcall; external 'imagehlp.dll';
     
    var
      MapHandle: THandle = 0;
      ShareInf: PShareInf = nil;
      OldRecv: FARPROC = nil;
      Replaced: Boolean;
      AppTitle: ShortString;
     
    //  Перехват API посредством подмены в таблице импорта
    // =============================================================================
    function ReplaceIATEntryInOneMod(const OldProc,
      NewProc: FARPROC): Boolean;
    var
      ImportEntry: PImageImportDescriptor;
      Thunk: PImageThunkData;
      Protect, newProtect: DWORD;
      ImageBase: Cardinal;
      DOSHeader: PImageDosHeader;
      NTHeader: PImageNtHeaders;
    begin
      Result := False;
      if OldProc = nil then Exit;
      if NewProc = nil then Exit;
      ImageBase := GetModuleHandle(nil);
     
      // Зная структуру PE заголовка - находим начало таблицы импорта
      DOSHeader := PImageDosHeader(ImageBase);
      if IsBadReadPtr(Pointer(ImageBase), SizeOf(TImageNtHeaders)) then Exit;
      if (DOSHeader^.e_magic <> IMAGE_DOS_SIGNATURE) then Exit;
      NTHeader := PImageNtHeaders(DWORD(DOSHeader) + DWORD(DOSHeader^._lfanew));
      if NTHeader^.Signature <> IMAGE_NT_SIGNATURE then Exit;
      ImportEntry := PImageImportDescriptor(DWORD(ImageBase) +
          DWORD(NTHeader^.OptionalHeader.DataDirectory[IMAGE_DIRECTORY_ENTRY_IMPORT].VirtualAddress));
      if DWORD(ImportEntry) = DWORD(NTHeader) then Exit;
     
      if ImportEntry <> nil then
      begin
        // Бежим по записям таблицы ...
        while ImportEntry^.Name <> 0 do
        begin
          Thunk := PImageThunkData(DWORD(ImageBase) +
            DWORD(ImportEntry^.FirstThunk));
          // ... пока таблица не кончится ...
          while Thunk^._function <> nil do
          begin
            // ... или не найдем нужную нам запись.
            if (Thunk^._function = OldProc) then
            begin
              // Производим подмену, сначала так...
              if not IsBadWritePtr(@Thunk^._function, sizeof(DWORD)) then
              begin
                Thunk^._function := NewProc;
                Result := True;
              end
              else
              begin // ... ну а если не получилось - тогда вот так
                if VirtualProtect(@Thunk^._function, SizeOf(DWORD),
                  PAGE_EXECUTE_READWRITE, Protect) then
                begin
                  Thunk^._function := NewProc;
                  newProtect := Protect;
                  VirtualProtect(@Thunk^._function, SizeOf(DWORD),
                    newProtect, Protect);
                  Result := True;
                end;
              end;
            end
            else
              Inc(PChar(Thunk), SizeOf(TImageThunkData32));
          end;
          ImportEntry := Pointer(Integer(ImportEntry) + SizeOf(TImageImportDescriptor));
        end;
      end;
    end;
     
    //  Наша функция которая будет работать вместо оригинальной ...
    // =============================================================================
    function InterceptedRecv(s: TSocket; var Buf; len, flags: Integer): Integer; stdcall;
    type
      TrecvImage = function(s: TSocket; var Buf; len, flags: Integer): Integer; stdcall;
    var
      CDS: TCopyDataStruct;
      SockAddr: TSockAddr;
      AddrLen: Integer;
      Data: TLogData;
    begin
      // Первоначально вызываем оригинальную функцию, но данные будем писать в свой буфер...
      Result := TrecvImage(OldRecv)(s, Data.Buff[0], len, flags);
      // Получаем информацию кто с кем связался
      if getpeername(s, SockAddr, AddrLen) = SOCKET_ERROR then Exit;
      Data.IP := inet_ntoa(SockAddr.sin_addr);
      Data.Port := ntohs(SockAddr.sin_port);
      Data.BuffSize := Result;
      Data.AppName := AppTitle;
     
      // Тут можно встроить проверку (к примеру по какому нибудь порту)
      if True then
        Move(Data.Buff[0], Buf, Result) // проверка успешна - пишем в буфер полученные данные
      else
        Result := SOCKET_ERROR;         // в противном случае говорим что вызов неуспешен.
     
      // Отправляем полученные данные нашему приложению...
      CDS.dwData := NOTIFY_API_CALL;
      CDS.cbData := SizeOf(TLogData);
      CDS.lpData := @Data;
      SendMessage(ShareInf^.AppWndHandle, WM_COPYDATA, 0, Integer(@CDS));
    end;
     
    //  Начало и завершение работы нашего хука ...
    // =============================================================================
    procedure DLLEntryPoint(dwReason: DWORD); //stdcall;  <- вот это как раз не нужно...
    var
      CDS: TCopyDataStruct;
      Data: TLogData;
      ImageBase: Cardinal;
      FileName: array [0..MAX_PATH - 1] of Char;
    begin
      case dwReason Of
        DLL_PROCESS_ATTACH:
          begin
            // Все данные во избежании разрыва цепочки хуков храним в отображаемом в память процесса файле,
            // только тогда все экземпляры хука будут владеть достоверной информацией
            MapHandle := CreateFileMapping(INVALID_HANDLE_VALUE, nil, PAGE_READWRITE, 0, SizeOf(TShareInf), GlobMapID);
            ShareInf := MapViewOfFile(MapHandle, FILE_MAP_ALL_ACCESS, 0, 0, SizeOf(TShareInf));
       
            // Получаем информацию о процессе в который подгружена наша библиотека
            Replaced := False;
            OldRecv := GetProcAddress(GetModuleHandle('wsock32.dll'), 'recv');
            DisableThreadLibraryCalls(hInstance);
            ImageBase := GetModuleHandle(nil);
            ZeroMemory(@FileName, SizeOf(FileName));
            GetModuleFileName(ImageBase, @FileName, SizeOf(FileName));
            AppTitle := String(FileName);
       
            // Нотифицируем приложение о успешном внедрении библиотеки
            // И сообщаем информацию о процессе
            ZeroMemory(@Data, SizeOf(TLogData));
            Data.AppName := AppTitle;
            Data.FuncName := 'recv';
            Data.FuncPointer := Integer(OldRecv);
       
            CDS.dwData := NOTIFY_DLL_INJECT;
            CDS.cbData := SizeOf(TLogData);
            CDS.lpData := @Data;
            SendMessage(ShareInf^.AppWndHandle, WM_COPYDATA, 0, Integer(@CDS));
       
            // Подменяем процедуры своими (если это нужное нам приложение)
            if Pos('NETCHAT.EXE', AnsiUpper(@FileName)) <>0 then
            begin
              if OldRecv <> nil then
                // Смотрим - успешно ли подменилась запись в таблице импорта?
                if ReplaceIATEntryInOneMod(OldRecv, @InterceptedRecv) then
                begin
                  CDS.dwData := NOTIFY_API_INTERCEPT_SUCCESS; // Успешно...
                  Replaced := True;                           // Ставим флаг, что была замена...
                end
                else
                  CDS.dwData := NOTIFY_API_INTERCEPT_FAILED;  // Не успешно...
       
              // Нотифицируем наше приложение о результате подмены...
              CDS.cbData := SizeOf(TLogData);
              CDS.lpData := @Data;
              SendMessage(ShareInf^.AppWndHandle, WM_COPYDATA, 0, Integer(@CDS));
            end;
          end;
        DLL_PROCESS_DETACH:
          begin
            UnMapViewOfFile(ShareInf);
            CloseHandle(MapHandle);
            // Возвращаем изменения как они и были (если замена была удачна)
            if Replaced then
              ReplaceIATEntryInOneMod(@InterceptedRecv, OldRecv);
          end;
      end;
    end;
     
    //  Это наш хук, он нужен только для внедрения в удаленный процесс ...
    // =============================================================================
    function Hook(Code: Integer; WParam: WPARAM; LParam: LPARAM): LRESULT; stdcall;
    begin
      Result := CallNextHookEx(ShareInf^.OldHookHandle, Code, WParam, LParam); // вызываем след. ловушку
    end;
     
    //  Установка хука ...
    // =============================================================================
    function SetHook(Wnd: HWND): BOOL; stdcall;
    begin
      if ShareInf <> nil then
      begin
        ShareInf^.AppWndHandle := Wnd;
        ShareInf^.OldHookHandle := SetWindowsHookEx(WH_GETMESSAGE, @Hook, HInstance, 0); // <- Обратите внимание, не допускаем главной ошибки
        Result := ShareInf^.OldHookHandle <> 0;
      end
      else 
        Result:=False;
    end;
     
    //  Снятие хука ...
    // =============================================================================
    function RemoveHook: BOOL; stdcall;
    begin
      Result := UnhookWindowsHookEx(ShareInf^.OldHookHandle);
      CloseHandle(ShareInf^.hm);
    end;
     
    exports
      SetHook, RemoveHook;
     
    begin
      DLLProc := @DLLEntryPoint;
      DLLEntryPoint(DLL_PROCESS_ATTACH);
    end.


Приложение:


    ////////////////////////////////////////////////////////////////////////////////
    //
    //  ****************************************************************************
    //  * Unit Name : uMain
    //  * Purpose   : Демонстрационный пример хука и подмены API в приложениях...
    //  * Author    : Александр (Rouse_) Багель
    //  * Version   : 1.00
    //  ****************************************************************************
    //
     
    unit uMain;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls, ActiveX;
     
    const // Константы нотификаций
      NOTIFY_DLL_INJECT = 1;
      NOTIFY_API_CALL = 2;
      NOTIFY_API_INTERCEPT_SUCCESS = 3;
      NOTIFY_API_INTERCEPT_FAILED = 4;
     
    type
      TLogData = record
        AppName: ShortString; // Имя приложения
        FuncName: String[8];  // Имя функции
        FuncPointer: Integer; // Адрес функции
        IP: String[15];       // IP адрес
        Port: Cardinal;       // Порт
        Buff: array [0..$FFFF] of Char; // Содержимое буффера
        BuffSize: Word;       // Размер буфера
      end;
      PLogData = ^TLogData;
     
      THADemo = class(TForm)
        memReport: TMemo;
        procedure FormCreate(Sender: TObject);
        procedure FormClose(Sender: TObject; var Action: TCloseAction);
      private
        procedure WMCopyData(var Msg: TMessage); message WM_COPYDATA;
      end;
     
      function SetHook(Wnd: HWND): BOOL; stdcall;
        external 'HookDLL.dll' name 'SetHook';
      function RemoveHook: BOOL; stdcall;
        external 'HookDLL.dll' name 'RemoveHook';     
     
    var
      HADemo: THADemo;
     
    implementation
     
    {$R *.dfm}
     
    { TForm1 }
     
    procedure THADemo.FormCreate(Sender: TObject);
    begin
      if not SetHook(Handle) Then
        MessageBox(Handle, 'Невозможно установить хук.', PChar(Application.Title), MB_OK OR MB_ICONHAND);
    end;
     
    procedure THADemo.FormClose(Sender: TObject; var Action: TCloseAction);
    begin
      if not RemoveHook Then
        MessageBox(Handle, 'Невозможно снять хук.', PChar(Application.Title), MB_OK OR MB_ICONHAND);
    end;
     
    procedure THADemo.WMCopyData(var Msg: TMessage);
    const
      ReportInject = 'Библиотека внедрена в приложение "%s", функция "%s" имеет адрес: $%s';
      ReportIntercept = 'Приложение: "%s" IP %s:%d размер данных = %d буфер = "%s"';
      ReportSucceeded = 'Перехват функции "%s" в модуле "%s" успешен.';
      ReportFailed = 'Перехват функции "%s" в модуле "%s" неуспешен!!!';
    var
      Data: TLogData;
      Buffer: String;
    begin
      Data := PLogData(PCopyDataStruct(Msg.LParam)^.lpData)^;
      // Типы нотификаций
      case PCopyDataStruct(Msg.LParam)^.dwData of
        NOTIFY_DLL_INJECT: // Пришло уведомление о внедрении библиотеки в удаленный процесс
          with Data do
            memReport.Lines.Add(Format(ReportInject, [AppName, FuncName,
              IntToHex(Data.FuncPointer, 8)]));
        NOTIFY_API_CALL: // Уведомление о вызове функции
          begin
            SetLength(Buffer, Data.BuffSize);
            Move(Data.Buff[0], Buffer[1], Data.BuffSize);
            with Data do
              memReport.Lines.Add(Format(ReportIntercept, [AppName, IP, Port, BuffSize, Buffer]));
          end;
        NOTIFY_API_INTERCEPT_SUCCESS: // Уведомление о удачной подмене таблицы импорта
          with Data do
            memReport.Lines.Add(Format(ReportSucceeded, [FuncName, AppName]));
        NOTIFY_API_INTERCEPT_FAILED: // Уведомление о неудачной подмене таблицы импорта
          with Data do
            memReport.Lines.Add(Format(ReportFailed, [FuncName, AppName]));
      end;
    end;
     
    end.

Демонстрационный пример перехвата вызовов API функций, посредством
изменения таблицы импорта.

Скачать демонстрационный пример: [iatchange.zip](iatchange.zip) 2k

Александр (Rouse\_) Багель

<https://rouse.drkb.ru>
