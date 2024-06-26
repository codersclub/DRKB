---
Title: Другие особенности Microsoft SQL Server
Date: 01.06.2001
---


Другие особенности Microsoft SQL Server
=======================================

* [Получение уникальных идентификаторов](part6/#part6_1)
* [Временные таблицы](part6/#part6_2)
* [Создание хранимых процедур и триггеров](part6/#part6_3)
* [Кластерные индексы](part6/#part6_4)
* [Определяемые пользователем функции](part6/#part6_5)


## <a name="part6_1"></a> Получение уникальных идентификаторов

Сервер имеет средства для автоматической генерации уникальных
идентификаторов, который могут использоваться в качестве первичного
ключа. В качестве этих значений могут выступать целые числа, либо новый
тип данных UNIQUEIDENTIFIER

Для получения целочисленного уникального идентификатора записи в MSSQL
используется ключевое слово IDENTITY [(seed, increment)].

Здесь: seed - начальное значение,  
increment - приращение.  
По умолчанию seed и increment равны 1

Чтобы создать в таблице автоинкрементный столбец необходимо написать:

     CREATE TABLE TableName (
       Id INTEGER NOT NULL IDENTITY
     )

Только одна колонка в таблице может иметь атрибут IDENTITY. Эта колонка
должна иметь тип  TINYINT, SMALLINT, INT или DECIMAL(p,0) После этого
при вставке новых записей поле Id будет получать новое значение
счетчика. Если таблица имеет поле с установленным IDENTITY, то к этому
полю можно обратиться при помощи ключевого слова IDENTITYCOL, например
запрос

     SELECT IDENTITYCOL FROM TableName

Эквивалентен

     SELECT Id FROM TableName

если поле Id создано с атрибутом IDENTITY

Значение последнего поля с IDENTITY, вставленного текущей сессией можно
получить функцией @@IDENTITY. Например, следующий скрипт добавляет
записи в главную и дочернюю таблицы.

    DECLARE @IdentityValue INTEGER

    INSERT MainTable (Name) VALUES ('Петров')

    SELECT @IdentityValue = @@IDENTITY

    INSERT ChildTable (MainId, Data) VALUES (@IdentityValue, 'Первая')
    INSERT ChildTable (MainId, Data) VALUES (@IdentityValue, 'Вторая')

Обращаю внимание, что если значение ключевого поля нужно для нескольких
вставок, то его необходимо сохранить в переменной, в противном случае,
при наличии у ChildTable своего поля с IDENTITY после первой вставки в
неё @@IDENTITY вернет уже значение для ChildTable.

При использовании вышеописанной техники необходимо соблюдать
осторожность при написании триггеров. Если триггер на MainTable сам
производит вставку в какие-то таблицы с IDENTITY, то после

    INSERT MainTable (Name) VALUES ('Петров')

Функция @@IDENTITY уже не вернет значения для MainTable.

В версии MSSQL 2000 появилась функция SCOPE\_IDENTITY(), которая
аналогична @@IDENTITY, однако возвращает значение, вставленное в
текущем контексте (триггере, хранимой процедуре, пакете команд).
Например, в предыдущем примере SCOPE\_IDENTITY() вернет значение,
вставленное в MainTable, независимо от операций в триггере, поскольку
они выполняются уже не в текущем контексте.

Значения seed и increment можно использовать, например, для
предоставления диапазонов значений первичного ключа в распределенной БД.
Например, один филиал может генерировать значения, начиная с 1, другой с
1 000 000 и т.д.

По умолчанию в поле с IDENTITY не может быть вставлено явное значение.
Однако MS SQL Server позволяет разрешить такую вставку путем установки

    SET IDENTITY_INSERT [database.[owner.]]{table} {ON|OFF}

Вставка может быть разрешена только для одной таблицы в сессии. Если в
таблицу вставляется число, большее максимального значения сервер
использует это число как основу для генерации последующих значений
IDENTITY

Другим способом генерации уникальных идентификаторов, появившемся в MS
SQL 7.0 является тип данных UNIQUEIDENTIFIER. Физически это 16-байтовое
число. Этот тип аналогичен GUID (Global Unique Identifier), активно
использующемся в технологии COM. Над этим типом данных определены только
операции =, \<\>, IS NULL и IS NOT NULL. Сравнение \>, \< и т.п. не
допускается. Для генерации значений используется функция NEWID()

    CREATE TABLE MyUniqueTable (
     UniqueColumn UNIQUEIDENTIFIER DEFAULT NEWID(),
     Characters VARCHAR(10)
    )

    GO

    INSERT INTO MyUniqueTable(Characters) VALUES ('abc')
    INSERT INTO MyUniqueTable VALUES (NEWID(), 'def')

Приведенные операторы вставки эквивалентны и оба создают записи с
уникальными значениями UniqueColumn. Аналогично, значение может быть
предоставлено клиентским приложением функцией CoCreateGUID при помощи
свойства AsGUID классов TField и TParam, без опасения, что оно окажется
неуникальным.




## <a name="part6_2"></a> Временные таблицы


Для промежуточной обработки данных клиентское приложение может создавать
временные таблицы. Временной является таблица, имя которой начинается с
"#" или "##". Таблица, имя которой начинается с # является локальной и
видима только той сессии, в которой она была создана. После завершения
сеанса временные таблицы, созданные им автоматически удаляются. Если
временная таблица создана внутри хранимой процедуры, она автоматически
удаляется по завершению процедуры. Если имя таблицы начинается с ##,
то она является глобальной и видима всеми сессиями. Таблица удаляется
автоматически, когда завершается последняя из использовавших её сессий.

Для примера рассмотрим хранимую процедуру, которая выдает значения
продаж по месяцам. Если в данном месяце продаж не было, выводится имя
месяца и NULL.

    CREATE PROCEDURE AmountsByMonths
    AS BEGIN
     DECLARE @I INTEGER
     CREATE TABLE #Months (
       Id INTEGER,
       Name CHAR(20)
     )
     SET @I = 1
     WHILE (@I <= 12) BEGIN
       INSERT Months (Id, Name) VALUES
         (@I, DATENAME(month, '1998' + REPLACE(STR(@I,2),' ','0')+'01'))
       SET @I = @I + 1
     END
     SELECT M.Name, SUM(P.Amount)
       FROM #Months M INNER JOIN Payment P 
        ON M.Id = DATEPART(month, P.Date)
     DROP TABLE #Months
    END

В версии MSSQL 2000 появилась возможность создавать переменные типа
table, которые представляют собой таблицу. Работа с такой переменной
может выглядеть следующим образом:

    DECLARE @T TABLE (Id INT)

    INSERT @T (Id) VALUES (10250)
    INSERT @T (Id) VALUES (10257)
    INSERT @T (Id) VALUES (10259)

    SELECT O.* 
      FROM Orders O
       INNER JOIN @T AS T ON O.OrderId = T.Id

Использование переменных типа table более предпочтительно, чем
использование временных таблиц, поскольку последние приводят к
невозможности кэширования плана запроса (он генерируется при каждом
выполнении), а в случае переменных этого не происходит.



## <a name="part6_3"></a> Создание хранимых процедур и триггеров

Если логика работы процедуры или триггера требует установки каких-либо
SET-параметров в определенные значения, процедура или триггер могут
установить их внутри своего кода. По завершении их выполнения будут
восстановлены исходные параметры, которые были на сервере до запуска
процедуры или оператора, вызвавшего срабатывание триггера. Исключением
являются SET QUOTED\_IDENTIFIER и SET ANSI\_NULLS для хранимых процедур.
Сервер запоминает их на момент создания процедуры и автоматически
восстанавливает при исполнении.

MS SQL Server использует отложенное разрешение имен объектов и позволяет
создавать процедуры и триггеры, которые ссылаются на объекты, не
существующие при их создании.



## <a name="part6_4"></a> Кластерные индексы

MS SQL Server позволяет иметь в таблице один кластерный (CLUSTERED)
индекс. Данные в таблице физически расположены на нижнем уровне B-дерева
этого индекса, поэтому доступ по нему является самым быстрым. По
умолчанию такой индекс автоматически создается по полю, объявленному
первичным ключом. Все остальные индексы в качестве ссылки на запись
хранят значение кластерного индекса этой записи, поэтому не
рекомендуется строить его по полям большого размера. Также, для
оптимизации операции вставки записей рекомендуется строить этот индекс
по полю с монотонно возрастающими значениями. Исходя из этих
рекомендаций, лучший кандидат на построение кластерного индекса - поле
INTEGER (минимальный размер) IDENTIY (возрастание), объявленное как
первичный ключ (заведомо уникальное, частый доступ по этому индексу).



## <a name="part6_5"></a> Определяемые пользователем функции

В версии MSSQL 2000 появилась возможность создавать в БД функции.
Функции могут быть трех типов:

**Скалярные функции**

Эти функции возвращают скалярную величину. Они аналогичны функциям в
любом языка программирования

    CREATE FUNCTION FirstWord (@S VARCHAR(255))
    RETURNS VARCHAR(255)
    AS
    BEGIN
     DECLARE @I INT
     SET @I = CHARINDEX(' ', @S) 
     RETURN CASE @I WHEN 0 THEN @S
                    ELSE LEFT(@S, @I-1)
            END
    END
    GO

    SELECT dbo.FirstWord ('Hello world !')

**Inline табличные функции**

Эти функции состоят из одного оператора SELECT и возвращают его
результат в виде таблицы

    CREATE FUNCTION OrdersByCustomer (@S VARCHAR(255))
    RETURNS TABLE 
    AS
      RETURN SELECT * FROM Orders WHERE CustomerId = @S
    GO

    SELECT * 
      FROM OrdersByCustomer('VINET') AS T
        INNER JOIN [Order Details] OD ON OD.OrderId = T.OrderId

**Многооператорные табличные функции**

Эти функции наиболее интересны, поскольку позволяют динамически
сформировать таблицу с требуемыми данными, которую затем можно
использовать в запросе

В качестве примера рассмотрим функцию, генерирующую таблицу, содержащую
номера и названия месяцев года. Параметр позволяет сгенерировать эту
таблицу за один квартал.

    CREATE FUNCTION Months (@Quoter INT)
    RETURNS @table_var TABLE 
            (Id int, 
             Name VARCHAR(20))
    AS
    BEGIN
     DECLARE @Start INTEGER, @End INTEGER

     SET @Start = CASE 
       WHEN @Quoter = 2 THEN 4
       WHEN @Quoter = 3 THEN 7
       WHEN @Quoter = 4 THEN 10
       ELSE 1
     END

     SET @End = CASE 
       WHEN @Quoter = 1 THEN 3
       WHEN @Quoter = 2 THEN 6
       WHEN @Quoter = 3 THEN 9
       ELSE 12
     END

     WHILE (@Start <= @End) BEGIN
       INSERT @table_var (Id, Name) VALUES
         (@Start, DATENAME(month, '1998' + REPLACE(STR(@Start,2),' ','0')+'01'))
       SET @Start = @Start + 1
     END

     RETURN 
    END
    GO

    SELECT T.Name, SUM(O.Freight) 
     FROM dbo.Months(NULL) AS T
       INNER JOIN Orders O ON DATEPART(month, O.OrderDate) = T.Id
    GROUP BY T.Name

Также, при помощи подобных функций можно легко раскрывать иерархии и
выполнять прочие задачи, которые в предыдущих версиях сервера требовали
временных таблиц.
