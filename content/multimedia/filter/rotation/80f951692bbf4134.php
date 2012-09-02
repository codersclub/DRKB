<h1>Алгоритм поворота изображения</h1>
<div class="date">01.01.2007</div>


<p>Вот алгоритм поворота изображения. Пусть O - это центр поворота, а M - некая точка исходного изображения. </p>
<p>Для каждой точки M нужно найти угол alpha между отрезком OM и горизонталью и длину r отрезка OM. </p>
<p>Теперь, чтобы повернуть изображение на угол beta, нужно каждой точке M </p>
<p>присвоить цвет точки исходного изображения с координатами x,y, где</p>
<p>x = xo + r * cos(alpha + beta)</p>
<p>y = yo + r * sin(alpha + beta)</p>
<p>(xo,yo - центр поворота, r - длина отрезка OM).</p>

<p>Важно именно каждой точке нового изображения сопоставлять точку старого изображения, </p>
<p>а не наоборот, так как иначе некоторые точки нового изображения останутся не закрашенными.</p>

<p>Эту программу можно сильно ускорить, если исходное изображение записать в массив и</p>
<p> обращаться к реальной переменной, а не к свойству Canvas.Pixels. </p>

<pre>
uses Math;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  bm, bm1: TBitMap;
  x, y: integer;
  r, a: single;
  xo, yo: integer;
  s, c: extended;
begin
  bm := TBitMap.Create;
  bm.LoadFromFile('ex.bmp');
  xo := bm.Width div 2;
  yo := bm.Height div 2;
  bm1 := TBitMap.Create;
  bm1.Width := bm.Width;
  bm1.Height := bm.Height;
  a := 0;
  repeat
    for y := 0 to bm.Height - 1 do begin
      for x := 0 to bm.Width - 1 do begin
        r := sqrt(sqr(x - xo) + sqr(y - yo));
        SinCos(a + arctan2((y - yo), (x - xo)), s, c);
        bm1.Canvas.Pixels[x,y] := bm.Canvas.Pixels[
          round(xo + r * c), round(yo + r * s)];
      end;
      Application.ProcessMessages;
    end;
    Form1.Canvas.Draw(xo, yo, bm1);
    a := a + 0.05;
    Application.ProcessMessages;
  until Form1.Tag &lt;&gt; 0;
  bm.Destroy;
  bm1.Destroy;
end;
 
procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
begin
  Form1.Tag := 1;
end;
</pre>


<p>Взято с сайта <a href="https://blackman.wp-club.net/" target="_blank">https://blackman.wp-club.net/</a></p>
