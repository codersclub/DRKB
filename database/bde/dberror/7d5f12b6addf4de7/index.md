---
Title: Multiple records found, but only one was expected
Author: Nomadic
Date: 01.01.2007
---


Multiple records found, but only one was expected
=================================================

::: {.date}
01.01.2007
:::

Автор: Nomadic

При выполнении некоторых живых запросов, возвращающих единственную
запись, BDE ругается \'multiple records found, but only one was
expected\'.

Запросы вида

    SELECT c, b, a, q FROM T WHERE b = :b

где ключ c, но BDE посчитала ключом a. Интересный запрос, да? Такое
впечатление, что, поскольку ключом в исходной таблице являлась третья
колонка, то Дельфы посчитали ключом третью колонку.

Перестановкой SELECT a, b, c, q\... все исправилось.
Я решил теперь использовать в таких (live) запросах только SELECT \*.
