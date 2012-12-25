---
Title: Определение поддержки SSE2
Date: 01.01.2007
---

Определение поддержки SSE2
==========================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Определение поддержки SSE2
     
    Зависимости: Types
    Автор:       Gua, gua@ukr.net, ICQ:141585495, Simferopol
    Copyright:   Unknown
    Дата:        17 июля 2002 г.
    ***************************************************** }
     
    function CheckSSE2: Boolean;
    var
      TempCheck: dword;
    begin
      TempCheck := 1;
      asm
      push ebx
      mov eax,1
      db $0F,$A2
      test edx,$4000000
      jz @NOSSE2
      mov edx,0
      mov TempCheck,edx
      @NOSSE2:
      pop ebx
      end;
      CheckSSE2 := (TempCheck = 0);
    end;
