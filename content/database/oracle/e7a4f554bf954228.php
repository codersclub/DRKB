<h1>Как заставить ORACLE анализировать все таблицы?</h1>
<div class="date">01.01.2007</div>


<p>Конечно, можно использовать dbms_sql, dbms_job... <br>
 <br>
А можно и так: <br>
<p></p>
<pre>#!/bin/sh
#
# analyze all tables
#
 
sqlfile=/tmp/analyze.sql
logfile=/tmp/analyze.log
 
echo @connect dbo/passwd@ &gt; $sqlfile
 
$oracle_home/bin/svrmgrl &lt;&gt; $sqlfile
connect dbo/passwd
select 'table', table_name from all_tables where owner = 'dbo';
eof
 
echo exit &gt;&gt; $sqlfile
cat $sqlfile &gt; $logfile
 
cat $sqlfile | $oracle_home/bin/svrmgrl &gt;&gt; $logfile
 
cat $logfile | /usr/bin/mailx -s 'analyze tables' tlk@nbd.kis.ru
 
rm $sqlfile
rm $logfile
</pre>
 <br>
<p>Источник: <a href="https://www.codenet.ru" target="_blank">https://www.codenet.ru</a></p>
