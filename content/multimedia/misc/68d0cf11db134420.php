<h1>Как определить формат изображения, загруженного в TMemoryStream?</h1>
<div class="date">01.01.2007</div>


<pre>
type
  TImageType = (NoImage, Bmp, Gif, Gif89, Png, Jpg);
 
function KindOfImage(Start: Pointer): TImageType;
type
  ByteArray = array[0..10] of Byte;
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
<p>&nbsp;<br>
&nbsp;<br>
<p>Пользоваться можно так:</p>
<pre>
case KindOfImage(MemoryStream.Memory) of
...
</pre>
<p>Для тех, кого смущает absolute:</p>
<pre>
type
  TImageType = (NoImage, Bmp, Gif, Gif89, Png, Jpg);
 
function KindOfImage(Start: Pointer): TImageType;
begin
  if LongWord(Start^) = $38464947 then
  begin
    if (PChar(Start) + 4)^ = '9' then Result := Gif89
    else Result := Gif;
  end
  else if Word(Start^) = $4D42 then Result := Bmp
  else if LongWord(Start^) = $474E5089 then Result := Png
  else if Word(Start^) = $D8FF then Result := Jpg
  else Result := NoImage;
end;
</pre>
<div class="author">Автор: Smike</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
&nbsp;<br>

