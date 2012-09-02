<h1>Гипергеометрическое распределение</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Гипергеометрическое распределение
 
Возвращает случайное число, распределенное по гипергеометрическому закону
распределения
 
Зависимости: system
Автор:       Алексей Перов, aperov@rambler.ru, ICQ:102661702, Караганда
Copyright:   Лабораторные работы по курсу "Моделирование информационных систем", КарГТУ
Дата:        26 апреля 2002 г.
********************************************** }
 
function RandomGipgeo(tn, ns, p: Extended): Extended;
{ гипергеометрическое распределение }
var
  x, s: Extended;
  i: Integer;
begin
  x := 0;
  for i := 1 to Round(ns) do begin
    if Random - p &lt;= 0
      then begin
        s := 1;
        x := x + 1
      end
      else s := 0;
    p := (tn * p - s) / (tn - 1)
  end;
  Result := x
end; 
</pre>

<p>Пример использования:</p>
<pre>
x := RandomGipgeo(2.5, 3, 0.4); 
</pre>

