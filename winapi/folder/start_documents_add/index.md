---
Title: Как добавить документ в меню «Пуск \> Документы»?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как добавить документ в меню «Пуск \> Документы»?
=================================================

Используйте функцию SHAddToRecentDocs.

    uses ShlOBJ;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
       s : string;
    begin
       s := 'C:\DownLoad\ntkfaq.html';
       SHAddToRecentDocs(SHARD_PATH, pChar(s));
    end;

