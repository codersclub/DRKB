<h1>Как управлять сервисом на другом компьютере в Windows 2000?</h1>
<div class="date">01.01.2007</div>


<p>Требуется написать управление сервисом, запущеном на другом компьютере. С помошью чего это лучеше сделать?</p>
<pre>
uses
  Windows, Messages, SysUtils,
  StdCtrls, SvcMgr;
var
  ssStatus: TServiceStatus;
  schSCManager,
    schService: SC_HANDLE;
 
begin
  schSCManager := OpenSCManager(PChar('Comp1'), //имя компьютера, nil - local machine
    nil, // ServicesActive database
    SC_MANAGER_ALL_ACCESS); // full access rights
 
  if schSCManager = 0 then exit; //Ошибка?
 
  schService := OpenService(
    schSCManager, // SCM database
    PChar('SQLServerAgent'), // посмотри имя в Services. В данном случае - MS Server Agent
    SERVICE_ALL_ACCESS);
 
  if schService = 0 then exit; //Ошибка?
 
  if not QueryServiceStatus(
    schService, // handle to service
    ssStatus) then // address of status information structure
    exit; //Ошибка?
 
  case ssStatus.dwCurrentState of
    :
      SERVICE_RUNNING: ShowMessage('Работает!');
    SERVICE_STOPPED: ShowMessage('Выключен');
// ну и т.д.
  end;
end;
</pre>


<p>Взято с сайта <a href="https://blackman.wp-club.net/" target="_blank">https://blackman.wp-club.net/</a></p>
