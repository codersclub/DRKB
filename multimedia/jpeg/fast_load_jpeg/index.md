---
Title: Как подгружать JPG-картинки, но чтобы они быстро отображались
Date: 01.01.2007
---


Как подгружать JPG-картинки, но чтобы они быстро отображались
=============================================================

::: {.date}
01.01.2007
:::

    procedure TForm1.FormCreate(Sender: TObject);
    begin
      if Image1.Picture.Graphic is TJPEGImage then
      begin
        TJPEGImage(Image1.Picture.Graphic).DIBNeeded;
      end;
    end;

Данный код заставляет явно и сразу декодировать jpeg, вместо того, чтобы
делать это при отображении картинки

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
