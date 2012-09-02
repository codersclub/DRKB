<h1>Определяемые пользователем функции</h1>
<div class="date">01.01.2007</div>


<p>В версии MSSQL 2000 появилась возможность создавать в БД функции. Функции могут быть трех типов:</p>

<p>Скалярные функции</p>
<p>Эти функции возвращают скалярную величину. Они аналогичны функциям в любом языка программирования</p>
<pre>
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
</pre>


<p>Inline табличные функции</p>

<p>Эти функции состоят из одного оператора SELECT и возвращают его результат в виде таблицы</p>
<pre>
CREATE FUNCTION OrdersByCustomer (@S VARCHAR(255))
RETURNS TABLE 
AS
  RETURN SELECT * FROM Orders WHERE CustomerId = @S
GO

SELECT * 
  FROM OrdersByCustomer('VINET') AS T
    INNER JOIN [Order Details] OD ON OD.OrderId = T.OrderId
</pre>


<p>Многооператорные табличные функции</p>
<p>Эти функции наиболее интересны, поскольку позволяют динамически сформировать таблицу с требуемыми данными, которую затем можно использовать в запросе</p>
<p>В качестве примера рассмотрим функцию, генерирующую таблицу, содержащую номера и названия месяцев года. Параметр позволяет сгенерировать эту таблицу за один квартал.</p>
<pre>
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

 WHILE (@Start &lt;= @End) BEGIN
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
</pre>


<p>Также, при помощи подобных функций можно легко раскрывать иерархии и выполнять прочие задачи, которые в предыдущих версиях сервера требовали временных таблиц.</p>

