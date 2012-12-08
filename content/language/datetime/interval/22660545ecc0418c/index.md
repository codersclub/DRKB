---
Title: Получение целого числа часов от начала суток
Date: 01.01.2007
---


Получение целого числа часов от начала суток
============================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Получение целого числа часов от начала суток
     
    Возвращает целое число часов от начала суток.
    Пример: для "11:25:00" будет возвращено значение "11"
     
    Зависимости: System, SysUtils
    Автор:       savva, savva@nm.ru, ICQ:126578975, Орел
    Copyright:   Сапронов Алексей (Savva)
    Дата:        6 июня 2002 г.
    ***************************************************** }
     
    function GetСurrentHour: integer;
    begin
      result := Round(Time * 24);
    end;