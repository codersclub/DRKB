---
Title: Вывод изображения по маске, используется MaskBlt
Author: Rouse\_
Date: 01.01.2007
---


Вывод изображения по маске, используется MaskBlt
================================================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject);
    var
      BitmapSrc, BitmapMask: TBitmap;
    begin
      BitmapSrc := TBitmap.Create;
      try
        BitmapMask := TBitmap.Create;
        try
          BitmapSrc.LoadFromFile('c:\src.bmp');
          BitmapMask.LoadFromFile('c:\mask.bmp');
          MaskBlt(Canvas.Handle, 0, 0, BitmapSrc.Width, BitmapSrc.Height,
            BitmapSrc.Canvas.Handle, 0, 0, BitmapMask.Handle, 0, 0, MakeROP4(PATCOPY xor PATINVERT, SRCCOPY));
        finally
          BitmapMask.Free;
        end;
      finally
        BitmapSrc.Free;
      end;
    end;

 \
 \

Автор: Rouse\_

Взято из <https://forum.sources.ru>
