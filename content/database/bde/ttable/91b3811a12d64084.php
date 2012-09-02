<h1>Как результат TQuery сделать в виде постоянной таблицы?</h1>
<div class="date">01.01.2007</div>



<p>Traditionally, to write the results of a query to disk, you use a TBatchMove and a TTable in addition to your query. But you can short-circuit this process by making a couple of simple, direct calls to the BDE.</p>

<p>Make sure you have BDE declared in your uses section</p>
<pre>
procedure MakePermTable(Qry: TQuery; PermTableName: string);
var
  h: HDBICur;
  ph: PHDBICur;
begin
  Qry.Prepare;
  Check(dbiQExec(Qry.StmtHandle, ph));
  h := ph^;
  Check(DbiMakePermanent(h, PChar(PermTableName), True));
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
