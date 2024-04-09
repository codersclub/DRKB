---
Title: Прилинковать MS Access базу данных как удаленный сервер
Author: Vit
Date: 01.01.2007
---


Прилинковать MS Access базу данных как удаленный сервер
=======================================================

    Exec sp_addlinkedserver @LinkedServerName, 'Jet 4.0', 'Microsoft.Jet.OLEDB.4.0', @DatabaseName, NULL, NULL
    Exec sp_addlinkedsrvlogin @LinkedServerName, 'false'
