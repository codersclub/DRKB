<h1>Получить список файлов в ListView как в проводнике</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  ListItem: TListItem;
  sr: tsearchrec;
  NewColumn: TListColumn;
begin
  NewColumn := ListView1.Columns.Add;
  NewColumn := ListView1.Columns.Add; // добавдяются колонки
  if FindFirst('*.*', faAnyFile - faDirectory - faVolumeId, sr) = 0 then
  begin
    ListItem := ListView1.Items.Add; // создается объект
    ListItem.Caption := sr.name;
    ListItem.SubItems.Add(inttostr(sr.size));
    ListItem.SubItems.Add(datetimetostr(FileDateToDateTime(sr.time)));
    while FindNext(sr) = 0 do
    begin
      ListItem := ListView1.Items.Add;
      ListItem.Caption := sr.name;
      ListItem.SubItems.Add(inttostr(sr.size));
      ListItem.SubItems.Add(datetimetostr(FileDateToDateTime(sr.time)));
    end;
    FindClose(sr);
  end;
end;
 
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
