<h1>Захват части изображения</h1>
<div class="date">01.01.2007</div>

Вот пример кода, позволящего с помощью TBitmap захватить часть изображения и сохранить его в файле. Я включил функцию копирования палитры, необходимой при работе в режиме 256 цветов.</p>
<pre>
function CopyPalette(Palette: HPalette): HPalette;
var
  nEntries: integer;
  LogPalSize: integer;
  LogPalette: PLogPalette;
begin
  Result := 0;
  if Palette = 0 then
    exit;
  GetObject(Palette, sizeof(nEntries), @nEntries);
  if nEntries &lt; 1 then
    exit;
  LogPalSize := sizeof(TLogPalette) + sizeof(TPaletteEntry) * (nEntries - 1);
  GetMem(LogPalette, LogPalSize);
  with LogPalette^ do
  try
    palVersion := $300;
    palNumEntries := nEntries;
    GetPaletteEntries(Palette, 0, nEntries, palPalEntry[0]);
    Result := CreatePalette(LogPalette^);
  finally
    FreeMem(LogPalette, LogPalSize);
  end;
end;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  Bitmap: TBitmap;
begin
  Bitmap := TBitmap.Create;
  try
    Bitmap.Width := 50;
    Bitmap.Height := 40;
    Bitmap.Palette := CopyPalette(Image1.Picture.Bitmap.Palette);
    Bitmap.Canvas.CopyRect(Rect(0, 0, 50, 40),
      Image1.Picture.Bitmap.Canvas,
      Bounds(20, 10, 50, 40));
    Bitmap.SaveToFile('c:\windows\temp\junk.bmp');
  finally
    Bitmap.Free;
  end;
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

