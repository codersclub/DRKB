---
Title: Integer -> Bin
Date: 01.01.2007
---


Integer -> Bin
==============

Вариант 1:

Source: <https://www.swissdelphicenter.ch>

    function IntToBin(Value: Longint; Digits: Integer): string;
     var
       i: Integer;
     begin
       Result := '';
       for i := Digits downto 0 do
         if Value and (1 shl i) <> 0 then
           Result := Result + '1'
       else
         Result := Result + '0';
     end;

------------------------------------------------------------------------

Вариант 2:

Source: <https://www.swissdelphicenter.ch>

     function IntToBin(d: Longint): string;
     var
       x, p: Integer;
       bin: string;
     begin
       bin := '';
       for x := 1 to 8 * SizeOf(d) do
       begin
         if Odd(d) then bin := '1' + bin
         else
           bin := '0' + bin;
         d := d shr 1;
       end;
       Delete(bin, 1, 8 * ((Pos('1', bin) - 1) div 8));
       Result := bin;
     end;

