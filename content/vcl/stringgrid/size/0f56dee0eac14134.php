<h1>Автоматическая ширина колонок в TStringGrid</h1>
<div class="date">01.01.2007</div>


<p>Можно ли сделать так чтобы TStringGrid автоматически изменял ширину колонок, чтобы вместить самую длинную строчку в колонке?</p>
<pre>
procedure AutoSizeGridColumn(Grid: TStringGrid; column: integer);
var
  i: integer;
  temp: integer;
  max: integer;
begin
  max := 0;
  for i := 0 to (Grid.RowCount - 1) do
    begin
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


<hr />
<pre>
procedure SetGridColumnWidths(Grid: TStringGrid;
   const Columns: array of Integer);
 { 
  When you double-Click on a Column-Header the Column 
  autosizes to fit its content 
 
  Bei Doppelklick auf eine fixierte Spalte passt sich 
  die Spaltenbreite der Textgrosse an 
}
 
   procedure AutoSizeGridColumn(Grid: TStringGrid; column, min, max: Integer);
     { Set for max and min some minimal/maximial Values}
     { Bei max and min kann eine Minimal- resp. Maximalbreite angegeben werden}
   var
     i: Integer;
     temp: Integer;
     tempmax: Integer;
   begin
     tempmax := 0;
     for i := 0 to (Grid.RowCount - 1) do
     begin
       temp := Grid.Canvas.TextWidth(Grid.cells[column, i]);
       if temp &gt; tempmax then tempmax := temp;
       if tempmax &gt; max then
       begin
         tempmax := max;
         break;
       end;
     end;
     if tempmax &lt; min then tempmax := min;
     Grid.ColWidths[column] := tempmax + Grid.GridLineWidth + 3;
   end;
 
   procedure TForm1.StringGrid1DblClick(Sender: TObject);
   var
     P: TPoint;
     iColumn, iRow: Longint;
   begin
     GetCursorPos(P);
     with StringGrid1 do
     begin
       P := ScreenToClient(P);
       MouseToCell(P.X, P.Y, iColumn, iRow);
       if P.Y &lt; DefaultRowHeight then
         AutoSizeGridColumn(StringGrid1, iColumn, 40, 100);
     end;
   end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>

<hr />
<pre>
 procedure TForm1.Button1Click(Sender: TObject);
   { by P. Below }
   const
     DEFBORDER = 8;
   var
     max, temp, i, n: Integer;
   begin
     with Grid do
     begin
       Canvas.Font := Font;
       for n := Low(Columns) to High(Columns) do
       begin
         max := 0;
         for i := 0 to RowCount - 1 do
         begin
           temp := Canvas.TextWidth(Cells[Columns[n], i]) + DEFBORDER;
           if temp &gt; max then
             max := temp;
         end; { For }
         if max &gt; 0 then
           ColWidths[Columns[n]] := max;
       end; { For }
     end; { With }
   end; {SetGridColumnWidths  }
</pre>

<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>


<hr />
<pre>
{   This will resize the columns of a TStringGrid / TDrawGrid (text 
    only!) so the text is completely visble. To save some time, 
    it uses the first 10 rows only, but that should be easy to fix, 
    if you need more. }
 
 // we need this to access protected methods 
type
   TGridHack = class(TCustomGrid);
 
 procedure ResizeStringGrid(_Grid: TCustomGrid);
 var
   Col, Row: integer;
   Grid: TGridHack;
   MaxWidth: integer;
   ColWidth: integer;
   ColText: string;
   MaxRow: integer;
   ColWidths: array of integer;
 begin
   Grid := TGridHack(_Grid);
   SetLength(ColWidths, Grid.ColCount);
   MaxRow := 10;
   if MaxRow &gt; Grid.RowCount then
     MaxRow := Grid.RowCount;
   for Col := 0 to Grid.ColCount - 1 do
   begin
     MaxWidth := 0;
     for Row := 0 to MaxRow - 1 do
     begin
       ColText  := Grid.GetEditText(Col, Row);
       ColWidth := Grid.Canvas.TextWidth(ColText);
       if ColWidth &gt; MaxWidth then
         MaxWidth := ColWidth;
     end;
     if goVertLine in Grid.Options then
       Inc(MaxWidth, Grid.GridLineWidth);
     ColWidths[Col]      := MaxWidth + 4;
     Grid.ColWidths[Col] := ColWidths[Col];
   end;
 end;
 
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>


<pre>
var
  i, j, temp, max: integer;
begin
  for i := 0 to grid.colcount - 1 do
  begin
    max := 0;
    for j := 0 to grid.rowcount - 1 do
    begin
      temp := grid.canvas.textWidth(grid.cells[i, j]);
      if temp &gt; max then
        max := temp;
    end;
    grid.colWidths[i] := max + grid.gridLineWidth + 1;
  end;
end;
 
 
 
 
 
</pre>
<p>Вероятно, вам необходимо будет добавить +1, чтобы текст не прилипал к границам ячеек</p>

<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>


<p class="author">Автор: Neil J. Rubenking </p>

<p>Я использую компонент StringGrid и хотел бы менять ширину его колонок в соответствии с расположенным в них текстом, другими словами я хочу чтобы весь текст в них был виден, но как это сделать? </p>

<p>Попробуйте это:</p>

<pre>
procedure TForm1.StringGrid1SelectCell(Sender: TObject; vCol,
  vRow: Longint; var CanSelect: Boolean);
var
  Wid: Integer;
begin
  with Sender as TStringGrid do
  begin
    Wid := Canvas.TextWidth(Cells[Col, Row] + ' ');
    if Wid &gt; ColWidths[Col] then
      ColWidths[Col] := Wid;
  end;
end;
 
procedure TForm1.StringGrid1KeyPress(Sender: TObject; var Key: Char);
var
  Wid: Integer;
begin
  if Key = #13 then
    with Sender as TStringGrid do
    begin
      Wid := Canvas.TextWidth(Cells[Col, Row] + ' ');
      if Wid &gt; ColWidths[Col] then
        ColWidths[Col] := Wid;
    end;
end;
</pre>

<p>Имейте в виду, что в обработчике события OnSelectCell я переименовал параметры Col и Row на vCol и vRow, чтобы избежать путаницы со свойствами StringGrid, имеющими те же имена. StringGrid c данными методами всегда расширяет данную колонку, если вновь добавляемая строка имеет ширину большую чем текущая ширина колонки.</p>
<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

