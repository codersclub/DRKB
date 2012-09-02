<h1>Изменение регистра букв</h1>
<div class="date">01.01.2007</div>


<p>В Delphi есть три функции для изменения регистра: upcase, lowercase, uppercase. </p>
<p>Но они работают только для латинского алфавита. </p>
<p>Чтобы сделать аналогичные функции для русского алфавита я </p>
<p>использовал то, что в кодировке Windows-1251 буквы расставлены по алфавиту, </p>
<p>как большие, так и маленькие. </p>
<p>То есть номер большой буквы связан с номером маленькой константой. </p>
<p>И в русском, и в английском алфавитах маленькие буквы находятся </p>
<p>за большими с разностью в 32 символа.</p>
<p>Здесь реализованы четыре функции: upcase и locase для</p>
<p> изменения регистра одного символа, и uppercase и lowercase для изменения регистра строки</p>

<pre>
function UpCase(ch: char): char;
begin
  if (ch in ['a'..'z', 'а'..'я'])
    then result := chr(ord(ch) - 32)
    else result := ch;
end;
 
function LoCase(ch: char): char;
begin
  if (ch in ['A'..'Z', 'А'..'Я'])
    then result := chr(ord(ch) + 32)
    else result := ch;
end;
 
function UpperCase(s: string): string;
var
  i: integer;
begin
  result := s;
  for i := 1 to length(result) do
    if (result[i] in ['a'..'z', 'а'..'я'])
      then result[i] := chr(ord(result[i]) - 32);
end;
 
function LowerCase(s: string): string;
var
  i: integer;
begin
  result := s;
  for i := 1 to length(result) do
    if (result[i] in ['A'..'Z', 'А'..'Я'])
      then result[i] := chr(ord(result[i]) + 32);
end;
 
procedure TForm1.Button1Click(Sender: TObject);
const
  s = 'zZцЦ.';
var
  i: integer;
begin
  Form1.Caption := 'DownCase: ';
  for i := 1 to Length(s) do
    Form1.Caption := Form1.Caption + LoCase(s[i]);
  Form1.Caption := Form1.Caption + ' UpCase: ';
  for i := 1 to Length(s) do
    Form1.Caption := Form1.Caption + UpCase(s[i]);
  Form1.Caption := Form1.Caption + ' UpperCase: ' +
    UpperCase(s);
  Form1.Caption := Form1.Caption + ' LowerCase: ' +
    LowerCase(s);
end;
</pre>


<p>Взято с сайта <a href="https://blackman.wp-club.net/" target="_blank">https://blackman.wp-club.net/</a></p>
