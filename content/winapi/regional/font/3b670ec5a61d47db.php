<h1>Какой шрифт установлен (крупный или мелкий)?</h1>
<div class="date">01.01.2007</div>


<pre>
function SmallFonts: Boolean;
{Значение функции TRUE если мелкий шрифт}
var
  DC: HDC;
begin
  DC := GetDC(0);
  Result := (GetDeviceCaps(DC, LOGPIXELSX) = 96);
  { В случае крупного шрифта будет 120}
  ReleaseDC(0, DC);
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
