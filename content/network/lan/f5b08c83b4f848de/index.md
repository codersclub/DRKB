---
Title: Как узнать имя компьютера?
Date: 01.01.2007
---


Как узнать имя компьютера?
==========================

::: {.date}
01.01.2007
:::

Чтобы узнать имя, идентифицирующее компьютер в сети, на котором запущена
Ваша программа, можно воспользоваться следующей функцией:

    uses Windows;
     
    function GetComputerNetName: string;
    var
     buffer: array[0..255] of char;
     size: dword;
    begin
     size := 256;
     if GetComputerName(buffer, size) then
       Result := buffer
     else
       Result := ''
    end;

Взято из <https://forum.sources.ru>
