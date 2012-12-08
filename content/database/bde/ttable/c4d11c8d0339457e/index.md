---
Title: Как по имени Базы Данных получить ссылку на компоненет TDataBase?
Author: Max Rezanov
Date: 01.01.2007
---


Как по имени Базы Данных получить ссылку на компоненет TDataBase?
=================================================================

::: {.date}
01.01.2007
:::

Автор: Max Rezanov

    var
    db : TDataBase;
    begin
     
    db := Session.FindDatabase(FDataBaseName);
    db.StartTransaction;

Взято из <https://forum.sources.ru>
