---
Title: Как в InterBase при создании базы ввести параметр для поддержки русского языка
Date: 01.01.2007
---


Как в InterBase при создании базы ввести параметр для поддержки русского языка
==========================================================================

::: {.date}
01.01.2007
:::

    UPDATE RDB$FIELDS 
    SET RDB$CHARACTER_SET_ID = 52 
    WHERE RDB$FIELD_NAME = 'RDB$SOURCE''

Взято с <https://delphiworld.narod.ru>
