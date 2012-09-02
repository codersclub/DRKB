<h1>Самый быстрый способ узнать количество записей в таблице</h1>
<div class="date">01.01.2007</div>



<p>When using the standard dataset.recordcount in my client-server (win nt against sqlserver7 db, targettable has 500.000 records) i can go for lunch and stil be waiting (:-</p>

<p>Answer:</p>

<p>For those of you who don't know why u should not use the standard dataset.recordcount when developing client server database applications. </p>
<p>This article is especialy for those cs db apps against a sqlserver 7 db. </p>

<p>since the standard dataset.recordcount iterates from begin of the table through the end of the table to result in the recordcount. This is a crime when developing cs db apps (against sqlserver7). </p>

<p>simply use another way of obtaining the number of records. I use a sql for obtaining the number of records in a sqlserver table. </p>

<p>drop a tquery on the form </p>

<p>provide this tquery with the follow SQL: </p>

<p>SQL: </p>

<pre>
select distinct max(itbl.rows) 
from sysindexes as itbl 
inner join sysobjects as otbl on (itbl.id = otbl.id) 
where (otbl.type = 'U') and (otbl.name = :parTableName) 
</pre>

<p>notice the parameter: parTableName type string </p>

<p>use this tquery to find out how many rows in the table </p>

<p>TIP: try to make your own tYourSqlServerCountQuery and thus override the recordcount property. </p>
<p>ByTheWay: use this only for sqlserver </p>

<p>for other cs db apps simply use a count sql (coming upnext time...) </p>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
