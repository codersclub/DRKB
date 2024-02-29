---
Title: Добавление псевдонима с помощью функции DbiAddAlias
Author: Tom Stickle
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Добавление псевдонима с помощью функции DbiAddAlias
===================================================

    var
      pszAliasName: PChar;  { Имя псевдонима }
      pszDriverType: PChar; { Тип драйвера для псевдонима }
      pszParams: PChar;     { Дополнительные параметры }
      bPersist: Bool;       { Постоянный или временный псевдоним }
      dbiRes: Integer;      { Возвращаемый код }
    begin
      pszAliasName := strAlloc(25);
      pszDriverType := strAlloc(25);
      pszParams := strAlloc(100);
     
      try
        bPersist := True;
        strPcopy(pszAliasName, 'Lance');
        strPcopy(pszDriverType, 'PARADOX');
        strPcopy(pszParams, 'PATH:' + 'c:\Paradox\');
     
        dbiRes := DbiAddAlias(nil, pszAliasName, pszDriverType, pszParams,
          bPersist);
     
      finally
        strDispose(pszAliasName);
        strDispose(pszDriverType);
        strDispose(pszParams);
      end;
    end;

