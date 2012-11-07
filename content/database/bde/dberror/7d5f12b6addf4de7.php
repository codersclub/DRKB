<h1>Multiple records found, but only one was expected</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Nomadic</div>

<p>При выполнении некоторых живых запросов, возвращающих единственную запись, BDE ругается 'multiple records found, but only one was expected'.</p>
<p>Запросы вида</p>

<pre class="sql">
SELECT c, b, a, q FROM T WHERE b = :b
</pre>

<p>где ключ c, но BDE посчитала ключом a. Интересный запрос, да? Такое впечатление, что, поскольку ключом в исходной таблице являлась третья колонка, то Дельфы посчитали ключом третью колонку.</p>

<p>Перестановкой SELECT a, b, c, q... все исправилось. Я решил теперь использовать в таких (live) запросах только SELECT *.</p>
