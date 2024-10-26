---
Title: Как добавить файл в меню Пуск / Документы?
Author: Даниил Карапетян (delphi4all@narod.ru)
Date: 01.01.2007
---

Как добавить файл в меню Пуск / Документы?
==========================================

Эта программа добавляет файл "File.txt" в "Пуск/Документы".

    uses ShlOBJ;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      SHAddToRecentDocs(SHARD_PATH, PChar('File.txt'));
    end;

Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)
