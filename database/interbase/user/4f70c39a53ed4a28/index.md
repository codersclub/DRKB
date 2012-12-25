---
Title: Как предотвратить появление login dialog?
Date: 01.01.2007
---


Как предотвратить появление login dialog?
=========================================

::: {.date}
01.01.2007
:::

To bypass the login dialog when connecting to a server database, use the
property LoginPrompt.You will have to provide the username & password at
runtime, but you also can set that up at design time in the object
inspector, property Params.

This short source code shows how to do it:

    Database1.LoginPrompt := false;
    with Database1.Params do
    begin
      Clear;
      // the parameters SYSDBA & masterkey should be
      // retrieved somewhat different :-)
      Add('USER NAME=SYSDBA');
      Add('PASSWORD=masterkey');
    end;
    Database1.Connected := tr

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
