<h1>Как отловить смену фокуса для всех контролов?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.ActiveControlChange(Sender: TObject);

begin
  Caption := TScreen(Sender).ActiveForm.ActiveControl.Name;
end;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  Screen.OnActiveControlChange := ActiveControlChange;
end;
</pre>

<div class="author">Автор: p0s0l</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

