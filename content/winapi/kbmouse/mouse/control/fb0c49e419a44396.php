<h1>Как ограничить движения мышки определенной областью?</h1>
<div class="date">01.01.2007</div>


<p>Для этого можно воспользоваться API функцией ClipCursor(). Например, можно вставить следующий код в обработчик события формы OnMouseDown:</p>
<p>ClipCursor(&amp;BoundsRect);</p>

<p>а следующий код в обработчик события формы OnMouseUp:</p>
<p>ClipCursor(NULL);</p>

<p>Если нажать кнопку мыши на форме и удерживать её, то курсор мышки не сможет покинуть пределы формы.</p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<p>Сначала определяете ограничивающий прямоугольник, затем используете функцию ClipCursor(), передав ей в качестве параметра указатель на этот прямоугольник. Например, вот так можно по 100 пикселей скостить по краям экрана:</p>

<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  r: TRect;
  pr: PRect;
begin
  r.Left := 100;
  r.Top := 100;
  r.Right := Screen.Width - 100;
  r.Bottom := Screen.Height - 100;
  pr := @r;
  ClipCursor(pr);
end;
 
 
 
 
Чтобы восстановить: 
 
 
 
ClipCursor(NULL);
</pre>



<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

