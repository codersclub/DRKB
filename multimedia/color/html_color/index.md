---
Title: Как получить цвет строки в HTML-формате?
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как получить цвет строки в HTML-формате?
========================================

Если Вам необходимо создать HTML-файл, то необходимо объявить тэг для
цвета шрифта либо цвета фона. Однако просто вставить значение TColor не
получится - необходимо преобразовать цвет в формат RGB. В своём наборе
SMExport я использую следующую функцию:

    function GetHTMLColor(cl: TColor; IsBackColor: Boolean): string;
    var
      rgbColor: TColorRef;
    begin
      if IsBackColor then
        Result := 'bg'
      else
        Result := '';
      rgbColor := ColorToRGB(cl);
      Result := Result + 'color="#' +
      Format('%.2x%.2x%.2x',
      [GetRValue(rgbColor),
      GetGValue(rgbColor),
      GetBValue(rgbColor)]) + '"';
    end;

