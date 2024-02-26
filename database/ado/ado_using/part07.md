---
Title: Провайдеры ADO
Date: 01.01.2007
---


Провайдеры ADO
==============

Провайдеры ADO обеспечивают соединение приложения, использующего данные
через ADO, с источником данных (сервером SQL, локальной СУБД, файловой
системой и т. д.). Для каждого типа хранилища данных должен существовать
провайдер ADO.

Провайдер "знает" о местоположении хранилища данных и его содержании,
умеет обращаться к данным с запросами и интерпретировать возвращаемую
служебную информацию и результаты запросов с целью их передачи
приложению.

Список установленных в данной операционной системе провайдеров доступен
для выбора при установке соединения через компонент TADOConnection.

При инсталляции Microsoft ActiveX Data Objects в операционной системе
устанавливаются следующие стандартные провайдеры:

- Microsoft Jet OLE DB Provider обеспечивает соединение с данными СУБД
Access при посредстве технологии DАО.

- Microsoft OLE DB Provider for Microsoft Indexing Service обеспечивает
доступ только для чтения к файлам и Internet-ресурсам Microsoft Indexing
Service.

- Microsoft OLE DB Provider for Microsoft Active Directory Service
обеспечивает доступ к ресурсам службы каталогов (Active Directory
Service).

- Microsoft OLE DB Provider for Internet Publishing позволяет использовать
ресурсы, предоставляемые Microsoft FrontPage, Microsoft Internet
Information Server, HTTP-файлы.

- Microsoft Data Shaping Service for OLE DB позволяет использовать
иерархические наборы данных.

- Microsoft OLE DB Simple Provider предназначен для организации доступа к
источникам данных, поддерживающим только базисные возможности OLE DB.

- Microsoft OLE DB Provider for ODBC drivers обеспечивает доступ к данным,
которые уже "прописаны" при помощи драйверов ODBC. Однако реальное
использование столь экзотичных вариантов соединений представляется
проблематичным. Драйверы ODBC и так славятся своей медлительностью,
поэтому дополнительный слой сервисов здесь ни к чему.

- Microsoft OLE DB Provider for Oracle обеспечивает соединение с сервером
Oracle.

- Microsoft OLE DB Provider for SQL Server обеспечивает соединение с
сервером Microsoft SQL Server.
