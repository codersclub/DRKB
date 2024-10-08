---
Title: Управление NT-сервисами
Date: 01.01.2007
Source:  <https://www.swissdelphicenter.ch/en/tipsindex.php>
---

Управление NT-сервисами
=======================

Следующий класс TServiceManager можно использовать для управления вашими NT-службами.
Вы можете выполнять такие действия, как запуск, остановка, приостановка или запрос статуса служб.

    {
      The following class TServiceManager can be used to manage your NT-Services.
      You can do things like start, stop, pause or querying a services status.
    }
     
    //  Thanks for this one to Frederik Schaller as well - it's a co-work }
     
    unit ServiceManager;
     
    interface
     
    uses
      SysUtils, Windows, WinSvc;
     
    type
     
      TServiceManager = class
      private
        { Private declarations }
        ServiceControlManager: SC_Handle;
        ServiceHandle: SC_Handle;
      protected
        function DoStartService(NumberOfArgument: DWORD; ServiceArgVectors: PChar): Boolean;
      public
        { Public declarations }
        function Connect(MachineName: PChar = nil; DatabaseName: PChar = nil;
          Access: DWORD = SC_MANAGER_ALL_ACCESS): Boolean;  // Access may be SC_MANAGER_ALL_ACCESS
        function OpenServiceConnection(ServiceName: PChar): Boolean;
        function StartService: Boolean; overload; // Simple start
        function StartService(NumberOfArgument: DWORD; ServiceArgVectors: PChar): Boolean;
          overload; // More complex start
        function StopService: Boolean;
        procedure PauseService;
        procedure ContinueService;
        procedure ShutdownService;
        procedure DisableService;
        function GetStatus: DWORD;
        function ServiceRunning: Boolean;
        function ServiceStopped: Boolean;
      end;
     
    implementation
     
    { TServiceManager }
     
    function TServiceManager.Connect(MachineName, DatabaseName: PChar;
      Access: DWORD): Boolean;
    begin
      Result := False;
      { open a connection to the windows service manager }
      ServiceControlManager := OpenSCManager(MachineName, DatabaseName, Access);
      Result := (ServiceControlManager <> 0);
    end;
     
    function TServiceManager.OpenServiceConnection(ServiceName: PChar): Boolean;
    begin
      Result := False;
      { open a connetcion to a specific service }
      ServiceHandle := OpenService(ServiceControlManager, ServiceName, SERVICE_ALL_ACCESS);
      Result := (ServiceHandle <> 0);
    end;
     
    procedure TServiceManager.PauseService;
    var
      ServiceStatus: TServiceStatus;
    begin
      { Pause the service: attention not supported by all services }
      ControlService(ServiceHandle, SERVICE_CONTROL_PAUSE, ServiceStatus);
    end;
     
    function TServiceManager.StopService: Boolean;
    var
      ServiceStatus: TServiceStatus;
    begin
      { Stop the service }
      Result := ControlService(ServiceHandle, SERVICE_CONTROL_STOP, ServiceStatus);
    end;
     
    procedure TServiceManager.ContinueService;
    var
      ServiceStatus: TServiceStatus;
    begin
      { Continue the service after a pause: attention not supported by all services }
      ControlService(ServiceHandle, SERVICE_CONTROL_CONTINUE, ServiceStatus);
    end;
     
    procedure TServiceManager.ShutdownService;
    var
      ServiceStatus: TServiceStatus;
    begin
      { Shut service down: attention not supported by all services }
      ControlService(ServiceHandle, SERVICE_CONTROL_SHUTDOWN, ServiceStatus);
    end;
     
    function TServiceManager.StartService: Boolean;
    begin
      Result := DoStartService(0, '');
    end;
     
    function TServiceManager.StartService(NumberOfArgument: DWORD;
      ServiceArgVectors: PChar): Boolean;
    begin
      Result := DoStartService(NumberOfArgument, ServiceArgVectors);
    end;
     
    function TServiceManager.GetStatus: DWORD;
    var
      ServiceStatus: TServiceStatus;
    begin
    { Returns the status of the service. Maybe you want to check this
      more than once, so just call this function again.
      Results may be:
        SERVICE_STOPPED
        SERVICE_START_PENDING
        SERVICE_STOP_PENDING
        SERVICE_RUNNING
        SERVICE_CONTINUE_PENDING
        SERVICE_PAUSE_PENDING
        SERVICE_PAUSED
    }
      Result := 0;
      QueryServiceStatus(ServiceHandle, ServiceStatus);
      Result := ServiceStatus.dwCurrentState;
    end;
     
    procedure TServiceManager.DisableService;
    begin
      { Implementation is following... }
    end;
     
    function TServiceManager.ServiceRunning: Boolean;
    begin
      Result := (GetStatus = SERVICE_RUNNING);
    end;
     
    function TServiceManager.ServiceStopped: Boolean;
    begin
      Result := (GetStatus = SERVICE_STOPPED);
    end;
     
    function TServiceManager.DoStartService(NumberOfArgument: DWORD;
      ServiceArgVectors: PChar): Boolean;
    var
      err: integer;
    begin
      Result := WinSvc.StartService(ServiceHandle, NumberOfArgument, ServiceArgVectors);
    end;
     
    end.

