---
Title: Как запустить программу и подождать её завершения?
Author: TAPAKAH
Date: 01.01.2007
---

Как запустить программу и подождать её завершения?
==================================================

::: {.date}
01.01.2007
:::

    var
    pi : TProcessInformation;
    si : TStartupInfo;
    begin
    ZeroMemory(@si,sizeof(si));
    si.cb:=SizeOf(si);
    if not CreateProcess(
    PChar(lpApplicationName), //pointer to name of executable module
    PChar(lpCommandLine), // Command line.
    nil, // Process handle not inheritable.
    nil, // Thread handle not inheritable.
    False, // Set handle inheritance to FALSE.
    0, // No creation flags.
    nil, // Use parent's environment block.
    nil, // Use parent's starting directory.
    si, // Pointer to STARTUPINFO structure.
    pi ) // Pointer to PROCESS_INFORMATION structure.
    then begin
    Result:=false;
    RaiseLastWin32Error; 
    Exit;
    end;
    WaitForSingleObject(pi.hProcess,INFINITE);
    CloseHandle(pi.hProcess);
    CloseHandle(pi.hThread);
    // ... здесь твой код
    end;

Автор: TAPAKAH

Примечание Vit:

Если заменить

WaitForSingleObject(pi.hProcess,INFINITE);

на

while WaitforSingleObject(PI.hProcess,200)=WAIT\_TIMEOUT do  
application.ProcessMessages;

то вызывающая программа не будет казаться завешанной и будет отвечать на
сообщения

Примечание Mikel: В RxLib есть функция для этого: FileExecuteWait

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

Здесь представлена функция, которая вызывается таким же образом как и
WinExec, однако она ждёт, пока запущенная задача завершится.

    function WinExecAndWait(Path: PChar; Visibility: Word): Word; 
    var 
      InstanceID: THandle; 
      Msg: TMsg; 
    begin 
      InstanceID := WinExec(Path, Visibility); 
      if InstanceID < 32 then { значение меньше чем 32 указывает на ошибку }
        WinExecAndWait := InstanceID 
      else 
        repeat 
           while PeekMessage(Msg, 0, 0, 0, pm_Remove) do 
           begin 
             if Msg.Message = wm_Quit then Halt(Msg.WParam); 
             TranslateMessage(Msg); 
             DispatchMessage(Msg); 
           end; 
        until GetModuleUsage(InstanceID) = 0; 
      WinExecAndWait := 0; 
    end;

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------

Автор: Fabrнcio Fadel Kammer

Пример показывает как из Вашей программы запустить внешнее приложение и
подождать его завершения.

    function ExecAndWait(const FileName, Params: ShortString; const WinState: Word): boolean; export; 
    var 
      StartInfo: TStartupInfo; 
      ProcInfo: TProcessInformation; 
      CmdLine: ShortString; 
    begin 
      { Помещаем имя файла между кавычками, с соблюдением всех пробелов в именах Win9x } 
      CmdLine := '"' + Filename + '" ' + Params; 
      FillChar(StartInfo, SizeOf(StartInfo), #0); 
      with StartInfo do 
      begin 
        cb := SizeOf(SUInfo); 
        dwFlags := STARTF_USESHOWWINDOW; 
        wShowWindow := WinState; 
      end; 
      Result := CreateProcess(nil, PChar( String( CmdLine ) ), nil, nil, false, 
                              CREATE_NEW_CONSOLE or NORMAL_PRIORITY_CLASS, nil, 
                              PChar(ExtractFilePath(Filename)),StartInfo,ProcInfo); 
      { Ожидаем завершения приложения } 
      if Result then 
      begin 
        WaitForSingleObject(ProcInfo.hProcess, INFINITE); 
        { Free the Handles } 
        CloseHandle(ProcInfo.hProcess); 
        CloseHandle(ProcInfo.hThread); 
      end; 
    end;

А вот пример вызова этой функции:

    ExecAndWait( 'C:\windows\calc.exe', '', SH_SHOWNORMAL);

Параметр FileName = Имя внешней программы.

Параметр Params = Параметры, необходимые для запуска внешней программы

Параметр WinState = Указывает - как будет показано окно:

               Для этого параметра мы можем так же использовать
следующие константы:

               SW\_HIDE, SW\_MAXIMIZE, SW\_MINIMIZE, SW\_SHOWNORMAL

Взято из <https://forum.sources.ru>
