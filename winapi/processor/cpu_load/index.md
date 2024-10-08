---
Title: Как узнать загрузку процессора? (NT/2000/XP)
Author: Nomadic
Date: 01.01.2007
---

Как узнать загрузку процессора? (NT/2000/XP)
============================================

Вариант 1:

Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>

    const 
      SystemBasicInformation = 0; 
      SystemPerformanceInformation = 2; 
      SystemTimeInformation = 3; 
     
    type 
      TPDWord = ^DWORD; 
     
      TSystem_Basic_Information = packed record 
        dwUnknown1: DWORD; 
        uKeMaximumIncrement: ULONG; 
        uPageSize: ULONG; 
        uMmNumberOfPhysicalPages: ULONG; 
        uMmLowestPhysicalPage: ULONG; 
        uMmHighestPhysicalPage: ULONG; 
        uAllocationGranularity: ULONG; 
        pLowestUserAddress: Pointer; 
        pMmHighestUserAddress: Pointer; 
        uKeActiveProcessors: ULONG; 
        bKeNumberProcessors: byte; 
        bUnknown2: byte; 
        wUnknown3: word; 
      end; 
     
    type 
      TSystem_Performance_Information = packed record 
        liIdleTime: LARGE_INTEGER; {LARGE_INTEGER} 
        dwSpare: array[0..75] of DWORD; 
      end; 
     
    type 
      TSystem_Time_Information = packed record 
        liKeBootTime: LARGE_INTEGER; 
        liKeSystemTime: LARGE_INTEGER; 
        liExpTimeZoneBias: LARGE_INTEGER; 
        uCurrentTimeZoneId: ULONG; 
        dwReserved: DWORD; 
      end; 
     
    var 
      NtQuerySystemInformation: function(infoClass: DWORD; 
        buffer: Pointer; 
        bufSize: DWORD; 
        returnSize: TPDword): DWORD; stdcall = nil; 
     
      liOldIdleTime: LARGE_INTEGER = (); 
      liOldSystemTime: LARGE_INTEGER = (); 
     
    function Li2Double(x: LARGE_INTEGER): Double; 
    begin 
      Result := x.HighPart * 4.294967296E9 + x.LowPart 
    end; 
     
    procedure GetCPUUsage; 
    var 
      SysBaseInfo: TSystem_Basic_Information; 
      SysPerfInfo: TSystem_Performance_Information; 
      SysTimeInfo: TSystem_Time_Information; 
      status: Longint; {long} 
      dbSystemTime: Double; 
      dbIdleTime: Double; 
     
      bLoopAborted : boolean; 
     
    begin 
      if @NtQuerySystemInformation = nil then 
        NtQuerySystemInformation := GetProcAddress(GetModuleHandle('ntdll.dll'), 
          'NtQuerySystemInformation'); 
     
      // get number of processors in the system 
     
      status := NtQuerySystemInformation(SystemBasicInformation, @SysBaseInfo, SizeOf(SysBaseInfo), nil); 
      
      if status <> 0 then Exit; 
     
      // Show some information 
      with SysBaseInfo do 
      begin 
        ShowMessage( 
        Format('uKeMaximumIncrement: %d'#13'uPageSize: %d'#13+ 
          'uMmNumberOfPhysicalPages: %d'+#13+'uMmLowestPhysicalPage: %d'+#13+ 
          'uMmHighestPhysicalPage: %d'+#13+'uAllocationGranularity: %d'#13+ 
          'uKeActiveProcessors: %d'#13'bKeNumberProcessors: %d', 
          [uKeMaximumIncrement, uPageSize, uMmNumberOfPhysicalPages, 
          uMmLowestPhysicalPage, uMmHighestPhysicalPage, uAllocationGranularity, 
          uKeActiveProcessors, bKeNumberProcessors])); 
      end; 
     
      bLoopAborted := False; 
     
      while not bLoopAborted do 
      begin 
     
        // get new system time 
        status := NtQuerySystemInformation(SystemTimeInformation, @SysTimeInfo, SizeOf(SysTimeInfo), 0); 
        if status <> 0 then Exit; 
     
        // get new CPU's idle time 
        status := NtQuerySystemInformation(SystemPerformanceInformation, @SysPerfInfo, SizeOf(SysPerfInfo), nil); 
        if status <> 0 then Exit; 
     
        // if it's a first call - skip it 
        if (liOldIdleTime.QuadPart <> 0) then 
        begin 
     
          // CurrentValue = NewValue - OldValue 
          dbIdleTime := Li2Double(SysPerfInfo.liIdleTime) - Li2Double(liOldIdleTime); 
          dbSystemTime := Li2Double(SysTimeInfo.liKeSystemTime) - Li2Double(liOldSystemTime); 
     
          // CurrentCpuIdle = IdleTime / SystemTime 
          dbIdleTime := dbIdleTime / dbSystemTime; 
     
          // CurrentCpuUsage% = 100 - (CurrentCpuIdle * 100) / NumberOfProcessors 
          dbIdleTime := 100.0 - dbIdleTime * 100.0 / SysBaseInfo.bKeNumberProcessors + 0.5; 
     
          // Show Percentage 
          Form1.Label1.Caption := FormatFloat('CPU Usage: 0.0 %',dbIdleTime); 
     
          Application.ProcessMessages; 
     
          // Abort if user pressed ESC or Application is terminated 
          bLoopAborted := (GetKeyState(VK_ESCAPE) and 128 = 128) or Application.Terminated; 
     
        end; 
     
        // store new CPU's idle and system time 
        liOldIdleTime := SysPerfInfo.liIdleTime; 
        liOldSystemTime := SysTimeInfo.liKeSystemTime; 
     
        // wait one second 
        Sleep(1000); 
      end; 
    end; 
     
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      GetCPUUsage 
    end; 


------------------------------------------------------------------------

Вариант 2:

Author: Nomadic

Source: <https://delphiworld.narod.ru>

Читать из реестра HKEY\_DYN\_DATA\\PerfStats\\StatData
соответствующий ключ Kernel\\CPUUsage

------------------------------------------------------------------------

Вариант 3:

Author: Александр (Rouse\_) Багель

Source: <https://forum.sources.ru>

    const
     
      SystemBasicInformation = 0; 
      SystemPerformanceInformation = 2; 
      SystemTimeOfDayInformation = 3; 
     
    type
      SYSTEM_BASIC_INFORMATION = packed record
        AlwaysZero              : ULONG;
        uKeMaximumIncrement     : ULONG;
        uPageSize               : ULONG;
        uMmNumberOfPhysicalPages: ULONG;
        uMmLowestPhysicalPage   : ULONG;
        uMmHighestPhysicalPage  : ULONG;
        uAllocationGranularity  : ULONG;
        pLowestUserAddress      : POINTER;
        pMmHighestUserAddress   : POINTER;
        uKeActiveProcessors     : POINTER;
        bKeNumberProcessors     : BYTE;
        Filler                  : array [0..2] of BYTE;
      end;
     
      SYSTEM_PERFORMANCE_INFORMATION = packed record
        nIdleTime               : INT64;
        dwSpare                 : array [0..75]of DWORD;
      end;
     
      SYSTEM_TIME_INFORMATION = packed record
        nKeBootTime             : INT64;
        nKeSystemTime           : INT64;
        nExpTimeZoneBias        : INT64;
        uCurrentTimeZoneId      : ULONG;
        dwReserved              : DWORD;
      end;
     
      function NtQuerySystemInformation(
        SystemInformationClass: DWORD;   // тип требуемой информации
        SystemInformation : Pointer;     // указатель на буфер, в который вернется информация
        SystemInformationLength : DWORD; // размер буфера в байтах
        var ReturnLength: DWORD          // сколько байт было возвращено или требуется
        ): DWORD; stdcall; external 'ntdll.dll';
     
    ...
     
    var
      nOldIdleTime    : Int64 = 0;
      nOldSystemTime  : INT64 = 0;
      nNewCPUTime     : ULONG = 0;
     
    procedure TTMDemo.tmrRefreshTimer(Sender: TObject);
    var
      spi : SYSTEM_PERFORMANCE_INFORMATION;
      sti : SYSTEM_TIME_INFORMATION;
      sbi : SYSTEM_BASIC_INFORMATION;
      Dummy: DWORD;
    begin
      if NTQuerySystemInformation(SystemBasicInformation, @sbi,
        SizeOf(SYSTEM_BASIC_INFORMATION), Dummy) = NO_ERROR then
        if NTQuerySystemInformation(SystemTimeOfDayInformation, @sti,
          SizeOf(SYSTEM_TIME_INFORMATION), Dummy) = NO_ERROR then
          if NTQuerySystemInformation(SystemPerformanceInformation, @spi,
            SizeOf(SYSTEM_PERFORMANCE_INFORMATION), Dummy) = NO_ERROR then
          begin
            if (nOldIdleTime <> 0) then
            begin
              nNewCPUTime:= Trunc(100 - ((spi.nIdleTime - nOldIdleTime)
                / (sti.nKeSystemTime - nOldSystemTime) * 100)
                / sbi.bKeNumberProcessors + 0.5);
              if (nNewCPUTime <> nOldIdleTime) then
                Caption := IntToStr(nNewCPUTIME);
            end;
            nOldIdleTime   := spi.nIdleTime;
            nOldSystemTime := sti.nKeSystemTime;
          end;
    end;

