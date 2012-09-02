<h1>Функция для быстрого копирования таблиц вместе со всеми дополнительными файлами</h1>
<div class="date">01.01.2007</div>


<pre>
// Только для не SQL-ых, т.е не промышленных БД (dBase, Paradox ..)
// Путь нужно задавать только АНГЛИЙСКИМИ буквами
procedure QuickCopyTable(T: TTable; DestTblName: string; Overwrite: boolean);
var
  DBType: DBIName;
  WasOpen: boolean;
  NumCopied: word;
begin
  WasOpen := T.Active;
  if not WasOpen then
    T.Open;
  Check(DbiGetProp(hDBIObj(T.Handle),drvDRIVERTYPE, @DBType,SizeOf(DBINAME), NumCopied));
  Check(DbiCopyTable(T.DBHandle, Overwrite, PChar(T.TableName),DBType, PChar(DestTblName)));
  T.Active := WasOpen;
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
