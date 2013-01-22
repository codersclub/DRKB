---
Title: Bin -> Byte
Date: 01.01.2007
---


Bin -> Byte
===========

::: {.date}
01.01.2007
:::

    function BinStrToByte(a_sBinStr: string): byte;
    var
     i: integer;
    begin
     Result := 0;
     for i := 1 to length(a_sBinStr) do
       Result := (Result shl 1) or byte(a_sBinStr[i] = '1');
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
