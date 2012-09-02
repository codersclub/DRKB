<h1>Как зыкрыть Excel</h1>
<div class="date">01.01.2007</div>


<pre>
try
  Ex1.Workbooks.Close(LOCALE_USER_DEFAULT);
  Ex1.Disconnect;
  Ex1.Quit;
  Ex1:=nil;
 except
 end;
</pre>
<p class="author">Автор Akella</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
