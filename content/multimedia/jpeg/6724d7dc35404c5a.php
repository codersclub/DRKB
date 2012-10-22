<h1>Открыть файл JPEG</h1>
<div class="date">01.01.2007</div>


<p>В комплект поставки Delphi входит модуль JPEG. Он позволяет работать с изображениями в формате JPEG. Эта программа открывает выбранный файл и выводит изображение на форму. </p>
<pre>
uses Jpeg;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  JpegIm: TJpegImage;
  bm: TBitMap;
begin
  if OpenDialog1.Execute = false then Exit;
  bm := TBitMap.Create;
  JpegIm := TJpegImage.Create;
  JpegIm.LoadFromFile(OpenDialog1.FileName);
 
  bm.Assign(JpegIm);
  Form1.Canvas.Draw(0, 0, bm);
  bm.Destroy;
  JpegIm.Destroy;
end;
</pre>


<p class="author">Автор: Даниил Карапетян (delphi4all@narod.ru)</p>
<p class="author">Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)</p>

