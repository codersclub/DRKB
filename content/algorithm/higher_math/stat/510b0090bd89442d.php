<h1>Гамма распределение</h1>
<div class="date">01.01.2007</div>


<pre>
 
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Гамма распределение
 
Возвращает случайное число, распределенное по закону Гамма-распределения
 
Зависимости: system
Автор:       Алексей Перов, aperov@rambler.ru, ICQ:102661702, Караганда
Copyright:   Лабораторные работы по курсу "Моделирование информационных систем", КарГТУ
Дата:        25 апреля 2002 г.
********************************************** }
 
function RandomGamma(k, a: Extended): Extended;
{ гамма распределение }
var
  tr: Extended;
  i: Integer;
begin
  tr := 1;
  for i := 1 to Round(k) do tr := tr * random;
  Result := -ln(tr) / a
end; 
</pre>

<p> Пример использования:</p>
<pre>
x := RandomGamma(10, 5); 
</pre>

