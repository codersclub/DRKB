<h1>Как по имени Базы Данных получить ссылку на компоненет TDataBase?</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Max Rezanov</div>

<pre>
var
db : TDataBase;
begin
 
db := Session.FindDatabase(FDataBaseName);
db.StartTransaction;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

