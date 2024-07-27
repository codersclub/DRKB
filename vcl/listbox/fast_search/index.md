---
Title: Как осуществить быстрый поиск в TListBox?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как осуществить быстрый поиск в TListBox?
=========================================

Очень просто, смотри пример...

считаем, сто есть поле Edit1, в котором набираем текст, и ListBox, в
котором ищем нужную строку, (как в Нelp).

    procedure TForm1.Edit1Change(Sender: TObject);
    begin
      ListBox1.Perform(LB_SELECTSTRING,-1,longint(Pchar(Edit1.text)));
    end;

