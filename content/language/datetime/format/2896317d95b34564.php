<h1>Универсальная функция возврата значения элемента даты</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: Галимарзанов Фанис </div>
<p>Универсальная функция возврата значения элемента даты (год, месяц, день, квартал):</p>
<pre>
function RetDate(inDate: TDateTime; inTip: integer): integer;
var
  xYear, xMonth, xDay: word;
begin
  Result := 0;
  DecodeDate(inDate, xYear, xMonth, xDay);
  case inTip of
    1: Result := xYear;  // год
    2: Result := xMonth; // месяц
    3: Result := xDay;   // день
    4: if xMonth &lt; 4 then
         Result := 1
       else // квартал
       if xMonth &lt; 7 then
         Result := 2
       else
       if xMonth &lt; 10 then
         Result := 3
       else
         Result := 4;
  end;
end; 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
