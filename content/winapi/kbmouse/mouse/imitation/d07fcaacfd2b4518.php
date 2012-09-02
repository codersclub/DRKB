<h1>Как автоматически помещать курсор мышки в центр контрола получившего фокус?</h1>
<div class="date">01.01.2007</div>


<p>Нам потребуется универсальная функция, которую можно будет применять для различных визуальных контролов.</p>

<p>Вот пример вызова нашей функции:</p>

<pre>
procedure TForm1.Button1Enter(Sender: TObject);
begin
  MoveMouseOverControl(Sender);
end;
</pre>


<p>Сама функция:</p>

<pre>
procedure MoveMouseOverControl(Sender: TObject);
var
  Point: TPoint;
begin
  with TControl(Sender) do
  begin
    Point.X := Left + (Width  div 2);
    Point.Y := Top +  (Height div 2);
    Point := Parent.ClientToScreen(Point);
    SetCursorPos(Point.X, Point.Y);
  end;
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<p>Исправлено Stolzen </p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

