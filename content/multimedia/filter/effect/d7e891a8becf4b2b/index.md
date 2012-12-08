---
Title: Эффект блоков
Date: 01.01.2007
---


Эффект блоков
=============

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Эффект 'Блоки'
     
    Зависимости: Windows, Classes, Graphics
    Автор:       Fenik, chook_nu@uraltc.ru, Новоуральск
    Copyright:   Собственное написание (Николай федоровских)
    Дата:        1 июня 2002 г.
    ***************************************************** }
     
    procedure Blocks(Bitmap: TBitmap; Hor, Ver, MaxOffset:
      Integer; BackColor: TColor);
    {вырезаем прямоугольники со сторонами Hor Ver
    и копируем их в радиусе MaxOffset}
     
      function RandomInRadius(Num, Radius: Integer): Integer;
      begin
        if Random(2) = 0 then
          Result := Num + Random(Radius)
        else
          Result := Num - Random(Radius);
      end;
     
    var
      x, y, xd, yd: Integer;
      Bmp: TBitmap;
    begin
      Bmp := TBitmap.Create;
      try
        Bmp.Assign(Bitmap);
        Bitmap.Canvas.Brush.Color := BackColor;
        Bitmap.Canvas.FillRect(Rect(0, 0, Bitmap.Width, Bitmap.Height));
        xd := (Bitmap.Width - 1) div Hor;
        yd := (Bitmap.Height - 1) div Ver;
        Randomize;
        for x := 0 to xd do
          for y := 0 to yd do
            BitBlt(Bitmap.Canvas.Handle,
              RandomInRadius(Hor * x, MaxOffset),
              RandomInRadius(Ver * y, MaxOffset),
              Hor, Ver, Bmp.Canvas.Handle, Hor * x, Ver * y, SRCCOPY);
      finally
        Bmp.Free;
      end;
    end;
    Пример использования: 
     
    Blocks(FBitmap, FBitmap.Width div 10, FBitmap.Height div 10, 4, clWhite); 
     
