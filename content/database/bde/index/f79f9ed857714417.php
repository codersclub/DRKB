<h1>Как добиться верной работы фильтра на запросах и на неиндексированных таблицах</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Nomadic</div>

<p>(Т.е. при работе программы наблюдалась следующая картина: в результате очередной фильтрации оставалось видно 4 записи из восьми. Добавляем букву к фильтру, остается, допустим, две. Убираем букву, которую только что добавили, в гриде все равно видно только две записи)</p>

<p>Эта проблема была в Delphi 3.0 только на TQuery, а в Delphi 3.01 появилась и в TTable. Лечится так (простой пример):</p>

<pre class="delphi">
procedure TMainForm.Edit1Change(Sender: TObject);
begin
  if length(Edit1.Text) &gt; 0 then
  begin
    Table1.Filtered := TRUE;
    UpdateFilter(Table1);
  end
  else
    Table1.Filtered := FALSE;
end;
 
procedure TMainForm.UpdateFilter(DataSet: TDataSet);
var
  FR: TFilterRecordEvent;
begin
  with DataSet do
  begin
    FR := OnFilterRecord;
    if Assigned(FR) and Active then
    begin
      DisableControls;
      try
        OnFilterRecord := nil;
        OnFilterRecord := FR;
      finally
        EnableControls;
      end;
    end;
  end;
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
