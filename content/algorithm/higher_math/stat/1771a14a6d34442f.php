<h1>Распределение Паскаля</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Распределение Паскаля
 
Возвращает случайное число, распределенное по закону распределения Паскаля
 
Зависимости: system
Автор:       Алексей Перов, aperov@rambler.ru, ICQ:102661702, Караганда
Copyright:   Лабораторные работы по курсу "Моделирование информационных систем", КарГТУ
Дата:        26 апреля 2002 г.
********************************************** }
 
function RandomPascal(k, q: Extended): Extended;
{ распределение Паскаля }
var
  tr: Extended;
  i: Integer;
begin
  tr := 1;
  q := ln(q);
  for i := 1 to Round(k) do tr := tr * Random;
  Result := ln(tr) / q;
end; 
</pre>

<p> Пример использования:</p>
<pre>
x := RandomPascal(10, 5); 
</pre>

