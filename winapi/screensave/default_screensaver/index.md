---
Title: Получить установленный по умолчанию Screen Saver
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---

Получить установленный по умолчанию Screen Saver
================================================

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
         if SHGetFileInfo(PChar(FileName), 0, aInfo, SizeOf(aInfo), SHGFI_DISPLAYNAME) <> 0 then
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

