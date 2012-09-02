<h1>Как проверить, находится ли файл на локальном диске?</h1>
<div class="date">01.01.2007</div>


<pre>
function IsOnLocalDrive(aFileName: string): Boolean; 
var 
  aDrive: string; 
begin 
  aDrive := ExtractFileDrive(aFileName); 
  if (GetDriveType(PChar(aDrive)) = DRIVE_REMOVABLE) or 
     (GetDriveType(PChar(aDrive)) = DRIVE_FIXED) then 
    Result := True 
  else 
    Result := False; 
end; 
 
 
// Example, Beispiel: 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  if OpenDialog1.Execute then 
    if IsOnLocalDrive(OpenDialog1.FileName) then 
      ShowMessage(OpenDialog1.FileName + ' is on a local drive.'); 
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
