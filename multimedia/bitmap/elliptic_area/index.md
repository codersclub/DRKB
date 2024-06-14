---
Title: Вырезание эллиптической области на Bitmap
author: Николай федоровских (Fenik), chook_nu@uraltc.ru
Date: 01.06.2002
---


Вырезание эллиптической области на Bitmap
=========================================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Вырезание эллиптической области на Bitmap
     
    Овальная рамка для изображения.
     
    Зависимости: Classes, Graphics
    Автор:       Fenik, chook_nu@uraltc.ru, Новоуральск
    Copyright:   Собственное написание (Николай федоровских)
    Дата:        1 июня 2002 г.
    ***************************************************** }
     
    procedure EllipticBitmap(Bitmap: TBitmap; BackColor: TColor);
    type
      TRGB = record
        B, G, R: Byte;
      end;
      pRGB = ^TRGB;
    var
      C: TRGB;
      x, y: Integer;
      Dest, Src: pRGB;
      Bmp: TBitmap;
    begin
      Bitmap.PixelFormat := pf24Bit;
      C.R := Lo(BackColor);
      C.G := Lo(BackColor shr 8);
      C.B := Lo((BackColor shr 8) shr 8);
      //создаём дополнительный Bitmap
      Bmp := TBitmap.Create;
      try
        Bmp.Width := Bitmap.Width;
        Bmp.Height := Bitmap.Height;
        Bmp.PixelFormat := Bitmap.PixelFormat;
        //рисуем на созданном Bitmap чёрный эллипс на белом фоне
        with Bmp.Canvas do
        begin
          Brush.Style := bsSolid;
          Brush.Color := clWhite;
          FillRect(Rect(0, 0, Bmp.Width, Bmp.Height));
          Brush.Color := clBlack;
          Pen.Style := psClear;
          Ellipse(Rect(0, 0, Bmp.Width, Bmp.Height));
        end;
        for y := 0 to Bitmap.Height - 1 do
        begin
          Src := Bmp.ScanLine[y];
          Dest := Bitmap.ScanLine[y];
          for x := 0 to Bitmap.Width - 1 do
          begin
            //если точка (x, y) на созданном Bitmap белая,
            //то точку (x, y) на исходном Bitmap закрашиваем BackColor
            if Src^.r = 255 then
              Dest^ := C;
            Inc(Dest);
            Inc(Src);
          end;
        end;
      finally
        Bmp.Free;
      end;
    end;

Пример использования: 

    EllipticBitmap(FBitmap, clWhite); 
