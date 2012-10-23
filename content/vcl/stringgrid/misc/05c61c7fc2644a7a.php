<h1>Можно ли обратиться к колонке или строке grid'а по заголовку?</h1>
<div class="date">01.01.2007</div>


<p>В следующем примере приведены две функции: GetGridColumnByName() и GetGridRowByName(), которые возвращают колонку или строку, имеющую заданный заголовок (caption).</p>
<pre>
procedure TForm1.FormCreate(Sender: TObject);
begin
  StringGrid1.Rows[1].Strings[0] := 'This Row';
  StringGrid1.Cols[1].Strings[0] := 'This Column';
end;
 
function GetGridColumnByName(Grid: TStringGrid; ColName: string): integer;
var
  i: integer;
begin
  for i := 0 to Grid.ColCount - 1 do
    if Grid.Rows[0].Strings[i] = ColName then
      begin
        Result := i;
        exit;
      end;
  Result := -1;
end;
 
function GetGridRowByName(Grid: TStringGrid; RowName: string): integer;
var
  i: integer;
begin
  for i := 0 to Grid.RowCount - 1 do
    if Grid.Cols[0].Strings[i] = RowName then
      begin
        Result := i;
        exit;
      end;
  Result := -1;
end;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  Column: integer;
  Row: integer;
begin
  Column := GetGridColumnByName(StringGrid1, 'This Column');
  if Column = -1 then
    ShowMessage('Column not found')
  else
    ShowMessage('Column found at ' + IntToStr(Column));
  Row := GetGridRowByName(StringGrid1, 'This Row');
  if Row = -1 then
    ShowMessage('Row not found')
  else
    ShowMessage('Row found at ' + IntToStr(Row));
end;
</pre>

