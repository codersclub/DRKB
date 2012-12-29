---
Title: Проверка на наличие числа в массиве
author: Dimka Maslov, mainbox@endimus.ru
Date: 28.05.2002
---


Проверка на наличие числа в массиве
===================================

::: {.date}
28.05.2002
:::

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Проверка наличия числа в массиве
     
    Функция проверяет, находится ли число N в массиве Values
     
    Зависимости: нет
    Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
    Copyright:   Dimka Maslov
    Дата:        28 мая 2002 г.
    ********************************************** }
     
    function Among(N: Integer; const Values: array of Integer): LongBool;
    asm
       push ebx
       xor ebx, ebx
    @@10:
       test ecx, ecx
       jl @@30
       cmp eax, [edx]
       jne @@20
       not ebx
       jmp @@30
    @@20:
       add edx, 4
       dec ecx
       jmp @@10
    @@30:
       mov eax, ebx
       pop ebx
    end; 
     

Пример использования:

    Among(N, [1, 2, 3, 4, 5]) 
