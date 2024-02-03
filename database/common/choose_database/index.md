---
Title: Критерии выбора базы данных (статья)
Author: Vit
Date: 01.01.2007
---


Критерии выбора базы данных (статья)
====================================

::: {.date}
01.01.2007
:::

Никаких абсолютных рекомендаций - это только вскидка на первый взгляд.
Просто небольшая памятка чтобы не терятся в море баз данных. Возможно
мои оценки неточны в деталях, кроме того я оставил лишь наиболее
распространённые базы.

1)Размер базы данных - параметер весьма критичен!

- несколько мегабайт: MS Access, XML, CSV, MS Excel, Парадокс, Dbase,
Foxpro/VFP, MySQL, PostgreSQL

- до сотни мегабайт: MS Access, Парадокс, Dbase, Foxpro/VFP, MySQL,
PostgreSQL, Interbase

- гигабайты: MySQL, PostgreSQL, Interbase, Informix, MS SQL Server,
Oracle, SyBase, DB/2

- сотни гигабайт и больше: MS SQL Server, Oracle, SyBase, DB/2

2) Количество одновременных пользователей - пожалуй это самый критичный
параметер!

- эксклюзивный доступ одного пользователя: MS Excel, XML, CSV,
Парадокс, Dbase, Foxpro/VFP, MS Access, MySQL, PostgreSQL

- до десятка пользователей: Парадокс, Dbase, Foxpro/VFP, MS Access,
MySQL, PostgreSQL

- несколько десятков пользователей: MySQL, PostgreSQL, Interbase,
Informix

- сотни пользователей: PostgreSQL, Interbase, MS SQL Server, Oracle,
SyBase, DB/2

- тысячи пользователей: MS SQL Server, Oracle, SyBase, DB/2

3) Цена базы данных - параметер весьма критичен!

- полностью бесплатно: XML, CSV, MySQL, PostgreSQL, Interbase
(некоторые клоны)

- формат бесплатен, для разработки желательно купить дешёвую всего одну
систему:MS Excel, Парадокс, Dbase, Foxpro/VFP, MS Access

- дешёвые сервера: Interbase (некоторые клоны), Informix, старые версии
SyBase

- дорогие сервера: MS SQL Server, Oracle, SyBase

- сверхдорогие сервера: DB/2

4) Платформа - параметер весьма критичен!

- любая: XML, CSV

- Windows only: MS SQL Server, SyBase, Парадокс, Dbase, Foxpro/VFP, MS
Access, MS Excel

- Unix/Linux only:PostgreSQL

- Windows+Linux:Oracle, DB/2, Interbase, MySQL

- Мейнфреймы: DB/2

- Кластеры:MS SQL Server, Oracle, SyBase, DB/2

5) язык программирования - рекомендательный параметер:

- Языки от Microsoft: MS SQL Server, SyBase, Foxpro/VFP, MS Access, MS
Excel

- Языки от Борланда: MS SQL Server, Interbase, Парадокс, MS Access

- Системы под Linux: Oracle, DB/2, Interbase, MySQL, PostgreSQL, XML

6) Тип программы - рекомендательный параметер:

- маленький web сервер: MySQL

- мощный web сервер: MS SQL Server, Oracle, SyBase, DB/2

- локальная утилита: Парадокс, Dbase, Foxpro/VFP, MS Access, MS Excel,
XML, CSV

- сложная система:MS SQL Server, Oracle, SyBase, DB/2, Interbase,
Informix

7) Защита данных - параметер весьма критичен!

- никакая: MS Excel, XML, CSV

- очень слабая: Парадокс, Dbase, Foxpro/VFP, MS Access

- сильная:MS SQL Server, Oracle, SyBase, DB/2, Interbase, Informix,
MySQL, PostgreSQL

8) Мощность языка SQL, возможности базы данных (View, Stored procedures,
agents, backup, репликации и т.п.) - параметер весьма критичен!

- очень слабые: MS Excel, XML, CSV

- слабые: Парадокс, Dbase, Foxpro/VFP, MS Access, MySQL

- развитые:Interbase, Informix, PostgreSQL

- мощные:MS SQL Server, Oracle, SyBase, DB/2

9) Требования к железу - параметер весьма критичен!:

- неприхотливые:MySQL, PostgreSQL, Парадокс, Dbase, Foxpro/VFP, MS
Access,MS Excel, XML, CSV

- чуствительные: Interbase, Informix, SyBase

- требуют отдельных мощных серверов с большой RAM, желательно на
нескольких процессорах: MS SQL Server, Oracle, DB/2

10) Способ доступа - рекомендательны параметер:

- ODBC: CSV

- OLE DB/ADO: MS Excel,MS Access,MS SQL Server, SyBase

- DAO:MS Excel,MS Access,Foxpro/VFP

- BDE:Парадокс, Dbase,Foxpro/VFP

- DBExpress:MySQL, Interbase, Oracle, DB/2

- Собственные:XML,MySQL,Interbase, Informix, PostgreSQL, Oracle,
SyBase, DB/2

11) Сложность настройки, установки, администрирования, желательность
специально обученного персонала для администрирования - параметер весьма
критичен!:

- никаких сложностей, администрирование не требуется: MS Excel, XML,
CSV

- минимальные либо небольшие сложности: Парадокс, Dbase, Foxpro/VFP, MS
Access

- первоначальная настройка плюс минимальная поддержка: PostgreSQL,
MySQL

- требуются специальные знания в достаточно большом объёме: Interbase,
Informix

- желательно наличие специалиста по базам данных: MS SQL Server,
Oracle, SyBase, DB/2

12) Стоимость программистов и администраторов - параметер весьма
критичен!:

- небольшая: MS Excel, XML, CSV, Парадокс, Dbase, Foxpro/VFP, MS
Access, PostgreSQL, MySQL

- значительная: Interbase, Informix, SyBase

- высокая и очень высокая: MS SQL Server, Oracle, DB/2

13) Перспективы развития базы данных, стабильность фирм-хозяев, выпуск
новых релизов и т.п-рекомендательный параметер.

- "мёртвые" или почти мёртвые базы: Парадокс, Dbase, Foxpro/VFP, CSV

- медленно развивающиеся, сомнительные перспективы, фирмы производители
не устойчиво стоящие на ногах: Interbase, Informix, PostgreSQL, SyBase

- Гарантированно продолжение, только развивать дальше некуда: MS Excel,
MS Access, DB/2

- Бурно развивающиеся базы, частые релизы и апдейты: MS SQL Server,
Oracle, XML, MySQL

14) Трудоёмкость и возможность перевода программы от одной базы к другой
- рекомендательный параметер:

Лёгкие переходы:

Парадокс\<-\>Dbase\<-\>Foxpro/VFP

CSV-\>MS Excel

SyBase -\> MS SQL Server

MS Excel-\>MS Access

В остальных случаях обычно можно перевести более лёгкие базы в более
навороченные, но не наоборот. Особняком стоит XML который обычно вообще
трудно куда дибо перевести

Автор: Vit
