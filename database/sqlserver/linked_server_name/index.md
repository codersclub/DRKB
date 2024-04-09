---
Title: Узнать путь к прилинкованной файловой базе данных
Author: Vit
Date: 01.01.2007
---


Узнать путь к прилинкованной файловой базе данных
=================================================

    Select @FileName=Datasource From master..sysservers
    Where srvname=@LinkedServerName
