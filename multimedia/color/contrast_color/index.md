---
Title: Как найти контрастный цвет к данному?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как найти контрастный цвет к данному?
=====================================

    function FindContrastingColor(Color: TColor): TColor;
    var
      R, G, B: Byte;
    begin
      R := GetRValue(Color);
      G := GetGValue(Color);
      B := GetBValue(Color);
      if (R < 128) then
        R := 255
      else
        R := 0;
      if (G < 128) then
        G := 255
      else
        G := 0;
      if (B < 128) then
        B := 255
      else
        B := 0;
      Result := RGB(R, G, B);
    end;

