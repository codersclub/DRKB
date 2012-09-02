<h1>Как удалить все файлы из Recent Documents?</h1>
<div class="date">01.01.2007</div>


Для этого можно воспользоваться API функцией SHAddToRecentDocs:</p>
<pre>procedure TForm1.Button1Click(Sender: TObject);
begin
SHAddToRecentDocs(SHARD_PATH, 0);
end;
</pre>
<p>Не забудьте включить ShlObj в Unit</p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
