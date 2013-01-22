---
Title: Удаление лишних пробелов в строке
Author: Vit
Date: 01.01.2007
---


Удаление лишних пробелов в строке
=================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> удаление лишних пробелов в строке
     
    удаляет из строки лишние пробелы без использования всяких указателей и т.д.
     
    Зависимости: стандартные модули
    Автор:       Артем, boss1999@mail.ru, москва
    Copyright:   собственное описание (Артем)
    Дата:        24 сентября 2003 г.
    ***************************************************** }
     
    {процедура удаления лишних пробелов в строке (см. function Sha_SpaceCompress)}
    var
      c, i: integer;
      stt, st, st1: string;
    begin
      c := 0;
      st := edit1.Text;
     
      for i := 1 to Length(st) do
      begin
     
        stt := copy(st, i, 1);
        if (stt = ' ') and (c >= 1) then
        begin
          st1 := st1;
          c := c + 1;
        end
        else if (stt = ' ') and (c = 0) then
        begin
          c := c + 1;
          st1 := st1 + stt;
        end
        else if (stt <> ' ') then
        begin
          c := 0;
          st1 := st1 + stt;
        end
      end;
     
      edit2.text := st1;
    end;

------------------------------------------------------------------------

    Function DeleteUselessSpaces(s:String):string;

    begin
      Repeat
        Result:=s;
        s:=StringReplace(Result,'  ',' ',[rfReplaceAll]); //заменяем все двойные пробелы на одинарные
      Until Result=s; //повторяем до тех пор пока есть двойные пробелы 
    end;

Автор: Vit
