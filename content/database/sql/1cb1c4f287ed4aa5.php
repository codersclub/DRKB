<h1>Интерактивные SQL-запросы</h1>
<div class="date">01.01.2007</div>


<p>Как мне передать значение переменной в SQL-запросе? К примеру, в обработчике onClick клавиши вывести все записи с величиной поля большей, чем задал пользователь. Можно ли в Delphi создать что-либо подобное механизму запросов, реализованному в Paradox for Windows? </p>

<p>Решение этой задачи в Delphi подобно созданию и выполнению строки запроса SQL в Paradox. </p>

<p>Pdoxwin код: </p>
<pre>method pushButton(var eventInfo Event)
var
s  string
q  query
d  database
endvar

d.open( "MYALIAS" )
s = "select * from mytable where somefield=\"" + entryField.value + "\""
q.readFromString( s )
q.executeSQL( d )

endmethod
</pre>

<p>Delphi код: </p>

<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
  MyQuery.Active := false;
  MyQuery.SQL.clear;
  MyQuery.SQL.add('select * from mytable where somefield="' +
    EntryField.Text + '"');
  MyQuery.Active := true;
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
