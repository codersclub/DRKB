<h1>Очистить ячейки в TStringGrid</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
 var
   i, k: Integer;
 begin
   with StringGrid1 do
     for i := 0 to ColCount - 1 do
       for k := 0 to RowCount - 1 do
         Cells[i, k] := '';
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
<hr />
<pre>
 // Many times faster! 
procedure TForm1.Button2Click(Sender: TObject);
 var
   I: Integer;
 begin
   for I := 0 to StringGrid1.RowCount - 1 do
     StringGrid1.Rows[I].Clear();
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
