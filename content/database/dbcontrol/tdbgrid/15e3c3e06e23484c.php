<h1>Выделить все поля в TDBGrid?</h1>
<div class="date">01.01.2007</div>


<pre>
function GridSelectAll(Grid: TDBGrid): Longint;
begin
  Result := 0;
  Grid.SelectedRows.Clear;
  with Grid.DataSource.DataSet do
  begin
    First;
    DisableControls;
    try
      while not EOF do
      begin
        Grid.SelectedRows.CurrentRowSelected := True;
        Inc(Result);
        Next;
      end;
    finally
      EnableControls;
    end;
  end;
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  GridSelectAll(DBGrid1);
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
