---
Title: Краткое пособие по языку Informix-4GL
Date: 01.01.2007
---


Краткое пособие по языку Informix-4GL
=====================================

::: {.date}
01.01.2007
:::

Краткое пособие по языку INFORMIX-4GL.

Соглашения о Языке 4GL и Начальные Понятия.

Программа на языке 4GL может состоять из нескольких файлов (модулей) с
исходными текстами на 4GL. К ней так же относятся файлы с описанием
используемых экранных форм, которые компилируются отдельно. Имя каждого
модуля должно иметь расширение .4gl (например, module1.4gl), а имя файла
с описанием экранных форм должно иметь расширение .per (например,
form2.per).\
Каждый модуль содержит описания переменных и несколько процедурных
блоков function (подпрограммы) и report (блоки печати). В программе
должен быть один блок main - главный блок, начинающийся с ключевого
слова main. На него будет передаваться управление при старте программы.\
Формат записи операторов 4GL свободный. Можно писать все подряд на одной
строке, один оператор на нескольких строках, слова операторов можно
разделять произвольным количеством пробелов и комментариев. Никакими
значками (типа ;) операторы разделять не нужно. Окончание операторов
определяется по контексту.\
Весь набор ключевых слов языка зарезервирован, их нельзя занимать для
других целей (на имена объектов и переменных 4GL).\

Компилятору языка безразлично, большими или маленькими буквами пишутся
операторы. Он их не различает.

Комментарии обозначаются знаками

{ комментарий },

или знаком \# - до конца строки,

или знаком \-- (два знака минус) до конца строки.

 

Объекты, Используемые в INFORMIX-4GL.

1\. Объекты SQL    2. Переменные 4GL        3. Программные

Имя базы данных   простая переменная          функция

Имя таблицы       переменная типа \"запись\"    отчет

Имя столбца       массив                     метка

Имя индекса

Имя псевдотаблицы

Имя синонима

( database-name   простые переменные      function )

( table-name      переменная типа запись report   )

( column-name     массивы                 label    )

( index-name                                       )

( view-name                                        )

( synonim-name                                     )

4\. Имена операторов             5. Объекты экранного обмена.

  и курсоров

                                      window

statement-id - изготовленный оператор form

cursor-name  - курсор                  screen-field

                                      screen-record

                                      screen-array

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
+-----------------------------------+-----------------------------------+
| 1.                                | Идентификаторы INFORMIX.\         |
|                                   |                                   |
|                                   | Каждый объект 4GL имеет имя       |
|                                   | (идентификатор) - это слово,      |
|                                   | состоящее из букв, цифр, и знаков |
|                                   | подчеркивания (\_), начинающееся  |
|                                   | с буквы или знака (\_). В         |
|                                   | INFORMIX-4GL не различаются       |
|                                   | маленькие и большие буквы.        |
|                                   | Поэтому i\_Un103Tt и I\_UN103TT - |
|                                   | одно и тоже имя.                  |
+-----------------------------------+-----------------------------------+
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  ---- -----------------------------------
  1.   Области Действия Имен Переменных:
  ---- -----------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 72px;"}
  --- --------------------------------------------------------------------------------------------------------------------
  ·   Локальная переменная - объявлена внутри блока function, main, report. Действует внутри блока, в котором объявлена.
  --- --------------------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 72px;"}
  --- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  ·   Модульная переменная должна быть объявлена в самом начале модуля с исходным текстом вне любого блока report, function или main. Действует внутри всего модуля (за исключением блоков, в которых это имя переобъявлено и является для них локальным).
  --- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 72px;"}
  --- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  ·   Глобальные переменные - объявляются с помощью оператора GLOBALS в начале модулей. Действуют во всех модулях с исходным текстом, в которых есть соответствующее объявление этих переменных.
  --- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  ---- ------------------------------------------------------------------------------------------------------------------------
  1.   Область действия имен КУРСОРОВ и Изготовленных Операторов от точки их объявления (DECLARE, PREPARE) и до конца модуля.
  ---- ------------------------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  ---- -------------------------------------------------------------------------
  1.   Область действия имен Окон, Форм, Функций, Отчетов - во всей программе.
  ---- -------------------------------------------------------------------------
:::

В Языке 4GL Есть Такие Операторы:

Операторы SQL

Организация программы

MAIN

FUNCTION

REPORT

Объявления переменных

DEFINE

GLOBALS

Присвоения

LET

INITIALIZE

Программные

CALL            EXIT            GOTO

RETURN          FOR             LABLE

CASE            WHILE           RUN

IF              CONTINUE        SLEEP

Перехват прерываний

WHENEVER

DEFER

Динамическое создание операторов

PREPARE         EXECUTE         FREE

Манипуляция \"курсором\"

DECLARE

OPEN            FOREACH                 PUT

CLOSE            FETCH                 FLUSH

Экранный обмен

MENU                    OPEN FORM               DISPLAY ARRAY

OPTIONS                 DISPLAY FORM            SCROLL

OPEN WINDOW             CLOSE FORM              INPUT ARRAY

CURRENT WINDOW          DISPLAY                 PROMPT

CLEAR                   INPUT                   ERROR

CLOSE WINDOW            CONSTRUCT               MESSAGE

Генерация отчетов

START  REPORT

OUTPUT TO  REPORT

FINISH REPORT

Типы Переменных и Операторы Описания Переменных в 4GL.

В языке 4GL имеются простые переменные, переменные типа запись и
массивы. Простые переменные бывают следующих типов:

   INTEGER       CHAR(n)        DATE

   SMALLINT      DECIMAL(m,n)   DATETIME ед\_врем1 TO ед\_врем2

   REAL          MONEY(m,n)     INTERVAL ед\_врем1 TO ед\_врем2

   FLOAT

 \

где ед\_врем1, ед\_врем2 - единицы измерения времени

{YEAR,MONTH,DAY,HOUR,MINUTE,SECOND,FRACTION(n)}

 \
где FLOAT = DOUBLE PRECISSION\
Переменная типа запись описывается при помощи конструкции RECORD \...
END RECORD или конструкции LIKE имя\_таблицы.\*\
Переменная типа массив имеет описатель ARRAY \[i,j,k\] OF type, где type
- тип простой переменной, конструкция RECORD, или конструкция ARRAY.\

Для описания переменных служит оператор DEFINE:

DEFINE  simw char (200), j,i,k INTEGER, ff FLOAT

\# Здесь объявлены символьная переменная simw длиной 200 байт,

\# целые i,j,k, и ff - восьмибайтовое с плавающей точкой

DATABASE zawod

DEFINE doljno   RECORD

\# объявляется запись doljno, состоящая из 4 простых переменных

                dolzn CHAR(20),         \# должность

                zarplmin  LIKE kadry.zarplata,

                zarplmax  money(16,2),  \# зарплата

                vakansii int            \# вакансии

END RECORD      \# Здесь заканчивается объявление записи doljno

\# Переменную можно оъявить с ключевым словом LIKE column\_name.

\# переменная zarplmin получает такой же тип,  что и столбец

\# zarplata таблицы kadry из базы данных zawod

DEFINE rrr RECORD LIKE kadry.\*

\#  Переменную типа запись тоже можно объявить с ключевым словом

\#  LIKE. Здесь объявлена запись rrr, содержащая элементы, имею-

\#  щие те же самые названия и те же самые типы что и столбцы

\#  таблицы kadry

 \

Элементами записи могут быть массивы. Можно обьявить массив элементов
типа RECORD.

DEFINE zap RECORD

        a LIKE kadry.tabnom,

        b array\[8\] OF REAL

      END RECORD,

massiw ARRAY\[2,15\] OF RECORD

        kolwo INT,

        tip CHAR(8)

      END RECORD

\#    massiw  объявлен как массив записей. Каждая запись состоит

\#  из двух простых элементов - kolwo и tip

 \

Индексы массивов пишутся в квадратных скобках. На элементы записей можно
ссылаться по его имени, если не допускается двусмысленности, иначе их
необходимо уточнять именем записи, отделяя его точкой (.) от простого
имени.

\#  присвоить значение элементу массива можно так:

LET   massiw\[1,i+2\].kolwo = zap.a + LENGTH(massiw\[1,i+2\].tip)

 \

Для сокращения перечисления элементов в списках можно пользоваться
нотацией (\*). Например, strkt.\* означает все элементы записи strkt. А
так же нотацией THRU: (элементы записи от и до)

SELECT kadry.\* INTO strkt.\* FROM kadry WHERE kadry.tabnom=i+j

SELECT \* INTO strukt.b THRU strkt.e FROM kadry

 \

Глобальные переменные должны иметь одинаковые объявления GLOBALS во всех
модулях программы (в которых используются). Проще всего это организуется
так: заводится отдельный модуль, в котором ничего, кроме объявлений
GLOBALS нет. А во всех остальных модулях программы ссылаются на этот
файл. Ниже приводится пример объявления глобальных переменных в файле
progrglob.4gl:

DATABASE zawod

GLOBALS

DEFINE zap RECORD LIKE kadry.\*

DEFINE ext\_count INT

  . . .

END GLOBALS

 \

Тогда в остальные модули программы, где используются эти глобальные
переменные, надо включить строчку

GLOBALS \"progrglob\"

. . .

Подпрограммные Блоки (Функции).

В языке 4GL при программировании функций (подпрограмм) используются
операторы function. Все аргументы функции должны быть объявлены.
Аргументы передаются по значению. Если функция возвращает какие-либо
значения, то при вызове ее нужно воспользоваться в операторе CALL
предложением RETURNING с перечислением переменных, в которые
возвращается значение. Ниже приводится соответствующий фрагмент
программы.

FUNCTION stroka(rec)

DEFINE rec RECORD       i int, st char(256)  END RECORD

RETURN  st clipped,\"автопробега\"

END FUNCTION

. . .

MAIN

. . .

  CALL stroka(rec1.\*) RETURNING simw

. . .

  LET simw=stroka(7,\"Привет участникам \")

\#    Если функция возвращает одно значение, то ее имя мож-

\#         но использовать в выражениях.

  MESSAGE simw

. . .

END MAIN

 \

На экране пользователь увидит:

ѓЃѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹‚

ѓЉ   Привет участникам автопробега                        ѓЉ

ѓЉ                                                        ѓЉ

ѓЉ                                                        ѓЉ

ѓЉ                                                        ѓЉ

ѓѓѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹„

Примеры Использования Программных Операторов.

Оператор безусловного перехода действует в пределах модуля.

GOTO metka

. . .

LABEL  metka:   . . .

 \

Оператор выбора.

CASE

  WHEN iscreen=1

       current window is w1

  WHEN iscreen=2

       current window is w2

       let iscreen=1

  OTHERWISE

       current window is SCREEN

END CASE

CASE   (a+b)                  \#    Другой формат оператора CASE

      WHEN  1

       message \"a=\",a

      WHEN  2

       message \"b=\",b

END CASE

 \

Условный оператор.

IF str = \"завершить\" OR y\<0 THEN exit program \# Не забывайте в конце
каждого условного \# оператора ставить END IF. END IF

Оператор цикла.

FOR     I= i1 TO 23

let a\[i\]=0

    if b\[i\]=100 then

        EXIT FOR

        END IF

END FOR

Цикл \"пока\".

WHILE      ff \> 3 or nn=\"проба\"

  PROMPT \"Введите число \" for n

  let i=n+1

  message \"А у меня \",i,\", больше.   Вы проиграли.\"

  SLEEP  5

  RUN \"rm \*\" WITHOUT WAITING

END WHILE

Динамическое Изготовление Операторов SQL. Курсоры.

Операторы PREPARE и EXECUTE предназначены для динамического (во время
выполнения программы) изготовления и выполнения операторов языка SQL (не
4GL !!!).\

В приведенном ниже фрагменте в ответ на запрос пользователь сможет
ввести с клавиатуры строку с оператором языка SQL (Пусть, например, он
введет строку: DROP DATABASE buhgalteriq). Программа изготовит из этой
строки настоящий оператор и выполнит его с помощью оператора EXECUTE.
Если при выполнении зарегистрирована ошибка, о чем сообщит установленный
в отрицательное значение код завершения status, пользователя снова
попросят ввести оператор.

DEFINE stroka char(200)

MAIN

. . .

  LABEL METK2:PROMPT \"введите оператор языка SQL: \" FOR stroka

   WHENEVER ERROR CONTINUE     \# Включить режим   \"В   случае

                               \# ошибки продолжить выполнение

                               \# программы\"

   PREPARE st1 FROM stroka     \# Изготовить оператор из

                               \# символьной строки

   EXECUTE st1         \#   Выполнить изготовленный оператор

   IF status\<0 THEN ERROR \"ошибка номер \", status, \" в вашем
операторе\" GOTO metk2 END IF WHENEVER ERROR STOP \# Восстановить режим
\# \"В случае ошибки прервать \# выполнение программы\" . . . END MAIN

В системную переменную status помещается код выполнения каждого
оператора 4GL (status=0 если все нормально, status\<0 если произошла
ошибка). Переменная status может проверяться после любого оператора
программы и в зависимости от ее значения могут предприниматься
какие-либо действия.

Курсоры

Если запрос к таблице возвращает несколько (больше одной) строк, то для
их обработки используется так называемый курсор - указатель во множестве
строк, выбранных оператором SELECT. Оператором DECLARE объявляется
курсор для запроса, оператором OPEN этот запрос фактически выполняется и
выбранные строки выделяются. Курсор устанавливается на первую из
выбранных строк. С помощью оператора FETCH вы можете брать очередную
строку, на которую указывает курсор, и помещать ее в свои программные
переменные. Курсор после этого смещается на следующую строку.\

С помощью конструкции циклической FOREACH имя\_курсора \... END FOREACH
можно перебрать все строки, выбранные оператором SELECT. Оператор OPEN в
этом случае не нужен.

DATABASE zawod

DEFINE zap RECORD LIKE kadry.\*

DECLARE curs1 CURSOR FOR

    select \* from kadry where datarovd\>\"9/25/1973\"

\#  в цикле FOREACH выводим на экран все строки таблицы kadry,

\#  в которых столбец datarovd содержит дату после 25 сентября

\#  1973 года.

FOREACH curs1 INTO zap.\*      \# Берем очередную строку и по-

                               \# мещаем ее в запись zap

MESSAGE zap.\*                 \#  Выводим запись zap на экран

PROMPT \"Еще ?\" FOR CHAR c

END FOREACH                   \#  Конец цикла FOREACH

В следующем примере строки выбираемые из таблицы kadry  через курсор
curs2 помещаются в массив z1 (но не более 100 строк).

DATABASE zawod

DEFINE z1 ARRAY\[100\] OF RECORD LIKE kadry.\*, counter int

DECLARE curs2 CURSOR FOR SELECT \* FROM kadry

       WHERE datarovd\<\"9/26/1973\" OPEN curs2 FOR counter=\"1\" TO 100
FETCH curs2 INTO z1\[counter\].\* \# взять очередную строку и поместить
ее в следующий элемент \# массива z1 IF status=\"NOTFOUND\" THEN \# если
выбранные сроки кончились, закончить цикл EXIT FOR END IF END FOR LET
counter=\"counter-1\" MESSAGE \"В массив z1 прочитано \",counter, \"
записей\"

Этот пример демонстрирует еще одно использование переменной status. Если
оператор FETCH пытается взять сроку из курсора когда тот уже пуст, то
значение переменной status устанавливается равным символической
константе NOTFOUND, имеющей значение 100. Поэтому можно проверять
значение status после оператора FETCH и если оно равно 100, то
прекратить чтение строк из опустевшего курсора. В данном примере
пользователь сам должен ввести условия, по которым будут найдены строки
в таблице ceh. Он, например, может ввести: \"nomerceh\>15 and
nomerceh\<23\". Программа прицепит это условие к строке, в которой
записан SELECT оператор, получит строчку \"SELECT \* FROM ceh WHERE
nomerceh\>15 and nomerceh\<23\", изготовит из нее оператор, и для этого
изготовленного оператора SELECT объявит курсор. Дальше действия
аналогичны предыдущему примеру.

DEFINE z2 ARRAY\[100\] OF RECORD LIKE ceh.\*,

        counter int, simw char(200)

PROMPT \"допишите оператор SELECT \* FROM ceh WHERE \" FOR simw

IF LENGTH(simw)=0 THEN

   LET simw=\"TRUE\"

   END IF

LET simw=\"SELECT \* FROM ceh WHERE \", simw CLIPPED

PREPARE st2 FROM simw

DECLARE cs2 FOR st2

let counter=1

FOREACH cs2 INTO z2\[counter\].\*

LET counter=counter+1

IF counter\>100 THEN

    EXIT FOREACH

    END IF

END FOREACH

LET   counter=counter-1

MESSAGE \"В массив z2 прочитано \",counter, \" записей\"

Программирование Экранного Обмена.

В любой момент времени на экране терминала существует ТЕКУЩЕЕ окно,
через которое и выполняется ввод/вывод вашей программы. С окном связаны
используемые при вводе и выводе атрибуты (например, green, revers,
underline и т.п.) и номера строк окна, используемых операторами MESSAGE,
PROMPT и ERROR для вывода.\
При открытии нового окна оно становится текущим и и весь ввод/вывод
будет направляться уже в него.\
В окно можно вывести экранную форму, которая, представляет собой набор
экранных полей, имеющих имена, и в эти поля (из этих полей), обращаясь к
ним по имени, можно выводить (вводить) данные с помощью оператора
DISPLAY (INPUT). Экранные поля можно объединять в экранные записи.
Описание экранных полей и самой формы располагается отдельно от
программы в файле описания экранной формы.\

Ниже приведен пример программы, иллюстрирующий работу с окнами.

OPEN WINDOW wind1 AT 2,30 WITH 10 ROWS, 40 COLUMNS

    ATTRIBUTE(BORDER, REVERSE, MESSAGE LINE FIRST)

       \# текущим окном является wind1

       . . .

OPEN WINDOW wind2 AT 5,15 WITH FORM \"schoolp\"

ATTRIBUTE(GREEN,PROMPT LINE LAST,

MESSAGE LINE LAST, FORM LINE FIRST)

       \# текущим окном является wind2

CLEAR  WINDOW wind1

       . . .

CURRENT WINDOW IS wind1

       \# текущим окном является wind1

OPEN FORM form1 from \"schoolp\"  \# Инициализировать форму form1

                               \# Взяв ее описание из файла

                               \# schoolp.frm

DISPLAY FORM form1      \# Вывести форму form1 в текущее окно

                       \# т.е. в wind1

В результате работы этих операторов на экране терминала появится
приблизительно такая картинка:

ѓ\'ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ\'

ѓљ         
ѓ\'ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ\' окно   
ѓљ

ѓљ          ѓљ значение равно 8                       ѓљ \...ѓwind1
              ѓљ

ѓљ   
ѓ\'ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ\'     

ѓљ    ѓљ      цех   \[  2\] \[литейный     \]      ѓљ      ѓљѓщѓ‹ѓ„     
ѓљ

ѓљ    ѓљ таб.номер \[26         \]              ѓљ      ѓљ окно       ѓљ

ѓљ    ѓљ фамилия   \[Петров У.Е.         \]     ѓљ      ѓљ \...ѓ wind2 
ѓљ

ѓљ    ѓљ должность \[бригадир            \]     ѓљ      ѓљ ѓЉ        ѓљ

ѓљ    ѓљ зарплата \[\$340         \]            ѓљѓщѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ‹ѓ„ѓљ

ѓљ    ѓљ дата рождения \[31.12.1952\]            ѓљ      ѓљ         ѓљ

ѓљ    ѓљ                                       ѓљ      ѓљ         ѓљ

ѓљ   
ѓ\"ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ\"

ѓљ          ѓљ 789                                    ѓљ         ѓљ

ѓљ         
ѓ\"ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ\"
      

ѓљ                                                                ѓљ

ѓљ   нет таких                                                    ѓљ

ѓ\"ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ\"

Операторы MENU. MESSAGE. PROMPT.

В результате работы фрагмента программы

let sta\_return=podtwervdenie(\" В самом деле решили закончить? \")

       \...

function podtwervdenie(stroka)

define stroka char(38) , kod\_wozwr  int

open window podtwervdenie AT 11,10 WITH 4 rows, 39 columns
ATTRIBUTE(border)

display stroka at 4, 2 attribute (reverse)

   menu \" \"

     command key(\"Y\")     \"   Yes   \" \"Действительно Да.\"

       let kod\_wozwr=1

       exit menu

     command key(\"N\",ESC) \"   No    \" \"Нет, вернуться обратно.\"

       let kod\_wozwr=0

       exit menu

     command key(\"A\")     \"  Abort  \" \"Отменить. И кончить.\"

       let kod\_wozwr=-1

       exit menu

   end menu

close window podtwervdenie

return kod\_wozwr

end function

на экране в текущем окне появится такое меню

      
+\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\--+

       \| :     Yes       No        Abort     \|

       \|Действительно Да.                     \|

       \|                                       \|

       \| В самом деле решили закончить?        \|

      
+\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\--+

Оператор OPTIONS

Оператор OPTIONS может установить новые режимы для ввода вывода, если
вас не устраивают заданные по умолчанию.

OPTIONS     MESSAGE LINE 23,

    HELP    FILE \"h4gl.txt\",   HELP  KEY CONTROL-T,

    DISPLAY ATTRIBUTE(REVERSE, UNDERLINE)

Операторы MESSAGE, ERROR

Оператор MESSAGE выводит строку значений на экран на message line.
Аргументами MESSAGE могут быть переменные и константы, но не выражения.

let ttmm=CURRENT

message \"Московское время \", ttmm

error \"Данных больше нет, прочитанно \", n, \" строк\"

Оператор ERROR делает тоже, что и MESSAGE, только со звонком и с
атрибутом REVERSE. Сообщение выводится на 24-ю строку экрана.

Оператор PROMPT

Оператор PROMPT выводит на экран display-list - список значений
переменных и констант, и вводит после этого с клавиатуры значение в
указанную вслед за ключевым словом FOR переменную.

PROMPT \"Да или нет ?\" FOR answer

       ON KEY (CONTROL-U)

          LET  answer=wozderv()

          EXIT PROMPT

END PROMPT

Можно включить в PROMPT  контрольные блоки,  выполняющиеся при нажатии
заданных клавиш. Если в данном примере во время ввода пользователь
нажмет клавишу CTRL-U то выполнятся операторы из ON  KEY  предложения: 
будет вызвана функция wozderv() а затем

прерван оператор PROMPT, не завершив ввода.

Операторы обмена с экранной формой

DISPLAY и INPUT

Оператор DISPLAY выводит данные в поля экранной формы.

DISPLAY a,b,zap\[i\].nomerceh TO pole1,fscr.\* ATTRIBUTE(BOLD)

Если имена выводимых переменных совпадают с именами экранных полей в
текущей экранной форме, то можно применить ключевое слово BY NAME.

DISPLAY BY NAME fio, dolvnostx

Оператор INPUT  используется для ввода значений через поля экранной
формы. Можно предусмотреть дополнительные действия при вводе.  Для этого
в оператор можно включить контрольные блоки AFTER, BEFORE, ON KEY.

INPUT  kadr.\* FROM fio, dolvnostx, nomerceh

    BEFORE FIELD nomerceh

       message \"Сегодня обслуживаются цеха 5 и 6\"

       sleep 2

       message \"\"

    AFTER FIELD nomerceh

       IF kadr.nomerceh \> 6 then

       MESSAGE \"Нет такого цеха, повторите\"

       NEXT FIELD NOMERCEH

       ENF IF

END INPUT

Фрагмент, реализующий окошко подсказки.

Ниже приведен пример программирования подсказки (в процессе
интерактивного диалога) с использованием экранного массива. Таблица ceh
содержит два столбца: номер цеха и его название. В приведенном фрагменте
вызывается функция wyborceh, которая выводит содержимое таблицы ceh в
экранный массив. Пользователь передвигает курсор на название нужного ему
цеха и нажимает клавишу CR. Подпрограмма определяет номер цеха и
возвращает его вызывающей программе.

DATABASE zawod

. . .

let nc= wyborceh()

. . .

FUNCTION wyborceh()     \#  Выбор цеха, для внесения изменений

DEFINE counter  int

DEFINE ceharr ARRAY\[25\] OF RECORD       \# массив для хранения

        nomerceh  int,      \# номерцеха    данных из таблицы

        nameceh char(20)    \# название цеха              ceh

        END RECORD

\# Открыть окно с рамкой и вывести в него экранную форму cehform

   OPEN WINDOW cehwind AT 4 ,6 WITH FORM \"cehform\"

        ATTRIBUTE(BORDER)

\# Объявить курсор для выбора содержимого из таблицы ceh

       DECLARE cehcurs CURSOR FOR

         SELECT \* FROM ceh ORDER BY nomerceh

\#  Выполнить запрос и все выбранные строки поместить в програм-

\#  ный массив ceharr

       LET counter = 0

       FOREACH cehcurs INTO ceharr\[counter+1\].\*

               LET counter = counter + 1

               IF counter \>=25 THEN   EXIT FOREACH   END IF

       END FOREACH

\# счетчик counter равен фактическому числу строк выданных в

\#  курсор

       MESSAGE \"Выберите цех и нажмите CR\"

\#  Вывести в экранный массив cehscreen в экранной форме cehform

\#  counter первых строк из программного массива ceharr

       call set\_count(counter)

       DISPLAY ARRAY ceharr TO cehscreen.\*

       ON KEY (CONTROL-M) EXIT DISPLAY

       END DISPLAY

\# Прервать показ экранного массива при нажатии клавиши CR

\# закрыть окно с экранной формой cehform

CLOSE WINDOW cehwind

let counter=arr\_curr()             \#номер строки массива,

                                  \#на котором нажато CR

RETURN ceharr\[counter\].nomerceh  \#номер цеха,

                                \#на котором нажато CR

END FUNCTION

А это пользователь увидит на экране:

  ѓ\'ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ\'

  ѓљ номер        цех            ѓљ

  ѓљ \[3  \] \[токарный            \]ѓљ

  ѓљ \[4  \] \[гараж               \]ѓљ

  ѓљ \[5 \] \[конюшня             \]ѓљ

  ѓљ \[6  \] \[столовая            \]ѓљ

  ѓљ \[   \] \[                    \]ѓљ

  ѓљ Выберите цех и нажмите CR   ѓљ

  ѓ\"ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ\"

Описание и компиляция экранных форм

В приведенном выше фрагменте использована экранная форма cehform.per.
Ниже приведено ее описание. Это описание должно лежать в файле
cehform.per и должно быть откомпилировано компилятором экранных форм
INFORMIX\'а form4gl.\

Описание экранной формы cehform.per

DATABASE zawod

SCREEN

{

номер        цех

\[f00\] \[f001                \]

\[f00\] \[f001                \]

\[f00\] \[f001                \]

\[f00\] \[f001                \]

\[f00\] \[f001                \]

}

TABLES

ceh

ATTRIBUTES

f00 =  ceh.nomerceh;

f001 = ceh.nameceh;

INSTRUCTIONS

screen record cehscreen\[5\] (ceh.\*)

END

В секции DATABASE указана база данных; в секции SCREEN  задана картинка,
которая будет рисоваться на экране; В TABLES указываются таблицы, в
ATRIBUTES указываются имена экранных полей, (и, возможно,  их атрибуты)
а в INSTRUCTIONS объявлен экранный массив cehscreen в пяти строках из
двух полей (nomerceh и nameceh)

В качестве примера ниже приводится функция,  реализующая простейший
калькулятор. Возвращает значение вычисленного выражения. Скомпилируйте
ее самостоятельно и посмотрите отладчиком, как она работает.

function kalkulator()           \#       Калькулятор

define wyravenie, kalkulator char(64), kolichestwo int

define stroka\_kalkulatora char(200)

define beep char(1)

let beep=ascii 7

open   window   kalkulator   at   2,2  with  form  \"kalkulator\"

attribute(border, form line first)

input by name wyravenie, kalkulator without defaults

before field kalkulator

  let stroka\_kalkulatora=

  \"select  count(\*),\",wyravenie,\" from systables\"

  whenever error continue

  prepare kalkulqtor\_operator from stroka\_kalkulatora

  if status\<0 then display beep to kalkulator display \"Неправильное
выражение\" to kalkulator next field wyravenie end if declare kalkulator
cursor for kalkulqtor\_operator foreach kalkulator into kolichestwo,
kalkulator if status\<0 then display beep to kalkulator display
\"Неправильное выражение\" to kalkulator next field wyravenie end if end
foreach whenever error stop display kalkulator to kalkulator next field
wyravenie end input close window kalkulator return kalkulator end
function

Использованная в подпрограмме экранная форма должна быть описана в файле
kalkulator.per и откомпилирована при помощи компилятора form4gl.

DATABASE formonly

SCREEN

{

       Калькулятор.            Чтобы закончить нажмите ESC

\[wyravenie                                                    \]

\[kalkulator                                                   \]

}

ATTRIBUTES

wyravenie =formonly.wyravenie;

kalkulator=formonly.kalkulator;

END

Пример программы, выдающей отчет

DATABASE zawod

MAIN

DEFINE zapisx record like kadry.\*

DEFINE  simw char (200), zapr char (300),fn  char (18)

OPEN form maxprim from \"maxprim\"

DISPLAY form maxprim            \# вывести экранную форму

CONSTRUCT BY NAME simw ON kadry.\* \# Введение критериев выбора

                                 \# с экрана

LET zapr=\"select \* from kadry  where \",

simw clipped,\" order by tabnom \"

MESSAGE simw

PREPARE selpr FROM zapr           \# Изготовление запроса

DECLARE qquer CURSOR FOR selpr    \# Объявление курсора для него

DISPLAY \"Не забудьте нажать CTRL-O\" AT 2,40

PROMPT \"Файл, куда выводить отчет? или CR, если на экран: \"

                        FOR fn

IF length(fn)=0 then START REPORT kadryrep       \# на экран

else                 START REPORT kadryrep TO fn \# в файл

END IF

  \# выполнить запрос и сбросить выбранные строки в отчет

  FOREACH qquer  into zapisx.\*   \# Очередную строку из курсора

  OUTPUT TO REPORT kadryrep(zapisx.\*)  \# поместить в отчет

  END FOREACH

FINISH REPORT kadryrep          \# Вывести результаты отчета

END MAIN

REPORT kadryrep(z)

DEFINE nameceh like ceh.nameceh

DEFINE z record like kadry.\*

  \# nomerceh  int,          \# номер цеха

  \# tabnom    serial,       \# табельн. номер

  \# fio       char(20),     \# фамилия

  \# dolvn     char(20),     \# должность

  \# zarplata  money(16,2),  \# зарплата

  \# datarovd  date          \# дата рожд.

       OUTPUT

left  margin 0

right margin 80

top   margin 0

bottom margin 0

page  length 23

      ORDER BY z.nomerceh, z.tabnom   \# Упорядочить

                   FORMAT

PAGE HEADER

print
\"\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\--\"

print \"цех\|таб.ном\|фио       \|должность   \|зарплата\| дата рожд\"

print
\"\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\"

ON EVERY ROW

print  z.nomerceh using \"\#\#\", column 4,z.tabnom using
\"\#\#\#\#\#\",

column 13,z.fio clipped,

column 28,z.dolvn clipped,

column 43,z.zarplata using \"\$\#\#\#\#.\#\#\",

column 53,z.datarovd using \"dd-mm-yyyy\"

BEFORE GROUP OF z.nomerceh

select \@nameceh into nameceh from ceh where nomerceh=z.nomerceh

skip to top of page

skip 1 line

print \"Цех   \",nameceh

skip 1 line

AFTER GROUP OF  z.nomerceh

need 2 lines

print \" В цехе \",nameceh clipped,2 spaces,

      group count(\*) using \"\#\#\#\#\#\" ,\" человек, \"

print \" Средняя зарплата \",

      group avg(z.zarplata) using \"\#\#\#\#\# руб.\#\# коп\"

PAGE TRAILER

print \"заполнена страница номер\", pageno

pause \"нажмите ВВОД\"

END REPORT

Вот что увидит на пользователь во время работы программы:

+\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\--+

\|Укажите файл, куда выводить отчет, или CR, если на экран:    \|

\|                                 Не забудьте нажать CONTROL-О\|

\|                                                             \|

\|\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\--              
\|

\|     цех   \[1:4\] \[                     \]                     \|

\| таб.номер \[           \]                                     \|

\| фамилия   \[\*ов                 \]                            \|

\| должность \[                    \]                            \|

\| зарплата \[\>500         \]                                   \|

\|дата рождения \[          \]                                   \|

\|                                                             \|

\|                                                             \|

nomerceh between 1 and 4 and fio matches \"\*о\*\" and zarplata\>500

\|                                                             \|

+\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\--+

\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\--

цех\|таб.ном\|фио            \|должность     \|зарплата\| дата рожд

\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_

Цех   дирекция

1    34    иванов         директор       \$ 4000.00

1    35    кононов        зав. по снабжению\$ 4000.00

В цехе дирекция      2 человек,

Средняя зарплата   4000 руб.00 коп

заполнена страница номер          1

нажмите ВВОД

\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\--

цех\|таб.ном\|фио            \|должность     \|зарплата\| дата рожд

\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_

Цех   литейный

2    12    окунев         рабочий        \$ 2000.00

2    14    липко          лаборант       \$ 2000.00

2    18    пухов          мастер         \$ 2000.00

2    21    сухов          рабочий        \$ 2000.00

2    24    угольков       рабочий        \$ 2000.00

В цехе литейный      5 человек,

Средняя зарплата   2000 руб.00 коп

заполнена страница номер          2

нажмите ВВОД

\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\--

цех\|таб.ном\|фио            \|должность     \|зарплата\| дата рожд

\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_

Цех   гараж

4     9    потруев        слесарь        \$ 1230.00

4    12    гундосов       шофер          \$ 2000.00

В цехе гараж      2 человек,

Средняя зарплата   1615 руб.00 коп

заполнена страница номер          3

нажмите ВВОД

Описание экранной формы

Описание состоит из 5 разделов: DATABASE, SCREEN, TABLES, ATTRIBUTES,
INSTRUCTIONS

\#  база данных, с которой ведется работа

DATABASE zawod

\#  Картинка, которая выводится на экран.

\#  экранные поля обозначены так:    \[метка поля \]

\#  метка поля используется в разделе ATTRIBUТЕ

SCREEN

{

номер цеха \[nceh  \]             зарплата   \[f002       \]

фамилия    \[fio                 \]

должность \[dol                 \]

                 Так в экранной форме рисуется рамка.

Значок \\g используется для входа и выхода в графический режим

                  
\\gp\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\--q\\g

                   \\g\|\\g Экранный массив         \\g\|\\g

                   \\g\|\\g \[s1     \]  \[s2            \] \\g\|\\g

                   \\g\|\\g \[s1     \]  \[s2            \] \\g\|\\g

                   \\g\|\\g \[s1     \]  \[s2            \] \\g\|\\g

                   \\g\|\\gномер цеха название цеха    \\g\|\\g

                  
\\gb\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\--d\\g

       в графическом режиме символы р q b d - \|  заменяются

       символами рисования рамки    ѓ\' ѓ\' ѓ\" ѓ\" ѓ› ѓљ

}

TABLES          \#  имена таблиц, с которыми ассоциированна форма

kadry

ceh

ATTRIBUTES      \# Имена экранных полей в форме и их атрибуты.

\# слева от знака (=) пишется метка поля (которая фигурирует в

\# разделе SCREEN), справа - имя экранного поля, которое обычно,

\# для удобства, должно совпадать с именем какого-нибудь столбца

\# из таблиц, перечисленных в разделе TABLES

nceh     = kadry.nomerceh;

f002     = zarplata, COLOR=REVERSE WHERE f002 \>500;

\#  если в поле выведено значение больше 500, то оно будет

\#  выделено с атрибутом  REVERSЕ (негатив)

fio  = fio;

dol  = dolvn, comments=\"Проверьте наличие в штатном расписании\";

s1      = ceh.nomerceh;

s2      = ceh.nameceh;

                           \#  здесь экранные поля можно

INSTRUCTIONS                \#  объединить в экранные записи

   screen record   kad (kadry.nomerceh, dolvn, zarplata)

               \#  и описать экранные массивы

   screen record   scr\[3\] (ceh.nomerceh, nameceh)

END

 \

а вот что увидит на экране пользователь, использующий эту форму:

ѓ\'ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ\'

ѓљ   номер цеха \[      \]            зарплата   \[f002      
\]           ѓљ

ѓљ   фамилия    \[                    \]                                
ѓљ

ѓљ   должность \[                    \]                                
ѓљ

ѓљ                    Так в экранной форме рисуется рамка.            
ѓљ

ѓљ    Значок используется для входа и выхода в графический режим      ѓљ

ѓљ                     
ѓ\'ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ\'              

ѓљ                      ѓљ   Экранный массив             ѓљ           
ѓљ

ѓљ                      ѓљ   \[       \]  \[              \] ѓљ
           ѓљ

ѓљ                      ѓљ   \[       \]  \[              \] ѓљ
           ѓљ

ѓљ                      ѓљ   \[       \]  \[              \] ѓљ
           ѓљ

ѓљ                      ѓљ   номер цеха название цеха   ѓљ            ѓљ

ѓљ                     
ѓ\"ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ\"           

ѓљ          в графическом режиме символы р q b d - \|  заменяются      
ѓљ

ѓљ          символами рисования рамки    ѓ\' ѓ\' ѓ\" ѓ\" ѓ› ѓљ
            ѓљ

ѓ\"ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ›ѓ

 \
В этой экранной форме определены экранные поля: kadry.nomerceh,
zarpllatа, fiо, dolvп, ceh.nomerceh, nameceh\

А так же экранные записи: kadrу (по умолчанию), ceh (по умолчанию), kad,
scr\[3\]