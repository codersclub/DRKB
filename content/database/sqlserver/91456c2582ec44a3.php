<h1>Получить размеры таблиц</h1>
<div class="date">01.01.2007</div>


<p>Если в таблицах есть ключи, то работает такой код:</p>
<pre>
  Select SubString(o.name, 1, 30) as Table_Name,
         i.[rows] as Number_of_Rows
  From sysobjects o
  Left Outer Join sysindexes i on o.id = i.id
  Where o.xtype = 'u' and i.indid &lt; 2
  Order by o.name
</pre>

<p class="author">Автор: Vit</p>

