---
Title: Как сравнить Bookmarks в таблице?
Date: 01.01.2007
---


Как сравнить Bookmarks в таблице?
=================================

::: {.date}
01.01.2007
:::

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

Взято с <https://delphiworld.narod.ru>
