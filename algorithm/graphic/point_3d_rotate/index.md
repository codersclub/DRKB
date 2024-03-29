---
Title: Rotate a 3D Point around another 3D Point
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Rotate a 3D Point around another 3D Point
=========================================

    const 
      PIDiv180 = 0.017453292519943295769236907684886;
     
    procedure Rotate3(Rx, Ry, Rz: Double; x, y, z, ox, oy, oz: Double;
      var Nx, Ny, Nz: Double);
    begin
      Rotate(Rx, Ry, Rz, x - ox, y - oy, z - oz, Nx, Ny, Nz);
      Nx := Nx + ox;
      Ny := Ny + oy;
      Nz := Nz + oz;
    end;
     
     
    procedure Rotate(Rx, Ry, Rz: Double; x, y, z: Double; var Nx, Ny, Nz: Double);
    var 
      TempX: Double;
      TempY: Double;
      TempZ: Double;
      SinX: Double;
      SinY: Double;
      SinZ: Double;
      CosX: Double;
      CosY: Double;
      CosZ: Double;
      XRadAng: Double;
      YRadAng: Double;
      ZRadAng: Double;
    begin
      XRadAng := Rx * PIDiv180;
      YRadAng := Ry * PIDiv180;
      ZRadAng := Rz * PIDiv180;
     
      SinX := Sin(XRadAng);
      SinY := Sin(YRadAng);
      SinZ := Sin(ZRadAng);
     
      CosX := Cos(XRadAng);
      CosY := Cos(YRadAng);
      CosZ := Cos(ZRadAng);
     
      Tempy := y * CosY - z * SinY;
      Tempz := y * SinY + z * CosY;
      Tempx := x * CosX - Tempz * SinX;
     
      Nz := x * SinX + Tempz * CosX;
      Nx := Tempx * CosZ - TempY * SinZ;
      Ny := Tempx * SinZ + TempY * CosZ;
    end;

