---
Title: Как в runtime добавить TAction в TActionList?
Author: Dayana
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как в runtime добавить TAction в TActionList?
=============================================

    var

      NewAction : TAction;
    begin
      NewAction := TAction.Create(self);
      NewAction.ActionList := ActionList1;
    end; 

