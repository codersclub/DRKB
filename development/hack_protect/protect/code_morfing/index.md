---
Title: Пример программы на Delphi, которая морфирует во время работы свой код
Author: Нуржанов Аскар (NikNet\_), NikNet@yandex.ru
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Пример программы на Delphi, которая морфирует во время работы свой код
======================================================================

Пример программы на DELPHI которая морфирует во время работы свой код и
при этом не имеет секции импорта.

Пример также показывает, как сделать программу очень маленькой хоть не
на максимум, но предельно! После компиляций EXE весит 800 байт.

    unit Demo;
     
    {
     Автор: Нуржанов Аскар
     Email: NikNet@yandex.ru
     Сайт : NikNet.narod.ru
    }
     
    interface
     
    Procedure EntryCode;
     
     
    implementation
     
     
    Procedure EntryCode;
     
     function _DeltaOfs:cardinal;stdcall;
     asm
            call @get_eip
         @get_eip:
            pop  eax
            sub  eax, offset @get_eip
     end
     function _Library:cardinal;stdcall;
     asm
       @FreeLibrary               : dd 078A25FBBh  // 00
       @GetProcAddress            : dd 0F2509B84h  // 04
       @LoadLibraryA              : dd 0A412FD89h  // 08
       @_ENDLIB                   : dd 0FFFFFFFFh  // 12
     end
     procedure _CalcHashFunction;
     asm
            lea     edi, dword ptr [_Library]
            push    ebx
            push    ebp
            mov     ebp, esp
            xchg    eax, ebx
            mov edx, [ebx + 3ch]        // PE
            mov esi, [ebx + edx + 78h]  // Export Table RVA
            lea esi, [ebx + esi + 18h]  // Export Table VA+18h
            lodsd
            xchg    eax, ecx            // NumberOfNames
            lodsd                       // AddressOfFunctions
            push    eax
            lodsd                       // AddressOfNames
            add eax, ebx
            xchg    eax, edx
            lodsd                       // AddressOfNameOrdinals
            add eax, ebx
            push    eax
            mov esi, edx                // ESI - указывает на начало таблицы экспорта
     @search_api_name:
            lodsd                       // Переходим на Export Name Table
            add eax, ebx                // eax - Находится первая буква имений ф-ций
            xor edx, edx                // обнулим регистр EDX
     @calc_hash:
            rol     edx,3
            xor dl,byte [eax]           // xor dl with current character
            inc eax                     // character shift
            cmp byte [eax], 0           // is we in the endof chain?
            jnz     @calc_hash
            mov eax, [esp]              // AddressOfNameOrdinals
            add dword [esp], 2          // Move to next ordinal word
     
     @ok_hash:
            cmp [edi], edx
            jnz @SkipHash
            movzx   eax, word [eax]     // Name ordinal
            shl eax, 2                  // Multiply by 4
            add eax, [esp + 4]
            add eax, ebx
            mov eax, [eax]
            add eax, ebx
            stosd
     
     @SkipHash:
            cmp dword ptr [edi],       0FFFFFFFFh        // Skip function hash
            jne @search_api_name
            leave
            pop     ebx
     end
     
     
     Function _GetKernelBase:cardinal;stdcall;
     asm
            call  _DeltaOfs
            xchg  eax,ebx
            mov     edx, fs:[0]                 // SEH:0
     @NextSEH:
            mov     eax, [edx+4]                // Переходим на следующий эелемент
            mov     edx, [edx]                  // Берем первый элемент
            cmp     edx, $FFFFFFFF              // Сравниваем первый эелемент
            jnz     @NextSEH                    // Если не равно $FFFFFFFF идем дальше
            and     eax, $FFFF0000              // тначе нормализуем ????0000
     @Circle:                                   // Теперь будем провирять...
            cmp     word ptr [eax],5A4Dh        // Проверим на MZ сигнатуру
            jnz     @NotFoundMZ                 // Если не равно то это не Kernel
            mov     edx, eax                    // Иначе сохраняем базовый адрес в EDX
            add     edx, [edx+3Ch]              // И добовляем адрес начало PE заголовка
            cmp     dword ptr [edx],00004550h   // Сверяем, является ли это PE?
            jz     @K32Found                    // Если да, то переходим на метку K32Found
     @NotFoundMZ:                               // Иначе
            sub     eax, 10000h                 // Уменьшаем базовый адрес 10000h
            cmp     eax, 70000000h              // и сверяем если не ниже
            jnb     @Circle                     // то повторяем пойск иначе
            mov     eax, 0BFF70000h             // присваеваем базовый адрес 0BFF70000 для Win98
         @K32Found:
     end
     
     
     Procedure _ExitProc;stdcall;
     asm
            pop     dword ptr fs:[0]
            add     esp,4
     end
     //****************************************************************
     
     
     begin
       _GetKernelBase;
       _CalcHashFunction;
     asm
            JMP @MSBOX
            @User32  : db 'User32.dll',000
            @ms      : db 'MessageBoxA',000
            @lpTitle : db 'VIRUS',000
            @lpText  : db 'HULIGAN',000
     
     @MSBOX:
            lea      esi, [ebx + @User32]
            push     esi
            Call     dword ptr [_Library+8]
            mov      edx, eax
            lea      esi, [ebx + @MS] 
            push     esi
            push     eax
            Call     dword ptr [_Library+4]
            push     0
            lea      esi, [ebx + @lpTitle]
            push     esi
            lea      esi, [ebx + @lpText]
            push     esi
            push     0
            call     eax
            push     edx
            call     dword ptr [_Library+0]
     end

     _ExitProc;

     end;
     
    end.
     

```