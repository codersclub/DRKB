---
Title: Как вывести результат работы консоли в TMemo?
Date: 01.01.2007
---

Как вывести результат работы консоли в TMemo?
=============================================

Вариант 1:

Source: <https://www.torry.net/memos.htm>

    procedure Dos2Win(CmdLine:String; OutMemo:TMemo);
    const BUFSIZE = 2000;
    var SecAttr    : TSecurityAttributes;
        hReadPipe,
        hWritePipe : THandle;
        StartupInfo: TStartUpInfo;
        ProcessInfo: TProcessInformation;
        Buffer     : Pchar;
        WaitReason,
        BytesRead  : DWord;
    begin
     
     with SecAttr do
     begin
       nlength              := SizeOf(TSecurityAttributes);
       binherithandle       := true;
       lpsecuritydescriptor := nil;
     end;
     // Creazione della pipe
     if Createpipe (hReadPipe, hWritePipe, @SecAttr, 0) then
     begin
       Buffer  := AllocMem(BUFSIZE + 1);    // Allochiamo un buffer di dimensioni BUFSIZE+1
       FillChar(StartupInfo, Sizeof(StartupInfo), #0);
       StartupInfo.cb          := SizeOf(StartupInfo);
       StartupInfo.hStdOutput  := hWritePipe;
       StartupInfo.hStdInput   := hReadPipe;
       StartupInfo.dwFlags     := STARTF_USESTDHANDLES +
                                  STARTF_USESHOWWINDOW;
       StartupInfo.wShowWindow := SW_HIDE;
     
       if CreateProcess(nil,
          PChar(CmdLine),
          @SecAttr,
          @SecAttr,
          true,
          NORMAL_PRIORITY_CLASS,
          nil,
          nil,
          StartupInfo,
          ProcessInfo) then
         begin
           // Attendiamo la fine dell'esecuzione del processo
           repeat
             WaitReason := WaitForSingleObject( ProcessInfo.hProcess,100);
             Application.ProcessMessages;
           until (WaitReason <> WAIT_TIMEOUT);
           // Leggiamo la pipe
           Repeat
             BytesRead := 0;
             // Leggiamo "BUFSIZE" bytes dalla pipe
             ReadFile(hReadPipe, Buffer[0], BUFSIZE, BytesRead, nil);
             // Convertiamo in una stringa "\0 terminated"
             Buffer[BytesRead]:= #0;
             // Convertiamo i caratteri da DOS ad ANSI
             OemToAnsi(Buffer,Buffer);
             // Scriviamo nell' "OutMemo" l'output ricevuto tramite pipe
             OutMemo.Text := OutMemo.text + String(Buffer);
           until (BytesRead < BUFSIZE);
         end;
       FreeMem(Buffer);
       CloseHandle(ProcessInfo.hProcess);
       CloseHandle(ProcessInfo.hThread);
       CloseHandle(hReadPipe);
       CloseHandle(hWritePipe);
     end;
    end;

------------------------------------------------------------------------

Вариант 2:

Author: Song

Source: Vingrad.ru <https://forum.vingrad.ru>

А это исправленный Song\'ом вариант для обеспечения вывода текста в
real-time:

    procedure RunDosInMemo(CmdLine:String;AMemo:TMemo); 
     const 
       ReadBuffer = 2400; 
     var 
      Security           : TSecurityAttributes; 
      ReadPipe,WritePipe : THandle; 
      start              : TStartUpInfo; 
      ProcessInfo        : TProcessInformation; 
      Buffer             : Pchar; 
      BytesRead          : DWord; 
      Apprunning         : DWord; 
     begin 
      Screen.Cursor:=CrHourGlass; 
      Form1.Button1.Enabled:=False; 
      With Security do begin 
        nlength              := SizeOf(TSecurityAttributes); 
        binherithandle       := true; 
        lpsecuritydescriptor := nil; 
      end; 
      if Createpipe (ReadPipe, WritePipe, @Security, 0) then begin 
        Buffer  := AllocMem(ReadBuffer + 1); 
        FillChar(Start,Sizeof(Start),#0); 
        start.cb          := SizeOf(start); 
        start.hStdOutput  := WritePipe; 
        start.hStdInput   := ReadPipe; 
        start.dwFlags     := STARTF_USESTDHANDLES + STARTF_USESHOWWINDOW; 
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
          ProcessInfo) 
      then 
      begin 
       repeat 
       Apprunning := WaitForSingleObject (ProcessInfo.hProcess,100); 
        ReadFile(ReadPipe,Buffer[0], ReadBuffer,BytesRead,nil); 
        Buffer[BytesRead]:= #0; 
        OemToAnsi(Buffer,Buffer); 
        AMemo.Text := AMemo.text + String(Buffer); 
     
       Application.ProcessMessages; 
       until (Apprunning <> WAIT_TIMEOUT); 
      end; 
      FreeMem(Buffer); 
      CloseHandle(ProcessInfo.hProcess); 
      CloseHandle(ProcessInfo.hThread); 
      CloseHandle(ReadPipe); 
      CloseHandle(WritePipe); 
      end; 
      Screen.Cursor:=CrDefault; 
      Form1.Button1.Enabled:=True; 
     end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
     Memo1.Clear; 
     RunDosInMemo('ping -t 192.168.28.200',Memo1); 
    end;


------------------------------------------------------------------------

Вариант 3:

Author: Алексей Бойко

Source: <https://forum.sources.ru>

Это пример запуска консольных программ с передачей ей консольного ввода
(как если бы он был введен с клавиатуры после запуска программы) и
чтением консольного вывода. Таким способом можно запускать например
стандартный виндовый ftp.exe (в невидимом окне) и тем самым отказаться
от использования специализированных, зачастую глючных компонент.

    function ExecuteFile(FileName,StdInput: string;
                         TimeOut: integer;
                         var StdOutput:string) : boolean;
     
    label Error;
     
    type
      TPipeHandles = (IN_WRITE,  IN_READ,
                      OUT_WRITE, OUT_READ,
                      ERR_WRITE, ERR_READ);
     
    type
      TPipeArray = array [TPipeHandles] of THandle;
     
    var
      i         : integer;
      ph        : TPipeHandles;
      sa        : TSecurityAttributes;
      Pipes     : TPipeArray;
      StartInf  : TStartupInfo;
      ProcInf   : TProcessInformation;
      Buf       : array[0..1024] of byte;
      TimeStart : TDateTime;
     
    function ReadOutput : string;
    var
      i : integer;
      s : string;
      BytesRead : longint;
     
    begin
      Result := '';
      repeat
     
        Buf[0]:=26;
        WriteFile(Pipes[OUT_WRITE],Buf,1,BytesRead,nil);
        if ReadFile(Pipes[OUT_READ],Buf,1024,BytesRead,nil) then
        begin
          if BytesRead>0 then
          begin
            buf[BytesRead]:=0;
            s := StrPas(@Buf[0]);
            i := Pos(#26,s);
            if i>0 then s := copy(s,1,i-1);
            Result := Result + s;
          end;
        end;
     
        if BytesRead1024 then break;
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
     
      if not CreatePipe(Pipes[IN_READ],Pipes[IN_WRITE], @sa, 0 ) then
        goto Error;
      if not CreatePipe(Pipes[OUT_READ],Pipes[OUT_WRITE], @sa, 0 ) then
        goto Error;
      if not CreatePipe(Pipes[ERR_READ],Pipes[ERR_WRITE], @sa, 0 ) then
        goto Error;
     
      // Пишем StdIn
      StrPCopy(@Buf[0],stdInput+^Z);
      WriteFile(Pipes[IN_WRITE],Buf,Length(stdInput),i,nil);
     
      // Хендл записи в StdIn надо закрыть - иначе выполняемая программа
      // может не прочитать или прочитать не весь StdIn.
     
      CloseHandle(Pipes[IN_WRITE]);
     
      Pipes[IN_WRITE] := INVALID_HANDLE_VALUE;
     
      FillChar(StartInf,sizeof(TStartupInfo),0);
      StartInf.cb := sizeof(TStartupInfo);
      StartInf.dwFlags := STARTF_USESHOWWINDOW or STARTF_USESTDHANDLES;
     
      StartInf.wShowWindow := SW_SHOW; // SW_HIDE если надо запустить невидимо
     
      StartInf.hStdInput := Pipes[IN_READ];
      StartInf.hStdOutput := Pipes[OUT_WRITE];
      StartInf.hStdError := Pipes[ERR_WRITE];
     
      if not CreateProcess(nil, PChar(FileName), nil,
                           nil, True, NORMAL_PRIORITY_CLASS,
                           nil, nil, StartInf, ProcInf) then goto Error;
     
      TimeStart := Now;
     
      repeat
        Application.ProcessMessages;
        i := WaitForSingleObject(ProcInf.hProcess,100);
        if i = WAIT_OBJECT_0 then break;
        if (Now-TimeStart)*SecsPerDay>TimeOut then break;
      until false;
     
      if iWAIT_OBJECT_0 then goto Error;
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
     
          if ProcInf.hProcess  0 then
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

