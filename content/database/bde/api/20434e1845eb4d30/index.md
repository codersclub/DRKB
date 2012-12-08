---
Title: Работа с базами данных
Date: 01.01.2007
---


Работа с базами данных
======================

::: {.date}
01.01.2007
:::

Each function listed below returns information about a specific
database, available databases, or performs a database-related task, such
as opening or closing a database.

DbiCloseDatabase:

Closes a database and all tables associated with this database handle.

DbiGetDatabaseDesc:

Retrieves the description of the specified database from the
configuration file.

DbiGetDirectory:

Retrieves the current working directory or the default directory.

DbiOpenDatabase:

Opens a database in the current session and returns a database handle.

DbiOpenDatabaseList:

Creates an in-memory table containing a list of accessible databases and
their descriptions.

DbiOpenFileList:

Opens a cursor on the virtual table containing all the tables accessible
by the client application

and their descriptions.

DbiOpenIndexList:

Opens a cursor on an in-memory table listing the indexes on a specified
table, along with

their descriptions.

DbiOpenTableList:

Creates an in-memory table with information about all the tables
accessible to the client application.

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
