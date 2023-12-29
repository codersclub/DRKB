---
Title: Чтение OLE из BLOB-поля Paradox
Author: Eryk
Date: 01.01.2007
---


Чтение OLE из BLOB-поля Paradox
===============================

::: {.date}
01.01.2007
:::

Автор: Eryk

...после моих дискуссий с людьми из службы технической поддержки
Borland вывод один \-- это невозможно!

Попробуйте так:

    procedure TForm1.SpeedButton1Click(Sender: TObject);
    var
      b: TBlobStream;
    begin
      try
        b := TBlobStream.Create((Table1.FieldByName('OLE') as TBlobField),bmRead);
        OLEContainer1.LoadFromStream(b);
      finally
        b.free;
      end;
    end;

...и:

    procedure TForm1.SpeedButton2Click(Sender: TObject);
    var
      b: TBlobStream;
    begin
      try
        Table1.Insert;
        b := TBlobstream.Create((Table1.FieldByName('OLE') as TBlobField),bmReadWrite);
        OLEContainer1.SaveToStream(b);
        Table1.Post;
      finally
        b.free;
      end;
    end;

Я, кажется, припоминаю несколько ошибок GPFs с этим кодом, но это,
вероятно, связано с тем, что я использую WinNT с другим распределением
памяти... тем не менее, основные функции работали как положено (т.е.
данные сохранялись и загружались). Основная специфика проявилась в том,
что PdoxWIN не смог прочесть данные TOLEContainer. Но это результаты
моих экспериментов и предположений, исходя из которых PdoxWIN ожидает
8-байтовый заголовок BLOB-поля, который ему просто не дает
TOLEContainer... если это так, то это легко обойти.

Взято с <https://delphiworld.narod.ru>
