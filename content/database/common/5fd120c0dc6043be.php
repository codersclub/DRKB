<h1>Быстрое копирование таблиц</h1>
<div class="date">01.01.2007</div>


<p>Из книги Стива Тейксейра и Пачеко 'Delphi 4. Руководство разработчика'</p>
<p>я взял функцию для быстрого копирования</p>
<p>таблиц вместе со всеми дополнительными файлами:</p>
<p>Вот она:</p>
<pre>
procedure QuickCopyTable(T: TTable;DestTblName:string;Overwrite: boolean);
// только для не SQL-ых, т.е не промышленных  БД (dBase, Paradox ..)
var DBType: DBIName;
   WasOpen:boolean;
   NumCopied:word;
begin
 WasOpen:=T.Active;
 if not WasOpen then T.Open;
 Check(DbiGetProp(hDBIObj(T.Handle),drvDRIVERTYPE,@DBType,SizeOf(DBINAME),
    NumCopied));
 Check(DbiCopyTable(T.DBHandle, Overwrite, PChar(T.TableName),DBType, PChar(DestTblName)));
 T.Active:=WasOpen;
end;
</pre>


<p>Взято с сайта <a href="https://blackman.wp-club.net/" target="_blank">https://blackman.wp-club.net/</a></p>
