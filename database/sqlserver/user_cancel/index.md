---
Title: Отключить пользователя и прервать все его запросы
Author: Vit
Date: 01.01.2007
---


Отключить пользователя и прервать все его запросы
=================================================

    declare @pid int, @sql varchar(100)

    Declare p cursor  For
      select spid from  master.dbo.sysprocesses
      where sid = suser_sid(@User)
     
    Open p 
    Fetch next from p into @pid
    While @@Fetch_status=0
      begin
        Set @sql='Kill '+cast(@pid as varchar(10))
        Exec(@sql)
        Fetch next from p into @pid
      end 
    Close p
    Deallocate p

Пользователь будет отключен и все его запросы прерваны,
но код не мешает ему вновь подсоединиться.
