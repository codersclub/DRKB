---
Title: Integer -> Bin
Date: 01.01.2007
---


Integer -> Bin
==============

::: {.date}
01.01.2007
:::

    function IntToBin1(Value: Longint; Digits: Integer): string;
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

Взято с сайта: <https://www.swissdelphicenter.ch>

------------------------------------------------------------------------

     function IntToBin2(d: Longint): string;
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

Взято с сайта: <https://www.swissdelphicenter.ch>
