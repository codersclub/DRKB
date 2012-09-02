<h1>Арифметика указателей</h1>
<div class="date">01.01.2007</div>


<p>Сначала короткое объяснение арифметике указателя. Когда вы имеете дело с динамическими страницами памяти, то все, что вы имеете - это указатели на начала блоков памяти. Вы хотите просмотреть всю строку памяти, чтобы понять какие функции необходимы для работы с данными, хранящимися в памяти? Это возможно путем изменения места в памяти, на которое указывает указатель. Это называется арифметикой указателя. </p>

<p>Основополагающая идея при занятиях арифметикой с указателем - указатель должен быть увеличен на значение корректного приращения. (Корректное приращение определяется размером объекта, на который показывает указатель. Например, char = 1 байт; integer = 2 байта; double = 8 байт и т.д.) Функции Inc() и Dec() изменяют значение корректного приращения. (Компилятор знает правильный размер объекта.) </p>

<p>Если вы осуществляете динамическое распределение памяти, то делать это можно примерно так: </p>

<pre>
uses WinCRT;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  MyArray: array[0..30] of char;
  b: ^char;
  i: integer;
begin
  StrCopy(MyArray, 'Дельфи - рулез фарева!');
    {помещаем что-то в память для организации указателя}
  b := @MyArray; { назначаем указатель на текущую позицию памяти }
  for i := StrLen(MyArray) downto 0 do
  begin
    write(b^); { пишем символ в текущую позицию указателя. }
    inc(b); { перемещаем указатель на следующий байт памяти }
  end;
end;
</pre>

<p>Нижеследующий код демонстрирует работу функций Inc() и Dec(), увеличивающих или уменьшающих указатель на размер соответствующего типа:</p>

<pre>
var
  P1, P2: ^LongInt;
  L: LongInt;
begin
  P1 := @L; { назначаем оба указателя на одно и то же место }
  P2 := @L;
  Inc(P2); { Увеличиваем один }
 
  { Здесь мы получаем разницу между смещениями двух
  указателей. Поскольку первоначально они указывали на одно
  и то же место памяти, то результатом данного вызова
  будет разница между двумя указателями после вызова Inc(). }
 
  L := Ofs(P2^) - Ofs(P1^); { L = 4; т.е. sizeof(longInt) }
end;
</pre>

<p>Вы можете изменить тип объекта, на который указывает P1 и P2, на какой-то другой и убедиться, что (SizeOf(P1^)) всегда возвращает величину корректного приращения (проще сказать, что это размер объекта - В.О.). </p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

