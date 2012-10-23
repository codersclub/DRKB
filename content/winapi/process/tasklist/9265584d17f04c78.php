<h1>Как увеличить процессорное время, выделяемого программе?</h1>
<div class="date">01.01.2007</div>


<p>Следующий пример изменяет приоритет приложения. Изменение приоритета следует использовать</p>
<p> с осторожностью - т.к. присвоение слишком высокого приоритета может привети к</p>
<p>медленной работе остальных программ и системы в целом. См. Win32 help for SetThreadPriority() function.</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);  
  var    ProcessID : DWORD;   
   ProcessHandle : THandle;
   ThreadHandle : THandle;  
begin
  ProcessID := GetCurrentProcessID; 
  ProcessHandle := OpenProcess(PROCESS_SET_INFORMATION, false,  ProcessID); 
  SetPriorityClass(ProcessHandle, REALTIME_PRIORITY_CLASS);  
  ThreadHandle := GetCurrentThread;
  SetThreadPriority(ThreadHandle, THREAD_PRIORITY_TIME_CRITICAL);
end;
</pre>


<p>Взято с сайта <a href="https://blackman.wp-club.net/" target="_blank">https://blackman.wp-club.net/</a></p>
