<h1>Сохранить изображение в формате JPEG</h1>
<div class="date">01.01.2007</div>


<p>В комплект поставки Delphi входит модуль JPEG. Он позволяет работать с изображениями в формате JPEG. Эта программа сохраняет изображение экрана в файле C:\Screen.jpg. </p>
<pre>
uses Jpeg;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  JpegIm: TJpegImage;
  bm: TBitMap;
begin
  bm := TBitMap.Create;
  bm.Width := Screen.Width;
  bm.Height := Screen.Height;
  BitBlt(bm.Canvas.Handle, 0, 0,
    bm.Width, bm.Height,
    GetDC(0), 0, 0, SRCCOPY);
 
  JpegIm := TJpegImage.Create;
  JpegIm.Assign(bm);
  JpegIm.CompressionQuality := 20;
  JpegIm.Compress;
  JpegIm.SaveToFile('C:\Screen.jpg');
  bm.Destroy;
  JpegIm.Destroy;
end;
</pre>

<p class="author">Автор: Даниил Карапетян (delphi4all@narod.ru)</p>
<p class="author">Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)</p>
