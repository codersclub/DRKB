---
Title: Перевод символа в нижний регистр для русского алфавита
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Перевод символа в нижний регистр для русского алфавита
======================================================

    function LoCaseRus( ch : Char ) : Char;
    {Перевод символа в нижний регистр для русского алфавита}
    asm
      CMP          AL,'A'
      JB              @@exit
      CMP          AL,'Z'
      JA              @@Rus
      ADD          AL,'a' - 'A'
      RET
    @@Rus:
      CMP          AL,'Я'
      JA              @@Exit
      CMP          AL,'А'
      JB              @@yo
      ADD          AL,'я' - 'Я'
      RET
    @@yo:
      CMP          AL,'?'
      JNE            @@exit
      MOV          AL,'?'
    @@exit:
    end;

