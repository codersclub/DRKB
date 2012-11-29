Функции для выделения, перераспределения и освобождения памяти
==============================================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Функции для выделения/перераспределения/освобождения памяти
     
    Модуль содержит функции для работы с блоками памяти.
     
    AllocateMem - выделяет блок памяти из Count записей по RecSize байт, возвращает
    адрес выделенного блока памяти в случае успеха или nil в случае ошибки.
     
    ReallocateMem - устанавливает новый размер блока памяти, выделенного функцией
    AllocateMem. В качестве параметра Pointer можт быть использован как
    типизированный так и нетипизированный указатель.
     
    DeallocateMem - освобождает память, выделенную функциями AllocateMem или
    ReallocateMem. В качестве параметра Pointer можт быть использован как
    типизированный так и нетипизированный указатель.
     
    MemSize - возвращает размер блока памяти, выделенного функциями AllocateMem или
    ReallocateMem.
     
    Зависимости: Windows
    Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
    Copyright:   Dimka Maslov
    Дата:        21 мая 2002 г.
    ***************************************************** }
     
    unit MemFuncs;
     
    uses Windows;
     
    interface
     
    function AllocateMem(Count: Integer; RecSize: Integer): Pointer;
    procedure ReallocateMem(var Pointer; Count: Integer; RecSize: Integer = 1);
    procedure DeallocateMem(var Pointer);
    function MemSize(P: Pointer): Integer;
     
    implementation
     
    function LocalHandle; external kernel32 name 'LocalHandle';
     
    function AllocateMem(Count: Integer; RecSize: Integer = 1): Pointer;
    asm
       test eax, eax
       jle @@10
       test edx, edx
       jle @@10
       imul edx
       push eax
       push LHND
       call LocalAlloc
       push eax
       call LocalLock
       ret
    @@10:
       xor eax, eax
    end;
     
    procedure ReallocateMem(var Pointer; Count: Integer; RecSize: Integer = 1);
    asm
       push ebx
       mov ebx, eax
       mov eax, [ebx]
       test eax, eax
       jnz @@10
       mov eax, edx
       mov edx, ecx
       call AllocateMem
       mov [ebx], eax
       pop ebx
       ret
    @@10:
       push ecx
       push edx
       push eax
       call LocalHandle
       pop edx
       pop ecx
       test eax, eax
       jnz @@20
       pop ebx
       ret
    @@20:
       push eax
       mov eax, edx
       imul ecx
       mov edx, eax
       pop eax
       push LHND
       push edx
       push eax
       call LocalRealloc
       push eax
       call LocalLock
       mov [ebx], eax
       pop ebx
    end;
     
    procedure DeallocateMem(var Pointer);
    asm
       push ebx
       mov ebx, eax
       mov eax, [ebx]
       test eax, eax
       jz @@10
       push eax
       call LocalHandle
       test eax, eax
       jz @@10
       push eax
       push eax
       call LocalUnlock
       call LocalFree
    @@10:
       xor eax, eax
       mov [ebx], eax
       pop ebx
    end;
     
    function MemSize(P: Pointer): Integer;
    asm
       test eax, eax
       jnz @@10
       ret
    @@10:
       push eax
       call LocalHandle
       test eax, eax
       jnz @@20
       ret
    @@20:
       push eax
       call LocalSize
    end;
     
    end.
