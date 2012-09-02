<h1>Как проверить, запущен ли сервис?</h1>
<div class="date">01.01.2007</div>


<pre>
uses
  WinSvc;
 
function ServiceGetStatus(sMachine, sService: PChar): DWORD;
  {******************************************}
  {*** Parameters: ***}
  {*** sService: specifies the name of the service to open
  {*** sMachine: specifies the name of the target computer
  {*** ***}
  {*** Return Values: ***}
  {*** -1 = Error opening service ***}
  {*** 1 = SERVICE_STOPPED ***}
  {*** 2 = SERVICE_START_PENDING ***}
  {*** 3 = SERVICE_STOP_PENDING ***}
  {*** 4 = SERVICE_RUNNING ***}
  {*** 5 = SERVICE_CONTINUE_PENDING ***}
  {*** 6 = SERVICE_PAUSE_PENDING ***}
  {*** 7 = SERVICE_PAUSED ***}
  {******************************************}
var
  SCManHandle, SvcHandle: SC_Handle;
  SS: TServiceStatus;
  dwStat: DWORD;
begin
  dwStat := 0;
  // Open service manager handle.
  SCManHandle := OpenSCManager(sMachine, nil, SC_MANAGER_CONNECT);
  if (SCManHandle &gt; 0) then
  begin
    SvcHandle := OpenService(SCManHandle, sService, SERVICE_QUERY_STATUS);
    // if Service installed
    if (SvcHandle &gt; 0) then
    begin
      // SS structure holds the service status (TServiceStatus);
      if (QueryServiceStatus(SvcHandle, SS)) then
        dwStat := ss.dwCurrentState;
      CloseServiceHandle(SvcHandle);
    end;
    CloseServiceHandle(SCManHandle);
  end;
  Result := dwStat;
end;
 
function ServiceRunning(sMachine, sService: PChar): Boolean;
begin
  Result := SERVICE_RUNNING = ServiceGetStatus(sMachine, sService);
end;
 
// Check if Eventlog Service is running
procedure TForm1.Button1Click(Sender: TObject);
begin
  if ServiceRunning(nil, 'Eventlog') then
    ShowMessage('Eventlog Service Running')
  else
    ShowMessage('Eventlog Service not Running')
end;
 
{
  Windows 2000 and earlier: All processes are granted the SC_MANAGER_CONNECT,
  SC_MANAGER_ENUMERATE_SERVICE, and SC_MANAGER_QUERY_LOCK_STATUS access rights.
 
  Windows XP: Only authenticated users are granted the SC_MANAGER_CONNECT,
  SC_MANAGER_ENUMERATE_SERVICE,
  and SC_MANAGER_QUERY_LOCK_STATUS access rights.
}
 
{
  Do not use the service display name (as displayed in the services
  control panel applet.) You must use the real service name, as
  referenced in the registry under
  HKEY_LOCAL_MACHINE\System\CurrentControlSet\Services
}
</pre>


<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
