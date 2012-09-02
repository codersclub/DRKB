<h1>Выполнение SQL, заданного строкой</h1>
<div class="date">01.01.2007</div>


<pre>
Declare @sql varchar(8000)

Set @sql='Select * From MyTable'
Exec (@sql)
</pre>

<p class="author">Автор: Vit</p>

