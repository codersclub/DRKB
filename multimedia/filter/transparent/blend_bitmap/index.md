---
Title: Установка уровня прозрачности изображения
Author: Федоровских Николай (Fenik), chook_nu@uraltc.ru
Date: 03.09.2002
---


Установка уровня прозрачности изображения
=========================================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Установка уровня прозрачности изображения
     
    Зависимости: Windows, Graphics, Math
    Автор:       Fenik, chook_nu@uraltc.ru, Новоуральск
    Copyright:   Автор Федоровских Николай
    Дата:        3 сентября 2002 г.
    ***************************************************** }
     
    procedure BlendBitmap(Src, Dest: TBitmap; Amount: Byte; Left, Top:
      Integer; BackColor: TColor; Transparent: Boolean);
      function CandC(C1, C2: TRGBTriple): Boolean;
      begin {Сравнение двух цветов}
        Result := (C1.rgbtBlue = C2.rgbtBlue) and
          (C1.rgbtGreen = C2.rgbtGreen) and
          (C1.rgbtRed = C2.rgbtRed);
      end;
      {Процедура установления уровня прозрачности
       изображения Dest, расположенного над изображением Src.
       Amount - уровень прозрачности в промежутке [0..255].
       Left, Top - левый верхний угол Dest.
       BackColor - цвет, который не нужно изменять,
       если Transparent = True.}
    var
      x, y, y1, y2, x1, x2: Integer;
      ps, pd: pRGBTriple;
      rgb: TRGBTriple;
      A1, A2: Double;
    begin
      Src.PixelFormat := pf24Bit;
      Dest.PixelFormat := pf24Bit;
      A1 := Amount / 255;
      A2 := 1 - A1;
      {Изменяется только та часть изображения,
       которая расположена над исходным}
      y1 := Max(0, Top);
      x1 := Max(0, Left);
      x2 := Min(Src.Width - 1, Left + Dest.Width - 1);
      y2 := Min(Src.Height - 1, Top + Dest.Height - 1);
      rgb.rgbtRed := Lo(BackColor);
      rgb.rgbtGreen := Lo(BackColor shr 8);
      rgb.rgbtBlue := Lo((BackColor shr 8) shr 8);
      for y := y1 to y2 do
      begin
        ps := Src.ScanLine[y];
        pd := Dest.ScanLine[y - Top];
        Inc(ps, x1);
        if Left < 0 then
          Inc(pd, Abs(Left));
        for x := x1 to x2 do
        begin
          if not (Transparent and CandC(pd^, rgb)) then
            with pd^ do
            begin
              rgbtBlue := Round(A1 * ps^.rgbtBlue + A2 * rgbtBlue);
              rgbtGreen := Round(A1 * ps^.rgbtGreen + A2 * rgbtGreen);
              rgbtRed := Round(A1 * ps^.rgbtRed + A2 * rgbtRed);
            end;
          Inc(pd);
          Inc(ps);
        end;
      end;
    end;

Пример использования:

    var
      Bmp: TBitmap;
    begin
      if not FileExists('C:\Blend.bmp') then
        Exit;
      Bmp := TBitmap.Create;
      try
        Bmp.LoadFromFile('C:\Blend.bmp');
        BlendBitmap(FBitmap, Bmp, 127, 10, 10, clWhite, True);
        Bmp.TransparentColor := clWhite;
        Bmp.Transparent := True;
        FBitmap.Canvas.Draw(10, 10, Bmp);
      finally
        Bmp.Free;
      end;
      Paint;
    end;
