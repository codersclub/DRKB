---
Title: Рисование звезд и многоугольников
Date: 01.01.2007
---


Рисование звезд и многоугольников
=================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Рисование звёзд и многоугольников
     
    Зависимости: Windows, Graphics
    Автор:       Fenik, chook_nu@uraltc.ru, Новоуральск
    Copyright:   Автор Федоровских Николай
    Дата:        3 июня 2002 г.
    ***************************************************** }
     
    procedure DrawStar(Canvas: TCanvas; Center, Pos: TPoint;
      R2inPercent, Ends: Byte; DrawCircle: Boolean);
    {
     Рисование звёзд и многоугольников
     
     Center - центр фигуры;
     Pos - точка, лежащая на внешнем радиусе;
     R2inPercent - сколько процентов от внешнего радиуса составляет внутренний;
     Ends - число концов (внешних углов) фигуры;
     DrawCircle - описывать или нет возле фигуры окружность;
     
     R2inPercent рекомендую брать в промежутке [0; 100].
     Если R2inPercent = 100, то рисуется правильный многоугольник,
     число углов которого равно Ends.
     Все точки лежат на двух окружностях, чередуясь.
    }
     
      function Max(A, B: Integer): Integer;
      begin
        if A > B then
          Result := A
        else
          Result := B;
      end;
     
      function ArcTan2(Y, X: Extended): Extended;
      asm
        FLD Y
        FLD X
        FPATAN
        FWAIT
      end;
     
    const
      Rad = Pi / 180;
    var
      R, r2, rd, len: Word;
      i: Integer;
      MemBS: TBrushStyle;
      p: array of TPoint;
      MemC: TColor;
      a, ad: Double;
    begin
      if Ends < 2 then
        Exit;
      {начальный угол:}
      a := ArcTan2(Center.y - Pos.y, Pos.x - Center.x) * (180 / Pi);
      R := Max(Abs(Center.x - Pos.x), Abs(Center.y - Pos.y));
      r2 := Round(R / 100 * R2inPercent); {внутренний радиус}
      if R2inPercent <> 100 then
        len := Ends * 2
      else
        len := Ends;
      SetLength(p, len); {устанавливаем длину массива точек}
      ad := 360 / len; {угол между рядом стоящими точками}
      for i := 0 to len - 1 do
      begin
        {если i нечетный, то радиус внутренний, иначе - внешний}
        if Odd(i) then
          rd := r2
        else
          rd := R;
        p[i].x := Trunc(Cos(a * Rad) * rd) + Center.x;
        p[i].y := Trunc(Sin(a * Rad) * rd) + Center.y;
        a := a + ad; {увеличиваем угол}
      end;
      {рисуем многоугольник}
      Canvas.Polygon(p);
      if DrawCircle then
      begin
        {Рисуем окружность}
        MemC := Canvas.Brush.Color;
        MemBS := Canvas.Brush.Style;
        Canvas.Brush.Style := bsClear;
        Canvas.Ellipse(Center.x - R, Center.y - R, Center.x + R, Center.y + R);
        Canvas.Brush.Color := MemC;
        Canvas.Brush.Style := MemBS;
      end;
    end;

Пример использования:

    DrawStar(FBitmap.Canvas, Point(FBitmap.Width div 2, FBitmap.Height div 2),
      Point(FBitmap.Width div 2, 0), 20, 12, False); 
