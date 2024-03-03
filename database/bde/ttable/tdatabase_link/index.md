---
Title: Как по имени Базы Данных получить ссылку на компонент TDataBase?
Author: Max Rezanov
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как по имени Базы Данных получить ссылку на компонент TDataBase?
=================================================================

    var
    db : TDataBase;
    begin
     
    db := Session.FindDatabase(FDataBaseName);
    db.StartTransaction;

