---
Title: Эффект мозаики (пикселизация)
Author: Николай федоровских (Fenik), chook_nu@uraltc.ru
Date: 01.06.2002
---


Эффект мозаики (пикселизация)
==============

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Эффект 'Мозаика' (пикселизация)
     
    Зависимости: Windows, Classes, Graphics
    Автор:       Fenik, chook_nu@uraltc.ru, Новоуральск
    Copyright:   Собственное написание (Николай федоровских)
    Дата:        1 июня 2002 г.
    ***************************************************** }
     
    procedure PixelsEffect(Bitmap: TBitmap; Hor, Ver: Word);
    {функция разбивает изображение на прямоугольники
    (ширина - Hor; высота - Ver)
    И закрашивает эти прямоугольники средним цветом,
    используя среднеарифметическое составляющих}
     
      function Min(A, B: Integer): Integer;
      begin
        if A < B then
          Result := A
        else
          Result := B;
      end;
     
    type
      TRGB = record
        B, G, R: Byte;
      end;
      pRGB = ^TRGB;
    var
      i, j, x, y, xd, yd,
        rr, gg, bb, h, hx, hy: Integer;
      Dest: pRGB;
    begin
      Bitmap.PixelFormat := pf24Bit;
      if (Hor = 1) and (Ver = 1) then
        Exit;
      xd := (Bitmap.Width - 1) div Hor;
      yd := (Bitmap.Height - 1) div Ver;
      for i := 0 to xd do
        for j := 0 to yd do
        begin
          h := 0;
          rr := 0;
          gg := 0;
          bb := 0;
          hx := Min(Hor * (i + 1), Bitmap.Width - 1);
          hy := Min(Ver * (j + 1), Bitmap.Height - 1);
          for y := j * Ver to hy do
          begin
            Dest := Bitmap.ScanLine[y];
            Inc(Dest, i * Hor);
            for x := i * Hor to hx do
            begin
              Inc(rr, Dest^.R);
              Inc(gg, Dest^.G);
              Inc(bb, Dest^.B);
              Inc(h);
              Inc(Dest);
            end;
          end;
          Bitmap.Canvas.Brush.Color := RGB(rr div h, gg div h, bb div h);
          Bitmap.Canvas.FillRect(Rect(i * Hor, j * Ver, hx + 1, hy + 1));
        end;
    end;

Пример использования: 
     
    PixelsEffect(FBitmap, 8, 8); 

