---
Title: Преобразование изображения в оттенки серого
Author: Николай Федоровских (Fenik), chook_nu@uraltc.ru
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Преобразование изображения в оттенки серого
===========================================

    // Используется функция преобразования изображения в оттенки серого
    // взятая из UBPFD - http://delphibase.endimus.com/
    // автор: Николай Федоровских - mailto: chook_nu@uraltc.ru
    procedure ModColors(Bitmap: TBitmap; Color: TColor);
      function GetR(const Color: TColor): Byte;
      //извлечение красного
      begin
        Result := Lo(Color);
      end;
      function GetG(const Color: TColor): Byte;
      //извлечение зелёного
      begin
        Result := Lo(Color shr 8);
      end;
      function GetB(const Color: TColor): Byte;
      //извлечение синего
      begin
        Result := Lo((Color shr 8) shr 8);
      end;
      function BLimit(B: Integer): Byte;
      begin
        if B < 0 then Result := 0
          else if B > 255 then Result := 255
            else Result := B;
      end;
    type TRGB = record
           B, G, R: Byte;
         end;
         pRGB = ^TRGB;
    var r1, g1, b1: Byte;
        x, y: Integer;
        Dest: pRGB;
        A: Double;
    begin
      Bitmap.PixelFormat := pf24Bit;
      r1 := Round(255 / 100 * GetR(Color));
      g1 := Round(255 / 100 * GetG(Color));
      b1 := Round(255 / 100 * GetB(Color));
      for y := 0 to Bitmap.Height - 1 do begin
        Dest := Bitmap.ScanLine[y];
        for x := 0 to Bitmap.Width - 1 do begin
          with Dest^ do begin
            A := (r + b + g) / 300;
            with Dest^ do begin
              R := BLimit(Round(r1 * A));
              G := BLimit(Round(g1 * A));
              B := BLimit(Round(b1 * A));
              // Небольшая поправка к оригинальной функции
              if (R=255) and (G=255) and (B=255) then begin
                R:= 216;
                G:= 212;
                B:= 240;
              end;
            end;
          end;
          Inc(Dest);
        end;
      end;
    end;

пример использования:

    ModColors(BitMap, RGB(150,150,150));

