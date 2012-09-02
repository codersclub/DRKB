<h1>Информация о логических дисках</h1>
<div class="date">01.01.2007</div>


<p>Теперь об информации о дисках: </p>
<p>исчерпывающую информацию по этому поводу дает функция GetVolumeInformation,</p>
<p>посмотри help, там все понятно (там и серийный номер диска, и тип файловой системы, и прочее и прочее).</p>
<p>Вот параметры FileSysFlags:</p>
<p>FS_CASE_IS_PRESERVED - (при записи на диск сохраняется регистр букв в его имени)</p>
<p>FS_CASE_SENSITIVE - (поддерживается поиск файлов с учетом регистра букв)</p>
<p>FS_UNICODE_STORED_ON_DISK - (поддерживается сохранение имен файлов в UniCode)</p>
<p>FS_PERSISTENT_ACLS - (поддерживаются списки контроля доступа (ACL). Только для NTFS)</p>
<p>FS_FILE_COMPRESSION - (поддерживается сжатие файлов на уровне системы)</p>
<p>FS_VOL_IS_COMPRESSED - (устройство представляет собой сжатый диск)</p>
<p>Определение типа диска:</p>
<pre>
function GetDriveType (Drive : byte) : string;
  var
    DriveLetter : Char;
    DriveType : uInt;
begin
DriveLetter := Char (Drive + $41);
DriveType := GetDriveType (PChar(DriveLetter + ':\'));
case DriveType of
0: Result := '?';
1: Result := 'Path does not exists';
Drive_Removable: Result := 'Removable';
Drive_Fixed: Result := 'Fixed';
Drive_Remote: Result := 'Remote';
Drive_CDROM: Result := 'CD-ROM';
Drive_RamDisk: Result := 'RAMDisk'
else Result := 'Unknown';
end;
end;
</pre>

<p>Может так попробовать:</p>
<pre>
procedure TMainForm.btnGetHandleClick(Sender: TObject);
var DriveHandle : HWND;
begin
case Win32Platform of
  VER_PLATFORM_WIN32_NT:
    begin
      DriveHandle := CreateFile ('\\.\Scsi0:', GENERIC_READ+GENERIC_WRITE,
                                FILE_SHARE_READ+FILE_SHARE_WRITE, nil, 
                                OPEN_EXISTING, 0, 0);
      if DriveHandle &lt;&gt; INVALID_HANDLE_VALUE then
        MessageBox (MainForm.Handle, PChar(IntToStr(DriveHandle)),
                   PChar('Here is your handle:'), MB_ICONINFORMATION)
      else
         MessageBox (MainForm.Handle, PChar('Error!'), PChar('Error'), 
                     MB_ICONERROR);
    end;
  VER_PLATFORM_WIN32_WINDOWS:
begin
  DriveHandle := CreateFile ('\\.\SMARTVSD', 0, 0, nil, CREATE_NEW, 0, 0 );
  if DriveHandle &lt;&gt; INVALID_HANDLE_VALUE then
    MessageBox (MainForm.Handle, PChar(IntToStr(DriveHandle)), 
                PChar('Here is your handle:'), MB_ICONINFORMATION)
  else
    MessageBox (MainForm.Handle, PChar('Error!'), PChar('Error'), MB_ICONERROR);
end;
end; // case
end
</pre>
<p>;</p>
<p class="author">Автор Serious </p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
