<h1>Число цветов (цветовая палитра) у данного компьютера</h1>
<div class="date">01.01.2007</div>


<p>Эта функция возвращает число бит на точку у данного компьютера. Так, например, 8 - 256 цветов, 4 - 16 цветов ...</p>

<pre>
function GetDisplayColors : integer;
var tHDC  : hdc;
begin
 tHDC:=GetDC(0);
 result:=GetDeviceCaps(tHDC, 12)* GetDeviceCaps(tHDC, 14);
 ReleaseDC(0, tHDC);
end;
</pre>


<p>Зайцев О.В.</p>
<p>Владимиров А.М.</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<hr />
<pre>
1 shl GetDeviceCaps( Canvas.Handle, BITSPIXEL );
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
