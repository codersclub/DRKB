<h1>Как предотвратить Data Corruption (повреждение данных)?</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
{
  If a database or a table is local on a PC installed (Paradox or Dbase)
  and the BDE-setting "LOCAL SHARE" is FALSE, then changings are not
  stored immediatly but are kept in the memory.
  This changings are gone after a chrash.
  So it might be better after changing to store the data physically on the disk:
}
 
 
uses
  BDE;
 
procedure TForm1.Table1AfterPost(DataSet: TDataSet);
begin
  DbiSaveChanges(Table1.Handle);
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
