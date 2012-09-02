<h1>Как поменять приоритет моего приложения?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  ProcessID: DWORD;
  ProcessHandle: THandle;
  ThreadHandle: THandle;
begin
  ProcessID := GetCurrentProcessID;
  ProcessHandle := OpenProcess(PROCESS_SET_INFORMATION,
    false, ProcessID);
  SetPriorityClass(ProcessHandle, REALTIME_PRIORITY_CLASS);
  ThreadHandle := GetCurrentThread;
  SetThreadPriority(ThreadHandle, THREAD_PRIORITY_TIME_CRITICAL);
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

