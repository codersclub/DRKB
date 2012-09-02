<h1>Дни недели</h1>
<div class="date">01.01.2007</div>


<pre>
unit datefunc;
 
interface
function checkdate(date: string): boolean;
function Date2julian(date: string): longint;
function Julian2date(julian: longint): string;
function DayOfTheWeek(date: string): string;
function idag: string;
 
implementation
uses
 
  sysutils;
 
function idag(): string;
{Получает текущую дату и возвращает ее в формате YYYYMMDD для использования
другими функциями данного молуля.}
var
 
  Year, Month, Day: Word;
begin
  DecodeDate(Now, Year, Month, Day);
  result := IntToStr(year) + IntToStr(Month) + IntToStr(day);
end;
 
function Date2julian(date: string): longint;
{Получает дату в формате YYYYMMDD.
Если у вас другой формат,
в первую очередь преобразуйте его.}
var
 
  month, day, year: integer;
  ta, tb, tc: longint;
begin
 
  month := strtoint(copy(date, 5, 2));
  day := strtoint(copy(date, 7, 2));
  year := strtoint(copy(date, 1, 4));
  if month &gt; 2 then
    month := month - 3
  else
  begin
    month := month + 9;
    year := year - 1;
  end;
  ta := 146097 * (year div 100) div 4;
  tb := 1461 * (year mod 100) div 4;
  tc := (153 * month + 2) div 5 + day + 1721119;
  result := ta + tb + tc
end;
 
function mdy2date(month, day, year: integer): string;
var
 
  y, m, d: string;
begin
 
  y := '000' + inttostr(year);
  y := copy(y, length(y) - 3, 4);
  m := '0' + inttostr(month);
  m := copy(m, length(m) - 1, 2);
  d := '0' + inttostr(day);
  d := copy(d, length(d) - 1, 2);
  result := y + m + d;
 
end;
 
function Julian2date(julian: longint): string;
{Получает значение и возвращает дату в формате YYYYMMDD}
var
 
  x, y, d, m: longint;
  month, day, year: integer;
begin
 
  x := 4 * julian - 6884477;
  y := (x div 146097) * 100;
  d := (x mod 146097) div 4;
  x := 4 * d + 3;
  y := (x div 1461) + y;
  d := (x mod 1461) div 4 + 1;
  x := 5 * d - 3;
  m := x div 153 + 1;
  d := (x mod 153) div 5 + 1;
  if m &lt; 11 then
    month := m + 2
  else
    month := m - 10;
  day := d;
  year := y + m div 11;
  result := mdy2date(month, day, year);
end;
 
function checkdate(date: string): boolean;
{Дата должна быть в формате YYYYMMDD.}
var
 
  julian: longint;
  test: string;
begin
  {Сначала преобразовываем строку в юлианский формат даты.
  Это позволит получить необходимое значение.}
  julian := Date2julian(date);
  {Затем преобразовываем полученную величину в дату.
  Это всегда будет правильной датой. Для проверки делаем обратное преобразование.
  Результат проверки передаем как выходной параметр функции.}
  test := Julian2date(julian);
 
  if date = test then
 
    result := true
  else
 
    result := false;
end;
 
function DayOfTheWeek(date: string): string;
{Получаем дату в формате YYYYMMDD
и возвращаем день недели.}
var
 
  julian: longint;
begin
  julian := (Date2julian(date)) mod 7;
 
  case julian of
    0: result := 'Понедельник';
    1: result := 'Вторник';
    2: result := 'Среда';
    3: result := 'Четверг';
    4: result := 'Пятница';
    5: result := 'Суббота';
    6: result := 'Воскресенье';
  end;
end;
 
end.
</pre>
<p>Тем не менее, начиная со второй версии, Delphi содержат в своем арсенале замечательную функцию DayOfWeek, возвращающую целочисленный результат в диапазоне от 1 до 7. Вот пример кода, присланный Андреем Ивановым:</p>
<pre>
uses SysUtils;
...
 
function TForm1.DayOfWeekRus(S: TDateTime): string;
begin
  case DayOfWeek(S) of
    1: Result := 'Воскресенье';
    2: Result := 'Понедельник';
    3: Result := 'Вторник';
    4: Result := 'Среда';
    5: Result := 'Четверг';
    6: Result := 'Пятница';
    7: Result := 'Суббота';
  end;
end;
 
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>

