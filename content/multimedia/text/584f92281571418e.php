<h1>Вывод надписи на рабочий стол</h1>
<div class="date">01.01.2007</div>


<p>На рабочий стол можно вывести строку используя</p>
<p>TextOut(GetWindowDC(GetDesktopWindow),100,100,'Thom',4);&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;</p>

<div class="author">Автор: Fantasist</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

<hr />

<p>Поверх всех окон можно нарисовать надпись использую следующую процедуру:</p>
<pre>
procedure WriteDC(s: string);
var c: TCanvas;
begin
  c := TCanvas.Create;
  c.Brush.Color := clBlue;
  c.Font.color := clYellow;
  c.Font.name := 'Fixedsys';
  c.Handle := GetDC(GetWindow(GetDesktopWindow, GW_OWNER));
  c.TextOut(screen.Width - c.TextWidth(s) - 2, screen.Height - 43, s);
  c.free;
end;
</pre>

<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

