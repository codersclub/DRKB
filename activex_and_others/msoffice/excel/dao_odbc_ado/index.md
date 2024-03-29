---
Title: Через DAO/ODBC/ADO
Author: Vit
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Через DAO/ODBC/ADO
==================

Чтобы использовать только стандартные компоненты давайте попробуем
работать с Excel через ADO. Это не самый быстрый и далеко не первый по
возможностям метод (DAO работает на порядок быстрее и предоставляет куда
больше возможностей), но ADO компоненты входят в стандартную поставку 5
и 6 Дельфи. Итак заходим в Панель управления Windows, идем в свойства
ODBC, делаем DSN используя Excel драйвер, не забываем указать в
свойствах на файл Excel. Закрываем ODBC, открываем Дельфи. Ставим на
форму ADOConnection. Идем в ConnectionString, строим строку подключения:
надо выбрать только ODBC провайдер и на следующей вкладке указать
сделанный DSN, остальные опции в большинстве случаев можно оставить как
есть. Строка получена. Кстати ее можно вообще упростить до вида:
"DSN=MyDsn".

Теперь вам доступны листы файла как таблицы а весь файл
как база данных.

Подключаем ADOQuery к ADOConnection. Cоздаем таблицу,
т.е. новый лист - путем запуска следующей квери:

    Create Table MyTable1 (
    Field1 varchar(20),
    Field2 varchar(10) )

Снова переходим в дизайн - ставим на форму ADOTable, указываем как
Connection наш компонент с ADOConnection, теперь если кликнуть на
свойстве TableName - вы сможете увидеть в списке сделанную нами таблицу
"MyTable1". Соедините таблицу с DBGrid - убедитесь что работа с
таблицей в Excel мало отличается от работы с другими базами данных.

