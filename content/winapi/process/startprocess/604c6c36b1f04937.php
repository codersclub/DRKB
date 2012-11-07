<h1>Как запустить программу и подождать её завершения?</h1>
<div class="date">01.01.2007</div>


<pre>
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
</pre>

<div class="author">Автор: TAPAKAH</div>
<p class="note">Примечание Vit:</p>
<p>Если заменить</p>
<p>WaitForSingleObject(pi.hProcess,INFINITE);</p>
<p>на</p>
<p>while WaitforSingleObject(PI.hProcess,200)=WAIT_TIMEOUT do   application.ProcessMessages;</p>
<p>то вызывающая программа не будет казаться завешанной и будет отвечать на сообщения</p>
<p class="note">Примечание Mikel: В RxLib есть функция для этого: FileExecuteWait</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>Здесь представлена функция, которая вызывается таким же образом как и WinExec, однако она ждёт, пока запущенная задача завершится.</p>
<pre>
function WinExecAndWait(Path: PChar; Visibility: Word): Word; 
var 
  InstanceID: THandle; 
  Msg: TMsg; 
begin 
  InstanceID := WinExec(Path, Visibility); 
  if InstanceID &lt; 32 then { значение меньше чем 32 указывает на ошибку }
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
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<hr />
<div class="author">Автор: Fabrнcio Fadel Kammer</div>
<p>Пример показывает как из Вашей программы запустить внешнее приложение и подождать его завершения.</p>
<pre>
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
</pre>
<p>А вот пример вызова этой функции:</p>
<pre>
ExecAndWait( 'C:\windows\calc.exe', '', SH_SHOWNORMAL);
</pre>
<p>Параметр FileName = Имя внешней программы.</p>
<p>Параметр Params = Параметры, необходимые для запуска внешней программы</p>
<p>Параметр WinState = Указывает - как будет показано окно:</p>
<p>                Для этого параметра мы можем так же использовать следующие константы:</p>
<p>                SW_HIDE, SW_MAXIMIZE, SW_MINIMIZE, SW_SHOWNORMAL</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

