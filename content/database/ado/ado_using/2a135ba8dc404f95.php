<h1>Транзакции</h1>
<div class="date">01.01.2007</div>


<p>Управление транзакциями в OLE DB реализовано на двух уровнях. Во-первых, всеми необходимыми методами обладает объект сессии. Он имеет интерфейсы ITransaction, ITransactionJoin, ITransactionLocal, ITransactionObject. </p>

<p>Внутри сессии транзакция управляется интерфейсами ITransactionLocal, ItransactionSC, ITransaction и их методами StartTransaction, Commit, Rollback. </p>

<p>Во-вторых, для объекта сессии можно создать объект транзакции при помощи метода </p>

<p>function GetTransactionObject(ulTransactionLevel: UINT; out ppTransactionObject: ITransaction): HResult; stdcall; </p>

<p>интерфейса ITransactionObject, который возвращает ссылку на интерфейс объекта-транзакции. </p>

