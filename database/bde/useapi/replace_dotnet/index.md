---
Title: Изменение месторасположения *.NET-файла
author: Scott Frolich
Date: 01.01.2007
Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)
---


Изменение месторасположения *.NET-файла
========================================

>Кто-нибудь знает как изменить месторасположение файла PDOXUSRS.NET во
>время выполнения программы?

    DbiSetProp(hSessionHandle, sesNetFile, pchar('c:\newdir'));

Для получения дескриптора сеанса, если вы используете сессию по
умолчанию, необходимо вызвать DbiGetCurrSession .

Взято из Советов по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)

Сборник Kuliba
