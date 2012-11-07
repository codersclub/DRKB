<h1>Формат операторов Informix-4GL</h1>
<div class="date">01.01.2007</div>

<p>Типы данных и выражения над переменными.</p>
<p>    INTEGER       SERIAL[(n0)]   CHAR(n)        DATE</p>
<p>    SMALLINT      DECIMAL(m,n)   DATETIME qualif1 TO qualif2</p>
<p>    REAL          MONEY(m,n)     INTERVAL qualif1 TO qualif2</p>
<p>    FLOAT         RECORD         ARRAY [i,j,k] OF  datatype</p>
<p>где qualif \in {YEAR,MONTH,DAY,HOUR,MINUTE,SECOND,FRACTION(n)}</p>
<p> <br>
Операции числовые: ** * / mod + - ( ) <br>
Все аргументы, в том числе CHAR, преобразуются к типу DECIMAL <br>
Внимание: -7 mod 3 = -1 <br>
Внимание: mod и ** нельзя использовать в операторе SELECT <br>
<p>Можно пользоваться встроенными функциями 4GL (см. "Функции 4GL") и функциями на языке Си.</p>
<p>Операции над строками:</p>
<p>                string1,string2            сцепить</p>
<p>                string   [m,n]             подстрока</p>
<p>                string   CLIPPED           усечь пробелы справа</p>
<p>                string   USING "формат"    форматировать</p>
<p>                string   WORDWRAP     переносить длинную строку</p>
<p>Выражения над датами:</p>
<p>                      time + interval = time</p>
<p>                      time - time = interval</p>
<p>Логические выражения:</p>
<p>              =, != или &lt;&gt;, &lt;=,&gt;=, &lt;,&gt;</p>
<p>               NOT ,  OR,  AND</p>
<p>              выражение IS [NOT] NULL</p>
<p>                                   по умолчанию "\"</p>
<p>        string [NOT] LIKE "шаблон" [ESCAPE "escape-char"]</p>
<p>         спецсимволы шаблона  % _  означают &#166; &#167;!</p>
<p>        string [NOT] MATCHES "шаблон" [ESCAPE "esc-char"]</p>
<p>         спецсимволы шаблона  *  ? [  abH  ]  [^  d  -  z  ]</p>
<p>         означают "много", "один", "любой из", "ни один из"</p>
<p>Системные переменные:</p>
<p> <br>
<p>Устанавливаются после любого оператора 4GL</p>
<p>status            { 0 | NOTFOUND | &lt;0 } код завершения оператора quit_flag ( не 0 если было нажато QUIT ) int_flag ( не 0 если было нажато ^C ) define SQLCA record # системная запись с кодами завершения SQLCODE integer,="status" SQLERRM char(71), &#173;- SQLERRP char(8), &#173;- SQLERRD array[8] of int,...&#8222;см. SQLAWARN char(8) warning или пробел end record SQLERRD[1] зарезервирован SQLERRD[2] serial значение или ISAM error cod SQLERRD[3] число обработанных строк SQLERRD[4] CPU cost запроса SQLERRD[5] offset of error into SQL-st SQLERRD[6] ROWID of last row SQLERRD[7] зарезервирован SQLERRD[8] зарезервирован</p>

<p>Операторы организации программы.</p>
<pre>MAIN            Главный блок (должен быть ровно один)
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
</pre>

<p>Генерация отчетов.</p>
<p>START  REPORT report-name</p>
<p>      [TO {file-name | PRINTER | PIPE program}]</p>
<p>OUTPUT TO  REPORT  report-name (выражение, выражение [, ...])</p>
<p>FINISH REPORT report-name</p>
<p>Объявления переменных.</p>
<p>DEFINE  список переменных  { type | LIKE table.column</p>
<p>               | RECORD {LIKE table.* | список переменных [,..]</p>
<p>                                        END RECORD} } [,...]</p>
<p>        где type может быть следующим:</p>
<p>        INTEGER       CHAR(n)       DATE</p>
<p>        SMALLINT      DECIMAL(m,n)  DATETIME qualif1 TO qualif2</p>
<p>        REAL          MONEY(m,n)    INTERVAL qualif1 TO qualif2</p>
<p>        FLOAT         RECORD        ARRAY [i,j,k] OF  datatype</p>
<p>   где qualif &#1025; {YEAR,MONTH,DAY,HOUR,MINUTE,SECOND,FRACTION(n)}</p>
<p>GLOBALS   { "файл с GLOBALS объявлениями" |</p>
<p>        DEFINE-st    Должен лежать вне любого блока во всех</p>
<p>          .  .  .    модулях, где эти переменные используются</p>
<p>END GLOBALS }</p>
<p>Присвоения.</p>
<p>INITIALIZE  список переменных {LIKE column-list | TO NULL}</p>
<p>    присвоить переменным NULL или DEFAULT значения</p>
<p>LET  переменная = выражение</p>
<p>Перехват прерываний.</p>
<p>WHENEVER { ERROR | WARNING | NOT FOUND }</p>
<p>       { GOTO [:]label | CALL function-name | CONTINUE | STOP }</p>
<p>                        !!!    function-name без () !!!</p>
<p>DEFER  INTERRUPT   Запретить прерывание программы клавишей ^C</p>
<p>DEFER  QUIT        Запретить прерывание программы клавишей QUIT</p>
<p>  Тогда после нажатия QUIT =&gt; quit_flag!=0,  ^C =&gt; int_flag!=0</p>
<p>Программные операторы.</p>
<p>CALL function([список аргументов]) [RETURNING список переменных]</p>
<p>              ! ! ! передача по значению</p>
<p>CASE                               CASE   (выражение)</p>
<p>   WHEN логич.выраж.                   WHEN  выраж1</p>
<p>      .  .  .            или              .  .  .</p>
<p>      [EXIT CASE]                         [EXIT CASE]</p>
<p>      .  .  .                             .  .  .</p>
<p>   WHEN логич.выраж.                   WHEN  выраж2</p>
<p>      .  .  .                             .  .  .</p>
<p>  [OTHERWISE]                         [OTHERWISE]</p>
<p>      .  .  .                             .  .  .</p>
<p>END CASE                           END CASE</p>
<p>IF  логическое выражение THEN</p>
<p>        .  .  .</p>
<p>       [ELSE</p>
<p>        .  .  . ]</p>
<p>END IF    не забывайте закрывать все операторы IF !!!</p>
<p>FOR     I= i1 TO i2  [STEP i3]</p>
<p>        statement</p>
<p>          .  .  .</p>
<p>        [CONTINUE FOR]</p>
<p>          .  .  .</p>
<p>        [EXIT FOR]</p>
<p>          .  .  .</p>
<p>END FOR</p>
<p>CONTINUE { FOR | FOREACH | MENU | WHILE }</p>
<p>EXIT  { CASE | WHILE | FOR | FOREACH | MENU | INPUT | DISPLAY</p>
<p>| PROGRAM[(status code for UNIX)] }</p>
<p>WHILE  логическое выражение</p>
<p>        операторы . . .</p>
<p>          .  .  .</p>
<p>        [CONTINUE WHILE]</p>
<p>          .  .  .</p>
<p>        [EXIT WHILE]</p>
<p>          .  .  .</p>
<p>END WHILE</p>
<p>GOTO [:] метка          Двоеточие ':' для совместимости с ANSI стандартом</p>
<p>LABEL метка:      Действует только внутри блока</p>
<p>RUN {"командная строка UNIX"|char-variable} [RETURNING int-variable</p>
<p>                                             | WITHOUT WAITING]</p>
<p>SLEEP   целое-выраж.    Подождать  n  секунд</p>
<p>Меню, окна.</p>
<p>MENU  "Название меню"</p>
<p>    COMMAND { KEY (key-list) |</p>
<p>    [KEY (key-list)] "kоманда меню"</p>
<p>                        [" подсказка help"] [HELP help-number] }</p>
<p>            Либо key, либо первая буква, обязаны быть латинскими.</p>
<p>              statement</p>
<p>              .  .  .</p>
<p>              [CONTINUE MENU]</p>
<p>              .  .  .</p>
<p>              [EXIT MENU]</p>
<p>              .  .  .</p>
<p>              [NEXT OPTION "kоманда меню"           #  Перейти к</p>
<p>     [COMMAND  .  .  .        ]</p>
<p>      . . .</p>
<p>END MENU</p>
<p>OPTIONS   {                        По умолчанию:</p>
<p>     PROMPT  LINE  p |                  FIRST</p>
<p>     MESSAGE LINE  m |                  FIRST + 1</p>
<p>     FORM    LINE  f |                  FIRST + 2</p>
<p>     COMMENT LINE  c |                  LAST [-1]</p>
<p>     ERROR   LINE  e |                  LAST</p>
<p>     INPUT { WRAP | NO WRAP } |         NO WRAP</p>
<p>     INSERT    KEY   key-name | Вставить  F1   !! Не применять:</p>
<p>     DELETE    KEY   key-name | Удал. стр F2   CONTROL-A,D,H,L,</p>
<p>     NEXT      KEY   key-name | Страница  F3   CONTROL-Q,R,X,</p>
<p>     PREVIOUS  KEY   key-name | Страница  F4   CONTROL-C,S,Q,Z</p>
<p>     ACCEPT    KEY   key-name |           ESC</p>
<p>     HELP    FILE "help-file" | Предварительно откомпилированный</p>
<p>     HELP      KEY   key-name |   CONTROL-W   утилитой mkmessage</p>
<p>     INPUT ATTRIBUTE(список атрибутов) |</p>
<p>     DISPLAY ATTRIBUTE(список атрибутов)</p>
<p>           } [,...]      атрибуты:</p>
<p>       NORMAL     REVERSE        FORM    использовать атрибуты</p>
<p>       BOLD        UNDERLINE      WINDOW   текущего окна</p>
<p>       INVISIBLE  BLINK</p>
<p>OPEN WINDOW window-name AT row, column</p>
<p>   WITH { integer ROWS, integer COLUMNS | FORM "form-file" }</p>
<p>     [ATTRIBUTE(список аттрибутов)]</p>
<p>        Атрибуты:  BORDER     По умолчанию: нет</p>
<p>        BOLD, DIM, INVISIBLE, NORMAL       NORMAL</p>
<p>              REVERSE, UNDERLINE, BLINK     нет</p>
<p>                   PROMPT LINE  n          FIRST</p>
<p>                   MESSAGE LINE m          FIRST + 1</p>
<p>                   FORM    LINE m          FIRST + 2</p>
<p>                   COMMENT LINE m          LAST</p>
<p>CURRENT WINDOW IS { window name | SCREEN }</p>
<p>CLEAR  {SCREEN | WINDOW window-name | FORM | список полей}</p>
<p>CLOSE WINDOW window-name</p>
<p>OPEN FORM form-name FROM "form-file"    Без расширения .frm</p>
<p>DISPLAY FORM form-name [ATTRIBUTE(список аттрибутов)]</p>
<p>CLOSE FORM form-name</p>
<p>Простые операторы вывода на экран.</p>
<p>MESSAGE список переменных, констант [ATTRIBUTE(список атрибутов)]</p>
<p>ERROR список переменных, констант [ATTRIBUTE(список атрибутов)]</p>
<p>                                по умолчанию REVERSE</p>
<p>PROMPT список переменных и констатнт</p>
<p> [ATTRIBUTE(аттрибуты вывода)] FOR [CHAR] variable</p>
<p> [HELP help-number]             # Ввести значение в variable</p>
<p> [ATTRIBUTE(аттрибуты ввода)]   # FOR CHAR - ввести один символ</p>
<p> [ON KEY (key-list)</p>
<p>    statement               атрибуты: NORMAL     REVERSE</p>
<p>      .  .  .                         BOLD       UNDERLINE</p>
<p> .  .  .                              DIM        BLINK</p>
<p>END PROMPT]                           INVISIBLE</p>
<p>в  ON  KEY  пункте  нельзя  напрямую  пользоваться  операторами</p>
<p>PROMPT, INPUT.Для их вызова применяйте функции.</p>
<p>Ввод/вывод через экранные формы.</p>
<p>Вывести в форму</p>
<p>DISPLAY { BY NAME список переменных |</p>
<p> список переменных TO {список полей|screen-record[[n]].*}[,..] |</p>
<p> список переменных AT row, column }</p>
<p> [ATTRIBUTE(список атрибутов)]</p>
<p>                    [Не стирать значений из формы перед вводом]</p>
<p>INPUT { BY NAME список переменных [WITHOUT DEFAULTS] |</p>
<p>        список переменных [WITHOUT DEFAULTS] FROM</p>
<p>         {список полей | screen-record[[n]].*}[,...]}</p>
<p> [ATTRIBUTE(список атрибутов)]</p>
<p> [HELP help-number]</p>
<p>       [ { BEFORE FIELD подсписок полей     по клавише ESC</p>
<p>         | AFTER  { FIELD подсписок полей | INPUT }</p>
<p>         | ON KEY (key-list) }</p>
<p>                statement . . .</p>
<p>               [NEXT FIELD field-name]</p>
<p>               [EXIT INPUT]</p>
<p>                statement . . .</p>
<p>          .  .  .</p>
<p>END INPUT  ]</p>
<p>  конструирует WHERE условие для QUERY BY EXAMPLE</p>
<p>CONSTRUCT {BY NAME char-variable ON column-list |</p>
<p>           char-variable ON column-list FROM</p>
<p>            {список полей | screen-record[[n]].*}[,...]}</p>
<p>        [ATTRIBUTE(список атрибутов)]</p>
<p>В полях могут использоваться служебные символы:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>символ:</p>
</td>
<td><p>пример:</p>
</td>
<td><p>назначение:</p>
</td>
</tr>
<tr>
<td><p>*</p>
</td>
<td><p>*X</p>
</td>
<td><p>произвольная строка</p>
</td>
</tr>
<tr>
<td><p>?</p>
</td>
<td><p>X?</p>
</td>
<td><p>произвольный символ</p>
</td>
</tr>
<tr>
<td><p>|</p>
</td>
<td><p>abc|cdef</p>
</td>
<td><p>или</p>
</td>
</tr>
<tr>
<td><p>&gt;,&lt;,&gt;=,&lt;=,&lt;&gt;</p>
</td>
<td><p>&gt;X</p>
</td>
<td>
</td>
</tr>
<tr>
<td><p>:</p>
</td>
<td><p>X:YW</p>
</td>
<td><p>промежуток</p>
</td>
</tr>
<tr>
<td><p>..</p>
</td>
<td><p>Date..Date</p>
</td>
<td><p>промежуток между датами
</td>
</tr>
</table>
<p>call set_count(кол-во выводимых строк) в программном массиве</p>
<p>DISPLAY ARRAY record-array TO screen-array.*</p>
<p> [ATTRIBUTE(список атрибутов)]</p>
<p>      [  ON KEY (key-list)</p>
<p>                .  .  .</p>
<p>         [EXIT DISPLAY]</p>
<p>                .  .  .</p>
<p>END DISPLAY ] | [END DISPLAY]</p>
<p>SCROLL {field-list | screen-record.*} [,...} Прокрутить строки</p>
<p>        {UP | DOWN} [BY int]                 в экранном массиве</p>
<p>call set_count(кол-во выводимых строк) в программном массиве</p>
<p>INPUT ARRAY record-array [WITHOUT DEFAULTS]</p>
<p> FROM   screen-array.*  [HELP help-number] [ATTRIBUTE(атр.)]</p>
<p> [{BEFORE {ROW | INSERT | DELETE | FIELD подсписок полей}[,...]</p>
<p>  | AFTER {ROW|INSERT|DELETE|FIELD подсписок полей |INPUT}[,...]</p>
<p>  | ON KEY (key-list) }</p>
<p>          statement  ...</p>
<p>         [NEXT FIELD field-name]</p>
<p>          statement...</p>
<p>         [EXIT INPUT]</p>
<p>           .  .  .</p>
<p>      .  .  .</p>
<p>END INPUT ]</p>
<p>   Внутри оператора DISPLAY ARRAY можно пользоваться функциями:</p>
<p>        arr_curr()  номер текущей строки прогр. массива</p>
<p>        arr_count() число заполненных строки прогр. массива</p>
<p>        scr_line()  номер текущей  строки экр. массива</p>
<p>        CALL showhelp(helpnumber) - вывести help</p>
<p>Динамическое создание операторов.</p>
<p>PREPARE statement-id FROM {char-variable | "SQL-оператор [ы] "}</p>
<p>  Изготовить SQL - statement из символьной строки</p>
<p>  Нельзя включать имена переменных, нужно заменять их на знак ?</p>
<p>Нельзя готовить операторы:</p>
<p>DECLARE         PREPARE         LOAD</p>
<p>OPEN            EXECUTE         UNLOAD</p>
<p>CLOSE           FETCH        SELECT INTO variables</p>
<p>EXECUTE statment-id [USING input-list]</p>
<p>   Выполняет, заменив знаки ? на input-list</p>
<p>FREE   { statment-id | cursor-name }</p>
<p>Манипуляция "курсором".</p>
<p>DECLARE cursor-name [SCROLL] CURSOR [WITH HOLD] FOR</p>
<p>        { SELECT-st [FOR UPDATE [OF column-list]] |</p>
<p>          INSERT-st   |  statment-id }</p>
<p>               SCROLL - фактически, создается временная таблица.</p>
<p>                statment-id - приготовленого PREPARE</p>
<p>                HOLD - игнорировать конец транзакции</p>
<p>Внимание: SCROLL cursor нельзя открывать FOR UPDATE,  зато  для не-SCROLL cursora можно использовать</p>
<p>Внимание:  оператор  DECLARE cursor-name должен располагаться в тексте программы выше любого использования этого курсора.</p>
<p>OPEN  cursor-name [USING список переменных]</p>
<p>CLOSE cursor-name</p>
<p>                для SELECT-курсора:</p>
<p>FOREACH cursor-name [INTO список переменных]</p>
<p>          .  .  .</p>
<p>        [CONTINUE FOREACH]</p>
<p>          .  .  .</p>
<p>        [EXIT FOREACH]</p>
<p>          .  .  .</p>
<p>END FOREACH</p>
<p>FETCH { NEXT | PREVIOUS | FIRST | LAST | CURRRENT |</p>
<p>        RELATIVE m | ABSOLUTE n ] cursor-name</p>
<p>        [INTO список переменных]</p>
<p>     если cursor not  SCROLL то можно только NEXT</p>
<p>     если строки не обнаружено, то  status=NOTFOUND</p>
<p>                для INSERT-курсора:</p>
<p>PUT cursor-name [FROM список переменных] ввести строку в буфер,</p>
<p>[заменив знаки ? для DECLAREd INSERT-st на список переменных]</p>
<p>FLUSH cursor-name   вытолкнуть буфер</p>
<p>               ^^  SQL операторы  ^^</p>
<p>Описания CREATE, DROP, DATABASE, ALTER, RENAME</p>
<p>Манипуляция данными DELETE, INSERT, UPDATE, LOAD, UNLOAD</p>
<p>Оператор SELECT</p>
<p>Права доступа GRANT/REVOKE, LOCK/UNLOCK TABLE, SET LOCK MODE</p>
<p>Операторы транзакции и восстановления BEGIN WORK, COMMIT WORK, ROLLBACK WORK, START DATABASE, ...</p>
<p>Операторы описания данных.</p>
<p>Операторы описания данных не откатываются !</p>
<p>CREATE DATABASE db-name [WITH LOG IN "pathname" [MODE ANSI]]</p>
<p>Стандарт ansi требует имя владельца, транзакция по умолчанию</p>
<p>DROP DATABASE { database-name | char-variable }</p>
<p>DATABASE database-name [EXCLUSIVE]        Сделать текущей</p>
<p>CLOSE DATABASE</p>
<p>CREATE [TEMP] TABLE table-name( column-name datatype [NOT NULL]</p>
<p>                     [UNIQUE [CONSTRAINT constr-name]] [,...] )</p>
<p>        [UNIQUE(uniq-col-list) [CONSTRAINT constr-name] ] [,..]</p>
<p>        [WITH NO LOG]</p>
<p>        [IN "pathname-directory"]</p>
<p>где datatype может быть:</p>
<p>    INTEGER        SERIAL[(n0)]   DATE</p>
<p>    SMALLINT      DECIMAL(m,n)   DATETIME qualif1 TO qualif2</p>
<p>    REAL          MONEY(m,n)     INTERVAL qualif1 TO qualif2</p>
<p>    FLOAT         CHAR(n)</p>
<p>qualifier \in {YEAR,MONTH,DAY,HOUR,MINUTE,SECOND,FRACTION(n)}</p>
<p>ALTER TABLE table-name       # Недопустим для временых таблиц</p>
<p>     {  ADD ( new-column-name datatype [NOT NULL]</p>
<p>                [UNIQUE [CONSTRAINT constr-name]][,...] )</p>
<p>                    [BEFORE old-column-name]</p>
<p>        |</p>
<p>        DROP (old-column-name[,...])</p>
<p>        |</p>
<p>        MODIFY (old-column-name new-datatype [NOT NULL][,...])</p>
<p>        |</p>
<p>        ADD CONSTRAINT UNIQUE (old-column-name[,...])</p>
<p>                                   [CONSTRAINT constr-name]</p>
<p>        |</p>
<p>        DROP CONSTRAINT (constr-name[,...])</p>
<p>      } [,...]</p>
<p>RENAME TABLE old-table-name TO new-table-name</p>
<p>RENAME COLUMN table.old-column-name TO new-column-name</p>
<p>CREATE VIEW view-name [(column-list)]</p>
<p>        AS SELECT-statement [WITH CHECK OPTION]</p>
<p>CREATE [UNIQUE|DISTINCT] [CLUSTER] INDEX index-name</p>
<p>        ON table-name (column-name [DESC], ...)</p>
<p>ALTER INDEX index-name TO [NOT] CLUSTER  Упорядочить таблицу</p>
<p>CREATE SYNONYM synonym-name FOR table-name</p>
<p>DROP VIEW    view-name</p>
<p>DROP TABLE   table-name</p>
<p>DROP INDEX   index-name</p>
<p>DROP SYNONYM synonym-name</p>
<p>UPDATE STATISTICS [FOR TABLE table-name] В системном каталоге</p>
<p>SET EXPLAIN {ON | OFF}</p>
<p>Выводить системные объяснения в sqlexplain.out</p>
<p>Операторы манипуляции данными.</p>
<p>DELETE FROM table-name [WHERE {condition | CURRENT OF cursor-name}]</p>
<p>                                           !* Только в  4GL *!</p>
<p>INSERT INTO table-name [(column-list)]</p>
<p>      { VALUES (value-list) | SELECT-statement }</p>
<p>UPDATE table-name SET {column-name ={ expression | (SELECT-st) } [,...]</p>
<p>  | {(col-list) | [table.]*} =</p>
<p> { ({ expr-list | (SELECT-st) } [,...]) | record-name.* }</p>
<p>     [WHERE {condition | CURRENT OF cursor-name}]</p>
<p>                            !* Только в  4GL *!</p>
<p>LOAD FROM "file-name" [DELIMITER "?"] { INSERT INTO table</p>
<p>            [(col-list)] | char-variable with INSERT-st }</p>
<p>UNLOAD TO "file" [DELIMITER "?"] SELECT-statement</p>
<p>        формат файла по умолчанию:</p>
<p>столбец1|столбец2| ... ||столбецn|</p>
<p>                   ...</p>
<p>значение|значение| ... значение|</p>
<p>OUTPUT TO {FILENAME | PIPE program} [WITHOUT HEADINGS] SELECT-st</p>
<p>                только в INFORMIX-SQL</p>
<p>Оператор SELECT.</p>
<p>SELECT [ALL | UNIQUE] column-expr [col-lable] [,...]</p>
<p>        [INTO список переменных]            !* Только в  4GL *!</p>
<p>        FROM { [OUTER] table-name [tab-alias] |</p>
<p>           OUTER  (table-expr) } [,...] -проверять      условие</p>
<p>                                        только  для этой (менее</p>
<p>        [WHERE condition]               надежной) таблицы</p>
<p>        [GROUP BY column-list  [HAVING condition] ]</p>
<p>        [ORDER BY column-name [DESC],...]</p>
<p>        [INTO TEMP table-name]</p>
<p>     WHERE conditions:</p>
<p>  связанные логическими операторами OR, AND, NOT сравнения</p>
<p>        выраж1  сравнение выраж1</p>
<p>     где сравнение  =,&gt;,&lt;,&gt;=,&lt;=,&lt;&gt;,!=</p>
<p>        column-name IS [NOT] NULL</p>
<p>        выраж [NOT] BETWEEN выраж1 AND выраж2</p>
<p>        выраж [NOT] IN (выраж1 , ...  [, ...] )</p>
<p>                                   по умолчанию "\"</p>
<p>        строка [NOT] LIKE "шаблон" [ESCAPE "escape-char"]</p>
<p>         спецсимволы шаблона  %  _  означают "много" "один"</p>
<p>        строка [NOT] MATCHES "шаблон" [ESCAPE "esc-char"]</p>
<p>         спецсимволы шаблона  *  ?   означают "много" "один"</p>
<p>         [abH]  [^d-z]  "один из" "ни один из"</p>
<p>        выраж  сравнение {ALL | [ANY | SOME]} (SELECT-оператор)</p>
<p>        выраж [NOT] IN (SELECT-оператор)     !* Обыкновенный *!</p>
<p>        [NOT] EXISTS  (SELECT-оператор)      !*  SQLевский   *!</p>
<p>Операторы задания прав доступа (не откатываются).</p>
<p>     {DBpriv             {PUBLIC  право давать права</p>
<p>GRANT   |           TO   |     [WITH GRANT OPTION] [AS grantor]</p>
<p> TBpriv [,..] ON table}  user-list}            от имени grantor</p>
<p>        {DBpriv</p>
<p>REVOKE   |                FROM { PUBLIC | user-list }</p>
<p>   TBpriv [,..] ON table}</p>
<p>                                            TABLE PRIVILEGES:</p>
<p>       DATABASE PRIVILEGES:                  ALTER          DELETE</p>
<p>                                          INDEX          INSERT</p>
<p>        CONNECT   работать                     SELECT[(cols)]</p>
<p>        RESOURCE  создавать объекты           UPDATE [(cols)]</p>
<p>        DBA       все                         ALL [PRIVILEGES]</p>
<p>SET LOCK MODE TO [NOT] WAIT     ждать [не ждать] освобождения</p>
<p>                                                блокир. строк</p>
<p>LOCK TABLE   table-name   IN      {SHARE | EXCLUSIVE} MODE</p>
<p>                         {Можно смотреть | Ничего нельзя}</p>
<p>UNLOCK TABLE table-name</p>
<p>Операторы транзакций, восстановления данных.</p>
<p>CREATE DATABASE db-name  WITH LOG IN "/pathname" [MODE ANSI]]</p>
<p>START  DATABASE db-name  WITH LOG IN "/pathname" [MODE ANSI]</p>
<p>    стартовать новый системный журнал (log-файл)</p>
<p>DATABASE database-name [EXCLUSIVE]  Сделать текущей</p>
<p>ROLLFORWARD DATABASE database-name  Накатить базу из копии</p>
<p>CLOSE DATABASE                     вперед по системному журналу</p>
<p>BEGIN WORK      Начало транзакции   Внимание!! Все</p>
<p>   . . .                        измененные строки блокируются!!</p>
<p>COMMIT WORK     Kонец транзакции</p>
<p>ROLLBACK WORK   Откатить изменения к предыдущему COMMIT</p>
<p>CREATE AUDIT FOR table-name IN "pathname"</p>
<p>   . . .</p>
<p>RECOVER TABLE table-name            Восстановить таблицу</p>
<p>DROP AUDIT FOR table-name</p>
<p>VALIDATE список переменных LIKE column-list   удовлетворяют ли</p>
<p> переменные допустимым значениям для этих столбцов (syscolval)?, если нет то status&lt;0</p>
   Примечание: подчеркнутые операторы  нельзя  использовать в 4GL, а можно только в INFORMIX-SQL</p>
<p>INFO  { TABLES | { COLUMNS | INDEXES | ACCES | PRIVILEGES |</p>
<p>                         STATUS }          FOR table-name }</p>
<p>CHECK  TABLE owner.table-name         Проверить индексы</p>
<p>REPAIR  TABLE table-name               Ремонт индексов</p>

