---
Title: Как в байте информации выделить биты?
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Как в байте информации выделить биты?
=====================================

В Delphi используй операцию `and`, которая возвращает результат побитового
умножения. Пример: `a and $10` - выделить 4-ый бит. Если результат не
ноль - бит установлен.

То же самое, но на ассемблере. Это позволяет достичь максимальной
скорости выполнения.

    function GetBites(t, Mask: LongWord): LongWord;  
    asm
      mov eax, t;
      and eax, mask;
    end;

Эта функция возвращает `t and Mask`. Если необходимо выполнить сдвиг, то
применяется команда `shr`:

    function ShiftBites(t, Mask: LongWord; shift: byte): LongWord; 
    asm
      mov eax, t;
      mov cl, shift;
      shr eax;
      and eax, Mask;
    end;

Эта функция возвращает `(t shr shift) and Mask`. Если же ассемблер не
поможет, надо или переделывать алгоритм, или менять компьютер :))

