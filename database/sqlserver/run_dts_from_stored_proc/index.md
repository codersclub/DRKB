---
Title: Как запустить DTS из StoredProcedure
Author: Akim
Date: 01.01.2007
---


Как запустить DTS из StoredProcedure
====================================

Вариант 1.

    use master
    exec xp_cmdshell "DTSRun /S servername /U username /P password /N packagename"

Author: Akim

Source: <https://forum.sources.ru>

--------------------------------------------------
Вариант 2.

Author: Vit

    Exec master..xp_cmdshell '"C:\Program Files\Microsoft SQL Server\80\Tools\Binn\dtsrun.exe" /S'+@ServerName+' /U'+@SQLUserName+' /P'+@SQLPassword+' /N'+@DTSPackageName

--------------------------------------------------
Вариант 3.

Author: Vit

      Declare @retval int,
              @package int,
              @ServerName char(20),
              @LoadString varchar(8000)
     
     
      Set @ServerName=CONVERT(char(20), SERVERPROPERTY('servername'))
      Set @LoadString='LoadFromSQLServer("'+@ServerName+'", "'+@ServerLogin+'", "'+@ServerPassword+'", 256,,,,"'+@DTSPackageName+'")'
     
      EXEC @retval = sp_OACreate 'DTS.Package', @package OUTPUT
      EXEC @retval = sp_OAMethod @package,@LoadString,NULL
      EXEC @retval = sp_OAMethod @package, 'Execute'
