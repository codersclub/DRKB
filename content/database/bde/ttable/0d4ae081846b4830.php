<h1>Быстрый доступ к нужной записи в таблице Paradox</h1>
<div class="date">01.01.2007</div>


<p class="author">Автор: Valler&nbsp; ( http://www.valler.narod.ru )</p>

<pre>
var NeedNumber: Integer;
 
...
NeedNumber := Table.RecNo;
{сохранение номера нужной записи}
...
{код меняющий номе записи}
...
Table.RecNo := NeedNumber;
{востановление номера нужной записи}
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<p>Примечания Vit:</p>
<p>1) Следует категорически избегать подобных решений в приложениях "Клиент-Сервер"</p>
<p>2) Если есть многопользовательский доступ, то эта конструкция может работать неправильно</p>

