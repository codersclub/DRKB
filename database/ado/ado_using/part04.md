---
Title: Транзакции
Date: 01.01.2007
---


Транзакции
==========

Управление транзакциями в OLE DB реализовано на двух уровнях. Во-первых,
всеми необходимыми методами обладает объект сессии. Он имеет интерфейсы
ITransaction, ITransactionJoin, ITransactionLocal, ITransactionObject.

Внутри сессии транзакция управляется интерфейсами ITransactionLocal,
ItransactionSC, ITransaction и их методами StartTransaction, Commit,
Rollback.

Во-вторых, для объекта сессии можно создать объект транзакции при помощи
метода

    function GetTransactionObject(ulTransactionLevel: UINT;
      out ppTransactionObject: ITransaction): HResult; stdcall;

интерфейса ITransactionObject, который возвращает ссылку на интерфейс
объекта-транзакции.
