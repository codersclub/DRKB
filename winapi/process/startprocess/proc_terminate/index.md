---
Title: Поддержка процедур завершения программы
Date: 01.01.2007
---

Поддержка процедур завершения программы
=======================================

::: {.date}
01.01.2007
:::

Процедура AddTerminateProc( TermProc: TTerminateProc);

Добавляет процедуру в системный список процедур \"завершения программы\"
(termination procedures list), которые вызываются перед окончанием
работы приложения. Каждая такая процедура должна возвращать True, когда
приложение может быть беспроблемно завершено или False, если приложение
не должно быть завершено. Если любая из указанных процедур возвращает
False, то выполнение приложения завершено не будет.

Функция CallTerminateProcs: Boolean;

Функция вызывает все подпрограммы, указанные в списке процедур
завершения программы (termination procedures list). Если все процедуры и
функции списка возвращают True, то CallTerminateProcs возвращает True, в
остальных случаях функция возвращает False. Функция CallTerminateProcs
вызывается внутренне непосредственно перед завершением выполнения
приложения.

Взято с <https://atrussk.ru/delphi/>