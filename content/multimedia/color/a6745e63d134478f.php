<h1>TColor &gt; HTML Color</h1>
<div class="date">01.01.2007</div>

<p>Функция для преобразования цвета TColor в формат цветов HTML</p>
<pre>function TColorToHTML(const Value: TColor): string;
var
  RGBColor: Longint;
begin
  RGBColor := ColorToRGB(Value);
  Result := Format('#%.2x%.2x%.2x', [GetRValue(RGBColor), GetGValue(RGBColor), GetBValue(RGBColor)]);
end;
</pre>
<p>&nbsp;<br>
<p>Не нужно забывать о</p>
<pre>uses SysUtils, Graphics;
</pre>
<p>&nbsp;<br>
для функций Format и ColorToRGB! <br>
<p>&nbsp;</p>
<div class="author">Автор: Smike</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

