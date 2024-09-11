---
Title: CreateProcess, который возвращает консольный вывод
Date: 01.01.2007
---

CreateProcess, который возвращает консольный вывод
==================================================

    procedure ExecConsoleApp(CommandLine: AnsiString;
      Output: TStringList; Errors: TStringList);
    var
      sa: TSECURITYATTRIBUTES;
      si: TSTARTUPINFO;
      pi: TPROCESSINFORMATION;
      hPipeOutputRead: THANDLE;
      hPipeOutputWrite: THANDLE;
      hPipeErrorsRead: THANDLE;
      hPipeErrorsWrite: THANDLE;
      Res, bTest: Boolean;
      env: array[0..100] of Char;
      szBuffer: array[0..256] of Char;
      dwNumberOfBytesRead: DWORD;
      Stream: TMemoryStream;
    begin
      sa.nLength := sizeof(sa);
      sa.bInheritHandle := true;
      sa.lpSecurityDescriptor := nil;
      CreatePipe(hPipeOutputRead, hPipeOutputWrite, @sa, 0);
      CreatePipe(hPipeErrorsRead, hPipeErrorsWrite, @sa, 0);
      ZeroMemory(@env, SizeOf(env));
      ZeroMemory(@si, SizeOf(si));
      ZeroMemory(@pi, SizeOf(pi));
      si.cb := SizeOf(si);
      si.dwFlags := STARTF_USESHOWWINDOW or STARTF_USESTDHANDLES;
      si.wShowWindow := SW_HIDE;
      si.hStdInput := 0;
      si.hStdOutput := hPipeOutputWrite;
      si.hStdError := hPipeErrorsWrite;
     
      (* Remember that if you want to execute an app with no parameters you nil the
         second parameter and use the first, you can also leave it as is with no
         problems.                                                                 *)
      Res := CreateProcess(nil, pchar(CommandLine), nil, nil, true,
        CREATE_NEW_CONSOLE or NORMAL_PRIORITY_CLASS, @env, nil, si, pi);
     
      // Procedure will exit if CreateProcess fail
      if not Res then
      begin
        CloseHandle(hPipeOutputRead);
        CloseHandle(hPipeOutputWrite);
        CloseHandle(hPipeErrorsRead);
        CloseHandle(hPipeErrorsWrite);
        Exit;
      end;
      CloseHandle(hPipeOutputWrite);
      CloseHandle(hPipeErrorsWrite);
     
      //Read output pipe
      Stream := TMemoryStream.Create;
      try
        while true do
        begin
          bTest := ReadFile(hPipeOutputRead, szBuffer, 256, dwNumberOfBytesRead,
            nil);
          if not bTest then
          begin
            break;
          end;
          Stream.Write(szBuffer, dwNumberOfBytesRead);
        end;
        Stream.Position := 0;
        Output.LoadFromStream(Stream);
      finally
        Stream.Free;
      end;
     
      //Read error pipe
      Stream := TMemoryStream.Create;
      try
        while true do
        begin
          bTest := ReadFile(hPipeErrorsRead, szBuffer, 256, dwNumberOfBytesRead,
            nil);
          if not bTest then
          begin
            break;
          end;
          Stream.Write(szBuffer, dwNumberOfBytesRead);
        end;
        Stream.Position := 0;
        Errors.LoadFromStream(Stream);
      finally
        Stream.Free;
      end;
     
      WaitForSingleObject(pi.hProcess, INFINITE);
      CloseHandle(pi.hProcess);
      CloseHandle(hPipeOutputRead);
      CloseHandle(hPipeErrorsRead);
    end;
     
    (* got it from yahoo groups, so no copyrights for this piece :p and and example
       of how to use it. put a button and a memo to a form.                      *)
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      OutP: TStringList;
      ErrorP: TStringList;
    begin
      OutP := TStringList.Create;
      ErrorP := TstringList.Create;
     
      ExecConsoleApp('ping localhost', OutP, ErrorP);
      Memo1.Lines.Assign(OutP);
     
      OutP.Free;
      ErrorP.Free;
    end;
     
