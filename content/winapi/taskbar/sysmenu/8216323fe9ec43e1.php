<h1>Как добавить файл в меню Пуск / Документы?</h1>
<div class="date">01.01.2007</div>


<p>Эта программа добавляет файл "File.txt" в "Пуск/Документы". </p>
<pre>
uses ShlOBJ;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  SHAddToRecentDocs(SHARD_PATH, PChar('File.txt'));
end;
</pre>


<p class="author">Автор: Даниил Карапетян (delphi4all@narod.ru)</p>
<p class="author">Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)</p>

