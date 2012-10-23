<h1>Бинарный поиск</h1>
<div class="date">25.04.2002</div>

<div class="author">Автор: Mystic, mystic2000@newmail.ru, ICQ:125905046</div>

<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Бинарный поиск
 
Бинарный поиск в целочисленном массиве - шаблон для функции,
выполняющей бинарный поиск.
X - значение, которое ищеться
A - массив в котором происходит поиск.
возвращаемое значение
индекс элемента, начиная с которого значения в массиве превышают заданное значение
в случае точного поиска заменить строку Result := L и -1 будет свидетельствовать 
о том, что значение не найдено.
 
Зависимости: System
Автор:       Mystic, mystic2000@newmail.ru, ICQ:125905046, Харьков
Copyright:   Mystic
Дата:        25 апреля 2002 г.
********************************************** }
 
function BinaryFind(X: Integer; A: array of Integer): Integer;
 
function RecurceFind(L,R: Integer): Integer;
var 
  M: Integer;
begin
  if R&lt;L then begin
    Result := L; // Result := -1 если поиск точный
    Exit;
  end;
  M := (L+R) div 2;
  if A[M]=X then
  begin
    Result := M;
    Exit;
  end;
  if A[M]&gt;X
    then Result := RecurceFind(L,M-1)
    else Result := RecurceFind(M+1,R)
end;
 
begin
  Result := RecurceFind(Low(A), High(A));
end;
</pre>
<hr />
<p>Примечания:</p>
<p>Александр Шарахов</p>
<p>Функцию BinaryFind можно усовершенствовать по нескольким направлениям:<br>
1. Повысить скорость работы, избавившись от рекурсии.<br>
2. При положительном результате поиска всегда возвращать индекс первого подходящего элемента.<br>
3. Совместить в одном флаконе точный и неточный поиск. Для этого при отрицательном результате поиска возвращать отрицательное значение Index-MaxInt, где Index - индекс первого элемента массива, больше искомого. Если такой элемент отсутствует, то возвращать (High(a)+1)-MaxInt.<br>
<p>Вот что у меня получилось:</p>
<pre>
function BinaryFind2(x: integer; const a: array of integer): integer;
var
i, j, m: integer;
found: boolean;
begin;
found:=false;
i:=-1;
j:=High(a);
while true do begin;
if i&gt;=j then break;
m:=(i+j+1) shr 1;
if a[m]&lt;x then i:=m
else begin;
j:=m-1;
if a[m]=x then found:=true;
end;
end;
Result:=i+1;
if not found then dec(Result,MaxInt);
end;
</pre>
<p><img src="/pic/embim1847.png" width="100" height="1" vspace="1" hspace="1" border="0" alt=""></p>

<p>Константиныч</p>
<p>Точно не проверял, но походу работает только если<br>
каждый элемент массива уникален.<br>
В противном случае будет выдаваться не первый элемент, подходящий по критерию поиска.<br>
&nbsp;<br>
<p>И надо было упомянуть, что массив д.б. отсортирован по возрастаню.</p>
<hr />
<p>Бинарный поиск в массиве</p>

<p>На практике довольно часто производится поиск в массиве, элементы которого упорядочены по некоторому критерию (такие массивы называются упорядоченными). Например, массив фамилий, как правило, упорядочен по алфавиту, массив данных о погоде &#8212; по датам наблюдений. В случае, если массив упорядочен, то применяют другие, более эффективные по сравнению с методом простого перебора алгоритмы, один из которых &#8212; метод бинарного поиска.</p>
<p>Пусть есть упорядоченный по возрастанию массив целых чисел. Нужно определить, содержит ли этот массив некоторое число (образец).</p>
<p>Метод (алгоритм) бинарного поиска реализуется следующим образом:</p>
<p>1. Сначала образец сравнивается со средним (по номеру) элементом массива</p>
<p>Если образец равен среднему элементу, то задача решена.</p>
<p>Если образец больше среднего элемента, то это значит, что искомый элемент расположен ниже среднего элемента (между элементами с номерами sred+1 и niz), и за новое значение verb принимается sred+i, а значение niz не меняется</p>
<p>Если образец меньше среднего элемента, то это значит, что искомый элемент расположен выше среднего элемента (между элементами с номерами verh и sred-1), и за новое значение niz принимается sred-1, а значение verh не меняется</p>
<p>2. После того как определена часть массива, в которой может находиться искомый элемент, по формуле (niz-verh) /2+verh вычисляется новое значение sred и поиск продолжается.</p>
<pre>
unit b_found_;
 
interface
uses
  Windows, Messages, SysUtils, Classes,
  Graphics, Controls, Forms, Dialogs, StdCtrls, Grids;
 
type
  TForm1 = class(TForm)
    Label1: TLabel;
    Label2: TLabel;
    Button1: TButton;
    Label3: TLabel;
    CheckBox1: TCheckBox;
    StringGrid1: TStringGrid;
    Editl: TEdit;
    procedure ButtonlClick(Sender: TObject);
    procedure StringGridlKeyPress(Sender: TObject; var Key: Char);
    procedure EditlKeyPress(Sender: TObject; var Key: Char);
  private
    {Private declarations }
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
{$R *.DFM}
 
{ Бинарным поиск в массиве }
procedure TForm1.Button1Click(Sender: TObject);
const
  SIZE = 10;
var
  a: array[1..SIZE] of integer; { массив }
  obr: integer; { образец для поиска}
  verh: integer; { верхняя граница поиска }
  niz: integer; { нижняя граница поиска }
  sred: integer; { номер среднего элемента }
  found: boolean; { TRUE — совпадение образца с элементом массива }
  n: integer; { число сравнений с образцом}
  i: integer;
begin
  // ввод массива и образца
  for i := l to SIZE do
    a[i] := StrToInt(StringGridl.Cells[i - l, 0]);
  obr := StrToInt(Editl.text);
  // поиск verh:=1;
  niz := SIZE; n := 0;
  found := FALSE; labels.caption := '';
  if CheckBoxl.State = cbChecked then
    Labels.caption: = 'verh' + #9 + 'niz'#9'sred'   #13;
  // бинарный поиск в массиве
  repeat
    sred := Trunc((niz - verh) / 2) + verh;
    if CheckBox1.Checked then
      Labels.caption := label3.caption + IntToStr(yerh) + #9
        + IntToStr(niz) + #9 + IntToStr(sred) + #13; n := n + 1;
    if a[sred] = obr then
      found := TRUE
    else
    if obr &lt; a[sred] then
      niz := sred - 1
    else
      verh := sred + 1;
  until
    (verh &gt; niz) or found;
 
  if found then
    labels.caption := label3.caption
      + 'Совпадение с элементом номер '
      + IntToStr(sred) + #13 + 'Сравнений '
      + IntToStr(n)
  else
    label3.caption := label3.caption
      + 'Образец в массиве не найден.';
end;
 
// нажатие клавиши в ячейке StringGrid
procedure TForml.StringGridlKeyPress(Sender: TObject; var Key: Char),
begin
  if Key = #13 then // нажата клавиша &lt;Enter&gt;
    // курсор в следующую ячейку таблицы
    if StringGrid1.Col &lt; StringGridl.ColCount - 1 then
      StringGridl.Col := StringGrid1.Col + 1
    else // курсор в поле Editl, в поле ввода образца
      Editl.SetFocus;
end;
 
// нажатие клавиши в поле Editl
procedure TForm1.Edit1KeyPress(Sender: TObject; .var Key: Char);
begin
  // нажата клавиша &lt;Enter&gt;
  if Key = #13 then // сделать активной командную кнопку
    Button1.SetFocus;
end;
 
end.
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<hr />
<pre>
function FoundByBinarySearch(
  LowIdx,
  HighIdx: LongInt;
  var Result: LongInt;
  const GoalIs: CompareFunc;
  var Data;
  var Goal
  ): Boolean;
var
  CompVal: CompareResults;
begin
  FoundByBinarySearch := FALSE;
 
  if HighIdx &lt; LowIdx then
    Exit;
 
  Result := LowIdx + ((HighIdx - LowIdx) div 2);
  CompVal := GoalIs(Result, Data, Goal);
 
  if CompVal = BinEqual then
    FoundByBinarySearch := TRUE
  else if (LowIdx &lt; HighIdx) then
  begin
    if CompVal = BinLess then
      HighIdx := Result - 1
    else {CompVal = BinGreater}
      LowIdx := Result + 1;
    FoundByBinarySearch := FoundByBinarySearch(
      LowIdx, HighIdx, Result, GoalIs, Data, Goal)
  end
  else if (CompVal = BinLess) then
    Dec(Result)
end; { function FoundByBinarySearch }
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
