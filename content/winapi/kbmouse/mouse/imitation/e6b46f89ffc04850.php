<h1>Как имитировать нажатие левой кнопки мыши?</h1>
<div class="date">01.01.2007</div>


<pre>
mouse_event(MOUSEEVENTF_LEFTDOWN,0,0,0,0);
Application.ProcessMessages;
mouse_event(MOUSEEVENTF_LEFTUP,0,0,0,0); 
</pre>
<p class="author">Автор: Song, Spawn</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
