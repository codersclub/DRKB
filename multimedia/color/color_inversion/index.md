---
Title: Инверсия цветов
Author: Song
Date: 01.01.2007
---


Инверсия цветов
===============

::: {.date}
01.01.2007
:::

    function InvertBitmap(Bmp: TBitmap): TBitmap;
    var
      x, y: integer;
      ByteArray: PByteArray;
    begin
      Bmp.PixelFormat := pf24Bit;
      for y := 0 to Bmp.Height - 1 do
      begin
        ByteArray := Bmp.ScanLine[y];
        for x := 0 to Bmp.Width * 3 - 1 do
        begin
          ByteArray[x] := 255 - ByteArray[x];
        end;
      end;
      Result := Bmp;
    end;




ПРИМЕР ИСПОЛЬЗОВАНИЯ:

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Image1.Picture.Bitmap := InvertBitmap(Image1.Picture.Bitmap);
    end;

Взято из <https://forum.sources.ru>

Автор: Song
