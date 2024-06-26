---
Title: Method pointers -> Function pointers
Author: Florian.Benz@t-online.de
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
Date: 01.01.2007
---


Method pointers -> Function pointers
====================================

Преобразование указателя на метод в указатель на функцию

    {
     Converting method pointers into function pointers
     
     Often you need a function pointer for a callback function. But what, 
     if you want to specify a method as an callback? Converting a method 
     pointer to a function pointer is not a trivial task; both types are
     incomatible with each other. Although you have the possibility to 
     convert like this "@TClass.SomeMethod", this is more a hack than a 
     solution, because it restricts the use of this method to some kind 
     of a class function, where you cannot access instance variables. 
     If you fail to do so, you'll get a wonderful gpf. But there is 
     a better solution: run time code generation! Just allocate an 
     executeable memory block, and write 4 machine code instructions into 
     it: 2 instructions loads the two pointers of the method pointer
     (code & data) into the registers, one calls the method via the code 
     pointer, and the last is just a return Now you can use this pointer 
     to the allocated memory as a plain funtion pointer, but in fact you are
     calling a method for a specific instance of a Class.
     
    }
    type TMyMethod = procedure of object;
     
     
    function MakeProcInstance(M: TMethod): Pointer;
    begin
      // allocate memory
      GetMem(Result, 15);
      asm
        // MOV ECX, 
        MOV BYTE PTR [EAX], $B9
        MOV ECX, M.Data
        MOV DWORD PTR [EAX+$1], ECX
        // POP EDX
        MOV BYTE PTR [EAX+$5], $5A
        // PUSH ECX
        MOV BYTE PTR [EAX+$6], $51
        // PUSH EDX
        MOV BYTE PTR [EAX+$7], $52
        // MOV ECX, 
        MOV BYTE PTR [EAX+$8], $B9
        MOV ECX, M.Code
        MOV DWORD PTR [EAX+$9], ECX
        // JMP ECX
        MOV BYTE PTR [EAX+$D], $FF
        MOV BYTE PTR [EAX+$E], $E1
      end;
    end;
     
     
    procedure FreeProcInstance(ProcInstance: Pointer);
    begin
      // free memory
      FreeMem(ProcInstance, 15);
    end;
     
    {
     After all, you should not forget to release the allocated memory.
     "TMyMethod" can be modified according your specific needs, e.g. 
     add some parameters for a WindowProc. N.B.: Yes, I know, Delphi 
     has those "MakeProcInstance" function in its forms unit. But this 
     works a little bit different, has much more overhead, and most 
     important, you have to use the forms unit, which increases the 
     size of your exe drastically, if all other code doesn't use the 
     VCL (e.g. in a fullscreen DirectX/OpenGl app).
     
    // Wer noch Fragen hat / if you have questions: Florian.Benz@t-online.de
    }

