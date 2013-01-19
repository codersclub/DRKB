---
Title: Вывод надписи на рабочий стол
Author: Fantasist
Date: 01.01.2007
---


Вывод надписи на рабочий стол
=============================

::: {.date}
01.01.2007
:::

На рабочий стол можно вывести строку используя

    TextOut(GetWindowDC(GetDesktopWindow),100,100,'Thom',4);

Автор: Fantasist

Взято с Vingrad.ru <https://forum.vingrad.ru>

Поверх всех окон можно нарисовать надпись использую следующую процедуру:

    procedure WriteDC(s: string);
    var c: TCanvas;
    begin
      c := TCanvas.Create;
      c.Brush.Color := clBlue;
      c.Font.color := clYellow;
      c.Font.name := 'Fixedsys';
      c.Handle := GetDC(GetWindow(GetDesktopWindow, GW_OWNER));
      c.TextOut(screen.Width - c.TextWidth(s) - 2, screen.Height - 43, s);
      c.free;
    end;

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>
