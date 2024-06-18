---
Title: Эффект волн (синусоидальные, вид сбоку)
Author: Николай федоровских (Fenik), chook_nu@uraltc.ru
Date: 01.06.2002
---


Эффект волн (синусоидальные, вид сбоку)
=======================================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Эффект 'Волны' (синусоидальные, вид сбоку)
     
    Зависимости: Classes, Graphics
    Автор:       Fenik, chook_nu@uraltc.ru, Новоуральск
    Copyright:   Собственное написание (Николай федоровских)
    Дата:        1 июня 2002 г.
    ***************************************************** }
     
    procedure WaveSin(Bitmap: TBitmap; Frequency, Length:
      Integer; Hor: Boolean; BackColor: TColor);
     
      function Min(A, B: Integer): Integer;
      begin
        if A < B then
          Result := A
        else
          Result := B;
      end;
     
      function Max(A, B: Integer): Integer;
      begin
        if A > B then
          Result := A
        else
          Result := B;
      end;
     
    const
      Rad = Pi / 180;
    type
      TRGB = record
        B, G, R: Byte;
      end;
      pRGB = ^TRGB;
    var
      x, y, f: Integer;
      Dest, Src: pRGB;
      Bmp: TBitmap;
    begin
      Bitmap.PixelFormat := pf24Bit;
      Bmp := TBitmap.create;
      try
        Bmp.Assign(Bitmap);
        Bitmap.Canvas.Brush.Color := BackColor;
        Bitmap.Canvas.FillRect(Rect(0, 0, Bitmap.Width, Bitmap.Height));
        for y := 0 to Bmp.Height - 1 do
        begin
          Src := Bmp.ScanLine[y];
          for x := 0 to Bmp.Width - 1 do
          begin
            if Hor then
            begin
              f := Min(Max(Round(Sin(x * Rad * Length) * Frequency) + y, 0),
                Bitmap.Height - 1);
              Dest := Bitmap.ScanLine[f];
              Inc(Dest, x);
            end
            else
            begin
              f := Min(Max(Round(Sin(y * Rad * Length) * Frequency) + x, 0),
                Bitmap.Width - 1);
              Dest := Bitmap.ScanLine[y];
              Inc(Dest, f);
            end;
            Dest^ := Src^;
            Inc(Src);
          end;
        end;
      finally
        Bmp.free;
      end;
    end;

Пример использования: 
     
    WaveSin(FBitmap, FBitmap.Width div 50, FBitmap.Width div 40, True, clWhite); 
     
