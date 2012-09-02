<h1>Как паковать таблицу?</h1>
<div class="date">01.01.2007</div>


<pre>
function dgPackParadoxTable(Tbl: TTable; Db: TDatabase): DBIResult;
{Packs a Paradox table by calling the BDE DbiDoRestructure function. The TTable passed as the first parameter must be closed. The TDatabase passed as the second parameter must be connected.}
var
  TblDesc: CRTblDesc;
begin
  Result := DBIERR_NA;
  FillChar(TblDesc, SizeOf(CRTblDesc), 0);
  StrPCopy(TblDesc.szTblName, Tbl.TableName);
  TblDesc.bPack := True;
  Result := DbiDoRestructure(Db.Handle, 1, @TblDesc, nil, nil, nil, False);
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
<hr />
<pre>
uses
  DbiProcs;
 
with Table do
begin
  OldState := Active;
  Close;
  Exclusive := True;
  Open;
 
  DbiPackTable(DBHandle, Handle, nil, nil, True);
  {^ здесь можно добавить check()}
 
  Close;
  Exclusive := False;
  Active := OldState;
  { при желании можно сохранить закладку }
end;
</pre>


<p>Nomadic</p><p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

