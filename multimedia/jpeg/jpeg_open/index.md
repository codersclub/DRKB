---
Title: Открыть файл JPEG
Author: Даниил Карапетян (delphi4all@narod.ru)
Date: 01.01.2007
---


Открыть файл JPEG
=================

В комплект поставки Delphi входит модуль JPEG. Он позволяет работать с
изображениями в формате JPEG. Эта программа открывает выбранный файл и
выводит изображение на форму.

    uses Jpeg;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      JpegIm: TJpegImage;
      bm: TBitMap;
    begin
      if OpenDialog1.Execute = false then Exit;
      bm := TBitMap.Create;
      JpegIm := TJpegImage.Create;
      JpegIm.LoadFromFile(OpenDialog1.FileName);
     
      bm.Assign(JpegIm);
      Form1.Canvas.Draw(0, 0, bm);
      bm.Destroy;
      JpegIm.Destroy;
    end;


Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)
