---
Title: Изменение гаммы рисунка
Date: 01.01.2007
---


Изменение гаммы рисунка
=======================

::: {.date}
01.01.2007
:::

    {
     **** UBPFD *********** by delphibase.endimus.com ****
    >> Изменение гаммы рисунка
     
    Зависимости: Graphics
    Автор:       Fenik, chook_nu@uraltc.ru, Новоуральск
    Copyright:   Автор Федоровских Николай
    Дата:        5 июня 2002 г.
    ***************************************************** }
     
    procedure Gamma(Bitmap: TBitmap; L: Double);
    {0.0 < L < 7.0}
      function Power(Base, Exponent: Extended): Extended;
      begin
        Result := Exp(Exponent * Ln(Base));
      end;
    type
      TRGB = record
        B, G, R: Byte;
      end;
      pRGB = ^TRGB;
    var
      Dest: pRGB;
      X, Y: Word;
      GT: array[0..255] of Byte;
    begin
      Bitmap.PixelFormat := pf24Bit;
      GT[0] := 0;
      if L = 0 then
        L := 0.01;
      for X := 1 to 255 do
        GT[X] := Round(255 * Power(X / 255, 1 / L));
      for Y := 0 to Bitmap.Height - 1 do
      begin
        Dest := Bitmap.ScanLine[y];
        for X := 0 to Bitmap.Width - 1 do
        begin
          with Dest^ do
          begin
            R := GT[R];
            G := GT[G];
            B := GT[B];
          end;
          Inc(Dest);
        end;
      end;
    end;
