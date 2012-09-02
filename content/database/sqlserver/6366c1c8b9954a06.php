<h1>Узнать путь к прилинкованной файловой базе данных</h1>
<div class="date">01.01.2007</div>


<pre>
Select @FileName=Datasource From master..sysservers
Where srvname=@LinkedServerName
</pre>

<p class="author">Автор: Vit</p>

