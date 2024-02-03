---
Title: Что такое DB2?
Date: 01.01.2007
---


Что такое DB2?
==============

::: {.date}
01.01.2007
:::

Семейство СУБД  от IBM.

Работающие на ограмном спектре современного аппаратного обеспечения
от карманных блокнотов (DB2 EveryWhere) до mainfraime (DB2 for OS/390) и
архитектур с массовым паралеизмом SPP. В поледнее время различные ветки
DB2, IBM сливает в одну по названием IBM DB2 Universal DataBase.

DB2 как сервер доступна на платформах:

OS/2, OS/390, OS/400, VSE, VM,
AIX, HP-UX, Sun Solaris (SPARC), SCO, DB2 for PTX (NUMA),
Windows NT, Windows 2000, Linux, Win95/98 PE

Как клиент добавляются IRIX, SINIX, MacOS, WinCE, PalmOS, Neutrino,
и для версии 1.* есть клиент для DOS.

DB2 server поддерживает следующие сетевые протоколы
если их поддержка установлена в ОС. Один instance DB2
может обслуживать клиентов по нескольким протоколам.

Платф/Прот \| TCP/IP \| SNA/APPC \| NETBIOS \| IPX/SPX \| Named Pipes \|
AIX        \|     X   \|        X    \|         \|    X    \|            \|
HP-UX        \|     X   \|        X    \|         \|    X    \|            \|
Solaris\_SPARC \| X   \|        X    \|         \|    X    \|            \|
OS/2          \|   X   \|        X    \|    X    \|    X    \|       X    \|
WinNT(x86) \|   X   \|        X    \|    X    \|    X    \|       X     \|
SCO         \|    X   \|        X    \|         \|    X    \|            \|
Linux        \|     X   \|            \|         \|    X    \|            \|

Типы лицензии на DB2:

Нижеописанное справедливо для Сommon Platform

Common Platform NOT IN ( OS/390, OS/400, VSE, VM )

Host System IN ( OS/390, OS/400, VSE, VM )

Количество лицензий регулируется юридическим
образом см. (Лицензионное соглашение с IBM)

DB2 CAE (client)(Client Application Enabler) - Клиент для доступа к
серверу DB2 идет в поставке любого db2 сервера,
является бесплатным

DB2 Workgroup Edition (we) - cервер для рабочих групп, стоит ~1200,
отличается от Enterprise Edition, тем что internet/intranet пользователь
равен простому пользователю (лицензия на пользователя порядка
200$), так же отсутствует

Personal Edition - локальный полнофункциональный сервер без
поддержки сетевых клиентов, является бесплатным. Доступен
под OS/2 и WinXX, Linux

Personal Developer Edition - есть бесплатный Personal Ed. с
дополнениями необходимыми для разработки.
Доступен под OS/2 и WinXX, Linux.

Enterprise Developer Edition - набор Personal, Workgroup и Enterprise
Ed.

DB2 Connect (conn) - cредство для связи с Host  System, входит в DB2

UDB EE так же продается как отдельно.

DB2 Enterprise Edition (ee) - лицензирутся на количество процессоров, в
поставку входит DB2 Connect, также дает лицензию на неограниченное
количество internet/intranet пользователей

DB2 Extended Enterprise Edition (eee) - Версия DB2 для кластеров,
существует для AIX, NT, Sun Solaris

А9: На каких пратформах доступны Extenders

DB2 Extenders для os/2, nt, win95, win98, aix, hp-ux, solaris (sparc),
для linux.
