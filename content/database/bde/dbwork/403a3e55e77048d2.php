<h1>Определение типа базы данных</h1>
<div class="date">01.01.2007</div>


<pre>
{uses должен включать в себя db, dbitypes, dbiprocs }
 
procedure TForm1.FormCreate(Sender: TObject);
var
 
  rDB: DBDesc;
begin
 
{ Первый аргумент DbiGetDatabaseDesc - имя псевдонима базы данных
типа PChar }
  Check(DbiGetDatabaseDesc('IBLOCAL', @rDB));
{ член szDbType структуры DBDesc содержит информацию о типе
базы данных и имеет тип PChar }
  ShowMessage('Database имеет тип: ' + StrPas(rDB.szDbType));
 
{ Совет: Если вам просто необходимо узнать -
SQL server это или нет, используйте свойсто TDatabase
IsSQLBased }
end;
</pre>

<p>OAmiry/Borland </p>
<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

