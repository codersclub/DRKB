---
Title: Byte -> Bin
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Byte -> Bin
===========

    function ByteToBinStr(a_bByte: byte): string;
    var
     i: integer;
    begin
     SetLength(Result, 8);
     for i := 8 downto 1 do
     begin
       Result[i] := chr($30 + (a_bByte and 1));
       a_bByte := a_bByte shr 1;
     end;
    end;


