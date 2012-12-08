---
Title: Перевод символа в верхний регистр для русского алфавита
Date: 01.01.2007
---


Перевод символа в верхний регистр для русского алфавита
=======================================================

::: {.date}
01.01.2007
:::

    function UpCaseRus(ch: Char): Char;
    asm
      CMP   AL,'a'
      JB    @@exit
      CMP   AL,'z'
      JA    @@Rus
      SUB   AL,'a' - 'A'
      RET
    @@Rus:
      CMP   AL,'я'
      JA    @@Exit
      CMP   AL,'а'
      JB    @@yo
      SUB   AL,'я' - 'Я'
      RET
    @@yo:
      CMP   AL,'?'
      JNE   @@exit
      MOV   AL,'?'
    @@exit:
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 
