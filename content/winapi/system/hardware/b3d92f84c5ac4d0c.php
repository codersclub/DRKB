<h1>Определение видеокарты</h1>
<div class="date">01.01.2007</div>


<pre>{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Определение видеокарты
 
Зависимости: Windows
Автор:       Gua, gua@ukr.net, ICQ:141585495, Simferopol
Copyright:   Gua
Дата:        18 июля 2002 г.
********************************************** }
 
function GetDisplayDevice: string;
var
  lpDisplayDevice: TDisplayDevice;
begin
  lpDisplayDevice.cb := sizeof(lpDisplayDevice);
  EnumDisplayDevices(nil, 0, lpDisplayDevice , 0);
  Result:=lpDisplayDevice.DeviceString;
end;
</pre>

