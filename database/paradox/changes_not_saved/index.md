---
Title: Не сохраняются изменения в базе Paradox
Date: 01.01.2007
---


Не сохраняются изменения в базе Paradox
=======================================

::: {.date}
01.01.2007
:::

Где-нибудь при закрытии главной формы выполните нижеследующие куски
кода:

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

Взято с <https://delphiworld.narod.ru>
