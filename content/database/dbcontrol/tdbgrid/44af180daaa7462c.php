<h1>Как зафиксировать один или несколько столбцов в TDBGrid с возможностью навигации по этим столбцам?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TDbGridEx.ColEnter;
 
procedure ProcessColEnter;
begin
 // -----------------------------------------------------------
 if (SelectedIndex  _Mark) then
   begin
     ColumnMoved(Columns.Count, StaticCol + 1);
     SelectedField := Fields[StaticCol];
   end;
   Exit;
 end;
 
 // -----------------------------------------------------------
 if (SelectedIndex &gt; StaticCol) then
 begin
 
   if _LastSelectedIndex = StaticCol then
   begin
     if _Mark = Columns[SelectedIndex].Title.Caption then
 
     begin
       ColumnMoved(StaticCol + 1, Columns.Count);
       SelectedField := Fields[Columns.Count - 1];
     end
       else
     begin
       ColumnMoved(StaticCol + 1, Columns.Count);
       SelectedField := Fields[StaticCol];
     end;
   end;
 
 end;
end;
 
begin
 if (_EntryCol &gt; 0) or _MouseDown or (StaticCol = 0) then
 begin
   _MouseDown := FALSE;
 end else
 begin
   inc(_EntryCol);
   ProcessColEnter;
   dec(_EntryCol);
 end;
 
 if Assigned(OnColEnter) then OnColEnter(Self);
 
 _LastSelectedIndex := SelectedIndex;
end;
</pre>

<p class="author">Автор: Ramil Galiev</p>
<p>(2:5085/33.11)</p>

<p class="author">Автор: StayAtHome</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

