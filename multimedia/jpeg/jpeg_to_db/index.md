---
Title: Как показать на экpане и сохранить в базе картинку формата JPEG
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Как показать на экpане и сохранить в базе картинку формата JPEG
===============================================================

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

