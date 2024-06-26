---
Title: Наклон изображения
Date: 02.06.2002
Author: Федоровских Николай (Fenik), chook_nu@uraltc.ru
---


Наклон изображения
==================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Наклон изображения по вертикали и горизонтали
     
    Зависимости: Classes, Graphics
    Автор:       Fenik, chook_nu@uraltc.ru, Новоуральск
    Copyright:   Автор Федоровских Николай
    Дата:        2 июня 2002 г.
    ***************************************************** }
     
    procedure InclinationBitmap(Bitmap: TBitmap; Hor,
      Ver: Double; BackColor: TColor);
     
      function Tan(X: Extended): Extended;
        // Tan := Sin(X) / Cos(X)
      asm
            FLD X
            FPTAN
            FSTP ST(0) // FPTAN pushes 1.0 after result
            FWAIT
      end;
     
    type
      TRGB = record
        B, G, R: Byte;
      end;
      pRGB = ^TRGB;
    var
      x, y, WW, HH, alpha: Integer;
      OldPx, NewPx: PRGB;
      T: Double;
      Bmp: TBitmap;
    begin
      Bitmap.PixelFormat := pf24Bit;
      Bmp := TBitmap.Create;
      try
        Bmp.Assign(Bitmap);
        WW := Bitmap.Width;
        HH := Bitmap.Height;
        if Hor <> 0.0 then
        begin // По горизонтали
          T := Tan(Hor * (Pi / 180));
          Inc(WW, Abs(Round(HH * T)));
          Bitmap.Width := WW;
          Bitmap.Canvas.Brush.Color := BackColor;
          Bitmap.Canvas.FillRect(Rect(0, 0, Bitmap.Width, Bitmap.Height));
          for y := 0 to HH - 1 do
          begin
            if T > 0 then
              alpha := Round((HH - y) * T)
            else
              alpha := -Round(y * T);
            OldPx := Bmp.ScanLine[y];
            NewPx := Bitmap.ScanLine[y];
            Inc(NewPx, Alpha);
            for x := 0 to Bmp.Width - 1 do
            begin
              NewPx^ := OldPx^;
              Inc(NewPx);
              Inc(OldPx);
            end;
          end;
          Bmp.Assign(Bitmap);
        end;
        if Ver <> 0.0 then
        begin // По вертикали
          T := Tan(Ver * (Pi / 180));
          Bitmap.Height := HH + Abs(Round(WW * T));
          Bitmap.Canvas.Brush.Color := BackColor;
          Bitmap.Canvas.FillRect(Rect(0, 0, Bitmap.Width, Bitmap.Height));
          for x := 0 to WW - 1 do
          begin
            if T > 0 then
              alpha := Round((WW - x) * T)
            else
              alpha := -Round(x * T);
            for y := 0 to Bmp.Height - 1 do
            begin
              NewPx := Bitmap.ScanLine[y + alpha];
              OldPx := Bmp.ScanLine[y];
              Inc(OldPx, x);
              Inc(NewPx, x);
              NewPx^ := OldPx^;
            end;
          end;
        end;
      finally
        Bmp.Free;
      end;
    end;

Пример использования: 
     
    InclinationBitmap(FBitmap, 7.151, -5.8, clWhite); 
     
