<h1>Как узнать, находится ли мышка на форме?</h1>
<div class="date">01.01.2007</div>


<p>Для этого можно воспользоваться API функцией GetCapture().</p>

<p>Пример:</p>
<pre>
procedure TForm1.FormDeactivate(Sender: TObject);
begin
  ReleaseCapture;
end;
 
procedure TForm1.FormMouseMove(Sender: TObject; Shift: TShiftState; X,
  Y: Integer);
begin
  If GetCapture = 0 then
    SetCapture(Form1.Handle);
  if PtInRect(Rect(Form1.Left,
                   Form1.Top,
                   Form1.Left + Form1.Width,
                   Form1.Top + Form1.Height),
                   ClientToScreen(Point(x, y))) then
  Form1.Caption := 'Мышка на форме' else
  Form1.Caption := 'Мышка за пределами формы';
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

