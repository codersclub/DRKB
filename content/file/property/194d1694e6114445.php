<h1>Как получить тип файла?</h1>
<div class="date">01.01.2007</div>


<pre>
uses
  ShellAPI;
 
function MrsGetFileType(const strFilename: string): string;
var
  FileInfo: TSHFileInfo;
begin
  FillChar(FileInfo, SizeOf(FileInfo), #0);
  SHGetFileInfo(PChar(strFilename), 0, FileInfo, SizeOf(FileInfo), SHGFI_TYPENAME);
  Result := FileInfo.szTypeName;
end;
 
 
// Beispiel:
// Example:
procedure TForm1.Button1Click(Sender: TObject);
begin
  ShowMessage('File type is: ' + MrsGetFileType('c:\autoexec.bat'));
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
