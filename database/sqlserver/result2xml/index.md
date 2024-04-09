---
Title: Как вернуть результат в виде XML?
Author: Vit
Date: 01.01.2007
---


Как вернуть результат в виде XML?
=================================

Вариант 1:

Author: Тенцер А. Л., tolik@katren.nsk.ru

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

Тенцер А. Л.  
ICQ UIN 15925834  
tolik@katren.nsk.ru

------------------------------------------------------------------------

Вариант 2:

Author: Vit

Просто используйте SQL запрос:

    Select * From MyTable For XML  AUTO, ELEMENTS
