---
Title: Аналог функции С memcmp
Author: Dennis Passmore 
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Аналог функции С memcmp
=======================

Я создал следующие две функции, существенно повышающие произвотельность
в приложениях, активно работающих с данными. Вам нужно всего-лишь
обеспечить контроль типов и границ допустимого диапазона, все остальное
они сделают с любым типом данных лучше нас :-) .

    function Keys_are_Equal(var OldRec, NewRec;
    KeyLn : word): boolean; assembler;
    asm
      PUSH    DS
      MOV     AL,01
      CLD
      LES     DI,NewRec
      LDS     SI,OldRec
      MOV     CX,KeyLn
      CLI
      REPE    CMPSB
      STI
      JZ      @1
      XOR     AL,AL
      @1:
      POP     DS
    end;
     
    function First_Key_is_Less(var NewRec, OldRec; Keyln : word): boolean; assembler;
    asm
      PUSH    DS
      MOV     AL,01
      CLD
      LES     DI,NewRec
      LDS     SI,OldRec
      MOV     CX,KeyLn
      CLI
      REPE    CMPSB
      STI
      JZ      @5
      JGE     @6
      @5: XOR     AL,AL
      @6: POP     DS
    end;

------
**Примечание от Jin X:**

Примеры приведены для 16-битного Pascal\'я и не могут использоваться в
32-битном Delphi!

Зато можно делать так:

    { Возвращает -1 при X<Y, 0 при X=Y, 1 при X>Y. }
    { Сравнение идёт по DWord'ам, будто сравнивается массив чисел Integer или Cardinal, }
    { т.е. 01 02 03 04 05 06 07 08 > 01 02 03 04 05 06 08 07, }
    { т.к. 04030201 = 04030201, но 08070605 > 07080605 (hex). }
    { Однако, если Size and 3 <> 0, то последние Size mod 4 байт сравниваются побайтно! }

    function memcmp(const X, Y; Size: DWord): Integer;
    asm
      mov esi,X
      mov edi,Y
      mov ecx,Size
      mov dl,cl
      and dl,3
      shr ecx,2
      xor eax,eax
      rep cmpsd
      jb @@less
      ja @@great
      mov cl,dl
      rep cmpsb
      jz @@end
      ja @@great
     @@less:
      dec eax
      jmp @@end
     @@great:
      inc eax
     @@end:
    end;
