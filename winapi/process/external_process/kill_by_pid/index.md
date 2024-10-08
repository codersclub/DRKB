---
Title: Как завершить задачу в Windows NT (а заодно получить PID задачи)?
Date: 20.03.2009
Source: <https://forum.sources.ru>
---

Как завершить задачу в Windows NT (а заодно получить PID задачи)?
=================================================================

Ниже приведён unit, который позволяет убить задачу в Windows NT.

Entry :

    function Kill_By_Pid(pid : longint) : integer; 

где pid, это число, представляющее pid задачи
     
    function EnumProcessWithPid(list : TStrings) : integer; 

где список, это объект TStrings, который будет содержать имя задачи и pid в полях Object.
( list.Items[i] для имени, integer(list.Object[i]) для PID) 

Дальше следует сам код:

    procedure GenerateBlueScreen; 
    var 
      Task : TStringList; 
      i : integer; 
    begin 
      Task := TStringList.Create; 
      Try 
        EnumProcessWithPid(Task); 
        for i := 0 to Task.Count - 1 do 
        begin 
          TaskName := UpperCase(Task[i]); 
          if (TaskName = 'WINLOGON.EXE') then 
          begin // Generate a nice BlueScreenOfDeath 
            Kill_By_Pid(integer(Task.Objects[i])); 
            Beep; 
            break; 
          end; 
        end; 
      Finally 
        Task.Free; 
      end; 
    end; 

    unit U_Kill; 
    {** JF 15/02/2000 - U_Kill.pas 
    ** This unit allow you to list and to kill runnign process. (Work only on NT) 
    ** Entry point : EnumProcessWithPid and Kill_By_Pid. 
    ** v1.2 JF correct a bug in Kill_By_Pid 
    ** v1.3 JF change a thing for D5 05/09/2000 
    **} 
    interface 
     
    uses 
    Classes; 
     
    //** Error code **// 
    const 
    KILL_NOERR = 0; 
    KILL_NOTSUPPORTED = -1; 
    KILL_ERR_OPENPROCESS = -2; 
    KILL_ERR_TERMINATEPROCESS = -3; 
     
    ENUM_NOERR = 0; 
    ENUM_NOTSUPPORTED = -1; 
    ENUM_ERR_OPENPROCESSTOKEN = -2; 
    ENUM_ERR_LookupPrivilegeValue = -3; 
    ENUM_ERR_AdjustTokenPrivileges = -4; 
     
    GETTASKLIST_ERR_RegOpenKeyEx = -1; 
    GETTASKLIST_ERR_RegQueryValueEx = -2; 
     
    function Kill_By_Pid(pid : longint) : integer; 
    function EnumProcessWithPid(list : TStrings) : integer; 
     
    implementation 
    uses 
      Windows, 
      Registry, 
      SysUtils; 
    var 
      VerInfo : TOSVersionInfo; 
    const 
      SE_DEBUG_NAME = 'SeDebugPrivilege'; 
      INITIAL_SIZE  =     51200; 
      EXTEND_SIZE   =     25600; 
      REGKEY_PERF   =     'software\microsoft\windows nt\currentversion\perflib'; 
      REGSUBKEY_COUNTERS ='Counters'; 
      PROCESS_COUNTER    ='process'; 
      PROCESSID_COUNTER  ='id process'; 
      UNKNOWN_TASK       ='unknown'; 
    type 
      ArrayOfChar = array[0..1024] of char; 
      pArrayOfChar = ^pArrayOfChar; 
    type 
      TPerfDataBlock = record 
        Signature       : array[0..3] of WCHAR; 
        LittleEndian    : DWORD; 
        Version         : DWORD; 
        Revision        : DWORD; 
        TotalByteLength : DWORD; 
        HeaderLength    : DWORD; 
        NumObjectTypes  : DWORD; 
        DefaultObject   : integer; 
        SystemTime      : TSystemTime; 
        PerfTime        : TLargeInteger; 
        PerfFreq        : TLargeInteger; 
        PerfTime100nSec : TLargeInteger; 
        SystemNameLength: DWORD; 
        SystemNameOffset: DWORD; 
      end; 
      pTPerfDataBlock = ^TPerfDataBlock; 
      TPerfObjectType = record 
        TotalByteLength    : DWORD; 
        DefinitionLength   : DWORD; 
        HeaderLength       : DWORD; 
        ObjectNameTitleIndex : DWORD; 
        ObjectNameTitle    : LPWSTR; 
        ObjectHelpTitleIndex : DWORD; 
        ObjectHelpTitle      : LPWSTR; 
        DetailLevel          : DWORD; 
        NumCounters          : DWORD; 
        DefaultCounter       : integer; 
        NumInstances         : integer; 
        CodePage             : DWORD; 
        PerfTime             : TLargeInteger; 
        PerfFreq             : TLargeInteger; 
      end; 
      pTPerfObjectType       = ^TPerfObjectType; 
      TPerfInstanceDefinition = record 
         ByteLength           : DWORD; 
         ParentObjectTitleIndex : DWORD; 
         ParentObjectInstance   : DWORD; 
         UniqueID               : integer; 
         NameOffset             : DWORD; 
         NameLength             : DWORD; 
      end; 
      pTPerfInstanceDefinition = ^TPerfInstanceDefinition; 
     
      TPerfCounterBlock = record 
        ByteLength      : DWORD; 
      end; 
      pTPerfCounterBlock = ^TPerfCounterBlock; 
     
      TPerfCounterDefinition = record 
        ByteLength               : DWORD; 
        CounterNameTitleIndex    : DWORD; 
        CounterNameTitle         : LPWSTR; 
        CounterHelpTitleIndex    : DWORD; 
        CounterHelpTitle         : LPWSTR; 
        DefaultScale             : integer; 
        DetailLevel              : DWORD; 
        CounterType              : DWORD; 
        CounterSize              : DWORD; 
        CounterOffset            : DWORD; 
      end; 
      pTPerfCounterDefinition = ^TPerfCounterDefinition; 
     
    procedure InitKill; 
    begin 
      VerInfo.dwOSVersionInfoSize := SizeOf(TOSVersionInfo); 
      GetVersionEx(VerInfo); 
    end; 
     
    (* 
    #define MAKELANGID(p, s)       ((((WORD  )(s)) << 10) | (WORD  )(p)) 
    *) 
    function MAKELANGID(p : DWORD ; s : DWORD) : word; 
    begin 
      result := (s shl 10) or (p); 
    end; 
     
    function Kill_By_Pid(pid : longint) : integer; 
    var 
      hProcess : THANDLE; 
      TermSucc : BOOL; 
    begin 
      if (verInfo.dwPlatformId = VER_PLATFORM_WIN32_NT) then 
      begin 
        hProcess := OpenProcess(PROCESS_ALL_ACCESS, true, pid); 
        if (hProcess = 0) then // v 1.2 : was =-1 
        begin 
          result := KILL_ERR_OPENPROCESS; 
        end 
        else 
        begin 
          TermSucc := TerminateProcess(hProcess, 0); 
          if (TermSucc = false) then 
            result := KILL_ERR_TERMINATEPROCESS 
          else 
            result := KILL_NOERR; 
        end; 
      end 
      else 
        result := KILL_NOTSUPPORTED; 
    end; 
     
    function  EnableDebugPrivilegeNT : integer; 
    var 
      hToken : THANDLE; 
      DebugValue : TLargeInteger; 
      tkp : TTokenPrivileges ; 
      ReturnLength : DWORD; 
      PreviousState: TTokenPrivileges; 
    begin 
      if (OpenProcessToken(GetCurrentProcess, TOKEN_ADJUST_PRIVILEGES or TOKEN_QUERY, hToken) = false) then 
        result := ENUM_ERR_OPENPROCESSTOKEN 
      else 
      begin 
        if (LookupPrivilegeValue(nil, SE_DEBUG_NAME, DebugValue) = false) then 
          result := ENUM_ERR_LookupPrivilegeValue 
        else 
        begin 
          ReturnLength := 0; 
          tkp.PrivilegeCount := 1; 
          tkp.Privileges[0].Luid := DebugValue; 
          tkp.Privileges[0].Attributes := SE_PRIVILEGE_ENABLED; 
          AdjustTokenPrivileges(hToken, false, tkp, SizeOf(TTokenPrivileges),PreviousState, ReturnLength); 
          if (GetLastError <> ERROR_SUCCESS) then 
            result := ENUM_ERR_AdjustTokenPrivileges 
          else 
            result := ENUM_NOERR; 
        end; 
      end; 
    end; 
     
    function  IsDigit(c : char) : boolean; 
    begin 
      result := (c>='0') and (c<='9'); 
    end; 
     
    function  min(a,b : integer) : integer; 
    begin 
      if (a < b) then result := a 
      else result := b; 
    end; 
     
    function  GetTaskListNT(pTask : TStrings) : integer; 
    var 
      rc        : DWORD; 
      hKeyNames : HKEY; 
      dwType    : DWORD; 
      dwSize    : DWORd; 
      buf       : PBYTE; 
      szSubkey  : array[0..1024] of char; 
      lid       : LANGID; 
      p         : PCHAR; 
      p2        : PCHAR; 
      pPerf     : pTPerfDataBlock; 
      pObj      : pTPerfObjectType; 
      pInst     : pTPerfInstanceDefinition; 
      pCounter  : pTPerfCounterBlock; 
      pCounterDef : pTPerfCounterDefinition; 
      i           : DWORD; 
      dwProcessIdTitle : DWORD; 
      dwProcessIdCounter : DWORD; 
      szProcessName : array[0..MAX_PATH] of char; 
      dwLimit       : DWORD; 
      dwNumTasks    : dword; 
     
      ProcessName   : array[0..MAX_PATH] of char; 
      dwProcessID   : DWORD; 
    label 
      EndOfProc; 
    begin 
      dwNumTasks := 255; 
      dwLimit := dwNumTasks - 1; 
      StrCopy(ProcessName, ''); 
      lid := MAKELANGID(LANG_ENGLISH, SUBLANG_NEUTRAL); 
      StrFmt(szSubKey, '%s\%.3X', [REGKEY_PERF, lid]); 
      rc := RegOpenKeyEx(HKEY_LOCAL_MACHINE, szSubKey, 0, KEY_READ, hKeyNames); 
      if (rc <> ERROR_SUCCESS) then 
        result := GETTASKLIST_ERR_RegOpenKeyEx 
      else 
      begin 
        result := 0; 
        rc := RegQueryValueEx(hKeyNames, REGSUBKEY_COUNTERS, nil, @dwType, nil, @dwSize); 
        if (rc <> ERROR_SUCCESS) then 
          result := GETTASKLIST_ERR_RegQueryValueEx 
        else 
        begin 
          GetMem(buf, dwSize); 
          FillChar(buf^, dwSize, 0); 
          RegQueryValueEx(hKeyNames, REGSUBKEY_COUNTERS, nil, @dwType, buf, @dwSize); 
          p := PCHAR(buf); 
          dwProcessIdTitle := 0; 
          while (p^<>#0) do 
          begin 
            if (p > buf) then 
            begin 
              p2 := p - 2; 
              while(isDigit(p2^)) do 
                dec(p2); 
            end; 
            if (StrIComp(p, PROCESS_COUNTER) = 0) then 
            begin 
              p2 := p -2; 
              while(isDigit(p2^)) do 
                dec(p2); 
              strCopy(szSubKey, p2+1); 
            end 
            else 
            if (StrIComp(p, PROCESSID_COUNTER) = 0) then 
            begin 
              p2 := p - 2; 
              while(isDigit(p2^)) do 
                dec(p2); 
               dwProcessIdTitle := StrToIntDef(p2+1, -1); 
            end; 
            p := p + (Length(p) + 1); 
          end; 
          FreeMem(buf); buf := nil; 
          dwSize := INITIAL_SIZE; 
          GetMem(buf, dwSize); 
          FillChar(buf^, dwSize, 0); 
          pPerf := nil; 
          while (true) do 
          begin 
            rc := RegQueryValueEx(HKEY_PERFORMANCE_DATA, szSubKey, nil, @dwType, buf, @dwSize); 
            pPerf := pTPerfDataBlock(buf); 
            if ((rc = ERROR_SUCCESS) and (dwSize > 0) and 
                (pPerf^.Signature[0] = WCHAR('P')) and 
                (pPerf^.Signature[1] = WCHAR('E')) and 
                (pPerf^.Signature[2] = WCHAR('R')) and 
                (pPerf^.Signature[3] = WCHAR('F')) 
                ) then 
            begin 
              break; 
            end; 
            if (rc = ERROR_MORE_DATA) then 
            begin 
              dwSize := dwSize + EXTEND_SIZE; 
              FreeMem(buf); buf := nil; 
              GetMem(buf, dwSize); 
              FillChar(buf^, dwSize, 0);
            end 
            else 
              goto EndOfProc; 
          end; 
     
          pObj := pTPerfObjectType( DWORD(pPerf) + pPerf^.HeaderLength); 
     
          pCounterDef := pTPerfCounterDefinition( DWORD(pObj) + pObj^.HeaderLength); 
          dwProcessIdCounter := 0; 
          i := 0; 
          while (i < pObj^.NumCounters) do 
          begin 
            if (pCounterDef^.CounterNameTitleIndex = dwProcessIdTitle) then 
            begin 
              dwProcessIdCounter := pCounterDEf^.CounterOffset; 
              break; 
            end; 
            inc(pCounterDef); 
            inc(i); 
          end; 
          dwNumTasks := min(dwLimit, pObj^.NumInstances); 
          pInst := PTPerfInstanceDefinition(DWORD(pObj) + pObj^.DefinitionLength); 
     
          i := 0; 
          while ( i < dwNumTasks) do 
          begin 
            p := PCHAR(DWORD(pInst)+pInst^.NameOffset); 
            rc := WideCharToMultiByte(CP_ACP, 0, LPCWSTR(p), -1, szProcessName, SizeOf(szProcessName), nil, nil); 
            {** This is changed for working with D3 and D5 05/09/2000 **} 
            if (rc = 0) then 
              StrCopy(ProcessName, UNKNOWN_TASK) 
            else 
              StrCopy(ProcessName, szProcessName); 
            // Получаем ID процесса
            pCounter := pTPerfCounterBlock( DWORD(pInst) + pInst^.ByteLength); 
            dwProcessId := LPDWORD(DWORD(pCounter) + dwProcessIdCounter)^; 
            if (dwProcessId = 0) then 
              dwProcessId := DWORD(0); 
            pTask.AddObject(ProcessName, TObject(dwProcessID)); 
            pInst := pTPerfInstanceDefinition( DWORD(pCounter) + pCounter^.ByteLength); 
            inc(i); 
          end; 
          result := dwNumTasks; 
        end; 
      end; 
    EndOfProc: 
      if (buf <> nil) then 
        FreeMem(buf); 
      RegCloseKey(hKeyNames); 
      RegCloseKey(HKEY_PERFORMANCE_DATA); 
      RegCloseKey(hKeyNames); 
      RegCloseKey(HKEY_PERFORMANCE_DATA); 
    end; 
     
    function EnumProcessWithPid(list : TStrings) : integer; 
    begin 
      if (verInfo.dwPlatformId = VER_PLATFORM_WIN32_NT) then 
      begin 
        EnableDebugPrivilegeNT; 
        result := GetTaskListNT(list); 
      end 
      else 
        result := ENUM_NOTSUPPORTED; 
    end; 
     
    initialization 
      InitKill; 
    end.

