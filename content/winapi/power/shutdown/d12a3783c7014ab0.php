<h1>Как программно вазвать окно Завершение работы Windows?</h1>
<div class="date">01.01.2007</div>


<pre>
SendMessage (FindWindow ('Progman', 'Program Manager'), WM_CLOSE, 0, 0);
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
