<h1>Пример вызова хранимой процедуры с указанием переменных</h1>
<div class="date">01.01.2007</div>


<pre>
Declare @MyVariable1 varchar(50), @MyVariable2 varchar(50)
 
Select @MyVariable1='dir', @MyVariable2='test'
 
Exec MyStroredProcedure
  @StroredProcedureVariable1=@MyVariable1,
  @StroredProcedureVariable2=@MyVariable2
</pre>

<div class="author">Автор: Vit</div>

