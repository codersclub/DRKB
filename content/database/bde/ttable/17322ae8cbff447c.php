<h1>Как обновить TQuery не потеряв при этом текущей записи?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure RefreshQuery(AQuery : TQuery; const FieldsForSearch: String); 
var 
  AList : TList; 
  AVarArray : Variant; 
  i : Byte; 
begin 
  AList := TList.Create; 
  try 
    AQuery.GetFieldList(AList, FieldsForSearch); 
    AVarArray := VarArrayCreate([0, AList.Count - 1], varVariant); 
    for i := 0 to Pred(AList.Count) do 
      AVarArray[i] := TField(AList.Items[i]).AsVariant; 
    AQuery.Close; 
    AQuery.Open; 
    AQuery.Locate(FieldsForSearch, AVarArray, []); 
  finally 
    AList.Free; 
    AVarArray.Free;p 
  end; 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

