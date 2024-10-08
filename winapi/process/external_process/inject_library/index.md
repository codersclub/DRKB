---
Title: Внедрение библиотеки через CreateRemoteThread
Author: Александр (Rouse_) Багель
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Внедрение библиотеки через CreateRemoteThread
=============================================

**Инжектирование кода.**

Простой пример внедрения и выгрузки библиотеки в удаленное адресное
пространство.  
А также исполнение своего кода в удаленном процессе через CreateRemote

    ////////////////////////////////////////////////////////////////////////////////
    //
    //  ****************************************************************************
    //  * Project   : Inject/Eject Library Demo
    //  * Unit Name : HookDLL
    //  * Purpose   : Демонстрационный пример внедрения библиотеки через CreateRemoteThread
    //  * Author    : Александр (Rouse_) Багель
    //  * Version   : 1.00
    //  ****************************************************************************
    //   
     
    Library HookDLL;
     
    uses
      Windows,
      Messages,
      SysUtils;
     
    procedure DLLEntryPoint(dwReason: DWORD); 
    begin
      case dwReason of
        DLL_PROCESS_ATTACH:
        begin
          MessageBox(0, 'DLL_PROCESS_ATTACH', 'DLL_PROCESS_ATTACH', MB_OK);
          ExitThread(0);
        end;
      end;
    end;
     
    begin
      DLLProc := @DLLEntryPoint;
      DLLEntryPoint(DLL_PROCESS_ATTACH);
    end.


Приложение:

    ////////////////////////////////////////////////////////////////////////////////
    //
    //  ****************************************************************************
    //  * Project   : Inject/Eject Library Demo
    //  * Unit Name : main
    //  * Purpose   : Демонстрационный пример внедрения библиотеки через CreateRemoteThread
    //  * Author    : Александр (Rouse_) Багель
    //  * Version   : 1.00
    //  ****************************************************************************
    //
     
    unit main;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls;
     
    resourcestring
      BTN_INJECT = 'Inject';
      BTN_EJECT  = 'Eject';
     
    const
      DLLName = 'hooklib.dll';
     
    type
      TfrmMain = class(TForm)
        btnInjectEject: TButton;
        GroupBox: TGroupBox;
        lbStatus: TListBox;
        procedure btnInjectEjectClick(Sender: TObject);
      private
        function InjectLib(const ProcessID: DWORD): Boolean;
        function EjectLib(const ProcessID: DWORD): Boolean;
      end;
     
      // Декларация функций при помощи которых будет происходить выгрузка билиотеки
      TGetModuleHandle = function (lpModuleName: PChar): HMODULE; stdcall;
      TFreeLibrary = function (hLibModule: HMODULE): BOOL; stdcall;
     
      // Структура передаваемая потоковой функции при выгрузке библиотеки
      PEjectLibStruct = ^TEjectLibStruct;
      TEjectLibStruct = record
        hGetModuleHandle: TGetModuleHandle;
        hFreeLibrary: TFreeLibrary;
        lpModuleName: PChar;
      end;
     
    var
      frmMain: TfrmMain;
     
    implementation
     
    {$R *.dfm}
     
    { TfrmMain }
     
    //  Обработчик кнопки на внедрение/выгрузку библиотеки
    // =============================================================================
    procedure TfrmMain.btnInjectEjectClick(Sender: TObject);
    begin
      TComponent(Sender).Tag := TComponent(Sender).Tag + 1;
      if (TComponent(Sender).Tag mod 2) = 1 then
      begin
        btnInjectEject.Caption := BTN_EJECT;
        if InjectLib(GetCurrentProcessID) then
          lbStatus.Items.Add('Library injected succes.')
        else
          lbStatus.Items.Add('Library injected fail.');
      end
      else
      begin
        btnInjectEject.Caption := BTN_INJECT;
        if EjectLib(GetCurrentProcessID) then
          lbStatus.Items.Add('Library ejected succes.')
        else
          lbStatus.Items.Add('Library ejected fail.');
      end;
    end;
     
    //  Пока наш процесс не получит отлабочные привилегии,
    //  весь этот код работать не будет
    // =============================================================================
    function SetDebugPriv: Boolean;
    var
      Token: THandle;
      tkp: TTokenPrivileges;
      ReturnLength: DWORD;
    begin
      Result := false;
      // Получаем токен текущего процесса
      if OpenProcessToken(GetCurrentProcess, TOKEN_ADJUST_PRIVILEGES or TOKEN_QUERY, Token) then
      begin
        // Получаем Luid привилегии
        if LookupPrivilegeValue(nil, PChar('SeDebugPrivilege'), tkp.Privileges[0].Luid) then
        begin
          // Заполняем необходимые параметры
          tkp.PrivilegeCount := 1;
          tkp.Privileges[0].Attributes := SE_PRIVILEGE_ENABLED;
          // Включаем привилегию
          Result := AdjustTokenPrivileges(Token, false, tkp, 0, nil, ReturnLength);
        end;
      end;
    end;     
     
    //  Функция внедряет библиотеку в удаленный процесс с PID равным ProcessID
    //  Для успешного внедрения нужно передать адрес функции LoadLibraryA
    //  и путь к загружаемой библиотеке.
    //  Строку с путем необходимо разместить в алресном пространстве удаленного процесса
    // =============================================================================
    function TfrmMain.InjectLib(const ProcessID: DWORD): Boolean;
    var
      Process: HWND;
      ThreadRtn: FARPROC;
      DllPath: String;
      RemoteDll: Pointer;
      BytesWriten: DWORD;
      Thread: DWORD;
      ThreadId: DWORD;
      ExitCode: DWORD;
    begin
      // Устанавливаем отладочные привилегии для нашего процесса
      Result := SetDebugPriv;
      if not Result then Exit;
      Process := 0;
      Thread := 0;
      try
        // Открываем процесс
        Process := OpenProcess(PROCESS_CREATE_THREAD or PROCESS_VM_OPERATION or
          PROCESS_VM_WRITE, True, ProcessID);
        if Process = 0 then Exit;
        // Выделяем в нем память под строку
        DllPath := ExtractFilePath(ParamStr(0)) + DLLName;
        RemoteDll := VirtualAllocEx(Process, nil, Length(DllPath),
          MEM_COMMIT or MEM_TOP_DOWN, PAGE_READWRITE);
        if RemoteDll = nil then Exit;
        // Пишем путь к длл в его адресное пространство
        if not WriteProcessMemory(Process, RemoteDll, PChar(DllPath),
          Length(DllPath), BytesWriten) then Exit;
        if BytesWriten <> DWORD(Length(DllPath)) then Exit;
        // Получаем адрес функции из Kernel32.dll
        ThreadRtn := GetProcAddress(GetModuleHandle('Kernel32.dll'), 'LoadLibraryA');
        if ThreadRtn = nil then Exit;
        // Запускаем удаленный поток
        Thread := CreateRemoteThread(Process, nil, 0, ThreadRtn, RemoteDll, 0, ThreadId);
        if Thread = 0 then Exit;
        // Ждем пока удаленный поток отработает...
        if (WaitForSingleObject(Thread, INFINITE) = WAIT_OBJECT_0) then
          if GetExitCodeThread(Thread, ExitCode) then
            Result := ExitCode = 0;
      finally
        // Удаленный поток свою задачу выполнил и загрузил нашу библиотеку,
        // можно освобождать занятую память...
        if RemoteDll <> nil then
          VirtualFreeEx(Process, @RemoteDll, 0, MEM_RELEASE);
        if Thread <> 0 then CloseHandle(Thread);
        if Process <> 0 then CloseHandle(Process);  
      end;
    end;
     
    //  Для того чтобы выгрузить библиотеку, необходимо найти ее адрес в удаленном
    //  процессе и вызвать там же FreeLibrary
    //  Этим у нас будет заниматься вот такая функция
    //  Для успешной ее работы необходимо передать 3 параметра.
    //  1: Адреса функций GetModuleHandle и FreeLibrary;
    //  2: Имя модуля, выгрузку которого мы будем производить
    // =============================================================================
    function RemoteFreeLibrary(lpParameter: Pointer): DWORD; stdcall;
    var
      hLibModule: HMODULE;
    begin
      Result := 0;
      if lpParameter = nil then Exit;
      // Получаем описатель нашей библиотеки (используем переданные параметры)
      hLibModule := TGetModuleHandle(PEjectLibStruct(lpParameter)^.hGetModuleHandle)
        (PEjectLibStruct(lpParameter)^.lpModuleName);
      if hLibModule <> 0 then
        // Выгружаем библиотеку
        Result := DWORD(TFreeLibrary(PEjectLibStruct(lpParameter)^.hFreeLibrary)(hLibModule));
    end;
     
    //  Данная функция запускает в удаленном процессе поток
    //  с потоковой функцией RemoteFreeLibrary
    //  и подготавливает для ее работы необходимые данные
    // =============================================================================
    function TfrmMain.EjectLib(const ProcessID: DWORD): Boolean;
    var
      Process: HWND;
      BytesWriten: DWORD;
      Thread: DWORD;
      ThreadId: DWORD;
      ExitCode: DWORD;
      EjectLibStruct: TEjectLibStruct;
      EjectLibStructAddr: Pointer;
    begin
      Result := False;
      Process := 0;
      Thread := 0;
      try
        // Открываем процесс
        Process := OpenProcess(PROCESS_CREATE_THREAD or PROCESS_VM_OPERATION or
          PROCESS_VM_WRITE, True, ProcessID);
        if Process = 0 then Exit;
        // Выделяем в нем память под имя модуля
        EjectLibStruct.lpModuleName := VirtualAllocEx(Process, nil, Length(DLLName),
          MEM_COMMIT or MEM_TOP_DOWN, PAGE_READWRITE);
        if EjectLibStruct.lpModuleName = nil then Exit;
        // Пишем имя модуля в его адресное пространство
        if not WriteProcessMemory(Process, EjectLibStruct.lpModuleName, PChar(DLLName),
          Length(DLLName), BytesWriten) then Exit;
        if BytesWriten <> DWORD(Length(DLLName)) then Exit;
        // Получаем адрес функции FreeLibrary из Kernel32.dll
        EjectLibStruct.hFreeLibrary :=
          GetProcAddress(GetModuleHandle('Kernel32.dll'), 'FreeLibrary');
        if not Assigned(EjectLibStruct.hFreeLibrary) then Exit;
        // Получаем адрес функции GetModuleHandle из Kernel32.dll
        EjectLibStruct.hGetModuleHandle :=
          GetProcAddress(GetModuleHandle('Kernel32.dll'), 'GetModuleHandleA');
        if not Assigned(EjectLibStruct.hGetModuleHandle) then Exit;
        // Выделяем память под структуру, которая передается нашей функции
        EjectLibStructAddr := VirtualAllocEx(Process, nil, SizeOf(TEjectLibStruct),
          MEM_COMMIT or MEM_TOP_DOWN, PAGE_READWRITE);
        if EjectLibStructAddr = nil then Exit;
        // Пишем саму структуру
        if not WriteProcessMemory(Process, EjectLibStructAddr, @EjectLibStruct,
          SizeOf(TEjectLibStruct), BytesWriten) then Exit;
        if BytesWriten <> DWORD(SizeOf(TEjectLibStruct)) then Exit;
     
        // Запускаем удаленный поток
        Thread := CreateRemoteThread(Process, nil, 0, @RemoteFreeLibrary,
          EjectLibStructAddr, 0, ThreadId);
        if Thread = 0 then Exit;
        // Ждем пока удаленный поток отработает...
        if (WaitForSingleObject(Thread, INFINITE) = WAIT_OBJECT_0) then
          if GetExitCodeThread(Thread, ExitCode) then
            Result := BOOL(ExitCode);
      finally
        // Удаленный поток свою задачу выполнил и выгрузил нашу библиотеку,
        // можно освобождать занятую память...
        VirtualFreeEx(Process, @EjectLibStruct.lpModuleName, 0, MEM_RELEASE);
        VirtualFreeEx(Process, @EjectLibStructAddr, 0, MEM_RELEASE);
        if Thread <> 0 then CloseHandle(Thread);
        if Process <> 0 then CloseHandle(Process);
      end;
    end;
     
    end.


[Скачать демонстрационный пример](injectlib.zip)

