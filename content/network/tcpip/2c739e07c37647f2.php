<h1>Как преобразовать длинный IP-адрес в короткий адрес / порт?</h1>
<div class="date">01.01.2007</div>


<p>Некоторые старые internet протоколы ( такие как FTP ) посылают IP адреса и номера портов в шестизначном формате XXX.XXX.XXX.XXX.XX.XXX&nbsp; Следующий код позволяет преобразовать такой адрес к нормальному четырёхзначному IP адресу.</p>
<pre>
procedure LongIPToShort(aLongIPAddress: string; out ShortIPAddress: string; out PortNumber: Integer);
var I, DotPos, tempPort: Integer;
var tempAddy, temp: string;
var TempStr: string;
begin
  tempAddy := '';
  tempStr := '';
// Определяем, какой символ использует отправитель в качестве разделителя длинного IP: , или .
 
  if (POS(',', aLongIPAddress) &lt;&gt; 0) then
    TempStr := ','
  else
    TempStr := '.';
 
  for I := 1 to 4 do
    begin
      DotPOS := POS(TempStr, aLongIPAddress);
      tempAddy := tempAddy + (Copy(aLongIPAddress, 1, (DotPos - 1)));
      if I &lt;&gt; 4 then TempADdy := TempAddy + '.';
      Delete(aLongIpAddress, 1, DotPos);
    end;
  DotPos := Pos(TempStr, aLongIpAddress);
  temp := Copy(aLongIpAddress, 1, (DotPos - 1));
  tempPort := (StrToInt(temp) * 256);
  Delete(aLongIpAddress, 1, DotPos);
  TempPort := tempPort + StrToInt(ALongIpAddress);
  ShortIPAddress := TempADdy;
  PortNumber := tempPort;
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

