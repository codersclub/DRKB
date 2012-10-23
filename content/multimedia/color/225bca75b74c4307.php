<h1>Как получить hex-значение данного цвета?</h1>
<div class="date">01.01.2007</div>


<p>GetRValue, GetGValue, GetBValue - дадут тебе байты цветов, затем тебе надо их перевести в hex...</p>
<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>IntToHex(Color);</p>
<div class="author">Автор: neutrino</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>В модуле graphics имеются две недокументированные функции:</p>
<p>function ColorToString(Color: TColor): string;</p>
<p>Если значение TColor является именованным цветом, функция возвращает имя цвета ("clRed"). В противном случае возвращается шестнадцатиричное значение цвета в виде строки.</p>
<p>function StringToColor(S: string): TColor;</p>
<p>Данная функция преобразует "clRed" или "$0000FF" во внутреннее значение цвета.</p>
<div class="author">Автор: Pegas</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

