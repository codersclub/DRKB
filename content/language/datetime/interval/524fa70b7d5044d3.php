<h1>Сложение времени</h1>
<div class="date">01.01.2007</div>

<p>Если Вы создаёте приложение, в котором пользователь вводит значения времени, то стандартные вычисления не подойдут. Проблема в том, что нужно сделать так, чтобы выражение 1.20 + 1.70 было равно НЕ 2.90 а 3.10. </p>
<p>Здесь представлены три функции, которые решают эту проблему. Они работают только с часами и минутами, потому что пользователь очень редко используют секунды, но если Вам потребуются секунды, то Вы без труда сможете доработать эти функции по своему желаню. Вторая и третья функции позволяют преобразовать реальное значение времени в десятичный эквивалент и обратно. Все поля на форме будут в формате hh.mm. </p>
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
 
// ************************************** //
//             Использование:             //
// ************************************** //
// sumtime(1.20,1.50) =&gt; 3.10             //
// sumtime(1.20,- 0.50) =&gt; 0.30           //
// hhmm2hhdd(1.30) =&gt; 1.5 (1h.30m = 1.5h) //
// hhdd2hhmm(1.50) =&gt; 1.30 (1.5h = 1h30m) //
// ************************************** // 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
