---
Title: Как предотвратить появление login dialog?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как предотвратить появление login dialog?
=========================================

Чтобы обойти диалоговое окно входа в систему при подключении к базе данных сервера,
используйте свойство LoginPrompt.
Вам нужно будет указать имя пользователя и пароль во время выполнения,
но вы также можете настроить это во время разработки в инспекторе объектов, свойство Params.

Этот короткий исходный код показывает, как это сделать:

    Database1.LoginPrompt := false;
    with Database1.Params do
    begin
      Clear;
      // the parameters SYSDBA & masterkey should be
      // retrieved somewhat different :-)
      Add('USER NAME=SYSDBA');
      Add('PASSWORD=masterkey');
    end;
    Database1.Connected := true;

