<h1>Пример вызова хранимой процедуры с возвращаемой переменной</h1>
<div class="date">01.01.2007</div>


<pre>
Declare @MyInVariable varchar(50) --переменная для ввода данных 
Declare @MyOutVariable varchar(50) --переменная для вывода данных 
 
Set @MyVariable='dir'
 
Exec MyStoredProcedure 
  @InternalInVar=@MyInVariable, 
  @InternalOutVar=@MyOutVariable output
 
Select @MyOutVariable
</pre>

<p>Обратите внимание что переменные для вывода данных всегда "присваиваются"</p>
<p>внутренним переменным при вызове, хотя логика работы как раз обратная - при выполнении процедуры значению внешней переменной @MyOutVariable присваивается значение внутренней (внутрипроцедурной) переменной @InternalOutVar.</p>
<p class="author">Автор: Vit</p>

