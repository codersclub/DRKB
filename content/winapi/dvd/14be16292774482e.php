<h1>Как узнать, есть ли в заданном CD-ROM'е Audio CD?</h1>
<div class="date">01.01.2007</div>



<p>Можно использовать функцию Windows API GetDriveType() чтобы определить является ли дисковод CD-ROM'мом. И функцию API GetVolumeInformation() чтобы проверить VolumeName на равенство 'Audio CD'.</p>
<p>Пример:</p>
<pre>
function IsAudioCD(Drive : char) : bool;
var
        DrivePath : string;
        MaximumComponentLength : DWORD;
        FileSystemFlags : DWORD;
        VolumeName : string;
Begin
        sult := false;
        DrivePath := Drive + ':\';
        if GetDriveType(PChar(DrivePath)) &lt;&gt; DRIVE_CDROM then 
                exit;
        SetLength(VolumeName, 64);
        GetVolumeInformation(PChar(DrivePath),PChar(VolumeName),
        Length(VolumeName),nil,MaximumComponentLength,FileSystemFlags,nil,0);
        if lStrCmp(PChar(VolumeName),'Audio CD') = 0 then
                result := true;
end;
 
function PlayAudioCD(Drive : char) : bool;
var
        mp : TMediaPlayer;
begin
        result := false;
        Application.ProcessMessages;
        if not IsAudioCD(Drive) then
                exit;
        mp := TMediaPlayer.Create(nil);
        mp.Visible := false;
        mp.Parent := Application.MainForm;
        mp.Shareable := true;
        mp.DeviceType := dtCDAudio;
        mp.FileName := Drive + ':';
        mp.Shareable := true;
        mp.Open;
        Application.ProcessMessages;
        mp.Play;
        Application.ProcessMessages;
        mp.Close;
        Application.ProcessMessages;
        mp.free;
        result := true;
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
        if not PlayAudioCD('D') then
                ShowMessage('Not an Audio CD');
end;
</pre>

<p>Взято из</p>
DELPHI VCL FAQ Перевод с английского &nbsp; &nbsp; &nbsp; 
<p>Подборку, перевод и адаптацию материала подготовил Aziz(JINX)</p>
<p>специально для <a href="https://delphi.vitpc.com/" target="_blank">Королевства Дельфи</a></p>


