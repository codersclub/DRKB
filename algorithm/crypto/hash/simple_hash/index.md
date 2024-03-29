---
Title: Вычисление простого хеш-кода для блока данных
Author: Алексей Вуколов, vuk@fcenter.ru
Date: 18.04.2002
---


Вычисление простого хеш-кода для блока данных
=============================================

Вычисление значения простой хеш-функции (xor + циклический сдвиг) для блока данных.

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Вычисление простого хеш-кода для блока данных
     
    Вычисляет значение простой хеш-функции (xor + циклический сдвиг) для блока 
    данных.
     
    Описание параметров:
    Data - указатель на блок данных
     
    DataSize - размер блока
     
    Возвращаемое значение - значение хеш-функции
     
    Зависимости: нет
    Автор:       vuk, vuk@fcenter.ru
    Copyright:   Алексей Вуколов
    Дата:        18 апреля 2002 г.
    ********************************************** }
     
    function CalcHash(Data : pointer; DataSize : integer) : integer; register;
    asm
      push ebx
      push esi
      push edi
      mov esi, Data
      xor ebx, ebx
      or esi, esi
      jz @@Exit
      mov edx, DataSize
      or edx,edx
      jz @@Exit
      xor ecx,ecx
     
    @@Cycle:
      xor eax,eax
      mov al,[esi]
      inc esi
      rol eax,cl
      xor ebx,eax
      inc ecx
      dec edx
      jnz @@Cycle
     
    @@Exit:
      mov eax,ebx
      pop edi
      pop esi
      pop ebx
    end; 

Пример использования:

    //вычисление хеш-кода для строки
     
    var
       i : integer;
       s : string;
    ...
    s := 'test';
    i := CalcHash(pointer(S), length(S)); 
