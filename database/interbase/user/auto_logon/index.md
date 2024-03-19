---
Title: Автоматический logon к локальной InterBase
Date: 01.01.2007
Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)
---


Автоматический logon к локальной InterBase
==========================================

Используйте компонент TDatabase.

В строках Params пропишите:

    USER NAME=sysdba
    PASSWORD=masterkey

Затем установите свойство компонента TDataBase LoginPrompt в False.

После этого, с помощью свойства DataBaseName, вы должны создать
прикладной псевдоним (Alias) и связать TQuery/TTable с вашим компонентом
TDataBase

Взято из Советов по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)

Сборник Kuliba
