---
Title: Как подгружать JPG-картинки, но чтобы они быстро отображались
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Как подгружать JPG-картинки, но чтобы они быстро отображались
=============================================================

    procedure TForm1.FormCreate(Sender: TObject);
    begin
      if Image1.Picture.Graphic is TJPEGImage then
      begin
        TJPEGImage(Image1.Picture.Graphic).DIBNeeded;
      end;
    end;

Данный код заставляет явно и сразу декодировать jpeg, вместо того, чтобы
делать это при отображении картинки


