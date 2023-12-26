---
Title: Как зарегистрировать свое расширение?
Author: Vit
Date: 01.01.2007
---

Как зарегистрировать свое расширение?
=====================================

::: {.date}
01.01.2007
:::

    Uses Registry;

     
    procedure RegisterFileType(FileType,FileTypeName, Description,ExecCommand:string);
    begin
    if (FileType='') or (FileTypeName='') or (ExecCommand='') then exit;
    if FileType[1]<>'.' then FileType:='.'+FileType;
    if Description='' then Description:=FileTypeName;
    with Treginifile.create do
    try
    rootkey := hkey_classes_root;
    writestring(FileType,'',FileTypeName);
    writestring(FileTypeName,'',Description);
    writestring(FileTypeName+'\shell\open\command','',ExecCommand+' "%1"');
    finally
    free;
    end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
    RegisterFileType('txt','TxtFile', 'Plain text','notepad.exe');
    end;

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>
