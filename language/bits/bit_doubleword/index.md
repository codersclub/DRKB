---
Title: Получение значения бита в двойном слове
Date: 21.05.2002
Author: Dimka Maslov, mainbox@endimus.ru
---


Получение значения бита в двойном слове
=======================================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Получение значения бита в двойном слове
     
    Функция возвращает значение бита с номером Index в двойном слове Value
     
    Зависимости: нет
    Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
    Copyright:   Dimka Maslov
    Дата:        21 мая 2002 г.
    ***************************************************** }
     
    function Bit(Value, Index: Integer): Boolean;
    asm
       bt eax, edx
       setc al
       and eax, 0FFh
    end;
