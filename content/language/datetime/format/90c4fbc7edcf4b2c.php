<h1>Вывод даты в нужном формате</h1>
<div class="date">01.01.2007</div>


<pre>
function CheckDateFormat(SDate:  string):  string;
var
  IDateChar: string;
  x, y: integer;
begin
  IDateChar := '.,\/';
  for y := 1 to length(IDateChar) do
  begin
    x := pos(IDateChar[y], SDate);
    while x &gt; 0 do
    begin
      Delete(SDate, x, 1);
      Insert('-', SDate, x);
      x := pos(IDateChar[y], SDate);
    end;
  end;
  CheckDateFormat := SDate;
end;
 
 
function DateEncode(SDate:string):longint;
var
  year, month, day: longint;
  wy, wm, wd: longint;
  Dummy: TDateTime;
  Check: integer;
begin
  DateEncode := -1;
  SDate := CheckDateFormat(SDate);
  Val(Copy(SDate, 1, pos('-', SDate) - 1), day, check);
  Delete(Sdate, 1, pos('-', SDate));
  Val(Copy(SDate, 1, pos('-', SDate) - 1), month, check);
  Delete(SDate, 1, pos('-', SDate));
  Val(SDate, year, check);
  wy := year;
  wm := month;
  wd := day;
  try
    Dummy := EncodeDate(wy, wm, wd);
  except
    year := 0;
    month := 0;
    day := 0;
  end;
  DateEncode := (year * 10000) + (month * 100) + day;
end;
</pre>
&nbsp;</p>
<hr />
<p class="p_Heading1">Формат даты </p>
<p>У меня есть неотложная задача: в настоящее время я разрабатываю проект, где я должен проверять достоверность введенных дат с применением маски __/__/____, например 12/12/1997.</p>
<p>Некоторое время назад я делал простой шифратор/дешифратор дат, проверяющий достоверность даты. Код приведен ниже.</p>
<pre>
function CheckDateFormat(SDate: string): string;
var
  IDateChar: string;
  x, y: integer;
begin
  IDateChar := '.,\/';
  for y := 1 to length(IDateChar) do
  begin
    x := pos(IDateChar[y], SDate);
    while x &gt; 0 do
    begin
      Delete(SDate, x, 1);
      Insert('-', SDate, x);
      x := pos(IDateChar[y], SDate);
    end;
  end;
  CheckDateFormat := SDate;
end;
 
function DateEncode(SDate: string): longint;
var
  year, month, day: longint;
  wy, wm, wd: longint;
  Dummy: TDateTime;
  Check: integer;
begin
  DateEncode := -1;
  SDate := CheckDateFormat(SDate);
  Val(Copy(SDate, 1, pos('-', SDate) - 1), day, check);
  Delete(Sdate, 1, pos('-', SDate));
  Val(Copy(SDate, 1, pos('-', SDate) - 1), month, check);
  Delete(SDate, 1, pos('-', SDate));
  Val(SDate, year, check);
  wy := year;
  wm := month;
  wd := day;
  try
    Dummy := EncodeDate(wy, wm, wd);
  except
    year := 0;
    month := 0;
    day := 0;
  end;
  DateEncode := (year * 10000) + (month * 100) + day;
end; 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<p class="p_Heading1">&nbsp;</p>
<p class="p_Heading1">&nbsp;</p>
<p class="p_Heading1">&nbsp;</p>
<p class="p_Heading1">&nbsp;</p>
<p class="p_Heading1">&nbsp;</p>
<p class="p_Heading1">&nbsp;</p>
