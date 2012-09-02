<h1>Проверить, выделена ли ячейка TStringGrid</h1>
<div class="date">01.01.2007</div>


<pre>
function IsCellSelected(StringGrid: TStringGrid; X, Y: Longint): Boolean;
 begin
   Result := False;
   try
     if (X &gt;= StringGrid.Selection.Left) and (X &lt;= StringGrid.Selection.Right) and
       (Y &gt;= StringGrid.Selection.Top) and (Y &lt;= StringGrid.Selection.Bottom) then
       Result := True;
   except
   end;
 end;
 
 procedure TForm1.Button1Click(Sender: TObject);
 begin
   if IsCellSelected(stringgrid1, 2, 2) then
     ShowMessage('Cell (2,2) is selected.');
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>

