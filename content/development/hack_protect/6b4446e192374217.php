<h1>Как определить, запущена ли Delphi?</h1>
<div class="date">01.01.2007</div>


<p>Иногда, особенно при создании компонент, бывает необходимо получить доступ к компоненту только когда запущена Delphi IDE.</p>

<pre>
If FindWindow('TAppBuilder',nil) &lt;= 0 then 
  ShowMessage('Delphi is not running !') 
else 
  ShowWindow('Delphi is running !'); 
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

