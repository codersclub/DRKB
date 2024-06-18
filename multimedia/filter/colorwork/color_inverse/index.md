---
Title: Инверсия всех цветов в bitmap
Author: Song
Date: 01.01.2007
---


Инверсия всех цветов в bitmap
=============================

Вариант 1:

Author: Song

Source: <https://forum.sources.ru>

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
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Image1.Picture.Bitmap := InvertBitmap(Image1.Picture.Bitmap);
    end;

------------------------------------------------------------------------

Вариант 2:

Author: Николай федоровских (Fenik), chook_nu@uraltc.ru

Date: 01.06.2002

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Инверсия всех цветов Bitmap
     
    Зависимости: Graphics
    Автор:       Fenik, chook_nu@uraltc.ru, Новоуральск
    Copyright:   Собственное написание (Николай федоровских)
    Дата:        1 июня 2002 г.
    ***************************************************** }
     
    procedure InvertBitmap(Bitmap: TBitmap);
    type
      TRGB = record
        B, G, R: Byte;
      end;
      pRGB = ^TRGB;
    var
      x, y: Integer;
      Dest: pRGB;
    begin
      Bitmap.PixelFormat := pf24Bit;
      for y := 0 to Bitmap.Height - 1 do
      begin
        Dest := Bitmap.ScanLine[y];
        for x := 0 to Bitmap.Width - 1 do
        begin
          with Dest^ do
          begin
            R := 255 - R;
            G := 255 - G;
            B := 255 - B;
          end;
          Inc(Dest);
        end;
      end;
    end;
