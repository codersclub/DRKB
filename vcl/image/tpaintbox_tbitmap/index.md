---
Title: Как сохранить содержимое TPaintBox в TBitmap
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как сохранить содержимое TPaintBox в TBitmap
============================================

    var
      Bitmap: TBitmap;
      Source: TRect;
      Dest: TRect;
    begin
      Bitmap := TBitmap.Create;
      try
        with Bitmap do
        begin
          Width := MyPaintBox.Width;
          Height := MyPaintBox.Height;
          Dest := Rect(0, 0, Width, Height);
        end;
        with MyPaintBox do
          Source := Rect(0, 0, Width, Height);
        Bitmap.Canvas.CopyRect(Dest, MyPaintBox.Canvas, Source);
        Bitmap.SaveToFile('MYFILE.BMP');
      finally
        Bitmap.Free;
      end;
    end;

