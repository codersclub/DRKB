---
Title: Bitmap в TStringGrid-ячейке
Date: 01.01.2007
---


Bitmap в TStringGrid-ячейке
===========================

::: {.date}
01.01.2007
:::

В обработчике события OnDrawCell элемента StringGrid поместите следующий
код:

    with (Sender as TStringGrid) do
      with Canvas do
      begin
        {...}
        Draw(Rect.Left, Rect.Top, Image1.Picture.Graphic);
        {...}
      end;

Используйте метод Draw() или StretchDraw() класса TCanvas. Image1 - это
TImage с предварительно загруженным в него bitmap-ом.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
