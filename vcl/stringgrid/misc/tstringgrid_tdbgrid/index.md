---
Title: TStringGrid как TDBGrid
Date: 01.01.2007
---


TStringGrid как TDBGrid
=======================

::: {.date}
01.01.2007
:::

Ну это может выглядеть приблизительно так (возможно нужна некоторая
доработка, написал от руки, не проверяя):

    table.first;
    row := 0;
    grid.rowcount := table.recordCount;
    while not table.eof do 
    begin
      for i := 0 to table.fieldCount-1 do
        grid.cells[i,row] := table.fields[i].asString;
      inc (row);
      table.next;
    end;

У меня тоже имееются свои причины использования TStringGrid. Вот мой
код, который загружает данные из отфильтрованной таблицы. Он не очень
изящен, т.к. реально является лишь черновиком. У меня это работает, а
большего мне и не нужно. Работает очень быстро, даже в случае сотни
загруженных колонок. Есть много ссылок на внешние переменные. Надеюсь
что они не слишком заумные.

    procedure TformLookupDB.FillCells;
    var
      Row, i: INTEGER;
      w: INTEGER;
      grid: TStringGrid;
    begin
      doGrid.RowCount := 0;
      if not ASSIGNED(fDB) then
        EXIT;
      Row := 0;
      for i := LOW(fColWidths) to HIGH(fColWidths) do
        fColWidths[i] := 100
        // Данный временный объект-сетка используется для предохранения от огромного
        // количества подразумеваемых событий Application.ProcessMessages,
        // инициируемых базой данных, и вызывающих противное моргание объекта
        // doGrid. Итак, мы загружаем данные в объект-сетку
        // и затем копируем их в стобцы, начиная с верхней части.
     
        grid := TStringGrid.Create(Self);
      grid.Visible := FALSE;
      with fDB do
      try
     
        grid.ColCount := fFields.Count;
        DisableControls;
        // Фильтр был установлен с помощью свойства Self.Filter
        First;
        while not EOF do
        try
          grid.RowCount := Row + 1;
          for i := 0 to grid.ColCount - 1 do
          begin
            grid.Cells[i, Row] :=
              FieldByName(fFields.Strings[i]).AsString
              w := doGrid.Canvas.TEXTWIDTH(grid.Cells[i,
              Row]);
            if fColWidths[i] < w then
              fColWidths[i] := w;
          end
            INC(Row);
        finally
          Next;
        end
      finally
        doGrid.RowCount := grid.RowCount;
        doGrid.ColCount := grid.ColCount;
        for i := 0 to grid.ColCount - 1 do
        begin
          doGrid.Cols[i] := grid.Cols[i];
          doGrid.ColWidths[i] := fColWidths[i] + 4
        end
          grid.Free;
        EnableControls
      end
    end;
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
