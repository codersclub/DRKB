<h1>Как получить текущую дату?</h1>
<div class="date">01.01.2007</div>



<pre>
// make the SQL dependent on type of DBMS
 
if AppLibrary.Database.DriverName = 'ORACLE' then
  SQL.Add('and entry_date &lt; SYSDATE')
else
  SQL.Add('and entry_date &lt; "TODAY"');
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
