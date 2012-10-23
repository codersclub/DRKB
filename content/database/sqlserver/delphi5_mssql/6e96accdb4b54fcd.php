<h1>Советы по работе с MS SQL Server</h1>
<div class="date">01.01.2007</div>


<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>Устанавливайте SET NOCOUNT ON. При установке OFF после каждого оператора сервер посылает клиенту сообщение DONE_IN_PROC с количеством обработанных записей. Запретив это, Вы кардинально сократите сетевой трафик и существенно увеличите производительность.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>При необходимости изменить режим блокирования какой-либо таблицы без изменения уровня изоляции транзакций используйте подсказки режима блокирования. Например, в следующем примере оператор SELECT накладывает на запись, предотвращая изменение её другими сессиями до окончания транзакции, несмотря на то, что установленный уровень изоляции не предусматривает этого:</td></tr></table></div>
<pre>
SET TRANSACTION ISOLATION LEVEL READ COMMITED

BEGIN TRANSACTION
  SELECT * FROM City 
 &nbsp; WHERE Name = 'Ленинград' 
 &nbsp; WITH (HOLDLOCK)
  -- Какие-то операторы, во время их выполнения
  -- запись остается заблокированной
  UPDATE City 
 &nbsp;&nbsp;&nbsp; SET Name = 'Санкт-Петербург' 
 &nbsp; WHERE Name = 'Ленинград'
COMMIT
</pre>


<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>Явно указывайте параметры в запросах. Это поможет серверу более эффективно кэшировать планы выполнения. При динамическом формировании текста запроса не подставляйте параметры в текст, а используйте хранимую процедуру sp_executesql</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>Не начинайте названия своих хранимых процедур с префикса «sp_». Сервер ищет процедуры с такими именами в первую очередь в базе данных Master, а затем уже в текущей БД. Это приводит к дополнительным накладным расходам.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>Если Ваше приложение интенсивно использует базу данных tempdb (например, создает много временных таблиц) &#8211; увеличьте её минимальный размер. В противном случае при старте сервера создается tempdb малого размера, которая затем динамически расширяется, непроизводительно загружая компьютер.</td></tr></table></div>
