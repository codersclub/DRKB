<h1>Выделить подстроку (@result) после подстроки (@substr) в строке (@str)</h1>
<div class="date">01.01.2007</div>


<pre>
  declare @i int
  declare @result varchar(4000)
  Set @substr=Replace(@substr, '%', '[%]')
  Set @substr=Replace(@substr, '_', '[_]')
  Set @i=Patindex('%'+@substr+'%',  @str)
  if @i&gt;0 
    Set @Result=right(@str,len(@str)-@i)
  else 
    Set @Result=@str
  Return @Result
</pre>

<div class="author">Автор: Vit</div>

