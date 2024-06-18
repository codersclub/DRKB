---
Title: Как копировать образ экрана в файл?
Author: Vit
Source: Vingrad.ru <https://forum.vingrad.ru>
Date: 01.01.2007
---


Как копировать образ экрана в файл?
===================================

На форме у меня стоит TImage (его можно сделать невидимым)

    uses JPEG;
     
    ...
    var i: TJPEGImage;
    begin
      try
        i := TJPEGImage.create;
        try
          i.CompressionQuality := 100;
          image.Width := screen.width;
          image.height := screen.height;
          DWH := GetDesktopWindow;
          GetWindowRect(DWH, DRect);
          DescDC := GetDeviceContext(DWH);
          Canv.Handle := DescDC;
          DRect.Left := 0;
          DRect.Top := 0;
          DRect.Right := screen.Width;
          DRect.Bottom := screen.Height;
          Image.Canvas.CopyRect(DRect, Canv, DRect);
          i.assign(Image.Picture.Bitmap);
          I.SaveToFile('M:\MyFile.jpg');
        finally
          i.free;
        end;
      except
      end;

Типы использованных переменных:

    Dwh : HWND;
    DRect: TRect;
    DescDC : HDC;
    Canv : TCanvas;

