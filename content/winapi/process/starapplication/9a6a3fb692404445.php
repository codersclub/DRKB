<h1>Запустить приложение и подождать</h1>
<div class="date">01.01.2007</div>


<pre>
Function ExecuteFile(FileName, Params, WorkingDir:string; Wait:boolean):integer;

var
  buffer: array[0..511] of Char;
  TmpStr: String;
  i: Integer;
  StartupInfo:TStartupInfo;
  ProcessInfo:TProcessInformation;
  ext, key, fname, path:string;
  exitcode:cardinal;
begin
  if WorkingDir&lt;&gt;'' then ChDir(WorkingDir);
  ext:=lowercase(ExtractFileExt(FileName));
  path:=ExtractFilePath(FileName);
  if ext&lt;&gt;'.exe' then
    With TRegistry.create do
      try
        RootKey:=HKEY_CLASSES_ROOT;
        OpenKey(ext, false);
        Key:=ReadString('');
        CloseKey;
        OpenKey(key+'\Shell\open\command', false);
        key:=ReadString('');
        fname:=ExtractFileName(key);
        if pos('/', fname)&gt;0 then fname:=copy(fname,1, pos('/',fname)-1);
        FName:=StringReplace(FName, '%1', '', [rfReplaceAll, rfIgnoreCase]);
        if pos(' ',FileName)&gt;0 then FileName:='"'+Filename+'"';
        TmpStr:=ExtractFilePath(key)+Fname+' '+FileName;
        if Params&lt;&gt;'' then TmpStr := TmpStr + ' ' + Params;
        Closekey;
      finally
        free;
      end
  else
    begin
      TmpStr := FileName;
      TmpStr := TmpStr + ' ' + Params;
    end;
  StrPCopy(buffer,TmpStr);
  FillChar(StartupInfo,Sizeof(StartupInfo),#0);
  StartupInfo.cb := Sizeof(StartupInfo);
  StartupInfo.dwFlags := STARTF_USESHOWWINDOW;
  StartupInfo.wShowWindow := SW_SHOWNORMAL;
  if CreateProcess(nil, buffer, nil, nil, false, CREATE_NEW_CONSOLE or NORMAL_PRIORITY_CLASS, nil, nil, StartupInfo, ProcessInfo) then
    begin
      if Wait then
        begin
          while WaitforSingleObject(ProcessInfo.hProcess,200)=WAIT_TIMEOUT         do application.ProcessMessages;
          GetExitCodeProcess(ProcessInfo.hProcess, exitcode);
        end;
    end
  else
    Result := GetLastError();
end;
</pre>

<p class="author">Автор: Vit</p>

