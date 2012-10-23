<h1>Формат операторов Informix-4GL</h1>
<div class="date">01.01.2007</div>


<p>Формат операторов INFORMIX-4GL.</p>
<p>Типы данных и выражения над переменными.</p>
<p> &nbsp;&nbsp; INTEGER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SERIAL[(n0)]&nbsp;&nbsp; CHAR(n)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DATE</p>
<p> &nbsp;&nbsp; SMALLINT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DECIMAL(m,n)&nbsp;&nbsp; DATETIME qualif1 TO qualif2</p>
<p> &nbsp;&nbsp; REAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MONEY(m,n)&nbsp;&nbsp;&nbsp;&nbsp; INTERVAL qualif1 TO qualif2</p>
<p> &nbsp;&nbsp; FLOAT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RECORD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ARRAY [i,j,k] OF&nbsp; datatype</p>
<p>где qualif \in {YEAR,MONTH,DAY,HOUR,MINUTE,SECOND,FRACTION(n)}</p>
<p>&nbsp;<br>
Операции числовые: ** * / mod + - ( ) <br>
Все аргументы, в том числе CHAR, преобразуются к типу DECIMAL <br>
Внимание: -7 mod 3 = -1 <br>
Внимание: mod и ** нельзя использовать в операторе SELECT <br>
<p>Можно пользоваться встроенными функциями 4GL (см. "Функции 4GL") и функциями на языке Си.</p>
<p>Операции над строками:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; string1,string2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; сцепить</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; string&nbsp;&nbsp; [m,n]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; подстрока</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; string&nbsp;&nbsp; CLIPPED&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; усечь пробелы справа</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; string&nbsp;&nbsp; USING "формат"&nbsp;&nbsp;&nbsp; форматировать</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; string&nbsp;&nbsp; WORDWRAP&nbsp;&nbsp;&nbsp;&nbsp; переносить длинную строку</p>
<p>Выражения над датами:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; time + interval = time</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; time - time = interval</p>
<p>Логические выражения:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; =, != или &lt;&gt;, &lt;=,&gt;=, &lt;,&gt;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NOT ,&nbsp; OR,&nbsp; AND</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; выражение IS [NOT] NULL</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; по умолчанию "\"</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; string [NOT] LIKE "шаблон" [ESCAPE "escape-char"]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; спецсимволы шаблона  % _&nbsp; означают &#166; &#167;!</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; string [NOT] MATCHES "шаблон" [ESCAPE "esc-char"]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; спецсимволы шаблона  *&nbsp; ? [&nbsp; abH&nbsp; ]&nbsp; [^&nbsp; d&nbsp; -&nbsp; z&nbsp; ]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; означают "много", "один", "любой из", "ни один из"</p>
<p>Системные переменные:</p>
<p>&nbsp;<br>
<p>Устанавливаются после любого оператора 4GL</p>
<p>status&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; { 0 | NOTFOUND | &lt;0 } код завершения оператора quit_flag ( не 0 если было нажато QUIT ) int_flag ( не 0 если было нажато ^C ) define SQLCA record # системная запись с кодами завершения SQLCODE integer,="status" SQLERRM char(71), &#173;- SQLERRP char(8), &#173;- SQLERRD array[8] of int,...&#8222;см. SQLAWARN char(8) warning или пробел end record SQLERRD[1] зарезервирован SQLERRD[2] serial значение или ISAM error cod SQLERRD[3] число обработанных строк SQLERRD[4] CPU cost запроса SQLERRD[5] offset of error into SQL-st SQLERRD[6] ROWID of last row SQLERRD[7] зарезервирован SQLERRD[8] зарезервирован</p>

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
<p>START&nbsp; REPORT report-name</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; [TO {file-name | PRINTER | PIPE program}]</p>
<p>OUTPUT TO&nbsp; REPORT&nbsp; report-name (выражение, выражение [, ...])</p>
<p>FINISH REPORT report-name</p>
<p>Объявления переменных.</p>
<p>DEFINE&nbsp; список переменных  { type | LIKE table.column</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | RECORD {LIKE table.* | список переменных [,..]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; END RECORD} } [,...]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; где type может быть следующим:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; INTEGER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CHAR(n)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DATE</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SMALLINT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DECIMAL(m,n)&nbsp; DATETIME qualif1 TO qualif2</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; REAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MONEY(m,n)&nbsp;&nbsp;&nbsp; INTERVAL qualif1 TO qualif2</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FLOAT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RECORD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ARRAY [i,j,k] OF&nbsp; datatype</p>
<p> &nbsp; где qualif &#1025; {YEAR,MONTH,DAY,HOUR,MINUTE,SECOND,FRACTION(n)}</p>
<p>GLOBALS&nbsp;&nbsp; { "файл с GLOBALS объявлениями" |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DEFINE-st&nbsp;&nbsp;&nbsp; Должен лежать вне любого блока во всех</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .&nbsp;&nbsp;&nbsp; модулях, где эти переменные используются</p>
<p>END GLOBALS }</p>
<p>Присвоения.</p>
<p>INITIALIZE&nbsp; список переменных {LIKE column-list | TO NULL}</p>
<p> &nbsp;&nbsp; присвоить переменным NULL или DEFAULT значения</p>
<p>LET&nbsp; переменная = выражение</p>
<p>Перехват прерываний.</p>
<p>WHENEVER { ERROR | WARNING | NOT FOUND }</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; { GOTO [:]label | CALL function-name | CONTINUE | STOP }</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; !!!&nbsp;&nbsp;&nbsp; function-name без () !!!</p>
<p>DEFER&nbsp; INTERRUPT&nbsp;&nbsp; Запретить прерывание программы клавишей ^C</p>
<p>DEFER&nbsp; QUIT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Запретить прерывание программы клавишей QUIT</p>
<p>  Тогда после нажатия QUIT =&gt; quit_flag!=0,&nbsp; ^C =&gt; int_flag!=0</p>
<p>Программные операторы.</p>
<p>CALL function([список аргументов]) [RETURNING список переменных]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ! ! ! передача по значению</p>
<p>CASE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CASE&nbsp;&nbsp; (выражение)</p>
<p> &nbsp; WHEN логич.выраж.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; WHEN&nbsp; выраж1</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; или &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; [EXIT CASE]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [EXIT CASE]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .</p>
<p> &nbsp; WHEN логич.выраж.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; WHEN&nbsp; выраж2</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .</p>
<p>  [OTHERWISE]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [OTHERWISE]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .</p>
<p>END CASE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; END CASE</p>
<p>IF&nbsp; логическое выражение THEN</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [ELSE</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; . ]</p>
<p>END IF&nbsp;&nbsp;&nbsp; не забывайте закрывать все операторы IF !!!</p>
<p>FOR&nbsp;&nbsp;&nbsp;&nbsp; I= i1 TO i2&nbsp; [STEP i3]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; statement</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [CONTINUE FOR]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [EXIT FOR]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .</p>
<p>END FOR</p>
<p>CONTINUE { FOR | FOREACH | MENU | WHILE }</p>
<p>EXIT&nbsp; { CASE | WHILE | FOR | FOREACH | MENU | INPUT | DISPLAY</p>
<p>| PROGRAM[(status code for UNIX)] }</p>
<p>WHILE&nbsp; логическое выражение</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; операторы . . .</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [CONTINUE WHILE]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [EXIT WHILE]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .</p>
<p>END WHILE</p>
<p>GOTO [:] метка &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Двоеточие ':' для совместимости с ANSI стандартом</p>
<p>LABEL метка:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Действует только внутри блока</p>
<p>RUN {"командная строка UNIX"|char-variable} [RETURNING int-variable</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | WITHOUT WAITING]</p>
<p>SLEEP&nbsp;&nbsp; целое-выраж.&nbsp;&nbsp;&nbsp; Подождать  n&nbsp; секунд</p>
<p>Меню, окна.</p>
<p>MENU&nbsp; "Название меню"</p>
<p> &nbsp;&nbsp; COMMAND { KEY (key-list) |</p>
<p> &nbsp;&nbsp; [KEY (key-list)] "kоманда меню"</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [" подсказка help"] [HELP help-number] }</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Либо key, либо первая буква, обязаны быть латинскими.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; statement</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [CONTINUE MENU]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [EXIT MENU]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [NEXT OPTION "kоманда меню"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #&nbsp; Перейти к</p>
<p> &nbsp;&nbsp;&nbsp; [COMMAND&nbsp; .&nbsp; .&nbsp; .&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; . . .</p>
<p>END MENU</p>
<p>OPTIONS&nbsp;&nbsp; {&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; По умолчанию:</p>
<p> &nbsp;&nbsp;&nbsp; PROMPT&nbsp; LINE&nbsp; p |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FIRST</p>
<p> &nbsp;&nbsp;&nbsp; MESSAGE LINE&nbsp; m |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FIRST + 1</p>
<p> &nbsp;&nbsp;&nbsp; FORM&nbsp;&nbsp;&nbsp; LINE&nbsp; f |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FIRST + 2</p>
<p> &nbsp;&nbsp;&nbsp; COMMENT LINE&nbsp; c |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST [-1]</p>
<p> &nbsp;&nbsp;&nbsp; ERROR&nbsp;&nbsp; LINE&nbsp; e |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST</p>
<p> &nbsp;&nbsp;&nbsp; INPUT { WRAP | NO WRAP } |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NO WRAP</p>
<p> &nbsp;&nbsp;&nbsp; INSERT&nbsp;&nbsp;&nbsp; KEY&nbsp;&nbsp; key-name | Вставить  F1&nbsp;&nbsp; !! Не применять:</p>
<p> &nbsp;&nbsp;&nbsp; DELETE&nbsp;&nbsp;&nbsp; KEY&nbsp;&nbsp; key-name | Удал. стр F2&nbsp;&nbsp; CONTROL-A,D,H,L,</p>
<p> &nbsp;&nbsp;&nbsp; NEXT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; KEY&nbsp;&nbsp; key-name | Страница  F3&nbsp;&nbsp; CONTROL-Q,R,X,&nbsp;</p>
<p> &nbsp;&nbsp;&nbsp; PREVIOUS&nbsp; KEY&nbsp;&nbsp; key-name | Страница  F4&nbsp;&nbsp; CONTROL-C,S,Q,Z</p>
<p> &nbsp;&nbsp;&nbsp; ACCEPT&nbsp;&nbsp;&nbsp; KEY&nbsp;&nbsp; key-name |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ESC</p>
<p> &nbsp;&nbsp;&nbsp; HELP&nbsp;&nbsp;&nbsp; FILE "help-file" | Предварительно откомпилированный</p>
<p> &nbsp;&nbsp;&nbsp; HELP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; KEY&nbsp;&nbsp; key-name |&nbsp;&nbsp; CONTROL-W&nbsp;&nbsp; утилитой mkmessage</p>
<p> &nbsp;&nbsp;&nbsp; INPUT ATTRIBUTE(список атрибутов) |</p>
<p> &nbsp;&nbsp;&nbsp; DISPLAY ATTRIBUTE(список атрибутов)</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; } [,...]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; атрибуты:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NORMAL&nbsp;&nbsp;&nbsp;&nbsp; REVERSE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FORM&nbsp;&nbsp;&nbsp; использовать атрибуты</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BOLD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; UNDERLINE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; WINDOW&nbsp;&nbsp; текущего окна</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; INVISIBLE&nbsp; BLINK</p>
<p>OPEN WINDOW window-name AT row, column</p>
<p> &nbsp; WITH { integer ROWS, integer COLUMNS | FORM "form-file" }</p>
<p> &nbsp;&nbsp;&nbsp; [ATTRIBUTE(список аттрибутов)]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Атрибуты:&nbsp; BORDER&nbsp;&nbsp;&nbsp;&nbsp; По умолчанию: нет</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BOLD, DIM, INVISIBLE, NORMAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NORMAL</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; REVERSE, UNDERLINE, BLINK&nbsp;&nbsp;&nbsp;&nbsp; нет</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PROMPT LINE&nbsp; n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FIRST</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MESSAGE LINE m&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FIRST + 1</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FORM&nbsp;&nbsp;&nbsp; LINE m&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FIRST + 2</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; COMMENT LINE m&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAST</p>
<p>CURRENT WINDOW IS { window name | SCREEN }</p>
<p>CLEAR&nbsp; {SCREEN | WINDOW window-name | FORM | список полей}</p>
<p>CLOSE WINDOW window-name</p>
<p>OPEN FORM form-name FROM "form-file"&nbsp;&nbsp;&nbsp; Без расширения .frm</p>
<p>DISPLAY FORM form-name [ATTRIBUTE(список аттрибутов)]</p>
<p>CLOSE FORM form-name</p>
<p>Простые операторы вывода на экран.</p>
<p>MESSAGE список переменных, констант [ATTRIBUTE(список атрибутов)]</p>
<p>ERROR список переменных, констант [ATTRIBUTE(список атрибутов)]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; по умолчанию REVERSE</p>
<p>PROMPT список переменных и констатнт</p>
<p> [ATTRIBUTE(аттрибуты вывода)] FOR [CHAR] variable</p>
<p> [HELP help-number]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # Ввести значение в variable</p>
<p> [ATTRIBUTE(аттрибуты ввода)]&nbsp;&nbsp; # FOR CHAR - ввести один символ</p>
<p> [ON KEY (key-list)</p>
<p> &nbsp;&nbsp; statement&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; атрибуты: NORMAL&nbsp;&nbsp;&nbsp;&nbsp; REVERSE</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BOLD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; UNDERLINE</p>
<p> .&nbsp; .&nbsp; .&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DIM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BLINK</p>
<p>END PROMPT]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; INVISIBLE</p>
<p>в  ON&nbsp; KEY&nbsp; пункте  нельзя  напрямую  пользоваться  операторами</p>
<p>PROMPT, INPUT.Для их вызова применяйте функции.</p>
<p>Ввод/вывод через экранные формы.</p>
<p>Вывести в форму</p>
<p>DISPLAY { BY NAME список переменных |</p>
<p> список переменных TO {список полей|screen-record[[n]].*}[,..] |</p>
<p> список переменных AT row, column }</p>
<p> [ATTRIBUTE(список атрибутов)]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [Не стирать значений из формы перед вводом]</p>
<p>INPUT { BY NAME список переменных [WITHOUT DEFAULTS] |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; список переменных [WITHOUT DEFAULTS] FROM</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {список полей | screen-record[[n]].*}[,...]}</p>
<p> [ATTRIBUTE(список атрибутов)]</p>
<p> [HELP help-number]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [ { BEFORE FIELD подсписок полей &nbsp;&nbsp;&nbsp; по клавише ESC</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | AFTER&nbsp; { FIELD подсписок полей | INPUT }</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | ON KEY (key-list) }</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; statement . . .</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [NEXT FIELD field-name]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [EXIT INPUT]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; statement . . .</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .</p>
<p>END INPUT&nbsp; ]</p>
<p>  конструирует WHERE условие для QUERY BY EXAMPLE</p>
<p>CONSTRUCT {BY NAME char-variable ON column-list |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; char-variable ON column-list FROM</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {список полей | screen-record[[n]].*}[,...]}</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [ATTRIBUTE(список атрибутов)]</p>
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
<p> &nbsp;&nbsp;&nbsp;&nbsp; [&nbsp; ON KEY (key-list)</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [EXIT DISPLAY]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .</p>
<p>END DISPLAY ] | [END DISPLAY]</p>
<p>SCROLL {field-list | screen-record.*} [,...} Прокрутить строки</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {UP | DOWN} [BY int]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; в экранном массиве</p>
<p>call set_count(кол-во выводимых строк) в программном массиве</p>
<p>INPUT ARRAY record-array [WITHOUT DEFAULTS]</p>
<p> FROM&nbsp;&nbsp; screen-array.*&nbsp; [HELP help-number] [ATTRIBUTE(атр.)]</p>
<p> [{BEFORE {ROW | INSERT | DELETE | FIELD подсписок полей}[,...]</p>
<p>  | AFTER {ROW|INSERT|DELETE|FIELD подсписок полей |INPUT}[,...]</p>
<p>  | ON KEY (key-list) }</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; statement&nbsp; ...</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [NEXT FIELD field-name]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; statement...</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [EXIT INPUT]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .</p>
<p>END INPUT ]</p>
<p> &nbsp; Внутри оператора DISPLAY ARRAY можно пользоваться функциями:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; arr_curr()&nbsp; номер текущей строки прогр. массива</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; arr_count() число заполненных строки прогр. массива</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; scr_line()&nbsp; номер текущей  строки экр. массива</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CALL showhelp(helpnumber) - вывести help</p>
<p>Динамическое создание операторов.</p>
<p>PREPARE statement-id FROM {char-variable | "SQL-оператор [ы] "}</p>
<p>  Изготовить SQL - statement из символьной строки</p>
<p>  Нельзя включать имена переменных, нужно заменять их на знак ?</p>
<p>Нельзя готовить операторы:</p>
<p>DECLARE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PREPARE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LOAD</p>
<p>OPEN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; EXECUTE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; UNLOAD</p>
<p>CLOSE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FETCH&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SELECT INTO variables</p>
<p>EXECUTE statment-id [USING input-list]</p>
<p> &nbsp; Выполняет, заменив знаки ? на input-list</p>
<p>FREE&nbsp;&nbsp; { statment-id | cursor-name }</p>
<p>Манипуляция "курсором".</p>
<p>DECLARE cursor-name [SCROLL] CURSOR [WITH HOLD] FOR</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; { SELECT-st [FOR UPDATE [OF column-list]] |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; INSERT-st&nbsp;&nbsp; |&nbsp; statment-id }</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SCROLL - фактически, создается временная таблица.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; statment-id - приготовленого PREPARE</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; HOLD - игнорировать конец транзакции</p>
<p>Внимание: SCROLL cursor нельзя открывать FOR UPDATE,&nbsp; зато  для не-SCROLL cursora можно использовать</p>
<p>Внимание:  оператор  DECLARE cursor-name должен располагаться в тексте программы выше любого использования этого курсора.</p>
<p>OPEN&nbsp; cursor-name [USING список переменных]</p>
<p>CLOSE cursor-name</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; для SELECT-курсора:</p>
<p>FOREACH cursor-name [INTO список переменных]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [CONTINUE FOREACH]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [EXIT FOREACH]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; .&nbsp; .&nbsp; .</p>
<p>END FOREACH</p>
<p>FETCH { NEXT | PREVIOUS | FIRST | LAST | CURRRENT |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RELATIVE m | ABSOLUTE n ] cursor-name</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [INTO список переменных]</p>
<p> &nbsp;&nbsp;&nbsp; если cursor not&nbsp; SCROLL то можно только NEXT</p>
<p> &nbsp;&nbsp;&nbsp; если строки не обнаружено, то  status=NOTFOUND</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; для INSERT-курсора:</p>
<p>PUT cursor-name [FROM список переменных] ввести строку в буфер,</p>
<p>[заменив знаки ? для DECLAREd INSERT-st на список переменных]</p>
<p>FLUSH cursor-name&nbsp;&nbsp; вытолкнуть буфер</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ^^&nbsp; SQL операторы  ^^</p>
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
<p>DATABASE database-name [EXCLUSIVE]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Сделать текущей</p>
<p>CLOSE DATABASE</p>
<p>CREATE [TEMP] TABLE table-name( column-name datatype [NOT NULL]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [UNIQUE [CONSTRAINT constr-name]] [,...] )</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [UNIQUE(uniq-col-list) [CONSTRAINT constr-name] ] [,..]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [WITH NO LOG]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [IN "pathname-directory"]</p>
<p>где datatype может быть:</p>
<p> &nbsp;&nbsp; INTEGER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  SERIAL[(n0)]&nbsp;&nbsp; DATE</p>
<p> &nbsp;&nbsp; SMALLINT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DECIMAL(m,n)&nbsp;&nbsp; DATETIME qualif1 TO qualif2</p>
<p> &nbsp;&nbsp; REAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MONEY(m,n)&nbsp;&nbsp;&nbsp;&nbsp; INTERVAL qualif1 TO qualif2</p>
<p> &nbsp;&nbsp; FLOAT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CHAR(n)</p>
<p>qualifier \in {YEAR,MONTH,DAY,HOUR,MINUTE,SECOND,FRACTION(n)}</p>
<p>ALTER TABLE table-name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # Недопустим для временых таблиц</p>
<p> &nbsp;&nbsp;&nbsp; {&nbsp; ADD ( new-column-name datatype [NOT NULL]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [UNIQUE [CONSTRAINT constr-name]][,...] )</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [BEFORE old-column-name]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DROP (old-column-name[,...])</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MODIFY (old-column-name new-datatype [NOT NULL][,...])</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ADD CONSTRAINT UNIQUE (old-column-name[,...])</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [CONSTRAINT constr-name]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DROP CONSTRAINT (constr-name[,...])</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; } [,...]</p>
<p>RENAME TABLE old-table-name TO new-table-name</p>
<p>RENAME COLUMN table.old-column-name TO new-column-name</p>
<p>CREATE VIEW view-name [(column-list)]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; AS SELECT-statement [WITH CHECK OPTION]</p>
<p>CREATE [UNIQUE|DISTINCT] [CLUSTER] INDEX index-name</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ON table-name (column-name [DESC], ...)</p>
<p>ALTER INDEX index-name TO [NOT] CLUSTER&nbsp; Упорядочить таблицу</p>
<p>CREATE SYNONYM synonym-name FOR table-name</p>
<p>DROP VIEW&nbsp;&nbsp;&nbsp; view-name</p>
<p>DROP TABLE&nbsp;&nbsp; table-name</p>
<p>DROP INDEX&nbsp;&nbsp; index-name</p>
<p>DROP SYNONYM synonym-name</p>
<p>UPDATE STATISTICS [FOR TABLE table-name] В системном каталоге</p>
<p>SET EXPLAIN {ON | OFF}</p>
<p>Выводить системные объяснения в sqlexplain.out</p>
<p>Операторы манипуляции данными.</p>
<p>DELETE FROM table-name [WHERE {condition | CURRENT OF cursor-name}]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; !* Только в  4GL *!</p>
<p>INSERT INTO table-name [(column-list)]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; { VALUES (value-list) | SELECT-statement }</p>
<p>UPDATE table-name SET {column-name ={ expression | (SELECT-st) } [,...]</p>
<p>  | {(col-list) | [table.]*} =</p>
<p> { ({ expr-list | (SELECT-st) } [,...]) | record-name.* }</p>
<p> &nbsp;&nbsp;&nbsp; [WHERE {condition | CURRENT OF cursor-name}]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; !* Только в  4GL *!</p>
<p>LOAD FROM "file-name" [DELIMITER "?"] { INSERT INTO table</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [(col-list)] | char-variable with INSERT-st }</p>
<p>UNLOAD TO "file" [DELIMITER "?"] SELECT-statement</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; формат файла по умолчанию:</p>
<p>столбец1|столбец2| ... ||столбецn|</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ...</p>
<p>значение|значение| ... значение|</p>
<p>OUTPUT TO {FILENAME | PIPE program} [WITHOUT HEADINGS] SELECT-st</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; только в INFORMIX-SQL</p>
<p>Оператор SELECT.</p>
<p>SELECT [ALL | UNIQUE] column-expr [col-lable] [,...]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [INTO список переменных]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; !* Только в  4GL *!</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FROM { [OUTER] table-name [tab-alias] |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; OUTER&nbsp; (table-expr) } [,...] -проверять &nbsp;&nbsp;&nbsp;&nbsp; условие</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; только  для этой (менее</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [WHERE condition]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; надежной) таблицы</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [GROUP BY column-list&nbsp; [HAVING condition] ]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [ORDER BY column-name [DESC],...]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [INTO TEMP table-name]</p>
<p> &nbsp;&nbsp;&nbsp; WHERE conditions:</p>
<p>  связанные логическими операторами OR, AND, NOT сравнения</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; выраж1  сравнение выраж1</p>
<p> &nbsp;&nbsp;&nbsp; где сравнение  =,&gt;,&lt;,&gt;=,&lt;=,&lt;&gt;,!=</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; column-name IS [NOT] NULL</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; выраж [NOT] BETWEEN выраж1 AND выраж2</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; выраж [NOT] IN (выраж1 , ...&nbsp; [, ...] )</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; по умолчанию "\"</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; строка [NOT] LIKE "шаблон" [ESCAPE "escape-char"]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; спецсимволы шаблона  %&nbsp; _&nbsp; означают "много" "один"</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; строка [NOT] MATCHES "шаблон" [ESCAPE "esc-char"]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; спецсимволы шаблона  *&nbsp; ?&nbsp;&nbsp; означают "много" "один"</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [abH]&nbsp; [^d-z]&nbsp; "один из" "ни один из"</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; выраж  сравнение {ALL | [ANY | SOME]} (SELECT-оператор)</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; выраж [NOT] IN (SELECT-оператор)&nbsp;&nbsp;&nbsp;&nbsp; !* Обыкновенный *!</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [NOT] EXISTS&nbsp; (SELECT-оператор)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; !*&nbsp; SQLевский &nbsp; *!</p>
<p>Операторы задания прав доступа (не откатываются).</p>
<p> &nbsp;&nbsp;&nbsp; {DBpriv&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {PUBLIC&nbsp; право давать права</p>
<p>GRANT&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TO&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp; [WITH GRANT OPTION] [AS grantor]</p>
<p> TBpriv [,..] ON table}&nbsp; user-list}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; от имени grantor</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {DBpriv</p>
<p>REVOKE&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FROM { PUBLIC | user-list }</p>
<p> &nbsp; TBpriv [,..] ON table}</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TABLE PRIVILEGES:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DATABASE PRIVILEGES:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ALTER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DELETE</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; INDEX&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; INSERT</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CONNECT&nbsp;&nbsp; работать &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SELECT[(cols)]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RESOURCE&nbsp; создавать объекты &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; UPDATE [(cols)]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DBA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; все &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ALL [PRIVILEGES]</p>
<p>SET LOCK MODE TO [NOT] WAIT&nbsp;&nbsp;&nbsp;&nbsp; ждать [не ждать] освобождения</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; блокир. строк</p>
<p>LOCK TABLE&nbsp;&nbsp; table-name&nbsp;&nbsp; IN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {SHARE | EXCLUSIVE} MODE</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {Можно смотреть | Ничего нельзя}</p>
<p>UNLOCK TABLE table-name</p>
<p>Операторы транзакций, восстановления данных.</p>
<p>CREATE DATABASE db-name&nbsp; WITH LOG IN "/pathname" [MODE ANSI]]</p>
<p>START&nbsp; DATABASE db-name&nbsp; WITH LOG IN "/pathname" [MODE ANSI]</p>
<p> &nbsp;&nbsp; стартовать новый системный журнал (log-файл)</p>
<p>DATABASE database-name [EXCLUSIVE]&nbsp; Сделать текущей</p>
<p>ROLLFORWARD DATABASE database-name&nbsp; Накатить базу из копии</p>
<p>CLOSE DATABASE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; вперед по системному журналу</p>
<p>BEGIN WORK&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Начало транзакции &nbsp; Внимание!! Все</p>
<p> &nbsp; . . .&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; измененные строки блокируются!!</p>
<p>COMMIT WORK&nbsp;&nbsp;&nbsp;&nbsp; Kонец транзакции</p>
<p>ROLLBACK WORK&nbsp;&nbsp; Откатить изменения к предыдущему COMMIT</p>
<p>CREATE AUDIT FOR table-name IN "pathname"</p>
<p> &nbsp; . . .</p>
<p>RECOVER TABLE table-name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Восстановить таблицу</p>
<p>DROP AUDIT FOR table-name</p>
<p>VALIDATE список переменных LIKE column-list&nbsp;&nbsp; удовлетворяют ли</p>
<p> переменные допустимым значениям для этих столбцов (syscolval)?, если нет то status&lt;0</p>
 &nbsp; Примечание: подчеркнутые операторы  нельзя  использовать в 4GL, а можно только в INFORMIX-SQL</p>
<p>INFO&nbsp; { TABLES | { COLUMNS | INDEXES | ACCES | PRIVILEGES |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; STATUS }&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FOR table-name }</p>
<p>CHECK&nbsp; TABLE owner.table-name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Проверить индексы</p>
<p>REPAIR&nbsp; TABLE table-name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ремонт индексов</p>

