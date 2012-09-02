<h1>Переместиться в конец файла</h1>
<div class="date">01.01.2007</div>


<pre>
{ прыгаем в конец (eof) }
procedure gotoeof (f : file);
begin
  { перемещаемся в начало }
  seek (f, 0);
  { перемещаемся вперед на "x" количество байт,
    в нашем случае это размер файла! }
  seek (f, filesize(f));
end; {gotoeof}
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
