<h1>Как вернуть результат в виде XML?</h1>
<div class="date">01.01.2007</div>


<p>В MSSQL 2000 можно в запросе указать выражение FOR XML, в результате чего будет возвращена строка, содержащая XML представление выборки. Например, запрос:</p>

<pre>SELECT O.OrderID, O.CustomerID, O.OrderDate, 
  O.ShipName, O.ShipAddress, O.ShipCity, O.ShipRegion, 
  P.ProductName, OD.UnitPrice, OD.Quantity
  FROM Orders O
    INNER JOIN [Order Details] OD ON O.OrderId = OD.OrderId
    INNER JOIN Products P ON OD.ProductId = P.ProductId
WHERE O.OrderId = '10248' 
FOR XML AUTO
</pre>

<p>Вернет результат:</p>

<pre>
&lt;O OrderID="10248" 
   CustomerID="VINET" 
   OrderDate="1996-07-04T00:00:00" 
   ShipName="Vins et alcools Chevalier" 
   ShipAddress="59 rue de l&amp;apos;Abbaye" 
   ShipCity="Reims"&gt;
   &lt;P ProductName="Queso Cabrales"&gt;
     &lt;OD UnitPrice="14.0000" Quantity="12"/&gt;
   &lt;/P&gt;
   &lt;P ProductName="Singaporean Hokkien Fried Mee"&gt;
     &lt;OD UnitPrice="9.8000" Quantity="10"/&gt;
   &lt;/P&gt;
   &lt;P ProductName="Mozzarella di Giovanni"&gt;
     &lt;OD UnitPrice="34.8000" Quantity="5"/&gt;
   &lt;/P&gt;
&lt;/O&gt;
</pre>

<p>Возможно как автоматическое форматирование XML результатов запроса, так и задание способа форматирования программистом.</p>
<p>Кроме этого возможно использование XML данных в качестве таблицы в запросе. В качестве примера рассмотрим хранимую процедуру, выдающую данные по заранее неизвестному количеству записей. Идентификаторы записей передаются в неё в виде XML-документа</p>

<pre>CREATE PROCEDURE XMLParam 
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
</pre>

<p>Вызов этой процедуры выглядит следующим образом:</p>

<pre>
DECLARE @S VARCHAR(8000)
SET @S = '&lt;ROOT&gt;
&lt;Ids ID="10250"/&gt;
&lt;Ids ID="10257"/&gt;
&lt;Ids ID="10258"/&gt;
&lt;/ROOT&gt;'
 
EXECUTE XMLParam @S
</pre>


<p>Очевидно, что соответствующая строка параметров может быть легко построена и клиентским приложением.</p>

<p>Тенцер А. Л.</p>
<p>ICQ UIN 15925834</p>
<p>tolik@katren.nsk.ru</p>
<hr />
<p class="author">Автор: Vit</p>

<pre>
Select * From MyTable For XML  AUTO, ELEMENTS
</pre>

