<h1>Как временно отключить перерисовку окна?</h1>
<div class="date">01.01.2007</div>

<p>Вызовите функцию WinAPI LockWindowUpdate передав ей дескриптор окна, которое необходимо не обновлять. Передайте ноль в качестве параметра для восстановления нормального обновления.</p>
<pre>
LockWindowUpdate(Memo1.Handle); 
... 
 
LockWindowUpdate(0); 
</pre>

