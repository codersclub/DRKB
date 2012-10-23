<h1>Нормальное распределение</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Нормальное распределение
 
Возвращает случайное число, распределенное по нормальному закону распределения
с заданным математическим ожиданием и дисперсией
 
Зависимости: System
Автор:       Mystic, mystic2000@newmail.ru, ICQ:125905046, Харьков
Copyright:   Из книги Полякова и Круглова "Turbo Pascal 5.5"
Дата:        25 апреля 2002 г.
********************************************** }
 
function Gauss(Mx, Sigma: Extended): Extended;
var
  a, b, r, Sq: Extended;
begin
  repeat
    a := 2*Random - 1;
    b := 2*Random - 1;
    r := Sqr(a) + Srq(b);
  until r&lt;1;
  Sq := Sqrt(-2*Ln(r)/r);
  Result := Mx + Sigma * a * Sq;
end; 
</pre>

<p> Пример использования:</p>
<pre>
X := Gauss(0, 1); 
</pre>

<hr />
<p>В стандартном модуле &nbsp;Math есть функция </p>
function RandG(Mean, StdDev: Extended): Extended;</p>

<div class="author">Автор: Vit</div>
<p>&nbsp;
<p>&nbsp;</p>
