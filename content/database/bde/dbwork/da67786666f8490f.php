<h1>Как перейти к указанной записи в БД</h1>
<div class="date">01.01.2007</div>


<pre>
function TBDEDirect.GoToRecord(RecNo: LongInt): Boolean;
var
  RecCount: LongInt;
  Bookmark: TBookmark;
  Res: DBIResult;
begin
  Result := False;
  if CheckDatabase then
  begin
    if RecNo &lt; 1 then
      RecNo := 1;
    RecCount := GetRecordCount;
    if RecNo &gt; RecCount then
      RecNo := RecCount;
    Res := DbiSetToRecordNo(FDataLink.DataSource.DataSet.Handle, RecNo);
    if Res = 0 then
    begin
      Bookmark := StrAlloc(GetBookmarkSize);
      DbiGetBookmark(FDataLink.DataSource.DataSet.Handle, Bookmark);
      FDataLink.DataSource.DataSet.GoToBookmark(Bookmark);
      FDataLink.DataSource.DataSet.FreeBookmark(Bookmark);
      Result := True;
    end
    else
      Check(Res);
  end;
end;
</pre>


<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
