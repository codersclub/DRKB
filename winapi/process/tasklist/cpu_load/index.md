---
Title: Как получить информацию о загрузке процессора?
Author: Nomadic
Date: 01.01.2007
---

Как получить информацию о загрузке процессора?
==============================================

Вариант 1:

Author: Nomadic

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Читать из реестра HKEY\_DYN\_DATA\\PerfStats\\StatData соответствующий
ключ Kernel \\CPUUsage.


------------------------------------------------------------------------

Вариант 2:

Source: <https://www.swissdelphicenter.ch>

    //NT – 2000 - XP
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
     
      bLoopAborted: boolean;
     
    begin
      if @NtQuerySystemInformation = nil then
        NtQuerySystemInformation := GetProcAddress(GetModuleHandle('ntdll.dll'),
          'NtQuerySystemInformation');
     
      // get number of processors in the system
     
      status := NtQuerySystemInformation(SystemBasicInformation, @SysBaseInfo,
        SizeOf(SysBaseInfo), nil);
      if status <> 0 then
        Exit;
     
      // Show some information
      with SysBaseInfo do
      begin
        ShowMessage(
          Format('uKeMaximumIncrement: %d'#13'uPageSize: %d'#13   +
          'uMmNumberOfPhysicalPages: %d' + #13 + 'uMmLowestPhysicalPage: %d' + #13 +
          'uMmHighestPhysicalPage: %d' + #13 + 'uAllocationGranularity: %d'#13 +
          'uKeActiveProcessors: %d'#13'bKeNumberProcessors: %d' ,
          [uKeMaximumIncrement, uPageSize, uMmNumberOfPhysicalPages,
          uMmLowestPhysicalPage, uMmHighestPhysicalPage, uAllocationGranularity,
            uKeActiveProcessors, bKeNumberProcessors]));
      end;
     
      bLoopAborted := False;
     
      while not bLoopAborted do
      begin
     
        // get new system time
        status := NtQuerySystemInformation(SystemTimeInformation, @SysTimeInfo,
          SizeOf(SysTimeInfo), 0);
        if status <> 0 then
          Exit;
     
        // get new CPU's idle time
        status := NtQuerySystemInformation(SystemPerformanceInformation,
          @SysPerfInfo, SizeOf(SysPerfInfo), nil);
        if status <> 0 then
          Exit;
     
        // if it's a first call - skip it
        if (liOldIdleTime.QuadPart <> 0) then
        begin
     
          // CurrentValue = NewValue - OldValue
          dbIdleTime := Li2Double(SysPerfInfo.liIdleTime) -
            Li2Double(liOldIdleTime);
          dbSystemTime := Li2Double(SysTimeInfo.liKeSystemTime) -
            Li2Double(liOldSystemTime);
     
          // CurrentCpuIdle = IdleTime / SystemTime
          dbIdleTime := dbIdleTime / dbSystemTime;
     
          // CurrentCpuUsage% = 100 - (CurrentCpuIdle * 100) / NumberOfProcessors
          dbIdleTime := 100.0 - dbIdleTime * 100.0 / SysBaseInfo.bKeNumberProcessors
            + 0.5;
     
          // Show Percentage
          Form1.Label1.Caption := FormatFloat('CPU Usage: 0.0 %', dbIdleTime);
     
          Application.ProcessMessages;
     
          // Abort if user pressed ESC or Application is terminated
          bLoopAborted := (GetKeyState(VK_ESCAPE) and 128 = 128) or
            Application.Terminated;
     
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

Вариант 3:

Author: DDA, Vologda

Date: 11.02.2004

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Показывает загруженость процессора
     
    Показывает загруженость процессора
     
    Зависимости: registry,Windows, SysUtils, Forms,Gauges,
                 Classes, Controls, ExtCtrls, StdCtrls;
    Автор:       DDA, Vologda
    Copyright:   Где-то найдено
    Дата:        11 февраля 2004 г.
    ***************************************************** }
     
    unit Unit1;
     
    interface
     
    uses
      registry, Windows, SysUtils, Forms, Gauges, Classes, Controls, ExtCtrls,
        StdCtrls;
     
    type
      TForm1 = class(TForm)
        Gauge1: TGauge;
        Timer1: TTimer;
        Button1: TButton;
        procedure Button1Click(Sender: TObject);
        procedure Timer1Timer(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      def: string;
      reg: TRegistry;
      Buffer: array[0..1000] of integer;
    begin
      //-------------------------------
      reg := TRegistry.Create;
      reg.RootKey := HKEY_DYN_DATA;
      def := '';
      if reg.OpenKey('PerfStats\StartStat', false) = TRUE then
      begin
        reg.ReadBinaryData('KERNEL\CPUusage', buffer, 1000);
      end;
      reg.CloseKey;
      Timer1.Enabled := true;
     
    end;
    //-------------------------------
     
    procedure TForm1.Timer1Timer(Sender: TObject);
    var
      def: string;
      reg: TRegistry;
      B: array[1..4] of integer;
    begin
      reg := TRegistry.Create;
      reg.RootKey := HKEY_DYN_DATA;
      def := '';
      if reg.OpenKey('PerfStats\StatData', false) = TRUE then
      begin
        reg.ReadBinaryData('KERNEL\CPUusage', b, 4);
      end;
     
      reg.CloseKey;
      Gauge1.Progress := b[1];
      Application.ProcessMessages;
     
      //-------------------------------
    end;
     
    end.
