---
Title: Как зарегистрировать базу данных (BDE)?
Author: Vit
Date: 01.01.2007
---


Как зарегистрировать базу данных (BDE)?
=======================================

::: {.date}
01.01.2007
:::

    Session.AddAlias(AliasName, AliasDriver, Params);
    Session.SaveConfigFile;

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

    uses
      DBIProcs, DBITypes;
     
    procedure AddBDEAlias(sAliasName, sAliasPath, sDBDriver: string);
    var
      h: hDBISes;
    begin
      DBIInit(nil);
      DBIStartSession('dummy', h, '');
      DBIAddAlias(nil, PChar(sAliasName), PChar(sDBDriver),
        PChar('PATH:' + sAliasPath), True);
      DBICloseSession(h);
      DBIExit;
    end;

    { Sample call to create an alias called WORK_DATA that }
    { points to the C:\WORK\DATA directory and uses the    }
    { DBASE driver as the default database driver:         }
     
    AddBDEAlias('WORK_DATA', 'C:\WORK\DATA', 'DBASE');

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
