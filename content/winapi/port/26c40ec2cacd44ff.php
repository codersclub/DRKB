<h1>Как узнать, есть ли в приемном буфере RS232 данные?</h1>
<div class="date">01.01.2007</div>


<p>При помощи функции ClearCommError можно узнать, сколько байт данных находится в буфере приёма (и буфере передачи) последовательного интерфейса.</p>
<pre>
procedure DataInBuffer(Handle: THandle; 
                       var InQueue, OutQueue: integer); 
var ComStat: TComStat; 
    e: integer; 
begin 
  if ClearCommError(Handle, e, @ComStat) then 
  begin 
    InQueue := ComStat.cbInQue; 
    OutQueue := ComStat.cbOutQue; 
  end 
  else 
  begin 
    InQueue := 0; 
    OutQueue := 0; 
  end; 
end; 
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

