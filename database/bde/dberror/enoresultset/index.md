---
Title: ENoResultSet Error creating cursor handle
Author: BAS
Date: 01.01.2007
---


ENoResultSet Error creating cursor handle
=========================================

::: {.date}
01.01.2007
:::

Почему не работает Query.Open(Query.ExecSQL)?

Что значит \"ENoResultSet Error creating cursor handle\"?

1.Query.Open возвращает результат запроса в виде курсора(Cursor).

Когда мы выполняем запрос «select \* from table1» мы получаем

Набор данных (Cursor). Можете представит курсор как виртуальную таблицу,
со строками и столбцами, определенными в запросе. В этом случае надо
использовать Query.Open или Query.Active:=true;

2.Query.ExecSQL выполняет инструкции запроса и курсор не создается.

Если в запросах используются инструкции не создающие набор данных
(курсор) -- СREATE TABLE, INSERT, DELETE, UPDATE , SELECT INTO и т.д. то
нужно вызывать метод ExecSQL.

Автор: BAS
