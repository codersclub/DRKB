---
Title: Индекс БД в другом каталоге
Date: 01.01.2007
---


Индекс БД в другом каталоге
===========================

::: {.date}
01.01.2007
:::

Подскажите как работать c dbf под Delphi 5, когда индексы расположены в
другом каталоге?

Serg

(10.01.01 19:54) можно сделать следующее:

    Vnhead_Cdx := TStringList.Create;
    Vnhead_Cdx.Add('c:\parus\bumi1\idx\vnhead.cdx');
    Vnhead.IndexFiles := Vnhead_Cdx;

при это сам dbf находится в c:\\parus\\bumi1\\dbf

Взято с сайта <https://blackman.wp-club.net/>
