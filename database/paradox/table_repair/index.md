---
Title: Как восстановить поврежденную таблицу?
Date: 01.01.2007
---


Как восстановить поврежденную таблицу?
======================================

::: {.date}
01.01.2007
:::

How to recover Data in a damaged Header of DbTables.

(Paradox or Dbase) Tables

If this problem occurs and we have not copies of data.

Paradox can\'t directly open those damaged Tables so

Paradox can\'t repair those tables.

solution :

T1: the Damaged Table

1 - We Have to create an empty Table (T2.Db or T2.Dbf)
that have the same structure of damaged table (T1.DB or T1.Dbf).

2 - With Dos Prompts or excutable batch File we have to
execute this command:

    Copy T2.Db+T1.db T3.Db

or

    Copy T2.Dbf+T1.dbf T3.Dbf

3 - Finally with paradox browser we can open T3 Table,
we have to delete bad records,
and copy t3 to t1 table.

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
