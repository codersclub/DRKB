---
Title: Конвертирование числа в строку, которую понимает Excel
Author: Sh\@dow
Date: 01.01.2007
---


Конвертирование числа в строку, которую понимает Excel
======================================================

::: {.date}
01.01.2007
:::

     /* Функция переводит число в строковое выражение числа с запятой, которое понимает Ёксель
     15.11.02  */
     
    CREATE FUNCTION Float2Str
    (@val as float )
    RETURNS varchar(24)
     AS  
    BEGIN 
     
    declare @s as varchar(24)
    set @s=str(@val,21,2)
    return stuff(@s,len(@s)-2,1,',')
     
    END

Автор: Sh\@dow

Взято с Vingrad.ru <https://forum.vingrad.ru>
