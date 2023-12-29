---
Title: Формат операторов Informix-4GL
Date: 01.01.2007
---


Формат операторов Informix-4GL
==============================

::: {.date}
01.01.2007
:::

Формат операторов INFORMIX-4GL.

Типы данных и выражения над переменными.

   INTEGER       SERIAL\[(n0)\]   CHAR(n)        DATE

   SMALLINT      DECIMAL(m,n)   DATETIME qualif1 TO qualif2

   REAL          MONEY(m,n)     INTERVAL qualif1 TO qualif2

   FLOAT         RECORD         ARRAY \[i,j,k\] OF  datatype

где qualif \\in {YEAR,MONTH,DAY,HOUR,MINUTE,SECOND,FRACTION(n)}


Операции числовые: ** * / mod + - ( )
Все аргументы, в том числе CHAR, преобразуются к типу DECIMAL
Внимание: -7 mod 3 = -1
Внимание: mod и ** нельзя использовать в операторе SELECT

Можно пользоваться встроенными функциями 4GL (см. "Функции 4GL") и
функциями на языке Си.

Операции над строками:

               string1,string2            сцепить

               string   \[m,n\]             подстрока

               string   CLIPPED           усечь пробелы справа

               string   USING "формат"    форматировать

               string   WORDWRAP     переносить длинную строку

Выражения над датами:

                     time + interval = time

                     time - time = interval

Логические выражения:

             =, != или \<\>, \<=,\>=, \<,\>

              NOT,  OR,  AND

             выражение IS \[NOT\] NULL

                                  по умолчанию "\\"

       string \[NOT\] LIKE "шаблон" \[ESCAPE "escape-char"\]

        спецсимволы шаблона % \_  означают ¦ §!

       string \[NOT\] MATCHES "шаблон" \[ESCAPE "esc-char"\]

        спецсимволы шаблона *  ? \[  abH  \]  \[\^  d  -  z  \]

        означают "много", "один", "любой из", "ни один из"

Системные переменные:



Устанавливаются после любого оператора 4GL

status            { 0 \| NOTFOUND \| \<0 } код завершения оператора
quit\_flag ( не 0 если было нажато QUIT ) int\_flag ( не 0 если было
нажато \^C ) define SQLCA record \# системная запись с кодами завершения
SQLCODE integer,="status" SQLERRM char(71), ­- SQLERRP char(8), ­-
SQLERRD array\[8\] of int,...„см. SQLAWARN char(8) warning или пробел
end record SQLERRD\[1\] зарезервирован SQLERRD\[2\] serial значение или
ISAM error cod SQLERRD\[3\] число обработанных строк SQLERRD\[4\] CPU
cost запроса SQLERRD\[5\] offset of error into SQL-st SQLERRD\[6\] ROWID
of last row SQLERRD\[7\] зарезервирован SQLERRD\[8\] зарезервирован

Операторы организации программы.

    MAIN            Главный блок (должен быть ровно один)
      .  .  .
    END MAIN
    CALL function-name ([список аргументов]) [RETURNING возвр. знач]
    FUNCTION function-name ([список аргументов])
            .  .  .                 Аргументы передаются
            [RETURN expr-list]      по значению
            .  .  .
    END FUNCTION
    REPORT  report-name(variable-list) 
            [DEFINE-statement]
                    .  .  .
            [OUTPUT
                    output-statement
                    .  .  .]
            [ORDER [EXTERNAL] BY sort-list
             FORMAT
                    format-statement
                    .  .  .
                    4gl-statement
                    .  .  .
    END REPORT

Генерация отчетов.

START  REPORT report-name

     \[TO {file-name \| PRINTER \| PIPE program}\]

OUTPUT TO  REPORT  report-name (выражение, выражение \[, ...\])

FINISH REPORT report-name

Объявления переменных.

DEFINE  список переменных { type \| LIKE table.column

              \| RECORD {LIKE table.* \| список переменных \[,..\]

                                       END RECORD} } \[,...\]

       где type может быть следующим:

       INTEGER       CHAR(n)       DATE

       SMALLINT      DECIMAL(m,n)  DATETIME qualif1 TO qualif2

       REAL          MONEY(m,n)    INTERVAL qualif1 TO qualif2

       FLOAT         RECORD        ARRAY \[i,j,k\] OF  datatype

  где qualif Ё {YEAR,MONTH,DAY,HOUR,MINUTE,SECOND,FRACTION(n)}

GLOBALS   { "файл с GLOBALS объявлениями" \|

       DEFINE-st    Должен лежать вне любого блока во всех

         .  .  .    модулях, где эти переменные используются

END GLOBALS }

Присвоения.

INITIALIZE  список переменных {LIKE column-list \| TO NULL}

   присвоить переменным NULL или DEFAULT значения

LET  переменная = выражение

Перехват прерываний.

WHENEVER { ERROR \| WARNING \| NOT FOUND }

      { GOTO \[:\]label \| CALL function-name \| CONTINUE \| STOP }

                       !!!    function-name без () !!!

DEFER  INTERRUPT   Запретить прерывание программы клавишей \^C

DEFER  QUIT        Запретить прерывание программы клавишей QUIT

Тогда после нажатия QUIT =\> quit\_flag!=0,  \^C =\> int\_flag!=0

Программные операторы.

CALL function(\[список аргументов\]) \[RETURNING список переменных\]

             ! ! ! передача по значению

CASE                               CASE   (выражение)

  WHEN логич.выраж.                   WHEN  выраж1

     .  .  .            или              .  .  .

     \[EXIT CASE\]                         \[EXIT CASE\]

     .  .  .                             .  .  .

  WHEN логич.выраж.                   WHEN  выраж2

     .  .  .                             .  .  .

\[OTHERWISE\]                         \[OTHERWISE\]

     .  .  .                             .  .  .

END CASE                           END CASE

IF  логическое выражение THEN

       .  .  .

      \[ELSE

       .  .  . \]

END IF    не забывайте закрывать все операторы IF !!!

FOR     I= i1 TO i2  \[STEP i3\]

       statement

         .  .  .

       \[CONTINUE FOR\]

         .  .  .

       \[EXIT FOR\]

         .  .  .

END FOR

CONTINUE { FOR \| FOREACH \| MENU \| WHILE }

EXIT  { CASE \| WHILE \| FOR \| FOREACH \| MENU \| INPUT \| DISPLAY

\| PROGRAM\[(status code for UNIX)\] }

WHILE  логическое выражение

       операторы . . .

         .  .  .

       \[CONTINUE WHILE\]

         .  .  .

       \[EXIT WHILE\]

         .  .  .

END WHILE

GOTO \[:\] метка          Двоеточие \':\' для совместимости с ANSI
стандартом

LABEL метка:      Действует только внутри блока

RUN {"командная строка UNIX"\|char-variable} \[RETURNING int-variable

                                            \| WITHOUT WAITING\]

SLEEP   целое-выраж.    Подождать n  секунд

Меню, окна.

MENU  "Название меню"

   COMMAND { KEY (key-list) \|

   \[KEY (key-list)\] "kоманда меню"

                       \[" подсказка help"\] \[HELP help-number\] }

           Либо key, либо первая буква, обязаны быть латинскими.

             statement

             .  .  .

             \[CONTINUE MENU\]

             .  .  .

             \[EXIT MENU\]

             .  .  .

             \[NEXT OPTION "kоманда меню"           \#  Перейти к

    \[COMMAND  .  .  .        \]

     . . .

END MENU

OPTIONS   {                        По умолчанию:

    PROMPT  LINE  p \|                  FIRST

    MESSAGE LINE  m \|                  FIRST + 1

    FORM    LINE  f \|                  FIRST + 2

    COMMENT LINE  c \|                  LAST \[-1\]

    ERROR   LINE  e \|                  LAST

    INPUT { WRAP \| NO WRAP } \|         NO WRAP

    INSERT    KEY   key-name \| Вставить F1   !! Не применять:

    DELETE    KEY   key-name \| Удал. стр F2   CONTROL-A,D,H,L,

    NEXT      KEY   key-name \| Страница F3   CONTROL-Q,R,X, 

    PREVIOUS  KEY   key-name \| Страница F4   CONTROL-C,S,Q,Z

    ACCEPT    KEY   key-name \|           ESC

    HELP    FILE "help-file" \| Предварительно откомпилированный

    HELP      KEY   key-name \|   CONTROL-W   утилитой mkmessage

    INPUT ATTRIBUTE(список атрибутов) \|

    DISPLAY ATTRIBUTE(список атрибутов)

          } \[,...\]      атрибуты:

      NORMAL     REVERSE        FORM    использовать атрибуты

      BOLD        UNDERLINE      WINDOW   текущего окна

      INVISIBLE  BLINK

OPEN WINDOW window-name AT row, column

  WITH { integer ROWS, integer COLUMNS \| FORM "form-file" }

    \[ATTRIBUTE(список аттрибутов)\]

       Атрибуты:  BORDER     По умолчанию: нет

       BOLD, DIM, INVISIBLE, NORMAL       NORMAL

             REVERSE, UNDERLINE, BLINK     нет

                  PROMPT LINE  n          FIRST

                  MESSAGE LINE m          FIRST + 1

                  FORM    LINE m          FIRST + 2

                  COMMENT LINE m          LAST

CURRENT WINDOW IS { window name \| SCREEN }

CLEAR  {SCREEN \| WINDOW window-name \| FORM \| список полей}

CLOSE WINDOW window-name

OPEN FORM form-name FROM "form-file"    Без расширения .frm

DISPLAY FORM form-name \[ATTRIBUTE(список аттрибутов)\]

CLOSE FORM form-name

Простые операторы вывода на экран.

MESSAGE список переменных, констант \[ATTRIBUTE(список атрибутов)\]

ERROR список переменных, констант \[ATTRIBUTE(список атрибутов)\]

                               по умолчанию REVERSE

PROMPT список переменных и констатнт

\[ATTRIBUTE(аттрибуты вывода)\] FOR \[CHAR\] variable

\[HELP help-number\]             \# Ввести значение в variable

\[ATTRIBUTE(аттрибуты ввода)\]   \# FOR CHAR - ввести один символ

\[ON KEY (key-list)

   statement               атрибуты: NORMAL     REVERSE

     .  .  .                         BOLD       UNDERLINE

.  .  .                              DIM        BLINK

END PROMPT\]                           INVISIBLE

в ON  KEY  пункте нельзя напрямую пользоваться операторами

PROMPT, INPUT.Для их вызова применяйте функции.

Ввод/вывод через экранные формы.

Вывести в форму

DISPLAY { BY NAME список переменных \|

список переменных TO {список полей\|screen-record\[\[n\]\].*}\[,..\] \|

список переменных AT row, column }

\[ATTRIBUTE(список атрибутов)\]

                   \[Не стирать значений из формы перед вводом\]

INPUT { BY NAME список переменных \[WITHOUT DEFAULTS\] \|

       список переменных \[WITHOUT DEFAULTS\] FROM

        {список полей \| screen-record\[\[n\]\].*}\[,...\]}

\[ATTRIBUTE(список атрибутов)\]

\[HELP help-number\]

      \[ { BEFORE FIELD подсписок полей     по клавише ESC

        \| AFTER  { FIELD подсписок полей \| INPUT }

        \| ON KEY (key-list) }

               statement . . .

              \[NEXT FIELD field-name\]

              \[EXIT INPUT\]

               statement . . .

         .  .  .

END INPUT  \]

конструирует WHERE условие для QUERY BY EXAMPLE

CONSTRUCT {BY NAME char-variable ON column-list \|

          char-variable ON column-list FROM

           {список полей \| screen-record\[\[n\]\].*}\[,...\]}

       \[ATTRIBUTE(список атрибутов)\]

В полях могут использоваться служебные символы:

    +-----------------------+-----------------------+-----------------------+
    | символ:               | пример:               | назначение:           |
    +-----------------------+-----------------------+-----------------------+
    | *                    | *X                   | произвольная строка   |
    +-----------------------+-----------------------+-----------------------+
    | ?                     | X?                    | произвольный символ   |
    +-----------------------+-----------------------+-----------------------+
    | \|                    | abc\|cdef             | или                   |
    +-----------------------+-----------------------+-----------------------+
    | \>,\<,\>=,\<=,\<\>    | \>X                   |                       |
    +-----------------------+-----------------------+-----------------------+
    | :                     | X:YW                  | промежуток            |
    +-----------------------+-----------------------+-----------------------+
    | ..                    | Date..Date            | промежуток между      |
    |                       |                       | датами                |
    +-----------------------+-----------------------+-----------------------+

call set\_count(кол-во выводимых строк) в программном массиве

DISPLAY ARRAY record-array TO screen-array.*

\[ATTRIBUTE(список атрибутов)\]

     \[  ON KEY (key-list)

               .  .  .

        \[EXIT DISPLAY\]

               .  .  .

END DISPLAY \] \| \[END DISPLAY\]

SCROLL {field-list \| screen-record.*} \[,...} Прокрутить строки

       {UP \| DOWN} \[BY int\]                 в экранном массиве

call set\_count(кол-во выводимых строк) в программном массиве

INPUT ARRAY record-array \[WITHOUT DEFAULTS\]

FROM   screen-array.*  \[HELP help-number\] \[ATTRIBUTE(атр.)\]

\[{BEFORE {ROW \| INSERT \| DELETE \| FIELD подсписок полей}\[,...\]

\| AFTER {ROW\|INSERT\|DELETE\|FIELD подсписок полей \|INPUT}\[,...\]

\| ON KEY (key-list) }

         statement  ...

        \[NEXT FIELD field-name\]

         statement...

        \[EXIT INPUT\]

          .  .  .

     .  .  .

END INPUT \]

  Внутри оператора DISPLAY ARRAY можно пользоваться функциями:

       arr\_curr()  номер текущей строки прогр. массива

       arr\_count() число заполненных строки прогр. массива

       scr\_line()  номер текущей строки экр. массива

       CALL showhelp(helpnumber) - вывести help

Динамическое создание операторов.

PREPARE statement-id FROM {char-variable \| "SQL-оператор \[ы\] "}

Изготовить SQL - statement из символьной строки

Нельзя включать имена переменных, нужно заменять их на знак ?

Нельзя готовить операторы:

DECLARE         PREPARE         LOAD

OPEN            EXECUTE         UNLOAD

CLOSE           FETCH        SELECT INTO variables

EXECUTE statment-id \[USING input-list\]

  Выполняет, заменив знаки ? на input-list

FREE   { statment-id \| cursor-name }

Манипуляция "курсором".

DECLARE cursor-name \[SCROLL\] CURSOR \[WITH HOLD\] FOR

       { SELECT-st \[FOR UPDATE \[OF column-list\]\] \|

         INSERT-st   \|  statment-id }

              SCROLL - фактически, создается временная таблица.

               statment-id - приготовленого PREPARE

               HOLD - игнорировать конец транзакции

Внимание: SCROLL cursor нельзя открывать FOR UPDATE,  зато для не-SCROLL
cursora можно использовать

Внимание: оператор DECLARE cursor-name должен располагаться в тексте
программы выше любого использования этого курсора.

OPEN  cursor-name \[USING список переменных\]

CLOSE cursor-name

               для SELECT-курсора:

FOREACH cursor-name \[INTO список переменных\]

         .  .  .

       \[CONTINUE FOREACH\]

         .  .  .

       \[EXIT FOREACH\]

         .  .  .

END FOREACH

FETCH { NEXT \| PREVIOUS \| FIRST \| LAST \| CURRRENT \|

       RELATIVE m \| ABSOLUTE n \] cursor-name

       \[INTO список переменных\]

    если cursor not  SCROLL то можно только NEXT

    если строки не обнаружено, то status=NOTFOUND

               для INSERT-курсора:

PUT cursor-name \[FROM список переменных\] ввести строку в буфер,

\[заменив знаки ? для DECLAREd INSERT-st на список переменных\]

FLUSH cursor-name   вытолкнуть буфер

              \^\^  SQL операторы \^\^

Описания CREATE, DROP, DATABASE, ALTER, RENAME

Манипуляция данными DELETE, INSERT, UPDATE, LOAD, UNLOAD

Оператор SELECT

Права доступа GRANT/REVOKE, LOCK/UNLOCK TABLE, SET LOCK MODE

Операторы транзакции и восстановления BEGIN WORK, COMMIT WORK, ROLLBACK
WORK, START DATABASE, ...

Операторы описания данных.

Операторы описания данных не откатываются !

CREATE DATABASE db-name \[WITH LOG IN "pathname" \[MODE ANSI\]\]

Стандарт ansi требует имя владельца, транзакция по умолчанию

DROP DATABASE { database-name \| char-variable }

DATABASE database-name \[EXCLUSIVE\]        Сделать текущей

CLOSE DATABASE

CREATE \[TEMP\] TABLE table-name( column-name datatype \[NOT NULL\]

                    \[UNIQUE \[CONSTRAINT constr-name\]\] \[,...\] )

       \[UNIQUE(uniq-col-list) \[CONSTRAINT constr-name\] \] \[,..\]

       \[WITH NO LOG\]

       \[IN "pathname-directory"\]

где datatype может быть:

   INTEGER        SERIAL\[(n0)\]   DATE

   SMALLINT      DECIMAL(m,n)   DATETIME qualif1 TO qualif2

   REAL          MONEY(m,n)     INTERVAL qualif1 TO qualif2

   FLOAT         CHAR(n)

qualifier \\in {YEAR,MONTH,DAY,HOUR,MINUTE,SECOND,FRACTION(n)}

ALTER TABLE table-name       \# Недопустим для временых таблиц

    {  ADD ( new-column-name datatype \[NOT NULL\]

               \[UNIQUE \[CONSTRAINT constr-name\]\]\[,...\] )

                   \[BEFORE old-column-name\]

       \|

       DROP (old-column-name\[,...\])

       \|

       MODIFY (old-column-name new-datatype \[NOT NULL\]\[,...\])

       \|

       ADD CONSTRAINT UNIQUE (old-column-name\[,...\])

                                  \[CONSTRAINT constr-name\]

       \|

       DROP CONSTRAINT (constr-name\[,...\])

     } \[,...\]

RENAME TABLE old-table-name TO new-table-name

RENAME COLUMN table.old-column-name TO new-column-name

CREATE VIEW view-name \[(column-list)\]

       AS SELECT-statement \[WITH CHECK OPTION\]

CREATE \[UNIQUE\|DISTINCT\] \[CLUSTER\] INDEX index-name

       ON table-name (column-name \[DESC\], ...)

ALTER INDEX index-name TO \[NOT\] CLUSTER  Упорядочить таблицу

CREATE SYNONYM synonym-name FOR table-name

DROP VIEW    view-name

DROP TABLE   table-name

DROP INDEX   index-name

DROP SYNONYM synonym-name

UPDATE STATISTICS \[FOR TABLE table-name\] В системном каталоге

SET EXPLAIN {ON \| OFF}

Выводить системные объяснения в sqlexplain.out

Операторы манипуляции данными.

DELETE FROM table-name \[WHERE {condition \| CURRENT OF cursor-name}\]

                                          !* Только в 4GL *!

INSERT INTO table-name \[(column-list)\]

     { VALUES (value-list) \| SELECT-statement }

UPDATE table-name SET {column-name ={ expression \| (SELECT-st) }
\[,...\]

\| {(col-list) \| \[table.\]*} =

{ ({ expr-list \| (SELECT-st) } \[,...\]) \| record-name.* }

    \[WHERE {condition \| CURRENT OF cursor-name}\]

                           !* Только в 4GL *!

LOAD FROM "file-name" \[DELIMITER "?"\] { INSERT INTO table

           \[(col-list)\] \| char-variable with INSERT-st }

UNLOAD TO "file" \[DELIMITER "?"\] SELECT-statement

       формат файла по умолчанию:

столбец1\|столбец2\| ... \|\|столбецn\|

                  ...

значение\|значение\| ... значение\|

OUTPUT TO {FILENAME \| PIPE program} \[WITHOUT HEADINGS\] SELECT-st

               только в INFORMIX-SQL

Оператор SELECT.

SELECT \[ALL \| UNIQUE\] column-expr \[col-lable\] \[,...\]

       \[INTO список переменных\]            !* Только в 4GL *!

       FROM { \[OUTER\] table-name \[tab-alias\] \|

          OUTER  (table-expr) } \[,...\] -проверять      условие

                                       только для этой (менее

       \[WHERE condition\]               надежной) таблицы

       \[GROUP BY column-list  \[HAVING condition\] \]

       \[ORDER BY column-name \[DESC\],...\]

       \[INTO TEMP table-name\]

    WHERE conditions:

связанные логическими операторами OR, AND, NOT сравнения

       выраж1 сравнение выраж1

    где сравнение =,\>,\<,\>=,\<=,\<\>,!=

       column-name IS \[NOT\] NULL

       выраж \[NOT\] BETWEEN выраж1 AND выраж2

       выраж \[NOT\] IN (выраж1, ...  \[, ...\] )

                                  по умолчанию "\\"

       строка \[NOT\] LIKE "шаблон" \[ESCAPE "escape-char"\]

        спецсимволы шаблона %  \_  означают "много" "один"

       строка \[NOT\] MATCHES "шаблон" \[ESCAPE "esc-char"\]

        спецсимволы шаблона *  ?   означают "много" "один"

        \[abH\]  \[\^d-z\]  "один из" "ни один из"

       выраж сравнение {ALL \| \[ANY \| SOME\]} (SELECT-оператор)

       выраж \[NOT\] IN (SELECT-оператор)     !* Обыкновенный *!

       \[NOT\] EXISTS  (SELECT-оператор)      !*  SQLевский   *!

Операторы задания прав доступа (не откатываются).

    {DBpriv             {PUBLIC  право давать права

GRANT   \|           TO   \|     \[WITH GRANT OPTION\] \[AS grantor\]

TBpriv \[,..\] ON table}  user-list}            от имени grantor

       {DBpriv

REVOKE   \|                FROM { PUBLIC \| user-list }

  TBpriv \[,..\] ON table}

                                           TABLE PRIVILEGES:

      DATABASE PRIVILEGES:                  ALTER          DELETE

                                         INDEX          INSERT

       CONNECT   работать                     SELECT\[(cols)\]

       RESOURCE  создавать объекты           UPDATE \[(cols)\]

       DBA       все                         ALL \[PRIVILEGES\]

SET LOCK MODE TO \[NOT\] WAIT     ждать \[не ждать\] освобождения

                                               блокир. строк

LOCK TABLE   table-name   IN      {SHARE \| EXCLUSIVE} MODE

                        {Можно смотреть \| Ничего нельзя}

UNLOCK TABLE table-name

Операторы транзакций, восстановления данных.

CREATE DATABASE db-name  WITH LOG IN "/pathname" \[MODE ANSI\]\]

START  DATABASE db-name  WITH LOG IN "/pathname" \[MODE ANSI\]

   стартовать новый системный журнал (log-файл)

DATABASE database-name \[EXCLUSIVE\]  Сделать текущей

ROLLFORWARD DATABASE database-name  Накатить базу из копии

CLOSE DATABASE                     вперед по системному журналу

BEGIN WORK      Начало транзакции   Внимание!! Все

  . . .                        измененные строки блокируются!!

COMMIT WORK     Kонец транзакции

ROLLBACK WORK   Откатить изменения к предыдущему COMMIT

CREATE AUDIT FOR table-name IN "pathname"

  . . .

RECOVER TABLE table-name            Восстановить таблицу

DROP AUDIT FOR table-name

VALIDATE список переменных LIKE column-list   удовлетворяют ли

переменные допустимым значениям для этих столбцов (syscolval)?, если нет
то status\<0

  Примечание: подчеркнутые операторы нельзя использовать в 4GL, а можно
только в INFORMIX-SQL

INFO  { TABLES \| { COLUMNS \| INDEXES \| ACCES \| PRIVILEGES \|

                        STATUS }          FOR table-name }

CHECK  TABLE owner.table-name         Проверить индексы

REPAIR  TABLE table-name               Ремонт индексов
