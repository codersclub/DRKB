<h1>Как подгружать JPG-картинки, но чтобы они быстро отображались</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.FormCreate(Sender: TObject);
begin
  if Image1.Picture.Graphic is TJPEGImage then
  begin
    TJPEGImage(Image1.Picture.Graphic).DIBNeeded;
  end;
end;
</pre>
<p>Данный код заставляет явно и сразу декодировать jpeg, вместо того, чтобы делать это при отображении картинки</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
