---
Title: Печать
Date: 01.01.2007
---


Печать
======

::: {.date}
01.01.2007
:::

Печать

После всех настроек и просмотра печати можно переходить непосредственно
к печати документа. Для этого будем использовать метод PrintOut объекта
\"Лист\" коллекции Sheets. В функции Print в качестве аргументов
передаем номер или имя листа и количество копий для печати.

::: {style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;"}
    Function Print (sheet:variant;copies:integer):boolean;
    begin
     Print:=true;
     try
      E.ActiveWorkbook.Sheets.Item
       [sheet].PrintOut(Copies:=copies);
     except
      Print:=false;
     end;
    End;

 

Для расширения возможностей печати можем использовать весь набор
аргументов метода PrintOut. Например, для задания печати 2-х копий со
2-й по 3-ю страницу используем метод и набор следующих аргументов:
PrintOut(from:=2, To:=3, Copies:=2);
:::