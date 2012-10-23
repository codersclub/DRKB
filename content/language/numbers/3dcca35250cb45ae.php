<h1>Число русской строкой</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Александр</div>

<pre>
{------------------------ Деньги прописью ---------------------}
function TextSum(S: double): string;
 
  function Conv999(M: longint; fm: integer): string;
  const
 
    c1to9m: array[1..9] of string[6] =
    ('один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять');
    c1to9f: array[1..9] of string[6] =
    ('одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять');
    c11to19: array[1..9] of string[12] =
    ('одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать',
      'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать');
    c10to90: array[1..9] of string[11] =
    ('десять', 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят',
      'семьдесят', 'восемьдесят', 'девяносто');
    c100to900: array[1..9] of string[9] =
    ('сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот',
      'восемьсот', 'девятьсот');
  var
 
    s: string;
    i: longint;
  begin
 
    s := '';
    i := M div 100;
    if i &lt;&gt; 0 then s := c100to900[i] + ' ';
    M := M mod 100;
    i := M div 10;
    if (M &gt; 10) and (M &lt; 20) then
      s := s + c11to19[M - 10] + ' '
    else
      begin
        if i &lt;&gt; 0 then s := s + c10to90[i] + ' ';
        M := M mod 10;
        if M &lt;&gt; 0 then
          if fm = 0 then
            s := s + c1to9f[M] + ' '
          else
            s := s + c1to9m[M] + ' ';
      end;
    Conv999 := s;
  end;
 
{--------------------------------------------------------------}
var
 
  i: longint;
  j: longint;
  r: real;
  t: string;
 
begin
 
  t := '';
 
  j := Trunc(S / 1000000000.0);
  r := j;
  r := S - r * 1000000000.0;
  i := Trunc(r);
  if j &lt;&gt; 0 then
    begin
      t := t + Conv999(j, 1) + 'миллиард';
      j := j mod 100;
      if (j &gt; 10) and (j &lt; 20) then
        t := t + 'ов '
      else
        case j mod 10 of
          0: t := t + 'ов ';
          1: t := t + ' ';
          2..4: t := t + 'а ';
          5..9: t := t + 'ов ';
        end;
    end;
 
  j := i div 1000000;
  if j &lt;&gt; 0 then
    begin
      t := t + Conv999(j, 1) + 'миллион';
      j := j mod 100;
      if (j &gt; 10) and (j &lt; 20) then
        t := t + 'ов '
      else
        case j mod 10 of
          0: t := t + 'ов ';
          1: t := t + ' ';
          2..4: t := t + 'а ';
          5..9: t := t + 'ов ';
        end;
    end;
 
  i := i mod 1000000;
  j := i div 1000;
  if j &lt;&gt; 0 then
    begin
      t := t + Conv999(j, 0) + 'тысяч';
      j := j mod 100;
      if (j &gt; 10) and (j &lt; 20) then
        t := t + ' '
      else
        case j mod 10 of
          0: t := t + ' ';
          1: t := t + 'а ';
          2..4: t := t + 'и ';
          5..9: t := t + ' ';
        end;
    end;
 
  i := i mod 1000;
  j := i;
  if j &lt;&gt; 0 then t := t + Conv999(j, 1);
  t := t + 'руб. ';
 
  i := Round(Frac(S) * 100.0);
  t := t + Long2Str(i) + ' коп.';
  TextSum := t;
end;
</pre>

<hr />
<pre>
unit RoubleUnit;
{$D Пропись © Близнец Антон '99 http:\\anton-bl.chat.ru\delphi\1001.htm }
{ 1000011.01-&gt;'Один миллион одинадцать рублей 01 копейка'               }
interface
function RealToRouble(c: Extended): string;
implementation
uses SysUtils, math;
const Max000 = 6; {Кол-во триплетов - 000}
  MaxPosition = Max000 * 3; {Кол-во знаков в числе }
//Аналог IIF в Dbase есть в proc.pas для основных типов, частично объявлена тут для независимости
function IIF(i: Boolean; s1, s2: Char): Char; overload; begin if i then
    result := s1
  else
    result := s2 end;
function IIF(i: Boolean; s1, s2: string): string; overload; begin if i then
    result := s1
  else
    result := s2 end;
 
function NumToStr(s: string): string; {Возвращает число прописью}
const c1000: array[0..Max000] of string = ('', 'тысяч', 'миллион', 'миллиард', 'триллион', 'квадраллион', 'квинтиллион');
 
  c1000w: array[0..Max000] of Boolean = (False, True, False, False, False, False, False);
  w: array[False..True, '0'..'9'] of string[3] = (('ов ', ' ', 'а ', 'а ', 'а ', 'ов ', 'ов ', 'ов ', 'ов ', 'ов '),
    (' ', 'а ', 'и ', 'и ', 'и ', ' ', ' ', ' ', ' ', ' '));
  function Num000toStr(S: string; woman: Boolean): string; {Num000toStr возвращает число для триплета}
  const c100: array['0'..'9'] of string = ('', 'сто ', 'двести ', 'триста ', 'четыреста ', 'пятьсот ', 'шестьсот ', 'семьсот ', 'восемьсот ', 'девятьсот ');
    c10: array['0'..'9'] of string = ('', 'десять ', 'двадцать ', 'тридцать ', 'сорок ', 'пятьдесят ', 'шестьдесят ', 'семьдесят ', 'восемьдесят ', 'девяносто ');
    c11: array['0'..'9'] of string = ('', 'один', 'две', 'три', 'четыр', 'пят', 'шест', 'сем', 'восем', 'девят');
    c1: array[False..True, '0'..'9'] of string = (('', 'один ', 'два ', 'три ', 'четыре ', 'пять ', 'шесть ', 'семь ', 'восемь ', 'девять '),
      ('', 'одна ', 'две ', 'три ', 'четыре ', 'пять ', 'шесть ', 'семь ', 'восемь ', 'девять '));
  begin {Num000toStr}
    Result := c100[s[1]] + iif((s[2] = '1') and (s[3] &gt; '0'), c11[s[3]] + 'надцать ', c10[s[2]] + c1[woman, s[3]]);
  end; {Num000toStr}
 
var s000: string[3];
 
  isw, isMinus: Boolean;
  i: integer; //Счётчик триплетов
begin
 
  Result := ''; i := 0;
  isMinus := (s &lt;&gt; '') and (s[1] = '-');
  if isMinus then s := Copy(s, 2, Length(s) - 1);
  while not ((i &gt;= Ceil(Length(s) / 3)) or (i &gt;= Max000)) do
    begin
      s000 := Copy('00' + s, Length(s) - i * 3, 3);
      isw := c1000w[i];
      if (i &gt; 0) and (s000 &lt;&gt; '000') then //тысячи и т.д.
        Result := c1000[i] + w[Isw, iif(s000[2] = '1', '0', s000[3])] + Result;
      Result := Num000toStr(s000, isw) + Result;
      Inc(i)
    end;
  if Result = '' then Result := 'ноль';
  if isMinus then Result := 'минус ' + Result;
end; {NumToStr}
 
function RealToRouble(c: Extended): string;
 
const ruble: array['0'..'9'] of string[2] = ('ей', 'ь', 'я', 'я', 'я', 'ей', 'ей', 'ей', 'ей', 'ей');
  Kopeek: array['0'..'9'] of string[3] = ('ек', 'йка', 'йки', 'йки', 'йки', 'ек', 'ек', 'ек', 'ек', 'ек');
 
  function ending(const s: string): Char;
  var l: Integer; //С l на 8 байт коротче $50-&gt;$48-&gt;$3F
  begin //Возвращает индекс окончания
    l := Length(s);
    Result := iif((l &gt; 1) and (s[l - 1] = '1'), '0', s[l]);
  end;
 
var rub: string[MaxPosition + 3]; kop: string[2];
begin {Возвращает число прописью с рублями и копейками}
 
  Str(c: MaxPosition + 3: 2, Result);
  if Pos('E', Result) = 0 then //Если число можно представить в строке &lt;&gt;1E+99
    begin
      rub := TrimLeft(Copy(Result, 1, Length(Result) - 3));
      kop := Copy(Result, Length(Result) - 1, 2);
      Result := NumToStr(rub) + ' рубл' + ruble[ending(rub)]
        + ' ' + kop + ' копе' + Kopeek[ending(kop)];
      Result := AnsiUpperCase(Result[1]) + Copy(Result, 2, Length(Result) - 1);
    end;
end;
end.
</pre>


<hr />Редянов Денис</p>

<pre>
function CifrToStr(Cifr: string; Pr: Integer; Padeg: Integer): string;
{Функция возвращает прописью 1 цифры признак 3-единицы 2-десятки 1-сотни 4-11-19
 
Padeg - 1-нормально 2- одна, две }
var i: Integer;
begin
 
  i := StrToInt(Cifr);
  if Pr = 1 then
    case i of
      1: CifrToStr := 'сто';
      2: CifrToStr := 'двести';
      3: CifrToStr := 'триста';
      4: CifrToStr := 'четыреста';
      5: CifrToStr := 'пятьсот';
      6: CifrToStr := 'шестьсот';
      7: CifrToStr := 'семьсот';
      8: CifrToStr := 'восемьсот';
      9: CifrToStr := 'девятьсот';
      0: CifrToStr := '';
    end
  else if Pr = 2 then
    case i of
      1: CifrToStr := '';
      2: CifrToStr := 'двадцать';
      3: CifrToStr := 'тридцать';
      4: CifrToStr := 'сорок';
      5: CifrToStr := 'пятьдесят';
      6: CifrToStr := 'шестьдесят';
      7: CifrToStr := 'семьдесят';
      8: CifrToStr := 'восемьдесят';
      9: CifrToStr := 'девяносто';
      0: CifrToStr := '';
    end
  else if Pr = 3 then
    case i of
      1: if Padeg = 1 then
          CifrToStr := 'один'
        else
          CifrToStr := 'одна';
      2: if Padeg = 1 then
          CifrToStr := 'два'
        else
          CifrToStr := 'две';
      3: CifrToStr := 'три';
      4: CifrToStr := 'четыре';
      5: CifrToStr := 'пять';
      6: CifrToStr := 'шесть';
      7: CifrToStr := 'семь';
      8: CifrToStr := 'восемь';
      9: CifrToStr := 'девять';
      0: CifrToStr := '';
    end
  else if Pr = 4 then
    case i of
      1: CifrToStr := 'одиннадцать';
      2: CifrToStr := 'двенадцать';
      3: CifrToStr := 'тринадцать';
      4: CifrToStr := 'четырнадцать';
      5: CifrToStr := 'пятнадцать';
      6: CifrToStr := 'шестнадцать';
      7: CifrToStr := 'семнадцать';
      8: CifrToStr := 'восемнадцать';
      9: CifrToStr := 'девятнадцать';
      0: CifrToStr := 'десять';
 
    end;
end;
 
function Rasryad(K: Integer; V: string): string;
{Функция возвращает наименование разряда в зависимости от последних 2 цифр его}
var j: Integer;
begin
 
  j := StrToInt(Copy(v, Length(v), 1));
  if (StrToInt(Copy(v, Length(v) - 1, 2)) &gt; 9) and (StrToInt(Copy(v, Length(v) - 1, 2)) &lt; 20) then
    case K of
      0: Rasryad := '';
      1: Rasryad := 'тысяч';
      2: Rasryad := 'миллионов';
      3: Rasryad := 'миллиардов';
      4: Rasryad := 'триллионов';
    end
  else
    case K of
      0: Rasryad := '';
      1: case j of
          1: Rasryad := 'тысяча';
          2..4: Rasryad := 'тысячи';
        else
          Rasryad := 'тысяч';
        end;
      2: case j of
          1: Rasryad := 'миллион';
          2..4: Rasryad := 'миллионa';
        else
          Rasryad := 'миллионов';
        end;
      3: case j of
          1: Rasryad := 'миллиард';
          2..4: Rasryad := 'миллиарда';
        else
          Rasryad := 'миллиардов';
        end;
      4: case j of
          1: Rasryad := 'триллион';
          2..4: Rasryad := 'триллиона';
        else
          Rasryad := 'триллионов';
        end;
    end;
end;
 
function GroupToStr(Group: string; Padeg: Integer): string;
{Функция возвращает прописью 3 цифры}
var i: Integer;
 
  S: string;
begin
 
  S := '';
  if (StrToInt(Copy(Group, Length(Group) - 1, 2)) &gt; 9) and (StrToInt(Copy(Group, Length(Group) - 1, 2)) &lt; 20) then
    begin
      if Length(Group) = 3 then
        S := S + ' ' + CifrToStr(Copy(Group, 1, 1), 1, Padeg);
      S := S + ' ' + CifrToStr(Copy(Group, Length(Group), 1), 4, Padeg);
    end
  else
    for i := 1 to Length(Group) do
      S := S + ' ' + CifrToStr(Copy(Group, i, 1), i - Length(Group) + 3, Padeg);
  GroupToStr := S;
end;
 
{Функция возвращает сумму прописью}
function RubToStr(Rubs: Currency; Rub, Kop: string): string;
var i, j: Integer;
 
  R, K, S: string;
begin
 
  S := CurrToStr(Rubs);
  S := Trim(S);
  if Pos(',', S) = 0 then
    begin
      R := S;
      K := '00';
    end
  else
    begin
      R := Copy(S, 0, (Pos(',', S) - 1));
      K := Copy(S, (Pos(',', S) + 1), Length(S));
    end;
 
  S := '';
  i := 0;
  j := 1;
  while Length(R) &gt; 3 do
    begin
      if i = 1 then
        j := 2
      else
        j := 1;
      S := GroupToStr(Copy(R, Length(R) - 2, 3), j) + ' ' + Rasryad(i, Copy(R, Length(R) - 2, 3)) + ' ' + S;
      R := Copy(R, 1, Length(R) - 3);
      i := i + 1;
    end;
  if i = 1 then
    j := 2
  else
    j := 1;
  S := Trim(GroupToStr(R, j) + ' ' + Rasryad(i, R) + ' ' + S + ' ' + Rub + ' ' + K + ' ' + Kop);
  S := ANSIUpperCase(Copy(S, 1, 1)) + Copy(S, 2, Length(S) - 1);
  RubToStr := S;
end;
</pre>


<hr />Вот еще одно решение, присланное Олегом Клюкач.</p>

<pre>
unit Numinwrd;
 
interface
function sMoneyInWords(Nin: currency): string; export;
function szMoneyInWords(Nin: currency): PChar; export;
{ Денежная сумма Nin в рублях и копейках прописью
 
1997, в.2.1, by О.В.Болдырев}
 
implementation
uses SysUtils, Dialogs, Math;
 
type
 
  tri = string[4];
  mood = 1..2;
  gender = (m, f);
  uns = array[0..9] of string[7];
  tns = array[0..9] of string[13];
  decs = array[0..9] of string[12];
  huns = array[0..9] of string[10];
  nums = array[0..4] of string[8];
  money = array[1..2] of string[5];
  endings = array[gender, mood, 1..3] of tri; {окончания числительных и денег}
 
const
 
  units: uns = ('', 'один ', 'два ', 'три ', 'четыре ', 'пять ',
    'шесть ', 'семь ', 'восемь ', 'девять ');
  unitsf: uns = ('', 'одна ', 'две ', 'три ', 'четыре ', 'пять ',
    'шесть ', 'семь ', 'восемь ', 'девять ');
  teens: tns = ('десять ', 'одиннадцать ', 'двенадцать ', 'тринадцать ',
    'четырнадцать ', 'пятнадцать ', 'шестнадцать ',
    'семнадцать ', 'восемнадцать ', 'девятнадцать ');
  decades: decs = ('', 'десять ', 'двадцать ', 'тридцать ', 'сорок ',
    'пятьдесят ', 'шестьдесят ', 'семьдесят ', 'восемьдесят ',
    'девяносто ');
  hundreds: huns = ('', 'сто ', 'двести ', 'триста ', 'четыреста ',
    'пятьсот ', 'шестьсот ', 'семьсот ', 'восемьсот ',
    'девятьсот ');
  numericals: nums = ('', 'тысяч', 'миллион', 'миллиард', 'триллион');
  RusMon: money = ('рубл', 'копе');
  ends: endings = ((('', 'а', 'ов'), ('ь', 'я', 'ей')),
    (('а', 'и', ''), ('йка', 'йки', 'ек')));
threadvar
 
  str: string;
 
function EndingIndex(Arg: integer): integer;
begin
 
  if ((Arg div 10) mod 10) &lt;&gt; 1 then
    case (Arg mod 10) of
      1: Result := 1;
      2..4: Result := 2;
    else
      Result := 3;
    end
  else
    Result := 3;
end;
 
function sMoneyInWords(Nin: currency): string; { Число Nin прописью, как функция }
var
//  str: string;
 
  g: gender; //род
  Nr: comp; {целая часть числа}
  Fr: integer; {дробная часть числа}
  i, iTri, Order: longint; {триада}
 
  procedure Triad;
  var
    iTri2: integer;
    un, de, ce: byte; //единицы, десятки, сотни
 
    function GetDigit: byte;
    begin
      Result := iTri2 mod 10;
      iTri2 := iTri2 div 10;
    end;
 
  begin
    iTri := trunc(Nr / IntPower(1000, i));
    Nr := Nr - int(iTri * IntPower(1000, i));
    iTri2 := iTri;
    if iTri &gt; 0 then
      begin
        un := GetDigit;
        de := GetDigit;
        ce := GetDigit;
        if i = 1 then
          g := f
        else
          g := m; {женского рода только тысяча}
 
        str := TrimRight(str) + ' ' + Hundreds[ce];
        if de = 1 then
          str := TrimRight(str) + ' ' + Teens[un]
        else
          begin
            str := TrimRight(str) + ' ' + Decades[de];
            case g of
              m: str := TrimRight(str) + ' ' + Units[un];
              f: str := TrimRight(str) + ' ' + UnitsF[un];
            end;
          end;
 
        if length(numericals[i]) &gt; 1 then
          begin
            str := TrimRight(str) + ' ' + numericals[i];
            str := TrimRight(str) + ends[g, 1, EndingIndex(iTri)];
          end;
      end; //triad is 0 ?
 
    if i = 0 then Exit;
    Dec(i);
    Triad;
  end;
 
begin
 
  str := '';
  Nr := int(Nin);
  Fr := round(Nin * 100 + 0.00000001) mod 100;
  if Nr &gt; 0 then
    Order := trunc(Log10(Nr) / 3)
  else
    begin
      str := 'ноль';
      Order := 0
    end;
  if Order &gt; High(numericals) then
    raise Exception.Create('Слишком большое число для суммы прописью');
  i := Order;
  Triad;
  str :=
    Format('%s %s%s %.2d %s%s', [Trim(str), RusMon[1], ends[m, 2, EndingIndex(iTri)],
    Fr, RusMon[2], ends[f, 2, EndingIndex(Fr)]]);
  str[1] := (ANSIUpperCase(copy(str, 1, 1)))[1];
  str[Length(str) + 1] := #0;
  Result := str;
end;
 
function szMoneyInWords(Nin: currency): PChar;
begin
 
  sMoneyInWords(Nin);
  Result := @(str[1]);
end;
 
end.
</pre>


<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>


<hr />
<pre>
unit FullSum;
 
interface
 
uses SysUtils;
 
{
Функция перевода суммы, записанной цифрами в сумму прописью :
например, 23.12 -&gt; двадцать три рубля 12 копеек.
переводит до 999999999 руб. 99 коп.
Функция не отслеживает, правильное ли значение получено в параметре Number
(т.е. положительное и округленное с точностью до сотых) - эту проверку
необходимо провести до вызова функции.
}
 
//----------------- Copyright (c) 1999 by Константин Егоров
//----------------- mailto: egor@vladi.elektra.ru
 
function SumNumToFull(Number: real): string;
 
implementation
 
function SumNumToFull(Number:real):string;
var
  PartNum, TruncNum, NumTMP, D: integer;
  NumStr : string;
  i, R : byte;
  Flag11 : boolean;
begin
  D:=1000000;
  R:=4;
  //выделяем рубли
  TruncNum:=Trunc(Number);
  if TruncNum&lt;&gt;0 then
    repeat
      PartNum:=TruncNum div D;
      Dec(R);
      D:=D div 1000;
    until
      PartNum&lt;&gt;0
  else
    R:=0;
 
  // перевод рублей
  for i:=R downto 1 do
  begin
    Flag11:=False;
    // выделение цифры сотен
    NumTMP:=PartNum div 100;
    case NumTMP of
      1: NumStr:=NumStr+'сто ';
      2: NumStr:=NumStr+'двести ';
      3: NumStr:=NumStr+'триста ';
      4: NumStr:=NumStr+'четыреста ';
      5: NumStr:=NumStr+'пятьсот ';
      6: NumStr:=NumStr+'шестьсот ';
      7: NumStr:=NumStr+'семьсот ';
      8: NumStr:=NumStr+'восемьсот ';
      9: NumStr:=NumStr+'девятьсот ';
    end;
    // выделение цифры десятков
    NumTMP:=(PartNum mod 100) div 10;
    case NumTMP of
      1:
      begin
        NumTMP:=PartNum mod 100;
        case NumTMP of
          10: NumStr:=NumStr+'десять ';
          11: NumStr:=NumStr+'одиннадцать ';
          12: NumStr:=NumStr+'двенадцать ';
          13: NumStr:=NumStr+'тринадцать ';
          14: NumStr:=NumStr+'четырнадцать ';
          15: NumStr:=NumStr+'пятнадцать ';
          16: NumStr:=NumStr+'шестнадцать ';
          17: NumStr:=NumStr+'семнадцать ';
          18: NumStr:=NumStr+'восемнадцать ';
          19: NumStr:=NumStr+'девятнадцать ';
        end;
        case i of
          3: NumStr:=NumStr+'миллионов ';
          2: NumStr:=NumStr+'тысяч ';
          1: NumStr:=NumStr+'рублей ';
        end;
        Flag11:=True;
      end;
      2: NumStr:=NumStr+'двадцать ';
      3: NumStr:=NumStr+'тридцать ';
      4: NumStr:=NumStr+'сорок ';
      5: NumStr:=NumStr+'пятьдесят ';
      6: NumStr:=NumStr+'шестьдесят ';
      7: NumStr:=NumStr+'семьдесят ';
      8: NumStr:=NumStr+'восемьдесят ';
      9: NumStr:=NumStr+'девяносто ';
    end;
    // выделение цифры единиц
    NumTMP:=PartNum mod 10;
    if not Flag11 then
    begin
      case NumTMP of
        1:
          if i=2 then
            NumStr:=NumStr+'одна '
          else
            NumStr:=NumStr+'один ';
        2:
          if i=2 then
            NumStr:=NumStr+'две '
          else
            NumStr:=NumStr+'два ';
        3: NumStr:=NumStr+'три ';
        4: NumStr:=NumStr+'четыре ';
        5: NumStr:=NumStr+'пять ';
        6: NumStr:=NumStr+'шесть ';
        7: NumStr:=NumStr+'семь ';
        8: NumStr:=NumStr+'восемь ';
        9: NumStr:=NumStr+'девять ';
      end;
      case i of
        3:
          case NumTMP of
            1: NumStr:=NumStr+'миллион ';
            2,3,4: NumStr:=NumStr+'миллиона ';
            else
              NumStr:=NumStr+'миллионов ';
          end;
        2:
          case NumTMP of
            1 : NumStr:=NumStr+'тысяча ';
            2,3,4: NumStr:=NumStr+'тысячи ';
            else
              if PartNum&lt;&gt;0 then
                NumStr:=NumStr+'тысяч ';
          end;
        1:
          case NumTMP of
            1 : NumStr:=NumStr+'рубль ';
            2,3,4: NumStr:=NumStr+'рубля ';
            else
              NumStr:=NumStr+'рублей ';
          end;
      end;
    end;
    if i&gt;1 then
    begin
      PartNum:=(TruncNum mod (D*1000)) div D;
      D:=D div 1000;
    end;
  end;
 
  //перевод копеек
  PartNum:=Round(Frac(Number)*100);
  if PartNum=0 then
  begin
    SumNumToFull:=NumStr+'00 копеек';
    Exit;
  end;
  // выделение цифры десятков
  NumTMP:=PartNum div 10;
  if NumTMP=0 then
    NumStr:=NumStr+'0'+IntToStr(PartNum)+' '
  else
    NumStr:=NumStr+IntToStr(PartNum)+' ';
  // выделение цифры единиц
  NumTMP:=PartNum mod 10;
  case NumTMP of
    1:
      if PartNum&lt;&gt;11 then
        NumStr:=NumStr+'копейка'
      else
        NumStr:=NumStr+'копеек';
    2,3,4:
      if (PartNum&lt;5) or (PartNum&gt;14) then
        NumStr:=NumStr+'копейки'
      else
        NumStr:=NumStr+'копеек';
    else
      NumStr:=NumStr+'копеек';
  end;
  SumNumToFull:=NumStr;
end;
 
end.
 
</pre>
<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>


<hr />
<pre>
{ Преобразует трехзначное число в строку }
function ConvertToWord(N: word): string;
const
  Sot : array[1..9] of string[13] =
  ('сто','двести','триста','четыреста','пятьсот',
  'шестьсот','семьсот','восемьсот','девятьсот');
 
  Des : array[2..9] of string[13] =
  ('двадцать','тридцать','сорок','пятьдесят',
  'шестьдесят','семьдесят','восемьдесят','девяносто');
 
  Edin : array[0..19] of string[13] =
  ('','один','два','три','четыре','пять','шесть','семь',
  'восемь','девять','десять','одиннадцать','двенадцать',
  'тринадцать','четырнадцать','пятнадцать',
  'шестнадцать','семнадцать','восемнадцать','девятнадцать');
 
var
  S: string;
begin
  S:='';
  N:=N mod 1000;
  if N&gt;99 then
  begin
    S:=Sot[N div 100]+' ';
    N:=N mod 100;
  end;
  if N&gt;19 then
  begin
    S:=S+Des[N div 10]+' ';
    N:=N mod 10;
  end;
  Result:=S+Edin[N];
end;
 
{ Возвращает сумму прописью }
function CenaToStr(r: Currency): string;
var
  N, k: longint;
  S: string;
begin
  N:=trunc(R); S:='';
  if N&lt;&gt;0 then
  begin
    if N&gt;999999 then
    begin
      k:=N div 1000000;
      S:=ConvertToWord(k);
      if ((k-(k div 100)*100)&gt;10) and ((k-(k div 100)*100)&lt;20) then
        S:=S+' миллионов'
      else
      if (k mod 10)=1 then
        S:=S+' миллион'
      else
      if ((k mod 10)&gt;=2)and((k mod 10)&lt;=4) then
        S:=S+' миллиона'
      else
        S:=S+' миллионов';
      N:=N mod 1000000;
    end;
    if N&gt;999 then
    begin
      k:=N div 1000;
      S:=S+' '+ConvertToWord(k);
      if ((k-(k div 100)*100)&gt;10)and((k-(k div 100)*100)&lt;20) then
        S:=S+' тысяч'
      else
      if (k mod 10)=1 then
      begin
        SetLength(S, Length(S)-2);
        S:=S+'на тысяча';
      end
      else
      if (k mod 10)=2 then
      begin
        SetLength(S, length(S)-1);
        S:=S+'е тысячи';
      end
      else
      if ((k mod 10)&gt;=3)and((k mod 10)&lt;=4) then
        S:=S+' тысячи'
      else
        S:=S+' тысяч';
      N:=N mod 1000;
    end;
    k:=N;
    S:=S+' '+ConvertToWord(k);
    if ((k-(k div 100)*100)&gt;10)and((k-(k div 100)*100)&lt;20) then
      S:=S+' рублей'
    else
    if (k mod 10)=1 then
      S:=S+' рубль'
    else
    if (k mod 10)=2 then
      S:=S+' рубля'
    else
    if ((k mod 10)&gt;=3)and((k mod 10)&lt;=4) then
      S:=S+' рубля'
    else
      S:=S+' рублей';
  end;
  if trunc(R)&lt;&gt;R then
  begin
    k:=round(frac(R)*100);
    S:=S+' '+IntToStr(K);
    if ((k-(k div 100)*100)&gt;10)and((k-(k div 100)*100)&lt;20) then
      S:=S+' копеек'
    else
    if (k mod 10)=1 then
    begin
      S:=S+' копейка';
    end
    else
    if (k mod 10)=2 then
    begin
      S:=S+' копейки';
    end
    else
    if ((k mod 10)&gt;=3)and((k mod 10)&lt;=4) then
      S:=S+' копейки'
    else
      S:=S+' копеек';
  end
  else
    S:=S+' 00 копеек';
  S:=Trim(S);
  if S&lt;&gt;'' then
    S[1]:=AnsiUpperCase(S[1])[1];
  result:=S;
end;
 
 
</pre>
<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>


<hr />
<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Сумма прописью
 
Данный набор функций позволяет из суммы в числовом виде получить
её представление прописью. Реализована возможность работы с рублями и долларами.
Возможно добавление какой угодно валюты.
 
Зависимости: SysUtils
Автор:       fnatali, fnatali@yandex.ru, Березники
Copyright:   Евгений Меньшенин &lt;johnmen@mail.ru&gt;
Дата:        27 апреля 2002 г.
***************************************************** }
 
unit SpellingD;
 
interface
 
uses SysUtils;
 
function SpellPic(StDbl: double; StSet: integer): string;
 
implementation
 
const
  Money: array[0..1] of string[25] =
  ('ь я рубл ей коп. ',
    'р ра долларов цент.');
  {А Б В Г Д Е Ж З И Й К Л М Н О
        П Р С Т У Ф Х Ц Ч Ш Щ Ъ Ы Ь
        Э Ю Я а б в г д }
  Sym: string[180] =
  'одна две один два три четыре пят ь шест сем восемдевятдесят'
    + 'на дцатьсорокдевяно сто сти ста ьсот тысяча и миллион '
    + 'ов ард ноль ь я рубл ей коп. ';
  Code: string[156] =
 
  'БААВААГААДААЕААЖЗАИЙАКЙАЛЙАМЙАНЙАОЙАГПРВПРЕПРЖПРИПРКПРЛПРМПРНПРДРАЕРА'
    +
    'СААИЙОКЙОЛЙОМЙОТУФФААВХАЕЦАЖЗЦИЧАКЧАЛЧАМЧАНЧАваАвбАвгАШЩАШЪАШААЫЬАЫЬЩ'
    + 'ЫЬЭЫЮАЫЮЩЫЮЭЯААдАА';
  {1 2 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 30
   40 50 60 70 80 90 1 2 3 4 5 6 7 8 9 РУБ -Я-ЕЙТЫС -И -ЧМ-Н-А
    -ВМ-Д -А -В0 коп}
  {0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22
   23 24 25 26 27 28 29 30 31 32 33 34 35 36 37 38 39 40 41 42 43 44 45
   46 47 48 49 50 51 }
 
function SpellPic(StDbl: double; StSet: integer): string;
{format of StNum: string[15]= 000000000000.00}
const
  StMask = '000000000000.00';
var
  StNum: string; {StDbl -&gt; StNum}
  PlaceNo: integer; {текущая позиция в StNum}
  TripletNo: integer; {позиция имени обрабатываемого разряда (им.п.ед.ч.)}
  StWord: string; {результат}
 
  procedure WordAdd(CodeNo: integer);
  var
    SymNo: integer; {текущая позиция в массиве Sym}
    i, j: integer;
  begin
    ;
    Inc(CodeNo, CodeNo shl 1); {* 3}
    for i := 1 to 3 do
    begin
      ;
      Inc(CodeNo);
      SymNo := ord(Code[CodeNo]) - ord('Б');
      if SymNo &lt; 0 then
        break;
      Inc(SymNo, SymNo shl 2); {* 5}
      for j := 1 to 5 do
      begin
        ;
        Inc(SymNo);
        if Sym[SymNo] = ' ' then
          break;
        StWord := StWord + Sym[SymNo];
      end;
    end;
    StWord := StWord + ' ';
  end;
 
  procedure Triplet;
  var
    D3: integer; {сотни текущего разряда}
    D2: integer; {десятки текущего разряда}
    D1: integer; {единицы текущего разряда}
    TripletPos: integer; {смещение имени разряда для разных падежей}
  begin
    ;
    Inc(PlaceNo);
    D3 := ord(StNum[PlaceNo]) - ord('0');
    Inc(PlaceNo);
    D2 := ord(StNum[PlaceNo]) - ord('0');
    Inc(PlaceNo);
    D1 := ord(StNum[PlaceNo]) - ord('0');
    Dec(TripletNo, 3);
    TripletPos := 2; {рублей (род.п.мн.ч.)}
    if D3 &gt; 0 then
      WordAdd(D3 + 28);
    {сотни}
    if D2 = 1 then
      WordAdd(D1 + 11)
        {10-19}
    else
    begin
      ;
      if D2 &gt; 1 then
        WordAdd(D2 + 19);
      {десятки}
      if D1 &gt; 0 then
      begin
        ;
        {единицы}
        if (TripletNo = 41) and (D1 &lt; 3) then
          WordAdd(D1 - 1) {одна или две тысячи}
        else
          WordAdd(D1 + 1);
        if D1 &lt; 5 then
          TripletPos := 1; {рубля (род.п.ед.ч.)}
        if D1 = 1 then
          TripletPos := 0; {рубль (им.п.ед.ч.)}
      end;
    end;
    if (TripletNo = 38) and (Length(StWord) = 0) then
      WordAdd(50); {ноль целых}
    if (TripletNo = 38) or (D1 + D2 + D3 &gt; 0) then {имя разряда}
      WordAdd(TripletNo + TripletPos);
  end;
 
var
  i: integer;
begin
  ;
  Move(Money[StSet, 1], Sym[156], 25);
  StNum := FormatFloat(StMask, StDbl);
 
  PlaceNo := 0;
  TripletNo := 50;
  {47+3}
  StWord := ''; {будущий результат}
 
  for i := 1 to 4 do
    Triplet; {4 разряда: миллиарды, миллионы, тысячи,единицы}
  StWord := StWord + StNum[14] + StNum[15] + ' ';
  WordAdd(51);
 
  {Upcase первая буква}
  SpellPic := AnsiUpperCase(StWord[1]) + Copy(StWord, 2, Length(StWord) - 2);
end;
 
end.
Пример использования: 
 
var
  sumpr: string;
begin
  // первый параметр - сумма, которую необходимо перевести в пропись,
  // второй параметр - валюта (0-рубли, 1- доллары).
  sumpr := spellpic(100, 0);
  ...
 
</pre>
<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

<hr />
<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Преобразование целого числа 0-999999999 в строку (прописью)
 
Я думаю, всё итак понятно, что не понятно пишите письма
 
Зависимости: SysUtils
Автор:       Алексей, ARojkov@okil.ru, СПб
Copyright:   b0b
Дата:        12 марта 2004 г.
***************************************************** }
 
unit UIntToStroka;
 
interface
 
uses SysUtils;
 
const
  N1: array[0..9] of string = ('ноль',
    'один',
    'два',
    'три',
    'четыре',
    'пять',
    'шесть',
    'семь',
    'восемь',
    'девять');
 
const
  N1000: array[1..9] of string = ('одна',
    'две',
    'три',
    'четыре',
    'пять',
    'шесть',
    'семь',
    'восемь',
    'девять');
 
const
  N11: array[0..9] of string = ('десять',
    'одиннадцать',
    'двенадцать',
    'тринадцать',
    'четырнадцать',
    'пятнадцать',
    'шестнадцать',
    'семнадцать',
    'восемнадцать',
    'девятнадцать');
 
const
  N2: array[1..9] of string = ('десять',
    'двадцать',
    'тридцать',
    'сорок',
    'пятьдесят',
    'шестьдесят',
    'семьдесят',
    'восемьдесят',
    'девяносто'
    );
 
const
  N3: array[1..9] of string = ('сто',
    'двести',
    'триста',
    'четыреста',
    'пятьсот',
    'шестьсот',
    'семьсот',
    'восемьсот',
    'девятьсот'
    );
 
const
  NThousand: array[1..3] of string = ('тысяча ',
    'тысячи ',
    'тысяч ');
 
const
  NMillion: array[1..3] of string = ('миллион ',
    'миллиона ',
    'миллионов ');
 
function IntToStroka(n: Integer): AnsiString;
 
implementation
 
function IntToStroka(n: Integer): AnsiString;
var
  i, j, dec, j0: Integer;
  s: string;
  degt, degm: boolean;
  buf: string;
begin
  degt := false;
  degm := false;
  s := IntToStr(n);
  Result := '';
  for i := length(s) downto 1 do
  begin
    dec := (length(s) - i + 1); // получим разряд
    j := StrToInt(s[i]); // получим цифру
 
    if j = 0 then
      j0 := 0;
    if (not (j in [1..9])) and (dec &lt;&gt; 1) then
      Continue;
 
    if Dec in [1, 4, 7, 10] then
    try
      if StrToInt(s[i - 1]) = 1 then
      begin
        j0 := j;
        Continue;
      end; // подготовка к 10..19 тысяч/миллионов
    except
    end;
 
    if Dec in [2, 5, 8, 11] then
      if j = 1 then
      begin
        case dec of
          2: Result := N11[j0] + ' '; // если 10..19 тысяч/миллионов
          5:
            begin
              Result := N11[j0] + ' ' + NThousand[3] + Result;
              degt := true;
            end;
          8:
            begin
              Result := N11[j0] + ' ' + NMillion[3] + Result;
              degm := true;
            end;
        end;
        Continue;
      end;
 
    if DEC in [4..6] then
    begin
      if (j &lt;&gt; 0) and (not degt) then
      begin
        if dec = 4 then
          case j of
            1: buf := NThousand[1];
            2..4: buf := NThousand[2];
              // прибавим слово тысяча если ещё не добавляли
            5..9: buf := NThousand[3];
          end
        else
          buf := NThousand[3];
        degt := true;
      end;
    end;
 
    if DEC in [7..9] then
    begin
      if (j &lt;&gt; 0) and (not degm) then
      begin
        if dec = 7 then
          case j of
            1: buf := NMillion[1];
            2..4: buf := NMillion[2];
              // прибавим слово миллион если ещё не добавляли
            5..9: buf := NMillion[3];
          end
        else
          buf := NMillion[3];
        degm := true;
      end;
    end;
 
    Result := buf + Result;
 
    while dec &gt; 3 do
      dec := dec - 3;
 
    case Dec of
      1: if j &lt;&gt; 0 then
          if degt and (not degm) then
            Result := N1000[j] + ' ' + Result
          else
            Result := N1[j] + ' ' + Result; // 3 три
      2: Result := N2[j] + ' ' + Result; // 23 двадцать три
      3: Result := N3[j] + ' ' + Result; // 123 сто двадцать три
    end;
    Buf := '';
    j0 := j;
  end;
end;
 
end.
 
</pre>

<hr />
<pre>
function NumToStr(n: double; c: byte = 0): string;
(*
 
c=0 - 21.05 -&gt; 'Двадцать один рубль 05 копеек.'
с=1 - 21.05 -&gt; 'двадцать один'
c=2 - 21.05 -&gt; '21-05', 21.00 -&gt; '21='
*)
const
 
  digit: array[0..9] of string = ('ноль', 'оди', 'два', 'три', 'четыр',
    'пят', 'шест', 'сем', 'восем', 'девят');
var
 
  ts, mln, mlrd, SecDes: Boolean;
  len: byte;
  summa: string;
 
  function NumberString(number: string): string;
  var
    d, pos: byte;
 
    function DigitToStr: string;
    begin
      result := '';
      if (d &lt;&gt; 0) and ((pos = 11) or (pos = 12)) then
        mlrd := true;
      if (d &lt;&gt; 0) and ((pos = 8) or (pos = 9)) then
        mln := true;
      if (d &lt;&gt; 0) and ((pos = 5) or (pos = 6)) then
        ts := true;
      if SecDes then
      begin
        case d of
          0: result := 'десять ';
          2: result := 'двенадцать '
        else
          result := digit[d] + 'надцать '
        end;
        case pos of
          4: result := result + 'тысяч ';
          7: result := result + 'миллионов ';
          10: result := result + 'миллиардов '
        end;
        SecDes := false;
        mln := false;
        mlrd := false;
        ts := false
      end
      else
      begin
        if (pos = 2) or (pos = 5) or (pos = 8) or (pos = 11) then
          case d of
            1: SecDes := true;
            2, 3: result := digit[d] + 'дцать ';
            4: result := 'сорок ';
            9: result := 'девяносто ';
            5..8: result := digit[d] + 'ьдесят '
          end;
        if (pos = 3) or (pos = 6) or (pos = 9) or (pos = 12) then
          case d of
            1: result := 'сто ';
            2: result := 'двести ';
            3: result := 'триста ';
            4: result := 'четыреста ';
            5..9: result := digit[d] + 'ьсот '
          end;
        if (pos = 1) or (pos = 4) or (pos = 7) or (pos = 10) then
          case d of
            1: result := 'один ';
            2, 3: result := digit[d] + ' ';
            4: result := 'четыре ';
            5..9: result := digit[d] + 'ь '
          end;
        if pos = 4 then
        begin
          case d of
            0: if ts then
                result := 'тысяч ';
            1: result := 'одна тысяча ';
            2: result := 'две тысячи ';
            3, 4: result := result + 'тысячи ';
            5..9: result := result + 'тысяч '
          end;
          ts := false
        end;
        if pos = 7 then
        begin
          case d of
            0: if mln then
                result := 'миллионов ';
            1: result := result + 'миллион ';
            2, 3, 4: result := result + 'миллиона ';
            5..9: result := result + 'миллионов '
          end;
          mln := false
        end;
        if pos = 10 then
        begin
          case d of
            0: if mlrd then
                result := 'миллиардов ';
            1: result := result + 'миллиард ';
            2, 3, 4: result := result + 'миллиарда ';
            5..9: result := result + 'миллиардов '
          end;
          mlrd := false
        end
      end
    end;
 
  begin
    result := '';
    ts := false;
    mln := false;
    mlrd := false;
    SecDes := false;
    len := length(number);
    if (len = 0) or (number = '0') then
      result := digit[0]
    else
      for pos := len downto 1 do
      begin
        d := StrToInt(copy(number, len - pos + 1, 1));
        result := result + DigitToStr
      end
  end;
 
  function MoneyString(number: string): string;
  var
    s: string[1];
    n: string;
  begin
    len := length(number);
    n := copy(number, 1, len - 3);
    result := NumberString(n);
    s := AnsiUpperCase(result[1]);
    delete(result, 1, 1);
    result := s + result;
    if len &lt; 2 then
    begin
      if len = 0 then
        n := '0';
      len := 2;
      n := '0' + n
    end;
    if copy(n, len - 1, 1) = '1' then
      result := result + 'рублей'
    else
    begin
      case StrToInt(copy(n, len, 1)) of
        1: result := result + 'рубль';
        2, 3, 4: result := result + 'рубля'
      else
        result := result + 'рублей'
      end
    end;
    len := length(number);
    n := copy(number, len - 1, len);
    if copy(n, 1, 1) = '1' then
      n := n + ' копеек.'
    else
    begin
      case StrToInt(copy(n, 2, 1)) of
        1: n := n + ' копейка.';
        2, 3, 4: n := n + ' копейки.'
      else
        n := n + ' копеек.'
      end
    end;
    result := result + ' ' + n
  end;
 
  // Основная часть
begin
 
  case c of
    0: result := MoneyString(FormatFloat('0.00', n));
    1: result := NumberString(FormatFloat('0', n));
    2:
      begin
        summa := FormatFloat('0.00', n);
        len := length(summa);
        if copy(summa, len - 1, 2) = '00' then
        begin
          delete(summa, len - 2, 3);
          result := summa + '='
        end
        else
        begin
          delete(summa, len - 2, 1);
          insert('-', summa, len - 2);
          result := summa;
        end;
      end
  end;
end;
 
</pre>
<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

<hr />
<p>Честно, давно ждал подобного журнала в электронном виде. Решил послать своё творчество которое уже немало отработало, опять же, преобразование числа в пропись, отличающееся от опубликованных программок тем, что слова для прописи хранятся в отдельном файле (lang.cnf), по аналогии с подуктами 1C. Это позволяет изменять национальную валюту. </p>

<p>Если поэкспериментировать, с массивом Univer, в котором хранятся окончания, можно добиться преобразования для многих языков, не сказал ли я чего лишнего. :) </p>

<p>Надеюсь, моя версия Вам понравится. </p>

<p>С наилучшими пожеланиями, </p>

<p>Панченко Сергей </p>

<p>Казахстан, Алматы, </p>

<pre>
unit BuchUtil;
 
interface
 
uses IniFiles, SysUtils;
 
function DoubleChar(ch: string): string;
function NumToSampl(N: string): string;
function MoneyToSampl(M: Currency): string;
procedure LexemsToDim(fstr: string; var dim: array of string);
 
var
 
  NameNum: array[0..9, 1..4] of string; //массив им?н чисел
  Ext: array[0..4, 1..3] of string; //массив расшиений (тысячи, миллионы ...)
  Univer: array[1..9, 1..4] of integer; //массив окончаний
  Rubl: array[1..3] of string; //массив имен рублей
  Cop: array[1..3] of string; //массив имен копеек
  Zero: string; //название нуля
  One: string; //единица "одна"
  Two: string; //двойка "две"
  fFile: TIniFile; //файл, откуда загружается пропись
  fString: string;
  fDim: array[0..9] of string;
  i: integer;
 
implementation
 
{заполняет массив Dim лексемами}
 
procedure LexemsToDim(fstr: string; var dim: array of string);
var
 
  i, j: integer;
  flex: string;
begin
 
  if Length(fstr) &gt; 0 then
  begin
    i := 1;
    j := 0;
    while i - 1 &lt; Length(fstr) do
    begin
      if fstr[i] = ',' then
      begin
        dim[j] := flex + ' ';
        inc(j);
        flex := '';
      end
      else
        flex := flex + fstr[i];
      inc(i);
    end;
  end;
end;
 
{преобразует число в пропись
 
процедура использует файл lang.cnf}
 
function NumToSampl(N: string): string;
var
 
  k, i, i_indx: integer;
  number, string_num: string;
  index: integer;
  pos: integer;
  fl_ext: boolean;
begin
 
  fl_ext := true;
  i := 1;
  String_num := '';
  number := Trim(N);
  k := length(number);
  if (k = 1) and (number = '0') then
    String_num := Zero
  else
  begin
 
    pos := 0;
    while (k &gt; 0) do
    begin
      if (k &lt;&gt; 1) and (i = 1) and (length(number) &lt;&gt; 1) and (copy(number, k - 1,
        1) = '1')
        and (copy(number, k, 1) &lt;&gt; '0') then
      begin
        index := StrToInt(copy(number, k, 1));
        dec(k);
        inc(i);
        i_indx := 4;
      end
      else
      begin
        index := StrToInt(copy(number, k, 1));
        i_indx := i;
      end;
      if (NameNum[index, i_indx] &lt;&gt; '') and (fl_ext = true) then
      begin
        String_num := Ext[pos, Univer[index, i_indx]] + String_num;
        fl_ext := false;
      end;
 
      if (index = 1) and (pos = 1) and (i = 1) then
        String_num := One + String_num
      else if (index = 2) and (pos = 1) and (i = 1) then
        String_num := Two + String_num
      else
        String_num := NameNum[index, i_indx] + String_num;
      inc(i);
      if i = 4 then
      begin
        i := 1;
        inc(pos);
        fl_ext := true
      end;
      dec(k);
    end;
  end;
 
  if Trim(String_Num) &lt;&gt; '' then
  begin
    String_num[1] := CHR(ORD(String_num[1]) - 32);
    Result := String_num;
  end;
end;
 
{Преобразует х в 0х}
 
function DoubleChar(ch: string): string;
begin
 
  if Length(ch) = 1 then
    Result := '0' + ch
  else
    Result := ch;
end;
 
{преобразует денежную сумму в пропись}
 
function MoneyToSampl(M: Currency): string;
var
 
  Int_Part, idx, idxIP, idxRP: integer;
  Int_Str, Real_Part, Sampl: string;
begin
 
  Int_Part := Trunc(Int(M));
  Int_Str := IntToStr(Int_Part);
  Real_Part := DoubleChar(IntToStr(Trunc(Int((M - Int_Part + 0.001) * 100))));
  Sampl := NumToSampl(Int_Str);
  idx := StrToInt(Int_Str[Length(Int_Str)]);
  if idx = 0 then
    idx := 5;
  idxIP := Univer[idx, 1];
  idx := StrToInt(Real_Part[Length(Real_Part)]);
  if idx = 0 then
    idx := 5;
  idxRP := Univer[idx, 1];
  Result := Sampl + Rubl[idxIP] + Real_Part + ' ' + Cop[idxRP];
end;
 
initialization
 
  {Предположим файл находится на C:\ диске}
  fFile := TIniFile.Create('c:\lang.cnf');
  try
    {Заполнение массива рублей}
    fString := fFile.ReadString('Money', 'Rub', ',');
    LexemsToDim(fString, Rubl);
 
    {Заполнение массива копеек}
    fString := fFile.ReadString('Money', 'Cop', ',');
    LexemsToDim(fString, Cop);
 
    {Заполнение массива чисел}
    fString := fFile.ReadString('Nums', 'Numbers', ',');
    LexemsToDim(fString, fdim);
    NameNum[0, 1] := '';
    for i := 1 to 9 do
      NameNum[i, 1] := fdim[i - 1];
 
    {Заполнение массива десятков}
    fString := fFile.ReadString('Nums', 'Tens', ',');
    LexemsToDim(fString, fdim);
    NameNum[0, 2] := '';
    for i := 1 to 9 do
      NameNum[i, 2] := fdim[i - 1];
 
    {Заполнение массива сотен}
    fString := fFile.ReadString('Nums', 'Hundreds', ',');
    LexemsToDim(fString, fdim);
    NameNum[0, 3] := '';
    for i := 1 to 9 do
      NameNum[i, 3] := fdim[i - 1];
 
    {Заполнение массива чисел после десяти}
    fString := fFile.ReadString('Nums', 'AfterTen', ',');
    LexemsToDim(fString, fdim);
    NameNum[0, 4] := '';
    for i := 1 to 9 do
      NameNum[i, 4] := fdim[i - 1];
 
    {Заполнение расширений чисел}
    Ext[0, 1] := '';
    Ext[0, 2] := '';
    Ext[0, 3] := '';
 
    {Тысячи}
    fString := fFile.ReadString('Nums', 'Thou', ',');
    LexemsToDim(fString, fdim);
    for i := 1 to 3 do
      Ext[1, i] := fdim[i - 1];
 
    {Миллионы}
    fString := fFile.ReadString('Nums', 'Mill', ',');
    LexemsToDim(fString, fdim);
    for i := 1 to 3 do
      Ext[2, i] := fdim[i - 1];
 
    {Миллиарды}
    fString := fFile.ReadString('Nums', 'Bill', ',');
    LexemsToDim(fString, fdim);
    for i := 1 to 3 do
      Ext[3, i] := fdim[i - 1];
 
    {Триллион}
    fString := fFile.ReadString('Nums', 'Thrill', ',');
    LexemsToDim(fString, fdim);
    for i := 1 to 3 do
      Ext[4, i] := fdim[i - 1];
 
    Zero := fFile.ReadString('Nums', 'Zero', '0');
    if Zero[Length(Zero)] = ',' then
      Zero := Copy(Zero, 1, Length(Zero) - 1) + ' ';
 
    One := fFile.ReadString('Nums', 'One', '1');
    if One[Length(One)] = ',' then
      One := Copy(One, 1, Length(One) - 1) + ' ';
 
    Two := fFile.ReadString('Nums', 'Two', '0');
    if Two[Length(Two)] = ',' then
      Two := Copy(Two, 1, Length(Two) - 1) + ' ';
 
    {Заполнение таблицы окончаний}
    Univer[1, 1] := 1;
    Univer[1, 2] := 2;
    Univer[1, 3] := 2;
    Univer[1, 4] := 2;
    Univer[2, 1] := 3;
    Univer[2, 2] := 2;
    Univer[2, 3] := 2;
    Univer[2, 4] := 2;
    Univer[3, 1] := 3;
    Univer[3, 2] := 2;
    Univer[3, 3] := 2;
    Univer[3, 4] := 2;
    Univer[4, 1] := 3;
    Univer[4, 2] := 2;
    Univer[4, 3] := 2;
    Univer[4, 4] := 2;
    Univer[5, 1] := 2;
    Univer[5, 2] := 2;
    Univer[5, 3] := 2;
    Univer[5, 4] := 2;
    Univer[6, 1] := 2;
    Univer[6, 2] := 2;
    Univer[6, 3] := 2;
    Univer[6, 4] := 2;
    Univer[7, 1] := 2;
    Univer[7, 2] := 2;
    Univer[7, 3] := 2;
    Univer[7, 4] := 2;
    Univer[8, 1] := 2;
    Univer[8, 2] := 2;
    Univer[8, 3] := 2;
    Univer[8, 4] := 2;
    Univer[9, 1] := 2;
    Univer[9, 2] := 2;
    Univer[9, 3] := 2;
    Univer[9, 4] := 2;
  finally
    fFile.Free;
  end;
 
end.
</pre>


<pre>
[Nums]
Numbers=один,два,три,четыре,пять,шесть,семь,восемь,девять,
One=одна,
Two=две,
Tens=десять,двадцать,тридцать,сорок,пятьдесят,шестьдесят,семьдесят,восемьдесят,девяносто,
Hundreds=сто,двести,триста,четыреста,пятьсот,шестьсот,семьсот,восемьсот,девятьсот,
AfterTen=одиннадцать,двенадцать,тринадцать,четырнадцать,пятнадцать,шестнадцать,семнадцать,восемнадцать,девятнадцать,
Zero=ноль,
Thou=тысяча,тысяч,тысячи,
Mill=миллион,миллионов,миллиона,
Bill=миллиард,миллиардов,миллиарда,
Thrill=триллион,триллионов,триллиона,

[Money]
Rub=рубль,рублей,рубля,
Cop=копейка,копеек,копейки,
</pre>

<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

<hr />
<pre>
unit sumstr;
 
interface
 
uses
  SysUtils, StrUtils;
 
function SumToString(Value: string): string;
 
implementation
const
 
a: array[0..8,0..9] of string=(
('','один ','два ','три ','четыре ','пять ','шесть ','семь ','восемь ','девять '),
('','','двадцать ','тридцать ','сорок ','пятьдесят ','шестьдесят ','семьдесят ','восемьдесят ','девяносто '),
('','сто ','двести ','триста ','четыреста ','пятьсот ','шестьсот ','семьсот ','восемьсот ','девятьсот '),
('тысяч ','тысяча ','две тысячи ','три тысячи ','четыре тысячи ','пять тысячь ','шесть тысячь ','семь тысячь ',
'восемь тысячь ','девять тысячь '),
('','','двадцать ','тридцать ','сорок ','пятьдесят ','шестьдесят ','семьдесят ','восемьдесят ','девяносто '),
('','сто ','двести ','триста ','четыреста ','пятьсот ','шестьсот ','семьсот ','восемьсот ','девятьсот '),
('миллионов ','один миллион ','два миллиона ','три миллиона ','четыре миллиона ','пять миллионов ',
'шесть миллионов ','семь миллионов ','восемь миллионов ','девять миллионов '),
('','','двадцать ','тридцать ','сорок ','пятьдесят ','шестьдесят ','семьдесят ','восемьдесят ','девяносто '),
('','сто ','двести ','триста ','четыреста ','пятьсот ','шестьсот ','семьсот ','восемьсот ','девятьсот '));
 
b: array[0..9] of string=
('десять ','одинадцать ','двенадцать ','тринадцать ','четырнадцать ','пятьнадцать ','шестьнадцать ',
'семьнадцать ','восемьнадцать ','девятьнадцать ');
 
function SumToStrin(Value: string): string;
var
  s, t: string;
  p, pp, i, k: integer;
begin
  s:=value;
  if s='0' then
    t:='Ноль '
  else
  begin
    p:=length(s);
    pp:=p;
    if p&gt;1 then
      if (s[p-1]='1') and (s[p]&gt;'0') then
      begin
        t:=b[strtoint(s[p])];
        pp:=pp-2;
      end;
    i:=pp;
    while i&gt;0 do
    begin
      if (i=p-3) and (p&gt;4) then
        if s[p-4]='1' then
        begin
          t:=b[strtoint(s[p-3])]+'тысяч '+t;
          i:=i-2;
        end;
      if (i=p-6) and (p&gt;7) then
        if s[p-7]='1' then
        begin
          t:=b[strtoint(s[p-6])]+'миллионов '+t;
          i:=i-2;
        end;
      if i&gt;0 then
      begin
        k:=strtoint(s[i]);
        t:=a[p-i,k]+t;
        i:=i-1;
      end;
    end;
  end;
  result:=t;
end;
 
procedure get2str(value: string; var hi, lo: string);
var
  p: integer;
begin
  p:=pos(',', value);
  lo:='';
  hi:='';
  if p=0 then
    p:=pos('.', value);
  if p&lt;&gt;0 then
    delete(value,p,1);
  if p=0 then
  begin
    hi:=value;
    lo:='00';
  end;
  if p&gt;length(value) then
  begin
    hi:=value;
    lo:='00';
  end;
  if p=1 then
  begin
    hi:='0';
    lo:=value;
  end;
  if (p&gt;1) and (p then
  begin
    hi:=copy(value,1,p-1);
    lo:=copy(value,p,length(value));
  end;
end;
 
function sumtostring(value: string): string;
var
  hi, lo: string;
  pr, er: integer;
begin
  get2str(value,hi,lo);
  if (hi='') or (lo='') then
  begin
    result:='';
    exit;
  end;
  val(hi,pr,er);
  if er&lt;&gt;0 then
  begin
    result:='';
    exit;
  end;
  hi:=sumtostrin(inttostr(pr))+'руб. ';
  if lo&lt;&gt;'00' then
  begin
    val(lo,pr,er);
    if er&lt;&gt;0 then
    begin
      result:='';
      exit;
    end;
    lo:=inttostr(pr);
  end;
  lo:=lo+' коп. ';
  hi[1]:=AnsiUpperCase(hi[1])[1];
  result:=hi+lo;
end;
 
end.
</pre>
<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>


<hr />
<p>Этот алгоритм преобразует 12345 в "двенадцать тысяч триста сорок пять". Для этого создана процедура, которая преобразует трехзначные числа в слова и прибавляет к ним "тысяч" или "миллионов". Алгоритм корректен в смысле падежей и родов. Поэтому 121000 он не переведет в "сто двадцать один тысяч". </p>

<pre>
function ShortNum(num: word; razr: integer): string;
const
  hundreds: array [0..9] of string =
  ('', ' сто', ' двести', ' триста',
  ' четыреста', ' пятьсот', ' шестьсот', ' семьсот', ' восемьсот',
  ' девятьсот');
 
  tens: array [0..9] of string =
  ('', '', ' двадцать', ' тридцать',
  ' сорок', ' пятьдесят', ' шестьдесят', ' семьдесят', ' восемьдесят',
  ' девяносто');
 
  ones: array [3..19] of string =
  (' три', ' четыре', ' пять', ' шесть',
  ' семь', ' восемь', ' девять', ' десять', ' одиннадцать',
  ' двенадцать', ' тринадцать', ' четырнадцать', ' пятнадцать',
  ' шестнадцать', ' семнадцать', ' восемнадцать', ' девятнадцать');
 
  razryad: array [0..6] of string =
  ('', ' тысяч', ' миллион', ' миллиард',
  ' триллион', ' квадриллион', ' квинтиллион');
 
var
  t: byte; // десятки
  o: byte; // единицы
begin
  result := hundreds[num div 100];
  if num = 0 then
    Exit;
  t := (num mod 100) div 10;
  o := num mod 10;
  if t &lt;&gt; 1 then
  begin
    result := result + tens[t];
    case o of
      1:
        if razr = 1 then
          result := result + ' одна'
        else
          result := result + ' один';
      2:
        if razr = 1 then
          result := result + ' две'
        else
          result := result + ' два';
      3..9:
        result := result + ones[o];
    end;
    result := result + razryad[razr];
    case o of
      1:
        if razr = 1 then
          result := result + 'а';
      2..4:
        if razr = 1 then
          result := result + 'и'
        else
        if razr &gt; 1 then
          result := result + 'а';
        else
        if razr &gt; 1 then
          result := result + 'ов';
    end;
  end
  else
  begin
    result := result + ones[num mod 100];
    result := result + razryad[razr];
    if razr &gt; 1 then
      result := result + 'ов';
  end;
end;
 
function IntToWords(s: string): string;
var
  i, count: integer;
begin
  if (Length(s) &lt;= 0) or (s = '0') then
  begin
    result := 'ноль';
    Exit;
  end;
  count := (Length(s) + 2) div 3;
  if count &gt; 7 then
  begin
    result := 'Value is too large';
    Exit;
  end;
  result := '';
  s := '00' + s;
  for i := 1 to count do
    result := ShortNum(StrToInt(copy(s, Length(s) - 3 * i + 1, 3)),
    i - 1) + result;
  if Length(result) &gt; 0 then
    delete(result, 1, 1);
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  Edit2.Text := IntToWords(Edit1.Text);
end;
</pre>
<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Сумма и количество прописью, работа с падежами
 
Несколько функций для работы с строками:
function SumToString(Value : String) : string;//Сумма прописью
function KolToStrin(Value : String) : string;//Количество прописью
function padeg(s:string):string;//Склоняет фамилию имя и отчество (кому)
function padegot(s:string):string;//Склоняет фамилию имя и отчество (от кого)
function fio(s:string):string;//фамилия имя и отчество сокращенно
function longdate(s:string):string;//Длинная дата
procedure getfullfio(s:string;var fnam,lnam,onam:string);
//Получить из строки фамилию имя и отчество сокращенно
 
Зависимости: uses SysUtils, StrUtils,Classes;
Автор:       Eda, eda@arhadm.net.ru, Архангельск
Copyright:   Eda
Дата:        13 июня 2003 г.
***************************************************** }
 
unit sumstr;
 
interface
uses
  SysUtils, StrUtils, Classes;
var
  rub: byte;
function SumToString(Value: string): string; //Сумма прописью
function KolToStrin(Value: string): string; //Количество прописью
function padeg(s: string): string; //Склоняет фамилию имя и отчество (кому)
function padegot(s: string): string; //Склоняет фамилию имя и отчество (от кого)
function fio(s: string): string; //фамилия имя и отчество сокращенно
function longdate(s: string): string; //Длинная дата
procedure getfullfio(s: string; var fnam, lnam, onam: string);
  //Получить из строки фамилию имя и отчество сокращенно
 
implementation
const
  a: array[0..8, 0..9] of string = (
    ('', 'один ', 'два ', 'три ', 'четыре ', 'пять ', 'шесть ', 'семь ',
      'восемь ', 'девять '),
    ('', '', 'двадцать ', 'тридцать ', 'сорок ', 'пятьдесят ', 'шестьдесят ',
      'семьдесят ', 'восемьдесят ', 'девяносто '),
    ('', 'сто ', 'двести ', 'триста ', 'четыреста ', 'пятьсот ', 'шестьсот ',
      'семьсот ', 'восемьсот ', 'девятьсот '),
    ('тысяч ', 'одна тысяча ', 'две тысячи ', 'три тысячи ', 'четыре тысячи ',
      'пять тысяч ', 'шесть тысяч ', 'семь тысяч ', 'восемь тысяч ',
      'девять тысяч '),
    ('', '', 'двадцать ', 'тридцать ', 'сорок ', 'пятьдесят ', 'шестьдесят ',
      'семьдесят ', 'восемьдесят ', 'девяносто '),
    ('', 'сто ', 'двести ', 'триста ', 'четыреста ', 'пятьсот ', 'шестьсот ',
      'семьсот ', 'восемьсот ', 'девятьсот '),
    ('миллионов ', 'один миллион ', 'два миллиона ', 'три миллиона ',
      'четыре миллиона ', 'пять миллионов ', 'шесть миллионов ', 'семь миллионов ',
      'восемь миллионов ', 'девять миллионов '),
    ('', '', 'двадцать ', 'тридцать ', 'сорок ', 'пятьдесят ', 'шестьдесят ',
      'семьдесят ', 'восемьдесят ', 'девяносто '),
    ('', 'сто ', 'двести ', 'триста ', 'четыреста ', 'пятьсот ', 'шестьсот ',
      'семьсот ', 'восемьсот ', 'девятьсот '));
  c: array[0..8, 0..9] of string = (
    ('', 'одна ', 'две ', 'три ', 'четыре ', 'пять ', 'шесть ', 'семь ',
      'восемь ', 'девять '),
    ('', '', 'двадцать ', 'тридцать ', 'сорок ', 'пятьдесят ', 'шестьдесят ',
      'семьдесят ', 'восемьдесят ', 'девяносто '),
    ('', 'сто ', 'двести ', 'триста ', 'четыреста ', 'пятьсот ', 'шестьсот ',
      'семьсот ', 'восемьсот ', 'девятьсот '),
    ('тысячь ', 'одна тысяча ', 'две тысячи ', 'три тысячи ', 'четыре тысячи ',
      'пять тысяч ', 'шесть тысяч ', 'семь тысяч ', 'восемь тысяч ',
      'девять тысяч '),
    ('', '', 'двадцать ', 'тридцать ', 'сорок ', 'пятьдесят ', 'шестьдесят ',
      'семьдесят ', 'восемьдесят ', 'девяносто '),
    ('', 'сто ', 'двести ', 'триста ', 'четыреста ', 'пятьсот ', 'шестьсот ',
      'семьсот ', 'восемьсот ', 'девятьсот '),
    ('миллионов ', 'один миллион ', 'два миллиона ', 'три миллиона ',
      'четыре миллиона ', 'пять миллионов ', 'шесть миллионов ', 'семь миллионов ',
      'восемь миллионов ', 'девять миллионов '),
    ('', '', 'двадцать ', 'тридцать ', 'сорок ', 'пятьдесят ', 'шестьдесят ',
      'семьдесят ', 'восемьдесят ', 'девяносто '),
    ('', 'сто ', 'двести ', 'триста ', 'четыреста ', 'пятьсот ', 'шестьсот ',
      'семьсот ', 'восемьсот ', 'девятьсот '));
  b: array[0..9] of string =
  ('десять ', 'одинадцать ', 'двенадцать ', 'тринадцать ', 'четырнадцать ',
    'пятнадцать ', 'шестнадцать ', 'семнадцать ', 'восемнадцать ',
    'девятнадцать ');
var
  pol: boolean;
 
function longdate(s: string): string; //Длинная дата
var
  Pr: TDateTime;
  Y, M, D: Word;
begin
  Pr := strtodate(s);
  DecodeDate(Pr, Y, M, D);
  case m of
    1: s := 'Января';
    2: s := 'Февраля';
    3: s := 'Марта';
    4: s := 'Апреля';
    5: s := 'Мая';
    6: s := 'Июня';
    7: s := 'Июля';
    8: s := 'Августа';
    9: s := 'Сентября';
    10: s := 'Октября';
    11: s := 'Ноября';
    12: s := 'Декабря';
  end;
  result := inttostr(d) + ' ' + s + ' ' + inttostr(y)
end;
 
function SumToStrin(Value: string): string;
var
  s, t: string;
  p, pp, i, k: integer;
begin
  s := value;
  if s = '0' then
    t := 'Ноль '
  else
  begin
    p := length(s);
    pp := p;
    if p &gt; 1 then
      if (s[p - 1] = '1') and (s[p] &gt;= '0') then
      begin
        t := b[strtoint(s[p])];
        pp := pp - 2;
      end;
    i := pp;
    while i &gt; 0 do
    begin
      if (i = p - 3) and (p &gt; 4) then
        if s[p - 4] = '1' then
        begin
          t := b[strtoint(s[p - 3])] + 'тысяч ' + t;
          i := i - 2;
        end;
      if (i = p - 6) and (p &gt; 7) then
        if s[p - 7] = '1' then
        begin
          t := b[strtoint(s[p - 6])] + 'миллионов ' + t;
          i := i - 2;
        end;
      if i &gt; 0 then
      begin
        k := strtoint(s[i]);
        t := a[p - i, k] + t;
        i := i - 1;
      end;
    end;
  end;
  result := t;
end;
 
function kolToStrin(Value: string): string;
var
  s, t: string;
  p, pp, i, k: integer;
begin
  s := value;
  if s = '0' then
    t := 'Ноль '
  else
  begin
    p := length(s);
    pp := p;
    if p &gt; 1 then
      if (s[p - 1] = '1') and (s[p] &gt; '0') then
      begin
        t := b[strtoint(s[p])];
        pp := pp - 2;
      end;
    i := pp;
    while i &gt; 0 do
    begin
      if (i = p - 3) and (p &gt; 4) then
        if s[p - 4] = '1' then
        begin
          t := b[strtoint(s[p - 3])] + 'тысяча ' + t;
          i := i - 2;
        end;
      if (i = p - 6) and (p &gt; 7) then
        if s[p - 7] = '1' then
        begin
          t := b[strtoint(s[p - 6])] + 'миллионов ' + t;
          i := i - 2;
        end;
      if i &gt; 0 then
      begin
        k := strtoint(s[i]);
        t := c[p - i, k] + t;
        i := i - 1;
      end;
    end;
  end;
  result := t;
end;
 
procedure get2str(value: string; var hi, lo: string);
var
  p: integer;
begin
  p := pos(',', value);
  lo := '';
  hi := '';
  if p = 0 then
    p := pos('.', value);
  if p &lt;&gt; 0 then
    delete(value, p, 1);
  if p = 0 then
  begin
    hi := value;
    lo := '00';
    exit;
  end;
  if p &gt; length(value) then
  begin
    hi := value;
    lo := '00';
    exit;
  end;
  if p = 1 then
  begin
    hi := '0';
    lo := value;
    exit;
  end;
  begin
    hi := copy(value, 1, p - 1);
    lo := copy(value, p, length(value));
    if length(lo) &lt; 2 then
      lo := lo + '0';
  end;
end;
 
function sumtostring(value: string): string;
var
  hi, lo, valut, loval: string;
  pr, er: integer;
begin
  get2str(value, hi, lo);
  if (hi = '') or (lo = '') then
  begin
    result := '';
    exit;
  end;
  val(hi, pr, er);
  if er &lt;&gt; 0 then
  begin
    result := '';
    exit;
  end;
  if rub = 0 then
  begin
    if hi[length(hi)] = '1' then
      valut := 'рубль ';
    if (hi[length(hi)] &gt;= '2') and (hi[length(hi)] &lt;= '4') then
      valut := 'рубля ';
    if (hi[length(hi)] = '0') or (hi[length(hi)] &gt;= '5') or
    ((strtoint(copy(hi, length(hi) - 1, 2)) &gt; 10) and (strtoint(copy(hi,
      length(hi) - 1, 2)) &lt; 15)) then
      valut := 'рублей ';
    if (lo[length(lo)] = '0') or (lo[length(lo)] &gt;= '5') then
      loval := ' копеек';
    if lo[length(lo)] = '1' then
      loval := ' копейка';
    if (lo[length(lo)] &gt;= '2') and (lo[length(lo)] &lt;= '4') then
      loval := ' копейки';
  end
  else
  begin
    if (hi[length(hi)] = '0') or (hi[length(hi)] &gt;= '5') then
      valut := 'долларов ';
    if hi[length(hi)] = '1' then
      valut := 'доллар ';
    if (hi[length(hi)] &gt;= '2') and (hi[length(hi)] &lt;= '4') then
      valut := 'доллара ';
    if (lo[length(lo)] = '0') or (lo[length(lo)] &gt;= '5') then
      loval := ' центов';
    if lo[length(lo)] = '1' then
      loval := ' цент';
    if (lo[length(lo)] &gt;= '2') and (lo[length(lo)] &lt;= '4') then
      loval := ' цента';
  end;
  hi := sumtostrin(inttostr(pr)) + valut;
  if lo &lt;&gt; '00' then
  begin
    val(lo, pr, er);
    if er &lt;&gt; 0 then
    begin
      result := '';
      exit;
    end;
    lo := inttostr(pr);
  end;
  if length(lo) &lt; 2 then
    lo := '0' + lo;
  lo := lo + loval;
  hi[1] := AnsiUpperCase(hi[1])[1];
  result := hi + lo;
end;
 
function pfam(s: string): string;
begin
  if (s[length(s)] = 'к') or (s[length(s)] = 'ч') and (pol = true) then
    s := s + 'у';
  if s[length(s)] = 'в' then
    s := s + 'у';
  if s[length(s)] = 'а' then
  begin
    delete(s, length(s), 1);
    result := s + 'ой';
    exit;
  end;
  if s[length(s)] = 'н' then
    s := s + 'у';
  if s[length(s)] = 'й' then
  begin
    delete(s, length(s) - 1, 2);
    result := s + 'ому';
  end;
  if s[length(s)] = 'я' then
  begin
    delete(s, length(s) - 1, 2);
    result := s + 'ой';
    exit;
  end;
  result := s;
end;
 
function pnam(s: string): string;
begin
  pol := true;
  if s[length(s)] = 'й' then
  begin
    delete(s, length(s), 1);
    s := s + 'ю';
  end;
  if s[length(s)] = 'л' then
    s := s + 'у';
  if s[length(s)] = 'р' then
    s := s + 'у';
  if s[length(s)] = 'м' then
    s := s + 'у';
  if s[length(s)] = 'н' then
    s := s + 'у';
  if s[length(s)] = 'я' then
  begin
    pol := false;
    delete(s, length(s), 1);
    s := s + 'е';
  end;
  if s[length(s)] = 'а' then
  begin
    pol := false;
    delete(s, length(s), 1);
    s := s + 'е';
  end;
  result := s;
end;
 
function potch(s: string): string;
begin
  if s[length(s)] = 'а' then
  begin
    delete(s, length(s), 1);
    s := s + 'е';
  end;
  if s[length(s)] = 'ч' then
    s := s + 'у';
  result := s;
end;
 
function ofam(s: string): string;
begin
  if (s[length(s)] = 'к') or (s[length(s)] = 'ч') and (pol = true) then
    s := s + 'а';
  if s[length(s)] = 'а' then
  begin
    delete(s, length(s), 1);
    result := s + 'ой';
    exit;
  end;
  if s[length(s)] = 'в' then
    s := s + 'а';
  if s[length(s)] = 'н' then
    s := s + 'а';
  if s[length(s)] = 'й' then
  begin
    delete(s, length(s) - 1, 2);
    result := s + 'ова';
  end;
  if s[length(s)] = 'я' then
  begin
    delete(s, length(s) - 1, 2);
    result := s + 'ой';
    exit;
  end;
  result := s;
end;
 
function onam(s: string): string;
begin
  pol := true;
  if s[length(s)] = 'а' then
    if s[length(s) - 1] = 'г' then
    begin
      pol := false;
      delete(s, length(s), 1);
      s := s + 'и';
    end
    else
    begin
      pol := false;
      delete(s, length(s), 1);
      s := s + 'ы';
    end;
  if s[length(s)] = 'л' then
    s := s + 'а';
  if s[length(s)] = 'р' then
    s := s + 'а';
  if s[length(s)] = 'м' then
    s := s + 'а';
  if s[length(s)] = 'н' then
    s := s + 'а';
  if s[length(s)] = 'я' then
  begin
    pol := false;
    delete(s, length(s), 1);
    s := s + 'и';
  end;
  if s[length(s)] = 'й' then
  begin
    delete(s, length(s), 1);
    s := s + 'я';
  end;
  result := s;
end;
 
function ootch(s: string): string;
begin
  if s[length(s)] = 'а' then
  begin
    delete(s, length(s), 1);
    s := s + 'ы';
  end;
  if s[length(s)] = 'ч' then
    s := s + 'а';
  result := s;
end;
 
function padeg(s: string): string;
var
  q: tstringlist;
  p: integer;
begin
  if s &lt;&gt; '' then
  begin
    q := tstringlist.Create;
    p := pos(' ', s);
    if p = 0 then
      p := pos('.', s);
    if p = 0 then
      q.Add(s)
    else
    begin
      q.Add(copy(s, 1, p - 1));
      delete(s, 1, p);
      p := pos(' ', s);
      if p = 0 then
        p := pos('.', s);
      if p = 0 then
        q.Add(s)
      else
      begin
        q.Add(copy(s, 1, p - 1));
        delete(s, 1, p);
        p := pos(' ', s);
        if p = 0 then
          p := pos('.', s);
        if p = 0 then
          q.Add(s)
        else
        begin
          q.Add(copy(s, 1, p - 1));
          delete(s, 1, p);
        end;
      end;
    end;
    if q.Count &gt; 1 then
      result := result + ' ' + pnam(q[1]);
    if q.Count &gt; 0 then
      result := pfam(q[0]) + result;
    if q.Count &gt; 2 then
      result := result + ' ' + potch(q[2]);
    q.Free;
  end;
end;
 
function fio(s: string): string;
var
  q: tstringlist;
  p: integer;
begin
  if s &lt;&gt; '' then
  begin
    q := tstringlist.Create;
    p := pos(' ', s);
    if p = 0 then
      p := pos('.', s);
    if p = 0 then
      q.Add(s)
    else
    begin
      q.Add(copy(s, 1, p - 1));
      delete(s, 1, p);
      p := pos(' ', s);
      if p = 0 then
        p := pos('.', s);
      if p = 0 then
        q.Add(s)
      else
      begin
        q.Add(copy(s, 1, 1));
        delete(s, 1, p);
        p := pos(' ', s);
        if p = 0 then
          p := pos('.', s);
        if p = 0 then
          q.Add(copy(s, 1, 1))
        else
        begin
          q.Add(copy(s, 1, 1));
        end;
      end;
    end;
    if q.Count &gt; 1 then
      result := q[0] + ' ' + q[1] + '.';
    if q.Count &gt; 2 then
      result := result + q[2] + '.';
    q.Free;
  end;
end;
 
function padegot(s: string): string;
var
  q: tstringlist;
  p: integer;
begin
  if s &lt;&gt; '' then
  begin
    q := tstringlist.Create;
    p := pos(' ', s);
    if p = 0 then
      p := pos('.', s);
    if p = 0 then
      q.Add(s)
    else
    begin
      q.Add(copy(s, 1, p - 1));
      delete(s, 1, p);
      p := pos(' ', s);
      if p = 0 then
        p := pos('.', s);
      if p = 0 then
        q.Add(s)
      else
      begin
        q.Add(copy(s, 1, p - 1));
        delete(s, 1, p);
        p := pos(' ', s);
        if p = 0 then
          p := pos('.', s);
        if p = 0 then
          q.Add(s)
        else
        begin
          q.Add(copy(s, 1, p - 1));
          delete(s, 1, p);
        end;
      end;
    end;
    if q.Count &gt; 1 then
      result := result + ' ' + onam(q[1]);
    if q.Count &gt; 0 then
      result := ofam(q[0]) + result;
    if q.Count &gt; 2 then
      result := result + ' ' + ootch(q[2]);
    q.Free;
  end;
end;
 
procedure getfullfio(s: string; var fnam, lnam, onam: string);
  //Получить из строки фамилию имя и отчество сокращенно
begin
  fnam := '';
  lnam := '';
  onam := '';
  fnam := copy(s, 1, pos(' ', s));
  delete(s, 1, pos(' ', s));
  lnam := copy(s, 1, pos(' ', s));
  delete(s, 1, pos(' ', s));
  onam := s;
end;
 
begin
  rub := 0;
end.
Пример использования: 
 
s := SumToString('123.00');
 
 
</pre>
<hr />
<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Конвертация денежных сумм в строковое выражение
 
Конвертация денежных сумм в строковое выражение впоть до додециллиона,
причем легко наращивается. Небольшая по размеру.
 
Зависимости: System
Автор:       Раков Андрей, klopmail@mail.ru, Курчатов
Copyright:   Раков А.В.
Дата:        17 августа 2002 г.
***************************************************** }
 
function MoneyToStr(DD: string): string;
{(С) Раков А.В. 05.2002 e-mail: klopmail@mail.ru сайт: http://www.kursknet.ru/~klop}
type
  TTroyka = array[1..3] of Byte;
  TMyString = array[1..19] of string[12];
var
  S, OutS, S2: string;
  k, L, kk: Integer;
  Troyka: TTroyka;
  V1: TMyString;
  Mb: Byte;
const
  V11: TMyString =
  ('один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять',
    'десять', 'одиннадцать',
    'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать',
      'семнадцать', 'восемнадцать', 'девятнадцать');
  V2: array[1..8] of string =
  ('двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят',
    'восемьдесят', 'девяносто');
  V3: array[1..9] of string =
  ('сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот',
    'восемьсот', 'девятьсот');
  M1: array[1..13, 1..3] of string = (('тысяча', 'тысячи', 'тысяч'),
    ('миллион', 'миллиона', 'миллионов'),
    ('миллиард', 'миллиарда', 'миллиардов'),
    ('триллион', 'триллиона', 'триллионов'),
    ('квадриллион', 'квадриллиона', 'квадриллионов'),
    ('квинтиллион', 'квинтиллиона', 'квинтиллионов'),
    ('секстиллион', 'секстиллиона', 'секстиллионов'),
    ('сентиллион', 'сентиллиона', 'сентиллионов'),
    ('октиллион', 'октиллиона', 'октиллионов'),
    ('нониллион', 'нониллиона', 'нониллионов'),
    ('дециллион', 'дециллиона', 'дециллионов'),
    ('ундециллион', 'ундециллиона', 'ундециллионов'),
    ('додециллион', 'додециллиона', 'додециллионов'));
  R1: array[1..3] of string = ('рубль', 'рубля', 'рублей');
  R2: array[1..3] of string = ('копейка', 'копейки', 'копеек');
  function TroykaToStr(L: ShortInt; TR: TTroyka): string;
  var
    S: string;
  begin
    S := '';
    if Abs(L) = 1 then
    begin
      V1[1] := 'одна';
      V1[2] := 'две';
    end
    else
    begin
      V1[1] := 'один';
      V1[2] := 'два';
    end;
    if Troyka[2] = 1 then
    begin
      Troyka[2] := 0;
      Troyka[3] := 10 + Troyka[3];
    end;
    if Troyka[3] &lt;&gt; 0 then
      S := V1[Troyka[3]];
    if Troyka[2] &lt;&gt; 0 then
      S := V2[Troyka[2] - 1] + ' ' + S;
    if Troyka[1] &lt;&gt; 0 then
      S := V3[Troyka[1]] + ' ' + S;
    if (L &gt; 0) and (S &lt;&gt; '') then
      case Troyka[3] of
        1: S := S + ' ' + M1[L, 1] + ' ';
        2..4: S := S + ' ' + M1[L, 2] + ' ';
      else
        S := S + ' ' + M1[L, 3] + ' ';
      end;
    TroykaToStr := S;
  end;
begin
  V1 := V11;
  L := 0;
  OutS := '';
  kk := Pos(',', DD);
  if kk = 0 then
    S := DD
  else
    S := Copy(DD, 1, kk - 1);
  if S = '0' then
    S2 := ''
  else
    S2 := S;
  repeat
    for k := 3 downto 1 do
      if Length(S) &gt; 0 then
      begin
        Troyka[k] := StrToInt(S[Length(S)]);
        Delete(S, Length(S), 1);
      end
      else
        Troyka[k] := 0;
    OutS := TroykaToStr(L, Troyka) + OutS;
    if L = 0 then
      Mb := Troyka[3];
    Inc(L);
  until Length(S) = 0;
  case Mb of
    0: if Length(S2) &gt; 0 then
        OutS := OutS + ' ' + R1[3] + ' ';
    1: OutS := OutS + ' ' + R1[1] + ' ';
    2..4: OutS := OutS + ' ' + R1[2] + ' ';
  else
    OutS := OutS + ' ' + R1[3] + ' ';
  end;
  S2 := '';
  if kk &lt;&gt; 0 then
  begin
    DD := Copy(DD, kk + 1, 2);
    if Length(DD) = 1 then
      DD := DD + '0';
    k := StrToInt(DD);
    Troyka[1] := 0;
    Troyka[2] := k div 10;
    Troyka[3] := k mod 10;
    S2 := TroykaToStr(-1, Troyka);
    case Troyka[3] of
      0: if Troyka[2] = 0 then
          S := ''
        else
          S := R2[3];
      1: S := R2[1];
      2..4: S := R2[2];
    else
      S := R2[3];
    end;
  end;
  // MoneyToStr:=OutS+IntToStr(k)+' '+S; // если копейки нужны цифрой-эту строку раскоментировать
  MoneyToStr := OutS + S2 + ' ' + S; // а эту закоментировать
end;
Пример использования: 
 
S := MoneyToStr('76576876876976576437654365,98'); 
 
 
</pre>

