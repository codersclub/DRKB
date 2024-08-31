---
Title: Состояние кнопки Insert
Date: 01.01.2007
Source: <https://dmitry9.nm.ru/info/>
Author: Vit
---


Состояние кнопки Insert
=======================

    function InsertOn: Boolean;
    begin
      Result:=LowOrderBitSet(GetKeyState(VK_INSERT));
    end;

Исправлено by Vit
