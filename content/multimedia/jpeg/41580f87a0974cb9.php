<h1>Как показать на экpане и сохранить в базе картинку формата JPEG</h1>
<div class="date">01.01.2007</div>


<pre>
if Picture.Graphic is TJPegImage then
begin
  bs:=TBlobStream.Create(TBlobField(Field),bmWrite);
  Picture.Graphic.SaveToStream(bs);
  bs.Free;
end
else
if Picture.Graphic is TBitmap then
begin
  Jpg:=TJPegImage.Create;
  Jpg.CompressionQuality:=...;
  Jpg.PixelFormat:=...;
  Jpg.Assign(Picture.Graphic);
  Jpg.JPEGNeeded;
  bs:=TBlobStream.Create(TBlobField(Field),bmWrite);
  Jpg.SaveToStream(bs);
  bs.Free;
  Jpg.Free;
end
else
  Field.Clear;
 
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
