<h1>Обработка транзакций</h1>
<div class="date">01.01.2007</div>


<p>В MS SQL Server поддерживаются все определенные стандартом ANSI SQL 92 уровни изоляции транзакций:</p>

READ UNCOMMITTED        Позволяет транзакции читать неподтвержденные данные, других транзакций.       
READ COMMITTED        Предотвращает считывание транзакцией данных, не подтвержденных другой транзакцией       
REPEATABLE READ        Все блокировки удерживаются до конца транзакции, гарантируя идентичность повторно считанных данных прочитанным ранее.       
SERIALIZABLE        Гарантирует отсутствие «фантомов». Реализуется за блокирования диапазонов записей, внутри которых эти «фантомы» могут появиться.       
<p>Для установки текущего уровня изоляции используется оператор</p>

<pre>
SET TRANSACTION ISOLATION LEVEL
    {
        READ COMMITTED 
         READ UNCOMMITTED 
         REPEATABLE READ 
         SERIALIZABLE
    }
</pre>


<p>Момент начала транзакции регулируется установкой</p>
<pre>SET IMPLICIT_TRANSACTION ON|OFF
</pre>


<p>По умолчанию она установлена в ON, и каждый оператор выполняется в отдельной транзакции. По его завершении неявно выполняется COMMIT. Если необходимо выполнить транзакцию, состоящую из нескольких операторов её надо явно начать командой BEGIN TRANSACTION. Заканчивается транзакция операторами COMMIT или ROLLBACK.</p>

<p>Например:</p>
<pre>INSERT MyTable VALUES (1)
-- Выполнился внутри отдельной транзакции
BEGIN TRANSACTION
-- Начали явную транзакцию
INSERT MyTable VALUES (2) 
INSERT MyTable VALUES (3) 
COMMIT
-- завершили явную транзакцию
</pre>


<p>Если выдать команду</p>
<pre>SET IMPLICIT_TRANSACTION OFF
</pre>


<p>то сервер начинает новую транзакцию, если она еще не начата и выполнился один из следующих операторов:</p>
ALTER TABLE        FETCH        REVOKE       
CREATE        GRANT        SELECT       
DELETE        INSERT        TRUNCATE TABLE       
DROP        OPEN        UPDATE       
<p>Транзакция продолжается до тех пор, пока не будет выдана команда COMMIT или ROLLBACK.</p>

<p>Возможно создание вложенных транзакций. При этом функция @@TRANCOUNT показывает глубину вложенности транзакции. Например:</p>
<pre>BEGIN TRANSACTION
 SELECT @@TRANCOUNT  -- Выдаст 1
 BEGIN TRANSACTION
 SELECT @@TRANCOUNT  -- Выдаст 2
 COMMIT
 SELECT @@TRANCOUNT  -- Выдаст 1
COMMIT
SELECT @@TRANCOUNT  -- Выдаст 0
</pre>


<p>Вложенный BEGIN TRANSACTION не начинает новую транзакцию. Он лишь увеличивает @@TRANCOUNT на 1. Аналогично, Вложенный оператор COMMIT не завершает транзакцию, а лишь уменьшает @@TRANCOUNT на 1. Реальное завершение транзакции происходит, когда @@TRANCOUNT становится равным 0. Такой механизм позволяет писать хранимые процедуры, содержащие транзакцию, например:</p>
<pre>CREATE PROCEDURE Foo 
AS BEGIN
  BEGIN TRANSACTION
  INSERT MyTable VALUES (1)
  INSERT MyTable VALUES (1)
  COMMIT
END
</pre>


<p>При запуске вне контекста транзакции процедура выполнит свою транзакцию. Если она запущена внутри транзакции - внутренние BEGIN TRANSACTION и COMMIT просто увеличат и уменьшат счетчик транзакций.</p>
<p>Поведение ROLLBACK отличается от вышеописанного. ROLLBACK всегда, независимо от текущего уровня вложенности устанавливает @@TRANCOUNT в 0 и отменяет все изменения, начиная с начала самой внешней транзакции. Если в хранимой процедуре возможен откат её действий, исходя из какого-то условия, можно использовать точки сохранения (savepoint)</p>
<pre>CREATE PROCEDURE Foo 
AS BEGIN
  BEGIN TRANSACTION
  -- Этот оператор не может быть отменен вне контекста
  -- основной транзакции
  INSERT MyTable VALUES (1)
   SAVE TRANSACTION InsideFoo
    -- Операторы, начиная отсюда могут быть отменены
    -- без отката основной транзакции
    INSERT MyTable VALUES (2)
    INSERT MyTable VALUES (3)
    IF (SELECT COUNT(*) FROM MyTable) &gt; 3
      ROLLBACK TRANSACTION InsideFoo
      -- Отменяем изменения, внесенные после
      -- последнего savepoint
  COMMIT
END
</pre>


<p>Отдельного обсуждения заслуживает ROLLBACK вызванный в триггере.</p>
<p>В этом случае не только откатывается транзакция, в рамках которой произошло срабатывание триггера, но и прекращается выполнение пакета команд, внутри которого это произошло. Все операторы, следующие за оператором, вызвавшим триггер, не будут выполнены. Рассмотрим эту ситуацию на примере:</p>
<pre>CREATE TABLE MyTable (Id INTEGER)

GO

CREATE TRIGGER MyTrig ON MyTable FOR INSERT 
AS BEGIN
  IF (SELECT MAX(Id) FROM Inserted) &gt;= 2 BEGIN
    ROLLBACK
    RAISERROR('Id &gt;= 2', 17, 1)
  END
END

GO

INSERT MyTable VALUES (1)
INSERT MyTable VALUES (2) - Вызовет ROLLBACK в триггере
-- Операторы, начиная отсюда не выполнятся
INSERT MyTable VALUES (3)
INSERT MyTable VALUES (4)
</pre>


