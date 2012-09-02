<h1>Сканирование строки, начиная с указанной позиции с целью нахождения слова</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Сканирование строки начиная с указанной позиции с целью нахождения слова.
 
Функция предназначена для разбиения строки на слова. Границы слов
определяются по разделителям.
 
Описание параметров:
 
S - строка, в которой производится поиск;
 
StartPos - на входе принимает позицию с которой начинается сканирование
строки, на выходе содержит позицию символа, с которого начинается слово;
 
WordLen - на выходе содержит длину найденного слова;
 
Delimiters - множество, содержащее символы-разделители слов;
 
Возвращаемое значение - true если слово найдено, инече false;
 
Зависимости: SysUtils
Автор:       vuk, vuk@fcenter.ru
Copyright:   Алексей Вуколов
Дата:        18 апреля 2002 г.
***************************************************** }
 
function WordScan(const S: string; var StartPos, WordLen: integer;
  Delimiters: TSysCharSet): boolean;
var
  i, l: integer;
begin
  Result := false;
  WordLen := 0;
 
  i := StartPos;
  l := length(s);
  StartPos := 0;
  while i &lt;= l do
    if s[i] in Delimiters then
      inc(i)
    else
    begin
      StartPos := i;
      break;
    end;
 
  while i &lt;= l do
    if not (s[i] in Delimiters) then
    begin
      inc(i);
      inc(WordLen);
    end
    else
      break;
 
  Result := WordLen &lt;&gt; 0;
end;
//Пример использования: 
 
//Консольная программа, выводящая на экран слова из заданной строки.
 
program Project1;
{$APPTYPE CONSOLE}
uses SysUtils;
 
var
  s: string;
  wStart, wLen: integer;
begin
  s := 'This is a test string. String contains delimiters.';
  wStart := 1;
  wLen := 0;
  while WordScan(s, wStart, wLen, [' ', '.', ',']) do
  begin
    writeln(copy(s, wStart, wLen));
    inc(wStart, wLen);
  end;
  readln;
end.
</pre>

