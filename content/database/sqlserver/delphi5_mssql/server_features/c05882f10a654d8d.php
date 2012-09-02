<h1>INSERT, UPDATE и DELETE</h1>
<div class="date">01.01.2007</div>


<p><b>INSERT</b></p>
<p>В дополнение к стандартным возможностям, MS SQL Server позволяет вставить в таблицу набор данных, полученный в результате выполнения хранимой процедуры, при помощи синтаксиса:</p>
<pre>
INSERT author_sales EXECUTE get_author_sales
</pre>

<p><b>UPDATE и DELETE</b></p>
<p>Сервер поддерживает расширенный синтаксис</p>

<pre>
UPDATE MyTable 
  SET Name = 'Иванов'
 FROM MyTable T INNER JOIN AnotherTable A ON T.Id = A.MyTableId
  AND A.SomeField = 20
</pre>

