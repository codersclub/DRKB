---
Title: Как редактировать таблицы виртуальных и динамических методов?
Author: \_\_\_ALex\_\_\_ Форум: <https://forum.pascal.dax.ru/>
Date: 01.01.2007
---


Как редактировать таблицы виртуальных и динамических методов?
=============================================================

    unit EditorVMTandDMTTables;
     
    interface
     
    // функция служит для выяснения существования VMT у класса
    // возвращает True, если класс имеет VMT и False - если нет
    function IsVMTExist(Cls: TClass): Boolean;
     
    // процедура служит для замены адреса метода в VMT класса со смещением
    // Offset(должно быть кратно 4) новым адресом, хранящимся в NewMet
    // примечание: перед вызовом этой процедуры проверяйте существование
    // VMT у класса функцией IsVMTExist
    procedure VirtMethodReplace(Cls: TClass; Offset: LongWord; NewMet: Pointer); overload;
     
    // процедура служит для замены адреса метода, хранящегося в OldMet,
    // в VMT класса новым адресом, хранящимся в NewMet
    // примечание: перед вызовом этой процедуры проверяйте существование
    // VMT у класса функцией IsVMTExist
    procedure VirtMethodReplace(Cls: TClass; OldMet, NewMet: Pointer); overload;
     
    // функция служит для замены адреса динамического метода класса с индексом,
    // хранящимся в Index, новым адресом, хранящимся в NewMet
    // возвращает True, если метод с данным индексом найден и False - если нет
    function DynMethodReplace(Cls: TClass; Index: Word; NewMet: Pointer): Boolean; overload;
     
    // функция служит для замены адреса динамического метода класса, хранящегося
    // в OldMet, новым адресом, хранящимся в NewMet
    // возвращает True, если метод с данным адресом найден и False - если нет
    function DynMethodReplace(Cls: TClass; OldMet, NewMet: Pointer): Boolean; overload;
     
    implementation
     
    // функция служит для получения указателя на байт, следующий за адресом
    // последнего метода в VMT класса
    // возвращает nil в случае, если у класса нет VMT
    // функция является "внутренней" в модуле
    // (используется другими подпрограммами и не объявлена в секции interface)
    //, поэтому используйте её только если
    // Вы полностью уверены в своих действиях(она изменяет "рабочие" регистры
    // ECX и EDX)
    function GetVMTEnd(Cls: TClass): Pointer;
    asm
            // Вход: Cls --> EAX
            // Выход: Result --> EAX
     
            PUSH    EBX
            MOV     ECX, 8
            MOV     EBX, -1
            MOV     EDX, vmtSelfPtr
    @@cycle:
            ADD     EDX, 4
            CMP     [EAX + EDX], EAX
            JE      @@vmt_not_found
            JB      @@continue
            CMP     [EAX + EDX], EBX
            JAE     @@continue
            MOV     EBX, [EAX + EDX]
    @@continue:
            DEC     ECX
            JNZ     @@cycle
            MOV     EAX, EBX
            JMP     @@exit
    @@vmt_not_found:
            XOR     EAX, EAX
    @@exit:
            POP     EBX
    end;
     
    function IsVMTExist(Cls: TClass): Boolean;
    asm
            // Вход: Cls --> EAX
            // Выход: Result --> AL
     
            CALL    GetVMTEnd
            TEST    EAX, EAX
            JZ      @@vmt_not_found
            MOV     AL, 1
    @@vmt_not_found:
    end;
     
    procedure VirtMethodReplace(Cls: TClass; Offset: LongWord; NewMet: Pointer); overload;
    asm
           // Вход: Cls --> EAX, Offset --> EDX, NewMet --> ECX
            MOV     [EAX + EDX], ECX
    end;
     
    procedure VirtMethodReplace(Cls: TClass; OldMet, NewMet: Pointer); overload;
    asm
            // Вход: Cls --> EAX, OldMet --> EDX, NewMet --> ECX
            PUSH    EDI
            MOV     EDI, EAX
            PUSH    ECX
            PUSH    EDX
            PUSH    EAX
            CALL    GetVMTEnd
            POP     EDX
            SUB     EAX, EDX
            SHR     EAX, 2
            POP     EDX
            POP     ECX
            PUSH    ECX
            MOV     ECX, EAX
            MOV     EAX, EDX
            POP     EDX
            REPNE   SCASD
            JNE     @@OldMet_not_found
            MOV     [EDI - 4], EDX
    @@OldMet_not_found:
            POP     EDI
    end;
     
    function DynMethodReplace(Cls: TClass; Index: Word; NewMet: Pointer): Boolean; overload;
    asm
            // Вход: Cls --> EAX, Index --> DX, NewMet --> ECX
            // Выход: Result --> AL
     
            PUSH    EDI
            PUSH    ESI
            MOV     ESI, ECX
            XOR     EAX, EDX
            XOR     EDX, EAX
            XOR     EAX, EDX
            JMP     @@start
    @@cycle:
            MOV     EDX, [EDX]
    @@start:
            MOV     EDI, [EDX].vmtDynamicTable
            TEST    EDI, EDI
            JZ      @@get_parent_dmt
            MOVZX   ECX, WORD PTR [EDI]
            PUSH    ECX
            ADD     EDI, 2
            REPNE   SCASW
            JE      @@Index_found
            POP     ECX
    @@get_parent_dmt:
            MOV     EDX, [EDX].vmtParent
            TEST    EDX, EDX
            JNZ     @@cycle
            JMP     @@Index_not_found
    @@Index_found:
            POP     EAX
            SHL     EAX, 1
            SUB     EAX, ECX
            MOV     [EDI + EAX * 2 - 4], ESI
            MOV     AL, 1
            JMP     @@exit
    @@Index_not_found:
            XOR     AL, AL
    @@exit:
            POP     ESI
            POP     EDI
     
    end;
     
    function DynMethodReplace(Cls: TClass; OldMet, NewMet: Pointer): Boolean; overload;
    asm
            // Вход: Cls --> EAX, OldMet --> EDX, NewMet --> ECX
            // Выход: Result --> AL
     
            PUSH    EDI
            PUSH    ESI
            MOV     ESI, ECX
            XOR     EAX, EDX
            XOR     EDX, EAX
            XOR     EAX, EDX
            JMP     @@start
    @@cycle:
            MOV     EDX, [EDX]
    @@start:
            MOV     EDI, [EDX].vmtDynamicTable
            TEST    EDI, EDI
            JZ      @@get_parent_dmt
            MOVZX   ECX, WORD PTR [EDI]
            LEA     EDI, EDI + 2 * ECX + 2
            REPNE   SCASD
            JE      @@OldMet_found
    @@get_parent_dmt:
            MOV     EDX, [EDX].vmtParent
            TEST    EDX, EDX
            JNZ     @@cycle
            JMP     @@OldMet_not_found
    @@OldMet_found:
            MOV     [EDI - 4], ESI
            MOV     AL, 1
            JMP     @@exit
    @@OldMet_not_found:
            XOR     AL, AL
    @@exit:
            POP     ESI
            POP     EDI
     
    end;
     
    end.

