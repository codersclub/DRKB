---
Title: Умножение больших целых чисел
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Умножение больших целых чисел
=============================

    type
       IntNo = record
         Low32, Hi32: DWORD;
       end;
     
     function Multiply(p, q: DWORD): IntNo;
     var
       x: IntNo;
     begin
       asm
         MOV EAX,[p]
         MUL [q]
         MOV [x.Low32],EAX
         MOV [x.Hi32],EDX
       end;
       Result := x
     end;
     
     
     // Test the above with: 
    // So kannst du es testen 
     
    var
       r: IntNo;
     begin
        r := Multiply(40000000, 80000000);
        ShowMessage(IntToStr(r.Hi32) + ', ' + IntToStr(r.low32))
     end;

