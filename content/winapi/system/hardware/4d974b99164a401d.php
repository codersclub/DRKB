<h1>Установка драйвера</h1>
<div class="date">01.01.2007</div>


<p>Есть 2 файла драйвера - Sys и Ini как установить драйвер?</p>
<pre>

function Install: Boolean;
const
  StartType =
{$IFDEF SERVICE_DEBUG}           
    SERVICE_DEMAND_START;
{$ELSE}
    SERVICE_AUTO_START;
{$ENDIF}
var
  SCManager, Service: SC_HANDLE;
  Info: String;
begin
  SCManager := OpenSCManager(nil, nil, SC_MANAGER_CREATE_SERVICE);
  if SCManager &lt;&gt; 0 then
  try
    Service := CreateService(SCManager, PChar(ServiceName), ServiceDisplayName,
      SERVICE_ALL_ACCESS, SERVICE_WIN32_SHARE_PROCESS or SERVICE_INTERACTIVE_PROCESS,
      StartType, SERVICE_ERROR_NORMAL, PChar('"' + ParamStr(0) + '" -service'),
      nil, nil, nil, nil, nil);
    if Service &lt;&gt; 0 then
    try
      Result := ChangeServiceConfig(Service, SERVICE_NO_CHANGE,
        SERVICE_NO_CHANGE, SERVICE_NO_CHANGE, nil, nil,
        nil, nil, nil, nil, nil);
      Info := ServiceInfo;
      if Result then
        Result := ChangeServiceConfig2(Service,
          SERVICE_CONFIG_DESCRIPTION, @Info);
    finally
      CloseServiceHandle(Service);
    end
    else
      Result := GetLastError = ERROR_SERVICE_EXISTS;
  finally
    CloseServiceHandle(SCManager);
  end
  else
    Result := False
end;
</pre>
<div class="author">Автор: Rouse_</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<pre>
unit DrvMgr;
 
interface
 
uses
  windows, NativeAPI, advApiHook;
 
function InstallDriver(drName, drPath: PChar): boolean;
function UninstallDriver(drName: PChar): boolean;
function LoadDriver(dName: PChar): boolean;
function UnloadDriver(dName: PChar): boolean;
 
implementation
 
const
 DrRegPath = '\registry\machine\system\CurrentControlSet\Services\';
 
{
  Создание в реестре записи о драйвере.
  drName - имя драйвера,
  drPath - путь к файлу драйвера,
  Result - успешность установки.
}
function InstallDriver(drName, drPath: PChar): boolean;
var
 Key, Key2: HKEY;
 dType: dword;
 Err: dword;
 NtPath: array[0..MAX_PATH] of Char;
begin
 Result := false;
 dType := 1;
 Err := RegOpenKeyA(HKEY_LOCAL_MACHINE, 'system\CurrentControlSet\Services', Key);
 if Err = ERROR_SUCCESS then
   begin
    Err := RegCreateKeyA(Key, drName, Key2);
    if Err &lt;&gt; ERROR_SUCCESS then Err := RegOpenKeyA(Key, drName, Key2);
    if Err = ERROR_SUCCESS then
      begin
       lstrcpy(NtPath, PChar('\??\' + drPath));
       RegSetValueExA(Key2, 'ImagePath', 0, REG_SZ, @NtPath, lstrlen(NtPath));
       RegSetValueExA(Key2, 'Type', 0, REG_DWORD, @dType, SizeOf(dword));
       RegCloseKey(Key2);
       Result := true;
      end;
    RegCloseKey(Key);
   end;
end;
 
{
  Удаление записи о драйвере из реестра.
}
function UninstallDriver(drName: PChar): boolean;
var
 Key: HKEY;
begin
  Result := false;
  if RegOpenKeyA(HKEY_LOCAL_MACHINE, 'system\CurrentControlSet\Services', Key) = ERROR_SUCCESS then
    begin
      RegDeleteKey(Key, PChar(drName+'\Enum'));
      RegDeleteKey(Key, PChar(drName+'\Security'));
      Result := RegDeleteKey(Key, drName) = ERROR_SUCCESS;
      RegCloseKey(Key);
    end;
end;
 
{
  Загрузка драйвера.
}
function LoadDriver(dName: PChar): boolean;
var
 Image: TUnicodeString;
 Buff: array [0..MAX_PATH] of WideChar;
begin
  StringToWideChar(DrRegPath + dName, Buff, MAX_PATH);
  RtlInitUnicodeString(@Image, Buff);
  Result := ZwLoadDriver(@Image) = STATUS_SUCCESS;
end;
 
 
{
  Выгрузка драйвера.
}
function UnloadDriver(dName: PChar): boolean;
var
 Image: TUnicodeString;
 Buff: array [0..MAX_PATH] of WideChar;
begin
  StringToWideChar(DrRegPath + dName, Buff, MAX_PATH); 
  RtlInitUnicodeString(@Image, Buff);
  Result := ZwUnloadDriver(@Image) = STATUS_SUCCESS;
end;
 
initialization
 EnablePrivilege('SeLoadDriverPrivilege');
 
end.
</pre>
<div class="author">Автор: Arazel</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
