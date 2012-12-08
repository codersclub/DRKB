---
Title: Как создать shortcut-файл (.lnk)?
Author: Vit
Date: 01.01.2007
---

Как создать shortcut-файл (.lnk)?
=================================

::: {.date}
01.01.2007
:::

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

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>
