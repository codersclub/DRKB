<h1>Преодоление барьера в 8000 символов в динамическом SQL</h1>
<div class="date">01.01.2007</div>


<pre>
Declare @sql1 varchar(8000), @sql2 varchar(8000)
Set @sql1='Select * From MyTable'
Set @sql2='Where MyField=''Something'''
 
Exec (@sql1+@sql2)
</pre>

<div class="author">Автор: Vit</div>

