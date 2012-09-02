<h1>Послать Alt+буква другому приложению</h1>
<div class="date">01.01.2007</div>


<p>Как мне программно нажать ALT + буква(VK_...) в другом приложении. Хендл я нашел, деляю так</p>
<p>  SendMessage(Handle_, WM_KEYDOWN, VK_MENU,0);</p>
<p>  SendMessage(Handle_, WM_KEYDOWN, VK_F1,0);</p>
<p>  SendMessage(Handle_, WM_KEYUP, VK_F1,0);</p>
<p>но у меня не получается, что не так? </p>
<p>Попробуй так</p>
<pre>
SendMessage(Handle,WM_KEYDOWN,Byte(C),$20000001);
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
