---
Title: Как запустить DTS из StoredProcedure
Author: Akim
Date: 01.01.2007
---


Как запустить DTS из StoredProcedure
====================================

::: {.date}
01.01.2007
:::

    use master
    exec xp_cmdshell "DTSRun /S servername /U username /P password /N packagename"

Автор: Akim

Взято из <https://forum.sources.ru>

1.

    --©Drkb v.3(2007): www.drkb.ru

    Exec master..xp_cmdshell '"C:\Program Files\Microsoft SQL Server\80\Tools\Binn\dtsrun.exe" /S'+@ServerName+' /U'+@SQLUserName+' /P'+@SQLPassword+' /N'+@DTSPackageName

2.

    --©Drkb v.3(2007): www.drkb.ru
     
      Declare @retval int,
              @package int,
              @ServerName char(20),
              @LoadString varchar(8000)
     
     
      Set @ServerName=CONVERT(char(20), SERVERPROPERTY('servername'))
      Set @LoadString='LoadFromSQLServer("'+@ServerName+'", "'+@ServerLogin+'", "'+@ServerPassword+'", 256,,,,"'+@DTSPackageName+'")'
     
      EXEC @retval = sp_OACreate 'DTS.Package', @package OUTPUT
      EXEC @retval = sp_OAMethod @package,@LoadString,NULL
      EXEC @retval = sp_OAMethod @package, 'Execute'

Автор: Vit
