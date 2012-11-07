<h1>Качественное увеличение изображения билинейной интерполяцией</h1>
<div class="date">01.01.2007</div>

Этот алгоритм увеличивает изображение в произвольное количество раз при помощи билинейной интерполяции. При создании нового изображения каждой его точке с целыми координатами (x,y) сопоставляется точка исходного изображения с дробными координатами (xo, yo), xo=x/dx, yo=y/dy (dx и dy - коэффициенты увеличения). Далее нужно провести поверхность через точки, лежащие вокруг (xo, yo). Цвет здесь рассматривается как третье измерение. На поверхности ищется точка с координатами (xo, yo) и ее цвет понимается за цвет точки (x,y) получаемого изображения.</p>
<p>Этот алгоритм хорошо работает при целых или больших коэффициентах увеличения. Но резкие границы размываются. Для уменьшения изображения этот алгоритм также не подходит.</p>
<pre>
procedure Interpolate(var bm: TBitMap; dx, dy: single);
var
  bm1: TBitMap;
  z1, z2: single;
  k, k1, k2: single;
  x1, y1: integer;
  c: array [0..1, 0..1, 0..2] of byte;
  res: array [0..2] of byte;
  x, y: integer;
  xp, yp: integer;
  xo, yo: integer;
  col: integer;
  pix: TColor;
begin
  bm1 := TBitMap.Create;
  bm1.Width := round(bm.Width * dx);
  bm1.Height := round(bm.Height * dy);
  for y := 0 to bm1.Height - 1 do
  begin
    for x := 0 to bm1.Width - 1 do
    begin
      xo := trunc(x / dx);
      yo := trunc(y / dy);
      x1 := round(xo * dx);
      y1 := round(yo * dy);
 
      for yp := 0 to 1 do
        for xp := 0 to 1 do
        begin
          pix := bm.Canvas.Pixels[xo + xp, yo + yp];
          c[xp, yp, 0] := GetRValue(pix);
          c[xp, yp, 1] := GetGValue(pix);
          c[xp, yp, 2] := GetBValue(pix);
        end;
 
      for col := 0 to 2 do
      begin
        k1 := (c[1,0,col] - c[0,0,col]) / dx;
        z1 := x * k1 + c[0,0,col] - x1 * k1;
        k2 := (c[1,1,col] - c[0,1,col]) / dx;
        z2 := x * k2 + c[0,1,col] - x1 * k2;
        k := (z2 - z1) / dy;
        res[col] := round(y * k + z1 - y1 * k);
      end;
      bm1.Canvas.Pixels[x,y] := RGB(res[0], res[1], res[2]);
    end;
    Form1.Caption := IntToStr(round(100 * y / bm1.Height)) + '%';
    Application.ProcessMessages;
    if Application.Terminated then
      Exit;
  end;
  bm := bm1;
end;
 
const
  dx = 5.5;
  dy = 5.5;
 
procedure TForm1.Button1Click(Sender: TObject);
const
  w = 50;
  h = 50;
var
  bm: TBitMap;
  can: TCanvas;
begin
  bm := TBitMap.Create;
  can := TCanvas.Create;
  can.Handle := GetDC(0);
  bm.Width := w;
  bm.Height := h;
  bm.Canvas.CopyRect(Bounds(0, 0, w, h), can, Bounds(0, 0, w, h));
  ReleaseDC(0, can.Handle);
  Interpolate(bm, dx, dy);
  Form1.Canvas.Draw(0, 0, bm);
  Form1.Caption := 'x: ' + FloatToStr(dx) +
  ' y: ' + FloatToStr(dy) +
  ' width: ' + IntToStr(w) +
  ' height: ' + IntToStr(h);
end;
 
procedure TForm1.Button2Click(Sender: TObject);
var
  bm: TBitMap;
begin
  if OpenDialog1.Execute then
    bm.LoadFromFile(OpenDialog1.FileName);
  Interpolate(bm, dx, dy);
  Form1.Canvas.Draw(0, 0, bm);
  Form1.Caption := 'x: ' + FloatToStr(dx) +
  ' y: ' + FloatToStr(dy) +
  ' width: ' + IntToStr(bm.Width) +
  ' height: ' + IntToStr(bm.Height);
end;
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

