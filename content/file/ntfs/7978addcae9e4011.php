<h1>Как определить, является ли диск NTFS?</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  ComObj; 
 
function IsNTFS(AFileName: string): Boolean; 
var 
  fso, drv: OleVariant; 
begin 
  IsNTFS := False; 
  fso := CreateOleObject('Scripting.FileSystemObject'); 
  drv := fso.GetDrive(fso.GetDriveName(AFileName)); 
  IsNTFS := drv.FileSystem = 'NTFS' 
end; 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  if IsNTFS('X:\Temp\File.doc') then 
    ShowMessage('File is on NTFS File System') 
  else 
    ShowMessage('File is not on NTFS File System') 
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
