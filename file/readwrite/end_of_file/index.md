---
Title: Переместиться в конец файла
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Переместиться в конец файла
===========================

    { прыгаем в конец (eof) }
    procedure gotoeof (f : file);
    begin
      { перемещаемся в начало }
      seek (f, 0);
      { перемещаемся вперед на "x" количество байт,
        в нашем случае это размер файла! }
      seek (f, filesize(f));
    end; {gotoeof}

