---
Title: Перехват вывода консоли
Date: 01.01.2007
---

Перехват вывода консоли
=======================

Вариант 1:

Source: <https://forum.sources.ru>

    unit consoleoutput; 
     
    interface
     
    uses
      Controls, Windows, SysUtils, Forms;
     
    function GetDosOutput(const CommandLine:string): string;
     
    implementation
     
    function GetDosOutput(const CommandLine:string): string;
    var
      SA: TSecurityAttributes;
      SI: TStartupInfo;
      PI: TProcessInformation;
      StdOutPipeRead, StdOutPipeWrite: THandle;
      WasOK: Boolean;
      Buffer: array[0..255] of Char;
      BytesRead: Cardinal;
      WorkDir, Line: String;
    begin
      Application.ProcessMessages;
      with SA do
      begin
        nLength := SizeOf(SA);
        bInheritHandle := True;
        lpSecurityDescriptor := nil;
      end;
      // создаём пайп для перенаправления стандартного вывода
      CreatePipe(StdOutPipeRead,  // дескриптор чтения
                 StdOutPipeWrite, // дескриптор записи
                 @SA,             // аттрибуты безопасности
                 0                // количество байт принятых для пайпа - 0 по умолчанию
                 );
      try
        // Создаём дочерний процесс, используя StdOutPipeWrite в качестве стандартного вывода,
        // а так же проверяем, чтобы он не показывался на экране.
        with SI do
        begin
          FillChar(SI, SizeOf(SI), 0);
          cb := SizeOf(SI);
          dwFlags := STARTF_USESHOWWINDOW or STARTF_USESTDHANDLES;
          wShowWindow := SW_HIDE;
          hStdInput := GetStdHandle(STD_INPUT_HANDLE); // стандартный ввод не перенаправляем
          hStdOutput := StdOutPipeWrite;
          hStdError := StdOutPipeWrite;
        end;
     
        // Запускаем компилятор из командной строки
        WorkDir := ExtractFilePath(CommandLine);
        WasOK := CreateProcess(nil, PChar(CommandLine), nil, nil, True,
                               0, nil, PChar(WorkDir), SI, PI);
     
        // Теперь, когда дескриптор получен, для безопасности закрываем запись.
        // Нам не нужно, чтобы произошло случайное чтение или запись.
        CloseHandle(StdOutPipeWrite); 
        // если процесс может быть создан, то дескриптор, это его вывод
        if not WasOK then
          raise Exception.Create('Could not execute command line!')
        else
          try
            // получаем весь вывод до тех пор, пока DOS-приложение не будет завершено
            Line := '';
            repeat
              // читаем блок символов (могут содержать возвраты каретки и переводы строки)
              WasOK := ReadFile(StdOutPipeRead, Buffer, 255, BytesRead, nil);
     
              // есть ли что-нибудь ещё для чтения?
              if BytesRead > 0 then
              begin
                // завершаем буфер PChar-ом
                Buffer[BytesRead] := #0;
                // добавляем буфер в общий вывод
                Line := Line + Buffer;
              end;
            until not WasOK or (BytesRead = 0);
            // ждём, пока завершится консольное приложение
            WaitForSingleObject(PI.hProcess, INFINITE);
          finally
            // Закрываем все оставшиеся дескрипторы
            CloseHandle(PI.hThread);
            CloseHandle(PI.hProcess);
          end;
      finally
          result:=Line;
          CloseHandle(StdOutPipeRead);
      end;
    end;
     
     
    end.


------------------------------------------------------------------------

Вариант 2:

Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>

    {
    This function runs a program (console or batch)
    and adds its output to Memo1
    }
     
    {....}
      private
        function RunCaptured(const _dirName, _exeName, _cmdLine: string): Boolean;
     
    {....}
     
    function TForm1.RunCaptured(const _dirName, _exeName, _cmdLine: string): Boolean;
    var
      start: TStartupInfo;
      procInfo: TProcessInformation;
      tmpName: string;
      tmp: Windows.THandle;
      tmpSec: TSecurityAttributes;
      res: TStringList;
      return: Cardinal;
    begin
      Result := False;
      try
        { Set a temporary file }
        tmpName := 'Test.tmp';
        FillChar(tmpSec, SizeOf(tmpSec), #0);
        tmpSec.nLength := SizeOf(tmpSec);
        tmpSec.bInheritHandle := True;
        tmp := Windows.CreateFile(PChar(tmpName),
               Generic_Write, File_Share_Write,
               @tmpSec, Create_Always, File_Attribute_Normal, 0);
        try
          FillChar(start, SizeOf(start), #0);
          start.cb          := SizeOf(start);
          start.hStdOutput  := tmp;
          start.dwFlags     := StartF_UseStdHandles or StartF_UseShowWindow;
          start.wShowWindow := SW_Minimize;
          { Start the program }
          if CreateProcess(nil, PChar(_exeName + ' ' + _cmdLine), nil, nil, True,
                           0, nil, PChar(_dirName), start, procInfo) then
          begin
            SetPriorityClass(procInfo.hProcess, Idle_Priority_Class);
            WaitForSingleObject(procInfo.hProcess, Infinite);
            GetExitCodeProcess(procInfo.hProcess, return);
            Result := (return = 0);
            CloseHandle(procInfo.hThread);
            CloseHandle(procInfo.hProcess);
            Windows.CloseHandle(tmp);
            { Add the output }
            res := TStringList.Create;
            try
              res.LoadFromFile(tmpName);
              Memo1.Lines.AddStrings(res);
            finally
              res.Free;
            end;
            Windows.DeleteFile(PChar(tmpName));
          end
          else
          begin
            Application.MessageBox(PChar(SysErrorMessage(GetLastError())),
              'RunCaptured Error', MB_OK);
          end;
        except
          Windows.CloseHandle(tmp);
          Windows.DeleteFile(PChar(tmpName));
          raise;
        end;
      finally
      end;
    end;
     
     
    // Example:
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      RunCaptured('C:\', 'cmd.exe', '/c dir');
    end;

----------------------------------------------------------------

Вариант 3:

Author: Song

Source: <https://forum.sources.ru>

    procedure RunDosInMemo(CmdLine: string; AMemo: TMemo);
    const
      ReadBuffer = 2400;
    var
      Security: TSecurityAttributes;
      ReadPipe, WritePipe: THandle;
      start: TStartUpInfo;
      ProcessInfo: TProcessInformation;
      Buffer: Pchar;
      BytesRead: DWord;
      Apprunning: DWord;
    begin
      Screen.Cursor := CrHourGlass;
      Form1.Button1.Enabled := False;
      with Security do
      begin
        nlength := SizeOf(TSecurityAttributes);
        binherithandle := true;
        lpsecuritydescriptor := nil;
      end;
      if Createpipe(ReadPipe, WritePipe,
        @Security, 0) then
      begin
        Buffer := AllocMem(ReadBuffer + 1);
        FillChar(Start, Sizeof(Start), #0);
        start.cb := SizeOf(start);
        start.hStdOutput := WritePipe;
        start.hStdInput := ReadPipe;
        start.dwFlags := STARTF_USESTDHANDLES +
          STARTF_USESHOWWINDOW;
        start.wShowWindow := SW_HIDE;
     
        if CreateProcess(nil,
          PChar(CmdLine),
          @Security,
          @Security,
          true,
          NORMAL_PRIORITY_CLASS,
          nil,
          nil,
          start,
          ProcessInfo) then
        begin
          repeat
            Apprunning := WaitForSingleObject
              (ProcessInfo.hProcess, 100);
            ReadFile(ReadPipe, Buffer[0],
              ReadBuffer, BytesRead, nil);
            Buffer[BytesRead] := #0;
            OemToAnsi(Buffer, Buffer);
            AMemo.Text := AMemo.text + string(Buffer);
     
            Application.ProcessMessages;
          until (Apprunning <> WAIT_TIMEOUT);
        end;
        FreeMem(Buffer);
        CloseHandle(ProcessInfo.hProcess);
        CloseHandle(ProcessInfo.hThread);
        CloseHandle(ReadPipe);
        CloseHandle(WritePipe);
      end;
      Screen.Cursor := CrDefault;
      Form1.Button1.Enabled := True;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Memo1.Clear;
      RunDosInMemo('ping -t 192.168.28.200', Memo1);
    end;

------------------------------------------------------------------------

Вариант 4:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Hужно использовать пайпы (CreatePipe), и работать с ними как с обычным
файлом.

    const
      H_IN_READ = 1;
      H_IN_WRITE = 2;
      H_OUT_READ = 3;
      H_OUT_WRITE = 4;
      H_ERR_READ = 5;
      H_ERR_WRITE = 6;
     
    type
      TPipeHandles = array [1..6] of THandle;
    var
      hPipes: TPipeHandles;
      ProcessInfo: TProcessInformation;
     
    (************CREATE HIDDEN CONSOLE PROCESS************)
    function CreateHiddenConsoleProcess(szChildName: string;
             ProcPriority: DWORD; ThreadPriority: integer): Boolean;
    label
      error;
    var
      fCreated: Boolean;
      si: TStartupInfo;
      sa: TSecurityAttributes;
    begin
      // Initialize handles
      hPipes[ H_IN_READ ] := INVALID_HANDLE_VALUE;
      hPipes[ H_IN_WRITE ] := INVALID_HANDLE_VALUE;
      hPipes[ H_OUT_READ ] := INVALID_HANDLE_VALUE;
      hPipes[ H_OUT_WRITE ] := INVALID_HANDLE_VALUE;
      hPipes[ H_ERR_READ ] := INVALID_HANDLE_VALUE;
      hPipes[ H_ERR_WRITE ] := INVALID_HANDLE_VALUE;
      ProcessInfo.hProcess := INVALID_HANDLE_VALUE;
      ProcessInfo.hThread := INVALID_HANDLE_VALUE;
      // Create pipes
      // initialize security attributes for handle inheritance (for WinNT)
      sa.nLength := sizeof(sa);
      sa.bInheritHandle := TRUE;
      sa.lpSecurityDescriptor := nil;
      // create STDIN pipe
      if not CreatePipe( hPipes[ H_IN_READ ], hPipes[ H_IN_WRITE ], @sa, 0 ) then
        goto error;
      // create STDOUT pipe
      if not CreatePipe( hPipes[ H_OUT_READ ], hPipes[ H_OUT_WRITE ], @sa, 0 ) then
        goto error;
      // create STDERR pipe
      if not CreatePipe( hPipes[ H_ERR_READ ], hPipes[ H_ERR_WRITE ], @sa, 0 ) then
        goto error;
      // process startup information
      ZeroMemory(Pointer(@si), sizeof(si));
      si.cb := sizeof(si);
      si.dwFlags := STARTF_USESHOWWINDOW or STARTF_USESTDHANDLES;
      si.wShowWindow := SW_HIDE;
      // assign "other" sides of pipes
      si.hStdInput := hPipes[ H_IN_READ ];
      si.hStdOutput := hPipes[ H_OUT_WRITE ];
      si.hStdError := hPipes[ H_ERR_WRITE ];
      // Create a child process
      try
        fCreated := CreateProcess( nil, PChar(szChildName), nil, nil, True,
        ProcPriority, // CREATE_SUSPENDED,
        nil, nil, si, ProcessInfo );
      except
        fCreated := False;
      end;
     
      if not fCreated then
        goto error;
     
      Result := True;
      CloseHandle(hPipes[ H_OUT_WRITE ]);
      CloseHandle(hPipes[ H_ERR_WRITE ]);
      // ResumeThread( pi.hThread );
      SetThreadPriority(ProcessInfo.hThread, ThreadPriority);
      CloseHandle( ProcessInfo.hThread );
      Exit;
      //-----------------------------------------------------
      error:
        ClosePipes( hPipes );
        CloseHandle( ProcessInfo.hProcess );
        CloseHandle( ProcessInfo.hThread );
        ProcessInfo.hProcess := INVALID_HANDLE_VALUE;
        ProcessInfo.hThread := INVALID_HANDLE_VALUE;
        Result := False;
    end;


------------------------------------------------------------------------

Вариант 5:

Author: Алексей Бойко

Source: <https://forum.sources.ru>

Это пример запуска консольных программ с передачей ей консольного ввода
(как если бы он был введен с клавиатуры после запуска программы) и
чтением консольного вывода. Таким способом можно запускать например
стандартный виндовый ftp.exe (в невидимом окне) и тем самым отказаться
от использования специализированных, зачастую глючных компонент.

    function ExecuteFile(FileName, StdInput: string;
      TimeOut: integer;
      var StdOutput: string): boolean;
     
    label
      Error;
     
    type
      TPipeHandles = (IN_WRITE, IN_READ,
        OUT_WRITE, OUT_READ,
        ERR_WRITE, ERR_READ);
     
    type
      TPipeArray = array[TPipeHandles] of THandle;
     
    var
      i: integer;
      ph: TPipeHandles;
      sa: TSecurityAttributes;
      Pipes: TPipeArray;
      StartInf: TStartupInfo;
      ProcInf: TProcessInformation;
      Buf: array[0..1024] of byte;
      TimeStart: TDateTime;
     
      function ReadOutput: string;
      var
        i: integer;
        s: string;
        BytesRead: longint;
     
      begin
        Result := '';
        repeat
     
          Buf[0] := 26;
          WriteFile(Pipes[OUT_WRITE], Buf, 1, BytesRead, nil);
          if ReadFile(Pipes[OUT_READ], Buf, 1024, BytesRead, nil) then
          begin
            if BytesRead > 0 then
            begin
              buf[BytesRead] := 0;
              s := StrPas(@Buf[0]);
              i := Pos(#26, s);
              if i > 0 then
                s := copy(s, 1, i - 1);
              Result := Result + s;
            end;
          end;
     
          if BytesRead1024 then
            break;
        until false;
      end;
     
    begin
      Result := false;
      for ph := Low(TPipeHandles) to High(TPipeHandles) do
        Pipes[ph] := INVALID_HANDLE_VALUE;
     
      // Создаем пайпы
      sa.nLength := sizeof(sa);
      sa.bInheritHandle := TRUE;
      sa.lpSecurityDescriptor := nil;
     
      if not CreatePipe(Pipes[IN_READ], Pipes[IN_WRITE], @sa, 0) then
        goto Error;
      if not CreatePipe(Pipes[OUT_READ], Pipes[OUT_WRITE], @sa, 0) then
        goto Error;
      if not CreatePipe(Pipes[ERR_READ], Pipes[ERR_WRITE], @sa, 0) then
        goto Error;
     
      // Пишем StdIn
      StrPCopy(@Buf[0], stdInput + ^Z);
      WriteFile(Pipes[IN_WRITE], Buf, Length(stdInput), i, nil);
     
      // Хендл записи в StdIn надо закрыть - иначе выполняемая программа
      // может не прочитать или прочитать не весь StdIn.
     
      CloseHandle(Pipes[IN_WRITE]);
     
      Pipes[IN_WRITE] := INVALID_HANDLE_VALUE;
     
      FillChar(StartInf, sizeof(TStartupInfo), 0);
      StartInf.cb := sizeof(TStartupInfo);
      StartInf.dwFlags := STARTF_USESHOWWINDOW or STARTF_USESTDHANDLES;
     
      StartInf.wShowWindow := SW_SHOW; // SW_HIDE если надо запустить невидимо
     
      StartInf.hStdInput := Pipes[IN_READ];
      StartInf.hStdOutput := Pipes[OUT_WRITE];
      StartInf.hStdError := Pipes[ERR_WRITE];
     
      if not CreateProcess(nil, PChar(FileName), nil,
        nil, True, NORMAL_PRIORITY_CLASS,
        nil, nil, StartInf, ProcInf) then
        goto Error;
     
      TimeStart := Now;
     
      repeat
        Application.ProcessMessages;
        i := WaitForSingleObject(ProcInf.hProcess, 100);
        if i = WAIT_OBJECT_0 then
          break;
        if (Now - TimeStart) * SecsPerDay > TimeOut then
          break;
      until false;
     
      if iWAIT_OBJECT_0 then
        goto Error;
      StdOutput := ReadOutput;
     
      for ph := Low(TPipeHandles) to High(TPipeHandles) do
        if Pipes[ph]INVALID_HANDLE_VALUE then
          CloseHandle(Pipes[ph]);
     
      CloseHandle(ProcInf.hProcess);
      CloseHandle(ProcInf.hThread);
      Result := true;
      Exit;
     
      Error:
     
      if ProcInf.hProcessINVALID_HANDLE_VALUE then
     
      begin
        CloseHandle(ProcInf.hThread);
        i := WaitForSingleObject(ProcInf.hProcess, 1000);
        CloseHandle(ProcInf.hProcess);
        if iWAIT_OBJECT_0 then
     
        begin
          ProcInf.hProcess := OpenProcess(PROCESS_TERMINATE,
            FALSE,
            ProcInf.dwProcessId);
     
          if ProcInf.hProcess 0 then
          begin
            TerminateProcess(ProcInf.hProcess, 0);
            CloseHandle(ProcInf.hProcess);
          end;
        end;
      end;
     
      for ph := Low(TPipeHandles) to High(TPipeHandles) do
        if Pipes[ph]INVALID_HANDLE_VALUE then
          CloseHandle(Pipes[ph]);
     
    end;

