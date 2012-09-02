<h1>Блокируется таблица в MS SQL Server</h1>
<div class="date">01.01.2007</div>


<p>По умолчанию, оператор UPDATE в MS SQL Server пытается поставить эксклюзивную табличную блокировку. Вы можете обойти это, используя ключевое слово FROM в сочетании с опцией PAGLOCK для использования MS SQL Server страничных блокировок вместо эксклюзивной табличной блокировки:</p>
<pre>
UPDATE orders 
SET customer_id=NULL 
FROM orders(PAGLOCK) 
WHERE customer_id=32;
</pre>


<p>Блокиpовка на всю таблицу пpи UPDATE ставится только в том случае, если по пpедикату нет индекса. Так, можно пpосто пpоиндексиpовать таблицу orders по полю customer_id, и не забывать делать UPDATE STATISTIC, хотя будет работать и с PAGLOCK. Просто не факт, что UPDATE всегда делает табличную блокировку. </p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
