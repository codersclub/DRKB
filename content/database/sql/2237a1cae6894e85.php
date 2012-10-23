<h1>Локальные операторы языка SQL (BDE)</h1>
<div class="date">01.01.2007</div>



<p>Вывод нужных полей</p>

<pre>SELECT LastName, FirstName, Salary FROM employee
</pre>

<p>Хотим вывести только имя, фамилию и оклад служащих</p>

<p>Вывод всех полей из таблицы</p>

<pre>SELECT * FROM employee
</pre>

<p> * обозначает все поля</p>

<p>Задание псевдонима таблице</p>

<pre>SELECT * FROM employee emp</p>
where emp.salary&gt;35000
</pre>

<p>Таблице employee в качестве псевдонима задано emp</p>
<p>Выводим всех служащих с окладом свыше 35000</p>


<p>Исключение дубликатов</p>
<pre>SELECT DISTINCT Country FROM vendors
</pre>

<p>Хотим узнать из каких стран поставляют продукцию</p>


<p>Постановка условия</p>

<pre>SELECT * FROM vendors</p>
Where Country='Canada'
</pre>

<p>Выводим поставщиков из Канады</p>

<p>Использование логические операторов</p>

<pre>SELECT * FROM vendors</p>
Where Country='U.S.A.' and Preferred='True'
</pre>

<p>Выводим только предпочитаемых поставщиков из США.</p>
<p>Когда используем оператор AND должны удовлетворяться оба условия</p>

<pre>SELECT * FROM animals</p>
Where AREA='South America' or AREA='New Orleans'
</pre>

<p>Хотим видеть только тех животных, которые обитают в Южной Америке или Новом Орлеане Когда используем оператор OR должно удовлетворяться хотя бы одно условие</p>

<pre>SELECT * FROM animals
Where AREA='South America' and not Weight&lt;7
</pre>


<p>Выводим животных, обитающих в Южной Америке с весом не менее 7 кг</p>
<p>Когда используем оператор AND NOT должно удовлетворяться первое условие и не должно - второе</p>

<pre>SELECT * FROM animals
Where Weight&lt;5 or not Weight&lt;10
</pre>


<p>Выводим животных, с весом менее 5 кг или более 10 кг</p>
<p>Когда используем оператор OR NOT должно либо удовлетворяться первое условие, либо не должно - второе</p>


<p>Упорядочивание записей по возрастанию/убыванию/по номеру столбца</p>

<pre>SELECT * FROM animals order by Weight
</pre>

<p>Выводим животных в порядке увеличения веса: сначала самые лёгкие, в конце самые тяжелые</p>

<pre>SELECT * FROM animals order by Weight desc
</pre>


<p>...наоборот - по убыванию</p>

<pre>SELECT * FROM animals order by 3
</pre>

<p>Упорядочить по третьему столбцу (отсчёт начинается с 1 )</p>


<p>Объединение нескольких запросов</p>

<pre>
SELECT * FROM animals
Where Area='South America'
UNION
SELECT * FROM animals
Where Area='New Orleans'
</pre>

<p>Выводим тех животных, которые обитают в Южной Америке, а так же тех, которые обитают в Новом Орлеане Оператором UNION можем объединять несколько запросов</p>


<p>Максимальное/минимальное значение поля</p>

<pre>SELECT MAX(Salary) FROM employee
</pre>

<p>Выводим максимальный оклад из таблицы служащих</p>

<pre>SELECT MIN(Salary) FROM employee
</pre>

<p>Выводим минимальный оклад из таблицы служащих</p>


<p>Сумма всех значений/среднее значение</p>

<pre>SELECT SUM(Salary) FROM employee
</pre>

<p>Так можем узнать сколько получают служащие некой фирмы вместе взятые</p>

<pre>SELECT AVG(Salary) FROM employee
</pre>

<p>Так можем узнать среднестатистический оклад</p>

<p>Количество записей в таблице/в поле</p>

<pre>SELECT COUNT(*) FROM employee
</pre>

<p>Находим количество записей в таблице - в данном случае количество служащих</p>

<pre>SELECT COUNT(*) FROM clients</p>
Where occupation='Programmer'
</pre>

<p>Посчитали сколько человек увлекаются программированием</p>

<p>Группировка записей</p>
<pre>SELECT Continent, MAX(Area) FROM country group by Continent
</pre>

<p>С помощью конструкции "group by" можем узнать какая страна занимает самую большую площадь для каждого континента</p>

<p>Конструкция IN</p>

<pre>select * from Customer</p>
Where Country IN ('US','Canada','Columbia')
</pre>

<p>Выводим покупателей из США, Канады и Колумбии</p>
<pre>select * from Customer
Where Country NOT IN ('US','Canada')
</pre>


<p>Выводим всех покупателей за исключением тех, кто проживает в США, Канаде</p>

<p>Вывод пустых/непустых значений</p>

<pre>select * from Customer</p>
Where State is NULL
</pre>

<p>Выводит те записи, где не введено значение в поле State</p>

<pre>select * from Customer</p>
Where State is NOT NULL
</pre>


<p>Выводит те записи, где введено значение в поле State</p>

<p>Вывод значений приблизительно соответствующих нужным</p>

<pre>select * from employee</p>
Where LastName like 'L%'
</pre>

<p>Выводим только тех служащих, у которых фамилия начинается на букву 'L'. Знак '%' - означает любые символы</p>

<pre>
select * from employee
Where LastName like 'Nels_n'
</pre>

<p>Например, мы не помним: как правильно пишется 'Nelson' или 'Nelsan', тогда нужно будет воспользоваться знаком подчёркивания, который означает любой символ</p>

<p>Диапазон значений</p>

<pre>select * from employee</p>
Where Salary BETWEEN 25000 AND 50000
</pre>

<p>Можем вывести только тех, кто получает от 25000 до 50000 включительно</p>

<p>ANY, SOME, ALL</p>

<pre>SELECT * FROM orders.db</p>
where custno= ANY (select custno from customer.db where city = 'Largo');
</pre>


<p>или</p>
<pre>SELECT * FROM orders.db
where custno= SOME (select custno from customer.db where city = 'Largo');
</pre>


<p>или</p>
<pre>SELECT * FROM orders.db
where custno IN (select custno from customer.db where city = 'Largo');
</pre>

<p>Выводим заказы покупателей из города 'Largo'</p>

<pre>SELECT * FROM clients
where birth_date&gt;All(select birth_date from clients where city='Los Altos')
</pre>

<p>Вывести тех клиентов, которые моложе всех из 'Los Altos'</p>

<p>EXISTS</p>

<pre>SELECT * FROM orders.db</p>
<p>where custno= ANY (select custno from customer where city = 'Largo')</p>
and Exists(SELECT * FROM customer WHERE City='Largo')
</pre>

<p>Выводим заказы покупателей из города 'Largo' если вообще есть покупатели с этого города</p>

<p>Использование параметров</p>

<pre>SELECT * FROM clients</p>
where Last_Name=:LastNameParam
</pre>


<p>Если мы хотим дать возможность пользователю самому указывать фамилию нужного ему клиента. мы вместо значения для поля фамилия указываем параметр. Параметры указываются после двоеточия. И получить доступ к ним можно по индексу из свойства Params компонента Query. Индексация начинается с нуля. Затем, например, по нажатию на кнопке напишем код:</p>
<pre>
Query1.Active:=false;
Query1.Params[0].AsString:=Edit1.Text;
Query1.Active:=true;
</pre>



<p>Вывод дополнительного текста[использование выражений]</p>

<pre>SELECT LastName, Salary/100, '$' FROM employee
</pre>


<p>Если зарплата указана не в долларах, а какой-то другой валюте, курс которой равен 1 к 100, мы можем вывести данные в $, используя вышеуказанное выражение</p>

<p>Использование нескольких таблиц</p>

<pre>SELECT o.orderno,o.AmountPaid, c.Company FROM orders o, customer c</p>
where o.custno=c.custno and c.city='Largo'
</pre>

<p>Выводим номер и сумму заказа из таблицы заказов и компанию сделавшую заказ из таблицы покупателей</p>

<p>Вложенные подзапросы</p>

<pre>SELECT * FROM employee</p>
where Salary=(select MAX(Salary) from employee)
</pre>

<p>Мы научились выводить максимальное значение, например, можем узнать максимальный оклад у служащих, но куда полезнее было бы узнать кто тот счастливчик. Именно здесь используется механизм вложенных подзапросов</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
