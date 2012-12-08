---
Title: Переключение состояния бита с единицы на ноль и наоборот
Author: s-mike
Date: 01.01.2007
---


Переключение состояния бита с единицы на ноль и наоборот
========================================================

::: {.date}
01.01.2007
:::

Переключение состояния бита с единицы на ноль и наоборот

    function BitToggle(const val: longint; const TheBit: byte): LongInt;

    begin
      Result := val xor (1 shl TheeBit);
    end;

Автор: s-mike

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------

    procedure ToggleBit(SetWord, BitNum: Word);
    begin
      SetWord := SetWord xor BitNum; { Переключаем бит   }
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
