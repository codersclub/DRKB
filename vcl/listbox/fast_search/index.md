---
Title: Как осуществить быстрый поиск в TListBox?
Date: 01.01.2007
---


Как осуществить быстрый поиск в TListBox?
=========================================

::: {.date}
01.01.2007
:::

Очень просто, смотри пример...

считаем, сто есть поле Edit1, в котором набираем текст, и ListBox, в
котором ищем нужную строку, (как в Нelp).

    procedure TForm1.Edit1Change(Sender: TObject);
    begin
      ListBox1.Perform(LB_SELECTSTRING,-1,longint(Pchar(Edit1.text)));
    end;

Взято из <https://forum.sources.ru>
