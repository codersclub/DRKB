---
Title: Сравнение картинок
Date: 01.01.2007
---


Сравнение картинок
==================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject);
     var
       b1, b2: TBitmap;
       c1, c2: PByte;
       x, y, i,
       different: Integer; // Counter for different pixels 
    begin
       b1 := Image1.Picture.Bitmap;
       b2 := Image2.Picture.Bitmap;
       Assert(b1.PixelFormat = b2.PixelFormat); // they have to be equal 
      different := 0;
       for y := 0 to b1.Height - 1 do
       begin
         c1 := b1.Scanline[y];
         c2 := b2.Scanline[y];
         for x := 0 to b1.Width - 1 do
           for i := 0 to BytesPerPixel - 1 do // 1, to 4, dep. on pixelformat 
          begin
             Inc(different, Integer(c1^ <> c2^));
             Inc(c1);
             Inc(c2);
           end;
       end;
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
