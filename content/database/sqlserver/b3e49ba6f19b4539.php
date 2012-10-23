<h1>Оптимизация хранимых процедур</h1>
<div class="date">01.01.2007</div>


<p>1. Используйте практику добавления SET NOCOUNT ON в каждую процедуру, это позволит сэкономить время их выполнения и трафик, так как применение директивы указывает процедуре не подсчитывать количество строк которое затронула каждая операция.</p>
<p>Пример:</p>
<pre>
Create Procedure MyStoredProcedure
  @Parameter1 varchar(50),
  @Parameter2 int,
  @OutputParameter varchar(100) output
As
Begin
  Set nocount ON
  Set @Parameter1=isNull(@Parameter1, '')
  Set @OutputParameter=@Parameter1+cast(@Parameter2 as varchar(10))
  Set nocount OFF
  Return 0
End
</pre>

<div class="author">Автор: Vit</div>

