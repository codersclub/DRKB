---
Title: Rotate a 2D Point
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Rotate a 2D Point
=================

Rotate a 2D Point

    const
      PIDiv180 = 0.017453292519943295769236907684886;
     
    procedure Rotate(RotAng: Double; x, y: Double; var Nx, Ny: Double);
    var
      SinVal: Double;
      CosVal: Double;
    begin
      RotAng := RotAng * PIDiv180;
      SinVal := Sin(RotAng);
      CosVal := Cos(RotAng);
      Nx := x * CosVal - y * SinVal;
      Ny := y * CosVal + x * SinVal;
    end;


Rotate a 2D Point around another 2D Point

    const
      PIDiv180 = 0.017453292519943295769236907684886;
     
    procedure Rotate2(RotAng: Double; x, y, ox, oy: Double; var Nx, Ny: Double);
    begin
      Rotate(RotAng, x - ox, y - oy, Nx, Ny);
      Nx := Nx + ox;
      Ny := Ny + oy;
    end;

