<h1>Local SQL и временная таблица</h1>
<div class="date">01.01.2007</div>


<p>Local SQL не поддерживает вложенные запросы, но после того как я заработал клок седых волос, я нашел в высшей степени простое решение: использование временной таблицы. </p>

<p>Пример: </p>

<pre>
with GeneralQuery do
begin
  SQL.Clear;
  SQL.Add(.... внутренний SQL);
  SQL.Open;
  DbiMakePermanent(handle, 'temp.db',true);
  SQL.Clear;
  SQL.Add(SELECT  ... FROM 'temp.db'....);
  SQL.Open;
end;
</pre>

<p>Единственное: необходимо убедиться в том, что имя таблицы не вступает в конфликт с именами нескольких работающих копий таблицы. И, разумеется, данная технология не даст "живой" набор!</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
