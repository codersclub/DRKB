---
Title: Как узнать физическое расположение локальной БД по Alias?
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как узнать физическое расположение локальной БД по Alias?
=========================================================

По Table(Query).Database:

    uses
      DbiProcs;
     
    function GetDirByDatabase(Database: TDatabase): string;
    var
      pszDir: PChar;
    begin
      pszDir := StrAlloc(255);
      try
        DbiGetDirectory(Database.Handle, True, pszDir);
        Result := StrPas(pszDir);
      finally
        StrDispose(pszDir);
      end;
    end;

По алиасу:

    function GetPhNameByAlias(sAlias: string): string;
    var
      Database: TDatabase;
      pszDir: PChar;
    begin
      Database := TDatabase.Create(nil); {allocate memory}
      pszDir := StrAlloc(255);
      try
        Database.AliasName := sAlias;
        Database.DatabaseName := 'TEMP'; {requires a name -- is ignored}
        Database.Connected := True; {connect without opening any table}
        DbiGetDirectory(Database.Handle, True, pszDir); {get the dir.}
        Database.Connected := False; {disconnect}
        Result := StrPas(pszDir); {convert to a string}
      finally
        Database.Free; {free memory}
      end;
    end;

