---
Title: Как загрузить и отмасштабировать JPEGImage в TImage
Date: 01.01.2007
---


Как загрузить и отмасштабировать JPEGImage в TImage
===================================================

::: {.date}
01.01.2007
:::

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

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
