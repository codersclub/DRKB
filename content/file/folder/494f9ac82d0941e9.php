<h1>Как получить UNC-путь к файлу?</h1>
<div class="date">01.01.2007</div>


<pre>
function GetUNCName(PathStr: string): string;
var
  bufSize: DWord;
  buf: TUniversalNameInfo;
  msg: string;
begin
  bufSize := SizeOf(TUniversalNameInfo);
  if (WNetGetUniversalName(PChar(PathStr), UNIVERSAL_NAME_INFO_LEVEL,
    buf, bufSize) &gt; 0) then
    case GetLastError of
      ERROR_BAD_DEVICE: msg := 'ERROR_BAD_DEVICE';
      ERROR_CONNECTION_UNAVAIL: msg := 'ERROR_CONNECTION_UNAVAIL';
      ERROR_EXTENDED_ERROR: msg := 'ERROR_EXTENDED_ERROR';
      ERROR_MORE_DATA: msg := 'ERROR_MORE_DATA';
      ERROR_NOT_SUPPORTED: msg := 'ERROR_NOT_SUPPORTED';
      ERROR_NO_NET_OR_BAD_PATH: msg := 'ERROR_NO_NET_OR_BAD_PATH';
      ERROR_NO_NETWORK: msg := 'ERROR_NO_NETWORK';
      ERROR_NOT_CONNECTED: msg := 'ERROR_NOT_CONNECTED';
    end
  else
    msg := buf.lpUniversalName;
 
  Result := msg;
end;
</pre>

<p>Работает только на NT/2000/XP</p>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
