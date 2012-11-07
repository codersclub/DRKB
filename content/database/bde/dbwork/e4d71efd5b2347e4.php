<h1>Как узнать физическое расположение локальной БД по Alias?</h1>
<div class="date">01.01.2007</div>


<p>По Table(Query).Database:</p>

<pre class="delphi">
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
</pre>

<p>По алиасу:</p>

<pre class="delphi">
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
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

