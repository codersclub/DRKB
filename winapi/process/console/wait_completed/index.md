---
Title: Подождать завершения DOS-задачи
Date: 01.01.2007
---

Подождать завершения DOS-задачи
===============================

> Каким образом организовать ожидание завершения DOS-задачи? Например,
> надо подождать, пока заархивируется файл, и далее обработать его.

Вариант 1:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    uses Windows;
     
    procedure RunRarAndWait;
    var
      si: TStartupInfo;
      pi: TProcessInformation;
    begin
      //подготовливаем записи si и pi к использованию
      FillChar(si, SizeOf(si));
      si.cb := SizeOf(si);
      FillChar(pi, SizeOf(pi));
      //попытаемся запустить рар
      if CreateProcess('rar.exe', 'parameters',
      nil, nil, //безопасность по умолчанию
      false,    //не наследовать хэндлов
      0,        //флаги создания по умолчанию
      nil,      //переменные среды по умолчанию
      nil,      //текущая директория по умолчанию
      si,       //стартовая информация
      pi)       //а в эту запись получим информацию о созданом процессе
      then
      begin
        //удалось запустить рар
        //подождем пока рар работает
        WaitForSingleObject(pi.hProcess, INFINITE);
        //убираем мусор
        CloseHandle(pi.hProcess);
        CloseHandle(pi.hThread);
      end
      else
        //выдаем сообщение об ощибке
        MessageDlg(SysErrorMessage(GetLastError), mtError, [mbOK], 0);
    end;


------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    function WinExecute(CmdLine: string; Wait: Boolean): Boolean;
    var
      StartupInfo: TStartupInfo;
      ProcessInformation: TProcessInformation;
    begin
      Result := True;
      try
        FillChar(StartupInfo, SizeOf(StartupInfo), 0);
        StartupInfo.cb := SizeOf(StartupInfo);
        if not CreateProcess(nil, PChar(CmdLine), nil, nil, True, 0, nil,
        nil, StartupInfo, ProcessInformation) then
          RaiseLastWin32Error;
        if Wait then
          WaitForSingleObject(ProcessInformation.hProcess, INFINITE);
      except
        Result := False;
      end;
    end;


------------------------------------------------------------------------

Вариант 3:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    function TForm1.StartWithShell(Prog, par, Verz: string;
    var hProcess: THandle): DWord;
    var
      exInfo: TShellExecuteInfo;
    begin
      hProcess := 0;
      FillChar(exInfo, Sizeof(exInfo), 0);
      with exInfo do
      begin
        cbSize:= Sizeof(exInfo);
        fMask := SEE_MASK_NOCLOSEPROCESS or SEE_MASK_FLAG_DDEWAIT;
        Wnd := 0;
        lpVerb:= 'open';
        lpParameters := PChar(par);
        lpFile:= Pchar(prog);
        nShow := SW_HIDE;
      end;
      Result := ERROR_SUCCESS;
      if ShellExecuteEx(@exInfo) then
        hProcess := exinfo.hProcess
      else
        Result := GetLastError;
    end;
     
    function TForm1.StartProgramm : Boolean;
    var
      r, ExitCode: DWord;
      err: string;
      hProcess: THandle;
    begin
      Result := False;
      r := StartWithShell('rar.exe',, 'c:\windows\system',
      hProcess);
      if r = ERROR_SUCCESS then
      begin
        repeat
          Application.ProcessMessages;
          GetExitCodeProcess(hProcess, ExitCode);
        until
          ExitCode <> STILL_ACTIVE;
        result := true;
      end
      else
      begin
        case r of
          ERROR_FILE_NOT_FOUND : err:='The specified file was not found.';
          ERROR_PATH_NOT_FOUND : err:='The specified path was not found.';
          ERROR_DDE_FAIL : err:='The DDE transaction failed.';
          ERROR_NO_ASSOCIATION : err:='There is no application associated ' +
          'with the given filename extension.';
          ERROR_ACCESS_DENIED : err:='Access denied';
          ERROR_DLL_NOT_FOUND : err:='DLL not found';
          ERROR_CANCELLED : err:='The function prompted the user for the ' +
          'location of the application, but the user cancelled the request.';
          ERROR_NOT_ENOUGH_MEMORY: err:='Not enough memory';
          ERROR_SHARING_VIOLATION: err:='A sharing violation occurred.';
          else
            err := 'Unknown';
        end;
        MessageDlg('Error: ' + err, mtError, [mbOk], 0);
      end;
    end;

