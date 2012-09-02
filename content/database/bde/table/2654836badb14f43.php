<h1>Как узнать версию таблицы</h1>
<div class="date">01.01.2007</div>


<pre>
function GetTableVersion(Table: TTable): Longint;
var
  hCursor: hDBICur;
  DT:      TBLFullDesc;
begin
  Check(DbiOpenTableList(Table.DBHandle, True, False,
    PChar(Table.TableName), hCursor));
  Check(DbiGetNextRecord(hCursor, dbiNOLOCK, @DT, nil));
  Result := DT.tblExt.iRestrVersion;
  Check(DbiCloseCursor(hCursor));
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
