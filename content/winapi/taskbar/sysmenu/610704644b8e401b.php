<h1>Как очистить пункт меню Документы кнопки «Пуск»?</h1>
<div class="date">01.01.2007</div>


<p>Вызовите Windows API функцию SHAddToRecentDocs() передав nil вместо имени файла в качестве параметра.</p>
<pre>
uses ShlOBJ;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
      SHAddToRecentDocs(SHARD_PATH, nil);
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

