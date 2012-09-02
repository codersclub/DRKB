<h1>Как запретить Ctrl-Alt-Del?</h1>
<div class="date">01.01.2007</div>


<pre>
var 
  i : integer; 
begin 
i := 0; 
{запрещаем Ctrl-Alt-Del} 
SystemParametersInfo( SPI_SCREENSAVERRUNNING, 1, @i, 0); 
end. 
// необходим unit WinProcs
// для Alt-Tab: SPI_SETFASTTASKSWITCH 
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

