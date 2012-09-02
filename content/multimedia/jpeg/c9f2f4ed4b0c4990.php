<h1>Как загрузить и отмасштабировать JPEGImage в TImage</h1>
<div class="date">01.01.2007</div>


<pre>
try
  Image1.Picture.Graphic := nil;
  Image1.Picture.LoadFromFile(jpegfile);
except
  on EInvalidGraphic do
    Image1.Picture.Graphic := nil;
end;
if Image1.Picture.Graphic is TJPEGImage then
begin
  TJPEGImage(Image1.Picture.Graphic).Scale := Self.Scale;
  TJPEGImage(Image1.Picture.Graphic).Performance := jpBestSpeed;
end;
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

