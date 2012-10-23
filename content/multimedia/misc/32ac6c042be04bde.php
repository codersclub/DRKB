<h1>Определить формат изображения, загруженного в TMemoryStream</h1>
<div class="date">01.01.2007</div>


<pre>
type
  ImageType = (NoImage, Bmp, Gif, Gif89, Png, Jpg);
 
function KindOfImage(Start: Pointer): ImageType;
type
  ByteArray = array[0..10] of byte;
var
  PB: ^ByteArray absolute Start;
  PW: ^Word absolute Start;
  PL: ^DWord absolute Start;
begin
if PL^ = $38464947 then
  begin
  if PB^[4] = Ord('9') then Result := Gif89
  else Result := Gif;
  end
else if PW^ = $4D42 then Result := Bmp
else if PL^ = $474E5089 then Result := Png
else if PW^ = $D8FF then Result := Jpg
else Result := NoImage;
end;
</pre>

<p>Пользоваться можно так:</p>
<p>case KindOfImage(MemoryStream.Memory) of</p>
<p>...</p>

<div class="author">Автор: s-mike</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
