---
Title: TColor -\> HTML Color
Author: Smike
Source: <https://forum.sources.ru>
Date: 01.01.2007
---


TColor -\> HTML Color
====================

Функция для преобразования цвета TColor в формат цветов HTML

    function TColorToHTML(const Value: TColor): string;
    var
      RGBColor: Longint;
    begin
      RGBColor := ColorToRGB(Value);
      Result := Format('#%.2x%.2x%.2x', [GetRValue(RGBColor), GetGValue(RGBColor), GetBValue(RGBColor)]);
    end;

Не нужно забывать о

    uses SysUtils, Graphics;

для функций Format и ColorToRGB!
