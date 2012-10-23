<h1>Как програмно имитировать нажатие Ctrl-Esc?</h1>
<div class="date">01.01.2007</div>


<pre>
SendMessage(Handle,WM_SYSCOMMAND,SC_TASKLIST,0); 
</pre>
<div class="author">Автор: TwoK</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
