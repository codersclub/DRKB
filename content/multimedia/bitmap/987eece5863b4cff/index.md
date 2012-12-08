---
Title: Порог между двумя цветами на bitmap
Date: 01.01.2007
---


Порог между двумя цветами на bitmap
===================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Порог между двумя цветами на Bitmap
     
    Bitmap преобразуется в двухцветное изображение.
     
    Зависимости: Graphics
    Автор:       Fenik, chook_nu@uraltc.ru, Новоуральск
    Copyright:   Собственное написание (Николай федоровских)
    Дата:        1 июня 2002 г.
    ***************************************************** }
     
    procedure Threshold(Bitmap: TBitmap; Value: Byte; Color1, Color2: TColor);
    type
      TRGB = record
        B, G, R: Byte;
      end;
      pRGB = ^TRGB;
     
      function ColorToRGB(Color: TColor): TRGB;
      begin
        with Result do
        begin
          R := Lo(Color);
          G := Lo(Color shr 8);
          B := Lo((Color shr 8) shr 8);
        end;
      end;
     
    var
      x, y: Word;
      C1, C2: TRGB;
      Dest: pRGB;
    begin
      Bitmap.PixelFormat := pf24Bit;
      C1 := ColorToRGB(Color1);
      C2 := ColorToRGB(Color2);
      for y := 0 to Bitmap.Height - 1 do
      begin
        Dest := Bitmap.ScanLine[y];
        for x := 0 to Bitmap.Width - 1 do
        begin
          //если среднеарифметическое R, G и B больше Value,
          //то точку (x, y) закрашиваем цветом Color1,
          //иначе - цветом Color2
          if (Dest^.r + Dest^.g + Dest^.b) / 3 > Value then
            Dest^ := C1
          else
            Dest^ := C2;
          Inc(Dest);
        end;
      end;
    end;

Пример использования:

    Threshold(FBitmap, 127, clWhite, clBlack); 
