<h1>Как конвертировать RGB в TColor?</h1>
<div class="date">01.01.2007</div>


<pre>
function RGBToColor(R,G,B:Byte): TColor; 
begin 
       Result:=B Shl 16 Or
       G Shl 8 Or
       R;
end; 
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<hr />RGB -&gt; TColor</p>

<p>RGB(r,g,b:byte):tcolor</p>

<p>TColor -&gt; RGB</p>

<p>GetRValue(color:tcolor)</p>
<p>GetGValue(color:tcolor)</p>
<p>GetBValue(color:tcolor) </p>

<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

