<h1>Как узнать размеры шрифтов в Windows?</h1>
<div class="date">01.01.2007</div>


<p>GetTextMetrics()</p>
<div class="author">Автор: Song</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>Как определить, какой шрифт установлен в системе, большой или маленький</p>
<p>Следующуя функция возвращает true, если маленькие шрифты установлены в системе. Так же можно заменить строку 'Result := (GetDeviceCaps(DC, logpixelsx) = 96);' на 'Result := (GetDeviceCaps(DC, logpixelsx) = 120);' чтобы определять - установлены ли в системе крупные шрифты.</p>
<pre>
Function UsesSmallFonts: boolean; 
var 
DC: HDC; 
begin 
DC := GetDC(0); 
Result := (GetDeviceCaps(DC, logpixelsx) = 96); 
ReleaseDC(0, DC); 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
