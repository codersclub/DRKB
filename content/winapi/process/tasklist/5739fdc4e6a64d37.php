<h1>Как получить / установить приоритет процесса?</h1>
<div class="date">01.01.2007</div>


<pre>
const 
    ppIdle                  : Integer = -1; 
    ppNormal                : Integer =  0; 
    ppHigh                  : Integer =  1; 
    ppRealTime              : Integer =  2; 
 
function SetProcessPriority( Priority : Integer ) : Integer; 
var 
    H : THandle; 
begin 
    Result := ppNormal; 
    H := GetCurrentProcess(); 
    if ( Priority = ppIdle ) then 
        SetPriorityClass( H, IDLE_PRIORITY_CLASS ) 
    else If ( Priority = ppNormal ) then 
        SetPriorityClass( H, NORMAL_PRIORITY_CLASS ) 
    else If ( Priority = ppHigh ) then 
        SetPriorityClass( H, HIGH_PRIORITY_CLASS ) 
    else If ( Priority = ppRealTime ) then 
        SetPriorityClass( H, REALTIME_PRIORITY_CLASS ); 
    case GetPriorityClass( H ) of 
        IDLE_PRIORITY_CLASS     : Result := ppIdle; 
        NORMAL_PRIORITY_CLASS   : Result := ppNormal; 
        HIGH_PRIORITY_CLASS     : Result := ppHigh; 
        REALTIME_PRIORITY_CLASS : Result := ppRealTime; 
    end; 
end; 
 
function GetProcessPriority : Integer; 
var 
    H : THandle; 
begin 
    Result := ppNormal; 
    H := GetCurrentProcess(); 
    case GetPriorityClass( H ) of 
        IDLE_PRIORITY_CLASS     : Result := ppIdle; 
        NORMAL_PRIORITY_CLASS   : Result := ppNormal; 
        HIGH_PRIORITY_CLASS     : Result := ppHigh; 
        REALTIME_PRIORITY_CLASS : Result := ppRealTime; 
    end; 
end; 
</pre>


<p>Как использовать:</p>

<p> &nbsp;&nbsp; Function SetProcessPriority( Priority : Integer ) : Integer;</p>

<p>для установки приоритета Вашего приложения, либо:</p>

<p> &nbsp;&nbsp; Function GetProcessPriority : Integer;</p>

<p>для получения приоритета.</p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<hr />Следующий пример изменяет приоритет приложения. Изменение приоритета следует использовать с осторожностью - т.к. присвоение слишком высокого приоритета может привети к медленной работе остальных программ и системы в целом. См. Win32 help for SetThreadPriority() function.</p>

<pre>
  procedure TForm1.Button1Click(Sender: TObject);
  var
    ProcessID : DWORD;
    ProcessHandle : THandle;
    ThreadHandle : THandle;
  begin
    ProcessID := GetCurrentProcessID;
    ProcessHandle := OpenProcess(PROCESS_SET_INFORMATION,
                                 false,
                                 ProcessID);
    SetPriorityClass(ProcessHandle, REALTIME_PRIORITY_CLASS);
    ThreadHandle := GetCurrentThread;
    SetThreadPriority(ThreadHandle, THREAD_PRIORITY_TIME_CRITICAL);
  end;
</pre>

