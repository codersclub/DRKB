<h1>Перебор вариантов</h1>
<div class="date">01.01.2007</div>


<pre>
{ Если Х - количество видов букв, из которых состоит генеримое слово,
  а Y - максимальная длинна слова, то общее количество сгенеренных
  слов равно: Z = Y^1 + Y^2 + ... + Y^X }
 
var
  Gen_Length: Byte;      { максимальная длинна слова для генерации }
  Gen_CharArray: String; { массив символов, из которых будет сгенерированы слова }
  InS: String;           { строка, из которой будет создан массив Gen_CharArray }
  I: Byte;               { счётчик }
  F: Text;               { файл для сохранения сгенерированных слов }
 
{ рекурсивная процедура генерации слова }
procedure GenNext(Gen_LastCharNo: Byte; Gen_Str: String);
var
  I: Byte;               { счётчик }
begin
  { генерируем до тех пор, пока не достигнем последнего символа в массиве генерации }
  for I := 1 to Byte(Gen_CharArray[0]) do
    begin
      { устанавливаем длинну строки слова, которое сейчас сгенерируем }
      Byte(Gen_Str[0]) := Gen_LastCharNo;
 
      { изменяем последний символ генерируемого слова, которое нам передано 
        в заголовке процедуры }
      Gen_Str[Gen_LastCharNo] := Gen_CharArray[I];
 
      { слово сгенерировано, записываем в файл }
      WriteLn(F, Gen_Str);
 
      { если мы не достигли максимальной длинны слова, вызываем себя рекурсивно,
        указав, что уже следующи символ будет последним и передавая уже 
        сгенерированный кусок строки }
      if Gen_Length &gt; Gen_LastCharNo then GenNext(Gen_LastCharNo+1, Gen_Str);
    end;
end;
 
begin
  Gen_CharArray := 'DELPHI';
 
  { в примере максимальная длинна слова для генерации равна длинне массива символов }
  Gen_Length := Byte(Gen_CharArray[0]);
 
  Assign(F, 'OUTPUT.TXT');
  ReWrite(F);
 
  { запускаем генерацию
    Gen_LastCharNo - последний символ будет иметь номер 1
    Gen_Str - пока строка пуста }
  GenNext(1, '');
 
  Close(F);
end.
</pre>
<p>&nbsp;<br>
<p class="author">Автор: --= Eagle =-- </p>
