---
Title: Как удалить все файлы из Recent Documents?
Date: 01.01.2007
---


Как удалить все файлы из Recent Documents?
==========================================

::: {.date}
01.01.2007
:::

Для этого можно воспользоваться API функцией SHAddToRecentDocs:

    procedure TForm1.Button1Click(Sender: TObject);
    begin
    SHAddToRecentDocs(SHARD_PATH, 0);
    end;

Не забудьте включить ShlObj в Unit

Взято из <https://forum.sources.ru>
