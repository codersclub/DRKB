<h1>Проверить, запущена ли программа от System Account</h1>
<div class="date">01.01.2007</div>


<pre>
function OnSystemAccount(): Boolean;
const
  cnMaxNameLen = 254;
var
  sName: string;
  dwNameLen: DWORD;
begin
  dwNameLen := cnMaxNameLen - 1;
  SetLength(sName, cnMaxNameLen);
  GetUserName(PChar(sName), dwNameLen);
  SetLength(sName, dwNameLen);
  if UpperCase(Trim(sName)) = 'SYSTEM' then Result := True 
  else 
    Result := False;
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
