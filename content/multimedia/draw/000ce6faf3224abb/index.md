---
Title: Как повернуть элипс?
Date: 01.01.2007
---


Как повернуть элипс?
====================

::: {.date}
01.01.2007
:::

    procedure TForm1.EllipseAngle(ACanvas: TCanvas; XCenter, YCenter,
      XRadius, YRadius: Integer; Angle: Integer);
    const
      Step = 49;
    var
      RX, RY: Integer;
      i: Integer;
      Theta: Double;
      SAngle, CAngle: Double;
      RotAngle: Double;
      XC, YC: Integer;
      Kf: Double;
      X, Y: Double;
      XRot, YRot: Integer;
      Points: array[0..Step] of TPoint;
    begin
      RotAngle := Angle * PI / 180;
      Kf := (360 * PI / 180) / Step;
      SAngle := Sin(RotAngle);
      CAngle := Cos(RotAngle);
      for i := 0 to Step do
      begin
        Theta := i * Kf;
        X := XCenter + XRadius * Cos(Theta);
        Y := YCenter + YRadius * Sin(Theta);
        XRot := Round(XCenter + (X - XCenter) * CAngle - (Y - YCenter) * SAngle);
        YRot := Round(YCenter + (X - XCenter) * SAngle + (Y - YCenter) * CAngle);
        Points[i] := Point(XRot, YRot);
      end;
      ACanvas.Polygon(Points);
    end;

------------------------------------------------------------------------

    procedure RotatedEllipse(aCanvas: TCanvas; X1, Y1, X2, Y2: Integer);
    var
      T, O: TXForm; {in unit Windows}
    begin
      { ... }
      SetGraphicsMode(aCanvas.Handle, GM_Advanced);
      GetWorldTransform(aCanvas.Handle, O);
      {Angle in degree}
      T.eM11 := 1 * Cos(w / 360 * Pi * 2);
      T.eM22 := 1 * Cos(w / 360 * Pi * 2);
      T.eM12 := 1 * Sin(w / 360 * Pi * 2);
      T.eM21 := 1 * -Sin(w / 360 * Pi * 2);
      T.eDX := Round((X1 + X2) / 2);
      T.eDY := Round((Y1 + Y2) / 2);
      ModifyWorldTransform(aCanvas.Handle, T, MWT_LEFTMULTIPLY);
      Canvas.Ellipse(X1, Y1, X2, Y2);
      SetWorldTransform(TheDraw.Handle, O);
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
