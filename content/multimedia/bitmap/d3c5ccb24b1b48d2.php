<h1>Вывод изображения по маске, используется MaskBlt</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  BitmapSrc, BitmapMask: TBitmap;
begin
  BitmapSrc := TBitmap.Create;
  try
    BitmapMask := TBitmap.Create;
    try
      BitmapSrc.LoadFromFile('c:\src.bmp');
      BitmapMask.LoadFromFile('c:\mask.bmp');
      MaskBlt(Canvas.Handle, 0, 0, BitmapSrc.Width, BitmapSrc.Height,
        BitmapSrc.Canvas.Handle, 0, 0, BitmapMask.Handle, 0, 0, MakeROP4(PATCOPY xor PATINVERT, SRCCOPY));
    finally
      BitmapMask.Free;
    end;
  finally
    BitmapSrc.Free;
  end;
end;
</pre>
<p>&nbsp;<br>
&nbsp;<br>
<p class="author">Автор: Rouse_ </p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
