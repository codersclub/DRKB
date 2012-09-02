<h1>Создание автоинкрементного поля SQL запросом?</h1>
<div class="date">01.01.2007</div>


<pre>
{
  Lets say that we wish to create a fallawing number (Autoincrese) of an item,
  without using the AutoIncrese filed.
  This is usfull when for example there is more users from the same IP that log
  in or any other things that you wish.
 
  This example will show you how to do it with some checking of filled data,
  but it can be done anyway you wish.
 
  You need a Table with at least 2 fileds with number casting, and a TQUERY component.
}
 
 
function TForm1.GetNextNumber : integer;
begin
 qryMain.Active := False;
 qryMain.SQL.Clear;
 qryMain.SQL.Add('Select Max(FieldToIncrease) from tblMain where (Cheking &gt;=1);');
 qryMain.Active := True; //We executed the query
 
 if qryMain.RecordCount &gt;= 0 then
  result := qryMain.FieldByName('FieldToIncrese').AsInteger +1;
 else result := 1;
end;
 
...
 
procedure TForm1.SetNextNumber;
begin
 //You must first see if the table is in insert/update mode before using this procedure.
 tblMain.FieldByName('FieldToIncrese').AsInteger := GetNextNumber;
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
