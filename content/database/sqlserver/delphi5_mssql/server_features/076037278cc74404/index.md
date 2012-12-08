---
Title: SELECT
Date: 01.01.2007
---


SELECT
======

::: {.date}
01.01.2007
:::

В ранних версиях внешнее объединение таблиц задавалось выражением \*= и
=\* во фразе WHERE. Этот синтаксис поддерживается, но не рекомендуется и
будет исключен в будущих версиях. Начиная с версии 6.5, сервер
поддерживает стандартный синтаксис {LEFT\|RIGHT\|FULL} \[OUTER\] JOIN.

Функция IDENTITY(data\_type\[, seed, increment\]) позволяет при
выполнении SELECT в таблицу (SELECT INTO) создать в этой таблице
автоинкрементное поле IDENTITY и заполнить его. При помощи этой функции
и временных таблиц можно пронумеровать результаты запроса.

    SELECT IDENTITY(INTEGER, 1, 1) AS Counter, Name
    INTO #Temp
    FROM MyTable
    ORDER BY Name<

    SELECT * FROM #Temp

Начиная с версии 7.0, оператор SELECT имеет модификаторы TOP n
\[PERSENT\] \[WITH TIES\], позволяющие вывести первые n записей или n
процентов записей. Указав WITH TIES можно заставить сервер включить в
результат все записи с таким же значением сортируемого поля, как и у
последней из n записи. Если SELECT не имеет фразы ORDER BY, то набор
записей не обязательно будет один и тот же.

В качестве одной из таблиц в запросе можно использовать вложенный
запрос:

    SELECT A.Name, A.Population, B.AvgPop
      FROM City A INNER JOIN
       (SELECT Country, AVG(Population) AS AvgPop 
          FROM City GROUP BY Country ) AS B
        ON A.Country = B.Country

Этот запрос для каждого города выведет его название, количество жителей
и среднее количество жителей на город в стране, в которой он находится.

Функции OPENQUERY и OPENROWSET позволяют использовать в качестве одной
из таблиц в запросе выборку из любого OLE DB совместимого источника
данных.

В MSSQL 2000 можно в запросе указать выражение FOR XML, в результате
чего будет возвращена строка, содержащая XML представление выборки.
Например, запрос:

    SELECT O.OrderID, O.CustomerID, O.OrderDate, 
      O.ShipName, O.ShipAddress, O.ShipCity, O.ShipRegion, 
      P.ProductName, OD.UnitPrice, OD.Quantity
      FROM Orders O
        INNER JOIN [Order Details] OD ON O.OrderId = OD.OrderId
        INNER JOIN Products P ON OD.ProductId = P.ProductId
    WHERE O.OrderId = '10248' 
    FOR XML AUTO

Вернет результат:

    <O OrderID="10248" 
       CustomerID="VINET" 
       OrderDate="1996-07-04T00:00:00" 
       ShipName="Vins et alcools Chevalier" 
       ShipAddress="59 rue de l&apos;Abbaye" 
       ShipCity="Reims">
       <P ProductName="Queso Cabrales">
         <OD UnitPrice="14.0000" Quantity="12"/>
       </P>
       <P ProductName="Singaporean Hokkien Fried Mee">
         <OD UnitPrice="9.8000" Quantity="10"/>
       </P>
       <P ProductName="Mozzarella di Giovanni">
         <OD UnitPrice="34.8000" Quantity="5"/>
       </P>
    </O>

Возможно как автоматическое форматирование XML результатов запроса, так
и задание способа форматирования программистом.

Кроме этого возможно использование XML данных в качестве таблицы в
запросе. В качестве примера рассмотрим хранимую процедуру, выдающую
данные по заранее неизвестному количеству записей. Идентификаторы
записей передаются в неё в виде XML-документа

    CREATE PROCEDURE XMLParam 
     @Ids VARCHAR(8000)
    AS
     DECLARE @idoc int
     EXEC sp_xml_preparedocument @idoc OUTPUT, @Ids
     SELECT O.* 
       FROM Orders O
        INNER JOIN OPENXML (@idoc, '/ROOT/Ids', 1) WITH (ID INT) AS T ON 
     .OrderId = T.Id
     EXEC sp_xml_removedocument @idoc
    GO

Вызов этой процедуры выглядит следующим образом:

    DECLARE @S VARCHAR(8000)

    SET @S = '<ROOT>
    <Ids ID="10250"/>
    <Ids ID="10257"/>
    <Ids ID="10258"/>
    </ROOT>'

    EXECUTE XMLParam @S

Очевидно, что соответствующая строка параметров может быть легко
построена и клиентским приложением.
