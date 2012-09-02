<h1>Поиск по мемо-полям</h1>
<div class="date">01.01.2007</div>


<p>В MS SQL Server 2000 включена специальная версия MS Index Server, которая позволяет построить по текстовым (включая BLOB) полям полнотекстовый индекс и расширения SQL, позволяющие строить запросы по этому индексу, например:</p>

<pre>
SELECT ProductName
  FROM Products
 WHERE CONTAINS(ProductName, 'spread NEAR Boysenberry')
</pre>


<p>Тенцер А. Л.</p>
<p>ICQ UIN 15925834</p>
<p>tolik@katren.nsk.ru</p>
