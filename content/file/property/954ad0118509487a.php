<h1>Как выяснить дату последнего доступа к файлу?</h1>
<div class="date">01.01.2007</div>

Данная процедура, позволяет узнать дату последнего доступа к файлу, код не проверял, но говорят работает. Для тех кто не знает что с этим делать намекну, можно использовать для создания триального реиода или просто отслеживания доступа к компьютеру.</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  FileHandle: THandle;
  LocalFileTime: TFileTime;
  DosFileTime: DWORD;
  LastAccessedTime: TDateTime;
  FindData: TWin32FindData;
begin
  FileHandle := FindFirstFile('AnyFile.FIL', FindData);
  if FileHandle &lt;&gt; INVALID_HANDLE_VALUE then
  begin
    Windows.FindClose(Handle);
    if (FindData.dwFileAttributes and FILE_ATTRIBUTE_DIRECTORY) = 0 then
    begin
      FileTimeToLocalFileTime(FindData.ftLastWriteTime, LocalFileTime);
      FileTimeToDosDateTime(LocalFileTime,
        LongRec(DosFileTime).Hi, LongRec(DosFileTime).Lo);
      LastAccessedTime := FileDateToDateTime(DosFileTime);
      Label1.Caption := DateTimeToStr(LastAccessedTime);
    end;
  end;
end;
 
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
