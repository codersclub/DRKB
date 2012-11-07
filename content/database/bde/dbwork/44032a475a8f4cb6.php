<h1>Как узнать путь базы данных и её имя?</h1>
<div class="date">01.01.2007</div>


<p>Делается это при помощи dbiGetDatabaseDesc:</p>

<pre class="delphi">
uses BDE;
.....
 
procedure ShowDatabaseDesc(DBName: string);
const
  DescStr = 'Driver Name: %s'#13#10'AliasName: %s'#13#10 +
    'Text: %s'#13#10'Physical Name/Path: %s';
var
  dbDes: DBDesc;
begin
  dbiGetDatabaseDesc(PChar(DBName), @dbDes);
  with dbDes do
    ShowMessage(Format(DescStr, [szDbType, szName, szText, szPhyName]));
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

