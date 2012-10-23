<h1>Инверсия цветов</h1>
<div class="date">01.01.2007</div>


<pre>
function InvertBitmap(Bmp: TBitmap): TBitmap;
var
  x, y: integer;
  ByteArray: PByteArray;
begin
  Bmp.PixelFormat := pf24Bit;
  for y := 0 to Bmp.Height - 1 do
  begin
    ByteArray := Bmp.ScanLine[y];
    for x := 0 to Bmp.Width * 3 - 1 do
    begin
      ByteArray[x] := 255 - ByteArray[x];
    end;
  end;
  Result := Bmp;
end;
</pre>
<p>&nbsp;<br>
&nbsp;<br>
<p>ПРИМЕР ИСПОЛЬЗОВАНИЯ:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
  Image1.Picture.Bitmap := InvertBitmap(Image1.Picture.Bitmap);
end;
</pre>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<div class="author">Автор: Song</div>
