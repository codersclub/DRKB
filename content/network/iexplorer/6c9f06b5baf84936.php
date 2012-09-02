<h1>Узнать информацию о прокси сервере</h1>
<div class="date">01.01.2007</div>


<pre>
uses
  WinInet;
 
function GetProxyInformation: string;
var
  ProxyInfo: PInternetProxyInfo;
  Len: LongWord;
begin
  Result := '';
  Len := 4096;
  GetMem(ProxyInfo, Len);
  try
    if InternetQueryOption(nil, INTERNET_OPTION_PROXY, ProxyInfo, Len) then
      if ProxyInfo^.dwAccessType = INTERNET_OPEN_TYPE_PROXY then
      begin
        Result := ProxyInfo^.lpszProxy
      end;
  finally
    FreeMem(ProxyInfo);
  end;
end;
 
{**************************************************************************
* NAME:    GetProxyServer
* DESC:    Proxy-Server Einstellungen abfragen
* PARAMS:  protocol =&gt; z.B. 'http' oder 'ftp'
* RESULT:  [-]
* CREATED: 08-04-2004/shmia
*************************************************************************}
procedure GetProxyServer(protocol: string; var ProxyServer: string;
  var ProxyPort: Integer);
var
  i: Integer;
  proxyinfo, ps: string;
begin
  ProxyServer := '';
  ProxyPort := 0;
 
  proxyinfo := GetProxyInformation;
  if proxyinfo = '' then
    Exit;
 
  protocol := protocol + '=';
 
  i := Pos(protocol, proxyinfo);
  if i &gt; 0 then
  begin
    Delete(proxyinfo, 1, i + Length(protocol));
    i := Pos(';', ProxyServer);
    if i &gt; 0 then
      proxyinfo := Copy(proxyinfo, 1, i - 1);
  end;
 
  i := Pos(':', proxyinfo);
  if i &gt; 0 then
  begin
    ProxyPort := StrToIntDef(Copy(proxyinfo, i + 1, Length(proxyinfo) - i), 0);
    ProxyServer := Copy(proxyinfo, 1, i - 1)
  end
end;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  ProxyServer: string;
  ProxyPort: Integer;
begin
  GetProxyServer('http', ProxyServer, ProxyPort);
  Label1.Caption := ProxyServer;
  label2.Caption := IntToStr(ProxyPort);
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
