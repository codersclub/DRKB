---
Title: Как передать Username и Password в удаленный модуль данных?
Date: 01.01.2007
---


Как передать Username и Password в удаленный модуль данных?
===========================================================

::: {.date}
01.01.2007
:::

В Удаленный Модуль Данных бросьте компонент TDatabase, затем добавьте
процедуру автоматизации (пункт главного меню Edit \| Add To Interface)
для Login.

Убедитесь, что свойство HandleShared компонента TDatabase установлено в
True.

    procedure Login(UserName, Password: WideString);
    begin
      { DB = TDatabase }
      { Something unique between clients }
      DB.DatabaseName := UserName + 'DB';
      DB.Params.Values['USER NAME'] := UserName;
      DB.Params.Values['PASSWORD'] := Password;
      DB.Open;
    end;

После того, как Вы создали этот метод автоматизации, Вы можете вызывать
его с помощью:

RemoteServer1.AppServer.Login(\'USERNAME\',\'PASSWORD\');

Взято с <https://delphiworld.narod.ru>
