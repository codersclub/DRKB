<h1>Как перевести монитор в режим standby?</h1>
<div class="date">01.01.2007</div>

Если монитор поддерживает режим Stand by, то его можно программно перевести в этот режим. Данная возможность доступна на Windows95 и выше.</p>
<p>Чтобы перевести монитор в режим Stand by:</p>
<pre>
SendMessage(Application.Handle, wm_SysCommand, SC_MonitorPower, 0);
</pre>
<p>Чтобы вывести его из этого режима:</p>
<pre>
SendMessage(Application.Handle, wm_SysCommand, SC_MonitorPower, -1);
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
