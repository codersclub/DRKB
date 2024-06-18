---
Title: Как изменить размеры полигона?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как изменить размеры полигона?
==============================

    { ... }
    type
      TPolygon = array of TPoint;
     
    procedure ZoomPolygon(var Polygon: TPolygon; const Center: TPoint; const Scale: Double);
    var
      I: Integer;
    begin
      for I := 0 to High(Polygon) do
      begin
        Polygon[I].X := Round(Scale * (Polygon[I].X - Center.X) + Center.X);
        Polygon[I].Y := Round(Scale * (Polygon[I].Y - Center.Y) + Center.Y);
      end;
    end;

