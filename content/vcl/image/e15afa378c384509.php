<h1>Как сохранить содержимое TPaintBox в TBitmap</h1>
<div class="date">01.01.2007</div>


<pre>
var
  Bitmap: TBitmap;
  Source: TRect;
  Dest: TRect;
begin
  Bitmap := TBitmap.Create;
  try
    with Bitmap do
    begin
      Width := MyPaintBox.Width;
      Height := MyPaintBox.Height;
      Dest := Rect(0, 0, Width, Height);
    end;
    with MyPaintBox do
      Source := Rect(0, 0, Width, Height);
    Bitmap.Canvas.CopyRect(Dest, MyPaintBox.Canvas, Source);
    Bitmap.SaveToFile('MYFILE.BMP');
  finally
    Bitmap.Free;
  end;
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
