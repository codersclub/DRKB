---
Title: Переключение состояния бита с единицы на ноль и наоборот
Author: s-mike
Date: 01.01.2007
---


Переключение состояния бита с единицы на ноль и наоборот
========================================================

Вариант 1:

Author: s-mike

Source: <https://forum.sources.ru>

    function BitToggle(const val: longint; const TheBit: byte): LongInt;

    begin
      Result := val xor (1 shl TheeBit);
    end;

------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    procedure ToggleBit(SetWord, BitNum: Word);
    begin
      SetWord := SetWord xor BitNum; { Переключаем бит   }
    end;


