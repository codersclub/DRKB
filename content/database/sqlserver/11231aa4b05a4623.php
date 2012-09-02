<h1>Отключить пользователя и прервать все его запросы</h1>
<div class="date">01.01.2007</div>


<pre>
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
</pre>

<p>Пользователь будет отключен и все его запросы прерваны, но код не мешает ему вновь подсоединиться.</p>

<p class="author">Автор: Vit</p>

