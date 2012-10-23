<h1>Физическое удаление записей в локальных таблицах (BDE)</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Наталия Елманова</div>

<p>При удалении записей из таблицы dBase с помощью компонента TTable они просто приобретают признак удаления, и я никак не могу добиться их физического удаления. Как быть?</p>

<p>Ваша проблема решается просто - для физического удаления записей нужно использовать функцию DbiPackTable (ее описание есть в справочном файле BDE).</p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


<p class="note">Примечание Vit: точно так же удаляются записи и у таблиц других локальных баз данных</p>

<hr />

<div class="author">Автор: Epsylon Technologies</div>

<p>В BDE есть функция DbiPackTable.</p>

<p>Упаковать таблицу DBF можно открыв ее компонентом TTable и вызвав функцию BDE DbiPackTable. Для этого нужно добавить к модулю, где вызывается функция, имена DBITypes, DBIProcs, DBIErrs в оператор uses.</p>
<p>Затем вызвать в нужном месте функцию:</p>

<p>Result := DbiPackTable(Table1.DbHandle, Table1.Handle, nil, szDBase, True);</p>
<p>Copyright © 1996 Epsylon Technologies</p>
<p>Взято из FAQ Epsylon Technologies (095)-913-5608; (095)-913-2934; (095)-535-5349</p>
