<h1>Delphi 4 виснут при запуске. Видеокарта S3 Virge?</h1>
<div class="date">01.01.2007</div>


<pre>
REGEDIT4
[HKEY_CURRENT_CONFIG\Display\Settings]
"BusThrottle"="on"
</pre>
<p>Если не помогает, то попробуйте добавить в system.ini:</p>

[Display]
"BusThrottle"="On"

<p>Эта проблема устранена в Delphi 4sp3.</p>

<p>Взято с сайта <a href="https://blackman.wp-club.net/" target="_blank">https://blackman.wp-club.net/</a></p>

<hr />

<p>Надо уменьшить степень аппаратного ускорения графики в свойствах компьютера</p>

<p class="author">Автор: Vit</p>

