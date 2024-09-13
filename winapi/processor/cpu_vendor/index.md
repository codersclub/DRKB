---
Title: Определение фирмы-производителя CPU
Author: Gua, fbsdd@ukr.net
Date: 03.05.2002
---

Определение фирмы-производителя CPU
===================================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Определение фирмы производителя CPU
     
    Зависимости: нет
    Автор:       Gua, fbsdd@ukr.net, ICQ:1411585495, Simferopol
    Copyright:
    Дата:        03 мая 2002 г.
    ***************************************************** }
     
    type
      TVendor = array[0..11] of char;
     
      .........................
     
    function GetCPUVendor: TVendor; assembler; register;
    asm
      PUSH EBX {Save affected register}
      PUSH EDI
      MOV EDI,EAX {@Result (TVendor)}
      MOV EAX,0
      DW $A20F {CPUID Command}
      MOV EAX,EBX
      XCHG EBX,ECX {save ECX result}
      MOV ECX,4
    @1:
      STOSB
      SHR EAX,8
      LOOP @1
      MOV EAX,EDX
      MOV ECX,4
    @2:
      STOSB
      SHR EAX,8
      LOOP @2
      MOV EAX,EBX
      MOV ECX,4
    @3:
      STOSB
      SHR EAX,8
      LOOP @3
      POP EDI {Restore registers}
      POP EBX
    end;
