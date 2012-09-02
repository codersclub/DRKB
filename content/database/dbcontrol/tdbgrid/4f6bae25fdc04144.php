<h1>Как работать с выделенными запясями в TDBGrid?</h1>
<div class="date">01.01.2007</div>


<pre>
{
 In the "Object Inspector" set your DBGrid's Option for dgMultiSelect = True.
 The Grid_Edit function calls for each selected DBGrid-Row a data-processing
 function.
 Return value is the number of processed rows.
}
 
function TForm1.Grid_Edit(dbgIn: TDBGrid; qryIn: TQuery): Longint;
  // declared in the private section
begin
  Result := 0;
  with dbgIn.DataSource.DataSet do
  begin
    First;
    DisableControls;
    try
      while not EOF do
      begin
        if (dbgIn.SelectedRows.CurrentRowSelected = True) then
        begin
          { +++ Call here the data-processing function +++
 
          }
          Inc(Result);
        end;
        Next;
      end;
    finally
      EnableControls;
    end;
  end;
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  Form1.Caption := 'Processed: ' + IntToStr(Grid_Edit(DBGrid1, Query1));
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
