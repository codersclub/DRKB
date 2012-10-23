<h1>Как получить неповторяющиеся случайные числа?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure Shuffle(var aArray; aItemCount: Integer; aItemSize: Integer); 
  { after Julian M Bucknall } 
var 
  Inx: Integer; 
  RandInx: Integer; 
  SwapItem: PByteArray; 
  A: TByteArray absolute aArray; 
begin 
  if (aItemCount &gt; 1) then 
  begin 
    GetMem(SwapItem, aItemSize); 
    try 
      for Inx := 0 to (aItemCount - 2) do 
      begin 
        RandInx := Random(aItemCount - Inx); 
        Move(A[Inx * aItemSize], SwapItem^, aItemSize); 
        Move(A[RandInx * aItemSize], A[Inx * aItemSize], aItemSize); 
        Move(SwapItem^, A[RandInx * aItemSize], aItemSize); 
      end; 
    finally 
      FreeMem(SwapItem, aItemSize); 
    end; 
  end; 
end; 
 
procedure TForm1.Button1Click(Sender: TObject); 
var 
  a: array[1..10] of Integer; 
  i: Shortint; 
begin 
  Randomize; 
  for i := Low(a) to High(a) do a[i] := i; 
  Shuffle(a, High(a), SizeOf(Integer)); 
  for i := 1 to High(a) - 1 do 
    ListBox1.Items.Add(IntToStr(a[i])); 
end; 
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
<hr /><div class="author">Автор: Дедок Василий </div>
<pre>
 
type
  arr = array[1..255] of integer;
 
procedure FillArray(var A: arr; n: integer);
var
  i: integer;
  s: string;
  q: byte;
begin
  randomize;
  s := '';
  for i := 1 to n do
    begin
      q := random(i);
      insert(chr(i), s, q);
    end;
  for i := 1 to n do
    begin
      A[i] := ord(s[i]);
    end;
end;
</pre>
<hr /><div class="author">Автор: Иваненко Фёдор Григорьевич </div>
<pre>
procedure FillArray(var A: array of Integer);
var
  I, S, R: Integer;
begin
  for I := 0 to High(A) do
    A[I] := I;
  for i := High(A) downto 0 do
  begin
    R := Random(I);
    S := A[R];
    A[R] := A[I];
    A[I] := S;
  end;
end;
</pre>


<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
<hr />
<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Заполнение массива неповторяющимися случайными целыми числами
 
Данная процедура заполняет заданный массив случайными неповторяющимися целыми числами.
Заполнения идет числами начиная с 1, если вам необходимо заполнить массив числами с 0,
то измените строку:
inputMass[i]:=Unic(bm,range)+1;
на
inputMass[i]:=Unic(bm,range);
 
Зависимости: стандартные модули
Автор:       Ru, DiVo_Ru@rambler.ru, Одесса (Украина)
Copyright:   DiVo 2003 creator Ru
Дата:        22 октября 2003 г.
***************************************************** }
 
procedure MassRand(range: integer; var inputMass: array of integer);
var
  i: integer;
  bm: array of boolean; //массив флагов для отслеживания было уже число
  или нет
begin
  SetLength(bm, length(inputMass));
  for i := 0 to length(inputMass) - 1 do
  begin
    inputMass[i] := Unic(bm, range) + 1; //для последовательности 1,2, ... , N
    //inputMass[i]:=Unic(bm,range);//для последовательности 0,1, ... , N
  end;
end;
 
function Unic(var flag: array of boolean; range: integer): integer;
begin
  {данная функция возвращает одно случайное число}
  result := random(range);
  while flag[result] do
    result := random(range); //ищем какого числа еще нет
  flag[result] := true; //это чтобы не было повторений
end;
Пример использования: 
 
// Использовать можно по разному, например:
procedure TForm1.BitBtn1Click(Sender: TObject);
var
  i: integer;
  mass: array of integer; //массив над которым будем извращаться
begin
  Memo1.Lines.Clear; //сюда выведем результат
  SetLength(mass, strtoint(Edit1.Text)); //тут получим размерность массива
  MassRand(strtoint(Edit1.Text), mass); //соответственно поимели процедуру
  for i := 0 to length(mass) - 1 do
  begin
    Memo1.Lines.Add(inttostr(mass[i])); //отобразили пользователю результат
  end;
end;
</pre>
<hr />
<p>Предлагаю Вам интересное решение заполнения массива случаными неповторяющимися значениями. Думаю этот алгоритм небесполезен. </p>
<pre>
type
  arr = array[1..255] of integer;
 
procedure FillArray(var A: arr; n: integer);
var
  i: integer;
  s: string;
  q: byte;
begin
  randomize;
  s := '';
  for i := 1 to n do
  begin
    q := random(i);
    insert(chr(i), s, q);
  end;
  for i := 1 to n do
  begin
    A[i] := ord(s[i]);
  end;
end; 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

