---
Title: Как в InterBase при создании базы ввести параметр для поддержки русского языка
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как в InterBase при создании базы ввести параметр для поддержки русского языка
==========================================================================

    UPDATE RDB$FIELDS 
    SET RDB$CHARACTER_SET_ID = 52 
    WHERE RDB$FIELD_NAME = 'RDB$SOURCE''

