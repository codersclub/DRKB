<h1>Каким драйвером пользуется TDatabase?</h1>
<div class="date">01.01.2007</div>


<p>Вы можете использовать вызов IDAPI dbiGetDatabaseDesc. Вот быстрая справка (не забудьте добавить DB в список используемых модулей):</p>
<pre>
var
  pDatabase: DBDrsc:
begin
  { pAlias - PChar, содержащий имя псевдонима }
  dbiGetDatabaseDesc ( pAlias, @pDatabase ) ;
</pre>


<p>Для получения дополнительной информации обратитесь к описанию свойства pDatabase.szDbType.</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
