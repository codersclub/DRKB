---
Title: Очистка строки (символьное значение числа) от пробелов, нулей и точки
Author: Виталий, center_sapr@mnogo.ru
Date: 26.04.2002
---


Очистка строки (символьное значение числа) от пробелов, нулей и точки
=====================================================================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Очистка строки (символьное значение числа) от пробелов, нулей и точки
     
    Функция возращает строку очищенную от символов: пробел, ноль, точка.
     
    Зависимости: нет
    Автор:       Виталий, center_sapr@mnogo.ru, Львов
    Copyright:   Witek
    Дата:        26 апреля 2002 г.
    ***************************************************** }
     
    unit Unit2;
     
    interface
     
    function StrFl(st: string): string;
     
    implementation
     
    function StrFl(st: string): string;
    label
      p1, p2, p3;
    var
      poz: Byte;
      k: integer;
      stt: string;
    begin
      k := Length(st);
      if k <= 1 then
        goto p2;
      p1:
      stt := Copy(st, 1, 1); {Очистка от пробелов}
      if stt = ' ' then
      begin
        st := Copy(st, 2, k - 1);
        k := k - 1;
        goto p1;
      end;
      stt := Copy(st, k, 1);
      if stt = ' ' then
      begin
        st := Copy(st, 1, k - 1);
        k := k - 1;
        goto p1;
      end;
      p3:
      poz := Pos('.', st); {Очистка от нулей}
      if poz = 0 then
        goto p2;
      stt := Copy(st, k, 1);
      if stt = '0' then
      begin
        st := Copy(st, 1, k - 1);
        k := k - 1;
        goto p3;
      end;
      if stt = '.' then {Очистка от точки}
      begin
        st := Copy(st, 1, k - 1);
      end;
      p2:
      StrFl := st;
    end;
     
    end.

Пример результатов: 
     
    //5.000  -> 5
    //5.001  -> 5.001
    //05.100 -> 05.1

