---
Title: Самый быстрый способ узнать количество записей в таблице
Date: 01.01.2007
---


Самый быстрый способ узнать количество записей в таблице
========================================================

::: {.date}
01.01.2007
:::

When using the standard dataset.recordcount in my client-server (win nt
against sqlserver7 db, targettable has 500.000 records) i can go for
lunch and stil be waiting (:-

Answer:

For those of you who don\'t know why u should not use the standard
dataset.recordcount when developing client server database applications.

This article is especialy for those cs db apps against a sqlserver 7 db.

since the standard dataset.recordcount iterates from begin of the table
through the end of the table to result in the recordcount. This is a
crime when developing cs db apps (against sqlserver7).

simply use another way of obtaining the number of records. I use a sql
for obtaining the number of records in a sqlserver table.

drop a tquery on the form

provide this tquery with the follow SQL:

SQL:

    select distinct max(itbl.rows) 
    from sysindexes as itbl 
    inner join sysobjects as otbl on (itbl.id = otbl.id) 
    where (otbl.type = 'U') and (otbl.name = :parTableName) 

notice the parameter: parTableName type string

use this tquery to find out how many rows in the table

TIP: try to make your own tYourSqlServerCountQuery and thus override the
recordcount property.

ByTheWay: use this only for sqlserver

for other cs db apps simply use a count sql (coming upnext time...)

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
