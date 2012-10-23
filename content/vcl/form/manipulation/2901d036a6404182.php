<h1>Как сделать плавное закрытие окна?</h1>
<div class="date">01.01.2007</div>


<p>Работает в 2k/XP:</p>
<pre>
procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);

begin
 AnimateWindow(Handle, 500, AW_HIDE or AW_BLEND);
end; 
</pre>

<div class="author">Автор: p0s0l</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
