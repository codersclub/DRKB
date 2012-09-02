<h1>Как копировать образ экрана в файл?</h1>
<div class="date">01.01.2007</div>


<p>На форме у меня стоит TImage (его можно сделать невидимым)</p>
<pre>
uses JPEG;
 

 
...
var i: TJPEGImage;
begin
  try
    i := TJPEGImage.create;
    try
      i.CompressionQuality := 100;
      image.Width := screen.width;
      image.height := screen.height;
      DWH := GetDesktopWindow;
      GetWindowRect(DWH, DRect);
      DescDC := GetDeviceContext(DWH);
      Canv.Handle := DescDC;
      DRect.Left := 0;
      DRect.Top := 0;
      DRect.Right := screen.Width;
      DRect.Bottom := screen.Height;
      Image.Canvas.CopyRect(DRect, Canv, DRect);
      i.assign(Image.Picture.Bitmap);
      I.SaveToFile('M:\MyFile.jpg');
    finally
      i.free;
    end;
  except
  end;
</pre>
<p>Типы использованных переменных:</p>
<p>Dwh : HWND;</p>
<p>DRect: TRect;</p>
<p>DescDC : HDC;</p>
<p>Canv : TCanvas;</p>
<p class="author">Автор: Vit</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

