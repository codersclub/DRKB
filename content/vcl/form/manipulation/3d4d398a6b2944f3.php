<h1>Как сделать, чтобы форма закрывалась при нажатии Esc?</h1>
<div class="date">01.01.2007</div>


<p>Для начала необходимо установить свойство формы KeyPreview в True. А потом уже можно отлавливать "Esc":</p>
<pre>
procedure TForm1.FormCreate(Sender: TObject);
begin
  Form1.KeyPreview := True;
end;
 
procedure TForm1.FormKeyPress
  (Sender: TObject; var Key: Char);
begin
  if key = #27 then Close;
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

