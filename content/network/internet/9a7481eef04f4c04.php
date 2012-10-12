<h1>Есть ли соединение с инетом?</h1>
<div class="date">01.01.2007</div>


<p>За это отвечает ф-ии InternetGetConnectedState() из wininet.dll или InetIsOffLine() из url.dll </p>
<p class="author">Автор: Song</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>Единственный 100% достоверный способ узнать находится ли комп в интернете это скачать что-то со стабильного внешнего сервера - такого как Microsoft, Yahoo, AT&amp;T... По другому ни одна функция локального компьютера не сможет отличить нахождение компьютера в интранете и в интернете... Я в своей программе для определения коннекта с интернетом пингую наш собственный DNS сервер, который стоит за Firewall и естественно пинговка идет через провайдера интернет. (В некоторых Firewall может быть запрещен Ping - тогда надо именно попытаться скачать что-нибудь)</p>
<p class="author">Автор: Vit</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr /><p>Часто приложению, которое работает в интернете, требуется знать, подключён пользователь к интернету или нет. Предлагаю Вам довольно гибкое решение этого вопроса.</p>
<p>Совместимость: Delphi 3.x (или выше)</p>
<p>Для работы Вам необходимо импортировать функцию InetIsOffline из URL.DLL: </p>
<p>function InetIsOffline(Flag: Integer): Boolean; stdcall; external 'URL.DLL'; </p>
<p>а затем поместить в программу простой вызов функции для проверки статуса соединения: </p>
<p>if InetIsOffline(0) then </p>
<p> &nbsp; ShowMessage('This computer is not connected to Internet!') </p>
<p>else </p>
<p> &nbsp; ShowMessage(You are connected to Internet!'); </p>
<p>Эта функция возвращает TRUE если соединение с интернетов отсутствует, или FALSE если соединение установлено. </p>
<p>Замечание: </p>
<p>параметр Flag игнорируется, соответственно используем ноль. </p>
<p>Эта DLL обычно проинсталлирована на большинстве компьютеров. Она также существует в Win98 либо поставляется с Internet Explorer 4 или выше, Office 97 и т.д.. </p>
<p>Более подробно можно прочитать в MSDN. Оригинал: http://msdn.microsoft.com/library/psdk/shellcc/shell/Functions/InetIsOffline.htm</p>
<p class="author">Автор: Vitaly Zayko</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<hr /><p>
</p>
<pre>
interface 
 
uses 
  Windows, SysUtils, Registry, WinSock, WinInet; 
 
type 
  TConnectionType = (ctNone, ctProxy, ctDialup); 
 
function ConnectedToInternet: TConnectionType; 
function RasConnectionCount: Integer; 
 
 
implementation 
 
//For RasConnectionCount ======================= 
const 
  cERROR_BUFFER_TOO_SMALL = 603; 
  cRAS_MaxEntryName       = 256; 
  cRAS_MaxDeviceName      = 128; 
  cRAS_MaxDeviceType      = 16; 
type 
  ERasError = class(Exception); 
 
  HRASConn = DWORD; 
  PRASConn = ^TRASConn; 
  TRASConn = record 
    dwSize: DWORD; 
    rasConn: HRASConn; 
    szEntryName: array[0..cRAS_MaxEntryName] of Char; 
    szDeviceType: array[0..cRAS_MaxDeviceType] of Char; 
    szDeviceName: array [0..cRAS_MaxDeviceName] of Char; 
  end; 
 
  TRasEnumConnections = 
    function(RASConn: PrasConn; { buffer to receive Connections data } 
    var BufSize: DWORD;    { size in bytes of buffer } 
    var Connections: DWORD { number of Connections written to buffer } 
    ): Longint;  
  stdcall; 
  //End RasConnectionCount ======================= 
 
 
function ConnectedToInternet: TConnectionType; 
var 
  Reg:       TRegistry; 
  bUseProxy: Boolean; 
  UseProxy:  LongWord; 
begin 
  Result := ctNone; 
  Reg    := TRegistry.Create; 
  with REG do 
    try 
      try 
        RootKey := HKEY_CURRENT_USER; 
        if OpenKey('\Software\Microsoft\Windows\CurrentVersion\Internet settings', False) then  
        begin 
          //I just try to read it, and trap an exception 
          if GetDataType('ProxyEnable') = rdBinary then 
            ReadBinaryData('ProxyEnable', UseProxy, SizeOf(Longword)) 
          else  
          begin 
            bUseProxy := ReadBool('ProxyEnable'); 
            if bUseProxy then 
              UseProxy := 1 
            else 
              UseProxy := 0; 
          end; 
          if (UseProxy &lt;&gt; 0) and (ReadString('ProxyServer') &lt;&gt; '') then 
            Result := ctProxy; 
        end; 
      except 
        //Obviously not connected through a proxy 
      end; 
    finally 
      Free; 
    end; 
 
  //We can check RasConnectionCount even if dialup networking is not installed 
  //simply because it will return 0 if the DLL is not found. 
  if Result = ctNone then  
  begin 
    if RasConnectionCount &gt; 0 then Result := ctDialup; 
  end; 
end; 
 
function RasConnectionCount: Integer; 
var 
  RasDLL:    HInst; 
  Conns:     array[1..4] of TRasConn; 
  RasEnums:  TRasEnumConnections; 
  BufSize:   DWORD; 
  NumConns:  DWORD; 
  RasResult: Longint; 
begin 
  Result := 0; 
 
  //Load the RAS DLL 
  RasDLL := LoadLibrary('rasapi32.dll'); 
  if RasDLL = 0 then Exit; 
 
  try 
    RasEnums := GetProcAddress(RasDLL, 'RasEnumConnectionsA'); 
    if @RasEnums = nil then 
      raise ERasError.Create('RasEnumConnectionsA not found in rasapi32.dll'); 
 
    Conns[1].dwSize := SizeOf(Conns[1]); 
    BufSize         := SizeOf(Conns); 
 
    RasResult := RasEnums(@Conns, BufSize, NumConns); 
 
    if (RasResult = 0) or (Result = cERROR_BUFFER_TOO_SMALL) then Result := NumConns; 
  finally 
    FreeLibrary(RasDLL); 
  end; 
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
