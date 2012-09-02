<h1>Создание таблицы</h1>
<div class="date">01.01.2007</div>


<pre>
uses DB, DBTables, StdCtrls;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  tSource, TDest: TTable;
begin
  TSource := TTable.create(self);
  with TSource do
  begin
    DatabaseName := 'dbdemos';
    TableName := 'customer.db';
    open;
  end;
  TDest := TTable.create(self);
  with TDest do
  begin
    DatabaseName := 'dbdemos';
    TableName := 'MyNewTbl.db';
    FieldDefs.Assign(TSource.FieldDefs);
    IndexDefs.Assign(TSource.IndexDefs);
    CreateTable;
  end;
  TSource.close;
end;
</pre>

<hr />
<pre>
// Создание DBF-файла во время работы приложения
 
...
const
  CreateTab = 'CREATE TABLE ';
  IDXTab = 'PRIMARY KEY ';
  MyTabStruct =
    'IDX_TAB DECIMAL(6,0), ' +
    'DATE_ DATE, ' +
    'FLD_1 CHARACTER(20), ' +
    'FLD_2 DECIMAL(7,2), ' +
    'FLD_3 BOOLEAN, ' +
    'FLD_4 BLOB(1,1), ' +
    'FLD_5 BLOB(1,2), ' +
    'FLD_6 BLOB(1,3), ' +
    'FLD_7 BLOB(1,4), ' +
    'FLD_8 BLOB(1,5) ';
  ...
 
  // создание таблицы без индекса
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  if CreateTable('"MYTAB.DBF"', MyTabStruct, '') then
    ...
      // выполняем дальнейшие операции
  else
    ...
end;
 
// создание таблицы с индексом
 
procedure TForm1.Button2Click(Sender: TObject);
begin
  if CreateTable('"MYTAB.DBF"', MyTabStruct, IDXTab + ' (IDX_TAB)') then
    ...
      // выполняем дальнейшие операции
  else
    ...
end;
 
function TForm1.CreateTable(TabName, TabStruct, TabIDX: string): boolean;
var
  qyTable: TQuery;
begin
  result := true;
  qyTable := TQuery.Create(Self);
  with qyTable do
  try
    try
      SQL.Clear;
      SQL.Add(CreateTab + TabName + '(' + TabStruct + TabIDX + ')');
      Prepare;
      // ExecSQL, а не Open. Иначе ... облом
      ExecSQL;
    except
      // Обработка ошибок открытия таблицы Возможности обработчика можно расширить.
      Exception.Create('Ошибка открытия таблицы');
      result := false;
    end;
  finally
    Close;
  end;
end;
</pre>

<hr />
<pre>
sql := 'CREATE TABLE "employee.db" ( '+
       'Last_Name CHAR(20),'+
       'First_Name CHAR(15),'+ 
       'Salary NUMERIC(10,2),'+
       'Dept_No SMALLINT,'+ 
       'PRIMARY KEY (Last_Name, First_Name))';
Query1.sql.text:=sql;
Query1.ExecSQL;
</pre>


<p class="note">Примечание Vit</p>
<p>этот способ наиболее предпочтительный, так как наиболее стандартный. Кроме того он будет работать практически неизменно на любых базах данных при использовании любого способа доступа, а не только BDE.</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
