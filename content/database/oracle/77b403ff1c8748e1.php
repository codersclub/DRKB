<h1>Как на Oracle поменять compatible?</h1>
<div class="date">01.01.2007</div>


<p>Подскажите, как на Oracle 7.3.2.3 (Solaris x86) поменять compatible на 7.3.2.3 (c 7.1.0.0)?</p>
<p>Ставить в initmybase.ora</p>

<p>compatible = "7.3.2.3"</p>

<p>и после старта с новым параметром сделать</p>

<pre>ALTER DATABASE RESET COMPABILITY;
</pre>


<p>И рестартовать базу.</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
