---
Title: Понятия Instance, Database и т.д.
Author: Nomadic
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Понятия Instance, Database и т.д.
=================================

Перевод документации:

**Что такое ORACLE Database?**

Это данные которые будут обрабатываться как единое целое. Database
состоит из файлов операционной системы. Физически существуют database
files и redo log files. Логически database files содержат словари,
таблицы пользователей и redo log файлы. Дополнительно database требует
одну или более копий control file.

**Что такое ORACLE Instance?**

ORACLE Instance обеспечивает программные механизмы доступа и управления
database. Instance может быть запущен независимо от любой database (без
монтирования или открытия любой database). Один instance может открыть
только одну database. В то время как одна database может быть открыта
несколькими Instance.

Instance состоит из:

- SGA (System Global Area), которая обеспечивает коммуникацию между
процессами;
- до пяти (в последних версиях больше) бэкграундовых процессов.

От себя добавлю - database включает в себя tablespace.  
tablespace включает в себя segments (в одном файле данных может быть один или
несколько сегментов, сегменты не могут быть разделены на несколько
файлов).  
segments включают в себя extents.

