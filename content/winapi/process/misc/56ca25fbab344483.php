<h1>Как программе удалить саму себя?</h1>
<div class="date">01.01.2007</div>


<p>Первый способ:</p>
<pre>
uses 
  Windows, SysUtils; 
 
procedure DeleteMe; 
var 
  BatchFile: TextFile; 
  BatchFileName: string; 
  ProcessInfo: TProcessInformation; 
  StartUpInfo: TStartupInfo; 
begin 
  { создаём бат-файл в директории приложения }
  BatchFileName := ExtractFilePath(ParamStr(0)) + '$$336699.bat'; 
 
  { открываем и записываем в файл }
  AssignFile(BatchFile, BatchFileName); 
  Rewrite(BatchFile); 
 
  Writeln(BatchFile, ':try'); 
  Writeln(BatchFile, 'del "' + ParamStr(0) + '"'); 
  Writeln(BatchFile, 
    'if exist "' + ParamStr(0) + '"' + ' goto try'); 
  Writeln(BatchFile, 'del "' + BatchFileName + '"'); 
  CloseFile(BatchFile); 
 
  FillChar(StartUpInfo, SizeOf(StartUpInfo), $00); 
  StartUpInfo.dwFlags := STARTF_USESHOWWINDOW; 
  StartUpInfo.wShowWindow := SW_HIDE; 
 
  if CreateProcess(nil, PChar(BatchFileName), nil, nil, 
     False, IDLE_PRIORITY_CLASS, nil, nil, StartUpInfo, 
     ProcessInfo) then 
  begin 
    CloseHandle(ProcessInfo.hThread); 
    CloseHandle(ProcessInfo.hProcess); 
  end; 
 
end;
</pre>


<p>А вот тот же способ, но немного модифицированный:</p>
<pre>
program delete2; 
 
uses 
  SysUtils, 
  windows; 
 
var 
   BatchFile: TextFile; 
   BatchFileName : string; 
   TM : Cardinal; 
   TempMem : PChar; 
 
begin 
   BatchFileName:=ExtractFilePath(ParamStr(0))+ '$$336699.bat'; 
 
 
   AssignFile(BatchFile, BatchFileName); 
   Rewrite(BatchFile); 
 
   Writeln(BatchFile,':try'); 
   Writeln(BatchFile,'del "' + ParamStr(0) + '"'); 
   Writeln(BatchFile,'if exist "' + ParamStr(0) + '" goto try'); 
   Writeln(BatchFile,'del "' + BatchFileName + '"'); 
   CloseFile(BatchFile); 
 
   TM:=70; 
   GetMem (TempMem,TM); 
   GetShortPathName (pchar(BatchFileName), TempMem, TM); 
   BatchFileName:=TempMem; 
   FreeMem(TempMem); 
 
   winexec(Pchar(BatchFileName),sw_hide); 
 
   halt; 
 
end.
</pre>

<p>Второй способ:</p>

<pre>
procedure DeleteSelf; 
var 
  module: HModule; 
  buf: array[0..MAX_PATH - 1] of char; 
  p: ULong; 
  hKrnl32: HModule; 
  pExitProcess, 
  pDeleteFile, 
  pFreeLibrary: pointer; 
begin 
  module := GetModuleHandle(nil); 
  GetModuleFileName(module, buf, SizeOf(buf)); 
  CloseHandle(THandle(4)); 
  p := ULONG(module) + 1; 
  hKrnl32 := GetModuleHandle('kernel32'); 
  pExitProcess := GetProcAddress(hKrnl32, 'ExitProcess'); 
  pDeleteFile := GetProcAddress(hKrnl32, 'DeleteFileA'); 
  pFreeLibrary := GetProcAddress(hKrnl32, 'FreeLibrary'); 
  asm 
    lea eax, buf 
    push 0 
    push 0 
    push eax 
    push pExitProcess 
    push p 
    push pDeleteFile 
    push pFreeLibrary 
    ret 
  end; 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

