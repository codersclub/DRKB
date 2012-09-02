<h1>Функция вычисления суммы полей</h1>
<div class="date">01.01.2007</div>


<pre>
function SumField(const fieldName: OpenString): longint;
var
  fld: TField;
  bm: TBookmark; // закладка
begin
  result := 0;
  tbl.DisableControls; // выключаем рекцию на перемещение по набору данных
  bm := tbl.GetBookmark; // сохраняем позицию
  fld := tbl.FieldByName(fieldName);
  tbl.first;
  while not tbl.eof do
  begin
    result := result + fld.AsInteger;
    tbl.next;
  end;
  tbl.GotoBookmark(bm); // позиционируем обратно
  tbl.EnableControls; // включаем реакцию на перемещение по набору данных
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

<p class="note">Примечание Vit</p>
<p>данный способ один из худших, а точнее самый худший из всех возможных и мог бы служить пособием того как делать не следует (собственно для этого я его здесь и привёл). На больших таблицах, особенно на серверных базах данных выполнение этого кода будет исключительно медленное. Намного выгоднее выполнение SQL запроса вида:</p>
<pre>
Select Sum(MyField) From MyTable
</pre>


<p>И в коде чтение первого поля первой записи:</p>
<pre>
Function Form1.GetRecordSum(TableName:string):integer;

begin //на форме должен стоять компонент Query1 подсоединённый к нужной базе данных (код будет работать для любых разновидностей TQuery, TADOQuery и т.д.)
  Query1.active:=false;
  Query1.sql.text:='Select Sum(MyField) From '+TableName;
  Query1.active:=true;
  Result:=Query1.fields[0].asInteger;
  Query1.active:=false;
end;
</pre>


<p>при этом все другие открытые TTable/TQuery и т.п. на этой таблице могут продолжать оставаться открытыми.</p>
