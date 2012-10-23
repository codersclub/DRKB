<h1>Пронумеровать строки в результате запроса</h1>
<div class="date">01.01.2007</div>


<p>Придётся сделать Inner Join на самого себя....</p>
<pre>
select count(*) as ID,  c1.sys_id
from MyTable c1 
Inner join MyTable c2 on c1.Sys_id &gt;= c2.sys_id
group by c1.sys_id
order by id
</pre>
<div class="author">Автор: Vit</div>
