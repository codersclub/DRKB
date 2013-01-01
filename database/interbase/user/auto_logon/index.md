---
Title: Автоматический logon к локальной InterBase
Date: 01.01.2007
---


Автоматический logon к локальной InterBase
==========================================

::: {.date}
01.01.2007
:::

Используйте компонент TDatabase. В строках Params пропишите:

    USER NAME=sysdba

    PASSWORD=masterkey

Затем установите свойство компонента TDataBase LoginPrompt в False.

После этого, с помощью свойства DataBaseName, вы должны создать
прикладной псевдоним (Alias) и связать TQuery/TTable с вашим компонентом
TDataBase

Взято из Советов по Delphi от [Валентина
Озерова](mailto:mailto:webmaster@webinspector.com)

Сборник Kuliba
