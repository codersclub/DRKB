---
Title: Сохранить изображение в формате JPEG
Author: Даниил Карапетян (delphi4all\@narod.ru)
Date: 01.01.2007
---


Сохранить изображение в формате JPEG
====================================

::: {.date}
01.01.2007
:::

В комплект поставки Delphi входит модуль JPEG. Он позволяет работать с
изображениями в формате JPEG. Эта программа сохраняет изображение экрана
в файле C:\\Screen.jpg.

    uses Jpeg;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      JpegIm: TJpegImage;
      bm: TBitMap;
    begin
      bm := TBitMap.Create;
      bm.Width := Screen.Width;
      bm.Height := Screen.Height;
      BitBlt(bm.Canvas.Handle, 0, 0,
        bm.Width, bm.Height,
        GetDC(0), 0, 0, SRCCOPY);
     
      JpegIm := TJpegImage.Create;
      JpegIm.Assign(bm);
      JpegIm.CompressionQuality := 20;
      JpegIm.Compress;
      JpegIm.SaveToFile('C:\Screen.jpg');
      bm.Destroy;
      JpegIm.Destroy;
    end;

Автор: Даниил Карапетян (delphi4all\@narod.ru)

Автор справки: Алексей Денисов (aleksey\@sch103.krasnoyarsk.su)
