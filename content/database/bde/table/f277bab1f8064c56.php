<h1>Как сохранить содержимое таблицы в текстовый файл?</h1>
<div class="date">01.01.2007</div>


<p>Эти небольшие функции анализирую таблицу и записывают её содержимое в TStringList. А затем просто сохраняют в файл. </p>
<pre>
procedure DatasetRecordToInfFile(aDataset: TDataSet; aStrList: TStrings);
var
  i: integer;
begin
  for i := 0 to (aDataset.FieldCount-1) do
    aStrList.Add(aDataset.Fields[i].FieldName + '=' +
    aDataset.Fields[i].AsString);
end;
 
procedure DatasetToInfFile(aDataset: TDataSet; aStrList: TStrings);
begin
  aDataSet.First;
  while not aDataSet.EOF do
  begin
    DatasetRecordToInfFile(aDataset,aStrList);
    aDataSet.Next;
  end;
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  DatasetRecordToInfFile(Table1,Memo1.Lines);
end;
 
procedure TForm1.Button2Click(Sender: TObject);
begin
  DatasetToInfFile(Table1,Memo1.Lines);
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
