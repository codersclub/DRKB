---
Title: Изменение месторасположения *.NET-файла
author: Scott Frolich
Date: 01.01.2007
---


Изменение месторасположения *.NET-файла
========================================

::: {.date}
01.01.2007
:::

Кто-нибудь знает как изменить месторасположение файла PDOXUSRS.NET во
время выполнения программы?

DbiSetProp(hSessionHandle, sesNetFile, pchar(\'c:\\newdir\'));

Для получения дескриптора сеанса, если вы используете сессию по
умолчанию, необходимо вызвать DbiGetCurrSession .

Scott Frolich

Взято из Советов по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)

Сборник Kuliba
