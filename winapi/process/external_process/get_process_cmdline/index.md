---
Title: Как по PID процесса узнать CmdLine, то есть командную строку?
Author: Krid
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Как по PID процесса узнать CmdLine, то есть командную строку?
=============================================================

    function GetProcessCmdLine(PID:DWORD):string;
     
    var
     h:THandle;
     pbi:TProcessBacicInformation;
     ret:NTSTATUS;
     r:Cardinal;
     ws:WideString;
    begin
     result:='';
     if pid=0 then exit;
     h:=OpenProcess(PROCESS_QUERY_INFORMATION or PROCESS_VM_READ, FALSE, pid);
     if h=0 then exit;
     try
       ret:=NtQueryInformationProcess(h,ProcessBasicInformation,@pbi,sizeof(pbi),@r);
       if ret=STATUS_SUCCESS then
        if ReadProcessMemory(h,
                             pbi.PebBaseAddress.ProcessParameters.CommandLine.Buffer,
                             PWideChar(ws),
                             pbi.PebBaseAddress.ProcessParameters.CommandLine.Length,
                             r) then
       result:=string(ws);
     finally
      closehandle(h)
     end
    end;

