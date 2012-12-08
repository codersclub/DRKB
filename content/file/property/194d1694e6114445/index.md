---
Title: Как получить тип файла?
Date: 01.01.2007
---


Как получить тип файла?
=======================

::: {.date}
01.01.2007
:::

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

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
