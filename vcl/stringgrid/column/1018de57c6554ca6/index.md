---
Title: Очистить ячейки в TStringGrid
Date: 01.01.2007
---


Очистить ячейки в TStringGrid
=============================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject);
     var
       i, k: Integer;
     begin
       with StringGrid1 do
         for i := 0 to ColCount - 1 do
           for k := 0 to RowCount - 1 do
             Cells[i, k] := '';
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>

------------------------------------------------------------------------

     // Many times faster! 
    procedure TForm1.Button2Click(Sender: TObject);
     var
       I: Integer;
     begin
       for I := 0 to StringGrid1.RowCount - 1 do
         StringGrid1.Rows[I].Clear();
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
