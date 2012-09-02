<h1>Как получить цвет строки в HTML формате?</h1>
<div class="date">01.01.2007</div>


<p>Если Вам необходимо создать HTML-файл, то необходимо объявить тэг для цвета шрифта либо цвета фона. Однако просто вставить значение TColor не получится - необходимо преобразовать цвет в формат RGB. В своём наборе SMExport я использую следующую функцию:</p>
<pre>
function GetHTMLColor(cl: TColor; IsBackColor: Boolean): string; 
var rgbColor: TColorRef; 
begin 
  if IsBackColor then 
    Result := 'bg' 
  else 
    Result := ''; 
  rgbColor := ColorToRGB(cl); 
  Result := Result + 'color="#' + 
            Format('%.2x%.2x%.2x', 
                   [GetRValue(rgbColor), 
                    GetGValue(rgbColor), 
                    GetBValue(rgbColor)]) + '"'; 
end; 
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
