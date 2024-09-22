---
Title: Как создать shortcut-файл (.lnk)?
Author: Vit
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---

Как создать shortcut-файл (.lnk)?
=================================

    uses ShlObj, ActiveX, ComObj;
    ...
     
    procedure CreateShortCut(ShortCutName, Parameters, FileName: string);
    var ShellObject: IUnknown;
      ShellLink: IShellLink;
      PersistFile: IPersistFile;
      FName: WideString;
    begin
      ShellObject := CreateComObject(CLSID_ShellLink);
      ShellLink := ShellObject as IShellLink;
      PersistFile := ShellObject as IPersistFile;
      with ShellLink do
        begin
          SetArguments(PChar(Parameters));
          SetPath(PChar(FileName));
          SetWorkingDirectory(PChar(extractfilepath(FileName)));
          FName := ShortCutName;
          PersistFile.Save(PWChar(FName), False);
        end;
    end;

