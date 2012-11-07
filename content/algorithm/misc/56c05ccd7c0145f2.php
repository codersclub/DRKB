<h1>Как вычислить математическое выражение?</h1>
<div class="date">01.01.2007</div>


<p>Зачастую пользователь должен ввести что-то типа "1+2/(3*4)" и программа должна разобрать выражение и произвести вычисления. Делается это с помощью рекурсивных функций, которые постеменно разбирают выражение. К счастью не обязательно изобретать велосипед: в бесплатной библиотеке RxLib есть модуль Parsing.pas включающий в себя класс для вычисления математических выражений, библиотеку можно взять на</p>
<p><a href="https://www.rxlib.ru/Downl/Downl.htm " target="_blank">https://www.rxlib.ru/Downl/Downl.htm</a></p>
<p>или</p>
<p><a href="https://www.torry.net " target="_blank">https://www.torry.net</a></p>
<p>Модуль Parsing.pas вполне может работать отдельно и без установки пакета компонент (но в таком случае вам прийдется взять еще несколько inc файлов помимо него).</p>
<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

<hr />

<p>В Delphi нет функции, которая бы позволяла посчитать строку с формулой. Но есть множество способов реализовать это самому. Здесь я привел самый простой из них. Он не очень быстрый, но при нынешних скоростях компьютеров для многих целей он подойдет.</p>
<p>Принцип его заключается в следующем. Сначала строка оптимизируется - выкидываются все пробелы, точки и запятые меняются на установленный разделяющий знак (DecimalSeparator). Все числа и параметры (например, x), содержащиеся в строке "обособляются" символом #. В дальнейшем это позволяет избежать путаницы с экспонентой, минусами и. т. д. Следующий шаг - замена, если нужно, всех параметров на их значения. И, наконец, последний шаг, подсчет получившейся строки. Для этого программа ищет все операции с самым высоким приоритетом (это скобки). Считает их значение, вызывая саму себя (рекурсивная функция), и заменяет скобки и их содержимое на их значение, обособленное #. Дальше она выполняет то же самое для операции с более низким приоритетом и так до сложения с вычитанием.</p>
<p>Каждый шаг выделен в отдельную процедуру. Это позволяет быстрее считать функцию, если она не меняется, а меняются только значения параметров.</p>
<p>Вот модуль с этими методами.</p>
<pre>
unit Recognition;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, Math;
 
type
  TVar = set of char;
 
procedure Preparation(var s: String; variables: TVar);
function ChangeVar(s: String; c: char; value: extended): String;
function Recogn(st: String; var Num: extended): boolean;
 
implementation
 
 
procedure Preparation(var s: String; variables: TVar);
const
  operators: set of char = ['+','-','*', '/', '^'];
var
  i: integer;
  figures: set of char;
begin
  figures := ['0','1','2','3','4','5','6','7','8','9', DecimalSeparator] + variables;
 
// " "
  repeat
    i := pos(' ', s);
    if i &lt;= 0 then break;
    delete(s, i, 1);
 
  until 1 = 0;
 
  s := LowerCase(s);
 
// ".", ","
  if DecimalSeparator = '.' then begin
    i := pos(',', s);
    while i &gt; 0 do begin
      s[i] := '.';
      i := pos(',', s);
    end;
  end else begin
    i := pos('.', s);
    while i &gt; 0 do begin
      s[i] := ',';
      i := pos('.', s);
    end;
  end;
 
// Pi
 
  repeat
    i := pos('pi', s);
    if i &lt;= 0 then break;
    delete(s, i, 2);
    insert(FloatToStr(Pi), s, i);
  until 1 = 0;
 
// ":"
  repeat
    i := pos(':', s);
    if i &lt;= 0 then break;
    s[i] := '/';
  until 1 = 0;
 
// |...|
  repeat
    i := pos('|', s);
    if i &lt;= 0 then break;
    s[i] := 'a';
    insert('bs(', s, i + 1);
    i := i + 3;
 
    repeat i := i + 1 until (i &gt; Length(s)) or (s[i] = '|');
    if s[i] = '|' then s[i] := ')';
  until 1 = 0;
 
// #...#
  i := 1;
  repeat
    if s[i] in figures then begin
      insert('#', s, i);
      i := i + 2;
      while (s[i] in figures) do i := i + 1;
      insert('#', s, i);
      i := i + 1;
    end;
    i := i + 1;
  until i &gt; Length(s);
 
end;
 
function ChangeVar(s: String; c: char; value: extended): String;
var
  p: integer;
begin
  result := s;
  repeat
    p := pos(c, result);
    if p &lt;= 0 then break;
    delete(result, p, 1);
    insert(FloatToStr(value), result, p);
  until 1 = 0;
end;
 
function Recogn(st: String; var Num: extended): boolean;
const
  pogr = 1E-5;
var
 
  p, p1: integer;
  i, j: integer;
  v1, v2: extended;
  func: (fNone, fSin, fCos, fTg, fCtg, fArcsin, fArccos, fArctg, fArcctg, fAbs, fLn, fLg, fExp);
  Sign: integer;
  s: String;
  s1: String;
 
  function FindLeftValue(p: integer; var Margin: integer; var Value: extended): boolean;
  var
    i: integer;
  begin
    i := p - 1;
    repeat i := i - 1 until (i &lt;= 0) or (s[i] = '#');
 
    Margin := i;
    try
      Value := StrToFloat(copy(s, i + 1, p - i - 2));
      result := true;
    except
      result := false
    end;
    delete(s, i, p - i);
  end;
 
  function FindRightValue(p: integer; var Value: extended): boolean;
  var
    i: integer;
  begin
    i := p + 1;
    repeat i := i + 1 until (i &gt; Length(s)) or (s[i] = '#');
    i := i - 1;
    s1 := copy(s, p + 2, i - p - 1);
 
    result := TextToFloat(PChar(s1), value, fvExtended);
    delete(s, p + 1, i - p + 1);
  end;
 
  procedure PutValue(p: integer; NewValue: extended);
  begin
    insert('#' + FloatToStr(v1) + '#', s, p);
  end;
 
begin
  Result := false;
  s := st;
 
// ()
  p := pos('(', s);
  while p &gt; 0 do begin
    i := p;
    j := 1;
    repeat
      i := i + 1;
      if s[i] = '(' then j := j + 1;
 
      if s[i] = ')' then j := j - 1;
    until (i &gt; Length(s)) or (j &lt;= 0);
    if i &gt; Length(s) then s := s + ')';
    if Recogn(copy(s, p + 1, i - p - 1), v1) = false then Exit;
    delete(s, p, i - p + 1);
    PutValue(p, v1);
 
    p := pos('(', s);
  end;
 
// sin, cos, tg, ctg, arcsin, arccos, arctg, arcctg, abs, ln, lg, log, exp
  repeat
    func := fNone;
    p1 := pos('sin', s);
 
    if p1 &gt; 0 then begin
      func := fSin;
      p := p1;
    end;
    p1 := pos('cos', s);
    if p1 &gt; 0 then begin
      func := fCos;
      p := p1;
    end;
    p1 := pos('tg', s);
    if p1 &gt; 0 then begin
      func := fTg;
      p := p1;
    end;
    p1 := pos('ctg', s);
    if p1 &gt; 0 then begin
      func := fCtg;
      p := p1;
 
    end;
    p1 := pos('arcsin', s);
    if p1 &gt; 0 then begin
      func := fArcsin;
      p := p1;
    end;
    p1 := pos('arccos', s);
    if p1 &gt; 0 then begin
      func := fArccos;
      p := p1;
    end;
    p1 := pos('arctg', s);
    if p1 &gt; 0 then begin
      func := fArctg;
      p := p1;
    end;
    p1 := pos('arcctg', s);
    if p1 &gt; 0 then begin
 
      func := fArcctg;
      p := p1;
    end;
    p1 := pos('abs', s);
    if p1 &gt; 0 then begin
      func := fAbs;
      p := p1;
    end;
    p1 := pos('ln', s);
    if p1 &gt; 0 then begin
      func := fLn;
      p := p1;
    end;
    p1 := pos('lg', s);
    if p1 &gt; 0 then begin
      func := fLg;
      p := p1;
    end;
    p1 := pos('exp', s);
    if p1 &gt; 0 then begin
 
      func := fExp;
      p := p1;
    end;
    if func = fNone then break;
 
    case func of
      fSin, fCos, fCtg, fAbs, fExp: i := p + 2;
      fArctg: i := p + 4;
      fArcsin, fArccos, fArcctg: i := p + 5;
      else i := p + 1;
    end;
    if FindRightValue(i, v1) = false then Exit;
    delete(s, p, i - p + 1);
    case func of
      fSin: v1 := sin(v1);
      fCos: v1 := cos(v1);
 
      fTg: begin
        if abs(cos(v1)) &lt; pogr then Exit;
        v1 := sin(v1) / cos(v1);
      end;
      fCtg: begin
        if abs(sin(v1)) &lt; pogr then Exit;
        v1 := cos(v1) / sin(v1);
      end;
      fArcsin: begin
        if Abs(v1) &gt; 1 then Exit;
        v1 := arcsin(v1);
      end;
      fArccos: begin
        if abs(v1) &gt; 1 then Exit;
 
        v1 := arccos(v1);
      end;
      fArctg: v1 := arctan(v1);
//      fArcctg: v1 := arcctan(v1);
      fAbs: v1 := abs(v1);
      fLn: begin
        if v1 &lt; pogr then Exit;
        v1 := Ln(v1);
      end;
      fLg: begin
        if v1 &lt; 0 then Exit;
        v1 := Log10(v1);
      end;
      fExp: v1 := exp(v1);
    end;
    PutValue(p, v1);
  until func = fNone;
 
// power
  p := pos('^', s);
  while p &gt; 0 do begin
    if FindRightValue(p, v2) = false then Exit;
    if FindLeftValue(p, i, v1) = false then Exit;
    if (v1 &lt; 0) and (abs(Frac(v2)) &gt; pogr) then Exit;
    if (abs(v1) &lt; pogr) and (v2 &lt; 0) then Exit;
    delete(s, i, 1);
    v1 := Power(v1, v2);
    PutValue(i, v1);
    p := pos('^', s);
  end;
 
// *, /
  p := pos('*', s);
  p1 := pos('/', s);
  if (p1 &gt; 0) and ((p1 &lt; p) or (p &lt;= 0)) then p := p1;
  while p &gt; 0 do begin
    if FindRightValue(p, v2) = false then Exit;
    if FindLeftValue(p, i, v1) = false then Exit;
    if s[i] = '*'
      then v1 := v1 * v2
      else begin
        if abs(v2) &lt; pogr then Exit;
 
        v1 := v1 / v2;
      end;
    delete(s, i, 1);
    PutValue(i, v1);
 
    p := pos('*', s);
    p1 := pos('/', s);
    if (p1 &gt; 0) and ((p1 &lt; p) or (p &lt;= 0)) then p := p1;
  end;
 
// +, -
  Num := 0;
  repeat
    Sign := 1;
    while (Length(s) &gt; 0) and (s[1] &lt;&gt; '#') do begin
      if s[1] = '-' then Sign := -Sign
        else if s[1] &lt;&gt; '+' then Exit;
 
      delete(s, 1, 1);
    end;
    if FindRightValue(0, v1) = false then Exit;
    if Sign &lt; 0
      then Num := Num - v1
      else Num := Num + v1;
  until Length(s) &lt;= 0;
 
  Result := true;
end;
 
end.
</pre>
<p>А это пример использования этого модуля. Он рисует график функции, введенной в Edit1. Константы left и right определяют края графика, а YScale - масштаб по Y.</p>
<pre>
uses Recognition;
 
procedure TForm1.Button1Click(Sender: TObject);
const
  left = -10;
  right = 10;
  YScale = 50;
var
  i: integer;
  Num: extended;
  s: String;
  XScale: single;
  col: TColor;
begin
  s := Edit1.Text;
  preparation(s, ['x']);
 
  XScale := PaintBox1.Width / (right - left);
  randomize;
  col := RGB(random(100), random(100), random(100));
  for i := round(left * XScale) to round(right * XScale) do
    if recogn(ChangeVar(s, 'x', i / XScale), Num) then
      PaintBox1.Canvas.Pixels[round(i - left * XScale),
        round(PaintBox1.Height / 2 - Num * YScale)] := col;
end;
</pre>

<div class="author">Автор: Даниил Карапетян (delphi4all@narod.ru)</div>
<div class="author">Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)</div>

<hr />

<p>Отличная реализация есть в бесплатной библиотеке для дельфи JVCL. Помимо стандартных требований которые решены во всех приведенных примерах, там ещё есть интерфейс для простого подключения любых своих функций, например буквально парой строчек можно подключить распознавание и вычисление гиперболических функций из модуля Math. Настоятельно рекомендую этот пакет всем кто работает на Дельфи - там есть почти всё что требуется для комфортной работы</p>
<div class="author">Автор: Vit</div>

<hr />

<p>Вычислитель математических формул</p>
<p>Вот что я обнаружил несколько дней назад при просмотре зарубежных источников:</p>
<p>FORMULA должна быть стокой, содержащей формулу. Допускаются переменные x, y и z, а также операторы, перечисленные ниже. Пример:</p>
<p>sin(x)*cos(x^y)+exp(cos(x))</p>

<p>Использование:</p>
<pre>
uses EVALCOMP;
 
var
  calc: EVALVEC; {evalvec - указатель на объект, определяемый evalcomp}
  FORMULA: string;
begin
  FORMULA := 'x+y+z';
 
  new(calc, init(FORMULA));
  (Построение дерева оценки)
 
  writeln(calc^.eval1d(7));
  (x = 7 y = 0 z = 0; result: 7)
    writeln(calc^.eval2d(7, 8));
  (x = 7 y = 8 z = 0; result: 15)
    writeln(calc^.eval3d(7, 8, 9));
  (x = 7 y = 8 z = 9; result: 24)
 
  dispose(calc, done);
  (разрушение дерева оценки)
end.
 
</pre>
<p>Допустимые операторы:</p>
x &lt;l;&gt; y ; // Логические операторы возвращают 1 в случае истины и 0 если ложь.
x &lt;l;= y
x &gt;= y
x &gt; y
x &lt;l; y
x = y
x + y
x - y
x eor y //( исключающее или )
x or y
x * y
x / y
x and y
x mod y
x div y
x ^ y //( степень )
x shl y
x shr y
not (x)
sinc (x)
sinh (x)
cosh (x)
tanh (x)
coth (x)
sin (x)
cos (x)
tan (x)
cot (x)
sqrt (x)
sqr (x)
arcsinh (x)
arccosh (x)
arctanh (x)
arccoth (x)
arcsin (x)
arccos (x)
arctan (x)
arccot (x)
heavy (x) //; 1 для положительных чисел, 0 для остальных
sgn (x) //; 1 для положительных чисел, -1 для отрицательных и 0 для нуля
frac (x)
exp (x)
abs (x)
trunc (x)
ln (x)
odd (x)
pred (x)
succ (x)
round (x)
int (x)
fac (x) //; x*(x-1)*(x-2)*...*3*2*1
rnd //; Случайное число в диапазоне [0,1]
rnd (x) //; Случайное число в диапазоне [0,x]
pi
<p>e</p>
<pre>
unit evalcomp;
 
interface
 
type
  fun = function(x, y: real): real;
 
  evalvec = ^evalobj;
  evalobj = object
    f1, f2: evalvec;
    f1x, f2y: real;
    f3: fun;
    function eval: real;
    function eval1d(x: real): real;
    function eval2d(x, y: real): real;
    function eval3d(x, y, z: real): real;
    constructor init(st: string);
    destructor done;
  end;
var
  evalx, evaly, evalz: real;
 
implementation
 
var
  analysetmp: fun;
 
function search(text, code: string; var pos: integer): boolean;
var
  i, count: integer;
 
  flag: boolean;
  newtext: string;
begin
 
  if length(text) &lt; l;
  length(code) then
  begin
    search := false;
    exit;
  end;
  flag := false;
  pos := length(text) - length(code) + 1;
  repeat
    if code = copy(text, pos, length(code)) then
      flag := true
    else
      dec(pos);
    if flag then
    begin
      count := 0;
      for i := pos + 1 to length(text) do
      begin
        if copy(text, i, 1) = '(' then
          inc(count);
        if copy(text, i, 1) = ')' then
          dec(count);
      end;
      if count &lt; l;
      &gt; 0 then
      begin
        dec(pos);
        flag := false;
      end;
    end;
  until (flag = true) or (pos = 0);
  search := flag;
end;
 
function myid(x, y: real): real;
begin
 
  myid := x;
end;
 
function myunequal(x, y: real): real;
begin
 
  if x &lt;&gt; y then
    myunequal := 1
  else
    myunequal := 0;
end;
 
function mylessequal(x, y: real): real;
begin
 
  if x &lt;= y then
    mylessequal := 1
  else
    mylessequal := 0;
end;
 
function mygreaterequal(x, y: real): real;
begin
 
  if x &gt;= y then
    mygreaterequal := 1
  else
    mygreaterequal := 0;
end;
 
function mygreater(x, y: real): real;
begin
 
  if x &gt; y then
    mygreater := 1
  else
    mygreater := 0;
end;
 
function myless(x, y: real): real;
begin
 
  if x &lt; y then
    myless := 1
  else
    myless := 0;
end;
 
function myequal(x, y: real): real;
begin
 
  if x = y then
    myequal := 1
  else
    myequal := 0;
end;
 
function myadd(x, y: real): real;
begin
 
  myadd := x + y;
end;
 
function mysub(x, y: real): real;
begin
 
  mysub := x - y;
end;
 
function myeor(x, y: real): real;
begin
 
  myeor := trunc(x) xor trunc(y);
end;
 
function myor(x, y: real): real;
begin
 
  myor := trunc(x) or trunc(y);
end;
 
function mymult(x, y: real): real;
begin
 
  mymult := x * y;
end;
 
function mydivid(x, y: real): real;
begin
 
  mydivid := x / y;
end;
 
function myand(x, y: real): real;
begin
 
  myand := trunc(x) and trunc(y);
end;
 
function mymod(x, y: real): real;
begin
 
  mymod := trunc(x) mod trunc(y);
end;
 
function mydiv(x, y: real): real;
begin
 
  mydiv := trunc(x) div trunc(y);
end;
 
function mypower(x, y: real): real;
begin
 
  if x = 0 then
    mypower := 0
  else if x &gt; 0 then
    mypower := exp(y * ln(x))
  else if trunc(y) &lt;&gt; y then
  begin
    writeln(' Немогу вычислить x^y ');
    halt;
  end
  else if odd(trunc(y)) = true then
    mypower := -exp(y * ln(-x))
  else
    mypower := exp(y * ln(-x))
end;
 
function myshl(x, y: real): real;
begin
 
  myshl := trunc(x) shl trunc(y);
end;
 
function myshr(x, y: real): real;
begin
 
  myshr := trunc(x) shr trunc(y);
end;
 
function mynot(x, y: real): real;
begin
 
  mynot := not trunc(x);
end;
 
function mysinc(x, y: real): real;
begin
  if x = 0 then
 
    mysinc := 1
  else
 
    mysinc := sin(x) / x
end;
 
function mysinh(x, y: real): real;
begin
  mysinh := 0.5 * (exp(x) - exp(-x))
end;
 
function mycosh(x, y: real): real;
begin
  mycosh := 0.5 * (exp(x) + exp(-x))
end;
 
function mytanh(x, y: real): real;
begin
  mytanh := mysinh(x, 0) / mycosh(x, 0)
end;
 
function mycoth(x, y: real): real;
begin
  mycoth := mycosh(x, 0) / mysinh(x, 0)
end;
 
function mysin(x, y: real): real;
begin
  mysin := sin(x)
end;
 
function mycos(x, y: real): real;
begin
  mycos := cos(x)
end;
 
function mytan(x, y: real): real;
begin
  mytan := sin(x) / cos(x)
end;
 
function mycot(x, y: real): real;
begin
  mycot := cos(x) / sin(x)
end;
 
function mysqrt(x, y: real): real;
begin
  mysqrt := sqrt(x)
end;
 
function mysqr(x, y: real): real;
begin
  mysqr := sqr(x)
end;
 
function myarcsinh(x, y: real): real;
begin
  myarcsinh := ln(x + sqrt(sqr(x) + 1))
end;
 
function mysgn(x, y: real): real;
begin
  if x = 0 then
 
    mysgn := 0
  else
 
    mysgn := x / abs(x)
end;
 
function myarccosh(x, y: real): real;
begin
  myarccosh := ln(x + mysgn(x, 0) * sqrt(sqr(x) - 1))
end;
 
function myarctanh(x, y: real): real;
begin
  myarctanh := ln((1 + x) / (1 - x)) / 2
end;
 
function myarccoth(x, y: real): real;
begin
  myarccoth := ln((1 - x) / (1 + x)) / 2
end;
 
function myarcsin(x, y: real): real;
begin
  if x = 1 then
 
    myarcsin := pi / 2
  else
 
    myarcsin := arctan(x / sqrt(1 - sqr(x)))
end;
 
function myarccos(x, y: real): real;
begin
  myarccos := pi / 2 - myarcsin(x, 0)
end;
 
function myarctan(x, y: real): real;
begin
  myarctan := arctan(x);
end;
 
function myarccot(x, y: real): real;
begin
  myarccot := pi / 2 - arctan(x)
end;
 
function myheavy(x, y: real): real;
begin
  myheavy := mygreater(x, 0)
end;
 
function myfrac(x, y: real): real;
begin
  myfrac := frac(x)
end;
 
function myexp(x, y: real): real;
begin
  myexp := exp(x)
end;
 
function myabs(x, y: real): real;
begin
  myabs := abs(x)
end;
 
function mytrunc(x, y: real): real;
begin
  mytrunc := trunc(x)
end;
 
function myln(x, y: real): real;
begin
  myln := ln(x)
end;
 
function myodd(x, y: real): real;
begin
  if odd(trunc(x)) then
 
    myodd := 1
  else
 
    myodd := 0;
end;
 
function mypred(x, y: real): real;
begin
  mypred := pred(trunc(x));
end;
 
function mysucc(x, y: real): real;
begin
  mysucc := succ(trunc(x));
end;
 
function myround(x, y: real): real;
begin
  myround := round(x);
end;
 
function myint(x, y: real): real;
begin
  myint := int(x);
end;
 
function myfac(x, y: real): real;
var
  n: integer;
 
  r: real;
begin
  if x &lt; 0 then
  begin
    writeln(' Немогу вычислить факториал ');
    halt;
  end;
  if x = 0 then
    myfac := 1
  else
 
  begin
    r := 1;
    for n := 1 to trunc(x) do
      r := r * n;
    myfac := r;
  end;
end;
 
function myrnd(x, y: real): real;
begin
  myrnd := random;
end;
 
function myrandom(x, y: real): real;
begin
  myrandom := random(trunc(x));
end;
 
function myevalx(x, y: real): real;
begin
  myevalx := evalx;
end;
 
function myevaly(x, y: real): real;
begin
  myevaly := evaly;
end;
 
function myevalz(x, y: real): real;
begin
  myevalz := evalz;
end;
 
procedure analyse(st: string; var st2, st3: string);
label
  start;
 
var
  pos: integer;
  value: real;
  newterm, term: string;
begin
  term := st;
  start:
 
  if term = '' then
  begin
    analysetmp := myid;
    st2 := '0';
    st3 := '';
    exit;
  end;
  newterm := '';
  for pos := 1 to length(term) do
    if copy(term, pos, 1) &lt;&gt; ' ' then
      newterm := newterm + copy(term, pos, 1);
  term := newterm;
  if term = '' then
  begin
    analysetmp := myid;
    st2 := '0';
    st3 := '';
    exit;
  end;
  val(term, value, pos);
  if pos = 0 then
  begin
    analysetmp := myid;
    st2 := term;
    st3 := '';
    exit;
  end;
  if search(term, '&lt;&gt;', pos) then
  begin
    analysetmp := myunequal;
    st2 := copy(term, 1, pos - 1);
    st3 := copy(term, pos + 2, length(term) - pos - 1);
    exit;
  end;
  if search(term, '&lt;=', pos) then
  begin
    analysetmp := mylessequal;
    st2 := copy(term, 1, pos - 1);
    st3 := copy(term, pos + 2, length(term) - pos - 1);
    exit;
  end;
  if search(term, '&gt;=', pos) then
  begin
    analysetmp := mygreaterequal;
    st2 := copy(term, 1, pos - 1);
    st3 := copy(term, pos + 2, length(term) - pos - 1);
    exit;
  end;
  if search(term, '&gt;', pos) then
  begin
    analysetmp := mygreater;
    st2 := copy(term, 1, pos - 1);
    st3 := copy(term, pos + 1, length(term) - pos);
    exit;
  end;
  if search(term, '&lt;', pos) then
  begin
    analysetmp := myless;
    st2 := copy(term, 1, pos - 1);
    st3 := copy(term, pos + 1, length(term) - pos);
    exit;
  end;
  if search(term, '=', pos) then
  begin
    analysetmp := myequal;
    st2 := copy(term, 1, pos - 1);
    st3 := copy(term, pos + 1, length(term) - pos);
    exit;
  end;
  if search(term, '+', pos) then
  begin
    analysetmp := myadd;
    st2 := copy(term, 1, pos - 1);
    st3 := copy(term, pos + 1, length(term) - pos);
    exit;
  end;
  if search(term, '-', pos) then
  begin
    analysetmp := mysub;
    st2 := copy(term, 1, pos - 1);
    st3 := copy(term, pos + 1, length(term) - pos);
    exit;
  end;
  if search(term, 'eor', pos) then
  begin
    analysetmp := myeor;
    st2 := copy(term, 1, pos - 1);
    st3 := copy(term, pos + 3, length(term) - pos - 2);
    exit;
  end;
  if search(term, 'or', pos) then
  begin
    analysetmp := myor;
    st2 := copy(term, 1, pos - 1);
    st3 := copy(term, pos + 2, length(term) - pos - 1);
    exit;
  end;
  if search(term, '*', pos) then
  begin
    analysetmp := mymult;
    st2 := copy(term, 1, pos - 1);
    st3 := copy(term, pos + 1, length(term) - pos);
    exit;
  end;
  if search(term, '/', pos) then
  begin
    analysetmp := mydivid;
    st2 := copy(term, 1, pos - 1);
    st3 := copy(term, pos + 1, length(term) - pos);
    exit;
  end;
  if search(term, 'and', pos) then
  begin
    analysetmp := myand;
    st2 := copy(term, 1, pos - 1);
    st3 := copy(term, pos + 3, length(term) - pos - 2);
    exit;
  end;
  if search(term, 'mod', pos) then
  begin
    analysetmp := mymod;
    st2 := copy(term, 1, pos - 1);
    st3 := copy(term, pos + 3, length(term) - pos - 2);
    exit;
  end;
  if search(term, 'div', pos) then
  begin
    analysetmp := mydiv;
    st2 := copy(term, 1, pos - 1);
    st3 := copy(term, pos + 3, length(term) - pos - 2);
    exit;
  end;
  if search(term, '^', pos) then
  begin
    analysetmp := mypower;
    st2 := copy(term, 1, pos - 1);
    st3 := copy(term, pos + 1, length(term) - pos);
    exit;
  end;
  if search(term, 'shl', pos) then
  begin
    analysetmp := myshl;
    st2 := copy(term, 1, pos - 1);
    st3 := copy(term, pos + 3, length(term) - pos - 2);
    exit;
  end;
  if search(term, 'shr', pos) then
  begin
    analysetmp := myshr;
    st2 := copy(term, 1, pos - 1);
    st3 := copy(term, pos + 3, length(term) - pos - 2);
    exit;
  end;
  if copy(term, 1, 1) = '(' then
  begin
    term := copy(term, 2, length(term) - 2);
    goto start;
  end;
  if copy(term, 1, 3) = 'not' then
  begin
    analysetmp := mynot;
    st2 := copy(term, 4, length(term) - 3);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 4) = 'sinc' then
  begin
    analysetmp := mysinc;
    st2 := copy(term, 5, length(term) - 4);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 4) = 'sinh' then
  begin
    analysetmp := mysinh;
    st2 := copy(term, 5, length(term) - 4);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 4) = 'cosh' then
  begin
    analysetmp := mycosh;
    st2 := copy(term, 5, length(term) - 4);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 4) = 'tanh' then
  begin
    analysetmp := mytanh;
    st2 := copy(term, 5, length(term) - 4);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 4) = 'coth' then
  begin
    analysetmp := mycoth;
    st2 := copy(term, 5, length(term) - 4);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 3) = 'sin' then
  begin
    analysetmp := mysin;
    st2 := copy(term, 4, length(term) - 3);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 3) = 'cos' then
  begin
    analysetmp := mycos;
    st2 := copy(term, 4, length(term) - 3);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 3) = 'tan' then
  begin
    analysetmp := mytan;
    st2 := copy(term, 4, length(term) - 3);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 3) = 'cot' then
  begin
    analysetmp := mycot;
    st2 := copy(term, 4, length(term) - 3);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 4) = 'sqrt' then
  begin
    analysetmp := mysqrt;
    st2 := copy(term, 5, length(term) - 4);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 3) = 'sqr' then
  begin
    analysetmp := mysqr;
    st2 := copy(term, 4, length(term) - 3);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 7) = 'arcsinh' then
  begin
    analysetmp := myarcsinh;
    st2 := copy(term, 8, length(term) - 7);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 7) = 'arccosh' then
  begin
    analysetmp := myarccosh;
    st2 := copy(term, 8, length(term) - 7);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 7) = 'arctanh' then
  begin
    analysetmp := myarctanh;
    st2 := copy(term, 8, length(term) - 7);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 7) = 'arccoth' then
  begin
    analysetmp := myarccoth;
    st2 := copy(term, 8, length(term) - 7);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 6) = 'arcsin' then
  begin
    analysetmp := myarcsin;
    st2 := copy(term, 7, length(term) - 6);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 6) = 'arccos' then
  begin
    analysetmp := myarccos;
    st2 := copy(term, 7, length(term) - 6);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 6) = 'arctan' then
  begin
    analysetmp := myarctan;
    st2 := copy(term, 7, length(term) - 6);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 6) = 'arccot' then
  begin
    analysetmp := myarccot;
    st2 := copy(term, 7, length(term) - 6);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 5) = 'heavy' then
  begin
    analysetmp := myheavy;
    st2 := copy(term, 6, length(term) - 5);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 3) = 'sgn' then
  begin
    analysetmp := mysgn;
    st2 := copy(term, 4, length(term) - 3);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 4) = 'frac' then
  begin
    analysetmp := myfrac;
    st2 := copy(term, 5, length(term) - 4);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 3) = 'exp' then
  begin
    analysetmp := myexp;
    st2 := copy(term, 4, length(term) - 3);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 3) = 'abs' then
  begin
    analysetmp := myabs;
    st2 := copy(term, 4, length(term) - 3);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 5) = 'trunc' then
  begin
    analysetmp := mytrunc;
    st2 := copy(term, 6, length(term) - 5);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 2) = 'ln' then
  begin
    analysetmp := myln;
    st2 := copy(term, 3, length(term) - 2);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 3) = 'odd' then
  begin
    analysetmp := myodd;
    st2 := copy(term, 4, length(term) - 3);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 4) = 'pred' then
  begin
    analysetmp := mypred;
    st2 := copy(term, 5, length(term) - 4);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 4) = 'succ' then
  begin
    analysetmp := mysucc;
    st2 := copy(term, 5, length(term) - 4);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 5) = 'round' then
  begin
    analysetmp := myround;
    st2 := copy(term, 6, length(term) - 5);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 3) = 'int' then
  begin
    analysetmp := myint;
    st2 := copy(term, 4, length(term) - 3);
    st3 := '';
    exit;
  end;
  if copy(term, 1, 3) = 'fac' then
  begin
    analysetmp := myfac;
    st2 := copy(term, 4, length(term) - 3);
    st3 := '';
    exit;
  end;
  if term = 'rnd' then
  begin
    analysetmp := myrnd;
    st2 := '';
    st3 := '';
    exit;
  end;
  if copy(term, 1, 3) = 'rnd' then
  begin
    analysetmp := myrandom;
    st2 := copy(term, 4, length(term) - 3);
    st3 := '';
    exit;
  end;
  if term = 'x' then
  begin
    analysetmp := myevalx;
    st2 := '';
    st3 := '';
    exit;
  end;
  if term = 'y' then
  begin
    analysetmp := myevaly;
    st2 := '';
    st3 := '';
    exit;
  end;
  if term = 'z' then
  begin
    analysetmp := myevalz;
    st2 := '';
    st3 := '';
    exit;
  end;
  if (term = 'pi') then
  begin
    analysetmp := myid;
    str(pi, st2);
    st3 := '';
    exit;
  end;
  if term = 'e' then
  begin
    analysetmp := myid;
    str(exp(1), st2);
    sst3 := '';
    exit;
  end;
  writeln(' ВНИМАНИЕ : НЕДЕКОДИРУЕМАЯ ФОРМУЛА ');
  analysetmp := myid;
  st2 := '';
  st3 := '';
end;
 
function evalobj.eval: real;
var
  tmpx, tmpy: real;
begin
 
  if f1 = nil then
    tmpx := f1x
  else
    tmpx := f1^.eval;
  if f2 = nil then
    tmpy := f2y
  else
    tmpy := f2^.eval;
  eval := f3(tmpx, tmpy);
end;
 
function evalobj.eval1d(x: real): real;
begin
  evalx := x;
  evaly := 0;
  evalz := 0;
  eval1d := eval;
end;
 
function evalobj.eval2d(x, y: real): real;
begin
  evalx := x;
  evaly := y;
  evalz := 0;
  eval2d := eval;
end;
 
function evalobj.eval3d(x, y, z: real): real;
begin
  evalx := x;
  evaly := y;
  evalz := z;
  eval3d := eval;
end;
 
constructor evalobj.init(st: string);
var
  st2, st3: string;
 
  error: integer;
begin
  f1 := nil;
  f2 := nil;
  analyse(st, st2, st3);
  f3 := analysetmp;
  val(st2, f1x, error);
  if st2 = '' then
  begin
 
    f1x := 0;
    error := 0;
  end;
  if error &lt;&gt; 0 then
 
    new(f1, init(st2));
  val(st3, f2y, error);
  if st3 = '' then
  begin
 
    f2y := 0;
    error := 0;
  end;
  if error &lt;&gt; 0 then
 
    new(f2, init(st3));
end;
 
destructor evalobj.done;
begin
  if f1 &lt;&gt; nil then
 
    dispose(f1, done);
  if f2 &lt;&gt; nil then
 
    dispose(f2, done);
end;
 
end.
 
 
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<hr />
<pre>
unit MathComponent;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls,
  Forms, Dialogs, math;
 
type
  TMathtype = (mtnil, mtoperator, mtlbracket, mtrbracket, mtoperand);
 
type
  TMathOperatortype = (monone, moadd, mosub, modiv, momul, mopow);
 
type
  pmathchar = ^Tmathchar;
  TMathChar = record
  case mathtype: Tmathtype of
    mtoperand:(data:extended);
    mtoperator:(op:TMathOperatortype);
  end;
 
type
  TMathControl = class(TComponent)
  private
    input, output, stack: array of tmathchar;
    fmathstring: string;
    function getresult:extended;
    function calculate(operand1,operand2,operator:Tmathchar):extended;
    function getoperator(c:char):TMathOperatortype;
    function getoperand(mid:integer;var len:integer):extended;
    procedure processstring;
    procedure convertinfixtopostfix;
    function isdigit(c:char):boolean;
    function isoperator(c:char):boolean;
    function getprecedence(mop:TMathOperatortype):integer;
  protected
  published
    property MathExpression:string read fmathstring write fmathstring;
    property MathResult:extended read getresult;
  end;
 
procedure register;
 
implementation
 
function Tmathcontrol.calculate(operand1,operand2,operator:Tmathchar):extended;
begin
  result:=0;
  case operator.op of
    moadd:
      result:=operand1.data + operand2.data;
    mosub:
      result:=operand1.data - operand2.data;
    momul:
      result:=operand1.data * operand2.data;
    modiv:
      if (operand1.data&lt;&gt;0) and (operand2.data&lt;&gt;0) then
        result:=operand1.data / operand2.data
      else
        result := 0;
    mopow:
      result:=power(operand1.data, operand2.data);
  end;
end;
 
function Tmathcontrol.getresult:extended;
var
  i:integer;
  tmp1,tmp2,tmp3:tmathchar;
begin
  convertinfixtopostfix;
  setlength(stack,0);
  for i:=0 to length(output)-1 do
  begin
    if output[i].mathtype=mtoperand then
    begin
      setlength(stack,length(stack)+1);
      stack[length(stack)-1]:=output[i];
    end
    else
    if output[i].mathtype=mtoperator then
    begin
      tmp1:=stack[length(stack)-1];
      tmp2:=stack[length(stack)-2];
      setlength(stack,length(stack)-2);
      tmp3.mathtype:=mtoperand;
      tmp3.data:=calculate(tmp2,tmp1,output[i]);
      setlength(stack,length(stack)+1);
      stack[length(stack)-1]:=tmp3;
    end;
  end;
  result:=stack[0].data;
  setlength(stack,0);
  setlength(input,0);
  setlength(output,0);
end;
 
function Tmathcontrol.getoperator(c:char):TMathOperatortype;
begin
  result:=monone;
  if c='+' then
    result:=moadd
  else
  if c='*' then
    result:=momul
  else
  if c='/' then
    result:=modiv
  else
  if c='-' then
    result:=mosub
  else
  if c='^' then
    result:=mopow;
end;
 
function Tmathcontrol.getoperand(mid:integer;var len:integer):extended;
var
  i,j:integer;
  tmpnum:string;
begin
  j:=1;
  for i:=mid to length(fmathstring)-1 do
  begin
    if isdigit(fmathstring[i]) then
    begin
      if j&lt;=20 then
        tmpnum:=tmpnum+fmathstring[i];
      j:=j+1;
    end
    else
      break;
  end;
  result:=strtofloat(tmpnum);
  len:=length(tmpnum);
end;
 
procedure Tmathcontrol.processstring;
var
  i:integer;
  numlen:integer;
begin
  i:=0;
  numlen:=0;
  setlength(output,0);
  setlength(input,0);
  setlength(stack,0);
  fmathstring:='('+fmathstring+')';
  setlength(input,length(fmathstring));
  while i&lt;=length(fmathstring)-1 do
  begin
    if fmathstring[i+1]='(' then
    begin
      input[i].mathtype:=mtlbracket;
      i:=i+1;
    end
    else
    if fmathstring[i+1]=')' then
    begin
      input[i].mathtype:=mtrbracket;
      i:=i+1;
    end
    else
    if isoperator(fmathstring[i+1]) then
    begin
      input[i].mathtype:=mtoperator;
      input[i].op:=getoperator(fmathstring[i+1]);
      i:=i+1;
    end
    else
    if isdigit(fmathstring[i+1]) then
    begin
      input[i].mathtype:=mtoperand;
      input[i].data:=getoperand(i+1,numlen);
      i:=i+numlen;
    end;
  end;
end;
 
 
function Tmathcontrol.isoperator(c:char):boolean;
begin
  result:=false;
  if (c='+') or (c='-') or (c='*') or (c='/') or (c='^') then
    result:=true;
end;
 
function Tmathcontrol.isdigit(c:char):boolean;
begin
  result:=false;
  if ((integer(c)&gt; 47) and (integer(c)&lt; 58)) or (c='.') then
    result:=true;
end;
 
function Tmathcontrol.getprecedence(mop:TMathOperatortype):integer;
begin
  result:=-1;
  case mop of
    moadd: result := 1;
    mosub: result := 1;
    momul: result := 2;
    modiv: result := 2;
    mopow: result := 3;
  end;
end;
 
procedure Tmathcontrol.convertinfixtopostfix;
var
  i,j,prec:integer;
begin
  processstring;
  for i:=0 to length(input)-1 do
  begin
    if input[i].mathtype=mtoperand then
    begin
      setlength(output,length(output)+1);
      output[length(output)-1]:=input[i];
    end
    else
    if input[i].mathtype=mtlbracket then
    begin
      setlength(stack,length(stack)+1);
      stack[length(stack)-1]:=input[i];
    end
    else
    if input[i].mathtype=mtoperator then
    begin
      prec:=getprecedence(input[i].op);
      j:=length(stack)-1;
      if j&gt;=0 then
      begin
        while(getprecedence(stack[j].op)&gt;=prec) and (j&gt;=0) do
        begin
          setlength(output,length(output)+1);
          output[length(output)-1]:=stack[j];
          setlength(stack,length(stack)-1);
          j:=j-1;
        end;
        setlength(stack,length(stack)+1);
        stack[length(stack)-1]:=input[i];
      end;
    end
    else
    if input[i].mathtype=mtrbracket then
    begin
      j:=length(stack)-1;
      if j&gt;=0 then
      begin
        while(stack[j].mathtype&lt;&gt;mtlbracket) and (j&gt;=0) do
        begin
          setlength(output,length(output)+1);
          output[length(output)-1]:=stack[j];
          setlength(stack,length(stack)-1);
          j:=j-1;
        end;
        if j&gt;=0 then
          setlength(stack,length(stack)-1);
      end;
    end;
  end;
end;
 
procedure register;
begin
  RegisterComponents('Samples', [TMathControl]);
end; 
 
end.
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<pre>
function Calculate(SMyExpression: string; digits: Byte): string;
   // Calculate a simple expression 
  // Supported are:  Real Numbers, parenthesis 
var
   z: Char;
   ipos: Integer;
 
   function StrToReal(chaine: string): Real;
   var
     r: Real;
     Pos: Integer;
   begin
     Val(chaine, r, Pos);
     if Pos &gt; 0 then Val(Copy(chaine, 1, Pos - 1), r, Pos);
     Result := r;
   end;
 
   function RealToStr(inreal: Extended; digits: Byte): string;
   var
     S: string;
   begin
     Str(inreal: 0: digits, S);
     realToStr := S;
   end;
 
   procedure NextChar;
   var
     s: string;
   begin
     if ipos &gt; Length(SMyExpression) then
     begin
       z := #9;
       Exit;
     end
     else
     begin
       s := Copy(SMyExpression, ipos, 1);
       z := s[1];
       Inc(ipos);
     end;
     if z = ' ' then nextchar;
   end;
 
   function Expression: Real;
   var
     w: Real;
 
     function Factor: Real;
     var
       ws: string;
     begin
       Nextchar;
       if z in ['0'..'9'] then
       begin
         ws := '';
         repeat
           ws := ws + z;
           nextchar
         until not (z in ['0'..'9', '.']);
         Factor := StrToReal(ws);
       end
       else if z = '(' then
       begin
         Factor := Expression;
         nextchar
       end
       else if z = '+' then Factor := +Factor
       else if Z = '-' then Factor := -Factor;
     end;
 
     function Term: Real;
     var
       W: Real;
     begin
       W := Factor;
       while Z in ['*', '/'] do
         if z = '*' then w := w * Factor
       else
         w := w / Factor;
       Term := w;
     end;
   begin
     w := term;
     while z in ['+', '-'] do
       if z = '+' then w := w + term
     else
       w := w - term;
     Expression := w;
   end;
 begin
   ipos   := 1;
   Result := RealToStr(Expression, digits);
 end;
 
 
 procedure TForm1.Button1Click(Sender: TObject);
 var
   sMyExpression: string;
 begin
   sMyExpression := '12.5*6+18/3.2+2*(5-6.23)';
   ShowMessage(sMyExpression + ' = ' + Calculate(sMyExpression, 3));
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
