---
Title: Негатив картинки
Date: 01.01.2007
---


Негатив картинки
================

::: {.date}
01.01.2007
:::

    var
      Line: pByteArray;
      i, j: integer;
    begin
      // считываем высоту картинки
      for i := 0 to Image1.Picture.Bitmap.Height - 1 do
      begin
        //сканируем по линиям рисунок
        Line := Image1.Picture.Bitmap.ScanLine[i];
        for j := 0 to Image1.Picture.Bitmap.Width * 3 - 1 do
          //меняем цвет на обратный исходя из RGB
          Line^[j] := 255 - Line^[j];
      end;
      Image1.Refresh;
    end;

Взято с <https://delphiworld.narod.ru>
