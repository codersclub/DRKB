<h1>TCheckBox в TDBGrid</h1>
<div class="date">01.01.2007</div>


<pre>
procedure DrawGridCheckBox(Canvas: TCanvas; Rect: TRect; Checked: boolean);
var
  DrawFlags: Integer;
begin
  Canvas.TextRect(Rect, Rect.Left + 1, Rect.Top + 1, ' ');
  DrawFrameControl(Canvas.Handle, Rect, DFC_BUTTON, DFCS_BUTTONPUSH or DFCS_ADJUSTRECT);
  DrawFlags := DFCS_BUTTONCHECK or DFCS_ADJUSTRECT;// DFCS_BUTTONCHECK
  if Checked then
    DrawFlags := DrawFlags or DFCS_CHECKED;
  DrawFrameControl(Canvas.Handle, Rect, DFC_BUTTON, DrawFlags);
end; 
</pre>

<p>На событие OnDrawColumnCell повесьте вызов процедуры DrawGridCheckBox(): </p>
<pre>
procedure TForm1.DBGrid1DrawColumnCell(Sender: TObject; const Rect: TRect;
  DataCol: Integer; Column: TColumn; State: TGridDrawState);
begin
  if Column.FieldName = 'WEIGHT' then // Модифицируйте под себя
    if Column.Field.AsInteger &gt; 10 then
      DrawGridCheckBox(DBGrid1.Canvas, Rect, true)
    else
      DrawGridCheckBox(DBGrid1.Canvas, Rect, false)
end;
</pre>

<p>Кроме этого, для скрытия текста в ячейках с CheckBox-ом от отображения значения при вводе с клавиатуры определите реакцию на событие OnColumnEnter: </p>
<pre>
procedure TfrmMain.DBGrid1ColEnter(Sender: TObject);
begin
  with TDBGrid(Sender) do
    if SelectedField.FieldName = 'Weight' then // Модифицируйте под себя
      Options := Options - [dgEditing]
    else
      Options := Options + [dgEditing]
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

