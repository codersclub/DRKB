<h1>Проверить, существует ли индекс</h1>
<div class="date">01.01.2007</div>


<pre>
  if exists(
    SELECT *
    FROM sysobjects o 
    INNER JOIN sysindexes i 
      ON o.id = i.id
    WHERE o.xtype = 'U' AND 
          i.indid &gt; 0 AND 
          i.indid &lt; 255 AND 
          INDEXPROPERTY(i.id, @IndexName, 'isStatistics') = 0 AND 
          o.name = @TableName)
    Set @exists=1
  else
    Set @exists=0 
</pre>

<p class="author">Автор: Vit</p>

