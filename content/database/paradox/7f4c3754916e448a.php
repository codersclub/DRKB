<h1>Как добавить пароль к таблице</h1>
<div class="date">01.01.2007</div>


<pre>
uses
  Bde, SysUtils, dbtables, windows;
 
 
function StrToOem(const AnsiStr: string): string;
begin
  SetLength(Result, Length(AnsiStr));
  if Length(Result)  0 then
    CharToOem(PChar(AnsiStr), PChar(Result));
end;
 
function TablePasswort(var Table: TTable; password: string): Boolean;
var
  pTblDesc: pCRTblDesc;
  hDb: hDBIDb;
begin
  Result := False;
  with Table do
  begin
    if Active and (not Exclusive) then Close;
    if (not Exclusive) then Exclusive := True;
    if (not Active) then Open;
    hDB := DBHandle;
    Close;
  end;
  GetMem(pTblDesc, SizeOf(CRTblDesc));
  FillChar(pTblDesc^, SizeOf(CRTblDesc), 0);
  with pTblDesc^ do
  begin
    StrPCopy(szTblName, StrToOem(Table.TableName));
    szTblType := szParadox;
    StrPCopy(szPassword, StrToOem(Password));
    bPack      := True;
    bProtected := True;
  end;
  if DbiDoRestructure(hDb, 1, pTblDesc, nil, nil, nil, False) DBIERR_NONE then Exit;
  if pTblDesc  nil then FreeMem(pTblDesc, SizeOf(CRTblDesc));
  Result := True;
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
