<h1>Как узнать частоту обновления монитора?</h1>
<div class="date">01.01.2007</div>


<pre>
function GetDisplayFrequency: Integer; 

 
var 
 DeviceMode: TDeviceMode; 
 
begin 
 EnumDisplaySettings(nil, Cardinal(-1), DeviceMode); 
 Result := DeviceMode.dmDisplayFrequency; 
end;
</pre>
<div class="author">Автор: p0s0l</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
