---
Title: Бип (beep) для Delphi, который работает как в Turbo Pascal
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Бип (beep) для Delphi, который работает как в Turbo Pascal
====================================================

Я применяю следующий код, однако он работает только под Win9x/me.

(Под WinNT/2000/XP вы можете использовать функцию Beep(Tone, Duration) -
задавать тон и продолжительность звучания).

    procedure Sound(Freq : Word);
      var B : Byte;
    begin 
      if Freq > 18 then
        begin
          Freq := Word(1193181 div LongInt(Freq));
          B := Byte(GetPort($61)); 
          if (B and 3) = 0 then
            begin
              SetPort($61, Word(B or 3));
              SetPort($43, $B6);
            end; 
          SetPort($42, Freq);
          SetPort($42, Freq shr 8);
        end;
    end; 
     
    procedure NoSound;
      var Value: Word;
    begin 
      Value := GetPort($61) and $FC;
      SetPort($61, Value);
    end; 
     
    procedure SetPort(address, Value:Word);
      var bValue: byte;
    begin 
      bValue := trunc(Value and 255);
      asm
        mov dx, address
        mov al, bValue
        out dx, al
      end;
    end; 
     
    function GetPort(address:word):word;
    var bValue: byte;
    begin 
      asm
        mov dx, address
        in al, dx
        mov bValue, al
      end;
      GetPort := bValue;
    end;

