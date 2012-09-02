<h1>Как открыть меню кнопки «Пуск»?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  SendMessage(Self.Handle, WM_SYSCOMMAND, SC_TASKLIST, 0); 
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
