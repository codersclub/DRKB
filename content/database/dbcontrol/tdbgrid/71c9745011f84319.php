<h1>Как изменить шрифт определенной строки в TDBGrid?</h1>
<div class="date">01.01.2007</div>


<p>Для этого надо воспользоваться событием OnDrawDataCell в dbgrid.</p>
<pre>
procedure TForm1.DBGrid1DrawDataCell(Sender: TObject; const Rect: TRect;
  Field: TField; State: TGridDrawState);
begin
  // If the record's CustNo is 4711 draw the entire row with a
  // line through it. (set the font style to strike out)
  if (Sender as TDBGrid).DataSource.DataSet.FieldByName('CustNo').AsString =
    '4711' then
    with (Sender as TDBGrid).Canvas do
      begin
        FillRect(Rect);
       // Set the font style to StrikeOut
        Font.Style := Font.Style + [fsStrikeOut];
       // Draw the cell right aligned for floats + offset
        if (Field.DataType = ftFloat) then
          TextOut(Rect.Right - TextWidth(Field.AsString) - 3,
            Rect.Top + 3, Field.AsString)
       // Otherwise draw the cell left aligned + offset
        else
          TextOut(Rect.Left + 2, Rect.Top + 3, Field.AsString);
      end;
end;
</pre>


<p>Замечание: Вышеприведённый код использует таблицу "CUSTOMER.DB", TDBGrid, TDataSource</p>
<p>и TTable</p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

