---
Title: 14. Запросы на изменение данных
Date: 01.01.2007
Author: Vit
Source: Vingrad.ru <https://forum.vingrad.ru>
---


А как менять значения в базе данных? Тоже при помощи квери это делать
проще и, что важнее, значительно быстрее. Например, меняем в поле
Category все "Cod" на "Kod". В квере пишем текст:

    Update biolife
    Set Category='Kod'
    Where Category='Cod'

Ставим на форму кнопку, в обработчике нажания (onClick) пишем код:

    Query1.ExecSQL;

Важные примечания:

1. Обратите внимание, что в данном случае мы не открываем квери делая
Active:=true и не используем эквивалентный метод Open, а используем
метод ExecSQL. Если открытие квери с оператором Select приводит к
возвращению данных в программу (так называемый курсор данных), то все
остальные типы кверей никаких данных в программу не возвращают - они
выполняют операцию над базой, но не возвращают курсор. Такую кверю
НЕЛЬЗЯ соединить с визуальными компонентами, её открытие хоть и будет
выполнять операцию, будет приводить к исключительной ситуации.

2. Перед изменением текста квери, хоть в дизайне, хоть в run-time кверя
должна быть закрыта.

Аналогичным способом можно пользоваться другими операторами SQL:

- Delete - для удаления нескольких/всех строк
- Insert - для вставки одной или нескольких строк
- Create Table - для создания таблицы
- Alter Table - для изменения структуры таблицы
- Drop Table - для удаления таблицы

и другими.

Смотрите руководства по SQL по использованию этих операторов.
Например, здесь: [Основы языка SQL](/database/sql/sql_basics/)
