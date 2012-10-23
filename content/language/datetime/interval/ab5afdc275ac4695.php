<h1>Работа со временем или как реализовать 1.20 + 1.50 = 3.10?</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Hans Pieters</div>
<p>Если Вы создаёте приложение, в котором пользователь вводит значения времени, то стандартные вычисления не подойдут. Проблема в том, что нужно сделать так, чтобы выражение 1.20 + 1.70 было равно НЕ 2.90 а 3.10.</p>
<p>Здесь представлены три функции, которые решают эту проблему. Они работают только с часами и минутами, потому что пользователь очень редко используют секунды, но если Вам потребуются секунды, то Вы без труда сможете доработать эти функции по своему желанию. Вторая и третья функции позволяют преобразовать реальное значение времени в десятичный эквивалент и обратно. Все поля на форме будут в формате hh.mm.</p>
<pre>
function sumhhmm(a, b: double): double;
var
  h1: double;
begin
  h1 := (INT(A) + INT(B)) * 60 + (frac(a) + frac(b)) * 100;
  result := int(h1 / 60) + (h1 - int(h1 / 60) * 60) / 100;
end;
 
function hhmm2hhdd(const hhmm: double): double;
begin
  result := int(hhmm) + (frac(hhmm) / 0.6);
end;
 
function hhdd2hhmm(const hhdd: double): double;
begin
  result := int(hhdd) + (frac(hhdd) * 0.6);
end;
</pre>
<p>Использование: </p>
<p>// sumtime(1.20,1.50) =&gt; 3.10 </p>
<p>// sumtime(1.20,- 0.50) =&gt; 0.30 </p>
<p>// hhmm2hhdd(1.30) =&gt; 1.5 (1h.30m = 1.5h) </p>
<p>// hhdd2hhmm(1.50) =&gt; 1.30 (1.5h = 1h30m) </p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
