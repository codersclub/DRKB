<h1>За какое время было создано изображение?</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: Даниил Карапетян</div>
<p>WEB сайт: http://program.dax.ru  </p>

<p>При нажатии на Button1 используется свойство Pixels, а при нажатии на Button2 - ScanLine. В заголовок окна выводится время в миллисекундах, за которое было создано изображение. </p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  t: cardinal;
  x, y: integer;
  bm: TBitmap;
begin
  bm := TBitmap.Create;
  bm.PixelFormat := pf24bit;
  bm.Width := Form1.ClientWidth;
  bm.Height := Form1.ClientHeight;
  t := GetTickCount;
  for y := 0 to bm.Height - 1 do
    for x := 0 to bm.Width - 1 do
    bm.Canvas.Pixels[x,y] := RGB(x+y, x-y, y-x);
  Form1.Caption := IntToStr(GetTickCount - t);
  Form1.Canvas.Draw(0, 0, bm);
end;
 
procedure TForm1.Button2Click(Sender: TObject);
var
  t: cardinal;
  x, y: integer;
  bm: TBitmap;
  p: PByteArray;
begin
  bm := TBitmap.Create;
  bm.PixelFormat := pf24bit;
  bm.Width := Form1.ClientWidth;
  bm.Height := Form1.ClientHeight;
  t := GetTickCount;
  for y := 0 to bm.Height - 1 do
  begin
    p := bm.ScanLine[y];
    for x := 0 to bm.Width - 1 do
    begin
      p^[x*3] := x+y;
      p^[x*3+1] := x-y;
      p^[x*3+2] := y-x;
    end;
  end;
  Form1.Caption := IntToStr(GetTickCount - t);
  Form1.Canvas.Draw(0, 0, bm);
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>

