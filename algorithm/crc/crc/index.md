---
Title: CRC
Date: 01.01.2007
---


CRC
===

::: {.date}
01.01.2007
:::

    { 
      Example of calculating a simple checksum. 
      Beispiel, wie eine einfache Checksumme berechnet werden kann. 
    }
     
     function CalcStrChecksum(s: string; zerobased: Boolean): Longint;
     var
       i: integer;
       L: integer;
     begin
       Result := 0;
       l := Length(s);
       if l > 0 then
       begin
         for i := 1 to l do
           if zerobased then
             Inc(Result, Ord(s[i]) - 65)
         else
           Inc(Result, Ord(s[i]));
       end;
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
