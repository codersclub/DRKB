---
Title: Как очистить пункт меню Документы кнопки «Пуск»?
Date: 01.01.2007
---

Как очистить пункт меню Документы кнопки «Пуск»?
================================================

::: {.date}
01.01.2007
:::

Вызовите Windows API функцию SHAddToRecentDocs() передав nil вместо
имени файла в качестве параметра.

    uses ShlOBJ;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
          SHAddToRecentDocs(SHARD_PATH, nil);
    end;

Взято из <https://forum.sources.ru>
