<h1>Основы языка SQL (статья)</h1>
<div class="date">01.01.2007</div>


SQL (обычно  произносимый как "СИКВЭЛ" или "ЭСКЮЭЛЬ") символизирует собой Структурированный Язык Запросов. Это - язык, который дает Вам возможность создавать и работать в реляционных базах данных, являющихся наборами связанной информации, сохраняемой в таблицах.</p>
</p>
Информационное пространство становится более унифицированным. Это привело к необходимости создания стандартного языка, который мог бы использоваться в большом количестве различных видов компьютерных сред. Стандартный язык позволит пользователям, знающим один набор команд, использовать их для создания, нахождения, изменения и передачи информации - независимо от того, работают ли они на персональном компьютере, сетевой рабочей станции, или на универсальной ЭВМ.</p>
В нашем все более и более взаимосвязанном компьютерном мире, пользователь снабженый таким языком, имеет огромное преимущество в использовании и обобщении информации из ряда источников с помощью большого количества способов.</p>
Элегантность и независимость от специфики компьютерных технологий, а также его поддержка лидерами промышленности в области технологии реляционных баз данных, сделало SQL (и, вероятно, в течение обозримого будущего оставит его) основным стандартным языком. По этой причине, любой, кто хочет работать с базами данных 90-х годов, должен знать SQL.</p>
</p>
Стандарт SQL определяется ANSI (Американским Национальным Институтом Стандартов) и в данное время также принимается ISO (Международной Организацией по Стандартизации). Однако, большинство коммерческих программ баз данных расширяют SQL без уведомления ANSI, добавляя различные особенности в этот язык, которые, как они считают, будут весьма полезны. Иногда они несколько нарушают стандарт языка, хотя хорошие идеи имеют тенденцию развиваться и вскоре становиться стандартами "рынка" сами по себе в силу полезности своих качеств.</p>
На данном уроке мы будем, в основном, следовать стандарту ANSI, но одновременно иногда будет показывать и некоторые наиболее общие отклонения от его стандарта.</p>
Точное описание особенностей языка приводится в документации на СУБД, которую Вы используете. SQL системы InterBase 4.0 соответствует стандарту ANSI-92 и частично стандарту ANSI-III.</p>
<p>                 Состав языка SQL</p>
Язык SQL предназначен для манипулирования данными в реляционных базах данных, определения структуры баз данных и для управления правами доступа к данным в многопользовательской среде.</p>
Поэтому, в язык SQL в качестве составных частей входят:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        язык манипулирования данными (Data Manipulation Language, DML)</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        язык определения данных (Data Definition Language, DDL)</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        язык управления данными (Data Control Language, DCL).</td></tr></table></div></p>
Подчеркнем, что это не отдельные языки, а различные команды одного языка. Такое деление проведено только лишь с точки зрения различного функционального назначения этих команд.</p>
</p>
Язык манипулирования данными используется, как это следует из его названия, для манипулирования данными в таблицах баз данных. Он состоит из 4 основных команд:</p>
</p>
SELECT                 (выбрать)</p>
INSERT                 (вставить)</p>
UPDATE                 (обновить)</p>
DELETE                 (удалить).</p>
</p>
Язык определения данных используется для создания и изменения структуры базы данных и ее составных частей - таблиц, индексов, представлений (виртуальных таблиц), а также триггеров и сохраненных процедур. Основными его командами являются:</p>
</p>
CREATE DATABASE                 (создать базу данных)</p>
CREATE TABLE                 (создать таблицу)</p>
CREATE VIEW                 (создать виртуальную таблицу)</p>
CREATE INDEX                 (создать индекс)</p>
CREATE TRIGGER                (создать триггер)</p>
CREATE PROCEDURE                (создать сохраненную процедуру)</p>
ALTER DATABASE                 (модифицировать базу данных)</p>
ALTER TABLE                 (модифицировать таблицу)</p>
ALTER VIEW                 (модифицировать виртуальную таблицу)</p>
ALTER INDEX                 (модифицировать индекс)</p>
ALTER TRIGGER                (модифицировать триггер)</p>
ALTER PROCEDURE                (модифицировать сохраненную процедуру)</p>
DROP DATABASE                 (удалить базу данных)</p>
DROP TABLE                 (удалить таблицу)</p>
DROP VIEW                 (удалить виртуальную таблицу)</p>
DROP INDEX                 (удалить индекс)</p>
DROP TRIGGER                (удалить триггер)</p>
DROP PROCEDURE                (удалить сохраненную процедуру).</p>
</p>
Язык управления данными используется для управления правами доступа к данным и выполнением процедур в многопользовательской среде. Более точно его можно назвать "язык управления доступом". Он состоит из двух основных команд:</p>
</p>
GRANT                 (дать права)</p>
REVOKE                 (забрать права).</p>
</p>
С точки зрения прикладного интерфейса существуют две разновидности команд SQL:</p>
&#8226;                 интерактивный SQL</p>
&#8226;                 встроенный SQL.</p>
<p>Интерактивный SQL используется в специальных утилитах (типа WISQL или DBD), позволяющих в интерактивном режиме вводить запросы с использованием команд SQL, посылать их для выполнения на сервер и получать результаты в предназначенном для этого окне. Встроенный SQL используется в прикладных программах, позволяя им посылать запросы к серверу и обрабатывать полученные результаты, в том числе комбинируя set-ориентированный и record-ориентированный подходы.</p>
Мы не будем приводить точный синтаксис команд SQL, вместо этого мы рассмотрим их на многочисленных примерах, что намного более важно для понимания SQL, чем точный синтаксис, который можно посмотреть в документации на Вашу СУБД.</p>
</p>
Итак, начнем с рассмотрения команд языка манипулирования данными.</p>
<p>                 Реляционные операции. Команды языка манипулирования данными</p>
Наиболее важной командой языка манипулирования данными является команда SELECT. За кажущейся простотой ее синтаксиса скрывается огромное богатство возможностей. Нам важно научиться использовать это богатство!</p>
На данном уроке предполагается, если не оговорено противное, что все команды языка SQL вводятся интерактивным способом. В качестве информационной основы для примеров мы будем использовать базу данных "Служащие предприятия" (employee.gdb), входящую в поставку Delphi и находящуюся (по умолчанию) в поддиректории \IBLOCAL\EXAMPLES.</p>
<p>Рис. 1: Структура базы данных EMPLOYEE</p>
</p>
На рис.1 приведена схема базы данных EMPLOYEE для Local InterBase, нарисованная с помощью CASE-средства S-Designor (см. доп. урок). На схеме показаны таблицы базы данных и взаимосвязи, а также обозначены первичные ключи и их связи с внешними ключами. Многие из примеров, особенно в конце урока, являются весьма сложными. Однако, не следует на этом основании делать вывод, что так сложен сам язык SQL. Дело, скорее, в том, что обычные (стандартные) операции настолько просты в SQL, что примеры таких операций оказываются довольно неинтересными и не иллюстрируют полной мощности этого языка. Но в целях системности мы пройдем по всем возможностям SQL: от самых простых - до чрезвычайно сложных.</p>
Начнем с базовых операций реляционных баз данных. Таковыми являются:</p>
&#8226;                 выборка                 (Restriction)</p>
&#8226;                 проекция                 (Projection)</p>
&#8226;                 соединение                 (Join)</p>
&#8226;                 объединение                (Union).</p>
</p>
Операция выборки позволяет получить все строки (записи) либо часть строк одной таблицы.</p>
</p>
SELECT * FROM country                Получить все строки</p>
                 таблицы Country</p>
</p>
COUNTRY         CURRENCY</p>
=============== ==========</p>
USA             Dollar</p>
England         Pound</p>
Canada          CdnDlr</p>
Switzerland     SFranc</p>
Japan           Yen</p>
Italy           Lira</p>
France          FFranc</p>
Germany         D-Mark</p>
Australia       ADollar</p>
Hong Kong       HKDollar</p>
Netherlands     Guilder</p>
Belgium         BFranc</p>
Austria         Schilling</p>
Fiji            FDollar</p>
</p>
В этом примере и далее - для большей наглядности - все зарезервированные слова языка SQL будем писать большими буквами. Красным цветом будем записывать предложения SQL, а светло-синим - результаты выполнения запросов.</p>
<pre>
SELECT * FROM country
WHERE currency = "Dollar"
</pre>
<p>                Получить подмножество                 строк таблицы Country,                 удовлетворяющее                 условию Currency = "Dollar"</p>
Результат последней операции выглядит следующим образом:</p>
</p>
COUNTRY         CURRENCY</p>
=============== ==========</p>
USA             Dollar</p>
</p>
</p>
Операция проекции позволяет выделить подмножество столбцов таблицы. Например:</p>
</p>
SELECT currency FROM country                Получить список</p>
                денежных единиц</p>
</p>
CURRENCY</p>
==========</p>
Dollar</p>
Pound</p>
CdnDlr</p>
SFranc</p>
Yen</p>
Lira</p>
FFranc</p>
D-Mark</p>
ADollar</p>
HKDollar</p>
Guilder</p>
BFranc</p>
Schilling</p>
FDollar</p>
</p>
На практике очень часто требуется получить некое подмножество столбцов и строк таблицы, т.е. выполнить комбинацию Restriction и Projection. Для этого достаточно перечислить столбцы таблицы и наложить ограничения на строки.</p>
</p>
SELECT currency FROM country</p>
WHERE country = "Japan"                Найти денежную</p>
                единицу Японии</p>
</p>
CURRENCY</p>
==========</p>
Yen</p>
</p>
SELECT first_name, last_name</p>
FROM employee</p>
WHERE first_name = "Roger"                Получить фамилии</p>
                работников,</p>
                которых зовут "Roger"</p>
FIRST_NAME      LAST_NAME</p>
=============== ====================</p>
Roger           De Souza</p>
Roger           Reeves</p>
</p>
Эти примеры иллюстрируют общую форму команды SELECT в языке SQL (для одной таблицы):</p>
</p>
SELECT                (выбрать) специфицированные поля</p>
FROM                 (из) специфицированной таблицы</p>
WHERE                (где) некоторое специфицированное условие является                                                                                                                                                                                 истинным</p>
</p>
Операция соединения позволяет соединять строки из более чем одной таблицы (по некоторому условию) для образования новых строк данных.</p>
</p>
SELECT first_name, last_name, proj_name</p>
FROM employee, project</p>
WHERE emp_no = team_leader                Получить список</p>
                руководителей проектов</p>
</p>
FIRST_NAME     LAST_NAME         PROJ_NAME</p>
============== ================= ====================</p>
Ashok          Ramanathan        Video Database</p>
Pete           Fisher            DigiPizza</p>
Chris          Papadopoulos      AutoMap</p>
Bruce          Young             MapBrowser port</p>
Mary S.        MacDonald         Marketing project 3</p>
</p>
Операция объединения позволяет объединять результаты отдельных запросов по нескольким таблицам в единую результирующую таблицу. Таким образом, предложение UNION объединяет вывод двух или более SQL-запросов в единый набор строк и столбцов.</p>
</p>
SELECT first_name, last_name, job_country</p>
FROM employee</p>
WHERE job_country = "France"</p>
UNION</p>
SELECT contact_first, contact_last, country</p>
FROM customer</p>
WHERE country = "France"                Получить список</p>
                работников и заказчиков,</p>
                проживающих во Франции</p>
</p>
FIRST_NAME      LAST_NAME         JOB_COUNTRY</p>
=============== ================= ===============</p>
Jacques         Glon              France</p>
Michelle        Roche             France</p>
</p>
Для справки, приведем общую форму команды SELECT, учитывающую возможность соединения нескольких таблиц и объединения результатов:</p>
</p>
SELECT                [DISTINCT] список_выбираемых_элементов (полей)</p>
FROM                список_таблиц (или представлений)</p>
[WHERE                предикат]</p>
[GROUP BY                поле (или поля) [HAVING предикат]]</p>
[UNION                другое_выражение_Select]</p>
[ORDER BY                поле (или поля) или номер (номера)];</p>
</p>
</p>
<p>Отметим, что под предикатом понимается некоторое специфицированное условие (отбора), значение которого имеет булевский тип.  Квадратные скобки означают необязательность использования дополнительных конструкций команды. Точка с запятой является стандартным терминатором команды. Отметим, что в WISQL и в компоненте TQuery ставить конечный терминатор не обязательно. При этом там, где допустим один пробел между элементами, разрешено ставить любое количество пробелов и пустых строк - выполняя желаемое форматирование для большей наглядности.</p>
Гибкость и мощь языка SQL состоит в том, что он позволяет объединить все операции реляционной алгебры в одной конструкции, "вытаскивая" таким образом любую требуемую информацию, что очень часто и происходит на практике.</p>
<p>                 Команда SELECT</p>
                 Простейшие конструкции команды SELECT</p>
</p>
Итак, начнем с рассмотрения простейших конструкций языка SQL. После такого рассмотрения мы научимся:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        назначать поля, которые должны быть выбраны</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        назначать к выборке "все поля"</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        управлять "вертикальным" и "горизонтальным" порядком выбираемых полей</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        подставлять собственные заголовки полей в результирующей таблице</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        производить вычисления в списке выбираемых элементов</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        использовать литералы в списке выбираемых элементов</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        ограничивать число возвращаемых строк</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        формировать сложные условия поиска, используя реляционные и логические операторы</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        устранять одинаковые строки из результата.</td></tr></table></div></p>
Список выбираемых элементов может содержать следующее:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 47px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&rArr;</td><td>        имена полей</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 47px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&rArr;</td><td>        *</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 47px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&rArr;</td><td>        вычисления</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 47px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&rArr;</td><td>        литералы</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 47px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&rArr;</td><td>        функции</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 47px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&rArr;</td><td>        агрегирующие конструкции</td></tr></table></div>
                 Список полей</p>
</p>
SELECT first_name, last_name, phone_no</p>
FROM phone_list                получить список</p>
                имен, фамилий и служебных телефонов</p>
                всех работников предприятия</p>
</p>
FIRST_NAME    LAST_NAME            PHONE_NO</p>
============= ==================== ====================</p>
Terri         Lee                  (408) 555-1234</p>
Oliver H.     Bender               (408) 555-1234</p>
Mary S.       MacDonald            (415) 555-1234</p>
Michael       Yanowski             (415) 555-1234</p>
Robert        Nelson               (408) 555-1234</p>
Kelly         Brown                (408) 555-1234</p>
Stewart       Hall                 (408) 555-1234</p>
...</p>
Отметим, что PHONE_LIST - это виртуальная таблица (представление), созданная в InterBase и основанная на информации из двух таблиц - EMPLOYEE и DEPARTMENT.  Она не показана на рис.1, однако, как мы уже указывали в общей структуре команды SELECT, к ней можно обращаться так же, как и к "настоящей" таблице.</p>
                 Все поля</p>
</p>
SELECT *</p>
FROM phone_list                получить список служебных телефонов</p>
                всех работников предприятия</p>
                со всей необходимой информацией</p>
</p>
EMP_NO FIRST_NAME LAST_NAME PHONE_EXT LOCATION      PHONE_NO</p>
====== ========== ========= ========= ============= ==============</p>
    12 Terri      Lee       256       Monterey      (408) 555-1234</p>
   105 Oliver H.  Bender    255       Monterey      (408) 555-1234</p>
    85 Mary S.    MacDonald 477       San Francisco (415) 555-1234</p>
   127 Michael    Yanowski  492       San Francisco (415) 555-1234</p>
     2 Robert     Nelson    250       Monterey      (408) 555-1234</p>
   109 Kelly      Brown     202       Monterey      (408) 555-1234</p>
    14 Stewart    Hall      227       Monterey      (408) 555-1234</p>
<p> ...</p>
                 Все поля в произвольном порядке</p>
</p>
SELECT first_name, last_name, phone_no,</p>
       location, phone_ext, emp_no</p>
FROM phone_list                получить список служебных телефонов</p>
                всех работников предприятия</p>
                со всей необходимой информацией,</p>
                расположив их в требуемом порядке</p>
</p>
FIRST_NAME LAST_NAME PHONE_NO       LOCATION      PHONE_EXT EMP_NO</p>
========== ========= ============== ============= ========= ======</p>
Terri      Lee       (408) 555-1234 Monterey      256           12</p>
Oliver H.  Bender    (408) 555-1234 Monterey      255          105</p>
Mary S.    MacDonald (415) 555-1234 San Francisco 477           85</p>
Michael    Yanowski  (415) 555-1234 San Francisco 492          127</p>
Robert     Nelson    (408) 555-1234 Monterey      250            2</p>
Kelly      Brown     (408) 555-1234 Monterey      202          109</p>
Stewart    Hall      (408) 555-1234 Monterey      227           14</p>
...</p>
                 Блобы</p>
</p>
Получение информации о BLOb выглядит совершенно аналогично обычным полям. Полученные значения можно отображать с использованием data-aware компонент Delphi, например,  TDBMemo или TDBGrid. Однако, в последнем случае придется самому прорисовывать содержимое блоба (например, через OnDrawDataCell). Подробнее об этом см. на уроке,  посвященном работе с полями.</p>
</p>
SELECT job_requirement</p>
FROM job                получить список</p>
                должностных требований</p>
                к кандидатам на работу</p>
</p>
JOB_REQUIREMENT:</p>
No specific requirements.</p>
</p>
JOB_REQUIREMENT:</p>
15+ years in finance or 5+ years as a CFO</p>
with a proven track record.</p>
MBA or J.D. degree.</p>
</p>
...</p>
                 Вычисления</p>
</p>
SELECT emp_no, salary, salary * 1.15</p>
FROM employee                получить список номеров</p>
                служащих и их зарплату,</p>
                в том числе увеличенную на 15%</p>
</p>
EMP_NO                 SALARY</p>
====== ====================== ======================</p>
     2              105900.00                 121785</p>
     4               97500.00                 112125</p>
     5              102750.00               118162.5</p>
     8               64635.00               74330.25</p>
     9               75060.00                  86319</p>
    11               86292.94      99236.87812499999</p>
    12               53793.00               61861.95</p>
    14               69482.62      79905.01874999999</p>
   ...</p>
</p>
Порядок вычисления выражений подчиняется общепринятым правилам: сначала выполняется умножение и деление, а затем - сложение и вычитание. Операции одного уровня выполняются слева направо. Разрешено применять скобки для изменения порядка вычислений.</p>
Например, в выражении col1 + col2 * col3 сначала находится произведение значений столбцов col2 и col3, а затем результат этого умножения складывается со значением столбца col1. А в выражении (col1 + col2) * col3 сначала выполняется сложение значений столбцов col1 и col2, и только после этого результат умножается на значение столбца col3.</p>
                 Литералы</p>
</p>
Для придания большей наглядности получаемому результату можно использовать литералы. Литералы - это строковые константы, которые применяются наряду с наименованиями столбцов и, таким образом, выступают в роли "псевдостолбцов". Строка символов, представляющая собой литерал, должна быть заключена в одинарные или двойные скобки.</p>
</p>
SELECT first_name, "получает", salary,                                    "долларов в год"</p>
FROM employee                получить список сотрудников</p>
                и их зарплату</p>
</p>
FIRST_NAME               SALARY</p>
=========== ======== ========== ==============</p>
Robert      получает  105900.00 долларов в год</p>
Bruce       получает   97500.00 долларов в год</p>
Kim         получает  102750.00 долларов в год</p>
Leslie      получает   64635.00 долларов в год</p>
Phil        получает   75060.00 долларов в год</p>
K. J.       получает   86292.94 долларов в год</p>
Terri       получает   53793.00 долларов в год</p>
...</p>
                 Конкатенация</p>
</p>
Имеется возможность соединять два или более столбца, имеющие строковый тип, друг с другом, а также соединять их с литералами. Для этого используется операция конкатенации (||).</p>
</p>
SELECT "сотрудник " || first_name || " " ||                    last_name</p>
FROM employee                получить список всех сотрудников</p>
</p>
==============================================</p>
сотрудник Robert Nelson</p>
сотрудник Bruce Young</p>
сотрудник Kim Lambert</p>
сотрудник Leslie Johnson</p>
сотрудник Phil Forest</p>
сотрудник K. J. Weston</p>
сотрудник Terri Lee</p>
сотрудник Stewart Hall</p>
...</p>
                 Использование квалификатора AS</p>
</p>
Для придания наглядности получаемым результатам наряду с литералами в списке выбираемых элементов можно использовать квалификатор AS. Данный квалификатор заменяет в результирующей таблице существующее название столбца на заданное. Это наиболее эффективный и простой способ создания заголовков (к сожалению, InterBase, как уже отмечалось, не поддерживает использование русских букв в наименовании столбцов).</p>
</p>
SELECT count(*) AS number</p>
FROM employee                подсчитать количество служащих</p>
</p>
     NUMBER</p>
===========</p>
         42</p>
</p>
SELECT "сотрудник " || first_name || " " ||                    last_name AS employee_list</p>
FROM employee                получить список всех сотрудников</p>
</p>
EMPLOYEE_LIST</p>
==============================================</p>
сотрудник Robert Nelson</p>
сотрудник Bruce Young</p>
сотрудник Kim Lambert</p>
сотрудник Leslie Johnson</p>
сотрудник Phil Forest</p>
сотрудник K. J. Weston</p>
сотрудник Terri Lee</p>
сотрудник Stewart Hall</p>
...</p>
                 Работа с датами</p>
</p>
Мы уже рассказывали о типах данных, имеющихся в различных СУБД, в том числе и в InterBase. В разных системах имеется различное число встроенных функций, упрощающих работу с датами, строками и другими типами данных. InterBase, к сожалению, обладает достаточно ограниченным набором таких функций. Однако, поскольку язык SQL, реализованный в InterBase, соответствует стандарту, то в нем имеются возможности конвертации дат в строки и гибкой работы с датами. Внутренне дата в InterBase содержит значения даты и времени. Внешне дата может быть представлена строками различных форматов, например:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&diams;</td><td>        "October 27, 1995"</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&diams;</td><td>        "27-OCT-1994"</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&diams;</td><td>        "10-27-95"</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&diams;</td><td>        "10/27/95"</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&diams;</td><td>        "27.10.95"</td></tr></table></div>Кроме абсолютных дат, в SQL-выражениях можно также пользоваться относительным заданием дат:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">а</td><td>        "yesterday"                вчера</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">а</td><td>        "today"                сегодня</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">а</td><td>        "now"                сейчас (включая время)</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">а</td><td>        "tomorrow"                завтра</td></tr></table></div></p>
Дата может неявно конвертироваться в строку (из строки), если:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">-</td><td>        строка, представляющая дату, имеет один из вышеперечисленных форматов;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 1px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">-</td><td>        выражение не содержит неоднозначностей в толковании типов столбцов.</td></tr></table></div></p>
SELECT first_name, last_name, hire_date</p>
FROM employee</p>
WHERE hire_date &gt; '1-1-94'                получить список сотрудников,</p>
                принятых на работу после</p>
                1 января 1994 года</p>
</p>
FIRST_NAME      LAST_NAME              HIRE_DATE</p>
=============== ==================== ===========</p>
Pierre          Osborne               3-JAN-1994</p>
John            Montgomery           30-MAR-1994</p>
Mark            Guckenheimer          2-MAY-1994</p>
</p>
Значения дат можно сравнивать друг с другом, сравнивать с относительными датами, вычитать одну дату из другой.</p>
</p>
SELECT first_name, last_name, hire_date</p>
FROM employee</p>
WHERE 'today' - hire_date &gt; 365 * 7 + 1</p>
                получить список служащих,</p>
                проработавших на предприятии</p>
                к настоящему времени</p>
                более 7 лет</p>
</p>
FIRST_NAME      LAST_NAME              HIRE_DATE</p>
=============== ==================== ===========</p>
Robert          Nelson               28-DEC-1988</p>
Bruce           Young                28-DEC-1988</p>
</p>
                 Агрегатные функции</p>
</p>
К агрегирующим функциям относятся функции вычисления суммы (SUM), максимального (SUM) и минимального (MIN) значений столбцов, арифметического среднего (AVG), а также количества строк, удовлетворяющих заданному условию (COUNT).</p>
</p>
SELECT count(*), sum (budget), avg (budget),</p>
       min (budget), max (budget)</p>
FROM department</p>
WHERE head_dept = 100                вычислить: количество отделов,</p>
                являющихся подразделениями</p>
                отдела 100 (Маркетинг и продажи),</p>
                их суммарный, средний, мини-                мальный и максимальный бюджеты</p>
</p>
 COUNT         SUM        AVG        MIN         MAX</p>
====== =========== ========== ========== ===========</p>
     5  3800000.00  760000.00  500000.00  1500000.00</p>
                 Предложение FROM команды SELECT</p>
</p>
В предложении FROM перечисляются все объекты (один или несколько), из которых производится выборка данных (рис.2). Каждая таблица или представление, о которых упоминается в запросе, должны быть перечислены в предложении FROM.</p>
                 Ограничения на число выводимых строк</p>
</p>
Число возвращаемых в результате запроса строк может быть ограничено путем использования предложения WHERE, содержащего условия отбора (предикат, рис.2). Условие отбора для отдельных строк может принимать значения true, false или unnown. При этом запрос возвращает в качестве результата только те строки (записи), для которых предикат имеет значение true.</p>
Типы предикатов, используемых в предложении WHERE:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        сравнение с использованием реляционных операторов</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">=</td><td>        равно</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&lt;&gt;</td><td>        не равно</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">!=</td><td>        не равно</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&gt;</td><td>        больше</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&lt;</td><td>        меньше</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&gt;=</td><td>        больше или равно</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&lt;=</td><td>        меньше или равно</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        BETWEEN</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        IN</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        LIKE</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        CONTAINING</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        IS NULL</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        EXIST</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        ANY</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 20px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        ALL</td></tr></table></div>
                 Операции сравнения</p>
</p>
Рассмотрим операции сравнения. Реляционные операторы могут использоваться с различными элементами. При этом важно соблюдать следующее правило: элементы должны иметь сравнимые типы. Если в базе данных определены домены, то сравниваемые элементы должны относиться к одному домену.</p>
Что же может быть элементом сравнения? Элементом сравнения может выступать:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        значение поля</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        литерал</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        арифметическое выражение</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        агрегирующая функция</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        другая встроенная функция</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        значение (значения), возвращаемые подзапросом.</td></tr></table></div>
<p>При сравнении литералов конечные пробелы игнорируются. Так, предложение WHERE first_name = 'Петр    ' будет иметь тот же результат, что и предложение WHERE first_name = 'Петр'.</p>
SELECT first_name, last_name, dept_no</p>
FROM employee</p>
WHERE job_code = "Admin"                получить список  сотрудников</p>
                (и номера их отделов),</p>
                занимающих должность</p>
                администраторов</p>
FIRST_NAME      LAST_NAME            DEPT_NO</p>
=============== ==================== =======</p>
</p>
Terri           Lee                  000</p>
Ann             Bennet               120</p>
Sue Anne        O'Brien              670</p>
Kelly           Brown                600</p>
</p>
SELECT first_name, last_name, dept_no,</p>
       job_country</p>
FROM employee</p>
WHERE job_country &lt;&gt; "USA"                получить список  сотрудников</p>
                (а также номера их отделов</p>
                и страну),</p>
                работающих вне США</p>
</p>
FIRST_NAME      LAST_NAME        DEPT_NO JOB_COUNTRY</p>
=============== ================ ======= ==============</p>
Ann             Bennet           120     England</p>
Roger           Reeves           120     England</p>
Willie          Stansbury        120     England</p>
Claudia         Sutherland       140     Canada</p>
Yuki            Ichida           115     Japan</p>
Takashi         Yamamoto         115     Japan</p>
Roberto         Ferrari          125     Italy</p>
Jacques         Glon             123     France</p>
Pierre          Osborne          121     Switzerland</p>
                 BETWEEN</p>
</p>
Предикат BETWEEN задает диапазон значений, для которого выражение принимает значение true. Разрешено также использовать конструкцию  NOT  BETWEEN.</p>
</p>
SELECT first_name, last_name, salary</p>
FROM employee</p>
WHERE salary BETWEEN 20000 AND 30000</p>
                получить список сотрудников,</p>
                годовая зарплата которых</p>
                больше 20000 и меньше 30000</p>
</p>
FIRST_NAME      LAST_NAME           SALARY</p>
=============== ========== ===============</p>
Ann             Bennet            22935.00</p>
Kelly           Brown             27000.00</p>
</p>
Тот же запрос с использованием операторов сравнения будет выглядеть следующим образом:</p>
</p>
SELECT first_name, last_name, salary</p>
FROM employee</p>
WHERE salary &gt;= 20000</p>
  AND salary &lt;= 30000                получить список сотрудников,</p>
                годовая зарплата которых</p>
                больше 20000 и меньше 30000</p>
</p>
FIRST_NAME      LAST_NAME           SALARY</p>
=============== ========== ===============</p>
Ann             Bennet            22935.00</p>
Kelly           Brown             27000.00</p>
</p>
Запрос с предикатом BETWEEN может иметь следующий вид:</p>
</p>
SELECT first_name, last_name, salary</p>
FROM employee</p>
WHERE last_name BETWEEN "Nelson" AND "Osborne"</p>
                получить список сотрудников,</p>
                фамилии которых начинаются</p>
                с "Nelson"</p>
                и заканчиваются "Osborne"</p>
</p>
FIRST_NAME      LAST_NAME                 SALARY</p>
=============== =============== ================</p>
Robert          Nelson                 105900.00</p>
Carol           Nordstrom               42742.50</p>
Sue Anne        O'Brien                 31275.00</p>
Pierre          Osborne                110000.00</p>
</p>
<p>Значения, определяющие нижний и верхний диапазоны, могут не являться реальными величинами из базы данных. И это очень удобно - ведь мы не всегда можем указать точные значения диапазонов!</p>
SELECT first_name, last_name, salary</p>
FROM employee</p>
WHERE last_name BETWEEN "Nel" AND "Osb"</p>
                получить список сотрудников,</p>
                фамилии которых находятся</p>
                между  "Nel" и "Osb"</p>
FIRST_NAME      LAST_NAME                 SALARY</p>
=============== =============== ================</p>
Robert          Nelson                 105900.00</p>
Carol           Nordstrom               42742.50</p>
Sue Anne        O'Brien                 31275.00</p>
</p>
<p>В данном примере значений "Nel" и "Osb" в базе данных нет. Однако, все сотрудники, входящие в диапазон, в нижней части которого начало фамилий совпадает с "Nel" (т.е. выполняется условие "больше или равно"), а в верхней части фамилия не более "Osb" (т.е. выполняется условие "меньше или равно" - а именно "O", "Os", "Osb"), попадут в выборку. Отметим, что при выборке с использованием предиката BETWEEN поле, на которое накладывается диапазон, считается упорядоченным по возрастанию.</p>
Предикат BETWEEN с отрицанием NOT (NOT BETWEEN) позволяет получить выборку записей, указанные поля которых имеют значения меньше нижней границы и больше верхней границы.</p>
</p>
SELECT first_name, last_name, hire_date</p>
FROM employee</p>
WHERE hire_date NOT BETWEEN "1-JAN-1989" AND "31-DEC-1993"                получить список самых "старых"</p>
                и самых "молодых" (по времени</p>
                поступления на работу)</p>
                сотрудников</p>
</p>
FIRST_NAME      LAST_NAME          HIRE_DATE</p>
=============== ================ ===========</p>
Robert          Nelson           28-DEC-1988</p>
Bruce           Young            28-DEC-1988</p>
Pierre          Osborne           3-JAN-1994</p>
John            Montgomery       30-MAR-1994</p>
Mark            Guckenheimer      2-MAY-1994</p>
                 IN</p>
</p>
Предикат IN проверяет, входит ли заданное значение, предшествующее ключевому слову "IN" (например, значение столбца или функция от него) в указанный в скобках список. Если заданное проверяемое значение равно какому-либо элементу в списке, то предикат принимает значение true. Разрешено также использовать конструкцию  NOT  IN.</p>
</p>
SELECT first_name, last_name, job_code</p>
FROM employee</p>
WHERE job_code IN ("VP", "Admin", "Finan")</p>
                получить список сотрудников,</p>
                занимающих должности</p>
                "вице-президент", "администратор",</p>
                "финансовый директор"</p>
</p>
FIRST_NAME      LAST_NAME        JOB_CODE</p>
=============== ================ ========</p>
Robert          Nelson           VP</p>
Terri           Lee              Admin</p>
Stewart         Hall             Finan</p>
Ann             Bennet           Admin</p>
Sue Anne        O'Brien          Admin</p>
Mary S.         MacDonald        VP</p>
Kelly           Brown            Admin</p>
</p>
А вот пример запроса, использующего предикат  NOT  IN:</p>
</p>
SELECT first_name, last_name, job_country</p>
FROM employee</p>
WHERE job_country NOT IN</p>
      ("USA", "Japan", "England")</p>
                получить список сотрудников,</p>
                работающих не в США, не в Японии</p>
                и не в Великобритании</p>
</p>
FIRST_NAME      LAST_NAME        JOB_COUNTRY</p>
=============== ================ ===============</p>
Claudia         Sutherland       Canada</p>
Roberto         Ferrari          Italy</p>
Jacques         Glon             France</p>
Pierre          Osborne          Switzerland</p>
                 LIKE</p>
</p>
Предикат LIKE используется только с символьными данными. Он проверяет, соответствует ли данное символьное значение строке с указанной маской. В качестве маски используются все разрешенные символы (с учетом верхнего и нижнего регистров), а также специальные символы:</p>
% - замещает любое количество символов (в том числе и 0),</p>
_  - замещает только один символ.</p>
<p>Разрешено также использовать конструкцию  NOT  LIKE.</p>
SELECT first_name, last_name</p>
FROM employee</p>
WHERE last_name LIKE "F%"                получить список сотрудников,</p>
                фамилии которых начинаются                 с буквы "F"</p>
</p>
FIRST_NAME      LAST_NAME</p>
=============== ====================</p>
Phil            Forest</p>
Pete            Fisher</p>
Roberto         Ferrari</p>
</p>
SELECT first_name, last_name</p>
FROM employee</p>
WHERE first_name LIKE "%er"                получить список сотрудников,</p>
                имена которых                 заканчиваются буквами "er"</p>
FIRST_NAME      LAST_NAME</p>
=============== ====================</p>
Roger           De Souza</p>
Roger           Reeves</p>
Walter          Steadman</p>
</p>
А такой запрос позволяет решить проблему произношения (и написания) имени:</p>
</p>
SELECT first_name, last_name</p>
FROM employee</p>
WHERE first_name LIKE "Jacq_es"</p>
                найти сотрудника(ов),</p>
                в имени  которого</p>
                неизвестно произношение</p>
                буквы перед окончанием "es"</p>
</p>
FIRST_NAME      LAST_NAME</p>
=============== ====================</p>
Jacques         Glon</p>
</p>
Что делать, если требуется найти строку, которая содержит указанные выше специальные символы ("%", "_") в качестве информационных символов? Есть выход! Для этого с помощью ключевого слова ESCAPE нужно определить так называемый escape-символ, который, будучи поставленным перед символом "%" или "_", укажет, что этот символ является информационным. Escape-символ не может быть символом "\" (обратная косая черта) и, вообще говоря, должен представлять собой символ, никогда не появляющийся в упоминаемом столбце как информационный символ. Часто для этих целей используются символы "@" и "~".</p>
</p>
SELECT first_name, last_name</p>
FROM employee</p>
WHERE first_name LIKE "%@_%" ESCAPE "@"</p>
                получить список сотрудников,</p>
                в имени которых содержится "_"</p>
                (знак подчеркивания)</p>
                 CONTAINING</p>
</p>
Предикат CONTAINING аналогичен предикату LIKE, за исключением того, что он не чувствителен к регистру букв. Разрешено также использовать конструкцию  NOT  CONTAINING.</p>
</p>
SELECT first_name, last_name</p>
FROM employee</p>
WHERE last_name CONTAINING "ne"</p>
                получить список сотрудников,</p>
                фамилии которых содержат буквы</p>
                "ne", "Ne", "NE", "nE"</p>
</p>
FIRST_NAME      LAST_NAME</p>
=============== ====================</p>
Robert          Nelson</p>
Ann             Bennet</p>
Pierre          Osborne</p>
</p>
                 IS NULL</p>
</p>
В SQL-запросах NULL означает, что значение столбца неизвестно. Поисковые условия, в которых значение столбца сравнивается с NULL, всегда принимают значение unknown (и, соответственно, приводят к ошибке), в противоположность true или false, т.е.</p>
WHERE dept_no = NULL</p>
<p>или даже</p>
WHERE NULL = NULL.</p>
Предикат  IS NULL  принимает значение true только тогда, когда выражение слева от ключевых слов "IS NULL" имеет значение null (пусто, не определено). Разрешено также использовать конструкцию  IS NOT NULL, которая означает "не пусто", "имеет какое-либо значение".</p>
</p>
SELECT department, mngr_no</p>
FROM department</p>
WHERE mngr_no IS NULL                получить список отделов,</p>
                в которых еще не назначены</p>
                начальники</p>
DEPARTMENT                MNGR_NO</p>
========================= =======</p>
Marketing                  &lt;null&gt;</p>
Software Products Div.     &lt;null&gt;</p>
Software Development       &lt;null&gt;</p>
Field Office: Singapore    &lt;null&gt;</p>
</p>
Предикаты EXIST, ANY, ALL, SOME, SINGULAR мы рассмотрим в разделе, рассказывающем о подзапросах.</p>
</p>
</p>
                 Логические операторы</p>
</p>
К логическим операторам относятся известные операторы AND, OR, NOT, позволяющие выполнять различные логические действия: логическое умножение (AND, "пересечение условий"), логическое сложение (OR, "объединение условий"), логическое отрицание (NOT, "отрицание условий"). В наших примерах мы уже применяли оператор AND. Использование этих операторов позволяет гибко "настроить" условия отбора записей.</p>
</p>
Оператор AND означает, что общий предикат будет истинным только тогда, когда условия, связанные по "AND", будут истинны.</p>
Оператор OR означает, что общий предикат будет истинным, когда хотя бы одно из условий, связанных по "OR", будет истинным.</p>
Оператор NOT означает, что общий предикат будет истинным, когда условие, перед которым стоит этот оператор, будет ложным.</p>
</p>
В одном предикате логические операторы выполняются в следующем порядке: сначала выполняется оператор NOT, затем - AND и только после этого - оператор OR. Для изменения порядка выполнения операторов разрешается использовать скобки.</p>
</p>
SELECT first_name, last_name, dept_no,</p>
       job_code, salary</p>
FROM employee</p>
WHERE dept_no = 622</p>
   OR job_code = "Eng"</p>
  AND salary &lt;= 40000</p>
ORDER BY last_name                получить список служащих,</p>
                занятых в отделе 622</p>
                          или</p>
                на должности "инженер" с зарплатой</p>
                не выше 40000</p>
</p>
FIRST_NAME   LAST_NAME     DEPT_NO JOB_CODE      SALARY</p>
============ ============= ======= ======== ===========</p>
Jennifer M.  Burbank       622     Eng         53167.50</p>
Phil         Forest        622     Mngr        75060.00</p>
T.J.         Green         621     Eng         36000.00</p>
Mark         Guckenheimer  622     Eng         32000.00</p>
John         Montgomery    672     Eng         35000.00</p>
Bill         Parker        623     Eng         35000.00</p>
Willie       Stansbury     120     Eng         39224.06</p>
</p>
</p>
SELECT first_name, last_name, dept_no,</p>
       job_code, salary</p>
FROM employee</p>
WHERE (dept_no = 622</p>
   OR job_code = "Eng")</p>
  AND salary &lt;= 40000</p>
ORDER BY last_name                получить список служащих,</p>
                занятых в отделе 622</p>
                или на должности "инженер",</p>
                зарплата которых не выше 40000</p>
</p>
FIRST_NAME   LAST_NAME     DEPT_NO JOB_CODE      SALARY</p>
============ ============= ======= ======== ===========</p>
T.J.         Green         621     Eng         36000.00</p>
Mark         Guckenheimer  622     Eng         32000.00</p>
John         Montgomery    672     Eng         35000.00</p>
Bill         Parker        623     Eng         35000.00</p>
Willie       Stansbury     120     Eng         39224.06</p>
</p>
                 Преобразование типов (CAST)</p>
</p>
В SQL имеется возможность преобразовать значение столбца или функции к другому типу для более гибкого использования операций сравнения. Для этого используется функция CAST.</p>
Типы данных могут быть конвертированы в соответствии со следующей таблицей:</p>
</p>
Из типа данных                В тип данных</p>
---------------------------------------</p>
NUMERIC                CHAR, VARCHAR, DATE</p>
CHAR, VARCHAR                NUMERIC, DATE</p>
DATE                CHAR, VARCHAR, DATE</p>
</p>
</p>
SELECT first_name, last_name, dept_no</p>
FROM employee</p>
WHERE CAST(dept_no AS char(20))</p>
      CONTAINING "00"                получить список сотрудников,</p>
                занятых в отделах,</p>
                номера которых содержат "00"</p>
</p>
FIRST_NAME      LAST_NAME            DEPT_NO</p>
=============== ==================== =======</p>
Robert          Nelson               600</p>
Terri           Lee                  000</p>
Stewart         Hall                 900</p>
Walter          Steadman             900</p>
Mary S.         MacDonald            100</p>
Oliver H.       Bender               000</p>
Kelly           Brown                600</p>
Michael         Yanowski             100</p>
</p>
                 Изменение порядка выводимых строк (ORDER BY)</p>
</p>
Порядок выводимых строк может быть изменен с помощью опционального (дополнительного) предложения ORDER BY в конце SQL-запроса. Это предложение имеет вид:</p>
</p>
ORDER BY &lt;порядок строк&gt; [ASC | DESC]</p>
</p>
Порядок строк может задаваться одним из двух способов:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;&epsilon;0/\ столбцов</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        номерами столбцов.</td></tr></table></div></p>
Способ упорядочивания определяется дополнительными зарезервированными словами ASC и DESC. Способом по умолчанию - если ничего не указано - является упорядочивание "по возрастанию" (ASC). Если же указано слово "DESC", то упорядочивание будет производиться "по убыванию".</p>
Подчеркнем еще раз, что предложение ORDER BY должно указываться в самом конце запроса.</p>
                 Упорядочивание с использованием имен столбцов</p>
</p>
</p>
SELECT first_name, last_name, dept_no,</p>
       job_code, salary</p>
FROM employee</p>
ORDER BY last_name                получить список сотрудников,</p>
                упорядоченный по фамилиям</p>
                в алфавитном порядке</p>
</p>
FIRST_NAME   LAST_NAME     DEPT_NO JOB_CODE      SALARY</p>
============ ============= ======= ======== ===========</p>
Janet        Baldwin       110     Sales       61637.81</p>
Oliver H.    Bender        000     CEO        212850.00</p>
Ann          Bennet        120     Admin       22935.00</p>
Dana         Bishop        621     Eng         62550.00</p>
Kelly        Brown         600     Admin       27000.00</p>
Jennifer M.  Burbank       622     Eng         53167.50</p>
Kevin        Cook          670     Dir        111262.50</p>
Roger        De Souza      623     Eng         69482.62</p>
Roberto      Ferrari       125     SRep     99000000.00</p>
...</p>
</p>
</p>
SELECT first_name, last_name, dept_no,</p>
       job_code, salary</p>
FROM employee</p>
ORDER BY last_name DESC                получить список сотрудников,</p>
                упорядоченный по фамилиям</p>
                в порядке, обратном  алфавитному</p>
</p>
FIRST_NAME   LAST_NAME     DEPT_NO JOB_CODE      SALARY</p>
============ ============= ======= ======== ===========</p>
Katherine    Young         623     Mngr        67241.25</p>
Bruce        Young         621     Eng         97500.00</p>
Michael      Yanowski      100     SRep        44000.00</p>
Takashi      Yamamoto      115     SRep      7480000.00</p>
Randy        Williams      672     Mngr        56295.00</p>
K. J.        Weston        130     SRep        86292.94</p>
Claudia      Sutherland    140     SRep       100914.00</p>
Walter       Steadman      900     CFO        116100.00</p>
Willie       Stansbury     120     Eng         39224.06</p>
Roger        Reeves        120     Sales       33620.62</p>
...</p>
</p>
Столбец, определяющий порядок вывода строк, не обязательно дожен присутствовать в списке выбираемых элементов (столбцов):</p>
</p>
SELECT first_name, last_name, dept_no,</p>
       job_code</p>
FROM employee</p>
ORDER BY salary                получить список сотрудников,</p>
                упорядоченный по их зарплате</p>
</p>
FIRST_NAME      LAST_NAME       DEPT_NO JOB_CODE</p>
=============== =============== ======= ========</p>
Ann             Bennet          120     Admin</p>
Kelly           Brown           600     Admin</p>
Sue Anne        O'Brien         670     Admin</p>
Mark            Guckenheimer    622     Eng</p>
Roger           Reeves          120     Sales</p>
Bill            Parker          623     Eng</p>
                 Упорядочивание с использованием номеров столбцов</p>
</p>
</p>
SELECT first_name, last_name, dept_no,</p>
       job_code, salary * 1.1</p>
FROM employee</p>
ORDER BY 5                получить список сотрудников,</p>
                упорядоченный по их зарплате</p>
                с 10% надбавкой</p>
</p>
FIRST_NAME   LAST_NAME     DEPT_NO JOB_CODE</p>
============ ============= ======= ======== ===========</p>
Ann          Bennet        120     Admin        25228.5</p>
Kelly        Brown         600     Admin          29700</p>
Sue Anne     O'Brien       670     Admin        34402.5</p>
Mark         Guckenheimer  622     Eng            35200</p>
Roger        Reeves        120     Sales     36982.6875</p>
Bill         Parker        623     Eng            38500</p>
</p>
Допускается использование нескольких уровней вложенности при упорядочивании выводимой информации по столбцам; при этом разрешается смешивать оба способа.</p>
</p>
SELECT first_name, last_name, dept_no,</p>
       job_code, salary * 1.1</p>
FROM employee</p>
ORDER BY dept_no, 5 DESC, last_name</p>
                получить список сотрудников,</p>
                упорядоченный сначала по</p>
                номерам отделов,</p>
                в отделах - по убыванию их</p>
                зарплаты (с 10%),</p>
                а в пределах одной зарплаты -                 по фамилиям</p>
</p>
FIRST_NAME  LAST_NAME  DEPT_NO JOB_CODE</p>
=========== ========== ======= ======== ===============</p>
Oliver H.   Bender     000     CEO               234135</p>
Terri       Lee        000     Admin            59172.3</p>
Mary S.     MacDonald  100     VP             122388.75</p>
Michael     Yanowski   100     SRep     48400.000000001</p>
Luke        Leung      110     SRep             75685.5</p>
Janet       Baldwin    110     Sales        67801.59375</p>
Takashi     Yamamoto   115     SRep     8228000.0000001</p>
Yuki        Ichida     115     Eng      6600000.0000001</p>
                 Устранение дублирования (модификатор DISTINCT)</p>
</p>
Дублированными являются такие строки в результирующей таблице, в которых идентичен каждый столбец.</p>
Иногда (в зависимости от задачи) бывает необходимо устранить все повторы строк из результирующего набора. Этой цели служит модификатор DISTINCT. Данный модификатор может быть указан только один раз в списке выбираемых элементов и действует на весь список.</p>
</p>
SELECT job_code</p>
FROM employee                получить список должностей сотрудников</p>
</p>
JOB_CODE</p>
========</p>
VP</p>
Eng</p>
Eng</p>
Mktg</p>
Mngr</p>
SRep</p>
Admin</p>
Finan</p>
Mngr</p>
Mngr</p>
Eng</p>
...</p>
</p>
Данный пример некорректно решает задачу "получения" списка должностей сотрудников предприятия, так как в нем имеются многочисленные повторы, затрудняющие восприятие информации. Тот же запрос, включающий модификатор DISTINCT, устраняющий дублирование, дает верный результат.</p>
</p>
SELECT DISTINCT job_code</p>
FROM employee                 получить список должностей сотрудников</p>
</p>
JOB_CODE</p>
========</p>
Admin</p>
CEO</p>
CFO</p>
Dir</p>
Doc</p>
Eng</p>
Finan</p>
Mktg</p>
Mngr</p>
PRel</p>
SRep</p>
Sales</p>
VP</p>
</p>
Два следующих примера показывают, что модификатор DISTINCT действует на всю строку сразу.</p>
</p>
SELECT first_name, last_name</p>
FROM employee</p>
WHERE first_name = "Roger"                получить список служащих,</p>
                имена которых - Roger</p>
</p>
FIRST_NAME      LAST_NAME</p>
=============== ====================</p>
Roger           De Souza</p>
Roger           Reeves</p>
</p>
</p>
SELECT DISTINCT first_name, last_name</p>
FROM employee</p>
WHERE first_name = "Roger"                получить список служащих,</p>
                имена которых - Roger</p>
</p>
FIRST_NAME      LAST_NAME</p>
=============== ====================</p>
Roger           De Souza</p>
Roger           Reeves</p>
</p>
                 Соединение (JOIN)</p>
</p>
Операция соединения используется в языке SQL для вывода связанной информации, хранящейся в нескольких таблицах, в одном запросе. В этом проявляется одна из наиболее важных особенностей запросов SQL - способность определять связи между многочисленными таблицами и выводить информацию из них в рамках этих связей. Именно эта операция придает гибкость и легкость языку SQL.</p>
После изучения этого раздела мы будем способны:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        соединять данные из нескольких таблиц в единую результирующую таблицу;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        задавать имена столбцов двумя способами;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        записывать внешние соединения;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        создавать соединения таблицы с собой.</td></tr></table></div></p>
Операции соединения подразделяются на два вида - внутренние и внешние. Оба вида соединений задаются в предложении WHERE запроса SELECT с помощью специального условия соединения. Внешние соединения (о которых мы поговорим позднее) поддерживаются стандартом ANSI-92 и содержат зарезервированное слово "JOIN", в то время как внутренние соединения (или просто соединения) могут задаваться как без использования такого слова (в стандарте ANSI-89), так и с использованием слова "JOIN" (в стандарте ANSI-92).</p>
Связывание производится, как правило, по первичному ключу одной таблицы и внешнему ключу другой таблицы - для каждой пары таблиц. При этом очень важно учитывать все поля внешнего ключа, иначе результат будет искажен. Соединяемые поля могут (но не обязаны!) присутствовать в списке выбираемых элементов. Предложение WHERE может содержать множественные условия соединений. Условие соединения может также комбинироваться с другими предикатами в предложении WHERE.</p>
</p>
                 Внутренние соединения</p>
</p>
Внутреннее соединение возвращает только те строки, для которых условие соединения принимает значение true.</p>
</p>
SELECT first_name, last_name, department</p>
FROM employee, department</p>
WHERE job_code = "VP"                получить список сотрудников,</p>
                состоящих в должности "вице-</p>
                президент", а также названия</p>
                их отделов</p>
</p>
FIRST_NAME      LAST_NAME        DEPARTMENT</p>
=============== ================ ======================</p>
Robert          Nelson           Corporate Headquarters</p>
Mary S.         MacDonald        Corporate Headquarters</p>
Robert          Nelson           Sales and Marketing</p>
Mary S.         MacDonald        Sales and Marketing</p>
Robert          Nelson           Engineering</p>
Mary S.         MacDonald        Engineering</p>
Robert          Nelson           Finance</p>
Mary S.         MacDonald        Finance</p>
...</p>
</p>
Этот запрос ("без соединения") возвращает неверный результат, так как имеющиеся между таблицами связи не задействованы. Отсюда и появляется дублирование информации в результирующей таблице. Правильный результат дает запрос с использованием операции соединения:</p>
</p>
SELECT first_name, last_name, department</p>
FROM employee, department</p>
WHERE job_code = "VP"</p>
  AND employee.dept_no = department.dept_no</p>
</p>
                имена таблиц</p>
                получить список сотрудников,</p>
                состоящих в должности "вице-</p>
                президент", а также названия</p>
                их отделов</p>
</p>
FIRST_NAME      LAST_NAME        DEPARTMENT</p>
=============== ================ ======================</p>
Robert          Nelson           Engineering</p>
Mary S.         MacDonald        Sales and Marketing</p>
</p>
В вышеприведенном запросе использовался способ непосредственного указания таблиц с помощью их имен. Возможен (а иногда и просто необходим) также способ указания таблиц с помощью алиасов (псевдонимов). При этом алиасы определяются в предложении FROM запроса SELECT и представляют собой любой допустимый идентификатор, написание которого подчиняется таким же правилам, что и написание имен таблиц. Потребность в алиасах таблиц возникает тогда, когда названия столбцов, используемых в условиях соединения двух (или более) таблиц, совпадают, а названия таблиц слишком длинны...</p>
Замечание 1: в одном запросе нельзя смешивать использование написания имен таблиц и их алиасов.</p>
Замечание 2: алиасы таблиц могут совпадать с их именами.</p>
</p>
</p>
SELECT first_name, last_name, department</p>
FROM employee e, department d</p>
WHERE job_code = "VP"</p>
  AND e.dept_no = d.dept_no</p>
</p>
                  алиасы таблиц</p>
                получить список сотрудников,</p>
                состоящих в должности "вице-</p>
                президент", а также названия</p>
                их отделов</p>
</p>
FIRST_NAME      LAST_NAME        DEPARTMENT</p>
=============== ================ ======================</p>
Robert          Nelson           Engineering</p>
Mary S.         MacDonald        Sales and Marketing</p>
</p>
А вот пример запроса, соединяющего сразу три таблицы:</p>
</p>
SELECT first_name, last_name, job_title,</p>
       department</p>
FROM employee e, department d, job j</p>
WHERE d.mngr_no = e.emp_no</p>
  AND e.job_code = j.job_code</p>
  AND e.job_grade = j.job_grade</p>
  AND e.job_country = j.job_country</p>
                получить список сотрудников</p>
                с названиями их должностей</p>
                и названиями отделов</p>
</p>
<p>FIRST_NAME LAST_NAME    JOB_TITLE               DEPARTMENT</p>
<p>========== ============ ======================= ======================</p>
<p>Robert     Nelson       Vice President          Engineering</p>
<p>Phil       Forest       Manager                 Quality Assurance</p>
<p>K. J.      Weston       Sales Representative    Field Office: East Coast</p>
<p>Katherine  Young        Manager                 Customer Support</p>
<p>Chris      Papadopoulos Manager                 Research and Development</p>
<p>Janet      Baldwin      Sales Co-ordinator      Pacific Rim Headquarters</p>
<p>Roger      Reeves       Sales Co-ordinator      European Headquarters</p>
<p>Walter     Steadman     Chief Financial Officer Finance</p>
</p>
В данном примере последние три условия необходимы в силу того, что первичный ключ в таблице JOB состоит из трех полей - см. рис.1.</p>
</p>
Мы рассмотрели внутренние соединения с использованием стандарта ANSI-89. Теперь опишем новый (ANSI-92) стандарт:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        условия соединения записываются в предложении FROM, в котором слева и справа от зарезервированного слова "JOIN" указываются соединяемые таблицы;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        условия поиска, основанные на правой таблице, помещаются в предложение ON;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="18">&#8226;</td><td>        условия поиска, основанные на левой таблице, помещаются в предложение WHERE.</td></tr></table></div></p>
SELECT first_name, last_name, department</p>
FROM employee e JOIN department d</p>
 ON e.dept_no = d.dept_no</p>
AND department = "Customer Support"</p>
WHERE last_name starting with "P"</p>
                получить список  служащих</p>
                (а заодно и название отдела),</p>
                являющихся сотрудниками отдела</p>
                "Customer Support", фамилии кото-</p>
                рых начинаются с буквы "P"</p>
</p>
FIRST_NAME    LAST_NAME       DEPARTMENT</p>
============= =============== ===================</p>
Leslie        Phong           Customer Support</p>
Bill          Parker          Customer Support</p>
</p>
                 Самосоединения</p>
</p>
В некоторых задачах необходимо получить информацию, выбранную особым образом только из одной таблицы. Для этого используются так называемые самосоединения, или рефлексивные соединения. Это не отдельный вид соединения, а просто соединение таблицы с собой с помощью алиасов. Самосоединения полезны в случаях, когда нужно получить пары аналогичных элементов из одной и той же таблицы.</p>
</p>
SELECT one.last_name, two.last_name,</p>
       one.hire_date</p>
FROM employee one, employee two</p>
WHERE one.hire_date = two.hire_date</p>
  AND one.emp_no &lt; two.emp_no</p>
                получить пары фамилий сотрудников,</p>
                которые приняты на работу в один</p>
                и тот же день</p>
</p>
LAST_NAME            LAST_NAME              HIRE_DATE</p>
==================== ==================== ===========</p>
Nelson               Young                28-DEC-1988</p>
Reeves               Stansbury            25-APR-1991</p>
Bishop               MacDonald             1-JUN-1992</p>
Brown                Ichida                4-FEB-1993</p>
</p>
</p>
SELECT d1.department, d2.department, d1.budget</p>
FROM department d1, department d2</p>
WHERE d1.budget = d2.budget</p>
  AND d1.dept_no &lt; d2.dept_no</p>
                получить список пар отделов с</p>
                одинаковыми годовыми бюджетами</p>
</p>
<p>DEPARTMENT                DEPARTMENT                   BUDGET</p>
<p>========================  ========================= =========</p>
<p>Software Development      Finance                   400000.00</p>
<p>Field Office: East Coast  Field Office: Canada      500000.00</p>
<p>Field Office: Japan       Field Office: East Coast  500000.00</p>
<p>Field Office: Japan       Field Office: Canada      500000.00</p>
<p>Field Office: Japan       Field Office: Switzerland 500000.00</p>
<p>Field Office: Singapore   Quality Assurance         300000.00</p>
<p>Field Office: Switzerland Field Office: East Coast  500000.00</p>
</p>
                 Внешние соединения</p>
</p>
Напомним, что внутреннее соединение возвращает только те строки, для которых условие соединения принимает значение true. Иногда требуется включить в результирующий набор большее количество строк.</p>
Вспомним, запрос вида</p>
</p>
SELECT first_name, last_name, department</p>
FROM employee e, department d</p>
WHERE e.dept_no = d.dept_no</p>
</p>
<p>возвращает только те строки, для которых условие соединения    (e.dept_no = d.dept_no)  принимает значение true.</p>
Внешнее соединение возвращает все строки из одной таблицы и только те строки из другой таблицы, для которых условие соединения принимает значение true. Строки второй таблицы, не удовлетворяющие условию соединения (т.е. имеющие значение false), получают значение null в результирующем наборе.</p>
</p>
Существует два вида внешнего соединения:  LEFT JOIN  и   RIGHT JOIN.</p>
</p>
В левом соединении (LEFT JOIN) запрос возвращает все строки из левой таблицы (т.е. таблицы, стоящей слева от зарезервированного словосочетания "LEFT JOIN") и только те из правой таблицы, которые удовлетворяют условию соединения. Если же в правой таблице не найдется строк, удовлетворяющих заданному условию, то в результате они замещаются значениями null.</p>
Для правого соединения - все наоборот.</p>
</p>
SELECT first_name, last_name, department</p>
FROM employee e LEFT JOIN department d</p>
  ON e.dept_no = d.dept_no</p>
                получить список сотрудников</p>
                и название их отделов,</p>
                включая сотрудников, еще</p>
                не назначенных ни в какой отдел</p>
</p>
FIRST_NAME      LAST_NAME      DEPARTMENT</p>
=============== ============== =====================</p>
Robert          Nelson         Engineering</p>
Bruce           Young          Software Development</p>
Kim             Lambert        Field Office: East Coast</p>
Leslie          Johnson        Marketing</p>
Phil            Forest         Quality Assurance</p>
...</p>
</p>
В данном запросе все сотрудники оказались распределены по отделам, иначе названия отделов заместились бы значением null.</p>
</p>
А вот пример правого соединения:</p>
</p>
SELECT first_name, last_name, department</p>
FROM employee e RIGHT JOIN department d</p>
  ON e.dept_no = d.dept_no</p>
                получить список сотрудников</p>
                и название их отделов,</p>
                включая отделы, в которые еще</p>
                не назначены сотрудники</p>
</p>
FIRST_NAME      LAST_NAME     DEPARTMENT</p>
=============== ============= =========================</p>
Terri           Lee           Corporate Headquarters</p>
Oliver H.       Bender        Corporate Headquarters</p>
Mary S.         MacDonald     Sales and Marketing</p>
Michael         Yanowski      Sales and Marketing</p>
Robert          Nelson        Engineering</p>
Kelly           Brown         Engineering</p>
Stewart         Hall          Finance</p>
Walter          Steadman      Finance</p>
Leslie          Johnson       Marketing</p>
Carol           Nordstrom     Marketing</p>
&lt;null&gt;          &lt;null&gt;        Software Products Div.</p>
Bruce           Young         Software Development</p>
...</p>
</p>
В результирующий набор входит и отдел "Software Products Div." (а также отдел "Field Office: Singapore", не представленный здесь), в котором еще нет ни одного сотрудника.</p>

