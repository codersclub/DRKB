---
Title: Как клонировать процесс?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как клонировать процесс?
========================

    { 
      In Linux it is possible to duplicate a process with fork. In the original 
      process, fork will return the handle to the duplicated process. The 
      duplicated process will return zero. 
    } 
     
    program TestFork; 
     
    {$APPTYPE CONSOLE} 
     
    uses 
      SysUtils, 
      Libc; 
     
    var 
      ForkedProcessHandle: __pid_t; 
      bForked: Boolean; 
     
    procedure ForkNow; 
    begin 
      bForked := true; 
      ForkedProcessHandle := fork; 
    end; 
     
    function IsForked: Boolean; 
    begin 
      Result := (ForkedProcessHandle = 0) and bForked; 
    end; 
     
    var 
      Lf: Integer; 
     
    begin 
      sigignore(SIGCHLD); 
      bForked := false; 
     
      WriteLn('do some stuff'); 
     
      WriteLn('before fork'); 
      ForkNow; 
      WriteLn('after fork - we have dublicated the process'); 
     
      if IsForked then begin 
        WriteLn('do some stuff in forked process (wait 5s)'); 
        for Lf := 0 to 50 do begin 
          Write('f'); 
          sleep(100); 
        end; 
      end else begin 
        WriteLn('do stuff in original process (wait 10)'); 
        for Lf := 0 to 100 do begin 
          Write('o'); 
          sleep(100); 
        end; 
      end; 
     
      WriteLn; 
     
      if IsForked then 
        WriteLn('forked process end') 
      else 
        WriteLn('original process end'); 
    end. 
     
     
    { 
    Output of this demo app: 
     
    do some stuff 
    before fork 
    after fork - we have dublicated the process 
    after fork - we have dublicated the process 
    do some stuff in forked process (wait 5s) 
    fdo stuff in original process (wait 10) 
    ooffooffooffooffooffooffooffooffooffooffooffooffooffooffooffooffooffooff 
    ooffooffooffooffooffooffooffoo 
    forked process end 
    ooooooooooooooooooooooooooooooooooooooooooooooooo 
    original process end 
    } 

