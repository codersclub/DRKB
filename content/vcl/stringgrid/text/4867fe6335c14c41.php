<h1>Текст в ячейке TStringGrid, если не помещается, переносится на следующую ячейку</h1>
<div class="date">01.01.2007</div>


<pre>
//Сначала нужно обработать событие OnDrawCell компонента TStringGrid: 
 
 
 
procedure TForm1.StringGrid1DrawCell(Sender: TObject; ACol, ARow: Integer;
Rect: TRect; State: TGridDrawState);
var
  i, x, y: Integer;
begin
  if gdFixed in State then
    Exit;
  if ARow &gt; 1 then
    Exit;
  {Draw row 1 with text from cell 1,1 spanning all cells in the row}
  with sender as TStringGrid do
  begin
    {Extend rect to include grid line on right, if not last cell in row}
    if aCol &lt; Pred(ColCount) then
      Rect.Right := Rect.Right + GridlineWidth;
    {Figure out where the text of the first cell would start
    relative to the current cells rect}
    y := Rect.Top + 2;
    x := Rect.Left + 2;
    for i:= 1 to aCol - 1 do
      x := x - ColWidths[i] - GridlineWidth;
    {Paint cell pale yellow}
    Canvas.Brush.Color := $7FFFFF;
    Canvas.Brush.Style := bsSolid;
    Canvas.FillRect( Rect );
    {Paint text of cell 1,1 clipped to current cell}
    Canvas.TextRect( Rect, x, y, Cells[1, 1] );
  end;
end;
 
 
 
 
//По созданию окна изобразим следующее 
 
 
 
procedure TForm1.FormCreate(Sender: TObject);
var
  i, k: Integer;
begin
  with StringGrid1 do
  begin
    cells[1, 1] := 'A rather long line which will span cells';
    for i:= 1 to colcount-1 do
      for k:= 2 to rowcount -1 do
        cells[i,k] := Format( 'Cell[%d, %d]', [i, k]);
  end;
end;
 
 
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
