---
Title: Как скопировать таблицу из одной базы данных в другую?
Date: 01.01.2007
---


Как скопировать таблицу из одной базы данных в другую?
======================================================

::: {.date}
01.01.2007
:::

f I am not wrong you have an Access db with multiple tables and you want
to copy one of these tables into another Access db. For this case i
would do the next:

1.        Create database TrasportDB.mdb - use ADOX.

2.        Copy table from source table into TransportDB.mdb with Select
* Into [TransportTable] in "FullPath\\TransportDB.mdb" From
SourceTable.

3.        Deliver TransportDB.mdb on destination computer.

4.        Copy table from TransportTable into DestTable with Select *
Into [DestTable] From [TransportTable] in
"FullPath\\TransportDB.mdb".

FullPath is the path to TransportDB.mdb and is different on source and
dest computers.

This way you will use native access methods that should be more reliable
and faster than using ADO methods. If you need to perform more complete
tasks you should use replication from Microsoft Jet and Replication
objects (import this typelib).

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
