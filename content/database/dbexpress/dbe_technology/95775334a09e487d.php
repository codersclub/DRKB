<h1>Транзакции</h1>
<div class="date">01.01.2007</div>


<p>Подобно своим аналогам в BDE и ADO компонент TSQLConnection поддерживает механизм транзакций и делает это сходным образом.</p>

<p>Начало, фиксацию и откат транзакции выполняют методы</p>

<pre>
procedure StartTransaction(TransDesc: TTransactionDesc); 
procedure Commit(TransDesc: TTransactionDesc);  
procedure Rollback(TransDesc: TTransactionDesc); 
</pre>

<p>При этом запись TTransactionDesc возвращает параметры транзакции:</p>
<pre>
TTransIsolationLevel = (xilDIRTYREAD, xilREADCOMMITTED, xilREPEATABLEREAD, xilCUSTOM); 
TTransactionDesc = packed record 
  TransactionID : LongWord; 
  GloballD : LongWord; 
  IsolationLevel : TTransIsolationLevel; 
  Customlsolation : LongWord; 
end; 
</pre>

<p>Запись содержит уникальный в рамках соединения идентификатор транзакции TransactionID И уровень изоляции Транзакции IsolationLevel. При уровне изоляции xilCustom определяется параметр Customlsolation. Идентификатор GiobaliD используется при работе с сервером Oracle.</p>

<p>Некоторые серверы БД не поддерживают транзакции, и для определения этого факта используется свойство</p>

<p>property TransactionsSupported: LongBool;</p>

<p>Если соединение уже находится в транзакции, свойству</p>

<p>property InTransaction: Boolean;</p>

<p>присваивается значение True. Поэтому, если сервер не поддерживает множественные транзакции, всегда полезно убедиться, что соединение не обслуживает начатую транзакцию:</p>
<pre>
var Translnfo: TTransactionDesc; 
(...) 
if Not MyConnection.InTransaction then 
  try 
    MyConnection.StartTransaction(Translnfo); {...} 
    MyConnection.Commit(Translnfo); 
  except 
    MyConnection.Rollback(Translnfo);  
  end; 
</pre>


