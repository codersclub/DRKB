<h1>Как определить цвет произвольной точки экрана?</h1>
<div class="date">01.01.2007</div>


<pre><p>var</p>
DC: HDC;
Color: Cardinal;
begin
DC := CreateDC ('MONITOR', nil, nil, nil);
Color := GetPixel(DC, 300, 300);
DeleteDC(DC);
end;
</pre>
<p class="author">Автор: Baa</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<pre>
var
DC: HDC;
Color: Cardinal;
begin
DC :=GetDC(0);
Color := GetPixel(DC, 300, 300);
ReleaseDC(0,DC);
end;
</pre>

<p class="author">Автор: Mikel</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

