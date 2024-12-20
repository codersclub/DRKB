---
Title: Получить выходные данные DOS приложения
Author: Theodoros Bebekis, bebekis@otenet.gr 
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---

Получить выходные данные DOS приложения
=======================================

    {----------------------------CreateDOSProcessRedirected--------------------------- 
     Description    : executes a (DOS!) app defined in the CommandLine parameter redirected 
                      to take input from InputFile and give output to OutputFile 
     Result         : True on success 
     Parameters     : 
                      CommandLine : the command line for the app, including its full path 
                      InputFile   : the ascii file where from the app takes input 
                      OutputFile  : the ascii file to which the app's output is redirected 
                      ErrMsg      : additional error message string. Can be empty 
     Error checking : YES 
     Target         : Delphi 2, 3, 4 
     Author         : Theodoros Bebekis, email bebekis@otenet.gr 
     Notes          : 
     Example call   : CreateDOSProcessRedirected('C:\MyDOSApp.exe', 
                                                 'C:\InputPut.txt', 
                                                 'C:\OutPut.txt', 
                                                 'Please, record this message') 
    -----------------------------------------------------------------------------------}
     
     function CreateDOSProcessRedirected(const CommandLine, InputFile, OutputFile,
       ErrMsg: string): Boolean;
     const
       ROUTINE_ID = '[function: CreateDOSProcessRedirected ]';
     var
       OldCursor: TCursor;
       pCommandLine: array[0..MAX_PATH] of Char;
       pInputFile, pOutPutFile: array[0..MAX_PATH] of Char;
       StartupInfo: TStartupInfo;
       ProcessInfo: TProcessInformation;
       SecAtrrs: TSecurityAttributes;
       hAppProcess, hAppThread, hInputFile, hOutputFile: THandle;
     begin
       Result := False;
     
       { check for InputFile existence }
       if not FileExists(InputFile) then
         raise Exception.CreateFmt(ROUTINE_ID + #10 + #10 +
           'Input file * %s *' + #10 +
           'does not exist' + #10 + #10 +
           ErrMsg, [InputFile]);
     
       { save the cursor }
       OldCursor     := Screen.Cursor;
       Screen.Cursor := crHourglass;
     
       { copy the parameter Pascal strings to null terminated strings }
       StrPCopy(pCommandLine, CommandLine);
       StrPCopy(pInputFile, InputFile);
       StrPCopy(pOutPutFile, OutputFile);
     
       try
     
         { prepare SecAtrrs structure for the CreateFile calls 
          This SecAttrs structure is needed in this case because 
          we want the returned handle can be inherited by child process 
          This is true when running under WinNT. 
          As for Win95 the documentation is quite ambiguous }
         FillChar(SecAtrrs, SizeOf(SecAtrrs), #0);
         SecAtrrs.nLength        := SizeOf(SecAtrrs);
         SecAtrrs.lpSecurityDescriptor := nil;
         SecAtrrs.bInheritHandle := True;
     
         { create the appropriate handle for the input file }
         hInputFile := CreateFile(pInputFile,
           { pointer to name of the file }
           GENERIC_READ or GENERIC_WRITE,
           { access (read-write) mode }
           FILE_SHARE_READ or FILE_SHARE_WRITE,
           { share mode } @SecAtrrs,  { pointer to security attributes }
           OPEN_ALWAYS,               { how to create }
           FILE_ATTRIBUTE_TEMPORARY,  { file attributes }
           0);                        { handle to file with attributes to copy }
     
     
         { is hInputFile a valid handle? }
         if hInputFile = INVALID_HANDLE_VALUE then
           raise Exception.CreateFmt(ROUTINE_ID + #10 + #10 +
             'WinApi function CreateFile returned an invalid handle value' +
             #10 +
             'for the input file * %s *' + #10 + #10 +
             ErrMsg, [InputFile]);
     
         { create the appropriate handle for the output file }
         hOutputFile := CreateFile(pOutPutFile,
           { pointer to name of the file }
           GENERIC_READ or GENERIC_WRITE,
           { access (read-write) mode }
           FILE_SHARE_READ or FILE_SHARE_WRITE,
           { share mode } @SecAtrrs,  { pointer to security attributes }
           CREATE_ALWAYS,             { how to create }
           FILE_ATTRIBUTE_TEMPORARY,  { file attributes }
           0);                        { handle to file with attributes to copy }
     
         { is hOutputFile a valid handle? }
         if hOutputFile = INVALID_HANDLE_VALUE then
           raise Exception.CreateFmt(ROUTINE_ID + #10 + #10 +
             'WinApi function CreateFile returned an invalid handle value' +
             #10 +
             'for the output file * %s *' + #10 + #10 +
             ErrMsg, [OutputFile]);
     
         { prepare StartupInfo structure }
         FillChar(StartupInfo, SizeOf(StartupInfo), #0);
         StartupInfo.cb          := SizeOf(StartupInfo);
         StartupInfo.dwFlags     := STARTF_USESHOWWINDOW or STARTF_USESTDHANDLES;
         StartupInfo.wShowWindow := SW_HIDE;
         StartupInfo.hStdOutput  := hOutputFile;
         StartupInfo.hStdInput   := hInputFile;
     
         { create the app }
         Result := CreateProcess(nil, { pointer to name of executable module }
           pCommandLine,              { pointer to command line string }
           nil,                       { pointer to process security attributes }
           nil,                       { pointer to thread security attributes }
           True,                      { handle inheritance flag }
           CREATE_NEW_CONSOLE or
           REALTIME_PRIORITY_CLASS,   { creation flags }
           nil,                       { pointer to new environment block }
           nil,                       { pointer to current directory name }
           StartupInfo,               { pointer to STARTUPINFO }
           ProcessInfo);              { pointer to PROCESS_INF }
     
         { wait for the app to finish its job and take the handles to free them later }
         if Result then
         begin
           WaitForSingleObject(ProcessInfo.hProcess, INFINITE);
           hAppProcess := ProcessInfo.hProcess;
           hAppThread  := ProcessInfo.hThread;
         end
         else
           raise Exception.Create(ROUTINE_ID + #10 + #10 +
             'Function failure' + #10 + #10 +
             ErrMsg);
     
       finally
         { close the handles 
          Kernel objects, like the process and the files we created in this case, 
          are maintained by a usage count. 
          So, for cleaning up purposes we have to close the handles 
          to inform the system that we don't need the objects anymore }
         if hOutputFile <> 0 then CloseHandle(hOutputFile);
         if hInputFile <> 0 then CloseHandle(hInputFile);
         if hAppThread <> 0 then CloseHandle(hAppThread);
         if hAppProcess <> 0 then CloseHandle(hAppProcess);
         { restore the old cursor }
         Screen.Cursor := OldCursor;
       end;
     end;

