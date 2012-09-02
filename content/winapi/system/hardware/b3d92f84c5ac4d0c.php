<h1>Определение видеокарты</h1>
<div class="date">01.01.2007</div>


<pre>{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Определение видеокарты
&nbsp;
Зависимости: Windows
Автор:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Gua, gua@ukr.net, ICQ:141585495, Simferopol
Copyright:&nbsp;&nbsp; Gua
Дата:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 18 июля 2002 г.
********************************************** }
&nbsp;
function GetDisplayDevice: string;
var
  lpDisplayDevice: TDisplayDevice;
begin
  lpDisplayDevice.cb := sizeof(lpDisplayDevice);
  EnumDisplayDevices(nil, 0, lpDisplayDevice , 0);
  Result:=lpDisplayDevice.DeviceString;
end;
</pre>

