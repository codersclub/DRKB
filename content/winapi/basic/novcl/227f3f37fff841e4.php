<h1>Запретить в выбранном окне кнопку закрытия x</h1>
<div class="date">01.01.2007</div>


<pre>
 
EnableMenuItem(GetSystemMenu(FindWindow(Nil, Pchar('Название Окна')),False)
  ,SC_CLOSE,MF_BYCOMMAND or MF_GRAYED);
</pre>
<p class="author">Автор: Radmin</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
