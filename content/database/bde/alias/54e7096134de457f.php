<h1>Как создать постоянный Alias?</h1>
<div class="date">01.01.2007</div>



<p>There has been a number of occasions where I needed to create persistent BDE aliases. The point is that the DB API isn't very discussed and is unkown to most Delphi developers. Despite that fact, the Dbi calls are very powerful and useful functions.</p>

<p>The function below, CreateAlias, encapsulates the DbiAddAlias call, with some error checking and BDE initialization and finalization procedures.</p>
<pre>
uses Windows, SysUtils, DbiProcs, DbiErrs, DBTables;
 
const
  CRLF = #13 + #10;
  ERR_ALIASDRIVERNOTFOUND = 'Specified driver does not exist.';
  ERR_ALIASALREADYEXISTS = 'The Alias (%s) already exists.' + CRLF +
    'Would you like to reconfigure it?';
  ERR_ALIASINVALIDPARAM = 'Invalid Alias name.';
  ERR_ALIASCLOSEBDE = 'Error closing the BDE.' + CRLF +
    'Please close all applications and restart Windows';
  ERR_ALIASOPENBDE = 'Error initializing BDE. Cannot create Alias.';
 
procedure CreateAlias(sAlias, sPath, sDriver: string;
  PersistentAlias: Boolean);
var
  dbEnv: DbiEnv;
  dbRes: DbiResult;
  Resp: word;
begin
  { Sets the BDE environment }
  with dbEnv do
  begin
    StrPCopy(szWorkDir, sPath);
    StrPCopy(szIniFile, '');
    bForceLocalInit := True;
    StrPCopy(szLang, '');
    StrPCopy(szClientName, 'dbClientName');
  end;
  { Initalizes BDE with the environment dbEnv }
  if DbiInit(@dbEnv) &lt;&gt; DbiERR_NONE then
    raise Exception.Create(ERR_ALIASOPENBDE);
  { Adds the specified Alias }
  if sDriver = 'STANDARD' then
    dbRes := DbiAddAlias(nil, pchar(sAlias), nil,
      pchar('PATH:' + sPath), PersistentAlias)
  else
    dbRes := DbiAddAlias(nil, pchar(sAlias), pchar(sDriver),
      pchar('PATH:' + sPath), PersistentAlias);
  case dbRes of
    DbiERR_INVALIDPARAM:
      raise Exception.Create(ERR_ALIASINVALIDPARAM);
    DbiERR_NAMENOTUNIQUE:
      begin
        resp := MessageBox(0, pchar(Format(ERR_ALIASALREADYEXISTS, [sAlias])),
          'CreateAlias', MB_ICONSTOP + MB_YESNO);
        if Resp = ID_YES then
        begin
          Check(DbiDeleteAlias(nil, pchar(sAlias)));
          CreateAlias(sAlias, sPath, sDriver, PersistentAlias);
        end;
      end;
    DbiERR_UNKNOWNDRIVER:
      raise Exception.Create(ERR_ALIASDRIVERNOTFOUND);
  end;
  if DbiExit &lt;&gt; DbiERR_NONE then
    raise Exception.Create(ERR_ALIASCLOSEBDE);
end; {CreateAlias}
</pre>

<p>The parameters for this function are:</p>

<p>sAlias: Name of the new alias to be created</p>

<p>sPath: Full path of the directory to which the alias should point. With little adjustments, this function can be used to create any kind of aliases, and, instead of passing the path info in this argument, pass all the parameters needed by the driver to create the alias.</p>

<p>sDriver: Name of an existing BDE driver, such as PARADOX, DBASE, STANDARD</p>

<p>PersistentAlias: Determines whether the new alias will be for future use (persistent) or just for the actual session.</p>

<p>Example of usage:</p>

<p>CreateAlias('DBTEST', 'c:\progra~1\borland\delphi~1\projects\cd3\data', 'PARADOX',</p>
<p>  true);</p>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
