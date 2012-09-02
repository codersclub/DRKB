<h1>Как в TDBGrid pазpешить только опеpации UPDATE записей?</h1>
<div class="date">01.01.2007</div>


<p>А я делаю так. На DataSource, к которому прицеплен Grid, вешаю обработчик на событие OnStateChange. Ниже текст типичного обратчика</p>
<pre>
if DBGrid1.DataSource.DataSet.State in [dsEdit, dsInsert] then
  DBGrid1.Options := DBGrid1.Options + goRowSelect
else
  DBGrid1.Options := DBGrid1.Options - goRowSelect;
</pre>

<p>Дело в том, что если у Grid'а стоит опция goRowSelect, то из Grid'а невозможно добавить запись. Ну а когда програмно вызываешь редактирование или вставку, то курсор принимает обычный вид и все Ok. </p>

<p>Лучше использовать конструкцию "State in dsEditModes" </p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
