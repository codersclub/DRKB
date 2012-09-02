<h1>Краткое пособие по языку Informix-4GL</h1>
<div class="date">01.01.2007</div>


<p>Краткое пособие по языку INFORMIX-4GL.</p>
<p>Соглашения о Языке 4GL и Начальные Понятия.</p>
<p>Программа на языке 4GL может состоять из нескольких файлов (модулей) с исходными текстами на 4GL. К ней так же относятся файлы с описанием используемых экранных форм, которые компилируются отдельно. Имя каждого модуля должно иметь расширение .4gl (например, module1.4gl), а имя файла с описанием экранных форм должно иметь расширение .per (например, form2.per). <br>
Каждый модуль содержит описания переменных и несколько процедурных блоков function (подпрограммы) и report (блоки печати). В программе должен быть один блок main - главный блок, начинающийся с ключевого слова main. На него будет передаваться управление при старте программы. <br>
Формат записи операторов 4GL свободный. Можно писать все подряд на одной строке, один оператор на нескольких строках, слова операторов можно разделять произвольным количеством пробелов и комментариев. Никакими значками (типа ;) операторы разделять не нужно. Окончание операторов определяется по контексту. <br>
Весь набор ключевых слов языка зарезервирован, их нельзя занимать для других целей (на имена объектов и переменных 4GL). <br>
<p>Компилятору языка безразлично, большими или маленькими буквами пишутся операторы. Он их не различает. </p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td rowspan="3" ><p>Комментарии обозначаются знаками </p>
</td>
<td ><p>{ комментарий },</p>
</td>
<td ><p>или знаком # - до конца строки,</p>
</td>
<td ><p>или знаком -- (два знака минус) до конца строки.</p>
</td>
</tr>
<tr >
<td >
</td>
<td >
</td>
<td >
</td>
</tr>
<tr >
<td >
</td>
<td >
</td>
<td ><p>&nbsp;
</td>
</tr>
</table>
<p>Объекты, Используемые в INFORMIX-4GL. </p>
<p>1. Объекты SQL&nbsp;&nbsp;&nbsp; 2. Переменные 4GL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3. Программные</p>
<p>Имя базы данных &nbsp; простая переменная &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; функция</p>
<p>Имя таблицы &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; переменная типа "запись"&nbsp;&nbsp;&nbsp; отчет</p>
<p>Имя столбца &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; массив &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; метка</p>
<p>Имя индекса</p>
<p>Имя псевдотаблицы</p>
<p>Имя синонима</p>
<p>( database-name&nbsp;&nbsp; простые переменные &nbsp;&nbsp;&nbsp;&nbsp; function )</p>
<p>( table-name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; переменная типа запись  report&nbsp;&nbsp; )</p>
<p>( column-name&nbsp;&nbsp;&nbsp;&nbsp; массивы &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; label&nbsp;&nbsp;&nbsp; )</p>
<p>( index-name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )</p>
<p>( view-name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )</p>
<p>( synonim-name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )</p>
<p>4. Имена операторов &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5. Объекты экранного обмена.</p>
<p> &nbsp; и курсоров</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; window</p>
<p>statement-id - изготовленный оператор  form</p>
<p>cursor-name&nbsp; - курсор &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; screen-field</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; screen-record</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; screen-array</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>Идентификаторы INFORMIX. <br>
<p>Каждый объект 4GL имеет имя (идентификатор) - это слово, состоящее из букв, цифр, и знаков подчеркивания (_), начинающееся с буквы или знака (_). В INFORMIX-4GL не различаются маленькие и большие буквы. Поэтому i_Un103Tt и I_UN103TT - одно и тоже имя. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>Области Действия Имен Переменных: </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Локальная переменная - объявлена внутри блока function, main, report. Действует внутри блока, в котором объявлена. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Модульная переменная должна быть объявлена в самом начале модуля с исходным текстом вне любого блока report, function или main. Действует внутри всего модуля (за исключением блоков, в которых это имя переобъявлено и является для них локальным). </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Глобальные переменные - объявляются с помощью оператора GLOBALS в начале модулей. Действуют во всех модулях с исходным текстом, в которых есть соответствующее объявление этих переменных. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>Область действия имен КУРСОРОВ и Изготовленных Операторов от точки их объявления (DECLARE, PREPARE) и до конца модуля. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>Область действия имен Окон, Форм, Функций, Отчетов - во всей программе. </td></tr></table></div><p>В Языке 4GL Есть Такие Операторы:</p>
<p>Операторы SQL</p>
<p>Организация программы </p>
<p>MAIN</p>
<p>FUNCTION</p>
<p>REPORT</p>
<p>Объявления переменных </p>
<p>DEFINE</p>
<p>GLOBALS</p>
<p>Присвоения </p>
<p>LET</p>
<p>INITIALIZE</p>
<p>Программные </p>
<p>CALL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; EXIT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; GOTO</p>
<p>RETURN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FOR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LABLE</p>
<p>CASE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; WHILE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RUN</p>
<p>IF&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CONTINUE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SLEEP</p>
<p>Перехват прерываний </p>
<p>WHENEVER</p>
<p>DEFER</p>
<p>Динамическое создание операторов </p>
<p>PREPARE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; EXECUTE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FREE</p>
<p>Манипуляция "курсором" </p>
<p>DECLARE</p>
<p>OPEN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FOREACH&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PUT</p>
<p>CLOSE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FETCH&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FLUSH</p>
<p>Экранный обмен </p>
<p>MENU&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; OPEN FORM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DISPLAY ARRAY</p>
<p>OPTIONS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DISPLAY FORM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SCROLL</p>
<p>OPEN WINDOW&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CLOSE FORM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; INPUT ARRAY</p>
<p>CURRENT WINDOW&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DISPLAY&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PROMPT</p>
<p>CLEAR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; INPUT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ERROR</p>
<p>CLOSE WINDOW&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CONSTRUCT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MESSAGE</p>
<p>Генерация отчетов </p>
<p>START&nbsp; REPORT</p>
<p>OUTPUT TO&nbsp; REPORT</p>
<p>FINISH REPORT</p>
<p>Типы Переменных и Операторы Описания Переменных в 4GL.</p>
<p>В языке 4GL имеются простые переменные, переменные типа запись и массивы. Простые переменные бывают следующих типов: </p>
<p> &nbsp;&nbsp; INTEGER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CHAR(n)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DATE</p>
<p> &nbsp;&nbsp; SMALLINT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DECIMAL(m,n)&nbsp;&nbsp; DATETIME ед_врем1 TO ед_врем2</p>
<p> &nbsp;&nbsp; REAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MONEY(m,n)&nbsp;&nbsp;&nbsp;&nbsp; INTERVAL ед_врем1 TO ед_врем2</p>
<p> &nbsp;&nbsp; FLOAT</p>
<p>&nbsp;<br>
<p>где ед_врем1, ед_врем2 - единицы измерения времени </p>
<p>{YEAR,MONTH,DAY,HOUR,MINUTE,SECOND,FRACTION(n)}</p>
<p>&nbsp;<br>
где FLOAT = DOUBLE PRECISSION <br>
Переменная типа запись описывается при помощи конструкции RECORD ... END RECORD или конструкции LIKE имя_таблицы.* <br>
Переменная типа массив имеет описатель ARRAY [i,j,k] OF type, где type - тип простой переменной, конструкция RECORD, или конструкция ARRAY. <br>
<p>Для описания переменных служит оператор DEFINE: </p>
<p>DEFINE&nbsp; simw char (200), j,i,k INTEGER, ff FLOAT</p>
<p># Здесь объявлены символьная переменная simw длиной 200 байт,</p>
<p># целые i,j,k, и ff - восьмибайтовое с плавающей точкой</p>
<p>DATABASE zawod</p>
<p>DEFINE doljno&nbsp;&nbsp; RECORD</p>
<p># объявляется запись doljno, состоящая из 4 простых переменных</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dolzn CHAR(20),&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # должность</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; zarplmin&nbsp; LIKE kadry.zarplata,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; zarplmax&nbsp; money(16,2),&nbsp; # зарплата</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; vakansii int&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # вакансии</p>
<p>END RECORD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # Здесь заканчивается объявление записи doljno</p>
<p># Переменную можно оъявить с ключевым словом LIKE column_name.</p>
<p># переменная zarplmin получает такой же тип,&nbsp; что  и  столбец</p>
<p># zarplata таблицы kadry из базы данных zawod</p>
<p>DEFINE rrr RECORD LIKE kadry.*</p>
<p>#&nbsp; Переменную типа запись тоже можно объявить с ключевым словом</p>
<p>#&nbsp; LIKE. Здесь объявлена запись rrr, содержащая элементы, имею-</p>
<p>#&nbsp; щие те  же  самые  названия и те же самые типы что и столбцы</p>
<p>#&nbsp; таблицы kadry</p>
<p>&nbsp;<br>
<p>Элементами записи могут быть массивы. Можно обьявить массив элементов типа RECORD. </p>
<p>DEFINE zap RECORD</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; a LIKE kadry.tabnom,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; b array[8] OF REAL</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; END RECORD,</p>
<p>  massiw ARRAY[2,15] OF RECORD</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; kolwo INT,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; tip CHAR(8)</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; END RECORD</p>
<p>#&nbsp;&nbsp;&nbsp; massiw&nbsp; объявлен как массив записей. Каждая запись состоит</p>
<p>#&nbsp; из двух простых элементов - kolwo и tip</p>
<p>&nbsp;<br>
<p>Индексы массивов пишутся в квадратных скобках. На элементы записей можно ссылаться по его имени, если не допускается двусмысленности, иначе их необходимо уточнять именем записи, отделяя его точкой (.) от простого имени. </p>
<p>#&nbsp; присвоить значение элементу массива можно так:</p>
<p>LET&nbsp;&nbsp; massiw[1,i+2].kolwo = zap.a + LENGTH(massiw[1,i+2].tip)</p>
<p>&nbsp;<br>
<p>Для сокращения перечисления элементов в списках можно пользоваться нотацией (*). Например, strkt.* означает все элементы записи strkt. А так же нотацией THRU: (элементы записи от и до) </p>
<p>SELECT kadry.* INTO strkt.* FROM kadry WHERE kadry.tabnom=i+j</p>
<p>SELECT * INTO strukt.b THRU strkt.e FROM kadry</p>
<p>&nbsp;<br>
<p>Глобальные переменные должны иметь одинаковые объявления GLOBALS во всех модулях программы (в которых используются). Проще всего это организуется так: заводится отдельный модуль, в котором ничего, кроме объявлений GLOBALS нет. А во всех остальных модулях программы ссылаются на этот файл. Ниже приводится пример объявления глобальных переменных в файле progrglob.4gl: </p>
<p>DATABASE zawod</p>
<p> GLOBALS</p>
<p>  DEFINE zap RECORD LIKE kadry.*</p>
<p>  DEFINE ext_count INT</p>
<p> &nbsp; . . .</p>
<p> END GLOBALS</p>
<p>&nbsp;<br>
<p>Тогда в остальные модули программы, где используются эти глобальные переменные, надо включить строчку </p>
<p>GLOBALS "progrglob"</p>
<p>  . . .</p>
<p>Подпрограммные Блоки (Функции).</p>
<p>В языке 4GL при программировании функций (подпрограмм) используются операторы function. Все аргументы функции должны быть объявлены. Аргументы передаются по значению. Если функция возвращает какие-либо значения, то при вызове ее нужно воспользоваться в операторе CALL предложением RETURNING с перечислением переменных, в которые возвращается значение. Ниже приводится соответствующий фрагмент программы. </p>
<p>FUNCTION stroka(rec)</p>
<p>DEFINE rec RECORD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; i int, st char(256)&nbsp; END RECORD</p>
<p>RETURN&nbsp; st clipped,"автопробега"</p>
<p>END FUNCTION</p>
<p> . . .</p>
<p>MAIN</p>
<p> . . .</p>
<p> &nbsp; CALL stroka(rec1.*) RETURNING simw</p>
<p> . . .</p>
<p> &nbsp; LET simw=stroka(7,"Привет участникам ")</p>
<p>#&nbsp;&nbsp;&nbsp; Если функция возвращает одно значение, то ее имя мож-</p>
<p>#&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; но использовать в выражениях.</p>
<p> &nbsp; MESSAGE simw</p>
<p> . . .</p>
<p>END MAIN</p>
<p>&nbsp;<br>
<p>На экране пользователь увидит: </p>
<p>&#1107;&#1027;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#8218;</p>
<p>&#1107;&#1033; &nbsp; Привет участникам автопробега &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1033;</p>
<p>&#1107;&#1033; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1033;</p>
<p>&#1107;&#1033; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1033;</p>
<p>&#1107;&#1033; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1033;</p>
<p>&#1107;&#1107;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#8222;</p>
<p>Примеры Использования Программных Операторов.</p>
<p>Оператор безусловного перехода действует в пределах модуля. </p>
<p>GOTO metka</p>
<p> . . .</p>
<p>LABEL&nbsp; metka:&nbsp;&nbsp; . . .</p>
<p>&nbsp;<br>
<p>Оператор выбора. </p>
<p>CASE</p>
<p> &nbsp; WHEN iscreen=1</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; current window is w1</p>
<p> &nbsp; WHEN iscreen=2</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; current window is w2</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; let iscreen=1</p>
<p> &nbsp; OTHERWISE</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; current window is SCREEN</p>
<p>END CASE</p>
<p>CASE&nbsp;&nbsp; (a+b)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #&nbsp;&nbsp;&nbsp; Другой формат оператора CASE</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; WHEN&nbsp; 1</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; message "a=",a</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; WHEN&nbsp; 2</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; message "b=",b</p>
<p> END CASE</p>
<p>&nbsp;<br>
<p>Условный оператор. </p>
<p>IF str = "завершить" OR y&lt;0 THEN exit program # Не забывайте в конце каждого условного # оператора ставить END IF. END IF </p>
<p>Оператор цикла. </p>
<p>  FOR&nbsp;&nbsp;&nbsp;&nbsp; I= i1 TO 23</p>
<p>  let a[i]=0</p>
<p> &nbsp;&nbsp;&nbsp; if b[i]=100 then</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; EXIT FOR</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; END IF</p>
<p>  END FOR</p>
<p>Цикл "пока".</p>
<p>  WHILE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ff &gt; 3 or nn="проба"</p>
<p> &nbsp; PROMPT "Введите число " for n</p>
<p> &nbsp; let i=n+1</p>
<p> &nbsp; message "А у меня ",i,", больше.&nbsp;&nbsp; Вы проиграли."</p>
<p> &nbsp; SLEEP&nbsp; 5</p>
<p> &nbsp; RUN "rm *" WITHOUT WAITING</p>
<p>  END WHILE</p>
<p>Динамическое Изготовление Операторов SQL. Курсоры.</p>
<p>Операторы PREPARE и EXECUTE предназначены для динамического (во время выполнения программы) изготовления и выполнения операторов языка SQL (не 4GL !!!). <br>
<p>В приведенном ниже фрагменте в ответ на запрос пользователь сможет ввести с клавиатуры строку с оператором языка SQL (Пусть, например, он введет строку: DROP DATABASE buhgalteriq). Программа изготовит из этой строки настоящий оператор и выполнит его с помощью оператора EXECUTE. Если при выполнении зарегистрирована ошибка, о чем сообщит установленный в отрицательное значение код завершения status, пользователя снова попросят ввести оператор. </p>
<p>DEFINE stroka char(200)</p>
<p>  MAIN</p>
<p>  . . .</p>
<p> &nbsp; LABEL METK2:PROMPT "введите оператор языка SQL: " FOR stroka</p>
<p> &nbsp;&nbsp; WHENEVER ERROR CONTINUE&nbsp;&nbsp;&nbsp;&nbsp; # Включить  режим &nbsp; "В &nbsp; случае</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # ошибки  продолжить выполнение</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # программы"</p>
<p> &nbsp;&nbsp; PREPARE st1 FROM stroka&nbsp;&nbsp;&nbsp;&nbsp; # Изготовить оператор из</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # символьной строки</p>
<p> &nbsp;&nbsp; EXECUTE st1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #&nbsp;&nbsp; Выполнить изготовленный оператор</p>
<p> &nbsp;&nbsp; IF status&lt;0 THEN ERROR "ошибка номер ", status, " в вашем операторе" GOTO metk2 END IF WHENEVER ERROR STOP # Восстановить режим # "В случае ошибки прервать # выполнение программы" . . . END MAIN </p>
<p>В системную переменную status помещается код выполнения каждого оператора 4GL (status=0 если все нормально, status&lt;0 если произошла ошибка). Переменная status может проверяться после любого оператора программы и в зависимости от ее значения могут предприниматься какие-либо действия. </p>
<p>Курсоры </p>
<p>Если запрос к таблице возвращает несколько (больше одной) строк, то для их обработки используется так называемый курсор - указатель во множестве строк, выбранных оператором SELECT. Оператором DECLARE объявляется курсор для запроса, оператором OPEN этот запрос фактически выполняется и выбранные строки выделяются. Курсор устанавливается на первую из выбранных строк. С помощью оператора FETCH вы можете брать очередную строку, на которую указывает курсор, и помещать ее в свои программные переменные. Курсор после этого смещается на следующую строку. <br>
<p>С помощью конструкции циклической FOREACH имя_курсора ... END FOREACH можно перебрать все строки, выбранные оператором SELECT. Оператор OPEN в этом случае не нужен. </p>
<p>  DATABASE zawod</p>
<p>  DEFINE zap RECORD LIKE kadry.*</p>
<p>  DECLARE curs1 CURSOR FOR</p>
<p> &nbsp;&nbsp;&nbsp; select * from kadry where datarovd&gt;"9/25/1973"</p>
<p> #&nbsp; в цикле FOREACH выводим на экран все строки таблицы  kadry,</p>
<p> #&nbsp; в которых  столбец datarovd содержит дату после 25 сентября</p>
<p> #&nbsp; 1973 года.</p>
<p>  FOREACH curs1 INTO zap.*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # Берем очередную строку и  по-</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # мещаем ее в запись zap</p>
<p>  MESSAGE zap.*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #&nbsp; Выводим запись zap на экран</p>
<p>  PROMPT "Еще ?" FOR CHAR c</p>
<p>  END FOREACH&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #&nbsp; Конец цикла FOREACH</p>
<p>В следующем примере строки выбираемые из  таблицы  kadry&nbsp; через курсор curs2 помещаются в массив z1 (но не более 100 строк).</p>
<p>  DATABASE zawod</p>
<p>  DEFINE z1 ARRAY[100] OF RECORD LIKE kadry.*, counter int</p>
<p>  DECLARE curs2 CURSOR FOR SELECT * FROM kadry</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; WHERE datarovd&lt;"9/26/1973" OPEN curs2 FOR counter="1" TO 100 FETCH curs2 INTO z1[counter].* # взять очередную строку и поместить ее в следующий элемент # массива z1 IF status="NOTFOUND" THEN # если выбранные сроки кончились, закончить цикл EXIT FOR END IF END FOR LET counter="counter-1" MESSAGE "В массив z1 прочитано ",counter, " записей" </p>
<p>Этот пример демонстрирует еще одно использование переменной status. Если оператор FETCH пытается взять сроку из курсора когда тот уже пуст, то значение переменной status устанавливается равным символической константе NOTFOUND, имеющей значение 100. Поэтому можно проверять значение status после оператора FETCH и если оно равно 100, то прекратить чтение строк из опустевшего курсора. В данном примере пользователь сам должен ввести условия, по которым будут найдены строки в таблице ceh. Он, например, может ввести: "nomerceh&gt;15 and nomerceh&lt;23". Программа прицепит это условие к строке, в которой записан SELECT оператор, получит строчку "SELECT * FROM ceh WHERE nomerceh&gt;15 and nomerceh&lt;23", изготовит из нее оператор, и для этого изготовленного оператора SELECT объявит курсор. Дальше действия аналогичны предыдущему примеру. </p>
<p>DEFINE z2 ARRAY[100] OF RECORD LIKE ceh.*,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; counter int, simw char(200)</p>
<p>PROMPT "допишите оператор SELECT * FROM ceh WHERE " FOR simw</p>
<p>IF LENGTH(simw)=0 THEN</p>
<p> &nbsp;&nbsp; LET simw="TRUE"</p>
<p> &nbsp;&nbsp; END IF</p>
<p>LET simw="SELECT * FROM ceh WHERE ", simw CLIPPED</p>
<p>PREPARE st2 FROM simw</p>
<p>  DECLARE cs2 FOR st2</p>
<p>  let counter=1</p>
<p>  FOREACH cs2 INTO z2[counter].*</p>
<p>  LET counter=counter+1</p>
<p>  IF counter&gt;100 THEN</p>
<p> &nbsp;&nbsp;&nbsp; EXIT FOREACH</p>
<p> &nbsp;&nbsp;&nbsp; END IF</p>
<p>  END FOREACH</p>
<p>LET&nbsp;&nbsp; counter=counter-1</p>
<p>MESSAGE "В массив z2 прочитано ",counter, " записей"</p>
<p>Программирование Экранного Обмена.</p>
<p>В любой момент времени на экране терминала существует ТЕКУЩЕЕ окно, через которое и выполняется ввод/вывод вашей программы. С окном связаны используемые при вводе и выводе атрибуты (например, green, revers, underline и т.п.) и номера строк окна, используемых операторами MESSAGE, PROMPT и ERROR для вывода. <br>
При открытии нового окна оно становится текущим и и весь ввод/вывод будет направляться уже в него. <br>
В окно можно вывести экранную форму, которая, представляет собой набор экранных полей, имеющих имена, и в эти поля (из этих полей), обращаясь к ним по имени, можно выводить (вводить) данные с помощью оператора DISPLAY (INPUT). Экранные поля можно объединять в экранные записи. Описание экранных полей и самой формы располагается отдельно от программы в файле описания экранной формы. <br>
<p>Ниже приведен пример программы, иллюстрирующий работу с окнами. </p>
<p>OPEN WINDOW wind1 AT 2,30 WITH 10 ROWS, 40 COLUMNS</p>
<p> &nbsp;&nbsp;&nbsp; ATTRIBUTE(BORDER, REVERSE, MESSAGE LINE FIRST)</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # текущим окном является wind1</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; . . .</p>
<p>OPEN WINDOW wind2 AT 5,15 WITH FORM "schoolp"</p>
<p>ATTRIBUTE(GREEN,PROMPT LINE LAST,</p>
<p> MESSAGE LINE LAST, FORM LINE FIRST)</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # текущим окном является wind2</p>
<p>CLEAR&nbsp; WINDOW wind1</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; . . .</p>
<p>CURRENT WINDOW IS wind1</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # текущим окном является wind1</p>
<p>OPEN FORM form1 from "schoolp"&nbsp; # Инициализировать форму form1</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # Взяв ее описание из файла</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # schoolp.frm</p>
<p>DISPLAY FORM form1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # Вывести форму form1 в текущее окно</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # т.е. в wind1</p>
<p>  В результате работы этих операторов  на  экране  терминала появится приблизительно такая картинка:</p>
<p>&#1107;'&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;'</p>
<p>&#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;'&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;' окно &nbsp;&nbsp; &#1107;&#1113;</p>
<p>&#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113; значение  равно 8 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;  ...&#1107;wind1 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;</p>
<p>&#1107;&#1113; &nbsp;&nbsp; &#1107;'&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p>&#1107;&#1113; &nbsp;&nbsp; &#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp; цех &nbsp; [&nbsp; 2] [литейный &nbsp;&nbsp;&nbsp; ]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;&#1107;щ&#1107;&#8249;&#1107;&#8222; &nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;</p>
<p>&#1107;&#1113; &nbsp;&nbsp; &#1107;&#1113;  таб.номер [26&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113; окно &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;</p>
<p>&#1107;&#1113; &nbsp;&nbsp; &#1107;&#1113;  фамилия &nbsp; [Петров У.Е.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;  ...&#1107; wind2&nbsp; &#1107;&#1113;</p>
<p>&#1107;&#1113; &nbsp;&nbsp; &#1107;&#1113;  должность [бригадир &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;  &#1107;&#1033; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;</p>
<p>&#1107;&#1113; &nbsp;&nbsp; &#1107;&#1113;  зарплата  [$340&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;&#1107;щ&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8249;&#1107;&#8222;&#1107;&#1113;</p>
<p>&#1107;&#1113; &nbsp;&nbsp; &#1107;&#1113; дата рождения [31.12.1952]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;</p>
<p>&#1107;&#1113; &nbsp;&nbsp; &#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;</p>
<p>&#1107;&#1113; &nbsp;&nbsp; &#1107;"&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;" </p>
<p>&#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;  789 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;</p>
<p>&#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;"&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;" &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p>&#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;</p>
<p>&#1107;&#1113; &nbsp; нет таких &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;</p>
<p>&#1107;"&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;"</p>
<p>Операторы MENU. MESSAGE. PROMPT.</p>
<p>В результате работы фрагмента программы </p>
<p>let sta_return=podtwervdenie(" В самом деле решили закончить? ")</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ...</p>
<p>function podtwervdenie(stroka)</p>
<p>define stroka char(38) , kod_wozwr&nbsp; int</p>
<p>  open window podtwervdenie AT 11,10 WITH 4 rows, 39 columns ATTRIBUTE(border)</p>
<p>  display stroka at 4, 2 attribute (reverse)</p>
<p> &nbsp;&nbsp; menu " "</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; command key("Y")&nbsp;&nbsp;&nbsp;&nbsp; "&nbsp;&nbsp; Yes&nbsp;&nbsp; " "Действительно  Да."</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; let kod_wozwr=1</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; exit menu</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; command key("N",ESC) "&nbsp;&nbsp; No&nbsp;&nbsp;&nbsp; " "Нет, вернуться обратно."</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; let kod_wozwr=0</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; exit menu</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; command key("A")&nbsp;&nbsp;&nbsp;&nbsp; "&nbsp; Abort&nbsp; " "Отменить. И кончить."</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; let kod_wozwr=-1</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; exit menu</p>
<p> &nbsp;&nbsp; end menu</p>
<p>  close window podtwervdenie</p>
<p>  return kod_wozwr</p>
<p>end function</p>
<p>на экране в текущем окне появится такое меню</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +---------------------------------------+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | :  &nbsp;&nbsp;&nbsp; Yes&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp; No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Abort&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |Действительно  Да.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | В самом деле решили закончить?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +---------------------------------------+</p>
<p>Оператор OPTIONS</p>
<p>Оператор OPTIONS может установить новые режимы для ввода вывода, если вас не устраивают заданные по умолчанию. </p>
<p>OPTIONS&nbsp;&nbsp;&nbsp;&nbsp; MESSAGE LINE 23,</p>
<p> &nbsp;&nbsp;&nbsp; HELP&nbsp;&nbsp;&nbsp; FILE "h4gl.txt",&nbsp;&nbsp; HELP&nbsp; KEY CONTROL-T,</p>
<p> &nbsp;&nbsp;&nbsp; DISPLAY ATTRIBUTE(REVERSE, UNDERLINE)</p>
<p>Операторы MESSAGE, ERROR</p>
<p>Оператор MESSAGE выводит строку значений на экран на message line. Аргументами MESSAGE могут быть переменные и константы, но не выражения. </p>
<p>let ttmm=CURRENT</p>
<p>message "Московское время ", ttmm</p>
<p>error "Данных больше нет, прочитанно ", n, " строк"</p>
<p>Оператор ERROR делает тоже, что и MESSAGE, только со звонком  и с атрибутом REVERSE. Сообщение выводится на 24-ю строку экрана.</p>
<p>Оператор PROMPT</p>
<p>Оператор PROMPT выводит на экран display-list - список значений переменных и констант, и вводит после этого с клавиатуры значение в указанную вслед за ключевым словом FOR переменную. </p>
<p>PROMPT "Да или нет ?" FOR answer</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ON KEY (CONTROL-U)</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LET&nbsp; answer=wozderv()</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; EXIT PROMPT</p>
<p>END PROMPT</p>
<p>Можно включить в PROMPT&nbsp; контрольные  блоки,&nbsp; выполняющиеся при нажатии заданных клавиш. Если в данном примере  во  время ввода пользователь нажмет клавишу CTRL-U то выполнятся  операторы  из ON&nbsp; KEY&nbsp; предложения:&nbsp; будет  вызвана функция wozderv() а затем</p>
<p>прерван оператор PROMPT, не завершив ввода.</p>
<p>Операторы обмена с экранной формой</p>
<p>DISPLAY и INPUT </p>
<p>Оператор DISPLAY выводит данные в поля экранной формы. </p>
<p>DISPLAY a,b,zap[i].nomerceh TO pole1,fscr.* ATTRIBUTE(BOLD)</p>
<p>Если имена выводимых переменных совпадают  с  именами  экранных полей  в  текущей  экранной  форме, то можно применить ключевое слово BY NAME.</p>
<p>DISPLAY BY NAME fio, dolvnostx</p>
<p>Оператор  INPUT&nbsp; используется  для  ввода  значений  через поля экранной формы. Можно предусмотреть дополнительные действия при вводе.&nbsp; Для  этого  в оператор можно включить контрольные блоки AFTER, BEFORE, ON KEY.</p>
<p>INPUT&nbsp; kadr.* FROM fio, dolvnostx, nomerceh</p>
<p> &nbsp;&nbsp;&nbsp; BEFORE FIELD nomerceh</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; message "Сегодня обслуживаются цеха 5 и 6"</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sleep 2</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; message ""</p>
<p> &nbsp;&nbsp;&nbsp; AFTER FIELD nomerceh</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IF kadr.nomerceh &gt; 6 then</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MESSAGE "Нет такого цеха, повторите"</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NEXT FIELD NOMERCEH</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ENF IF</p>
<p>END INPUT</p>
<p>Фрагмент, реализующий окошко подсказки.</p>
<p>Ниже приведен пример программирования подсказки (в процессе интерактивного диалога) с использованием экранного массива. Таблица ceh содержит два столбца: номер цеха и его название. В приведенном фрагменте вызывается функция wyborceh, которая выводит содержимое таблицы ceh в экранный массив. Пользователь передвигает курсор на название нужного ему цеха и нажимает клавишу CR. Подпрограмма определяет номер цеха и возвращает его вызывающей программе. </p>
<p>DATABASE zawod</p>
<p> . . .</p>
<p>let nc= wyborceh()</p>
<p> . . .</p>
<p>  FUNCTION wyborceh()&nbsp;&nbsp;&nbsp;&nbsp; #&nbsp; Выбор цеха, для внесения изменений</p>
<p>  DEFINE counter&nbsp; int</p>
<p>  DEFINE ceharr ARRAY[25] OF RECORD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # массив для хранения</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; nomerceh&nbsp; int,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # номерцеха &nbsp;&nbsp; данных  из таблицы</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; nameceh char(20)&nbsp;&nbsp;&nbsp; # название цеха &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ceh</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; END RECORD</p>
<p># Открыть окно с рамкой и вывести в него экранную форму cehform</p>
<p> &nbsp;&nbsp; OPEN WINDOW cehwind AT 4 ,6 WITH FORM "cehform"</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ATTRIBUTE(BORDER)</p>
<p># Объявить курсор для выбора содержимого из таблицы ceh</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DECLARE cehcurs CURSOR FOR</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SELECT * FROM ceh ORDER BY nomerceh</p>
<p>#&nbsp; Выполнить запрос и все выбранные строки поместить в програм-</p>
<p>#&nbsp; ный массив ceharr</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LET counter = 0</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FOREACH cehcurs INTO ceharr[counter+1].*</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LET counter = counter + 1</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IF counter &gt;=25 THEN&nbsp;&nbsp; EXIT FOREACH&nbsp;&nbsp; END IF</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; END FOREACH</p>
<p># счетчик counter равен фактическому  числу  строк  выданных  в</p>
<p>#&nbsp; курсор</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MESSAGE "Выберите цех и нажмите CR"</p>
<p>#&nbsp; Вывести в экранный массив cehscreen в экранной форме cehform</p>
<p>#&nbsp; counter первых строк из программного массива ceharr</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; call set_count(counter)</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DISPLAY ARRAY ceharr TO cehscreen.*</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ON KEY (CONTROL-M) EXIT DISPLAY</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; END DISPLAY</p>
<p># Прервать показ экранного массива при нажатии клавиши CR</p>
<p># закрыть окно с экранной формой cehform</p>
<p>CLOSE WINDOW cehwind</p>
<p>let counter=arr_curr()&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #номер строки массива,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #на котором нажато CR</p>
<p>RETURN ceharr[counter].nomerceh&nbsp; #номер цеха,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #на котором нажато CR</p>
<p>END FUNCTION</p>
<p>А это пользователь увидит на экране:</p>
<p> &nbsp; &#1107;'&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;'</p>
<p> &nbsp; &#1107;&#1113;  номер &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; цех &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;</p>
<p> &nbsp; &#1107;&#1113;  [3&nbsp; ] [токарный &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]&#1107;&#1113;</p>
<p> &nbsp; &#1107;&#1113;  [4&nbsp; ] [гараж &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]&#1107;&#1113;</p>
<p> &nbsp; &#1107;&#1113;  [5  ] [конюшня &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]&#1107;&#1113;</p>
<p> &nbsp; &#1107;&#1113;  [6&nbsp; ] [столовая &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]&#1107;&#1113;</p>
<p> &nbsp; &#1107;&#1113;  [&nbsp;&nbsp; ] [&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]&#1107;&#1113;</p>
<p> &nbsp; &#1107;&#1113;  Выберите цех и нажмите CR&nbsp;&nbsp; &#1107;&#1113;</p>
<p> &nbsp; &#1107;"&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;"</p>
<p>Описание и компиляция экранных форм</p>
<p>В приведенном выше фрагменте использована экранная форма cehform.per. Ниже приведено ее описание. Это описание должно лежать в файле cehform.per и должно быть откомпилировано компилятором экранных форм INFORMIX'а form4gl. <br>
<p>Описание экранной формы cehform.per </p>
<p>DATABASE zawod</p>
<p>SCREEN</p>
<p>{</p>
<p>номер &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; цех</p>
<p>[f00] [f001&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]</p>
<p>[f00] [f001&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]</p>
<p>[f00] [f001&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]</p>
<p>[f00] [f001&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]</p>
<p>[f00] [f001&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]</p>
<p>}</p>
<p>TABLES</p>
<p>ceh</p>
<p>ATTRIBUTES</p>
<p>f00 =&nbsp; ceh.nomerceh;</p>
<p>f001 = ceh.nameceh;</p>
<p>INSTRUCTIONS</p>
<p>screen record cehscreen[5] (ceh.*)</p>
<p>END</p>
<p>В  секции DATABASE указана база данных; в секции SCREEN&nbsp; задана картинка, которая будет рисоваться на экране; В TABLES указываются таблицы, в ATRIBUTES указываются имена экранных полей, (и, возможно,&nbsp; их атрибуты) а в INSTRUCTIONS объявлен экранный массив cehscreen в пяти строках из двух полей (nomerceh и nameceh)</p>
<p>В качестве примера ниже приводится функция,&nbsp; реализующая  простейший калькулятор. Возвращает значение вычисленного выражения. Скомпилируйте  ее  самостоятельно  и посмотрите отладчиком, как она работает.</p>
<p>function kalkulator()&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Калькулятор</p>
<p>define wyravenie, kalkulator char(64), kolichestwo int</p>
<p>define stroka_kalkulatora char(200)</p>
<p>define beep char(1)</p>
<p>let beep=ascii 7</p>
<p>open&nbsp;&nbsp; window&nbsp;&nbsp; kalkulator&nbsp;&nbsp; at&nbsp;&nbsp; 2,2&nbsp; with&nbsp; form&nbsp; "kalkulator"</p>
<p>attribute(border, form line first)</p>
<p> input by name wyravenie, kalkulator without defaults</p>
<p> before field kalkulator</p>
<p> &nbsp; let stroka_kalkulatora=</p>
<p> &nbsp; "select&nbsp; count(*),",wyravenie," from systables"</p>
<p> &nbsp; whenever error continue</p>
<p> &nbsp; prepare kalkulqtor_operator from stroka_kalkulatora</p>
<p> &nbsp; if status&lt;0 then display beep to kalkulator display "Неправильное выражение" to kalkulator next field wyravenie end if declare kalkulator cursor for kalkulqtor_operator foreach kalkulator into kolichestwo, kalkulator if status&lt;0 then display beep to kalkulator display "Неправильное выражение" to kalkulator next field wyravenie end if end foreach whenever error stop display kalkulator to kalkulator next field wyravenie end input close window kalkulator return kalkulator end function </p>
<p>Использованная в подпрограмме экранная форма должна быть описана в файле kalkulator.per и откомпилирована при помощи компилятора form4gl. </p>
<p>DATABASE formonly</p>
<p>SCREEN</p>
<p>{</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Калькулятор.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Чтобы закончить нажмите ESC</p>
<p>[wyravenie&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]</p>
<p>[kalkulator&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]</p>
<p>}</p>
<p>ATTRIBUTES</p>
<p>wyravenie =formonly.wyravenie;</p>
<p>kalkulator=formonly.kalkulator;</p>
<p>END</p>
<p>Пример программы, выдающей отчет </p>
<p>DATABASE zawod</p>
<p>MAIN</p>
<p>DEFINE zapisx record like kadry.*</p>
<p>DEFINE&nbsp; simw char (200), zapr char (300),fn&nbsp; char (18)</p>
<p>OPEN form maxprim from "maxprim"</p>
<p>DISPLAY form maxprim&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # вывести экранную форму</p>
<p>CONSTRUCT BY NAME simw ON kadry.* # Введение критериев выбора</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # с экрана</p>
<p>LET zapr="select * from kadry&nbsp; where ",</p>
<p>simw clipped," order by tabnom "</p>
<p>MESSAGE simw</p>
<p>PREPARE selpr FROM zapr&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # Изготовление запроса</p>
<p>DECLARE qquer CURSOR FOR selpr&nbsp;&nbsp;&nbsp; # Объявление курсора для него</p>
<p>DISPLAY "Не забудьте нажать CTRL-O" AT 2,40</p>
<p>PROMPT "Файл, куда выводить отчет? или CR, если на экран: "</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FOR fn</p>
<p>IF length(fn)=0 then START REPORT kadryrep&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # на экран</p>
<p>else&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; START REPORT kadryrep TO fn # в файл</p>
<p>END IF</p>
<p> &nbsp; # выполнить запрос и сбросить выбранные строки в отчет</p>
<p> &nbsp; FOREACH qquer&nbsp; into zapisx.*&nbsp;&nbsp; # Очередную строку из курсора</p>
<p> &nbsp; OUTPUT TO REPORT kadryrep(zapisx.*)&nbsp; # поместить в отчет</p>
<p> &nbsp; END FOREACH</p>
<p>FINISH REPORT kadryrep&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # Вывести результаты отчета</p>
<p>END MAIN</p>
<p>REPORT kadryrep(z)</p>
<p>DEFINE nameceh like ceh.nameceh</p>
<p>DEFINE z record like kadry.*</p>
<p> &nbsp; # nomerceh&nbsp; int,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # номер цеха</p>
<p> &nbsp; # tabnom&nbsp;&nbsp;&nbsp; serial,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # табельн. номер</p>
<p> &nbsp; # fio&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; char(20),&nbsp;&nbsp;&nbsp;&nbsp; # фамилия</p>
<p> &nbsp; # dolvn&nbsp;&nbsp;&nbsp;&nbsp; char(20),&nbsp;&nbsp;&nbsp;&nbsp; # должность</p>
<p> &nbsp; # zarplata&nbsp; money(16,2),&nbsp; # зарплата</p>
<p> &nbsp; # datarovd&nbsp; date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # дата рожд.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; OUTPUT</p>
<p>left&nbsp; margin 0</p>
<p>right margin 80</p>
<p>top&nbsp;&nbsp; margin 0</p>
<p>bottom margin 0</p>
<p>page&nbsp; length 23</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ORDER BY z.nomerceh, z.tabnom&nbsp;&nbsp; # Упорядочить</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FORMAT</p>
<p>PAGE HEADER</p>
<p>print "-------------------------------------------------------"</p>
<p>print "цех|таб.ном|фио &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |должность &nbsp; |зарплата| дата рожд"</p>
<p>print "_______________________________________________________"</p>
<p>ON EVERY ROW</p>
<p> print&nbsp; z.nomerceh using "##", column 4,z.tabnom using "#####",</p>
<p> column 13,z.fio clipped,</p>
<p> column 28,z.dolvn clipped,</p>
<p> column 43,z.zarplata using "$####.##",</p>
<p> column 53,z.datarovd using "dd-mm-yyyy"</p>
<p>BEFORE GROUP OF z.nomerceh</p>
<p>select @nameceh into nameceh from ceh where nomerceh=z.nomerceh</p>
<p> skip to top of page</p>
<p> skip 1 line</p>
<p> print "Цех &nbsp; ",nameceh</p>
<p> skip 1 line</p>
<p>AFTER GROUP OF&nbsp; z.nomerceh</p>
<p> need 2 lines</p>
<p> print " В цехе ",nameceh clipped,2 spaces,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; group count(*) using "#####" ," человек, "</p>
<p> print " Средняя зарплата ",</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; group avg(z.zarplata) using "##### руб.## коп"</p>
<p>PAGE TRAILER</p>
<p> print "заполнена страница номер", pageno</p>
<p> pause "нажмите ВВОД"</p>
<p>END REPORT</p>

<p>Вот что увидит на пользователь во время работы программы: </p>
<p>+-------------------------------------------------------------+</p>
<p>|Укажите файл, куда выводить отчет, или CR, если на экран:&nbsp;&nbsp;&nbsp; |</p>
<p>|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Не забудьте нажать CONTROL-О|</p>
<p>|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p>|----------------------------------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p>|&nbsp;&nbsp;&nbsp;&nbsp; цех &nbsp; [1:4] [&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p>| таб.номер [&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p>| фамилия &nbsp; [*ов &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p>| должность [&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p>| зарплата  [&gt;500&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p>|дата рождения [&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p>|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p>|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p>nomerceh between 1 and 4 and fio matches "*о*" and zarplata&gt;500</p>
<p>|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p>+-------------------------------------------------------------+</p>
<p>---------------------------------------------------------------------------</p>
<p>цех|таб.ном|фио &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |должность &nbsp;&nbsp;&nbsp; |зарплата| дата рожд</p>
<p>_______________________________________________________________</p>
<p>Цех &nbsp; дирекция</p>
<p> 1&nbsp;&nbsp;&nbsp; 34&nbsp;&nbsp;&nbsp; иванов &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; директор &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $ 4000.00</p>
<p> 1&nbsp;&nbsp;&nbsp; 35&nbsp;&nbsp;&nbsp; кононов &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; зав. по снабжению$ 4000.00</p>
<p> В цехе дирекция &nbsp;&nbsp;&nbsp;&nbsp; 2 человек,</p>
<p> Средняя зарплата &nbsp; 4000 руб.00 коп</p>
<p>заполнена страница номер &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p>
<p>нажмите ВВОД</p>
<p>---------------------------------------------------------------------------</p>
<p>цех|таб.ном|фио &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |должность &nbsp;&nbsp;&nbsp; |зарплата| дата рожд</p>
<p>_______________________________________________________________</p>
<p>Цех &nbsp; литейный</p>
<p> 2&nbsp;&nbsp;&nbsp; 12&nbsp;&nbsp;&nbsp; окунев &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; рабочий &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $ 2000.00</p>
<p> 2&nbsp;&nbsp;&nbsp; 14&nbsp;&nbsp;&nbsp; липко &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; лаборант &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $ 2000.00</p>
<p> 2&nbsp;&nbsp;&nbsp; 18&nbsp;&nbsp;&nbsp; пухов &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; мастер &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $ 2000.00</p>
<p> 2&nbsp;&nbsp;&nbsp; 21&nbsp;&nbsp;&nbsp; сухов &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; рабочий &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $ 2000.00</p>
<p> 2&nbsp;&nbsp;&nbsp; 24&nbsp;&nbsp;&nbsp; угольков &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; рабочий &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $ 2000.00</p>
<p> В цехе литейный &nbsp;&nbsp;&nbsp;&nbsp; 5 человек,</p>
<p> Средняя зарплата &nbsp; 2000 руб.00 коп</p>
<p>заполнена страница номер &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2</p>
<p>нажмите ВВОД</p>
<p>---------------------------------------------------------------------------</p>
<p>цех|таб.ном|фио &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |должность &nbsp;&nbsp;&nbsp; |зарплата| дата рожд</p>
<p>_______________________________________________________________</p>
<p>Цех &nbsp; гараж</p>
<p> 4&nbsp;&nbsp;&nbsp;&nbsp; 9&nbsp;&nbsp;&nbsp; потруев &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; слесарь &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $ 1230.00</p>
<p> 4&nbsp;&nbsp;&nbsp; 12&nbsp;&nbsp;&nbsp; гундосов &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; шофер &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $ 2000.00</p>
<p> В цехе гараж &nbsp;&nbsp;&nbsp;&nbsp; 2 человек,</p>
<p> Средняя зарплата &nbsp; 1615 руб.00 коп</p>
<p>заполнена страница номер &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3</p>
<p>нажмите ВВОД</p>
<p>Описание экранной формы </p>
<p>Описание состоит из 5 разделов: DATABASE, SCREEN, TABLES, ATTRIBUTES, INSTRUCTIONS </p>
<p>#&nbsp; база данных, с которой ведется работа</p>
<p>DATABASE zawod</p>
<p>#&nbsp; Картинка, которая выводится на экран.</p>
<p>#&nbsp; экранные поля обозначены так:&nbsp;&nbsp;&nbsp; [метка поля  ]</p>
<p>#&nbsp; метка поля используется в разделе ATTRIBUТЕ</p>
<p>SCREEN</p>
<p>{</p>
<p> номер цеха [nceh&nbsp; ]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; зарплата &nbsp; [f002&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]</p>
<p> фамилия &nbsp;&nbsp; [fio&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]</p>
<p> должность  [dol&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Так в экранной форме рисуется рамка.</p>
<p>  Значок \g используется для входа и выхода в графический режим</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \gp-----------------------------q\g</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \g|\g Экранный массив &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \g|\g</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \g|\g [s1&nbsp;&nbsp;&nbsp;&nbsp; ]&nbsp; [s2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ] \g|\g</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \g|\g [s1&nbsp;&nbsp;&nbsp;&nbsp; ]&nbsp; [s2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ] \g|\g</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \g|\g [s1&nbsp;&nbsp;&nbsp;&nbsp; ]&nbsp; [s2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ] \g|\g</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \g|\gномер цеха  название цеха &nbsp;&nbsp; \g|\g</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \gb-----------------------------d\g</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; в графическом режиме символы р q b d - |&nbsp; заменяются</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; символами рисования рамки &nbsp;&nbsp; &#1107;' &#1107;' &#1107;" &#1107;" &#1107;&#8250; &#1107;&#1113;</p>
<p>}</p>
<p>TABLES&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #&nbsp; имена таблиц, с которыми ассоциированна форма</p>
<p>  kadry</p>
<p>  ceh</p>
<p>ATTRIBUTES&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # Имена экранных полей в форме и их атрибуты.</p>
<p># слева от знака (=) пишется метка поля (которая  фигурирует  в</p>
<p># разделе SCREEN), справа - имя экранного поля, которое обычно,</p>
<p># для удобства, должно совпадать с именем какого-нибудь столбца</p>
<p># из таблиц, перечисленных в разделе TABLES</p>
<p>nceh&nbsp;&nbsp;&nbsp;&nbsp; = kadry.nomerceh;</p>
<p>f002&nbsp;&nbsp;&nbsp;&nbsp; = zarplata, COLOR=REVERSE WHERE f002 &gt;500;</p>
<p>#&nbsp; если в поле выведено значение больше 500, то оно будет</p>
<p>#&nbsp; выделено с атрибутом  REVERSЕ (негатив)</p>
<p>fio&nbsp; = fio;</p>
<p>dol&nbsp; = dolvn, comments="Проверьте наличие в штатном расписании";</p>
<p>s1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; = ceh.nomerceh;</p>
<p>s2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; = ceh.nameceh;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #&nbsp; здесь экранные поля можно</p>
<p>INSTRUCTIONS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #&nbsp; объединить в экранные записи</p>
<p> &nbsp;&nbsp; screen record&nbsp;&nbsp; kad (kadry.nomerceh, dolvn, zarplata)</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #&nbsp; и описать экранные массивы</p>
<p> &nbsp;&nbsp; screen record&nbsp;&nbsp; scr[3] (ceh.nomerceh, nameceh)</p>
<p>END</p>
<p>&nbsp;<br>
<p>а вот что увидит на экране пользователь, использующий эту форму: </p>
<p>&#1107;'&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;'</p>
<p>&#1107;&#1113; &nbsp; номер цеха [&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; зарплата &nbsp; [f002&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;</p>
<p>&#1107;&#1113; &nbsp; фамилия &nbsp;&nbsp; [&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;</p>
<p>&#1107;&#1113; &nbsp; должность  [&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;</p>
<p>&#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Так в экранной форме рисуется рамка.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;</p>
<p>&#1107;&#1113; &nbsp;&nbsp; Значок  используется для входа и выхода в графический режим &nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;</p>
<p>&#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;'&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p>&#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113; &nbsp; Экранный массив &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;</p>
<p>&#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113; &nbsp; [&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]&nbsp; [&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ] &#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;</p>
<p>&#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113; &nbsp; [&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]&nbsp; [&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ] &#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;</p>
<p>&#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113; &nbsp; [&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]&nbsp; [&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ] &#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;</p>
<p>&#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113; &nbsp; номер цеха  название цеха &nbsp; &#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;</p>
<p>&#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;"&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p>&#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; в графическом режиме символы р q b d - |&nbsp; заменяются &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;</p>
<p>&#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; символами рисования рамки &nbsp;&nbsp; &#1107;' &#1107;' &#1107;" &#1107;" &#1107;&#8250; &#1107;&#1113; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#1107;&#1113;</p>
<p>&#1107;"&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;&#8250;&#1107;</p>
<p>&nbsp;<br>
В этой экранной форме определены экранные поля: kadry.nomerceh, zarpllatа, fiо, dolvп, ceh.nomerceh, nameceh <br>
<p>А так же экранные записи: kadrу (по умолчанию), ceh (по умолчанию), kad, scr[3] </p>
