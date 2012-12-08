---
Title: Состояние кнопки Insert
Date: 01.01.2007
---


Состояние кнопки Insert
=======================

::: {.date}
01.01.2007
:::

    function InsertOn: Boolean;
    begin
      
     
      Result:=LowOrderBitSet(GetKeyState(VK_INSERT));
    end;

Источник: <https://dmitry9.nm.ru/info/>

Исправлено by Vit
