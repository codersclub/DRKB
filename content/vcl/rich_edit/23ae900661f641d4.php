<h1>Как прокрутить TRichEdit в конец?</h1>
<div class="date">01.01.2007</div>


<p>Существует множество способов, включая и:</p>

<pre>    with MainFrm.RichEdit1 do 
    begin 
      perform (WM_VSCROLL, SB_BOTTOM, 0); 
      perform (WM_VSCROLL, SB_PAGEUP, 0); 
    end; 
</pre>

<p>Вышеприведенный пример работает отлично в 9x и NT4, но не работает в Windows 2000. Поэтому предлагаю воспользоваться следующим примером:</p>
<pre>
    with MainFrm.RichEdit1 do 
    begin 
      SelStart := Length(Text); 
      Perform(EM_SCROLLCARET, 0, 0); 
    end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

