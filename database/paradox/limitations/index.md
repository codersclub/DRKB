---
Title: Ограничения Paradox
Date: 01.01.2007
---


Ограничения Paradox
===================

::: {.date}
01.01.2007
:::

Table and Index Files

127 --- Tables open per system

64 --- Record locks on one table (16Bit) per session

255 --- Record locks on one table (32Bit) per session

255 --- Records in transactions on a table (32 Bit)

512 --- Open physical files (DB, PX, MB, X??, Y??, VAL, TV)

300 --- Users in one PDOXUSRS.NET file

255 --- Number of fields per table

255 --- Size of character fields

2 --- Billion records in a table

2 --- Billion bytes in .DB (Table) file

10800 --- Bytes per record for indexed tables

32750 --- Bytes per record for non-indexed tables

127 --- Number of secondary indexes per table

16 --- Number of fields in an index

255 --- Concurrent users per table

256 --- Megabytes of data per BLOB field

100 --- Passwords per session

15 --- Password length

63 --- Passwords per table

159 --- Fields with validity checks (32 Bit)

63 --- Fields with validity checks (16 Bit)

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
