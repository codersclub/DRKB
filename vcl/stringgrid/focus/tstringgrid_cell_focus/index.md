---
Title: Фокус ячейки TStringGrid
Author: Simon
Date: 01.01.2007
---


Фокус ячейки TStringGrid
========================

::: {.date}
01.01.2007
:::

Автор: Simon

    procedure SetGridFocus(SGrid: TStringGrid; r, c: integer);
    var
      SRect: TGridRect;
    begin
      with SGrid do
      begin
        SetFocus; {Передаем фокус сетке}
        Row := r; {Устанавливаем Row/Col}
        Col := c;
        SRect.Top := r; {Определяем выбранную область}
        SRect.Left := c;
        SRect.Bottom := r;
        SRect.Right := c;
        Selection := SRect; {Устанавливаем выбор}
      end;
    end;
     
     
     
    //Для вызова процедуры:
     
     
    SetGridFocus(StringGrid1, 10, 2);

Это всегда срабатывает в случае, если никакая ячейка не выбрана или
фокус имеет другой элемент управления.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
