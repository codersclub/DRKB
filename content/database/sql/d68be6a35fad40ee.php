<h1>Основы языка SQL (статья)</h1>
<div class="date">01.01.2007</div>


SQL (обычно&nbsp; произносимый как "СИКВЭЛ" или "ЭСКЮЭЛЬ") символизирует собой Структурированный Язык Запросов. Это - язык, который дает Вам возможность создавать и работать в реляционных базах данных, являющихся наборами связанной информации, сохраняемой в таблицах.</p>
&nbsp;</p>
Информационное пространство становится более унифицированным. Это привело к необходимости создания стандартного языка, который мог бы использоваться в большом количестве различных видов компьютерных сред. Стандартный язык позволит пользователям, знающим один набор команд, использовать их для создания, нахождения, изменения и передачи информации - независимо от того, работают ли они на персональном компьютере, сетевой рабочей станции, или на универсальной ЭВМ.</p>
В нашем все более и более взаимосвязанном компьютерном мире, пользователь снабженый таким языком, имеет огромное преимущество в использовании и обобщении информации из ряда источников с помощью большого количества способов.</p>
Элегантность и независимость от специфики компьютерных технологий, а также его поддержка лидерами промышленности в области технологии реляционных баз данных, сделало SQL (и, вероятно, в течение обозримого будущего оставит его) основным стандартным языком. По этой причине, любой, кто хочет работать с базами данных 90-х годов, должен знать SQL.</p>
&nbsp;</p>
Стандарт SQL определяется ANSI (Американским Национальным Институтом Стандартов) и в данное время также принимается ISO (Международной Организацией по Стандартизации). Однако, большинство коммерческих программ баз данных расширяют SQL без уведомления ANSI, добавляя различные особенности в этот язык, которые, как они считают, будут весьма полезны. Иногда они несколько нарушают стандарт языка, хотя хорошие идеи имеют тенденцию развиваться и вскоре становиться стандартами "рынка" сами по себе в силу полезности своих качеств.</p>
На данном уроке мы будем, в основном, следовать стандарту ANSI, но одновременно иногда будет показывать и некоторые наиболее общие отклонения от его стандарта.</p>
Точное описание особенностей языка приводится в документации на СУБД, которую Вы используете. SQL системы InterBase 4.0 соответствует стандарту ANSI-92 и частично стандарту ANSI-III.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Состав языка SQL</p>
Язык SQL предназначен для манипулирования данными в реляционных базах данных, определения структуры баз данных и для управления правами доступа к данным в многопользовательской среде.</p>
Поэтому, в язык SQL в качестве составных частей входят:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;язык манипулирования данными (Data Manipulation Language, DML)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;язык определения данных (Data Definition Language, DDL)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;язык управления данными (Data Control Language, DCL).</td></tr></table></div>&nbsp;</p>
Подчеркнем, что это не отдельные языки, а различные команды одного языка. Такое деление проведено только лишь с точки зрения различного функционального назначения этих команд.</p>
&nbsp;</p>
Язык манипулирования данными используется, как это следует из его названия, для манипулирования данными в таблицах баз данных. Он состоит из 4 основных команд:</p>
&nbsp;</p>
SELECT  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(выбрать)</p>
INSERT  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(вставить)</p>
UPDATE  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(обновить)</p>
DELETE  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(удалить).</p>
&nbsp;</p>
Язык определения данных используется для создания и изменения структуры базы данных и ее составных частей - таблиц, индексов, представлений (виртуальных таблиц), а также триггеров и сохраненных процедур. Основными его командами являются:</p>
&nbsp;</p>
CREATE DATABASE  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(создать базу данных)</p>
CREATE TABLE  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(создать таблицу)</p>
CREATE VIEW  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(создать виртуальную таблицу)</p>
CREATE INDEX  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(создать индекс)</p>
CREATE TRIGGER &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(создать триггер)</p>
CREATE PROCEDURE &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(создать сохраненную процедуру)</p>
ALTER DATABASE  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(модифицировать базу данных)</p>
ALTER TABLE  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(модифицировать таблицу)</p>
ALTER VIEW  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(модифицировать виртуальную таблицу)</p>
ALTER INDEX  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(модифицировать индекс)</p>
ALTER TRIGGER &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(модифицировать триггер)</p>
ALTER PROCEDURE &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(модифицировать сохраненную процедуру)</p>
DROP DATABASE  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(удалить базу данных)</p>
DROP TABLE  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(удалить таблицу)</p>
DROP VIEW  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(удалить виртуальную таблицу)</p>
DROP INDEX  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(удалить индекс)</p>
DROP TRIGGER &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(удалить триггер)</p>
DROP PROCEDURE &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(удалить сохраненную процедуру).</p>
&nbsp;</p>
Язык управления данными используется для управления правами доступа к данным и выполнением процедур в многопользовательской среде. Более точно его можно назвать "язык управления доступом". Он состоит из двух основных команд:</p>
&nbsp;</p>
GRANT  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(дать права)</p>
REVOKE  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(забрать права).</p>
&nbsp;</p>
С точки зрения прикладного интерфейса существуют две разновидности команд SQL:</p>
&#8226; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; интерактивный SQL</p>
&#8226; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; встроенный SQL.</p>
<p>Интерактивный SQL используется в специальных утилитах (типа WISQL или DBD), позволяющих в интерактивном режиме вводить запросы с использованием команд SQL, посылать их для выполнения на сервер и получать результаты в предназначенном для этого окне. Встроенный SQL используется в прикладных программах, позволяя им посылать запросы к серверу и обрабатывать полученные результаты, в том числе комбинируя set-ориентированный и record-ориентированный подходы.</p>
Мы не будем приводить точный синтаксис команд SQL, вместо этого мы рассмотрим их на многочисленных примерах, что намного более важно для понимания SQL, чем точный синтаксис, который можно посмотреть в документации на Вашу СУБД.</p>
&nbsp;</p>
Итак, начнем с рассмотрения команд языка манипулирования данными.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Реляционные операции. Команды языка манипулирования данными</p>
Наиболее важной командой языка манипулирования данными является команда SELECT. За кажущейся простотой ее синтаксиса скрывается огромное богатство возможностей. Нам важно научиться использовать это богатство!</p>
На данном уроке предполагается, если не оговорено противное, что все команды языка SQL вводятся интерактивным способом. В качестве информационной основы для примеров мы будем использовать базу данных "Служащие предприятия" (employee.gdb), входящую в поставку Delphi и находящуюся (по умолчанию) в поддиректории \IBLOCAL\EXAMPLES.</p>
<p>Рис. 1: Структура базы данных EMPLOYEE</p>
&nbsp;</p>
На рис.1 приведена схема базы данных EMPLOYEE для Local InterBase, нарисованная с помощью CASE-средства S-Designor (см. доп. урок). На схеме показаны таблицы базы данных и взаимосвязи, а также обозначены первичные ключи и их связи с внешними ключами. Многие из примеров, особенно в конце урока, являются весьма сложными. Однако, не следует на этом основании делать вывод, что так сложен сам язык SQL. Дело, скорее, в том, что обычные (стандартные) операции настолько просты в SQL, что примеры таких операций оказываются довольно неинтересными и не иллюстрируют полной мощности этого языка. Но в целях системности мы пройдем по всем возможностям SQL: от самых простых - до чрезвычайно сложных.</p>
Начнем с базовых операций реляционных баз данных. Таковыми являются:</p>
&#8226; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; выборка  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(Restriction)</p>
&#8226; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; проекция  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(Projection)</p>
&#8226; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; соединение  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(Join)</p>
&#8226; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; объединение &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(Union).</p>
&nbsp;</p>
Операция выборки позволяет получить все строки (записи) либо часть строк одной таблицы.</p>
&nbsp;</p>
SELECT * FROM country &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Получить все строки</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;таблицы Country</p>
&nbsp;</p>
COUNTRY&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CURRENCY&nbsp;&nbsp;</p>
=============== ==========</p>
USA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Dollar&nbsp;&nbsp;&nbsp;&nbsp;</p>
England&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pound&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Canada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CdnDlr&nbsp;&nbsp;&nbsp;&nbsp;</p>
Switzerland&nbsp;&nbsp;&nbsp;&nbsp; SFranc&nbsp;&nbsp;&nbsp;&nbsp;</p>
Japan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Yen&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Italy&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lira&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
France&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FFranc&nbsp;&nbsp;&nbsp;&nbsp;</p>
Germany&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; D-Mark&nbsp;&nbsp;&nbsp;&nbsp;</p>
Australia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ADollar&nbsp;&nbsp;&nbsp;</p>
Hong Kong&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; HKDollar&nbsp;&nbsp;</p>
Netherlands&nbsp;&nbsp;&nbsp;&nbsp; Guilder&nbsp;&nbsp;&nbsp;</p>
Belgium&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BFranc&nbsp;&nbsp;&nbsp;&nbsp;</p>
Austria&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Schilling&nbsp;</p>
Fiji&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FDollar</p>
&nbsp;</p>
В этом примере и далее - для большей наглядности - все зарезервированные слова языка SQL будем писать большими буквами. Красным цветом будем записывать предложения SQL, а светло-синим - результаты выполнения запросов.</p>
<pre>
SELECT * FROM country
WHERE currency = "Dollar"
</pre>
<p> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Получить подмножество  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;строк таблицы Country,  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;удовлетворяющее  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;условию Currency = "Dollar"</p>
Результат последней операции выглядит следующим образом:</p>
&nbsp;</p>
COUNTRY&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CURRENCY&nbsp;&nbsp;</p>
=============== ==========</p>
USA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Dollar</p>
&nbsp;</p>
&nbsp;</p>
Операция проекции позволяет выделить подмножество столбцов таблицы. Например:</p>
&nbsp;</p>
SELECT currency FROM country &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Получить список</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;денежных единиц</p>
&nbsp;</p>
CURRENCY&nbsp;&nbsp;</p>
==========</p>
Dollar&nbsp;&nbsp;&nbsp;&nbsp;</p>
Pound&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
CdnDlr&nbsp;&nbsp;&nbsp;&nbsp;</p>
SFranc&nbsp;&nbsp;&nbsp;&nbsp;</p>
Yen&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Lira&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
FFranc&nbsp;&nbsp;&nbsp;&nbsp;</p>
D-Mark&nbsp;&nbsp;&nbsp;&nbsp;</p>
ADollar&nbsp;&nbsp;&nbsp;</p>
HKDollar&nbsp;&nbsp;</p>
Guilder&nbsp;&nbsp;&nbsp;</p>
BFranc&nbsp;&nbsp;&nbsp;&nbsp;</p>
Schilling&nbsp;</p>
FDollar</p>
&nbsp;</p>
На практике очень часто требуется получить некое подмножество столбцов и строк таблицы, т.е. выполнить комбинацию Restriction и Projection. Для этого достаточно перечислить столбцы таблицы и наложить ограничения на строки.</p>
&nbsp;</p>
SELECT currency FROM country &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
WHERE country = "Japan" &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Найти денежную</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;единицу Японии</p>
&nbsp;</p>
CURRENCY&nbsp;&nbsp;</p>
==========</p>
Yen</p>
&nbsp;</p>
SELECT first_name, last_name</p>
FROM employee</p>
WHERE first_name = "Roger" &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Получить фамилии</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;работников,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;которых зовут "Roger"</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
=============== ====================</p>
Roger&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; De Souza&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Roger&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Reeves</p>
&nbsp;</p>
Эти примеры иллюстрируют общую форму команды SELECT в языке SQL (для одной таблицы):</p>
&nbsp;</p>
SELECT &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(выбрать) специфицированные поля</p>
FROM  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(из) специфицированной таблицы</p>
WHERE &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(где) некоторое специфицированное условие является  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;истинным</p>
&nbsp;</p>
Операция соединения позволяет соединять строки из более чем одной таблицы (по некоторому условию) для образования новых строк данных.</p>
&nbsp;</p>
SELECT first_name, last_name, proj_name</p>
FROM employee, project</p>
WHERE emp_no = team_leader &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Получить список</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;руководителей проектов</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PROJ_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
============== ================= ====================</p>
Ashok&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ramanathan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Video Database&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Pete&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fisher&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DigiPizza&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Chris&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Papadopoulos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; AutoMap&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Bruce&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Young&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MapBrowser port&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Mary S.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MacDonald&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Marketing project 3</p>
&nbsp;</p>
Операция объединения позволяет объединять результаты отдельных запросов по нескольким таблицам в единую результирующую таблицу. Таким образом, предложение UNION объединяет вывод двух или более SQL-запросов в единый набор строк и столбцов.</p>
&nbsp;</p>
SELECT first_name, last_name, job_country</p>
FROM employee</p>
WHERE job_country = "France"</p>
UNION</p>
SELECT contact_first, contact_last, country</p>
FROM customer</p>
WHERE country = "France" &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Получить список</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;работников и заказчиков,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;проживающих во Франции</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; JOB_COUNTRY&nbsp;&nbsp;&nbsp;&nbsp;</p>
=============== ================= ===============</p>
Jacques&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Glon&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; France&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Michelle&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Roche&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; France</p>
&nbsp;</p>
Для справки, приведем общую форму команды SELECT, учитывающую возможность соединения нескольких таблиц и объединения результатов:</p>
&nbsp;</p>
SELECT &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;[DISTINCT] список_выбираемых_элементов (полей)</p>
FROM &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;список_таблиц (или представлений)</p>
[WHERE &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;предикат]</p>
[GROUP BY &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;поле (или поля) [HAVING предикат]]</p>
[UNION &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;другое_выражение_Select]</p>
[ORDER BY &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;поле (или поля) или номер (номера)];</p>
&nbsp;</p>
&nbsp;</p>
<p>Отметим, что под предикатом понимается некоторое специфицированное условие (отбора), значение которого имеет булевский тип.&nbsp; Квадратные скобки означают необязательность использования дополнительных конструкций команды. Точка с запятой является стандартным терминатором команды. Отметим, что в WISQL и в компоненте TQuery ставить конечный терминатор не обязательно. При этом там, где допустим один пробел между элементами, разрешено ставить любое количество пробелов и пустых строк - выполняя желаемое форматирование для большей наглядности.</p>
Гибкость и мощь языка SQL состоит в том, что он позволяет объединить все операции реляционной алгебры в одной конструкции, "вытаскивая" таким образом любую требуемую информацию, что очень часто и происходит на практике.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Команда SELECT</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Простейшие конструкции команды SELECT</p>
&nbsp;</p>
Итак, начнем с рассмотрения простейших конструкций языка SQL. После такого рассмотрения мы научимся:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;назначать поля, которые должны быть выбраны</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;назначать к выборке "все поля"</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;управлять "вертикальным" и "горизонтальным" порядком выбираемых полей</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;подставлять собственные заголовки полей в результирующей таблице</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;производить вычисления в списке выбираемых элементов</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;использовать литералы в списке выбираемых элементов</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;ограничивать число возвращаемых строк</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;формировать сложные условия поиска, используя реляционные и логические операторы</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;устранять одинаковые строки из результата.</td></tr></table></div>&nbsp;</p>
Список выбираемых элементов может содержать следующее:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 47px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&rArr;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;имена полей</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 47px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&rArr;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;*</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 47px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&rArr;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;вычисления</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 47px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&rArr;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;литералы</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 47px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&rArr;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;функции</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 47px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&rArr;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;агрегирующие конструкции</td></tr></table></div>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Список полей</p>
&nbsp;</p>
SELECT first_name, last_name, phone_no</p>
FROM phone_list &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;имен, фамилий и служебных телефонов</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;всех работников предприятия</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PHONE_NO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
============= ==================== ====================</p>
Terri&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lee&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (408) 555-1234&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Oliver H.&nbsp;&nbsp;&nbsp;&nbsp; Bender&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (408) 555-1234&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Mary S.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MacDonald&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (415) 555-1234&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Michael&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Yanowski&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (415) 555-1234&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Robert&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nelson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (408) 555-1234&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Kelly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Brown&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (408) 555-1234&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Stewart&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Hall&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (408) 555-1234&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
...</p>
Отметим, что PHONE_LIST - это виртуальная таблица (представление), созданная в InterBase и основанная на информации из двух таблиц - EMPLOYEE и DEPARTMENT.&nbsp; Она не показана на рис.1, однако, как мы уже указывали в общей структуре команды SELECT, к ней можно обращаться так же, как и к "настоящей" таблице.</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Все поля</p>
&nbsp;</p>
SELECT *</p>
FROM phone_list &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список служебных телефонов</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;всех работников предприятия</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;со всей необходимой информацией</p>
&nbsp;</p>
EMP_NO FIRST_NAME LAST_NAME PHONE_EXT LOCATION&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PHONE_NO</p>
====== ========== ========= ========= ============= ==============</p>
 &nbsp;&nbsp; 12 Terri&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lee&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 256&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Monterey&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (408) 555-1234</p>
 &nbsp; 105 Oliver H.&nbsp; Bender&nbsp;&nbsp;&nbsp; 255&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Monterey&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (408) 555-1234</p>
 &nbsp;&nbsp; 85 Mary S.&nbsp;&nbsp;&nbsp; MacDonald 477&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; San Francisco (415) 555-1234</p>
 &nbsp; 127 Michael&nbsp;&nbsp;&nbsp; Yanowski&nbsp; 492&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; San Francisco (415) 555-1234</p>
 &nbsp;&nbsp;&nbsp; 2 Robert&nbsp;&nbsp;&nbsp;&nbsp; Nelson&nbsp;&nbsp;&nbsp; 250&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Monterey&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (408) 555-1234</p>
 &nbsp; 109 Kelly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Brown&nbsp;&nbsp;&nbsp;&nbsp; 202&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Monterey&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (408) 555-1234</p>
 &nbsp;&nbsp; 14 Stewart&nbsp;&nbsp;&nbsp; Hall&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 227&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Monterey&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (408) 555-1234</p>
<p> ...</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Все поля в произвольном порядке</p>
&nbsp;</p>
SELECT first_name, last_name, phone_no,</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; location, phone_ext, emp_no</p>
FROM phone_list &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список служебных телефонов</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;всех работников предприятия</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;со всей необходимой информацией,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;расположив их в требуемом порядке</p>
&nbsp;</p>
FIRST_NAME LAST_NAME PHONE_NO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LOCATION&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PHONE_EXT EMP_NO</p>
========== ========= ============== ============= ========= ======</p>
Terri&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lee&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (408) 555-1234 Monterey&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 256&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 12</p>
Oliver H.&nbsp; Bender&nbsp;&nbsp;&nbsp; (408) 555-1234 Monterey&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 255&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 105</p>
Mary S.&nbsp;&nbsp;&nbsp; MacDonald (415) 555-1234 San Francisco 477&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 85</p>
Michael&nbsp;&nbsp;&nbsp; Yanowski&nbsp; (415) 555-1234 San Francisco 492&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 127</p>
Robert&nbsp;&nbsp;&nbsp;&nbsp; Nelson&nbsp;&nbsp;&nbsp; (408) 555-1234 Monterey&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 250&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2</p>
Kelly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Brown&nbsp;&nbsp;&nbsp;&nbsp; (408) 555-1234 Monterey&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 202&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 109</p>
Stewart&nbsp;&nbsp;&nbsp; Hall&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (408) 555-1234 Monterey&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 227&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 14</p>
...</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Блобы</p>
&nbsp;</p>
Получение информации о BLOb выглядит совершенно аналогично обычным полям. Полученные значения можно отображать с использованием data-aware компонент Delphi, например,&nbsp; TDBMemo или TDBGrid. Однако, в последнем случае придется самому прорисовывать содержимое блоба (например, через OnDrawDataCell). Подробнее об этом см. на уроке,&nbsp; посвященном работе с полями.</p>
&nbsp;</p>
SELECT job_requirement</p>
FROM job &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;должностных требований</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;к кандидатам на работу</p>
&nbsp;</p>
JOB_REQUIREMENT:&nbsp;</p>
No specific requirements.</p>
&nbsp;</p>
JOB_REQUIREMENT:&nbsp;</p>
15+ years in finance or 5+ years as a CFO</p>
with a proven track record.</p>
MBA or J.D. degree.</p>
&nbsp;</p>
...</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Вычисления</p>
&nbsp;</p>
SELECT emp_no, salary, salary * 1.15</p>
FROM employee &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список номеров</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;служащих и их зарплату,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;в том числе увеличенную на 15%</p>
&nbsp;</p>
EMP_NO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SALARY&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
====== ====================== ======================</p>
 &nbsp;&nbsp;&nbsp; 2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 105900.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 121785</p>
 &nbsp;&nbsp;&nbsp; 4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 97500.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 112125</p>
 &nbsp;&nbsp;&nbsp; 5&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 102750.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 118162.5</p>
 &nbsp;&nbsp;&nbsp; 8&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 64635.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 74330.25</p>
 &nbsp;&nbsp;&nbsp; 9&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 75060.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 86319</p>
 &nbsp;&nbsp; 11&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 86292.94&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 99236.87812499999</p>
 &nbsp;&nbsp; 12&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 53793.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 61861.95</p>
 &nbsp;&nbsp; 14&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 69482.62&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 79905.01874999999</p>
 &nbsp; ...</p>
&nbsp;</p>
Порядок вычисления выражений подчиняется общепринятым правилам: сначала выполняется умножение и деление, а затем - сложение и вычитание. Операции одного уровня выполняются слева направо. Разрешено применять скобки для изменения порядка вычислений.</p>
Например, в выражении col1 + col2 * col3 сначала находится произведение значений столбцов col2 и col3, а затем результат этого умножения складывается со значением столбца col1. А в выражении (col1 + col2) * col3 сначала выполняется сложение значений столбцов col1 и col2, и только после этого результат умножается на значение столбца col3.</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Литералы</p>
&nbsp;</p>
Для придания большей наглядности получаемому результату можно использовать литералы. Литералы - это строковые константы, которые применяются наряду с наименованиями столбцов и, таким образом, выступают в роли "псевдостолбцов". Строка символов, представляющая собой литерал, должна быть заключена в одинарные или двойные скобки.</p>
&nbsp;</p>
SELECT first_name, "получает", salary,  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; "долларов в год"</p>
FROM employee &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список сотрудников</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;и их зарплату</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SALARY&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
=========== ======== ========== ==============</p>
Robert&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; получает&nbsp; 105900.00 долларов в год</p>
Bruce&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; получает&nbsp;&nbsp; 97500.00 долларов в год</p>
Kim&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; получает&nbsp; 102750.00 долларов в год</p>
Leslie&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; получает&nbsp;&nbsp; 64635.00 долларов в год</p>
Phil&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; получает&nbsp;&nbsp; 75060.00 долларов в год</p>
K. J.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; получает&nbsp;&nbsp; 86292.94 долларов в год</p>
Terri&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; получает&nbsp;&nbsp; 53793.00 долларов в год</p>
...</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Конкатенация</p>
&nbsp;</p>
Имеется возможность соединять два или более столбца, имеющие строковый тип, друг с другом, а также соединять их с литералами. Для этого используется операция конкатенации (||).</p>
&nbsp;</p>
SELECT "сотрудник " || first_name || " " ||  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; last_name</p>
FROM employee &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список всех сотрудников</p>
&nbsp;</p>
==============================================</p>
сотрудник Robert Nelson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
сотрудник Bruce Young&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
сотрудник Kim Lambert&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
сотрудник Leslie Johnson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
сотрудник Phil Forest&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
сотрудник K. J. Weston&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
сотрудник Terri Lee&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
сотрудник Stewart Hall</p>
...</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Использование квалификатора AS</p>
&nbsp;</p>
Для придания наглядности получаемым результатам наряду с литералами в списке выбираемых элементов можно использовать квалификатор AS. Данный квалификатор заменяет в результирующей таблице существующее название столбца на заданное. Это наиболее эффективный и простой способ создания заголовков (к сожалению, InterBase, как уже отмечалось, не поддерживает использование русских букв в наименовании столбцов).</p>
&nbsp;</p>
SELECT count(*) AS number</p>
FROM employee &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;подсчитать количество служащих</p>
&nbsp;</p>
 &nbsp;   NUMBER</p>
===========</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 42</p>
&nbsp;</p>
SELECT "сотрудник " || first_name || " " ||  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; last_name AS employee_list</p>
FROM employee &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список всех сотрудников</p>
&nbsp;</p>
EMPLOYEE_LIST&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
==============================================</p>
сотрудник Robert Nelson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
сотрудник Bruce Young&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
сотрудник Kim Lambert&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
сотрудник Leslie Johnson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
сотрудник Phil Forest&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
сотрудник K. J. Weston&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
сотрудник Terri Lee&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
сотрудник Stewart Hall</p>
...</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Работа с датами</p>
&nbsp;</p>
Мы уже рассказывали о типах данных, имеющихся в различных СУБД, в том числе и в InterBase. В разных системах имеется различное число встроенных функций, упрощающих работу с датами, строками и другими типами данных. InterBase, к сожалению, обладает достаточно ограниченным набором таких функций. Однако, поскольку язык SQL, реализованный в InterBase, соответствует стандарту, то в нем имеются возможности конвертации дат в строки и гибкой работы с датами. Внутренне дата в InterBase содержит значения даты и времени. Внешне дата может быть представлена строками различных форматов, например:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&diams;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;"October 27, 1995"</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&diams;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;"27-OCT-1994"</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&diams;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;"10-27-95"</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&diams;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;"10/27/95"</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&diams;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;"27.10.95"</td></tr></table></div>Кроме абсолютных дат, в SQL-выражениях можно также пользоваться относительным заданием дат:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">а</td><td> &nbsp; &nbsp; &nbsp; &nbsp;"yesterday" &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;вчера</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">а</td><td> &nbsp; &nbsp; &nbsp; &nbsp;"today" &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;сегодня</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">а</td><td> &nbsp; &nbsp; &nbsp; &nbsp;"now" &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;сейчас (включая время)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">а</td><td> &nbsp; &nbsp; &nbsp; &nbsp;"tomorrow" &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;завтра</td></tr></table></div>&nbsp;</p>
Дата может неявно конвертироваться в строку (из строки), если:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">-</td><td> &nbsp; &nbsp; &nbsp; &nbsp;строка, представляющая дату, имеет один из вышеперечисленных форматов;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">-</td><td> &nbsp; &nbsp; &nbsp; &nbsp;выражение не содержит неоднозначностей в толковании типов столбцов.</td></tr></table></div>&nbsp;</p>
SELECT first_name, last_name, hire_date</p>
FROM employee</p>
WHERE hire_date &gt; '1-1-94' &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список сотрудников,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;принятых на работу после</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1 января 1994 года</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; HIRE_DATE</p>
=============== ==================== ===========</p>
Pierre&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Osborne&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3-JAN-1994</p>
John&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Montgomery&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 30-MAR-1994</p>
Mark&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Guckenheimer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2-MAY-1994</p>
&nbsp;</p>
Значения дат можно сравнивать друг с другом, сравнивать с относительными датами, вычитать одну дату из другой.</p>
&nbsp;</p>
SELECT first_name, last_name, hire_date</p>
FROM employee</p>
WHERE 'today' - hire_date &gt; 365 * 7 + 1</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список служащих,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;проработавших на предприятии</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;к настоящему времени</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;более 7 лет</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; HIRE_DATE</p>
=============== ==================== ===========</p>
Robert&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nelson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 28-DEC-1988</p>
Bruce&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Young&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 28-DEC-1988</p>
&nbsp;</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Агрегатные функции</p>
&nbsp;</p>
К агрегирующим функциям относятся функции вычисления суммы (SUM), максимального (SUM) и минимального (MIN) значений столбцов, арифметического среднего (AVG), а также количества строк, удовлетворяющих заданному условию (COUNT).</p>
&nbsp;</p>
SELECT count(*), sum (budget), avg (budget),</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; min (budget), max (budget)</p>
FROM department</p>
WHERE head_dept = 100 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;вычислить: количество отделов,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;являющихся подразделениями</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;отдела 100 (Маркетинг и продажи),</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;их суммарный, средний, мини- &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;мальный и максимальный бюджеты</p>
&nbsp;</p>
 COUNT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SUM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; AVG&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MIN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MAX</p>
====== =========== ========== ========== ===========</p>
 &nbsp;&nbsp;&nbsp; 5&nbsp; 3800000.00&nbsp; 760000.00&nbsp; 500000.00&nbsp; 1500000.00</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Предложение FROM команды SELECT</p>
&nbsp;</p>
В предложении FROM перечисляются все объекты (один или несколько), из которых производится выборка данных (рис.2). Каждая таблица или представление, о которых упоминается в запросе, должны быть перечислены в предложении FROM.</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Ограничения на число выводимых строк</p>
&nbsp;</p>
Число возвращаемых в результате запроса строк может быть ограничено путем использования предложения WHERE, содержащего условия отбора (предикат, рис.2). Условие отбора для отдельных строк может принимать значения true, false или unnown. При этом запрос возвращает в качестве результата только те строки (записи), для которых предикат имеет значение true.</p>
Типы предикатов, используемых в предложении WHERE:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;сравнение с использованием реляционных операторов</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">=</td><td> &nbsp; &nbsp; &nbsp; &nbsp;равно</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&lt;&gt;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;не равно</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">!=</td><td> &nbsp; &nbsp; &nbsp; &nbsp;не равно</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&gt;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;больше</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&lt;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;меньше</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&gt;=</td><td> &nbsp; &nbsp; &nbsp; &nbsp;больше или равно</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&lt;=</td><td> &nbsp; &nbsp; &nbsp; &nbsp;меньше или равно</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;BETWEEN</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;IN</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;LIKE</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;CONTAINING</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;IS NULL</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;EXIST</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;ANY</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;ALL</td></tr></table></div>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Операции сравнения</p>
&nbsp;</p>
Рассмотрим операции сравнения. Реляционные операторы могут использоваться с различными элементами. При этом важно соблюдать следующее правило: элементы должны иметь сравнимые типы. Если в базе данных определены домены, то сравниваемые элементы должны относиться к одному домену.</p>
Что же может быть элементом сравнения? Элементом сравнения может выступать:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;значение поля</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;литерал</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;арифметическое выражение</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;агрегирующая функция</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;другая встроенная функция</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;значение (значения), возвращаемые подзапросом.</td></tr></table></div><p>При сравнении литералов конечные пробелы игнорируются. Так, предложение WHERE first_name = 'Петр&nbsp;&nbsp;&nbsp; ' будет иметь тот же результат, что и предложение WHERE first_name = 'Петр'.</p>
SELECT first_name, last_name, dept_no</p>
FROM employee</p>
WHERE job_code = "Admin" &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список&nbsp; сотрудников</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(и номера их отделов),</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;занимающих должность</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;администраторов</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DEPT_NO</p>
=============== ==================== =======</p>
&nbsp;</p>
Terri&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lee&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 000&nbsp;&nbsp;&nbsp;&nbsp;</p>
Ann&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bennet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 120&nbsp;&nbsp;&nbsp;&nbsp;</p>
Sue Anne&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; O'Brien&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 670&nbsp;&nbsp;&nbsp;&nbsp;</p>
Kelly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Brown&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 600</p>
&nbsp;</p>
SELECT first_name, last_name, dept_no,</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; job_country</p>
FROM employee</p>
WHERE job_country &lt;&gt; "USA" &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список&nbsp; сотрудников</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(а также номера их отделов</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;и страну),</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;работающих вне США</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DEPT_NO JOB_COUNTRY</p>
=============== ================ ======= ==============</p>
Ann&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bennet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 120&nbsp;&nbsp;&nbsp;&nbsp; England</p>
Roger&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Reeves&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 120&nbsp;&nbsp;&nbsp;&nbsp; England</p>
Willie&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Stansbury&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 120&nbsp;&nbsp;&nbsp;&nbsp; England</p>
Claudia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sutherland&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 140&nbsp;&nbsp;&nbsp;&nbsp; Canada</p>
Yuki&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ichida&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 115&nbsp;&nbsp;&nbsp;&nbsp; Japan</p>
Takashi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Yamamoto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 115&nbsp;&nbsp;&nbsp;&nbsp; Japan</p>
Roberto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ferrari&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 125&nbsp;&nbsp;&nbsp;&nbsp; Italy</p>
Jacques&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Glon&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 123&nbsp;&nbsp;&nbsp;&nbsp; France</p>
Pierre&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Osborne&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 121&nbsp;&nbsp;&nbsp;&nbsp; Switzerland</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;BETWEEN</p>
&nbsp;</p>
Предикат BETWEEN задает диапазон значений, для которого выражение принимает значение true. Разрешено также использовать конструкцию&nbsp; NOT&nbsp; BETWEEN.</p>
&nbsp;</p>
SELECT first_name, last_name, salary</p>
FROM employee</p>
WHERE salary BETWEEN 20000 AND 30000</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список сотрудников,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;годовая зарплата которых</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;больше 20000 и меньше 30000</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SALARY</p>
=============== ========== ===============</p>
Ann&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bennet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 22935.00</p>
Kelly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Brown&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 27000.00</p>
&nbsp;</p>
Тот же запрос с использованием операторов сравнения будет выглядеть следующим образом:</p>
&nbsp;</p>
SELECT first_name, last_name, salary</p>
FROM employee</p>
WHERE salary &gt;= 20000</p>
  AND salary &lt;= 30000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список сотрудников,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;годовая зарплата которых</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;больше 20000 и меньше 30000</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SALARY</p>
=============== ========== ===============</p>
Ann&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bennet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 22935.00</p>
Kelly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Brown&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 27000.00</p>
&nbsp;</p>
Запрос с предикатом BETWEEN может иметь следующий вид:</p>
&nbsp;</p>
SELECT first_name, last_name, salary</p>
FROM employee</p>
WHERE last_name BETWEEN "Nelson" AND "Osborne"</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список сотрудников,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;фамилии которых начинаются</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;с "Nelson"</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;и заканчиваются "Osborne"</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SALARY</p>
=============== =============== ================</p>
Robert&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nelson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 105900.00</p>
Carol&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nordstrom&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 42742.50</p>
Sue Anne&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; O'Brien&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 31275.00</p>
Pierre&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Osborne&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 110000.00</p>
&nbsp;</p>
<p>Значения, определяющие нижний и верхний диапазоны, могут не являться реальными величинами из базы данных. И это очень удобно - ведь мы не всегда можем указать точные значения диапазонов!</p>
SELECT first_name, last_name, salary</p>
FROM employee</p>
WHERE last_name BETWEEN "Nel" AND "Osb"</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список сотрудников,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;фамилии которых находятся</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;между&nbsp; "Nel" и "Osb"</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SALARY</p>
=============== =============== ================</p>
Robert&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nelson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 105900.00</p>
Carol&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nordstrom&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 42742.50</p>
Sue Anne&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; O'Brien&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 31275.00</p>
&nbsp;</p>
<p>В данном примере значений "Nel" и "Osb" в базе данных нет. Однако, все сотрудники, входящие в диапазон, в нижней части которого начало фамилий совпадает с "Nel" (т.е. выполняется условие "больше или равно"), а в верхней части фамилия не более "Osb" (т.е. выполняется условие "меньше или равно" - а именно "O", "Os", "Osb"), попадут в выборку. Отметим, что при выборке с использованием предиката BETWEEN поле, на которое накладывается диапазон, считается упорядоченным по возрастанию.</p>
Предикат BETWEEN с отрицанием NOT (NOT BETWEEN) позволяет получить выборку записей, указанные поля которых имеют значения меньше нижней границы и больше верхней границы.</p>
&nbsp;</p>
SELECT first_name, last_name, hire_date</p>
FROM employee</p>
WHERE hire_date NOT BETWEEN "1-JAN-1989" AND "31-DEC-1993" &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список самых "старых"</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;и самых "молодых" (по времени</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;поступления на работу)</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;сотрудников</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; HIRE_DATE</p>
=============== ================ ===========</p>
Robert&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nelson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 28-DEC-1988</p>
Bruce&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Young&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 28-DEC-1988</p>
Pierre&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Osborne&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3-JAN-1994</p>
John&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Montgomery&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 30-MAR-1994</p>
Mark&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Guckenheimer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2-MAY-1994</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;IN</p>
&nbsp;</p>
Предикат IN проверяет, входит ли заданное значение, предшествующее ключевому слову "IN" (например, значение столбца или функция от него) в указанный в скобках список. Если заданное проверяемое значение равно какому-либо элементу в списке, то предикат принимает значение true. Разрешено также использовать конструкцию&nbsp; NOT&nbsp; IN.</p>
&nbsp;</p>
SELECT first_name, last_name, job_code</p>
FROM employee</p>
WHERE job_code IN ("VP", "Admin", "Finan")</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список сотрудников,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;занимающих должности</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;"вице-президент", "администратор",</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;"финансовый директор"</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; JOB_CODE</p>
=============== ================ ========</p>
Robert&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nelson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; VP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Terri&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lee&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Admin&nbsp;&nbsp;&nbsp;</p>
Stewart&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Hall&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Finan&nbsp;&nbsp;&nbsp;</p>
Ann&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bennet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Admin&nbsp;&nbsp;&nbsp;</p>
Sue Anne&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; O'Brien&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Admin&nbsp;&nbsp;&nbsp;</p>
Mary S.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MacDonald&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; VP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Kelly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Brown&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Admin&nbsp;&nbsp;</p>
&nbsp;</p>
А вот пример запроса, использующего предикат&nbsp; NOT&nbsp; IN:</p>
&nbsp;</p>
SELECT first_name, last_name, job_country</p>
FROM employee</p>
WHERE job_country NOT IN</p>
 &nbsp;&nbsp;&nbsp;&nbsp; ("USA", "Japan", "England")</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список сотрудников,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;работающих не в США, не в Японии</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;и не в Великобритании</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; JOB_COUNTRY&nbsp;&nbsp;&nbsp;&nbsp;</p>
=============== ================ ===============</p>
Claudia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sutherland&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Canada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Roberto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ferrari&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Italy&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Jacques&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Glon&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; France&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Pierre&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Osborne&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Switzerland</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;LIKE</p>
&nbsp;</p>
Предикат LIKE используется только с символьными данными. Он проверяет, соответствует ли данное символьное значение строке с указанной маской. В качестве маски используются все разрешенные символы (с учетом верхнего и нижнего регистров), а также специальные символы:</p>
% - замещает любое количество символов (в том числе и 0),</p>
_&nbsp; - замещает только один символ.</p>
<p>Разрешено также использовать конструкцию&nbsp; NOT&nbsp; LIKE.</p>
SELECT first_name, last_name</p>
FROM employee</p>
WHERE last_name LIKE "F%" &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список сотрудников,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;фамилии которых начинаются  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;с буквы "F"</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
=============== ====================</p>
Phil&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Forest&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Pete&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fisher&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Roberto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ferrari</p>
&nbsp;</p>
SELECT first_name, last_name</p>
FROM employee</p>
WHERE first_name LIKE "%er" &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список сотрудников,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;имена которых  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;заканчиваются буквами "er" &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
=============== ====================</p>
Roger&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; De Souza&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Roger&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Reeves&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Walter&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Steadman</p>
&nbsp;</p>
А такой запрос позволяет решить проблему произношения (и написания) имени:</p>
&nbsp;</p>
SELECT first_name, last_name</p>
FROM employee</p>
WHERE first_name LIKE "Jacq_es"</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;найти сотрудника(ов),</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;в имени&nbsp; которого</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;неизвестно произношение</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;буквы перед окончанием "es"</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
=============== ====================</p>
Jacques&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Glon</p>
&nbsp;</p>
Что делать, если требуется найти строку, которая содержит указанные выше специальные символы ("%", "_") в качестве информационных символов? Есть выход! Для этого с помощью ключевого слова ESCAPE нужно определить так называемый escape-символ, который, будучи поставленным перед символом "%" или "_", укажет, что этот символ является информационным. Escape-символ не может быть символом "\" (обратная косая черта) и, вообще говоря, должен представлять собой символ, никогда не появляющийся в упоминаемом столбце как информационный символ. Часто для этих целей используются символы "@" и "~".</p>
&nbsp;</p>
SELECT first_name, last_name</p>
FROM employee</p>
WHERE first_name LIKE "%@_%" ESCAPE "@"</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список сотрудников,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;в имени которых содержится "_"</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(знак подчеркивания)</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;CONTAINING</p>
&nbsp;</p>
Предикат CONTAINING аналогичен предикату LIKE, за исключением того, что он не чувствителен к регистру букв. Разрешено также использовать конструкцию&nbsp; NOT&nbsp; CONTAINING.</p>
&nbsp;</p>
SELECT first_name, last_name</p>
FROM employee</p>
WHERE last_name CONTAINING "ne"</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список сотрудников,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;фамилии которых содержат буквы</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;"ne", "Ne", "NE", "nE"</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
=============== ====================</p>
Robert&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nelson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Ann&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bennet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Pierre&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Osborne</p>
&nbsp;</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;IS NULL</p>
&nbsp;</p>
В SQL-запросах NULL означает, что значение столбца неизвестно. Поисковые условия, в которых значение столбца сравнивается с NULL, всегда принимают значение unknown (и, соответственно, приводят к ошибке), в противоположность true или false, т.е.</p>
WHERE dept_no = NULL</p>
<p>или даже</p>
WHERE NULL = NULL.</p>
Предикат&nbsp; IS NULL  принимает значение true только тогда, когда выражение слева от ключевых слов "IS NULL" имеет значение null (пусто, не определено). Разрешено также использовать конструкцию&nbsp; IS NOT NULL, которая означает "не пусто", "имеет какое-либо значение".</p>
&nbsp;</p>
SELECT department, mngr_no</p>
FROM department</p>
WHERE mngr_no IS NULL &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список отделов,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;в которых еще не назначены</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;начальники</p>
DEPARTMENT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MNGR_NO</p>
========================= =======</p>
Marketing&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &lt;null&gt;</p>
Software Products Div.&nbsp;&nbsp;&nbsp;&nbsp; &lt;null&gt;</p>
Software Development&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &lt;null&gt;</p>
Field Office: Singapore&nbsp;&nbsp;&nbsp; &lt;null&gt;</p>
&nbsp;</p>
Предикаты EXIST, ANY, ALL, SOME, SINGULAR мы рассмотрим в разделе, рассказывающем о подзапросах.</p>
&nbsp;</p>
&nbsp;</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Логические операторы</p>
&nbsp;</p>
К логическим операторам относятся известные операторы AND, OR, NOT, позволяющие выполнять различные логические действия: логическое умножение (AND, "пересечение условий"), логическое сложение (OR, "объединение условий"), логическое отрицание (NOT, "отрицание условий"). В наших примерах мы уже применяли оператор AND. Использование этих операторов позволяет гибко "настроить" условия отбора записей.</p>
&nbsp;</p>
Оператор AND означает, что общий предикат будет истинным только тогда, когда условия, связанные по "AND", будут истинны.</p>
Оператор OR означает, что общий предикат будет истинным, когда хотя бы одно из условий, связанных по "OR", будет истинным.</p>
Оператор NOT означает, что общий предикат будет истинным, когда условие, перед которым стоит этот оператор, будет ложным.</p>
&nbsp;</p>
В одном предикате логические операторы выполняются в следующем порядке: сначала выполняется оператор NOT, затем - AND и только после этого - оператор OR. Для изменения порядка выполнения операторов разрешается использовать скобки.</p>
&nbsp;</p>
SELECT first_name, last_name, dept_no,</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; job_code, salary</p>
FROM employee</p>
WHERE dept_no = 622</p>
 &nbsp; OR job_code = "Eng"</p>
  AND salary &lt;= 40000</p>
ORDER BY last_name &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список служащих,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;занятых в отделе 622</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; или</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;на должности "инженер" с зарплатой</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;не выше 40000</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp; DEPT_NO JOB_CODE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SALARY</p>
============ ============= ======= ======== ===========</p>
Jennifer M.&nbsp; Burbank&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 622&nbsp;&nbsp;&nbsp;&nbsp; Eng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 53167.50</p>
Phil&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Forest&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 622&nbsp;&nbsp;&nbsp;&nbsp; Mngr&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 75060.00</p>
T.J.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Green&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 621&nbsp;&nbsp;&nbsp;&nbsp; Eng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 36000.00</p>
Mark&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Guckenheimer&nbsp; 622&nbsp;&nbsp;&nbsp;&nbsp; Eng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 32000.00</p>
John&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Montgomery&nbsp;&nbsp;&nbsp; 672&nbsp;&nbsp;&nbsp;&nbsp; Eng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 35000.00</p>
Bill&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Parker&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 623&nbsp;&nbsp;&nbsp;&nbsp; Eng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 35000.00</p>
Willie&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Stansbury&nbsp;&nbsp;&nbsp;&nbsp; 120&nbsp;&nbsp;&nbsp;&nbsp; Eng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 39224.06</p>
&nbsp;</p>
&nbsp;</p>
SELECT first_name, last_name, dept_no,</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; job_code, salary</p>
FROM employee</p>
WHERE (dept_no = 622</p>
 &nbsp; OR job_code = "Eng")</p>
  AND salary &lt;= 40000</p>
ORDER BY last_name &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список служащих,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;занятых в отделе 622</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;или на должности "инженер",</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;зарплата которых не выше 40000</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp; DEPT_NO JOB_CODE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SALARY</p>
============ ============= ======= ======== ===========</p>
T.J.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Green&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 621&nbsp;&nbsp;&nbsp;&nbsp; Eng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 36000.00</p>
Mark&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Guckenheimer&nbsp; 622&nbsp;&nbsp;&nbsp;&nbsp; Eng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 32000.00</p>
John&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Montgomery&nbsp;&nbsp;&nbsp; 672&nbsp;&nbsp;&nbsp;&nbsp; Eng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 35000.00</p>
Bill&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Parker&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 623&nbsp;&nbsp;&nbsp;&nbsp; Eng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 35000.00</p>
Willie&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Stansbury&nbsp;&nbsp;&nbsp;&nbsp; 120&nbsp;&nbsp;&nbsp;&nbsp; Eng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 39224.06</p>
&nbsp;</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Преобразование типов (CAST)</p>
&nbsp;</p>
В SQL имеется возможность преобразовать значение столбца или функции к другому типу для более гибкого использования операций сравнения. Для этого используется функция CAST.</p>
Типы данных могут быть конвертированы в соответствии со следующей таблицей:</p>
&nbsp;</p>
Из типа данных &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;В тип данных</p>
---------------------------------------</p>
NUMERIC &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;CHAR, VARCHAR, DATE</p>
CHAR, VARCHAR &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;NUMERIC, DATE</p>
DATE &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;CHAR, VARCHAR, DATE</p>
&nbsp;</p>
&nbsp;</p>
SELECT first_name, last_name, dept_no</p>
FROM employee</p>
WHERE CAST(dept_no AS char(20))</p>
 &nbsp;&nbsp;&nbsp;&nbsp; CONTAINING "00" &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список сотрудников,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;занятых в отделах,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;номера которых содержат "00"</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DEPT_NO</p>
=============== ==================== =======</p>
Robert&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nelson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 600&nbsp;&nbsp;&nbsp;&nbsp;</p>
Terri&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lee&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 000&nbsp;&nbsp;&nbsp;&nbsp;</p>
Stewart&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Hall&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 900&nbsp;&nbsp;&nbsp;&nbsp;</p>
Walter&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Steadman&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 900&nbsp;&nbsp;&nbsp;&nbsp;</p>
Mary S.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MacDonald&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 100&nbsp;&nbsp;&nbsp;&nbsp;</p>
Oliver H.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bender&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 000&nbsp;&nbsp;&nbsp;&nbsp;</p>
Kelly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Brown&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 600&nbsp;&nbsp;&nbsp;&nbsp;</p>
Michael&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Yanowski&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 100</p>
&nbsp;</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Изменение порядка выводимых строк (ORDER BY)</p>
&nbsp;</p>
Порядок выводимых строк может быть изменен с помощью опционального (дополнительного) предложения ORDER BY в конце SQL-запроса. Это предложение имеет вид:</p>
&nbsp;</p>
ORDER BY &lt;порядок строк&gt; [ASC | DESC]</p>
&nbsp;</p>
Порядок строк может задаваться одним из двух способов:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;&epsilon;0/\ столбцов</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;номерами столбцов.</td></tr></table></div>&nbsp;</p>
Способ упорядочивания определяется дополнительными зарезервированными словами ASC и DESC. Способом по умолчанию - если ничего не указано - является упорядочивание "по возрастанию" (ASC). Если же указано слово "DESC", то упорядочивание будет производиться "по убыванию".</p>
Подчеркнем еще раз, что предложение ORDER BY должно указываться в самом конце запроса.</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Упорядочивание с использованием имен столбцов</p>
&nbsp;</p>
&nbsp;</p>
SELECT first_name, last_name, dept_no,</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; job_code, salary</p>
FROM employee</p>
ORDER BY last_name &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список сотрудников,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;упорядоченный по фамилиям</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;в алфавитном порядке</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp; DEPT_NO JOB_CODE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SALARY</p>
============ ============= ======= ======== ===========</p>
Janet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Baldwin&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 110&nbsp;&nbsp;&nbsp;&nbsp; Sales&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 61637.81</p>
Oliver H.&nbsp;&nbsp;&nbsp; Bender&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 000&nbsp;&nbsp;&nbsp;&nbsp; CEO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 212850.00</p>
Ann&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bennet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 120&nbsp;&nbsp;&nbsp;&nbsp; Admin&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 22935.00</p>
Dana&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bishop&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 621&nbsp;&nbsp;&nbsp;&nbsp; Eng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 62550.00</p>
Kelly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Brown&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 600&nbsp;&nbsp;&nbsp;&nbsp; Admin&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 27000.00</p>
Jennifer M.&nbsp; Burbank&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 622&nbsp;&nbsp;&nbsp;&nbsp; Eng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 53167.50</p>
Kevin&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 670&nbsp;&nbsp;&nbsp;&nbsp; Dir&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 111262.50</p>
Roger&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; De Souza&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 623&nbsp;&nbsp;&nbsp;&nbsp; Eng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 69482.62</p>
Roberto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ferrari&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 125&nbsp;&nbsp;&nbsp;&nbsp; SRep&nbsp;&nbsp;&nbsp;&nbsp; 99000000.00</p>
...</p>
&nbsp;</p>
&nbsp;</p>
SELECT first_name, last_name, dept_no,</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; job_code, salary</p>
FROM employee</p>
ORDER BY last_name DESC &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список сотрудников,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;упорядоченный по фамилиям</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;в порядке, обратном&nbsp; алфавитному</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp; DEPT_NO JOB_CODE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SALARY</p>
============ ============= ======= ======== ===========</p>
Katherine&nbsp;&nbsp;&nbsp; Young&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 623&nbsp;&nbsp;&nbsp;&nbsp; Mngr&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 67241.25</p>
Bruce&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Young&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 621&nbsp;&nbsp;&nbsp;&nbsp; Eng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 97500.00</p>
Michael&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Yanowski&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 100&nbsp;&nbsp;&nbsp;&nbsp; SRep&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 44000.00</p>
Takashi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Yamamoto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 115&nbsp;&nbsp;&nbsp;&nbsp; SRep&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7480000.00</p>
Randy&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Williams&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 672&nbsp;&nbsp;&nbsp;&nbsp; Mngr&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 56295.00</p>
K. J.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Weston&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 130&nbsp;&nbsp;&nbsp;&nbsp; SRep&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 86292.94</p>
Claudia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sutherland&nbsp;&nbsp;&nbsp; 140&nbsp;&nbsp;&nbsp;&nbsp; SRep&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 100914.00</p>
Walter&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Steadman&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 900&nbsp;&nbsp;&nbsp;&nbsp; CFO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 116100.00</p>
Willie&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Stansbury&nbsp;&nbsp;&nbsp;&nbsp; 120&nbsp;&nbsp;&nbsp;&nbsp; Eng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 39224.06</p>
Roger&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Reeves&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 120&nbsp;&nbsp;&nbsp;&nbsp; Sales&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 33620.62</p>
...</p>
&nbsp;</p>
Столбец, определяющий порядок вывода строк, не обязательно дожен присутствовать в списке выбираемых элементов (столбцов):</p>
&nbsp;</p>
SELECT first_name, last_name, dept_no,</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; job_code</p>
FROM employee</p>
ORDER BY salary &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список сотрудников,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;упорядоченный по их зарплате</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DEPT_NO JOB_CODE</p>
=============== =============== ======= ========</p>
Ann&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bennet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 120&nbsp;&nbsp;&nbsp;&nbsp; Admin&nbsp;&nbsp;&nbsp;</p>
Kelly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Brown&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 600&nbsp;&nbsp;&nbsp;&nbsp; Admin&nbsp;&nbsp;&nbsp;</p>
Sue Anne&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; O'Brien&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 670&nbsp;&nbsp;&nbsp;&nbsp; Admin&nbsp;&nbsp;&nbsp;</p>
Mark&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Guckenheimer&nbsp;&nbsp;&nbsp; 622&nbsp;&nbsp;&nbsp;&nbsp; Eng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Roger&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Reeves&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 120&nbsp;&nbsp;&nbsp;&nbsp; Sales&nbsp;&nbsp;&nbsp;</p>
Bill&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Parker&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 623&nbsp;&nbsp;&nbsp;&nbsp; Eng</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Упорядочивание с использованием номеров столбцов</p>
&nbsp;</p>
&nbsp;</p>
SELECT first_name, last_name, dept_no,</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; job_code, salary * 1.1</p>
FROM employee</p>
ORDER BY 5 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список сотрудников,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;упорядоченный по их зарплате</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;с 10% надбавкой</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp; DEPT_NO JOB_CODE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
============ ============= ======= ======== ===========</p>
Ann&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bennet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 120&nbsp;&nbsp;&nbsp;&nbsp; Admin&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 25228.5</p>
Kelly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Brown&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 600&nbsp;&nbsp;&nbsp;&nbsp; Admin&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 29700</p>
Sue Anne&nbsp;&nbsp;&nbsp;&nbsp; O'Brien&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 670&nbsp;&nbsp;&nbsp;&nbsp; Admin&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 34402.5</p>
Mark&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Guckenheimer&nbsp; 622&nbsp;&nbsp;&nbsp;&nbsp; Eng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 35200</p>
Roger&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Reeves&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 120&nbsp;&nbsp;&nbsp;&nbsp; Sales&nbsp;&nbsp;&nbsp;&nbsp; 36982.6875</p>
Bill&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Parker&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 623&nbsp;&nbsp;&nbsp;&nbsp; Eng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 38500</p>
&nbsp;</p>
Допускается использование нескольких уровней вложенности при упорядочивании выводимой информации по столбцам; при этом разрешается смешивать оба способа.</p>
&nbsp;</p>
SELECT first_name, last_name, dept_no,</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; job_code, salary * 1.1</p>
FROM employee</p>
ORDER BY dept_no, 5 DESC, last_name</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список сотрудников,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;упорядоченный сначала по</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;номерам отделов,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;в отделах - по убыванию их</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;зарплаты (с 10%),</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;а в пределах одной зарплаты -  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;по фамилиям</p>
&nbsp;</p>
FIRST_NAME&nbsp; LAST_NAME&nbsp; DEPT_NO JOB_CODE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
=========== ========== ======= ======== ===============</p>
Oliver H.&nbsp;&nbsp; Bender&nbsp;&nbsp;&nbsp;&nbsp; 000&nbsp;&nbsp;&nbsp;&nbsp; CEO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 234135</p>
Terri&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lee&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 000&nbsp;&nbsp;&nbsp;&nbsp; Admin&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 59172.3</p>
Mary S.&nbsp;&nbsp;&nbsp;&nbsp; MacDonald&nbsp; 100&nbsp;&nbsp;&nbsp;&nbsp; VP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 122388.75</p>
Michael&nbsp;&nbsp;&nbsp;&nbsp; Yanowski&nbsp;&nbsp; 100&nbsp;&nbsp;&nbsp;&nbsp; SRep&nbsp;&nbsp;&nbsp;&nbsp; 48400.000000001</p>
Luke&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Leung&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 110&nbsp;&nbsp;&nbsp;&nbsp; SRep&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 75685.5</p>
Janet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Baldwin&nbsp;&nbsp;&nbsp; 110&nbsp;&nbsp;&nbsp;&nbsp; Sales&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 67801.59375</p>
Takashi&nbsp;&nbsp;&nbsp;&nbsp; Yamamoto&nbsp;&nbsp; 115&nbsp;&nbsp;&nbsp;&nbsp; SRep&nbsp;&nbsp;&nbsp;&nbsp; 8228000.0000001</p>
Yuki&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ichida&nbsp;&nbsp;&nbsp;&nbsp; 115&nbsp;&nbsp;&nbsp;&nbsp; Eng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 6600000.0000001</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Устранение дублирования (модификатор DISTINCT)</p>
&nbsp;</p>
Дублированными являются такие строки в результирующей таблице, в которых идентичен каждый столбец.</p>
Иногда (в зависимости от задачи) бывает необходимо устранить все повторы строк из результирующего набора. Этой цели служит модификатор DISTINCT. Данный модификатор может быть указан только один раз в списке выбираемых элементов и действует на весь список.</p>
&nbsp;</p>
SELECT job_code</p>
FROM employee &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список должностей сотрудников</p>
&nbsp;</p>
JOB_CODE</p>
========</p>
VP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Eng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Eng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Mktg&nbsp;&nbsp;&nbsp;&nbsp;</p>
Mngr&nbsp;&nbsp;&nbsp;&nbsp;</p>
SRep&nbsp;&nbsp;&nbsp;&nbsp;</p>
Admin&nbsp;&nbsp;&nbsp;</p>
Finan&nbsp;&nbsp;&nbsp;</p>
Mngr&nbsp;&nbsp;&nbsp;&nbsp;</p>
Mngr&nbsp;&nbsp;&nbsp;&nbsp;</p>
Eng</p>
...</p>
&nbsp;</p>
Данный пример некорректно решает задачу "получения" списка должностей сотрудников предприятия, так как в нем имеются многочисленные повторы, затрудняющие восприятие информации. Тот же запрос, включающий модификатор DISTINCT, устраняющий дублирование, дает верный результат.</p>
&nbsp;</p>
SELECT DISTINCT job_code</p>
FROM employee  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список должностей сотрудников</p>
&nbsp;</p>
JOB_CODE</p>
========</p>
Admin&nbsp;&nbsp;&nbsp;</p>
CEO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
CFO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Dir&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Doc&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Eng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Finan&nbsp;&nbsp;&nbsp;</p>
Mktg&nbsp;&nbsp;&nbsp;&nbsp;</p>
Mngr&nbsp;&nbsp;&nbsp;&nbsp;</p>
PRel&nbsp;&nbsp;&nbsp;&nbsp;</p>
SRep&nbsp;&nbsp;&nbsp;&nbsp;</p>
Sales&nbsp;&nbsp;&nbsp;</p>
VP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
&nbsp;</p>
Два следующих примера показывают, что модификатор DISTINCT действует на всю строку сразу.</p>
&nbsp;</p>
SELECT first_name, last_name</p>
FROM employee</p>
WHERE first_name = "Roger" &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список служащих,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;имена которых - Roger</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
=============== ====================</p>
Roger&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; De Souza&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Roger&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Reeves</p>
&nbsp;</p>
&nbsp;</p>
SELECT DISTINCT first_name, last_name</p>
FROM employee</p>
WHERE first_name = "Roger" &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список служащих,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;имена которых - Roger</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
=============== ====================</p>
Roger&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; De Souza&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Roger&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Reeves</p>
&nbsp;</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Соединение (JOIN)</p>
&nbsp;</p>
Операция соединения используется в языке SQL для вывода связанной информации, хранящейся в нескольких таблицах, в одном запросе. В этом проявляется одна из наиболее важных особенностей запросов SQL - способность определять связи между многочисленными таблицами и выводить информацию из них в рамках этих связей. Именно эта операция придает гибкость и легкость языку SQL.</p>
После изучения этого раздела мы будем способны:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;соединять данные из нескольких таблиц в единую результирующую таблицу;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;задавать имена столбцов двумя способами;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;записывать внешние соединения;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;создавать соединения таблицы с собой.</td></tr></table></div>&nbsp;</p>
Операции соединения подразделяются на два вида - внутренние и внешние. Оба вида соединений задаются в предложении WHERE запроса SELECT с помощью специального условия соединения. Внешние соединения (о которых мы поговорим позднее) поддерживаются стандартом ANSI-92 и содержат зарезервированное слово "JOIN", в то время как внутренние соединения (или просто соединения) могут задаваться как без использования такого слова (в стандарте ANSI-89), так и с использованием слова "JOIN" (в стандарте ANSI-92).</p>
Связывание производится, как правило, по первичному ключу одной таблицы и внешнему ключу другой таблицы - для каждой пары таблиц. При этом очень важно учитывать все поля внешнего ключа, иначе результат будет искажен. Соединяемые поля могут (но не обязаны!) присутствовать в списке выбираемых элементов. Предложение WHERE может содержать множественные условия соединений. Условие соединения может также комбинироваться с другими предикатами в предложении WHERE.</p>
&nbsp;</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Внутренние соединения</p>
&nbsp;</p>
Внутреннее соединение возвращает только те строки, для которых условие соединения принимает значение true.</p>
&nbsp;</p>
SELECT first_name, last_name, department</p>
FROM employee, department</p>
WHERE job_code = "VP" &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список сотрудников,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;состоящих в должности "вице-</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;президент", а также названия</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;их отделов</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DEPARTMENT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
=============== ================ ======================&nbsp;&nbsp;&nbsp;</p>
Robert&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nelson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Corporate Headquarters&nbsp;&nbsp;&nbsp;</p>
Mary S.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MacDonald&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Corporate Headquarters&nbsp;&nbsp;&nbsp;</p>
Robert&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nelson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sales and Marketing&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Mary S.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MacDonald&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sales and Marketing&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Robert&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nelson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Engineering&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Mary S.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MacDonald&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Engineering&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Robert&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nelson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Finance&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Mary S.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MacDonald&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Finance</p>
...</p>
&nbsp;</p>
Этот запрос ("без соединения") возвращает неверный результат, так как имеющиеся между таблицами связи не задействованы. Отсюда и появляется дублирование информации в результирующей таблице. Правильный результат дает запрос с использованием операции соединения:</p>
&nbsp;</p>
SELECT first_name, last_name, department</p>
FROM employee, department</p>
WHERE job_code = "VP"</p>
  AND employee.dept_no = department.dept_no</p>
&nbsp;</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;имена таблиц</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список сотрудников,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;состоящих в должности "вице-</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;президент", а также названия</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;их отделов</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DEPARTMENT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
=============== ================ ======================&nbsp;&nbsp;&nbsp;</p>
Robert&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nelson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Engineering&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Mary S.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MacDonald&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sales and Marketing</p>
&nbsp;</p>
В вышеприведенном запросе использовался способ непосредственного указания таблиц с помощью их имен. Возможен (а иногда и просто необходим) также способ указания таблиц с помощью алиасов (псевдонимов). При этом алиасы определяются в предложении FROM запроса SELECT и представляют собой любой допустимый идентификатор, написание которого подчиняется таким же правилам, что и написание имен таблиц. Потребность в алиасах таблиц возникает тогда, когда названия столбцов, используемых в условиях соединения двух (или более) таблиц, совпадают, а названия таблиц слишком длинны...</p>
Замечание 1: в одном запросе нельзя смешивать использование написания имен таблиц и их алиасов.</p>
Замечание 2: алиасы таблиц могут совпадать с их именами.</p>
&nbsp;</p>
&nbsp;</p>
SELECT first_name, last_name, department</p>
FROM employee e, department d</p>
WHERE job_code = "VP"</p>
  AND e.dept_no = d.dept_no</p>
&nbsp;</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  алиасы таблиц</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список сотрудников,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;состоящих в должности "вице-</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;президент", а также названия</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;их отделов</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DEPARTMENT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
=============== ================ ======================&nbsp;&nbsp;&nbsp;</p>
Robert&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nelson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Engineering&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Mary S.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MacDonald&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sales and Marketing</p>
&nbsp;</p>
А вот пример запроса, соединяющего сразу три таблицы:</p>
&nbsp;</p>
SELECT first_name, last_name, job_title,&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; department</p>
FROM employee e, department d, job j</p>
WHERE d.mngr_no = e.emp_no</p>
  AND e.job_code = j.job_code</p>
  AND e.job_grade = j.job_grade</p>
  AND e.job_country = j.job_country</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список сотрудников</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;с названиями их должностей</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;и названиями отделов</p>
&nbsp;</p>
<p>FIRST_NAME LAST_NAME&nbsp;&nbsp;&nbsp; JOB_TITLE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DEPARTMENT</p>
<p>========== ============ ======================= ======================</p>
<p>Robert&nbsp;&nbsp;&nbsp;&nbsp; Nelson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Vice President&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Engineering</p>
<p>Phil&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Forest&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Manager&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Quality Assurance</p>
<p>K. J.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Weston&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sales Representative&nbsp;&nbsp;&nbsp; Field Office: East Coast</p>
<p>Katherine&nbsp; Young&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Manager&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Customer Support</p>
<p>Chris&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Papadopoulos Manager&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Research and Development</p>
<p>Janet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Baldwin&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sales Co-ordinator&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pacific Rim Headquarters</p>
<p>Roger&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Reeves&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sales Co-ordinator&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; European Headquarters</p>
<p>Walter&nbsp;&nbsp;&nbsp;&nbsp; Steadman&nbsp;&nbsp;&nbsp;&nbsp; Chief Financial Officer Finance</p>
&nbsp;</p>
В данном примере последние три условия необходимы в силу того, что первичный ключ в таблице JOB состоит из трех полей - см. рис.1.</p>
&nbsp;</p>
Мы рассмотрели внутренние соединения с использованием стандарта ANSI-89. Теперь опишем новый (ANSI-92) стандарт:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;условия соединения записываются в предложении FROM, в котором слева и справа от зарезервированного слова "JOIN" указываются соединяемые таблицы;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;условия поиска, основанные на правой таблице, помещаются в предложение ON;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;условия поиска, основанные на левой таблице, помещаются в предложение WHERE.</td></tr></table></div>&nbsp;</p>
SELECT first_name, last_name, department</p>
FROM employee e JOIN department d</p>
 ON e.dept_no = d.dept_no</p>
AND department = "Customer Support"</p>
WHERE last_name starting with "P"</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список&nbsp; служащих</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(а заодно и название отдела),</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;являющихся сотрудниками отдела</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;"Customer Support", фамилии кото-</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;рых начинаются с буквы "P"</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DEPARTMENT</p>
============= =============== ===================</p>
Leslie&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Phong&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Customer Support&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Bill&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Parker&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Customer Support&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
&nbsp;</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Самосоединения</p>
&nbsp;</p>
В некоторых задачах необходимо получить информацию, выбранную особым образом только из одной таблицы. Для этого используются так называемые самосоединения, или рефлексивные соединения. Это не отдельный вид соединения, а просто соединение таблицы с собой с помощью алиасов. Самосоединения полезны в случаях, когда нужно получить пары аналогичных элементов из одной и той же таблицы.</p>
&nbsp;</p>
SELECT one.last_name, two.last_name,&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; one.hire_date</p>
FROM employee one, employee two</p>
WHERE one.hire_date = two.hire_date</p>
  AND one.emp_no &lt; two.emp_no</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить пары фамилий сотрудников,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;которые приняты на работу в один</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;и тот же день</p>
&nbsp;</p>
LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; HIRE_DATE</p>
==================== ==================== ===========</p>
Nelson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Young&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 28-DEC-1988</p>
Reeves&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Stansbury&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 25-APR-1991</p>
Bishop&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MacDonald&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1-JUN-1992</p>
Brown&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ichida&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4-FEB-1993</p>
&nbsp;</p>
&nbsp;</p>
SELECT d1.department, d2.department, d1.budget</p>
FROM department d1, department d2</p>
WHERE d1.budget = d2.budget</p>
  AND d1.dept_no &lt; d2.dept_no</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список пар отделов с</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;одинаковыми годовыми бюджетами</p>
&nbsp;</p>
<p>DEPARTMENT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DEPARTMENT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BUDGET</p>
<p>========================&nbsp; ========================= =========</p>
<p>Software Development&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Finance&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 400000.00</p>
<p>Field Office: East Coast&nbsp; Field Office: Canada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 500000.00</p>
<p>Field Office: Japan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Field Office: East Coast&nbsp; 500000.00</p>
<p>Field Office: Japan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Field Office: Canada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 500000.00</p>
<p>Field Office: Japan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Field Office: Switzerland 500000.00</p>
<p>Field Office: Singapore&nbsp;&nbsp; Quality Assurance&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 300000.00</p>
<p>Field Office: Switzerland Field Office: East Coast&nbsp; 500000.00</p>
&nbsp;</p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Внешние соединения</p>
&nbsp;</p>
Напомним, что внутреннее соединение возвращает только те строки, для которых условие соединения принимает значение true. Иногда требуется включить в результирующий набор большее количество строк.</p>
Вспомним, запрос вида</p>
&nbsp;</p>
SELECT first_name, last_name, department</p>
FROM employee e, department d</p>
WHERE e.dept_no = d.dept_no</p>
&nbsp;</p>
<p>возвращает только те строки, для которых условие соединения&nbsp;&nbsp;&nbsp; (e.dept_no = d.dept_no)&nbsp; принимает значение true.</p>
Внешнее соединение возвращает все строки из одной таблицы и только те строки из другой таблицы, для которых условие соединения принимает значение true. Строки второй таблицы, не удовлетворяющие условию соединения (т.е. имеющие значение false), получают значение null в результирующем наборе.</p>
&nbsp;</p>
Существует два вида внешнего соединения:&nbsp; LEFT JOIN  и&nbsp;&nbsp; RIGHT JOIN.&nbsp;&nbsp;</p>
&nbsp;</p>
В левом соединении (LEFT JOIN) запрос возвращает все строки из левой таблицы (т.е. таблицы, стоящей слева от зарезервированного словосочетания "LEFT JOIN") и только те из правой таблицы, которые удовлетворяют условию соединения. Если же в правой таблице не найдется строк, удовлетворяющих заданному условию, то в результате они замещаются значениями null.</p>
Для правого соединения - все наоборот.</p>
&nbsp;</p>
SELECT first_name, last_name, department</p>
FROM employee e LEFT JOIN department d</p>
  ON e.dept_no = d.dept_no</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список сотрудников</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;и название их отделов,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;включая сотрудников, еще</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;не назначенных ни в какой отдел</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DEPARTMENT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
=============== ============== =====================</p>
Robert&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nelson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Engineering&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Bruce&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Young&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Software Development&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Kim&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lambert&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Field Office: East Coast&nbsp;</p>
Leslie&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Johnson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Marketing&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Phil&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Forest&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Quality Assurance</p>
...</p>
&nbsp;</p>
В данном запросе все сотрудники оказались распределены по отделам, иначе названия отделов заместились бы значением null.</p>
&nbsp;</p>
А вот пример правого соединения:</p>
&nbsp;</p>
SELECT first_name, last_name, department</p>
FROM employee e RIGHT JOIN department d</p>
  ON e.dept_no = d.dept_no</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;получить список сотрудников</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;и название их отделов,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;включая отделы, в которые еще</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;не назначены сотрудники</p>
&nbsp;</p>
FIRST_NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST_NAME&nbsp;&nbsp;&nbsp;&nbsp; DEPARTMENT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
=============== ============= =========================</p>
Terri&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lee&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Corporate Headquarters&nbsp;&nbsp;&nbsp;</p>
Oliver H.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bender&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Corporate Headquarters&nbsp;&nbsp;&nbsp;</p>
Mary S.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MacDonald&nbsp;&nbsp;&nbsp;&nbsp; Sales and Marketing&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Michael&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Yanowski&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sales and Marketing&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Robert&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nelson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Engineering&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Kelly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Brown&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Engineering&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Stewart&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Hall&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Finance&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Walter&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Steadman&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Finance&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Leslie&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Johnson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Marketing&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
Carol&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nordstrom&nbsp;&nbsp;&nbsp;&nbsp; Marketing&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
&lt;null&gt;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &lt;null&gt;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Software Products Div.&nbsp;&nbsp;&nbsp;</p>
Bruce&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Young&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Software Development</p>
...</p>
&nbsp;</p>
В результирующий набор входит и отдел "Software Products Div." (а также отдел "Field Office: Singapore", не представленный здесь), в котором еще нет ни одного сотрудника.</p>

