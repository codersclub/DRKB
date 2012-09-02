<h1>Обработка ошибок</h1>
<div class="date">01.01.2007</div>


<p>Для тог, чтобы проинформировать клиентское приложение об ошибке MS SQL Server использует функцию RAISERROR. При этом необходимо помнить, что:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#8226;</td><td>Выполнение процедуры этой функцией не прерывается, транзакции не откатываются. Если в этом есть необходимость &#8211; используйте ROLLBACK или RETURN</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#8226;</td><td>Ошибки с severity ниже 10 являются информационными и не вызывают исключения компонентов работы с данными.</td></tr></table></div>При возникновении ошибки в каком-либо из операторов внутри пакета выполнение пакета продолжается, а функция @@ERROR возвращает код ошибки, который можно обработать.</p>

<pre>
INSERT MyTable (Name) VALUES ('Петров')
IF @@ERROR != 0
  PRINT 'Ошибка вставки'.
</pre>


<p>После успешного оператора @@ERROR возвращает 0, поэтому, если значение ошибки может понадобиться впоследствии &#8211; его надо сохранить в переменной.</p>
<pre>
DECLARE @ErrCode INTEGER

SET @ErrCode = 0

BEGIN TRANSACTION
INSERT MyTable (Name) VALUES ('Иванов')
IF @@ERROR != 0
  @ErrCode = @@ERROR

INSERT MyTable (Name) VALUES ('Петров')
IF @@ERROR != 0
  @ErrCode = @@ERROR

IF @ErrCode = 0
  COMMIT
ELSE BEGIN
  ROLLBACK
  RAISERROR('Не удалось обновить данные', 16, 1)
END
</pre>


<p>Если оператор обновления данных не нашел ни одной записи &#8211; ошибки не возникает. Проверить эту ситуацию можно при помощи функции @@ROWCOUNT, которая возвращает количество записей, обработанных последним оператором.</p>
<pre>
UPDATE MyTable
  SET Name = 'Сидоров'
WHERE Name = 'Петров'

IF @@ROWCOUNT = 0
  PRINT 'Петров не найден'
</pre>


