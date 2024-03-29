---
Title: 13. Запросы на выбор данных
Date: 01.01.2007
Author: Vit
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Теперь покажу на примере как можно использовать квери для наиболее
простых, но очень частых и нужных операций:

1. Выбор только тех строк (записей) которые отвечают условию (например
тех где в поле category записано \'Snapper\')

        SELECT * FROM biolife 
        where category='Snapper' 

2. Выбор только нужных столбцов (например нам нужны только столбцы
Category и common\_name )

        SELECT Category, common_name FROM biolife 

3. Выбор записей отсортированных в определённом порядке (например в
алфавитном порядке поля Category)

        SELECT * FROM biolife 
        Order by Category

4. Запрос может комбинировать в себе всё перечисленное

        SELECT Category, common_name FROM biolife 
        where category='Snapper' 
        Order by common_name 

Попробуйте задать каждый из этих запросов и посмотреть как программа
будет реагировать на него. На самом деле запросы предоставляют гораздо
большии возможности - например суммарные и статистические функции
(вычислить сумму всех значений поля), вычисляемые поля (например
добавить столбец который отражает не реальное поле в таблице, а сумму 2х
других полей), объединение нескольких таблиц в одном запросе (2 таблицы
с похожей структурой представляются как одна таблица), запросы на
несколько таблиц (например вам надо выбрать всех из одной таблицы
которые не встречаются в другой таблице, или для Иванова взять его номер
телефона из одной таблицы, а его заказы из другой и т.п.).

Всё это вы найдёте в статье:
[Основы языка SQL](/database/sql/sql_basics/),
а здесь я только показываю, как с этим можно работать из Дельфи.
