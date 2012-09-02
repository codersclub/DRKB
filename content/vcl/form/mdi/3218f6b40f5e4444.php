<h1>Сколько открыто дочерних окон?</h1>
<div class="date">01.01.2007</div>



<pre>
Form1.MDIChildCount
</pre>


<p>Закрыть все окна:</p>
<pre>
with Form1 do  
  For i := MDIChildCount-1 DownTo 0 Do
      if Assigned(MDIChildren[i]) then
      begin
        MDIChildren[i].Close;
      end;
</pre>


<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
<p>Исправлено Bose</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

