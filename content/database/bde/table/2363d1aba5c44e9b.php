<h1>Как копировать и удалять таблицы?</h1>
<div class="date">01.01.2007</div>



<p>Here is an example of a routine that I use for copying and deleting tables. It uses DB, DBTables, DbiProcs,DbiErrs, and DbiTypes.</p>

<p>You simply provide the directory to copy from, the source table name, the directory to copy to, and the destination table name, and the BDE will copy the entire table, indexes and all to the new file.</p>

<p>The delete function takes the path to delete from and the name of the table to delete, the BDE takes care of deleting all associated files (indexes, etc.).</p>

<p>These procedures have been pulled off a form of mine, and I've edited them to remove some dependencies that existed with that form. They should now be completely stand-alone.</p>

<pre>
procedure TConvertForm.CopyTable(FromDir, SrcTblName, ToDir, DestTblName: string);
var
  DBHandle: HDBIDB;
  ResultCode: DBIResult;
  Src, Dest, Err: array[0..255] of Char;
  SrcTbl, DestTbl: TTable;
begin
  SrcTbl := TTable.Create(Application);
  DestTbl := TTable.Create(Application);
  try
    SrcTbl.DatabaseName := FromDir;
    SrcTbl.TableName := SrcTblName;
    SrcTbl.Open;
    DBHandle := SrcTbl.DBHandle;
    SrcTbl.Close;
    ResultCode := DbiCopyTable(DBHandle, false,
      StrPCopy(Src, FromDir + '\' + SrcTblName), nil,
      StrPCopy(Dest, ToDir + '\' + DestTblName));
    if ResultCode &lt;&gt; DBIERR_NONE then
    begin
      DbiGetErrorString(ResultCode, Err);
      raise EDatabaseError.Create('While copying ' +
        FromDir + '\' + SrcTblName + ' to ' +
        ToDir + '\' + DestTblName + ', the '
        + ' database engine   generated the error '''
        + StrPas(Err) + '''');
    end;
  finally
    SrcTbl.Free;
    DestTbl.Free;
  end;
end;
 
procedure TConvertForm.DeleteTable(Dir, TblName: string);
var
  DBHandle: HDBIDB;
  ResultCode: DBIResult;
  tbl, Err: array[0..255] of Char;
  SrcTbl, DestTbl: TTable;
begin
  SrcTbl := TTable.Create(Application);
  try
    SrcTbl.DatabaseName := Dir;
    SrcTbl.TableName := TblName;
    SrcTbl.Open;
    DBHandle := SrcTbl.DBHandle;
    SrcTbl.Close;
    ResultCode := DbiDeleteTable(DBHandle,
      StrPCopy(Tbl, Dir + '\' + TblName), nil);
    if ResultCode &lt;&gt; DBIERR_NONE then
    begin
      DbiGetErrorString(ResultCode, Err);
      raise EDatabaseError.Create('While deleting ' +
        Dir + '\' + TblName + ', the database ' +
        'engine generated the error ''' + StrPas(Err) + '''');
    end;
  finally
    SrcTbl.Free;
  end;
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
