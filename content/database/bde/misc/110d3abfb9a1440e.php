<h1>Правила для SetRange</h1>
<div class="date">01.01.2007</div>


<p>Я, похоже, обнаружил неплохое решение ранжирования данных - вам необходимо только установить различные начальный и конечный диапазоны последнего поля, определенного вашим индексом, после чего введенное в любое поле индекса значение будет проигнорировано. Также вы не сможете покинуть ранжируемое поле, если редактируемая запись пуста.</p>

<p>Попытаюсь изложить все попроще... Скажем, у меня есть индекс Field1; Field2; Field3, затем;</p>

<pre>
SetRangeStart;
Table1Field1.Value := x1;
Table1Field2.Value := y1;
Table1Field3.Value := z1;
SetRangeEnd;
Table1Field1.Value := x2;
Table1Field2.Value := y2;
Table1Field3.Value := z2;
ApplyRange;
</pre>

<p>Правила...</p>

<p>x1 должен равняться x2, если y или z определен</p>
<p>y1 должен равняться y2, если z определен</p>
<p>x должен быть определен, если y или z определены</p>
<p>y должен быть определен, если x определен</p>
<p>если x1 = x2 и никаких других критериев не определено, тогда y1 и y2 должны быть соответственно min/max значениями y</p>
<p>если x1 = x2 и y1 = y2 и никаких других критериев не определено, тогда z1 и z2 должны быть соответственно min/max значениями z</p>
<p>Я не знаю, поняли вы это или нет, но надеюсь это поможет...</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
