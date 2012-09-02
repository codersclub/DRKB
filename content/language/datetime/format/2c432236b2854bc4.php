<h1>Название месяца &gt; номер месяца</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Функция преобразует текстовую строку, задающую название месяца, в номер месяца
 
функция преобразует текстовую строку,задающую название месяца, в номер месяца
 
Зависимости: ???
Автор:       Сергей, nfkazak@inbox.ru, Краснодар
Copyright:   VIP BANK
Дата:        11 сентября 2002 г.
***************************************************** }
 
function NumMonth(SMonth: string): word;
var
  i: byte;
begin
  Result := 0;
  for i := 1 to 12 do
    if AnsiUpperCase(SMonth) = Month[i] then
      Result := i
end;
</pre>
&nbsp;</p>
<hr />
<p>...через цикл обхода элементов глобального массива LongMonthNames:</p>
<pre>
Function GetMonthNumber(Month: String): Integer;
Begin
  For Result := 1 to 12 do
    If Month = LongMonthNames[Result] Then
      Exit;
  Result := 0;
End;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
