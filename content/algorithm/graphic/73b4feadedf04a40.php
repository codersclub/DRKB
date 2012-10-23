<h1>Нахождение угла между радиус-вектором и осью абсцисс</h1>
<div class="date">01.01.2007</div>


<pre>
function angl(y,x:extended):extended;  assembler; 
 asm 
  fld y   {СТЕК!!! Сначала у, потом х} 
  fld x 
  fpatan 
 end; 
</pre>

<p>вывод ответа: </p>
<pre>
s:=angl(0,1)*180/pi; {Т.к возвращается угол в радианах} 
writeln(s:0:0); 
</pre>

<div class="author">Автор: Bink (Новиков Виктор) </div>

