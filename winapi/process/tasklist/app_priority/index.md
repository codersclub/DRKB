---
Title: Как увеличить процессорное время, выделяемого программе?
Date: 01.01.2007
Source: <https://blackman.wp-club.net/>
---

Как увеличить процессорное время, выделяемого программе?
========================================================

Следующий пример изменяет приоритет приложения. Изменение приоритета
следует использовать
с осторожностью - т.к. присвоение слишком высокого приоритета может
привести к
медленной работе остальных программ и системы в целом.

См. Win32 help for SetThreadPriority() function.

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

