---
Title: Экспортировать таблицу или результат запроса в файл
Author: Vit
Date: 01.01.2007
---


Экспортировать таблицу или результат запроса в файл
===================================================

::: {.date}
01.01.2007
:::

@DataSource - хранит имя таблицы или sql запрос который надо сохранить

@UserName - имя пользователя для подсоединения к серверу

@Password - пароль пользователя для подсоединения к серверу

    Declare @sql varchar(8000), @out varchar(20)
     
    if PatIndex('%Select %', @DataSource)>0 Set @out='" queryout "' else Set @out='" out "'
     
    Set @sql='bcp "'+@DataSource+@out+' c:\MyFile.txt " -S'+@@servername+' -U'+@UserName+' -P'+@Password+' -c -t"," -r\n -k'
     
    Exec master..xp_cmdshell @sql

Примечание

Путь локален для серверного компьютера, не для клиента!

Автор: Vit
