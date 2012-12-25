---
Title: Изменение размера
Date: 01.01.2007
---


Изменение размера
=================

::: {.date}
01.01.2007
:::

     {
    This function resizes a bitmap calculating the average color of a rectangular 
    area of pixels from source bitmap to a pixel or a rectangular area to target 
    bitmap. 
     
    It produces a soft-color and undistorsioned result image unlike the StretchDraw 
    method 
     
    I think that this method have a tenichal name, but I am not sure. 
     
    As you can see, this function could be very optimized :p 
    }
     
     procedure TFormConvertir.ResizeBitmap(imgo, imgd: TBitmap; nw, nh: Integer);
     var
       xini, xfi, yini, yfi, saltx, salty: single;
       x, y, px, py, tpix: integer;
       PixelColor: TColor;
       r, g, b: longint;
     
       function MyRound(const X: Double): Integer;
       begin
         Result := Trunc(x);
         if Frac(x) >= 0.5 then
           if x >= 0 then Result := Result + 1
           else
             Result := Result - 1;
         // Result := Trunc(X + (-2 * Ord(X < 0) + 1) * 0.5); 
      end;
     
     begin
       // Set target size 
     
      imgd.Width  := nw;
       imgd.Height := nh;
     
       // Calcs width & height of every area of pixels of the source bitmap 
     
      saltx := imgo.Width / nw;
       salty := imgo.Height / nh;
     
     
       yfi := 0;
       for y := 0 to nh - 1 do
       begin
         // Set the initial and final Y coordinate of a pixel area 
     
        yini := yfi;
         yfi  := yini + salty;
         if yfi >= imgo.Height then yfi := imgo.Height - 1;
     
         xfi := 0;
         for x := 0 to nw - 1 do
         begin
           // Set the inital and final X coordinate of a pixel area 
     
          xini := xfi;
           xfi  := xini + saltx;
           if xfi >= imgo.Width then xfi := imgo.Width - 1;
     
     
           // This loop calcs del average result color of a pixel area 
          // of the imaginary grid 
     
          r := 0;
           g := 0;
           b := 0;
           tpix := 0;
     
           for py := MyRound(yini) to MyRound(yfi) do
           begin
             for px := MyRound(xini) to MyRound(xfi) do
             begin
               Inc(tpix);
               PixelColor := ColorToRGB(imgo.Canvas.Pixels[px, py]);
               r := r + GetRValue(PixelColor);
               g := g + GetGValue(PixelColor);
               b := b + GetBValue(PixelColor);
             end;
           end;
     
           // Draws the result pixel 
     
          imgd.Canvas.Pixels[x, y] :=
             rgb(MyRound(r / tpix),
             MyRound(g / tpix),
             MyRound(b / tpix)
             );
         end;
       end;
     end;
