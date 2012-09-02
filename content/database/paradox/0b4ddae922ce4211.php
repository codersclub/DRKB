<h1>Как назначить пароль на таблицу?</h1>
<div class="date">01.01.2007</div>


<pre>
uses Unit2;
// ..
TablePasswort(Table1, 'secret');
 
unit Unit2;
 
interface
 
uses
  BDE, SysUtils, DBTables, Windows;
 
function TablePasswort(var table: TTable; password: string): Boolean;
 
implementation
 
function StrToOem(const AnsiStr: string): string;
begin
  SetLength(result, Length(AnsiStr));
  if Length(result) &gt; 0 then
    CharToOem(PChar(AnsiStr), PChar(result))
end;
 
function TablePasswort(var table: ttable; password: string): Boolean;
var
  pTblDesc: pCRTblDesc;
  hDb: hDBIDb;
begin
  result := false;
  with table do
  begin
    if Active and (not Exclusive) then
      Close;
    if (not Exclusive) then
      Exclusive := true;
    if (not Active) then
      Open;
    hDb := DBHandle;
    Close
  end;
  GetMem(pTblDesc, sizeof(CRTblDesc));
  FillChar(pTblDesc^, sizeof(CRTblDesc), 0);
  with pTblDesc^ do
  begin
    StrPCopy(szTblName, StrToOem(table.tablename));
    szTblType := szParadox;
    StrPCopy(szPassword, StrToOem(password));
    bPack := true;
    bProtected := true
  end;
  if DbiDoRestructure(hDb, 1, pTblDesc, nil, nil, nil, false) &lt;&gt; DBIERR_NONE then
    exit;
  if pTblDesc &lt;&gt; nil then
    FreeMem(pTblDesc, sizeof(CRTblDesc));
  result := true
end;
 
end.
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
