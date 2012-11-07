<h1>Как зарегистрировать базу данных (BDE)?</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
Session.AddAlias(AliasName, AliasDriver, Params);
Session.SaveConfigFile;
</pre>

<div class="author">Автор: Vit</div>

<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

<hr />

<pre class="delphi">
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
</pre>

<pre>
{ Sample call to create an alias called WORK_DATA that }
{ points to the C:\WORK\DATA directory and uses the    }
{ DBASE driver as the default database driver:         }
 
AddBDEAlias('WORK_DATA', 'C:\WORK\DATA', 'DBASE');
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
