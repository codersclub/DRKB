<h1>Смешиваем два цвета</h1>
<div class="date">01.01.2007</div>


<p>Самый простой способ смешать два цвета c1 и c2, это вычислить средние значения rgb-значений. Данный пример не отличается особой быстротой, поэтому если Вам нужно быстро смешивать цвета, то прийдётся пошевелить мозгами...</p>
<pre>
function GetMixColor (c1, c2: TColor): TColor;
begin
  // вычисляем средние значения Красного, Синего и Зелёного значений
  // цветов c1 и c2:
  Result := RGB (
                  (GetRValue (c1) + GetRValue (c2)) div 2,
                  (GetGValue (c1) + GetGValue (c2)) div 2,
                  (GetBValue (c1) + GetBValue (c2)) div 2
                );
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

