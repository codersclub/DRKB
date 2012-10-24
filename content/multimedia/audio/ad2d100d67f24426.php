<h1>Нажатия клавиши и звук</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1MouseDown(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
begin
  PlaySound('wmpaud7.wav', 0, SND_NOSTOP + SND_ASYNC);
end;
 
procedure TForm1.Button1MouseUp(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
begin
  PlaySound(nil, 0, 0);
end;
</pre>
<p>&nbsp;<br>
<div class="author">Автор: Smike</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
