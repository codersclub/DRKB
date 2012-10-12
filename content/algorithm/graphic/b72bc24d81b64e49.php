<h1>Как нарисовать график функции?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button3Click(Sender: TObject);
var x, y: array[1..50] of double;
  i: integer;
  scalex, scaley, ymin, ymax, xmin, xmax: double;
begin
  for i := 1 to 50 do
    begin
      y[i] := sin(i * 0.5);
      x[i] := i;
    end;
  xmin := x[1];
  xmax := x[1];
  ymin := y[1];
  ymax := y[1];
  for i := 2 to 50 do
    begin // или используйте ymin:=MinValue(y); и т.д.
      if y[i] &lt; ymin then ymin := y[i];
      if y[i] &gt; ymax then ymax := y[i];
      if x[i] &lt; xmin then xmin := x[i];
      if x[i] &gt; xmax then xmax := x[i];
    end;
  scalex := paintbox1.Width / (xmax - xmin);
  scaley := paintbox1.Height / (ymax - ymin);
  with paintbox1.canvas do
    begin
      moveto(trunc(scalex * (x[1] - xmin)), paintbox1.height - trunc(scaley * (y[1] - ymin)));
      for i := 2 to 50 do
        Lineto(trunc(scalex * (x[i] - xmin)), paintbox1.height - trunc(scaley * (y[i] - ymin)));
    end;
end;
</pre>
<hr /><p>Забавная штука синусы:</p>
<pre>
 
for i:=1 to 500 do begin
  paintbox1.Canvas.Pixels [round(sin(i*5)*10+50),round(sin(i*10)*10+50)] := RGB(0,0,0);
</pre>

<p class="author">Автор: Baa</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

