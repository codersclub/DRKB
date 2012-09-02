<h1>Как получить версию моей DLL?</h1>
<div class="date">01.01.2007</div>



<pre>
procedure GetFileVersion(FileName: string; var Major1, Major2, 
    Minor1, Minor2: Integer); 
  var 
    Info: Pointer; 
    InfoSize: DWORD; 
    FileInfo: PVSFixedFileInfo; 
    FileInfoSize: DWORD; 
    Tmp: DWORD; 
  begin 
    InfoSize := GetFileVersionInfoSize(PChar(FileName), Tmp); 
    if InfoSize = 0 then 
      //Файл не содержит информации о версии
    else 
    begin     
      GetMem(Info, InfoSize); 
      try 
        GetFileVersionInfo(PChar(FileName), 0, InfoSize, Info); 
        VerQueryValue(Info, '\', Pointer(FileInfo), FileInfoSize); 
        Major1 := FileInfo.dwFileVersionMS shr 16; 
        Major2 := FileInfo.dwFileVersionMS and $FFFF; 
        Minor1 := FileInfo.dwFileVersionLS shr 16; 
        Minor2 := FileInfo.dwFileVersionLS and $FFFF; 
      finally 
        FreeMem(Info, FileInfoSize); 
      end; 
    end; 
  end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

