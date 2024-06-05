---
Title: Быстрый способ обмена значений двух переменных
Author: \_\_\_ALex\_\_\_
Date: 01.01.2007
---


Быстрый способ обмена значений двух переменных
==============================================

Вариант 1:

Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>

    procedure SwapVars1(var u, v; Size: Integer); 
    var 
      x: Pointer; 
    begin 
      GetMem(x, Size); 
      try 
        System.move(u, x^, Size); 
        System.move(v, u, Size); 
        System.move(x^, v, Size); 
      finally 
        FreeMem(x); 
      end; 
    end; 
     
     
    procedure SwapVars2(var Source, Dest; Size: Integer); 
      // By Mike Heydon, mheydon@eoh.co.za 
    begin 
      asm 
         push edi 
         push esi 
         mov esi,Source 
         mov edi,Dest 
         mov ecx,Size 
         cld 
     @1: 
         mov al,[edi] 
         xchg [esi],al 
         inc si 
         stosb 
         loop @1 
         pop esi 
         pop edi 
      end; 
    end; 
     
    procedure TForm1.Button2Click(Sender: TObject); 
    begin 
      SwapVars1(X1, X2, SizeOf(Integer)); 
    end; 


------------------------------------------------------------------------

Вариант 2:

Author: \_\_\_ALex\_\_\_

Source: <https://forum.pascal.dax.ru>

    var 
     X1, X2: Byte; 
    begin 
     X1 := X2 xor X2;  
     X2 := X1 xor X2; // X2 = X1 
     X1 := X1 xor X2; // X1 = X2 

