<h1>Запущен ли сервер удаленного доступа (RAS)</h1>
<div class="date">01.01.2007</div>


<p>Запущен ли сервер удаленного доступа (RAS)</p>
<pre>function checkras: boolean;
const maxentries = 100;
var
bufsize : integer;
numentries: integer;
entries : array[1..maxentries] of trasconn;
begin
entries[1].dwsize := sizeof(trasconn);
bufsize:=sizeof(trasconn)*maxentries;
fillchar(stat, sizeof(trasconnstatus), 0);
rasenumconnections(@entries[1], bufsize, numentries);
if numentries &gt; 0 then result:=true 
else result:=false;
end;
</pre>
&nbsp;<br>
<p>Источник: vlata.com</p>
