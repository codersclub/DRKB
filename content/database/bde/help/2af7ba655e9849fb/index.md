---
Title: Каковы текущие ограничения BDE?
Date: 01.01.2007
---


Каковы текущие ограничения BDE?
===============================

::: {.date}
01.01.2007
:::

Основные ограничения BDE:

48 клиентов в системе;

32 сессии на одного клиента (для версии 3.5 и ниже, 16 Bit, 32 Bit)

256 сессий на одного клиента (для версии 4.0 и выше, 32 Bit)

32 открытых баз данных на сессию (для версии 3.5 и ниже, 16 Bit, 32 Bit)

2048 открытых баз данных на сессию (для версии 4.0 и выше, 32 Bit)

32 загруженных драйвера

64 сессии в системе (для версии 3.5 и ниже, 16 Bit, 32 Bit)

12288 сессии в системе (для версии 4.0 и выше, 32 Bit)

4000 курсоров на сессию

16 вхождений в стеке ошибок

8 типов таблиц на один драйвер

16 типов полей на один драйвер

8 типов индексов на один драйвер

48K Размер конфигурационного файла (IDAPI.CFG)

64K Максимальный размер оператора SQL при RequestLive=False

4K Максимальный размер оператора SQL при RequestLive=True (для версии
4.0 и ниже, 16/32 Bit)

6K Максимальный размер оператора SQL при RequestLive=True (для версии
4.01 и выше, 32 Bit)

16K Размер буфера записи (SQL и ODBC)

31 Размер имени таблицы и имени поля в символах

64 Размер имени хранимой процедуры в символах

16 Полей в ключе

3 Размер расширения имени файла в символах

260 Длина имени таблицы в символах (некоторые сервера могут иметь другие
ограничения)

260 Длина полного имени файла и пути файловой системы в символах

Ограничения Paradox:

127 открытых таблиц в системе (для версии 4.0 и ниже, 16/32 Bit)

254 открытых таблиц в системе (для версии 4.01 и выше, 32 Bit)

64 блокировки на запись на одну таблицу (16Bit) на одну сессию

255 блокировок на запись на одну таблицу (32Bit) на одну сессию

255 записей, учавствующих в транзакции на таблицу (32 Bit)

512 открытых физически файлов (DB, PX, MB, X??, Y??, VAL, TV) (для
версии 4.0 и ниже, 16/32 Bit)

1024 открытых физически файлов (DB, PX, MB, X??, Y??, VAL, TV) (для
версии 4.01 и выше, 32 Bit)

300 пользователей в одном файле PDOXUSRS.NET

255 полей в таблице

255 размер символьных полей

2 миллиарда записей в таблице

2 миллиарда байт в .DB (таблица) файле

10800 байт на запись для индексированных таблиц

32750 байт на запись для неиндексированных таблиц

127 вторичных индексов на таблицу

16 полей на индекс

255 одновременно работающих пользователей на таблицу

256 Мегабайт данных на одно BLOb поле

100 паролей на сессию

15 длина пароля

63 паролей на таблицу

159 полей с проверками корректности (validity check) (32 Bit)

63 поля с проверками корректности (validity check) (16 Bit)

Ограничения dBase:

256 открытых таблиц dBASE на систему (16 Bit)

350 открытых таблиц dBASE на систему (BDE 3.0 - 4.0, 32 Bit)

512 открытых таблиц dBASE на систему (BDE 4.01 и выше, 32 Bit)

100 блокировок на запись на одной таблице dBASE (16 and 32 Bit)

100 записей, учавствующих в транзакции на таблицу (32 Bit)

1 миллиард записей в таблице

2 миллиарда байт в файле .DBF (таблица)

4000 Размер записи в байтах (dBASE 4)

32767 Размер записи в байтах (dBASE for Windows)

255 Количество полей в таблице (dBASE 4)

1024 Количество полей в таблице (dBASE for Windows)

47 Количество тэгов индексов на один .MDX-файл.

254 Размер символьных полей

10 открытых основных индексов (.MDX) на таблицу

220 Длина ключевого выражения в символах

Взято из Akzhan\'s Database Delphi