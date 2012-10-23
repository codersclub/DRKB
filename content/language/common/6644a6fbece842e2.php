<h1>Удобная функция ifthen</h1>
<div class="date">01.01.2007</div>


<p>В Делфи 6 (модуль Math) появилась удобная функция ifthen которая соответствует оператору "?" языка С++.</p>
<p>Пример:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var k, i, j: Integer;
begin
  i := 3; j := 2;
  k := ifthen({If}i &lt; j, {Then}i, {Else}k);
End;
</pre>
<div class="author">Автор: feriman</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
