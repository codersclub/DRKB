<h1>Как осуществить быстрый поиск в TListBox?</h1>
<div class="date">01.01.2007</div>


<p>Очень просто, смотри пример....</p>
<p>считаем, сто есть поле Edit1, в котором набираем текст, и ListBox, в котором ищем нужную строку, (как в Нelp).</p>
<pre>
procedure TForm1.Edit1Change(Sender: TObject);
begin
  ListBox1.Perform(LB_SELECTSTRING,-1,longint(Pchar(Edit1.text)));
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


