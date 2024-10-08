---
Title: Как запустить процесс на конкретном процессоре в многопроцессорной системе?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---

Как запустить процесс на конкретном процессоре в многопроцессорной системе?
===========================================================================

    function ExecuteProcess(FileName: string; Visibility: Integer; BitMask: Integer; Synch: Boolean): Longword;
    //valori di Visibility:
    {
    Value               Meaning
    SW_HIDE            :Hides the window and activates another window.
    SW_MAXIMIZE        :Maximizes the specified window.
    SW_MINIMIZE        :Minimizes the specified window and activates the next top-level window in the Z order.
    SW_RESTORE         :Activates and displays the window. If the window is minimized or maximized,
                        Windows restores it to its original size and position. An application should
                        specify this flag when restoring a minimized window.
    SW_SHOW            :Activates the window and displays it in its current size and position.
    SW_SHOWDEFAULT     :Sets the show state based on the SW_ flag specified in the STARTUPINFO
                        structure passed to the CreateProcess function by the program that started the application.
    SW_SHOWMAXIMIZED   :Activates the window and displays it as a maximized window.
    SW_SHOWMINIMIZED   :Activates the window and displays it as a minimized window.
    SW_SHOWMINNOACTIVE :Displays the window as a minimized window. The active window remains active.
    SW_SHOWNA          :Displays the window in its current state. The active window remains active.
    SW_SHOWNOACTIVATE  :Displays a window in its most recent size and position. The active window remains active.
    SW_SHOWNORMAL      :Activates and displays a window. If the window is minimized or maximized,
                        Windows restores it to its original size and position. An application should specify this
                        flag when displaying the window for the first time.
    }
    //FileName: the name of the program I want to launch
    //Bitmask:   specifies the set of CPUs on wich I want to run the program
        //the BitMask is built in the following manner:
        //I have a bit sequence: every bit is associated to a CPU (from right to left)
        //I set the bit to 1 if I want to use the corrisponding CPU, 0 otherwise
        //for example: I have 4 processor and I want to run the specified process on the CPU 2 and 4:
        //the corresponding bitmask will be     1010 -->2^0 * 0 + 2^1 * 1 + 2^2 * 0 + 2^3 * 1 = 2 + 8 = 10
        //hence BitMask = 10
    //Synch: Boolean --> True if I want a Synchronous Execution (I cannot close
    //my application before the launched process is terminated)
     
    var
      zAppName: array[0..512] of Char;
      zCurDir: array[0..255] of Char;
      WorkDir: string;
      StartupInfo: TStartupInfo;
      ProcessInfo: TProcessInformation;
      Closed: Boolean;
    begin
      Closed := True;
      StrPCopy(zAppName, FileName);
      GetDir(0, WorkDir);
      StrPCopy(zCurDir, WorkDir);
      FillChar(StartupInfo, SizeOf(StartupInfo), #0);
      StartupInfo.cb := SizeOf(StartupInfo);
      StartupInfo.dwFlags := STARTF_USESHOWWINDOW;
      StartupInfo.wShowWindow := Visibility;
      if not CreateProcess(nil,
        zAppName, // pointer to command line string
        nil, // pointer to process security attributes
        nil, // pointer to thread security attributes
        False, // handle inheritance flag
        CREATE_NEW_CONSOLE or // creation flags
        NORMAL_PRIORITY_CLASS,
        nil, //pointer to new environment block
        nil, // pointer to current directory name
        StartupInfo, // pointer to STARTUPINFO
        ProcessInfo) // pointer to PROCESS_INF
        then Result := WAIT_FAILED
      else
      begin
        //running the process on the set of CPUs specified by BitMask
        SetProcessAffinityMask(ProcessInfo.hProcess, BitMask);
        /////
        if (Synch = True) then //if I want a Synchronous execution (I cannot close my
        // application before this process is terminated)
          begin
            Closed:= False;
            repeat
              case WaitForSingleObject(
                ProcessInfo.hProcess, 100) of
                  WAIT_OBJECT_0 : Closed:= True;
                  WAIT_FAILED : RaiseLastWin32Error;
              end;
              Application.ProcessMessages;
            until (Closed);
            GetExitCodeProcess(ProcessInfo.hProcess, Result);
            //exit code of the launched process (0 if the process returned no error  )
            CloseHandle(ProcessInfo.hProcess);
            CloseHandle(ProcessInfo.hThread);
          end
        else
          begin
            Result := 0;
          end;
      end;
    end; {ExecuteProcess}
     
    // Open Taskmanager, select the launched process, right click,
    // "Set affinity", you will see a check on the CPUs you selected

