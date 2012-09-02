<h1>Экспортировать таблицу или результат запроса в файл</h1>
<div class="date">01.01.2007</div>


<p>@DataSource - хранит имя таблицы или sql запрос который надо сохранить</p>
<p>@UserName - имя пользователя для подсоединения к серверу</p>
<p>@Password - пароль пользователя для подсоединения к серверу</p>

<pre>
Declare @sql varchar(8000), @out varchar(20)
 
if PatIndex('%Select %', @DataSource)&gt;0 Set @out='" queryout "' else Set @out='" out "'
 
Set @sql='bcp "'+@DataSource+@out+' c:\MyFile.txt " -S'+@@servername+' -U'+@UserName+' -P'+@Password+' -c -t"," -r\n -k'
 
Exec master..xp_cmdshell @sql
</pre>

<p class="note">Примечание</p>
<p>Путь локален для серверного компьютера, не для клиента!</p>

<p class="author">Автор: Vit</p>

