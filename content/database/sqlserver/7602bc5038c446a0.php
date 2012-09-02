<h1>Пример вызова хранимой процедуры c передачей переменной</h1>
<div class="date">01.01.2007</div>


<pre>
Declare @MyVariable varchar(50)
 
Set @MyVariable='dir'
 
Exec master..xp_cmdshell @MyVariable
</pre>

<p class="author">Автор: Vit</p>

