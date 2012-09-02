<h1>Получить установленный по умолчанию Screen Saver</h1>
<div class="date">01.01.2007</div>


<pre>
uses
   Inifiles, ShellApi;
 
 procedure TForm1.Button1Click(Sender: TObject);
 var
   Ini: TInifile;
   ScreenSaverFile: string;
 
      function GetLongFileName(const FileName: string): string;
   var
     aInfo: TSHFileInfo;
   begin
     if SHGetFileInfo(PChar(FileName), 0, aInfo, SizeOf(aInfo), SHGFI_DISPLAYNAME) &lt;&gt; 0 then
       Result := string(aInfo.szDisplayName)
     else
       Result := FileName;
   end;
 
      begin
   Ini := TInifile.Create('system.ini');
   ScreenSaverFile := GetLongFileName(Ini.Readstring('boot', 'SCRNSAVE.EXE', 'Not Available'));
   Ini.Free;
   label1.Caption := ScreenSaverFile;
 end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
