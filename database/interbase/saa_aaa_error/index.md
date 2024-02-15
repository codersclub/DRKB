---
Title: Ошибка о файле SAA.AAA
Date: 01.01.2007
---


Ошибка о файле SAA.AAA
======================

::: {.date}
01.01.2007
:::

The \'SAA.AAA\' file is a temporary file used in processing a query.

A failure involving this file generally means that InterBase has run out
of disk space processing the query.

(Remember that this will be a temporary file on the server, so the
server is out of disk space, not your local machine!)

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>

------------------------------------------------------------------------

Этот файл является временным, и создается когда при выполнении запроса
возникает необходимость в сортировке результата. Ошибка может возникать
при нехватке дискового пространства на томе, куда указывает TEMP. Для NT
при работе IB в режиме сервиса необходимо изменить переменную TEMP для
System (см. My Computer/Properties/Environment). Для IB 5.x и 6.0 (в
архитектуре SuperServer только!) можно указать диски и размер временных
файлов в файле конфигурации IBCONFIG, или в переменной окружения
INTERBASE\_TMP (см. Operations Guide, стр92). Например:

TMP\_DIRECTORY "c:\\" 10000000

TMP\_DIRECTORY "e:\\temp\\" 100000000

Может быть указано несколько дисков или каталогов, которые будут
использоваться последовательно. Размер должен быть указан в байтах.
Кавычки для имени диска и каталога обязательны.

Borland Interbase / Firebird FAQ

Borland Interbase / Firebird Q&A, версия 2.02 от 31 мая 1999

последняя редакция от 17 ноября 1999 года.

Часто задаваемые вопросы и ответы по Borland Interbase / Firebird

Материал подготовлен в Демо-центре клиент-серверных технологий. (Epsylon
Technologies)

Материал не является официальной информацией компании Borland.

E-mail mailto:delphi@demo.ru

www: http://www.ibase.ru/

Телефоны: 953-13-34

источники: Borland International, Борланд АО, релиз Interbase 4.0, 4.1,
4.2, 5.0, 5.1, 5.5, 5.6, различные источники на WWW-серверах, текущая
переписка, московский семинар по Delphi и конференции, листсервер
ESUNIX1, листсервер mers.com.

Cоставитель: Дмитрий Кузьменко
