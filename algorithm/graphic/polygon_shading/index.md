---
Title: Draw a polygon with Gouraud shading
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Draw a polygon with Gouraud shading
===================================

Нарисовать многоугольник с затенением Гуро

    uses
      Graphics, Dialogs;
     
    TRGBFloat = record
      R : single;
      G : single;
      B : single;
    end;
     
    TPointColor = record
      X : integer;
      Y : integer;
      RGB : TRGBFloat;
    end;
     
    TPointColorTriangle = array[0..2] of TPointColor;
     
    {This procedure draws a triangular polygon using Gouraud shading. 
     You specify the position and colour of the 3 corners and it will
     draw a filled triangle with the colours smoothed out over the 
     surface of the polygon. This is used a lot in 3D graphics for
     improved rendering of curved surfaces. The procedure is very fast 
     and can be used for realtime 3D animation.}
     
    // fill a traingular polygon using Gouraud shading
    procedure T3DModel.GouraudPoly(var ABitmap : TBitmap ; V : TPointColorTriangle);
    Var
      LX, RX, Ldx, Rdx : Single;
      Dif1, Dif2 : Single;
      LRGB, RRGB, RGB, RGBdx, LRGBdy, RRGBdy : TRGBFloat;
      RGBT : RGBTriple;                      
      Scan : PRGBTripleArray;
      y, x, ScanStart, ScanEnd : integer;
      Vmax : byte;
      Right : boolean;
      Temp : TPointColor;
    begin
      try
     
        // sort vertices by Y
        Vmax := 0;
        if V[1].Y > V[0].Y then Vmax := 1;
        if V[2].Y > V[Vmax].Y then Vmax := 2;
        if Vmax <> 2 then begin
          Temp := V[2];
          V[2] := V[Vmax];
          V[Vmax] := Temp;
        end;
        if V[1].Y > V[0].Y then Vmax := 1 
                           else Vmax := 0;
        if Vmax = 0 then begin
          Temp := V[1];
          V[1] := V[0];
          V[0] := Temp;
        end;
     
        Dif1 := V[2].Y - V[0].Y;
        if Dif1 = 0 then Dif1 := 0.001; // prevent EZeroDivide
        Dif2 := V[1].Y - V[0].Y;
        if Dif2 = 0 then Dif2 := 0.001;
     
        { work out if middle point is to the left or right of the line
          connecting upper and lower points }
        if V[1].X > (V[2].X - V[0].X) * Dif2 / Dif1 + V[0].X then Right := True
                                                             else Right := False;
     
        // calculate increments in x and colour for stepping through the lines
        if Right then begin
          Ldx := (V[2].X - V[0].X) / Dif1;
          Rdx := (V[1].X - V[0].X) / Dif2;
          LRGBdy.B := (V[2].RGB.B - V[0].RGB.B) / Dif1;
          LRGBdy.G := (V[2].RGB.G - V[0].RGB.G) / Dif1;
          LRGBdy.R := (V[2].RGB.R - V[0].RGB.R) / Dif1;
          RRGBdy.B := (V[1].RGB.B - V[0].RGB.B) / Dif2;
          RRGBdy.G := (V[1].RGB.G - V[0].RGB.G) / Dif2;
          RRGBdy.R := (V[1].RGB.R - V[0].RGB.R) / Dif2;
        end else begin
          Ldx := (V[1].X - V[0].X) / Dif2;
          Rdx := (V[2].X - V[0].X) / Dif1;
          RRGBdy.B := (V[2].RGB.B - V[0].RGB.B) / Dif1;
          RRGBdy.G := (V[2].RGB.G - V[0].RGB.G) / Dif1;
          RRGBdy.R := (V[2].RGB.R - V[0].RGB.R) / Dif1;
          LRGBdy.B := (V[1].RGB.B - V[0].RGB.B) / Dif2;
          LRGBdy.G := (V[1].RGB.G - V[0].RGB.G) / Dif2;
          LRGBdy.R := (V[1].RGB.R - V[0].RGB.R) / Dif2;
        end;
     
        LRGB := V[0].RGB;
        RRGB := LRGB;
     
        LX := V[0].X;
        RX := V[0].X;
     
        // fill region 1
        for y := V[0].Y to V[1].Y - 1 do begin
     
          // y clipping
          if y > ABitmap.Height - 1 then Break;
          if y < 0 then begin
            LX := LX + Ldx;
            RX := RX + Rdx;
            LRGB.B := LRGB.B + LRGBdy.B;
            LRGB.G := LRGB.G + LRGBdy.G;
            LRGB.R := LRGB.R + LRGBdy.R;
            RRGB.B := RRGB.B + RRGBdy.B;
            RRGB.G := RRGB.G + RRGBdy.G;
            RRGB.R := RRGB.R + RRGBdy.R;
            Continue;
          end;
     
          Scan := ABitmap.ScanLine[y];
     
          // calculate increments in color for stepping through pixels
          Dif1 := RX - LX + 1;
          if Dif1 = 0 then Dif1 := 0.001;
          RGBdx.B := (RRGB.B - LRGB.B) / Dif1;
          RGBdx.G := (RRGB.G - LRGB.G) / Dif1;
          RGBdx.R := (RRGB.R - LRGB.R) / Dif1;
     
          // x clipping
          if LX < 0 then begin
            ScanStart := 0;
            RGB.B := LRGB.B + (RGBdx.B * abs(LX));
            RGB.G := LRGB.G + (RGBdx.G * abs(LX));
            RGB.R := LRGB.R + (RGBdx.R * abs(LX));
          end else begin
            RGB := LRGB;
            ScanStart := round(LX);
          end;
          if RX - 1 > ABitmap.Width - 1 then ScanEnd := ABitmap.Width - 1
                                        else ScanEnd := round(RX) - 1;
     
          // scan the line
          for x := ScanStart to ScanEnd do begin
            RGBT.rgbtBlue := trunc(RGB.B);
            RGBT.rgbtGreen := trunc(RGB.G);
            RGBT.rgbtRed := trunc(RGB.R);
            Scan[x] := RGBT;
            RGB.B := RGB.B + RGBdx.B;
            RGB.G := RGB.G + RGBdx.G;
            RGB.R := RGB.R + RGBdx.R;
          end;
          // increment edge x positions
          LX := LX + Ldx;
          RX := RX + Rdx;
     
          // increment edge colours by the y colour increments
          LRGB.B := LRGB.B + LRGBdy.B;
          LRGB.G := LRGB.G + LRGBdy.G;
          LRGB.R := LRGB.R + LRGBdy.R;
          RRGB.B := RRGB.B + RRGBdy.B;
          RRGB.G := RRGB.G + RRGBdy.G;
          RRGB.R := RRGB.R + RRGBdy.R;
        end;
     
        Dif1 := V[2].Y - V[1].Y;
        if Dif1 = 0 then Dif1 := 0.001;
        // calculate new increments for region 2
        if Right then begin
          Rdx := (V[2].X - V[1].X) / Dif1;
          RX := V[1].X;
          RRGBdy.B := (V[2].RGB.B - V[1].RGB.B) / Dif1;
          RRGBdy.G := (V[2].RGB.G - V[1].RGB.G) / Dif1;
          RRGBdy.R := (V[2].RGB.R - V[1].RGB.R) / Dif1;
          RRGB := V[1].RGB;
        end else begin
          Ldx := (V[2].X - V[1].X) / Dif1;
          LX := V[1].X;
          LRGBdy.B := (V[2].RGB.B - V[1].RGB.B) / Dif1;
          LRGBdy.G := (V[2].RGB.G - V[1].RGB.G) / Dif1;
          LRGBdy.R := (V[2].RGB.R - V[1].RGB.R) / Dif1;
          LRGB := V[1].RGB;
        end;
     
        // fill region 2
        for y := V[1].Y to V[2].Y - 1 do begin
     
          // y clipping
          if y > ABitmap.Height - 1 then Break;
          if y < 0 then begin
            LX := LX + Ldx;
            RX := RX + Rdx;
            LRGB.B := LRGB.B + LRGBdy.B;
            LRGB.G := LRGB.G + LRGBdy.G;
            LRGB.R := LRGB.R + LRGBdy.R;
            RRGB.B := RRGB.B + RRGBdy.B;
            RRGB.G := RRGB.G + RRGBdy.G;
            RRGB.R := RRGB.R + RRGBdy.R;
            Continue;
          end;
     
          Scan := ABitmap.ScanLine[y];
     
          Dif1 := RX - LX + 1;
          if Dif1 = 0 then Dif1 := 0.001;
          RGBdx.B := (RRGB.B - LRGB.B) / Dif1;
          RGBdx.G := (RRGB.G - LRGB.G) / Dif1;
          RGBdx.R := (RRGB.R - LRGB.R) / Dif1;
     
          // x clipping
          if LX < 0 then begin
            ScanStart := 0;
            RGB.B := LRGB.B + (RGBdx.B * abs(LX));
            RGB.G := LRGB.G + (RGBdx.G * abs(LX));
            RGB.R := LRGB.R + (RGBdx.R * abs(LX));
          end else begin
            RGB := LRGB;
            ScanStart := round(LX);
          end;
          if RX - 1 > ABitmap.Width - 1 then ScanEnd := ABitmap.Width - 1
                                        else ScanEnd := round(RX) - 1;
     
          // scan the line
          for x := ScanStart to ScanEnd do begin
            RGBT.rgbtBlue := trunc(RGB.B);
            RGBT.rgbtGreen := trunc(RGB.G);
            RGBT.rgbtRed := trunc(RGB.R);
            Scan[x] := RGBT;
            RGB.B := RGB.B + RGBdx.B;
            RGB.G := RGB.G + RGBdx.G;
            RGB.R := RGB.R + RGBdx.R;
          end;
     
          LX := LX + Ldx;
          RX := RX + Rdx;
     
          LRGB.B := LRGB.B + LRGBdy.B;
          LRGB.G := LRGB.G + LRGBdy.G;
          LRGB.R := LRGB.R + LRGBdy.R;
          RRGB.B := RRGB.B + RRGBdy.B;
          RRGB.G := RRGB.G + RRGBdy.G;
          RRGB.R := RRGB.R + RRGBdy.R;
        end;
     
      except
        ShowMessage('Exception in GouraudPoly Method');
      end;
    end;

