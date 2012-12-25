---
Title: Изменение размеров колонок в TStringGrid
Date: 01.01.2007
---


Изменение размеров колонок в TStringGrid
========================================

::: {.date}
01.01.2007
:::

Ниже приведён примен кода, который позволяет автоматически подогнать
размер колонки в компененте TStringGrid, под размер самой длинной строки
текста в колонке:

    procedure AutoSizeGridColumn(Grid : TStringGrid;
                                  column : integer);
    var
      i : integer;
      temp : integer;
      max : integer;
    begin
      max := 0;
      for i := 0 to (Grid.RowCount - 1) do begin
        temp := Grid.Canvas.TextWidth(grid.cells[column, i]);
        if temp > max then max := temp;
      end;
      Grid.ColWidths[column] := Max + Grid.GridLineWidth + 3;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      AutoSizeGridColumn(StringGrid1, 1);
    end;

Взято из <https://forum.sources.ru>
