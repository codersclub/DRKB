---
Title: Очистить переменную в оперативной памяти
Date: 01.01.2007
---


Очистить переменную в оперативной памяти
========================================

::: {.date}
01.01.2007
:::

If you want to erase a variable, that no other program can read it out
of the memory anymore, just use this function:

    ZeroMemory(Addr(yourVar), SizeOf(yourVar));
    ZeroMemory(Addr(yourStr), Length(yourStr));
    // ZeroMemory(Address of the variable, Size of the variable); 

Very usefull, if you asked for a password and you want, that nobody
other can get it.

Взято с сайта: <https://www.swissdelphicenter.ch>
