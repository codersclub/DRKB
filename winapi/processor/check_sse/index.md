---
Title: Определение поддержки SSE и SSE2
Author: Gua, gua@ukr.net
Date: 17.07.2002
---

Определение поддержки SSE и SSE2
=========================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Определение поддержки SSE
     
    Зависимости: Types
    Автор:       Gua, gua@ukr.net, ICQ:141585495, Simferopol
    Copyright:   Unknown
    Дата:        17 июля 2002 г.
    ***************************************************** }
     
    function CheckSSE: Boolean;
    var
      TempCheck: dword;
    begin
      TempCheck := 1;
      asm
        push ebx
        mov eax,1
        db $0F,$A2
        test edx,$2000000
        jz @NOSSE
        mov edx,0
        mov TempCheck,edx
      @NOSSE:
        pop ebx
      end;
      CheckSSE := (TempCheck = 0);
    end;



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
