<h1>Как добавить документ в меню «Пуск &gt; Документы»?</h1>
<div class="date">01.01.2007</div>


<p>Используйте функцию SHAddToRecentDocs.</p>
<pre>
uses ShlOBJ;
 
procedure TForm1.Button1Click(Sender: TObject);
var
   s : string;
begin
   s := 'C:\DownLoad\ntkfaq.html';
   SHAddToRecentDocs(SHARD_PATH, pChar(s));
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


