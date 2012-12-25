---
Title: Перевернуть строку
Author: \_\_\_Nikolay
Date: 01.01.2007
---


Перевернуть строку
==================

::: {.date}
01.01.2007
:::

Автор: \_\_\_Nikolay

    // Перевернуть строку
    function ReverseString(s: string): string;
    var
      i: integer;
    begin
      Result := '';
      if Trim(s) <> '' then
        for i := Length(s) downto 1 do
          Result := Result + s[i];
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Автор: Profit Manson

    function ReverseString(s: string): string;
    var
      i: integer;
      c: char;
    begin
      if s <> '' then
        for i := 1 to Length(s) div 2 do
        begin
          c := s[i];
          s[i] := s[Length(s) + 1 - i];
          s[Length(s) + 1 - i] := c;
        end;
      Result := s;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

    function ReverseString(const s: string): string;
     var
       i, len: Integer;
     begin
       len := Length(s);
       SetLength(Result, len);
       for i := len downto 1 do
       begin
         Result[len - i + 1] := s[i];
       end;
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>

------------------------------------------------------------------------

     function ReverseString(const Str: string): string;
     // by Ido Kanner 
    var
       ch: Char;
       i, Size: Integer;
     begin
       Result := Str;
       Size   := Length(Result);
       if (Size >= 2) then
       // 2 or more chars 
      begin
         // For 1 to middle of the string 
        for i := 1 to (Size div 2) do
         begin
           // Lets get the charecter of the current place in the string 
          ch := Result[i];
           // Place the Current pos of the char 
          // with the char of it's mirror place... 
          Result[i] := Result[Size - (i - 1)];
           // In the mirror place we will put char of the 
          // Original place... And we switched places !!! 
          Result[Size - (i - 1)] := ch;
         end
       end;
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>

------------------------------------------------------------------------

     function ReverseString(S: string): string;
     // by Rudy Velthuis 
    var
       P, Q: PChar;
       C: Char;
     begin
       Result := S;
       if Length(Result) = 0 then Exit;
       P := PChar(Result);
       Q := P + Length(Result) - 1;
       while P < Q do
       begin
         C := P^;
         P^ := Q^;
         Q^ := C;
         Inc(P);
         Dec(Q);
       end;
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>

------------------------------------------------------------------------

     procedure ReverseString(var S: string);
     // by Rudy Velthuis 
    var
       P, Q: PChar;
       C: Char;
     begin
       if Length(S) = 0 then Exit;
       P := PChar(S);
       Q := P + Length(S) - 1;
       while P < Q do
       begin
         C := P^;
         P^ := Q^;
         Q^ := C;
         Inc(P);
         Dec(Q);
       end;
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
