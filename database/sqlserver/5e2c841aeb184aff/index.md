---
Title: Как построить строку подключения
Author: Vit
Date: 01.01.2007
---


Как построить строку подключения
================================

::: {.date}
01.01.2007
:::

    function BuildConnectionString(Database, Server, Login, Password:string):Widestring;

     
    begin
      if Password<>'' then Password:=';Password='+Password+';Persist Security Info=True' else Password:=';Persist Security Info=False';
      result:=Format('Provider=SQLOLEDB.1%s;User ID=%s;Initial Catalog=%s;Data Source=%s', [Password, Login, Database, Server]);
    end;

Автор: Vit
