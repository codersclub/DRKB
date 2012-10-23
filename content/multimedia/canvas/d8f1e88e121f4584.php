<h1>Как быстро выводить графику?</h1>
<div class="date">01.01.2007</div>


<p>Как быстро выводить графику (a то Canvas очень медленно работает)&nbsp;</p>

<p>Вот пример заполнения формы точками случайного цвета:</p>

<pre>
type
  TRGB = record
    b, g, r: byte;
  end;
  ARGB = array[0..1] of TRGB;
  PARGB = ^ARGB;
 
var
  b: TBitMap;
 
procedure TForm1.FormCreate(sender: TObject);
begin
  b := TBitMap.Create;
  b.pixelformat := pf24bit;
  b.width := Clientwidth;
  b.height := Clientheight;
end;
 
procedure TForm1.Tim1OnTimer(sender: TObject);
var
  p: PARGB;
  x, y: integer;
begin
  for y := 0 to b.height - 1 do
  begin
    p := b.scanline[y];
    for x := 0 to b.width - 1 do
    begin
      p[x].r := random(256);
      p[x].g := random(256);
      p[x].b := random(256);
    end;
  end;
  canvas.draw(0, 0, b);
end;
 
procedure TForm1.FormDestroy(sender: TObject);
begin
  b.free;
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
