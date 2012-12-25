---
Title: Убрать зазубринки при рисовании линий
Date: 01.01.2007
---


Убрать зазубринки при рисовании линий
=====================================

::: {.date}
01.01.2007
:::

При рисовании линии, особенно под маленьким углом, хорошо различимы
отдельные точки. Для устранения этого недостатка я использую уменьшение
изображения, как в предыдущем совете.

    procedure TForm1.Button1Click(Sender: TObject);
    var
      x, y: integer;
      i, j: integer;
      r, g, b: integer;
    begin
      Form1.Canvas.Pen.Width := 10;
      Form1.Canvas.MoveTo(10, 10);
      Form1.Canvas.LineTo(90, 20);
      for y := 0 to 10 do
      begin
        for x := 0 to 25 do
        begin
          r := 0;
          for i := 0 to 3 do
            for j := 0 to 3 do
              r := r + GetRValue(Form1.Canvas.Pixels[4*x+i, 4*y+j]);
          r := round(r / 16);
          g := 0;
          for i := 0 to 3 do
            for j := 0 to 3 do
              g := g + GetGValue(Form1.Canvas.Pixels[4*x+i, 4*y+j]);
          g := round(g / 16);
          b := 0;
          for i := 0 to 3 do
            for j := 0 to 3 do
              b := b + GetBValue(Form1.Canvas.Pixels[4*x+i, 4*y+j]);
          b := round(b / 16);
          Form1.Canvas.Pixels[x,y+50] := RGB(r, g, b)
        end;
        Application.ProcessMessages;
      end;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

    {
     This code draws an anti-aliased line on a bitmap 
     This means that the line is not jagged like the 
     lines drawn using the LineTo() function 
    }
     
     uses
       Graphics, Windows;
     
     type
       TRGBTripleArray = array[0..1000] of TRGBTriple;
       PRGBTripleArray = ^TRGBTripleArray;
     
     // anti-aliased line 
    procedure WuLine(ABitmap : TBitmap ; Point1, Point2 : TPoint ; AColor : TColor);
     var
       deltax, deltay, loop, start, finish : integer;
       dx, dy, dydx : single; // fractional parts 
      LR, LG, LB : byte;
       x1, x2, y1, y2 : integer;
     begin
       x1 := Point1.X; y1 := Point1.Y;
       x2 := Point2.X; y2 := Point2.Y;
       deltax := abs(x2 - x1); // Calculate deltax and deltay for initialisation 
      deltay := abs(y2 - y1);
       if (deltax = 0) or (deltay = 0) then begin // straight lines 
        ABitmap.Canvas.Pen.Color := AColor;
         ABitmap.Canvas.MoveTo(x1, y1);
         ABitmap.Canvas.LineTo(x2, y2);
         exit;
       end;
       LR := (AColor and $000000FF);
       LG := (AColor and $0000FF00) shr 8;
       LB := (AColor and $00FF0000) shr 16;
       if deltax > deltay then
       begin // horizontal or vertical 
        if y2 > y1 then // determine rise and run 
          dydx := -(deltay / deltax)
         else
           dydx := deltay / deltax;
         if x2 < x1 then
         begin
           start := x2; // right to left 
          finish := x1;
           dy := y2;
         end else
         begin
           start := x1; // left to right 
          finish := x2;
           dy := y1;
           dydx := -dydx; // inverse slope 
        end;
         for loop := start to finish do
         begin
           AlphaBlendPixel(ABitmap, loop, trunc(dy), LR, LG, LB, 1 - frac(dy));
           AlphaBlendPixel(ABitmap, loop, trunc(dy) + 1, LR, LG, LB, frac(dy));
           dy := dy + dydx; // next point 
        end;
       end else
       begin
         if x2 > x1 then // determine rise and run 
          dydx := -(deltax / deltay)
         else
           dydx := deltax / deltay;
         if y2 < y1 then
         begin
           start := y2; // right to left 
          finish := y1;
           dx := x2;
         end else
         begin
           start := y1; // left to right 
          finish := y2;
           dx := x1;
           dydx := -dydx; // inverse slope 
        end;
         for loop := start to finish do
         begin
           AlphaBlendPixel(ABitmap, trunc(dx), loop, LR, LG, LB, 1 - frac(dx));
           AlphaBlendPixel(ABitmap, trunc(dx) + 1, loop, LR, LG, LB, frac(dx));
           dx := dx + dydx; // next point 
        end;
       end;
     end;
     
     // blend a pixel with the current colour 
    procedure AlphaBlendPixel(ABitmap : TBitmap ; X, Y : integer ; R, G, B : byte ; ARatio : Real);
     Var
       LBack, LNew : TRGBTriple;
       LMinusRatio : Real;
       LScan : PRGBTripleArray;
     begin
       if (X < 0) or (X > ABitmap.Width - 1) or (Y < 0) or (Y > ABitmap.Height - 1) then
         Exit; // clipping 
      LScan := ABitmap.Scanline[Y];
       LMinusRatio := 1 - ARatio;
       LBack := LScan[X];
       LNew.rgbtBlue := round(B*ARatio + LBack.rgbtBlue*LMinusRatio);
       LNew.rgbtGreen := round(G*ARatio + LBack.rgbtGreen*LMinusRatio);
       LNew.rgbtRed := round(R*ARatio + LBack.rgbtRed*LMinusRatio);
       LScan[X] := LNew;
     end; 
