---
Title: Транзакции
Date: 01.01.2007
---


Транзакции
==========

Подобно своим аналогам в BDE и ADO компонент TSQLConnection поддерживает
механизм транзакций и делает это сходным образом.

Начало, фиксацию и откат транзакции выполняют методы

    procedure StartTransaction(TransDesc: TTransactionDesc); 
    procedure Commit(TransDesc: TTransactionDesc);  
    procedure Rollback(TransDesc: TTransactionDesc); 

При этом запись TTransactionDesc возвращает параметры транзакции:

    TTransIsolationLevel = (xilDIRTYREAD, xilREADCOMMITTED, xilREPEATABLEREAD, xilCUSTOM); 
    TTransactionDesc = packed record 
      TransactionID : LongWord; 
      GloballD : LongWord; 
      IsolationLevel : TTransIsolationLevel; 
      Customlsolation : LongWord; 
    end; 

Запись содержит уникальный в рамках соединения идентификатор транзакции
TransactionID И уровень изоляции Транзакции IsolationLevel. При уровне
изоляции xilCustom определяется параметр Customlsolation. Идентификатор
GiobaliD используется при работе с сервером Oracle.

Некоторые серверы БД не поддерживают транзакции, и для определения этого
факта используется свойство

    property TransactionsSupported: LongBool;

Если соединение уже находится в транзакции, свойству

    property InTransaction: Boolean;

присваивается значение True. Поэтому, если сервер не поддерживает
множественные транзакции, всегда полезно убедиться, что соединение не
обслуживает начатую транзакцию:

    var Translnfo: TTransactionDesc; 
    (...) 
    if Not MyConnection.InTransaction then 
      try 
        MyConnection.StartTransaction(Translnfo); {...} 
        MyConnection.Commit(Translnfo); 
      except 
        MyConnection.Rollback(Translnfo);  
      end; 
