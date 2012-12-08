---
Title: Как добавить документ в меню «Пуск \> Документы»?
Date: 01.01.2007
---


Как добавить документ в меню «Пуск \> Документы»?
=================================================

::: {.date}
01.01.2007
:::

Используйте функцию SHAddToRecentDocs.

    uses ShlOBJ;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
       s : string;
    begin
       s := 'C:\DownLoad\ntkfaq.html';
       SHAddToRecentDocs(SHARD_PATH, pChar(s));
    end;

Взято из <https://forum.sources.ru>
