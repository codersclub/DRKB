---
Title: Как в runtime добавить TAction в TActionList?
Author: Dayana
Date: 01.01.2007
---


Как в runtime добавить TAction в TActionList?
=============================================

::: {.date}
01.01.2007
:::

    var

      NewAction : TAction;
    begin
      NewAction := TAction.Create(self);
      NewAction.ActionList := ActionList1;
    end; 

Автор: Dayana

Взято с Vingrad.ru <https://forum.vingrad.ru>
