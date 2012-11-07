<h1>Удалить временную таблицу по имени</h1>
<div class="date">01.01.2007</div>


<p>Причём не выдавать ошибку если такой таблицы нет.</p>
<pre>
  Execute('if exists 
          (select * from tempdb..sysobjects 
           where id = OBJECT_ID(''tempdb..'+@TableName+''')) drop table '+@TableName)
</pre>


<div class="author">Автор: Vit</div>
<p></p>
