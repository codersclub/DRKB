<h1>Удалить dbase index flag</h1>
<div class="date">01.01.2007</div>


<pre>
Function UnCheckIndex(FileDbf: string): Boolean;
var
  Dbf: file;
  Car: Char;
begin
  Result := T;
  AssignFile(Dbf, FileDbf);
  Car := #0;
  {$I-}
  Reset(Dbf, 1);
  if not ErrorIO(FileDbf, IoResult) then 
  begin
    Seek(Dbf, 28);
    {Flag's position}
    if not ErrorIO(FileDbf, IoResult) then
      BlockWrite(Dbf, Car, 1, Num_R)
    else
      Result := F;
    CloseFile(Dbf);
    if ErrorIO(FileDbf, IoResult) then
      Result := F;
  end
  else
    Result := F;
  {$I+}
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  if UnCheckIndex('MyBase.dbf') then
    ShowMessage('Flag removed');
end;
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
