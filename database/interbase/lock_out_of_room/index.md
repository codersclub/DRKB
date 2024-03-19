---
Title: Ошибка: lock manager out of room
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Ошибка: lock manager out of room
================================

Перейдите в каталог interbase/bin (Windows) или /usr/interbase (Unix)
и найдите файл конфигурации isc\_config.
По умолчанию ваш файл конфигурации будет выглядеть так:

    #V4_LOCK_MEM_SIZE            98304
    #ANY_LOCK_MEM_SIZE           98304
    #V4_LOCK_SEM_COUNT           32
    #ANY_LOCK_SEM_COUNT          32
    #V4_LOCK_SIGNAL              16
    #ANY_LOCK_SIGNAL             16
    #V4_EVENT_MEM_SIZE           32768
    #ANY_EVENT_MEM_SIZE          32768

Я увеличил запись V4_LOCK_MEM_SIZE с 98304 до 198304, и тогда все стало хорошо.

**!!! Важно!!!**

По умолчанию все строки в файле конфигурации закомментированы с помощью начального символа "#".

**Обязательно удалите знак "#"** во всех строках, которые вы измените, поскольку в файле конфигурации по умолчанию просто показаны параметры по умолчанию.
