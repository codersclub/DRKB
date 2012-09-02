<h1>Позиция ячейки в TDBGrid</h1>
<div class="date">01.01.2007</div>


<p>В TCustomGrid определен метод CellRect, который, к сожалению, защищен. Это означает, что даный метод доступен только для TCustomGrid и его наследников. Но все-таки существует немного мудреное решение вызова данного метода:</p>
<pre>
type
  TMyDBGrid = class(TDBGrid)
    public
      function CellRect(ACol, ARow: Longint): TRect;
  end;
 
function TMyDBGrid.CellRect(ACol, ARow: Longint): TRect;
begin
  Result := inherited CellRect(ACol, ARow);
end;
 
Вы можете сделать приведение типа вашего DBGrid к TMyDBGrid (это возможно, поскольку CellRect статический метод) и вызвать CellRect:
 
Rectangle := TMyDBGrid(SomeDBGrid).CellRect(SomeColumn, SomeRow);
 
procedure TfmLoadIn.DBGrid1DrawColumnCell(Sender: TObject;
  const Rect: TRect; DataCol: Integer; Column: TColumn;
  State: TGridDrawState);
const
  Disp = 2; //Правильно выравниваем компонент
begin
  inherited;
  if (gdFocused in State) then
  begin
    if (Column.FieldName = 'TYPEDescription') then
    begin
      dlTYPEDescription.Left := Rect.Left + DBGrid1.Left + Disp;
      dlTYPEDescription.Top := Rect.Top + DBGrid1.top + Disp;
      dlTYPEDescription.Width := Rect.Right - Rect.Left;
      dlTYPEDescription.Height := Rect.Bottom - Rect.Top;
      dlTYPEDescription.Visible := True;
    end;
  end;
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

