---
Title: Как узнать имя компьютера?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как узнать имя компьютера?
==========================

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

