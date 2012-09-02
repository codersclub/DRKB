<h1>Прилинковать MS Excel книгу как удаленный сервер</h1>
<div class="date">01.01.2007</div>


<pre>
Exec sp_addlinkedserver @LinkedServerName, 'Jet 4.0', 'Microsoft.Jet.OLEDB.4.0', @DatabaseName, NULL, 'Excel 8.0'
Exec sp_addlinkedsrvlogin @LinkedServerName, 'false'
</pre>

<p class="author">Автор: Vit</p>

