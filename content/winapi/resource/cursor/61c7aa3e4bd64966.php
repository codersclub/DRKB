<h1>Проверить видимость курсора</h1>
<div class="date">01.01.2007</div>


<pre>
function IsCursorVisible: Boolean;
begin
  Result := ShowCursor(True) &gt; 0;
  ShowCursor(False);
end;
</pre>
<p> <br>
Автор: s-mike <br>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
