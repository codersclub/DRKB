---
Title: Установка бита в ноль
Author: s-mike
Date: 01.01.2007
---


Установка бита в ноль
=====================

Вариант 1:

Author: s-mike

Source: <https://forum.sources.ru>

Установка бита в ноль

    function BitOff(const val: longint; const TheBit: byte): LongInt;

    begin
      Result := val and ((1 shl TheBit) xor $FFFFFFFF);
    end;

------------------------------------------------------------------------

Вариант 2:

Author: Yanis

Source: Vingrad.ru <https://forum.vingrad.ru>

    function BitOff(const val: longint; const TheBit: byte): LongInt; 

    begin
      Result := val and not (1 shl TheBit); 
    end; 

------------------------------------------------------------------------

Вариант 3:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    procedure ClearBit(SetWord, BitNum: Word);
    begin
      SetWord := SetWord or BitNum; { Устанавливаем бит }
      SetWord := SetWord xor BitNum; { Переключаем бит   }
    end;

