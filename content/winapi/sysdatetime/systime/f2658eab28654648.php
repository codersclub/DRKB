<h1>Как открыть окно настройки даты и времени Windows?</h1>
<div class="date">01.01.2007</div>


<pre>
Shellexecute(handle, 'Open', 'Rundll32.exe', 'shell32.dll,Control_RunDLL TIMEDATE.CPL', Pchar(Getsystemdir), 0); 
</pre>

<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

