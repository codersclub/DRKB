<h1>Алгоритм шифрование XOR</h1>
<div class="date">01.01.2007</div>


<pre>
program Crypt;
{$APPTYPE CONSOLE}
 
uses Windows;
 
var
  key, text, longkey, result : string;
  i : integer;
  toto, c : char;
  F : TextFile;
begin
  writeln('Enter the key:');
  readln(key);
  writeln('Enter the text:');
  readln(text);
 
  for i := 0 to (length(text) div length(key)) do
    longkey := longkey + key;
 
  for i := 1 to length(text) do
  begin
    // XOR алгоритм
    toto := chr((ord(text[i]) xor ord(longkey[i])));
    result := result + toto;
  end;
  writeln('The crypted text is:');
  writeln(result);
  write('Should i save it to result.txt ?');
  read(c);
  if c in ['Y','y'] then
  begin
    AssignFile(F,'result.txt');
    Rewrite(F);
    Writeln(F,result);
    CloseFile(F);
  end;
end.
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

<hr />

<div class="author">Автор: Igor N. Semenushkin</div>
<p>Вот ужасно простой пример XOR шифрования - работает без глюков.</p>
<pre>
var
  key, text, longkey, result: string;
  i: integer;
  toto, c: char;
begin
  for i := 0 to (length(text) div length(key)) do
    longkey := longkey + key;
  for i := 1 to length(text) do
  begin
    toto := chr((ord(text[i]) xor ord(longkey[i]))); // XOR алгоритм
    result := result + toto;
  end;
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
