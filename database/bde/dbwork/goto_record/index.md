---
Title: Как перейти к указанной записи в БД
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как перейти к указанной записи в БД
===================================

    function TBDEDirect.GoToRecord(RecNo: LongInt): Boolean;
    var
      RecCount: LongInt;
      Bookmark: TBookmark;
      Res: DBIResult;
    begin
      Result := False;
      if CheckDatabase then
      begin
        if RecNo < 1 then
          RecNo := 1;
        RecCount := GetRecordCount;
        if RecNo > RecCount then
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

