<h1>Как получить серийный номер тома жесткого диска?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  VolumeName,
  FileSystemName : array [0..MAX_PATH-1] of Char;
  VolumeSerialNo : DWord;
  MaxComponentLength,
  FileSystemFlags : Integer;
begin
  GetVolumeInformation('C:\',VolumeName,MAX_PATH,@VolumeSerialNo,
  MaxComponentLength,FileSystemFlags,
  FileSystemName,MAX_PATH);
  Memo1.Lines.Add('VName = '+VolumeName);
  Memo1.Lines.Add('SerialNo = $'+IntToHex(VolumeSerialNo,8));
  Memo1.Lines.Add('CompLen = '+IntToStr(MaxComponentLength));
  Memo1.Lines.Add('Flags = $'+IntToHex(FileSystemFlags,4));
  Memo1.Lines.Add('FSName = '+FileSystemName);
end; 
</pre>

