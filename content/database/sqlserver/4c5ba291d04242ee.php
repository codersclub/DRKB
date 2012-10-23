<h1>Вставить сразу несколько строк в таблицу одним запросом</h1>
<div class="date">01.01.2007</div>


<pre>
Insert into MyTable
  (Field1, Field2, Field3)
Select Value1, Value2, Value3
Union All
Select Value4, Value5, Value6
...
</pre>

<div class="author">Автор: Vit</div>

