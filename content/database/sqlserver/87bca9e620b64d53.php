<h1>Возведение в степень для больших чисел</h1>
<div class="date">01.01.2007</div>


<p>Стандартные функции T-SQL не поддерживают возведение в степень если результат не вмещается в тип int, несмотря на то что сам T-SQL вполне поддерживает большие числа (bigint)</p>

<pre>
@Base bigint, @Exp int
 
...
 
  Declare 
    @Result bigint,
    @j int
  set @j=0
  Set @Result=1
  while @j&lt;@Exp
    begin
      Set @Result=@Result*@Base
      set @j=@j+1
     end
  Return @Result
</pre>
<div class="author">Автор: Vit</div>

