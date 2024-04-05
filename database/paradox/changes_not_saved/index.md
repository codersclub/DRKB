---
Title: Не сохраняются изменения в базе Paradox
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Не сохраняются изменения в базе Paradox
=======================================

Чтобы изменения сохранялись, нужно где-нибудь при закрытии главной формы
выполнить нижеследующие куски кода:

при открытой таблице:

    Table.FlushBuffers;

Для прочих:

    Table.Open; 
    Check(dbiSaveChanges(Table.Handle)); 
    Table.Close;

Чтобы сбросить кэш, можно еще после этого сделать:

    asm
      mov ah, $0D
      int $21
    end; 

