<h1>Как можно из своей программы закрыть чужую?</h1>
<div class="date">01.01.2007</div>


<pre>
PostThreadMessage(AnotherProg_MainThreadID,WM_CLOSE,0,0);
PostMessage(AnotherProg_MainWindow,WM_CLOSE,0,0);
</pre>

<p class="author">Автор: Fantasist</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr /><p><a href="https://delphi.mastak.ru/download/255.zip " target="_blank">https://delphi.mastak.ru/download/255.zip </a></p>
<p class="author">Автор ответа: LENIN INC</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
