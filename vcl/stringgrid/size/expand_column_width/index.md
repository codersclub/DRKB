---
Title: В TStringGrid ширина колонки подгоняется под длину самой длинной строки
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


В TStringGrid ширина колонки подгоняется под длину самой длинной строки
=======================================================================

Поскольку в компоненте StringGrid по умолчанию все столбцы имеют
одинаковую ширину - в некоторых ячейках текст обрезается. Чтобы этого
избежать, после заполнения StringGrid нужно для каждого столбца находить
текст максимальной длины и в соответствии с его длиной устанавливать
ширину всего столбца

    var
      x, y, w: integer;
      s: string;
      MaxWidth: integer;
    begin
      with StringGrid1 do
        ClientHeight := DefaultRowHeight * RowCount + 5;
        with StringGrid1 do
        begin
          for x := 0 to ColCount - 1 do
          begin
            MaxWidth := 0;
            for y := 0 to RowCount - 1 do
            begin
              w := Canvas.TextWidth(Cells[x,y]);
              if w > MaxWidth then
                MaxWidth := w;
            end;
            ColWidths[x] := MaxWidth + 5;
          end;
        end;
    end;


