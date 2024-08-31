---
Title: Как удалить все файлы из Recent Documents?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как удалить все файлы из Recent Documents?
==========================================

Для этого можно воспользоваться API функцией `SHAddToRecentDocs`:

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      SHAddToRecentDocs(SHARD_PATH, 0);
    end;

Не забудьте включить ShlObj в Unit

