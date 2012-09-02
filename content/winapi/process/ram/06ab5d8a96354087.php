<h1>Как получить весь размер системной памяти?</h1>
<div class="date">01.01.2007</div>


<pre>
function GetMemoryTotalPhys : DWord; 
var 
memStatus: TMemoryStatus; 
begin 
memStatus.dwLength := sizeOf ( memStatus ); 
GlobalMemoryStatus ( memStatus ); 
Result := memStatus.dwTotalPhys; 
end; 
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

