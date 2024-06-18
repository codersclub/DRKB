---
Title: Как определить формат изображения, загруженного в TMemoryStream?
Author: Smike
Source: <https://forum.sources.ru>
Date: 01.01.2007
---


Как определить формат изображения, загруженного в TMemoryStream?
================================================================

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

Пользоваться можно так:

    case KindOfImage(MemoryStream.Memory) of
    ...

Для тех, кого смущает absolute:

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

