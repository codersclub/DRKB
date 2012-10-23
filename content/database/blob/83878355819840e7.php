<h1>Как записать файл в BLOB-поле?</h1>
<div class="date">01.01.2007</div>


<p>1) Через таблицу:</p>

<pre>
(table1.fieldbyname('ddd') as TBlobField).loadfromfile('dddss');
</pre>

<p>(Для некоторых баз данных через BDE так можно загрузить не более 64k)</p>
<p>2) через параметры в запросе...</p>

<pre>
ADOquery1.sql.text:='Insert into myTable (a) Values (:b)';
ADOQuery1.parameters.parseSQL(ADOquery1.sql.text, true);
ADOQuery1.parameters.parambyname('b').LoadFromFile('MyFile');
ADOQuery1.execsql; 
</pre>

<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
