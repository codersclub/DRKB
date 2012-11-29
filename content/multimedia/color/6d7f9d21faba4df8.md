Как найти контрастный цвет к данному?
=====================================

::: {.date}
01.01.2007
:::

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

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
