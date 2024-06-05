---
Title: Очистить переменную в оперативной памяти
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Очистить переменную в оперативной памяти
========================================

Если вы хотите стереть переменную, чтобы никакая другая программа больше не могла прочитать ее из памяти, просто используйте эту функцию:

    // ZeroMemory(Address of the variable, Size of the variable); 
    ZeroMemory(Addr(yourVar), SizeOf(yourVar));
    ZeroMemory(Addr(yourStr), Length(yourStr));

Очень полезная штука, если вы запросили пароль и хотите, чтобы никто другой не смог его получить.

