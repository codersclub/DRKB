---
Title: Пронумеровать строки в результате запроса
Author: Vit
Date: 01.01.2007
---


Пронумеровать строки в результате запроса
=========================================

::: {.date}
01.01.2007
:::

Придётся сделать Inner Join на самого себя...

    select count(*) as ID,  c1.sys_id
    from MyTable c1 
    Inner join MyTable c2 on c1.Sys_id >= c2.sys_id
    group by c1.sys_id
    order by id

Автор: Vit
