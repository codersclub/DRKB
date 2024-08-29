---
Title: Как установить обои в формате JPEG?
Author: Vasya2000
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как установить обои в формате JPEG?
===================================

Как установить обои в формате jpeg.

SystemParametersInfo только для bmp.

    uses
      ComObj, ShlObj;
     
    procedure ChangeActiveWallpaper;
    const
      CLSID_ActiveDesktop: TGUID = '{75048700-EF1F-11D0-9888-006097DEACF9}';
    var
      ActiveDesktop: IActiveDesktop;
    begin
      ActiveDesktop := CreateComObject(CLSID_ActiveDesktop) as IActiveDesktop;
      ActiveDesktop.SetWallpaper('c:\windows\forest.jpg', 0);
      ActiveDesktop.ApplyChanges(AD_APPLY_ALL or AD_APPLY_FORCE);
    end;

