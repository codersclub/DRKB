---
Title: Как поменять приоритет моего приложения?
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---

Как поменять приоритет моего приложения?
========================================

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

