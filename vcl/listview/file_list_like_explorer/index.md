---
Title: Получить список файлов в ListView как в проводнике
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Получить список файлов в ListView как в проводнике
==================================================

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

