---
Title: Как узнать, присутствует ли мышка?
Date: 01.01.2007
---


Как узнать, присутствует ли мышка?
==================================

::: {.date}
01.01.2007
:::

    function MousePresent : Boolean; 
    begin 
    if GetSystemMetrics(SM_MOUSEPRESENT) <> 0 then 
      Result := true 
    else 
      Result := false; 
    end; 

Взято из <https://forum.sources.ru>
