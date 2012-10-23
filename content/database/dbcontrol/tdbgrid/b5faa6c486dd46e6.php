<h1>Как заблокировать функцию вставки записи в компоненте TDBGrid?</h1>
<div class="date">01.01.2007</div>


<p>Не могли бы вы подсказать, как заблокировать функцию вставки записи непосредственно в компоненте TDBGrid с сохранением всех остальных возможностей редактирования таблицы.</p>

<p>Наиболее разумным представляется создать обработчик события OnBeforeInsert компонента TTable, TQuery или TClientDataSet, данные из которых отображаются в TDBGrid. Сам компонент TDBGrid не имеет подходящего события для обработки, так как это компонент, предназначенный только для создания пользовательского интерфейса, а в данном случае следует, по существу, запретить добавление записей в таблицу.</p>

<p>Наталия Елманова</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


