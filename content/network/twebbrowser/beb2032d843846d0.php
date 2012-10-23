<h1>Cut и Copy отказываются работать</h1>
<div class="date">01.01.2007</div>


<p>Вам нужно добавить следующие строки в конец unit:</p>
<pre>
initialization
  OleInitialize(nil);
finalization
  OleUninitialize;
</pre>

<div class="author">Автор: Song</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

