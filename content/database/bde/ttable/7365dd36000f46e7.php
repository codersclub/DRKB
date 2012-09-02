<h1>Как показать удаленные записи</h1>
<div class="date">01.01.2007</div>


<pre>
procedure DeletedRecords(Table: TTable; SioNo: Boolean);
begin
  Table.DisableControls;
  try
    Check(DbiSetProp(hDBIObj(Table.Handle), curSOFTDELETEON, Longint(SioNo)));
  finally
    Table.EnableControls;
  end;
  Table.Refresh;
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
