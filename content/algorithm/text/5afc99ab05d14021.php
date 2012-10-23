<h1>Перевернуть строку</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: ___Nikolay</div>

<pre>
// Перевернуть строку
function ReverseString(s: string): string;
var
  i: integer;
begin
  Result := '';
  if Trim(s) &lt;&gt; '' then
    for i := Length(s) downto 1 do
      Result := Result + s[i];
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

<hr />

<div class="author">Автор: Profit Manson</div>
<pre>
function ReverseString(s: string): string;
var
  i: integer;
  c: char;
begin
  if s &lt;&gt; '' then
    for i := 1 to Length(s) div 2 do
    begin
      c := s[i];
      s[i] := s[Length(s) + 1 - i];
      s[Length(s) + 1 - i] := c;
    end;
  Result := s;
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

<hr />

<pre>
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
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>

<hr />

<pre>
 function ReverseString(const Str: string): string;
 // by Ido Kanner 
var
   ch: Char;
   i, Size: Integer;
 begin
   Result := Str;
   Size   := Length(Result);
   if (Size &gt;= 2) then
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
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>

<hr />

<pre>
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
   while P &lt; Q do
   begin
     C := P^;
     P^ := Q^;
     Q^ := C;
     Inc(P);
     Dec(Q);
   end;
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>

<hr />

<pre>
 procedure ReverseString(var S: string);
 // by Rudy Velthuis 
var
   P, Q: PChar;
   C: Char;
 begin
   if Length(S) = 0 then Exit;
   P := PChar(S);
   Q := P + Length(S) - 1;
   while P &lt; Q do
   begin
     C := P^;
     P^ := Q^;
     Q^ := C;
     Inc(P);
     Dec(Q);
   end;
 end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>


