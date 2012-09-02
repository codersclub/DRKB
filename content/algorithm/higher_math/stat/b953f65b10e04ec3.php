<h1>Биноминальное рапределение</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Биноминальное рапределение
 
Возвращает случайное число, распределенное по биноминальному закону
распределения
 
Зависимости: system
Автор:       Алексей Перов, aperov@rambler.ru, ICQ:102661702, Караганда
Copyright:   Лабораторные работы по курсу "Моделирование информационных систем", КарГТУ
Дата:        26 апреля 2002 г.
********************************************** }
 
function RandomBinom(n, p: Extended): Extended;
{ биноминальное распределение }
var
  x: Extended;
  i: Integer;
begin
  x := 0;
  for i := 1 to Round(n) do
    if Random - p &lt;= 0 then x := x + 1;
  Result := x
end; 
</pre>
<p>Пример использования:</p>
<pre>
x := RandomBinom(10, 0.4); 
</pre>

