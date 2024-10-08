---
Title: Получение дополнительных привилегий под NT
---

Получение дополнительных привилегий под NT
==========================================

Вариант 1:

author: Денис, LiquidStorm_HSS@yahoo.com
Date: 09.08.2003

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Получение дополнительных привилегий под НТ
     
    В принципе и так все понятно - задаеш название привилегии и 
    если это возможно, то система их тебе дает
     
    Зависимости: uses Windows, SysUtils;
    Автор:       Денис, LiquidStorm_HSS@yahoo.com, Lviv
    Copyright:   by LiquidStorm, HomeSoftStudios(tm) aka Denis L.
    Дата:        9 августа 2003 г.
    ********************************************** }
     
    unit NTPrivelegsU;
    ////////////////////////////////////////////////////////////////////////
    // //
    // NT Defined Privileges //
    // //
    ////////////////////////////////////////////////////////////////////////
     
    interface
    uses Windows, SysUtils;
     
    const SE_CREATE_TOKEN_NAME = 'SeCreateTokenPrivilege';
    const SE_ASSIGNPRIMARYTOKEN_NAME = 'SeAssignPrimaryTokenPrivilege';
    const SE_LOCK_MEMORY_NAME = 'SeLockMemoryPrivilege';
    const SE_INCREASE_QUOTA_NAME = 'SeIncreaseQuotaPrivilege';
    const SE_UNSOLICITED_INPUT_NAME = 'SeUnsolicitedInputPrivilege';
    const SE_MACHINE_ACCOUNT_NAME = 'SeMachineAccountPrivilege';
    const SE_TCB_NAME = 'SeTcbPrivilege';
    const SE_SECURITY_NAME = 'SeSecurityPrivilege';
    const SE_TAKE_OWNERSHIP_NAME = 'SeTakeOwnershipPrivilege';
    const SE_LOAD_DRIVER_NAME = 'SeLoadDriverPrivilege';
    const SE_SYSTEM_PROFILE_NAME = 'SeSystemProfilePrivilege';
    const SE_SYSTEMTIME_NAME = 'SeSystemtimePrivilege';
    const SE_PROF_SINGLE_PROCESS_NAME = 'SeProfileSingleProcessPrivilege';
    const SE_INC_BASE_PRIORITY_NAME = 'SeIncreaseBasePriorityPrivilege';
    const SE_CREATE_PAGEFILE_NAME = 'SeCreatePagefilePrivilege';
    const SE_CREATE_PERMANENT_NAME = 'SeCreatePermanentPrivilege';
    const SE_BACKUP_NAME = 'SeBackupPrivilege';
    const SE_RESTORE_NAME = 'SeRestorePrivilege';
    const SE_SHUTDOWN_NAME = 'SeShutdownPrivilege';
    const SE_DEBUG_NAME = 'SeDebugPrivilege';
    const SE_AUDIT_NAME = 'SeAuditPrivilege';
    const SE_SYSTEM_ENVIRONMENT_NAME = 'SeSystemEnvironmentPrivilege';
    const SE_CHANGE_NOTIFY_NAME = 'SeChangeNotifyPrivilege';
    const SE_REMOTE_SHUTDOWN_NAME = 'SeRemoteShutdownPrivilege';
     
    function AdjustPriviliges(const PrivelegStr: String) : Bool; forward;
     
    implementation
     
    function AdjustPriviliges(const PrivelegStr: String) : Bool;
    var
     hTok : THandle;
     tp : TTokenPrivileges;
    begin
     Result := False;
     // Get the current process token handle so we can get privilege.
     if OpenProcessToken(GetCurrentProcess, TOKEN_ADJUST_PRIVILEGES + TOKEN_QUERY, hTok) then
     try
       // Get the LUID for privilege.
       if LookupPrivilegeValue(nil,PChar(PrivelegStr), tp.Privileges[0].Luid) then
       begin
         tp.PrivilegeCount := 1; // one privilege to set
         tp.Privileges[0].Attributes := SE_PRIVILEGE_ENABLED;
         // Get privilege for this process.
         Result := AdjustTokenPrivileges(hTok, False, tp, 0, PTokenPrivileges(nil)^, PDWord(nil)^)
       end
     finally
       // Cannot test the return value of AdjustTokenPrivileges.
       if (GetLastError <> ERROR_SUCCESS) then
          raise Exception.Create('AdjustTokenPrivileges enable failed');
       CloseHandle(hTok)
     end
     else raise Exception.Create('OpenProcessToken failed');
    end;
     
     
    end. 

Пример использования:

    unit uWDog;
     
    // define _DEV_ in developing stage - this mean DEBUG version
    {.$DEFINE _DEV_}
     
    // define WRITE_DESKTOP in developing stage if you want
    // visible confirmation of service work
    {.$DEFINE WRITE_DESKTOP}
     
    // define WRITE_NO_LOGIN if you want to write log when
    // nobody logged in
    {$DEFINE WRITE_NO_LOGIN}
     
    // define WRITE_FOUND if you want to write log when
    // everything ok and process found
    {$DEFINE WRITE_FOUND}
     
    // define WRITE_UNCHECKED_LOGINS if you want to write log for
    // not checked logins (like Administrator - in release)
    {$DEFINE WRITE_UNCHECKED_LOGINS}
     
    {$IFNDEF _DEV_}
    {$UNDEF WRITE_DESKTOP}
    {$ENDIF}
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, SvcMgr, Dialogs,
      ExtCtrls;
     
    type
      TwDog = class(TService)
        dx_time: TTimer;
        procedure ServiceStart(Sender: TService; var Started: Boolean);
        procedure ServiceStop(Sender: TService; var Stopped: Boolean);
        procedure dx_timeTimer(Sender: TObject);
        procedure ServiceCreate(Sender: TObject);
        procedure ServiceDestroy(Sender: TObject);
        procedure ServiceShutdown(Sender: TService);
      private
        { Private declarations }
        procedure InitiateShutdown;
        //procedure AbortShutdown;
      public
        function GetServiceController: TServiceController; override;
        { Public declarations }
      end;
     
    var
      wDog: TwDog;
     
    implementation
    {$R *.DFM}
     
    uses ShellAPI, NTPrivelegsU, WinSecur,
         FileCtrl {$IFDEF WRITE_DESKTOP}, DeskTopMsg{$ENDIF};
    const
          TimerInterval = 5000; // in msec = 5 sec
          SleepAftLogin = 3000; // in msec = 3 sec
          ProcessName = 'Q3Arena.exe';
          ClassName = 'Quake3ArenaClassWnd';
          WndName = ' '; // 1 space
          CheckUsersCount = 2;
    {$IFDEF _DEV_}
          StekServer = '127.0.0.1';
          CheckUsers: array [0..CheckUsersCount-1] of String =
                                ('Internet','Administrator');
    {$ELSE}
          StekServer = '132.0.0.16';
          CheckUsers: array [0..CheckUsersCount-1] of String =
                                ('Gamer','Office');
    {$ENDIF}
    var
        hLog: THandle;
        CreateOptScan: LongWord;
        xBuf: array [0..$FF-1] of Char;
        LogPath: String;
     
    // ------------- forward declarations
    function IsLoggedIn: Boolean; forward;
    function WriteLog(Status: String): DWord; forward;
    procedure SndMessage; forward;
    procedure Kill; forward;
    {$IFDEF _DEV_}
    procedure ShowError(erno: DWord); forward;
    {$ENDIF}
    // function ProcessTerminate(dwPID:Cardinal):Boolean; forward;
     
    // -------------
     
    procedure AdjTokenPrivelegs(mmName: String);
    var gler : DWord;
    begin
      AdjustPriviliges(mmName);
      gler := GetLastError;
      if (gler <> ERROR_SUCCESS) then
      begin
        WriteLog(Format('%s: [FAILED] ',[mmName]));
    {$IFDEF _DEV_}
        ShowError(gler);
    {$ENDIF}
        exit;
      end;
      WriteLog(Format('%s: [OK] ',[mmName]));
    end;
     
    // -------------
     
    function MyCtrlHandler(dwCtrlType: Dword): Bool; stdcall;
    begin
      //
      case dwCtrlType of
        CTRL_LOGOFF_EVENT : begin
                               WriteLog('CTRL_LOGOFF_EVENT');
                               Result := True;
                             end;
        CTRL_SHUTDOWN_EVENT: begin
                               WriteLog('CTRL_SHUTDOWN_EVENT');
                               Result := True;
                             end;
      else Result := False
      end;
    end;
     
    // -------------
     
    procedure ServiceController(CtrlCode: DWord); stdcall;
    begin
      wDog.Controller(CtrlCode);
    end;
     
    // -------------
     
    function TwDog.GetServiceController: TServiceController;
    begin
      Result := ServiceController;
    end;
     
    // -------------
     
    procedure TwDog.ServiceStart(Sender: TService; var Started: Boolean);
    begin
      WriteLog('OnStart');
      Started := True;
    end;
     
    // -------------
     
    procedure TwDog.ServiceStop(Sender: TService; var Stopped: Boolean);
    begin
      WriteLog('OnStop');
      Stopped := True;
    end;
     
    // -------------
     
    procedure TwDog.ServiceCreate(Sender: TObject);
    begin
      if sysutils.Win32Platform = VER_PLATFORM_WIN32_NT then
           CreateOptScan := FILE_FLAG_SEQUENTIAL_SCAN
      else CreateOptScan := 0;
      GetWindowsDirectory(xBuf,$FF);
      LogPath := Format('%s\wDog',[xBuf]);
      ForceDirectories(LogPath);
      LogPath := Format('%s\%s.log',[LogPath,FormatDateTime('dd.mm.yyyy',Now)]);
      WriteLog('Starting ...');
      AdjTokenPrivelegs(SE_SHUTDOWN_NAME);
      AdjTokenPrivelegs(SE_DEBUG_NAME);
      SetConsoleCtrlHandler(@MyCtrlHandler,True);
      dx_time.Interval:=TimerInterval;
      dx_time.Enabled:=true;
      WriteLog('Started: [OK]');
    end;
     
    // -------------
     
    procedure TwDog.ServiceDestroy(Sender: TObject);
    begin
      dx_time.Enabled:=false;
      WriteLog('Stopped: [OK]');
      CloseHandle(hLog);
    end;
     
    // -------------
     
    function IsLoggedIn: Boolean;
    var stmp: String;
        i : Byte;
        pid : DWord;
    begin
      Result := False;
      pid := GetPidFromProcessName(GetShellProcessName);
      if (pid = 0) or (pid = INVALID_HANDLE_VALUE) then
        // no shell running - no body logged in
        stmp := EmptyStr
      else
        // shell running - get interactive user name
        stmp := GetInteractiveUserName; // get DOMAIN\User
      if stmp = EmptyStr then
      begin
    {$IFDEF WRITE_NO_LOGIN}
        WriteLog('[No_Login]');
    {$ENDIF}
        Exit;
      end;
      Delete(stmp,1,Pos('\',stmp)); // get User
      for i:=0 to CheckUsersCount do
       if AnsiSameText(stmp,CheckUsers[i]) then
       begin
         WriteLog(Format('[%s]: check',[stmp]));
         Result := True;
         exit;
       end;
      // if no login detected
    {$IFDEF WRITE_UNCHECKED_LOGINS}
      WriteLog(Format('[%s]: no_check',[stmp]));
    {$ENDIF}
    end;
     
    // -------------
     
    function IsFoundByClass: Boolean;
    var hwnd: DWord;
    begin
      // try to find by classname
      hwnd := FindWindowEx(0,0,PChar(ClassName),nil);
      if (hwnd = 0) or (hwnd = INVALID_HANDLE_VALUE) then
         Result := False
      else
         Result := True;
    {$IFDEF _DEV_}
    {$IFDEF WRITE_DESKTOP}
      if not Result then writeDirect(10,30,'IsFoundByClass: [NO]')
      else writeDirect(10,30,'IsFoundByClass: [YES]')
    {$ENDIF}
    {$ENDIF}
    end;
     
    // -------------
     
    function IsFoundByProcName: Boolean;
    var
      Pid,
      hwnd: DWord;
    begin
      Pid := GetPidFromProcessName(ProcessName);
      hwnd := OpenProcess(PROCESS_ALL_ACCESS, False, Pid);
    // if hwnd = 0 then RaiseLastWin32Error;
      if (hwnd = 0) or (hwnd = INVALID_HANDLE_VALUE) then
         Result := False
      else
         Result := True;
      CloseHandle(hwnd);
    {$IFDEF _DEV_}
    {$IFDEF WRITE_DESKTOP}
      if not Result then writeDirect(10,70,'IsFoundByProcName: [NO]')
      else writeDirect(10,70,'IsFoundByProcName: [YES]')
    {$ENDIF}
    {$ENDIF}
    end;
     
    // -------------
     
    // enable complete Boolean expression evaluation
    {$B+}
    procedure TwDog.dx_timeTimer(Sender: TObject);
    begin
      // Check login
      // - service started under SYSTEM account, so it works on system boot.
      // To prevent machine from deadlock we must check if someone
      // has logged in.
      if IsLoggedIn then
      begin
        // turn off timer - to prevent
        // double elimination
        dx_time.Enabled:=false;
     
        // make some delay - for user processes startup
        // just after login
        Sleep(SleepAftLogin);
     
        // try to find by classname, process name
        if IsFoundByClass and
           IsFoundByProcName then
        begin
    {$IFDEF WRITE_FOUND}
          WriteLog('[FOUND]');
    {$ENDIF}
        end
        else // cheater found
        begin
    {$IFNDEF _DEV_}
          SndMessage;
    {$ENDIF}
          Kill;
          InitiateShutdown;
        end;
        dx_time.Enabled:=True;
      end;
    end;
    {$B-}
    // -------------
     
    procedure SndMessage;
    var stmp: string;
        buf: array [0..127] of Char;
        num: DWord;
    begin
      num := 128;
      stmp := EmptyStr;
      if GetComputerName(buf,num) then
        SetString(stmp,buf,num)
      else ;// no result for netbios name
      //
      stmp := Format('::Cheater detected on [%s]::',[stmp]);
      WriteLog(stmp);
      stmp := Format('%s %s',[StekServer,stmp]);
      // NetMessageBufferSend
      ShellExecute(0,'open','net',PChar('send '+stmp),nil,SW_HIDE);
      sleep(50);
    end;
     
    // -------------
     
    procedure Kill;
    begin
      WriteLog('[KILL]');
    {$IFDEF _DEV_}
    {$IFDEF WRITE_DESKTOP}
      writeDirect(10,10,'KILL');
    {$ENDIF}
    {$ELSE}
      ExitWindowsEx(EWX_LOGOFF or EWX_FORCE,0);
    {$ENDIF}
    end;
     
    // -------------
     
    function WriteLog(Status: String): DWord;
    begin
      if (hLog = INVALID_HANDLE_VALUE) or (hLog = 0) then
      begin
        if FileExists(LogPath) then
        hLog := CreateFile(PChar(LogPath),
                           GENERIC_READ or GENERIC_WRITE,
                           FILE_SHARE_READ,
                           nil,
                           OPEN_EXISTING,
                           FILE_ATTRIBUTE_NORMAL or CreateOptScan,
                           0)
        else
        hLog := CreateFile(PChar(LogPath),
                          GENERIC_READ or GENERIC_WRITE,
                          FILE_SHARE_READ,
                          nil,
                          CREATE_ALWAYS,
                          FILE_ATTRIBUTE_NORMAL or CreateOptScan,
                          0);
        if hLog = INVALID_HANDLE_VALUE then
        begin
          Result := DWord(-1);
          exit;
        end;
        // seek to the end of log
        FileSeek(hLog,0,2);
      end;
      FillChar(xBuf,$FF,0);
      Status := Format('%s - %s'#13#10,
                       [FormatDateTime('hh:nn:ss',Now),
                        Status]);
      move((Pointer(@Status[1]))^,xBuf,Length(Status));
      // write buffer
      FileWrite(hLog,xBuf,Length(Status));
      // flush file buffers
      FlushFileBuffers(hLog);
      Result := 0;
    end;
     
    // -------------
     
    {$IFDEF _DEV_}
    procedure ShowError(erno: DWord);
    var MsgBuf: array [0..$FF-1] of Char;
    begin
      if erno = ERROR_SUCCESS then exit;
      //
      FillChar(MsgBuf,$FF,0);
      FormatMessage(
            FORMAT_MESSAGE_FROM_SYSTEM,
            nil,
            erno,
            ((WORD(SUBLANG_DEFAULT) shl 10) or WORD(LANG_NEUTRAL)),
            MsgBuf,
            $FF,
            nil);
      // Display the string.
      MessageBox(0, MsgBuf, 'GetLastError', MB_OK + MB_ICONINFORMATION + MB_TASKMODAL + MB_SERVICE_NOTIFICATION);
    end;
    {$ENDIF}
     
    // -------------
     
    procedure TwDog.InitiateShutdown;
    begin
      InitiateSystemShutdown(nil, // shut down local computer
        'Cheater detected on this system. Shutdown initiated.', // message to user
        10, // time-out period
        FALSE, // ask user to close apps
        TRUE); // reboot after shutdown
      // bQuite:=False;
    end;

------------------------------------------------------------------------

Вариант 2:

    { 
      For some functions you need to get the right privileges 
      on a Windows NT machine. 
      (e.g: To shut down or restart windows with ExitWindowsEx or 
      to change the system time) 
      The following code provides a procedure to adjust the privileges. 
      The AdjustTokenPrivileges() function enables or disables privileges 
      in the specified access token. 
    } 
     
    // NT Defined Privileges from winnt.h 
     
    const 
      SE_CREATE_TOKEN_NAME = 'SeCreateTokenPrivilege'; 
      SE_ASSIGNPRIMARYTOKEN_NAME = 'SeAssignPrimaryTokenPrivilege'; 
      SE_LOCK_MEMORY_NAME = 'SeLockMemoryPrivilege'; 
      SE_INCREASE_QUOTA_NAME = 'SeIncreaseQuotaPrivilege'; 
      SE_UNSOLICITED_INPUT_NAME = 'SeUnsolicitedInputPrivilege'; 
      SE_MACHINE_ACCOUNT_NAME = 'SeMachineAccountPrivilege'; 
      SE_TCB_NAME = 'SeTcbPrivilege'; 
      SE_SECURITY_NAME = 'SeSecurityPrivilege'; 
      SE_TAKE_OWNERSHIP_NAME = 'SeTakeOwnershipPrivilege'; 
      SE_LOAD_DRIVER_NAME = 'SeLoadDriverPrivilege'; 
      SE_SYSTEM_PROFILE_NAME = 'SeSystemProfilePrivilege'; 
      SE_SYSTEMTIME_NAME = 'SeSystemtimePrivilege'; 
      SE_PROF_SINGLE_PROCESS_NAME = 'SeProfileSingleProcessPrivilege'; 
      SE_INC_BASE_PRIORITY_NAME = 'SeIncreaseBasePriorityPrivilege'; 
      SE_CREATE_PAGEFILE_NAME = 'SeCreatePagefilePrivilege'; 
      SE_CREATE_PERMANENT_NAME = 'SeCreatePermanentPrivilege'; 
      SE_BACKUP_NAME = 'SeBackupPrivilege'; 
      SE_RESTORE_NAME = 'SeRestorePrivilege'; 
      SE_SHUTDOWN_NAME = 'SeShutdownPrivilege'; 
      SE_DEBUG_NAME = 'SeDebugPrivilege'; 
      SE_AUDIT_NAME = 'SeAuditPrivilege'; 
      SE_SYSTEM_ENVIRONMENT_NAME = 'SeSystemEnvironmentPrivilege'; 
      SE_CHANGE_NOTIFY_NAME = 'SeChangeNotifyPrivilege'; 
      SE_REMOTE_SHUTDOWN_NAME = 'SeRemoteShutdownPrivilege'; 
      SE_UNDOCK_NAME = 'SeUndockPrivilege'; 
      SE_SYNC_AGENT_NAME = 'SeSyncAgentPrivilege'; 
      SE_ENABLE_DELEGATION_NAME = 'SeEnableDelegationPrivilege'; 
      SE_MANAGE_VOLUME_NAME = 'SeManageVolumePrivilege'; 
     
    // Enables or disables privileges debending on the bEnabled 
    function NTSetPrivilege(sPrivilege: string; bEnabled: Boolean): Boolean; 
    var 
      hToken: THandle; 
      TokenPriv: TOKEN_PRIVILEGES; 
      PrevTokenPriv: TOKEN_PRIVILEGES; 
      ReturnLength: Cardinal; 
    begin 
      Result := True; 
      // Only for Windows NT/2000/XP and later. 
      if not (Win32Platform = VER_PLATFORM_WIN32_NT) then Exit; 
      Result := False; 
     
      // obtain the processes token 
      if OpenProcessToken(GetCurrentProcess(), 
        TOKEN_ADJUST_PRIVILEGES or TOKEN_QUERY, hToken) then 
      begin 
        try 
          // Get the locally unique identifier (LUID) . 
          if LookupPrivilegeValue(nil, PChar(sPrivilege), 
            TokenPriv.Privileges[0].Luid) then 
          begin 
            TokenPriv.PrivilegeCount := 1; // one privilege to set 
     
            case bEnabled of 
              True: TokenPriv.Privileges[0].Attributes  := SE_PRIVILEGE_ENABLED; 
              False: TokenPriv.Privileges[0].Attributes := 0; 
            end; 
     
            ReturnLength := 0; // replaces a var parameter 
            PrevTokenPriv := TokenPriv; 
     
            // enable or disable the privilege 
     
            AdjustTokenPrivileges(hToken, False, TokenPriv, SizeOf(PrevTokenPriv), 
              PrevTokenPriv, ReturnLength); 
          end; 
        finally 
          CloseHandle(hToken); 
        end; 
      end; 
      
      // test the return value of AdjustTokenPrivileges. 
      Result := GetLastError = ERROR_SUCCESS; 
      if not Result then 
        raise Exception.Create(SysErrorMessage(GetLastError)); 
    end;


