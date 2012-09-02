<h1>Пример вызова динамического SQL с возвращаемой переменной</h1>
<div class="date">01.01.2007</div>


<pre>
Declare @sql nvarchar(4000)
Declare @ParmDefinition nvarchar(4000) 
 
Set @ParmDefinition = N'@InParameter varchar(9), @Count int output'
Set @Sql=N'Select @count=count(*) From MyTable with (nolock)'
Set @Sql=@Sql+N'WHERE MyField = @InParameter'
 
Exec sp_executesql @sql, @ParmDefinition, @count=@result output, @InParameter=@MyInParam
 
Select @result
</pre>

<p class="note">Примечание</p>
<p>Заменить nvarchar на varchar нельзя!</p>
<p class="author">Автор: Vit</p>
