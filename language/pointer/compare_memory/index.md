---
Title: Быстрое сравнение памяти
Author: Dennis Passmore
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Быстрое сравнение памяти
========================

> Я ищу функцию, которая была бы эквивалентом сишной функции memcmp.

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

    function First_Key_is_Less(var NewRec, OldRec;
    Keyln : word): boolean; assembler;
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

