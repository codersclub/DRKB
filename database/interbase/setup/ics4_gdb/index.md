---
Title: Что такое ISC4.GDB? Для чего нужна эта БД?
Author: [Дмитрий Кузьменко](mailto:delphi@demo.ru)
Date: 01.01.2007
---


Что такое ISC4.GDB? Для чего нужна эта БД?
==========================================

::: {.date}
01.01.2007
:::

БД ISC4.GDB используется IB для хранения информации о пользователях
(имена, пароли и т.п.). Удалять этот файл нельзя. Вы можете создать
alias на эту БД и посмотреть ее содержимое, и даже программно добавлять
пользователей или изменять их пароли, воспользовавшись соответствующими
UDF в разделе www.ibase.ru/d\_udf.htm.

Автор: [Дмитрий Кузьменко](mailto:delphi@demo.ru)
(<https://www.ibase.ru>)