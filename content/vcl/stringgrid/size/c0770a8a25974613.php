<h1>Изменение размеров колонок в TStringGrid</h1>
<div class="date">01.01.2007</div>


<p>Ниже приведён примен кода, который позволяет автоматически подогнать размер колонки в компененте TStringGrid, под размер самой длинной строки текста в колонке:</p>
<pre>
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
    if temp &gt; max then max := temp;
  end;
  Grid.ColWidths[column] := Max + Grid.GridLineWidth + 3;
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  AutoSizeGridColumn(StringGrid1, 1);
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


