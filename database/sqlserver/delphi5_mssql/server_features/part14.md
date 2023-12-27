---
Title: Создание хранимых процедур и триггеров
Date: 01.01.2007
---


Создание хранимых процедур и триггеров
======================================

::: {.date}
01.01.2007
:::

Если логика работы процедуры или триггера требует установки каких-либо
SET-параметров в определенные значения, процедура или триггер могут
установить их внутри своего кода. По завершении их выполнения будут
восстановлены исходные параметры, которые были на сервере до запуска
процедуры или оператора, вызвавшего срабатывание триггера. Исключением
являются SET QUOTED\_IDENTIFIER и SET ANSI\_NULLS для хранимых процедур.
Сервер запоминает их на момент создания процедуры и автоматически
восстанавливает при исполнении.

MS SQL Server использует отложенное разрешение имен объектов и позволяет
создавать процедуры и триггеры, которые ссылаются на объекты, не
существующие при их создании.