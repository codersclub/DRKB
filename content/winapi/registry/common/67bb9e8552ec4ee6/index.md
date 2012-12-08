---
Title: Проблемы использования TRegistry под NT/2000/XP
Author: p0s0l
Date: 01.01.2007
---

Проблемы использования TRegistry под NT/2000/XP
===============================================

::: {.date}
01.01.2007
:::

При использованиии компонента TRegistry под NT пользователь с права
доступа ниже чем \"администратор\" не может получить доступа к
информации реестра в ключе HKEY\_LOCAL\_MACHINE. Как это обойти?

Проблема вызвана тем, что TRegistry всегда открывает реестр с параметром
KEY\_ALL\_ACCESS (полный доступ), даже если необходим доступ KEY\_READ
(только чтение). Избежать этого можно используя функции API для работы с
реестром (RegOpenKey и т.п.), или создать новый класс из компонента
TRegestry, и изменить его так чтобы можно было задавать режим открытия
реестра.

Автор: p0s0l

Вообще-то можно ничего не переписывать:

Reg := TRegistry.Create(KEY\_READ);

т.е. у TRegistry есть два конструктора - один без параметра, тогда
доступ будет

KEY\_ALL\_ACCESS, а другой конструктор - с параметром\...

Примечание к примечанию Vit

Дополнительные конструкторы появились только в последних версиях Дельфи

------------------------------------------------------------------------

Проблема вызвана тем, что TRegistry всегда открывает реестр с параметром
KEY\_ALL\_ACCESS (полный доступ), даже если необходим доступ KEY\_READ
(только чтение). Избежать этого можно используя вместо TRegistry.OpenKey
- TRegistry.OpenKeyReadOnly

В справке про TRegistry указано неверно, что ключ открывается всегда с
параметром KEY\_ALL\_ACCESS. В случае если открывать через
TRegistry.OpenKeyReadOnly он откроется с параметром KEY\_READ