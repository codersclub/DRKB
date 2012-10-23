<h1>Как запустить DTS из StoredProcedure</h1>
<div class="date">01.01.2007</div>


<pre>
use master
exec xp_cmdshell "DTSRun /S servername /U username /P password /N packagename"
</pre>

<div class="author">Автор: Akim </div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<p>1.</p>
<pre>
--©Drkb v.3(2007): www.drkb.ru

Exec master..xp_cmdshell '"C:\Program Files\Microsoft SQL Server\80\Tools\Binn\dtsrun.exe" /S'+@ServerName+' /U'+@SQLUserName+' /P'+@SQLPassword+' /N'+@DTSPackageName
</pre>

<p>2.</p>
<pre>
--©Drkb v.3(2007): www.drkb.ru
 
  Declare @retval int,
          @package int,
          @ServerName char(20),
          @LoadString varchar(8000)
 
 
  Set @ServerName=CONVERT(char(20), SERVERPROPERTY('servername'))
  Set @LoadString='LoadFromSQLServer("'+@ServerName+'", "'+@ServerLogin+'", "'+@ServerPassword+'", 256, , , ,"'+@DTSPackageName+'")'
 
  EXEC @retval = sp_OACreate 'DTS.Package', @package OUTPUT
  EXEC @retval = sp_OAMethod @package,@LoadString,NULL
  EXEC @retval = sp_OAMethod @package, 'Execute'
</pre>

<div class="author">Автор: Vit</div>

