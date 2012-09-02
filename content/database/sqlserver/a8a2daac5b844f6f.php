<h1>Проверка на ошибки исполнения конструкции SQL</h1>
<div class="date">01.01.2007</div>


<p>Сразу после выполнения инструкции можно проверить на наличие ошибок при её выполнении путём проверки глобальной переменной @@error:</p>
<pre>
Insert into MyTable
Values (10)
 
if @@error &lt;&gt; 0 
  Print 'Record was not inserted' 
</pre>

<p class="author">Автор: Vit</p>

