---
Title: Установка бита в ноль
Author: s-mike
Date: 01.01.2007
---


Установка бита в ноль
=====================

::: {.date}
01.01.2007
:::

Установка бита в ноль

    function BitOff(const val: longint; const TheBit: byte): LongInt;

    begin
      Result := val and ((1 shl TheBit) xor $FFFFFFFF);
    end;

Автор: s-mike

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------

    function BitOff(const val: longint; const TheBit: byte): LongInt; 

    begin
      Result := val and not (1 shl TheBit); 
    end; 

Автор: Yanis

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

    procedure ClearBit(SetWord, BitNum: Word);
    begin
      SetWord := SetWord or BitNum; { Устанавливаем бит }
      SetWord := SetWord xor BitNum; { Переключаем бит   }
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 
