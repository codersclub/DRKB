---
Title: Как получить список таблиц в базе Access?
Author: Vit
Date: 01.01.2007
---


Как получить список таблиц в базе Access?
=========================================

::: {.date}
01.01.2007
:::

    t:Tstringlist;
    ...
    ADOConnection.GetTableNames(t, false)

Автор: Vit
