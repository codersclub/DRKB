---
Title: Как программно создать ярлык?
Author: Gavrilo
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Как программно создать ярлык?
=============================

    uses ShlObj, ComObj, ActiveX;
     
    procedure CreateLink(const PathObj, PathLink, Desc, Param: string);
    var
      IObject: IUnknown;
      SLink: IShellLink;
      PFile: IPersistFile;
    begin
      IObject := CreateComObject(CLSID_ShellLink);
      SLink := IObject as IShellLink;
      PFile := IObject as IPersistFile;
      with SLink do begin
        SetArguments(PChar(Param));
        SetDescription(PChar(Desc));
        SetPath(PChar(PathObj));
      end;
      PFile.Save(PWChar(WideString(PathLink)), FALSE);
    end;

