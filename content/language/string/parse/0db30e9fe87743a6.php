<h1>Деление строки не несколько строк</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Делит строку аStr на три строки St1,St2,St3 длиной Long1,Long2,Long3
 
Делит строку аStr на три строки St1,St2,St3 длиной Long1,Long2,Long3
соответственно или меньше в зависимости от длины исходной строки.
 
Зависимости: ???
Автор:       Сергей, nfkazak@inbox.ru, Краснодар
Copyright:   VIP BANK
Дата:        11 сентября 2002 г.
***************************************************** }
 
procedure DivPart(aStr: string; var St1, St2, St3: string; Long1, Long2, Long3:
  byte);
var
  i, pos, Long: byte;
begin
  St1 := '';
  St2 := '';
  St3 := '';
  aStr := Trim(aStr);
  Long := Length(aStr);
  if Long &lt;= Long1 then
  begin
    St1 := aStr;
    Exit
  end;
  Pos := Long1;
  for i := 1 to Long1 + 1 do
    if aStr[i] = ' ' then
      Pos := i;
  St1 := TrimRight(Copy(aStr, 1, Pos));
  Delete(aStr, 1, Pos);
  aStr := TrimLeft(aStr);
  Long := Length(aStr);
  if Long &lt;= Long2 then
  begin
    St2 := aStr;
    Exit
  end;
  Pos := Long2;
  for i := 1 to Long2 + 1 do
    if aStr[i] = ' ' then
      Pos := i;
  St2 := TrimRight(Copy(aStr, 1, Pos));
  St3 := Trim(Copy(aStr, Pos + 1, Long3))
end;
</pre>
<hr />
<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Разбивка строки на подстроки с использованием заданного разделителя
 
Параметры: Str: WideString - Строка для разбивки
Delimiter: String - Разделитель подстрок с строке Str
Результат: TStringList: Список найденных подстрок
 
Зависимости: System, Sysutils, Classes
Автор:       Stoma, stoma@bitex.bg
Copyright:   Собственная разработка
Дата:        4 августа 2003 г.
***************************************************** }
 
function Tokenize(Str: WideString; Delimiter: string): TStringList;
var
  tmpStrList: TStringList;
  tmpString, tmpVal: WideString;
  DelimPos: LongInt;
begin
  tmpStrList := TStringList.Create;
  TmpString := Str;
  DelimPos := 1;
  while DelimPos &gt; 0 do
  begin
    DelimPos := LastDelimiter(Delimiter, TmpString);
    tmpVal := Copy(TmpString, DelimPos + 1, Length(TmpString));
    if tmpVal &lt;&gt; '' then
      tmpStrList.Add(UpperCase(tmpVal));
    Delete(TmpString, DelimPos, Length(TmpString));
  end;
  Tokenize := tmpStrList;
end;
Пример использования: 
 
function TForm1.GetDirNames(FullPath: string): TStringList;
begin
  GetDirNames := Tokenize(FullPath, '\');
end;
</pre>
</p>
<hr />
<pre>
procedure Explode(var a: array of string; Border, S: string);
 var
    S2: string;
   i: Integer;
 begin
   i  := 0;
   S2 := S + Border;
   repeat
     a[i] := Copy(S2, 0,Pos(Border, S2) - 1);
     Delete(S2, 1,Length(a[i] + Border));
     Inc(i);
   until S2 = '';
 end;
 
 // How to use it: 
// Und hier ein Beispiel zur Verwendung: 
 
procedure TForm1.Button1Click(Sender: TObject);
 var
    S: string;
   A: array of String;
 begin
   S := 'Ein Text durch Leerzeichen getrennt';
   SetLength(A, 10);
   Explode(A, ' ', S);
   ShowMessage(A[0] + ' ' + A[1] + ' ' + A[2] + ' ' + A[3] + ' ' + A[4]);
 end;
 
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
</p>
<hr />
