---
Title: Локальные операторы языка SQL (BDE)
Date: 01.01.2007
---


Локальные операторы языка SQL (BDE)
===================================

::: {.date}
01.01.2007
:::

Вывод нужных полей

    SELECT LastName, FirstName, Salary FROM employee

Хотим вывести только имя, фамилию и оклад служащих

Вывод всех полей из таблицы

    SELECT * FROM employee

\* обозначает все поля

Задание псевдонима таблице

    SELECT * FROM employee emp
    where emp.salary>35000

Таблице employee в качестве псевдонима задано emp

Выводим всех служащих с окладом свыше 35000

Исключение дубликатов

    SELECT DISTINCT Country FROM vendors

Хотим узнать из каких стран поставляют продукцию

Постановка условия

    SELECT * FROM vendors
    Where Country='Canada'

Выводим поставщиков из Канады

Использование логические операторов

    SELECT * FROM vendors
    Where Country='U.S.A.' and Preferred='True'

Выводим только предпочитаемых поставщиков из США.

Когда используем оператор AND должны удовлетворяться оба условия

    SELECT * FROM animals
    Where AREA='South America' or AREA='New Orleans'

Хотим видеть только тех животных, которые обитают в Южной Америке или
Новом Орлеане Когда используем оператор OR должно удовлетворяться хотя
бы одно условие

    SELECT * FROM animals
    Where AREA='South America' and not Weight<7

Выводим животных, обитающих в Южной Америке с весом не менее 7 кг

Когда используем оператор AND NOT должно удовлетворяться первое условие
и не должно - второе

    SELECT * FROM animals
    Where Weight<5 or not Weight<10

Выводим животных, с весом менее 5 кг или более 10 кг

Когда используем оператор OR NOT должно либо удовлетворяться первое
условие, либо не должно - второе

Упорядочивание записей по возрастанию/убыванию/по номеру столбца

    SELECT * FROM animals order by Weight

Выводим животных в порядке увеличения веса: сначала самые лёгкие, в
конце самые тяжелые

    SELECT * FROM animals order by Weight desc

...наоборот - по убыванию

    SELECT * FROM animals order by 3

Упорядочить по третьему столбцу (отсчёт начинается с 1 )

Объединение нескольких запросов

    SELECT * FROM animals
    Where Area='South America'
    UNION
    SELECT * FROM animals
    Where Area='New Orleans'

Выводим тех животных, которые обитают в Южной Америке, а так же тех,
которые обитают в Новом Орлеане Оператором UNION можем объединять
несколько запросов

Максимальное/минимальное значение поля

    SELECT MAX(Salary) FROM employee

Выводим максимальный оклад из таблицы служащих

    SELECT MIN(Salary) FROM employee

Выводим минимальный оклад из таблицы служащих

Сумма всех значений/среднее значение

    SELECT SUM(Salary) FROM employee

Так можем узнать сколько получают служащие некой фирмы вместе взятые

    SELECT AVG(Salary) FROM employee

Так можем узнать среднестатистический оклад

Количество записей в таблице/в поле

    SELECT COUNT(*) FROM employee

Находим количество записей в таблице - в данном случае количество
служащих

    SELECT COUNT(*) FROM clients
    Where occupation='Programmer'

Посчитали сколько человек увлекаются программированием

Группировка записей

    SELECT Continent, MAX(Area) FROM country group by Continent

С помощью конструкции \"group by\" можем узнать какая страна занимает
самую большую площадь для каждого континента

Конструкция IN

    select * from Customer
    Where Country IN ('US','Canada','Columbia')

Выводим покупателей из США, Канады и Колумбии

    select * from Customer
    Where Country NOT IN ('US','Canada')

Выводим всех покупателей за исключением тех, кто проживает в США, Канаде

Вывод пустых/непустых значений

    select * from Customer
    Where State is NULL

Выводит те записи, где не введено значение в поле State

    select * from Customer
    Where State is NOT NULL

Выводит те записи, где введено значение в поле State

Вывод значений приблизительно соответствующих нужным

    select * from employee
    Where LastName like 'L%'

Выводим только тех служащих, у которых фамилия начинается на букву
\'L\'. Знак \'%\' - означает любые символы

    select * from employee
    Where LastName like 'Nels_n'

Например, мы не помним: как правильно пишется \'Nelson\' или \'Nelsan\',
тогда нужно будет воспользоваться знаком подчёркивания, который означает
любой символ

Диапазон значений

    select * from employee
    Where Salary BETWEEN 25000 AND 50000

Можем вывести только тех, кто получает от 25000 до 50000 включительно

ANY, SOME, ALL

    SELECT * FROM orders.db
    where custno= ANY (select custno from customer.db where city = 'Largo');

или

    SELECT * FROM orders.db
    where custno= SOME (select custno from customer.db where city = 'Largo');

или

    SELECT * FROM orders.db
    where custno IN (select custno from customer.db where city = 'Largo');

Выводим заказы покупателей из города \'Largo\'

    SELECT * FROM clients
    where birth_date>All(select birth_date from clients where city='Los Altos')

Вывести тех клиентов, которые моложе всех из \'Los Altos\'

EXISTS

    SELECT * FROM orders.db
    where custno= ANY (select custno from customer where city = 'Largo')
    and Exists(SELECT * FROM customer WHERE City='Largo')

Выводим заказы покупателей из города \'Largo\' если вообще есть
покупатели с этого города

Использование параметров

    SELECT * FROM clients
    where Last_Name=:LastNameParam

Если мы хотим дать возможность пользователю самому указывать фамилию
нужного ему клиента. мы вместо значения для поля фамилия указываем
параметр. Параметры указываются после двоеточия. И получить доступ к ним
можно по индексу из свойства Params компонента Query. Индексация
начинается с нуля. Затем, например, по нажатию на кнопке напишем код:

    Query1.Active:=false;
    Query1.Params[0].AsString:=Edit1.Text;
    Query1.Active:=true;

Вывод дополнительного текста\[использование выражений\]

    SELECT LastName, Salary/100, '$' FROM employee

Если зарплата указана не в долларах, а какой-то другой валюте, курс
которой равен 1 к 100, мы можем вывести данные в \$, используя
вышеуказанное выражение

Использование нескольких таблиц

    SELECT o.orderno,o.AmountPaid, c.Company FROM orders o, customer c
    where o.custno=c.custno and c.city='Largo'

Выводим номер и сумму заказа из таблицы заказов и компанию сделавшую
заказ из таблицы покупателей

Вложенные подзапросы

    SELECT * FROM employee
    where Salary=(select MAX(Salary) from employee)

Мы научились выводить максимальное значение, например, можем узнать
максимальный оклад у служащих, но куда полезнее было бы узнать кто тот
счастливчик. Именно здесь используется механизм вложенных подзапросов

Взято с <https://delphiworld.narod.ru>
