---
Title: Модель безопасности
Date: 01.06.2001
---


Модель безопасности
===================

## Роли

Вместо групп пользователей, использовавшихся в предыдущих версиях,
седьмая версия использует роли пользователей. Права могут даваться или
отниматься у роли, и это отражается на правах всех пользователей,
ассоциированных с этой ролью. Пользователь может быть ассоциирован
одновременно с несколькими ролями.

Для облегчения управления сервером и базами данных поддерживаются
встроенные серверные роли и роли баз данных. Так, например, серверная
роль serveradmin дает право на настройку конфигурации и остановку
сервер, а роль базы данных db\_securityadmin позволяет управлять правами
доступа пользователей. Набор встроенных ролей позволяет не предоставлять
административных привилегий пользователям, нуждающимся в каких-либо
специфических правах. Так, роль db\_securityadmin не предоставляет своим
членам прав на чтение или модификацию пользовательских таблиц.

## Интегрированная безопасность

Сильной стороной MS SQL Server является его тесная интеграция с системой
безопасности Windows NT. Права на доступ к серверу и базам данных можно
давать пользователям и группам Windows NT. Механизм делегирования
полномочий позволяет пользователям, подключившимся к одному из серверов
иметь доступ к другим серверам в сети со своими правами, отличающимися
от прав сервера, к которому они подключились. Также возможна прозрачная
для пользователя проверка его полномочий при доступе к серверу через
Microsoft Internet Information Server или Microsoft Transaction Server
