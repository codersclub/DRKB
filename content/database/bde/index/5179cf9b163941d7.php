<h1>Индекс БД в другом каталоге</h1>
<div class="date">01.01.2007</div>


<p>Подскажите как работать c dbf под Delphi 5 , когда индексы расположены в другом каталоге?</p>

<p>Serg</p>
<p>(10.01.01 19:54) можно сделать следующее:</p>

<pre>
Vnhead_Cdx := TStringList.Create;
Vnhead_Cdx.Add('c:\parus\bumi1\idx\vnhead.cdx');
Vnhead.IndexFiles := Vnhead_Cdx;
</pre>

<p>при это сам dbf находится в c:\parus\bumi1\dbf</p>

<p>Взято с сайта <a href="https://blackman.wp-club.net/" target="_blank">https://blackman.wp-club.net/</a></p>

