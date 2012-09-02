<h1>Как сравнить Bookmarks в таблице?</h1>
<div class="date">01.01.2007</div>


<pre>
function TBDEDirect.CompareBookmarks(Bookmark1,
  Bookmark2: TBookmark): Boolean;
 
var
  Res: DBIResult;
  CompareRes: Word;
 
begin
  Result := False;
  if CheckDatabase then
    begin
      Res := DbiCompareBookmarks(FDataLink.DataSource.DataSet.Handle,
        Bookmark1, Bookmark2, CompareRes);
      if Res = 0 then
        if CompareRes = 0 then
          Result := True
        else
      else
        Check(Res);
    end;
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

