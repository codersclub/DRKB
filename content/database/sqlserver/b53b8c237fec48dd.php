<h1>Получить список индексов таблицы</h1>
<div class="date">01.01.2007</div>


<pre>
SELECT i.name AS index_name
FROM sysobjects o 
INNER JOIN sysindexes i ON o.id = i.id
WHERE o.xtype = 'U' AND i.indid &gt; 0 AND 
      i.indid &lt; 255 AND INDEXPROPERTY(i.id, i.name, 'isStatistics') = 0  AND 
      o.name = @TableName
ORDER BY i.indid
</pre>

<div class="author">Автор: Vit</div>

