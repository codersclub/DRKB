<h1>Получение уникальных идентификаторов</h1>
<div class="date">01.01.2007</div>


<p>Сервер имеет средства для автоматической генерации уникальных идентификаторов, который могут использоваться в качестве первичного ключа. В качестве этих значений могут выступать целые числа, либо новый тип данных UNIQUEIDENTIFIER</p>
<p>Для получения целочисленного уникального идентификатора записи в MSSQL используется ключевое слово IDENTITY [(seed, increment)].</p>
<p>Здесь:</p>
 seed &#8211; начальное значение</p>
 increment &#8211; приращение</p>
<p>По умолчанию seed и increment равны 1</p>
<p>Чтобы создать в таблице автоинкрементный столбец необходимо написать:</p>

<pre>
 CREATE TABLE TableName (
 &nbsp; Id INTEGER NOT NULL IDENTITY
 )
</pre>


<p>Только одна колонка в таблице может иметь атрибут IDENTITY. Эта колонка должна иметь тип&nbsp; TINYINT, SMALLINT, INT или DECIMAL(p,0) После этого при вставке новых записей поле Id будет получать новое значение счетчика. Если таблица имеет поле с установленным IDENTITY, то к этому полю можно обратиться при помощи ключевого слова IDENTITYCOL, например запрос</p>
<pre>
 SELECT IDENTITYCOL FROM TableName
</pre>


<p>Эквивалентен</p>
<pre>
 SELECT Id FROM TableName
</pre>


<p>если поле Id создано с атрибутом IDENTITY</p>
<p>Значение последнего поля с IDENTITY, вставленного текущей сессией можно получить функцией @@IDENTITY. Например, следующий скрипт добавляет записи в главную и дочернюю таблицы.</p>
<pre>
DECLARE @IdentityValue INTEGER

INSERT MainTable (Name) VALUES ('Петров')

SELECT @IdentityValue = @@IDENTITY

INSERT ChildTable (MainId, Data) VALUES (@IdentityValue, 'Первая')
INSERT ChildTable (MainId, Data) VALUES (@IdentityValue, 'Вторая')
</pre>


<p>Обращаю внимание, что если значение ключевого поля нужно для нескольких вставок, то его необходимо сохранить в переменной, в противном случае, при наличии у ChildTable своего поля с IDENTITY после первой вставки в неё @@IDENTITY вернет уже значение для ChildTable.</p>
<p>При использовании вышеописанной техники необходимо соблюдать осторожность при написании триггеров. Если триггер на MainTable сам производит вставку в какие-то таблицы с IDENTITY, то после </p>
<p>INSERT MainTable (Name) VALUES ('Петров')</p>
<p>Функция @@IDENTITY уже не вернет значения для MainTable.</p>
<p>В версии MSSQL 2000 появилась функция SCOPE_IDENTITY(), которая аналогична @@IDENTITY, однако возвращает значение, вставленное в текущем контексте (триггере, хранимой процедуре, пакете команд). Например, в предыдущем примере SCOPE_IDENTITY() вернет значение, вставленное в MainTable, независимо от операций в триггере, поскольку они выполняются уже не в текущем контексте.</p>
<p>Значения seed и increment можно использовать, например, для предоставления диапазонов значений первичного ключа в распределенной БД. Например, один филиал может генерировать значения, начиная с 1, другой с 1 000 000 и т.д.</p>
<p>По умолчанию в поле с IDENTITY не может быть вставлено явное значение. Однако MS SQL Server позволяет разрешить такую вставку путем установки</p>
<p> SET IDENTITY_INSERT [database.[owner.]]{table} {ON|OFF}</p>
<p>Вставка может быть разрешена только для одной таблицы в сессии. Если в таблицу вставляется число, большее максимального значения сервер использует это число как основу для генерации последующих значений IDENTITY</p>
<p>Другим способом генерации уникальных идентификаторов, появившемся в MS SQL 7.0 является тип данных UNIQUEIDENTIFIER. Физически это 16-байтовое число. Этот тип аналогичен GUID (Global Unique Identifier), активно использующемся в технологии COM. Над этим типом данных определены только операции =, &lt;&gt;, IS NULL и IS NOT NULL. Сравнение &gt;, &lt; и т.п. не допускается. Для генерации значений используется функция NEWID()</p>
<pre>
CREATE TABLE MyUniqueTable (
 UniqueColumn UNIQUEIDENTIFIER DEFAULT NEWID(),
 Characters VARCHAR(10)
)

GO

INSERT INTO MyUniqueTable(Characters) VALUES ('abc')
INSERT INTO MyUniqueTable VALUES (NEWID(), 'def')
</pre>


<p>Приведенные операторы вставки эквивалентны и оба создают записи с уникальными значениями UniqueColumn. Аналогично, значение может быть предоставлено клиентским приложением функцией CoCreateGUID при помощи свойства AsGUID классов TField и TParam, без опасения, что оно окажется неуникальным.</p>

