---
Title: Как очистить пункт меню «Документы» кнопки «Пуск»?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Как очистить пункт меню «Документы» кнопки «Пуск»?
================================================

Вызовите Windows API функцию SHAddToRecentDocs()
передав nil вместо имени файла в качестве параметра.

    uses ShlOBJ;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      SHAddToRecentDocs(SHARD_PATH, nil);
    end;

