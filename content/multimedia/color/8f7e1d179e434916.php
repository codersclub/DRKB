<h1>Как можно узнать количество цветов текущего режима?</h1>
<div class="date">01.01.2007</div>


<p>GetDeviceCaps(Form1.Canvas.Handle, BITSPIXEL) *</p>
<p>GetDeviceCaps(Form1.Canvas.Handle, PLANES)</p>

<p>Для получения общего количества битов, используемых для получения цвета используются следующие значения.</p>

<p>1 = 2 colors bpp</p>
<p>4 = 16 colors bpp</p>
<p>8 = 256 colors bpp</p>
<p>15 = 32768 colors (возвращает 16 на большинстве драйверов) bpp</p>
<p>16 = 65535 colors bpp</p>
<p>24 = 16,777,216 colors bpp</p>
<p>32 = 16,777,216 colors (то же, что и 24) bpp</p>

<p>Вы можете использовать:</p>

<p>NumberOfColors := (1 shl</p>
<p>(GetDeviceCaps(Form1.Canvas.Handle, BITSPIXEL) *</p>
<p>GetDeviceCaps(Form1.Canvas.Handle, PLANES));</p>

<p>для подсчета общего количества используемых цветов. </p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
