<h1>Пакеты и язык управления заданиями</h1>
<div class="date">01.01.2007</div>


<p>Пакеты и язык управления заданиями</p>
&nbsp;</p>
Язык Transact-SQL позволяет сгруппировать последовательность операторов в один пакет, который может выполняться либо интерактивно, либо как файл операционной системы. Пользователь может также использовать конструкции языка управления заданиями, имеющиеся в Transact-SQL, для построения программ из отдельных операторов.</p>
В этой главе рассматриваются следующие темы:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>дается общий обзор пакетов и языка управления заданиями;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>приводятся правила для построения пакетов;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>показывается, как использовать язык управления заданиями.</td></tr></table></div>&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Что такое пакеты и язык управления заданиями ?</td></tr></table></div>&nbsp;</p>
До сих пор в данном руководстве рассматривались примеры, в которых выполнялся лишь один оператор. Пользователь задавал отдельные операторы, которые непосредственно выполнялись SQL Сервером с последующей выдачей результатов (интерактивный режим). Но SQL Сервер может выполнить по очереди сразу несколько операторов, объединенных в пакет (программу), как в интерактивном режиме, так и в пакетном режиме, когда задание хранится в виде файла.</p>
Пакет (набор) SQL операторов заканчивается специальной командой, которая сообщает SQL Серверу о необходимости выполнения всех операторов в пакете. Такой командой в специальной утилите SQL Сервера isql является команда “go” (выполнить), которая указывается в отдельной строке. Более детально утилиты рассматриваются в справочном руководстве по утилитам SQL Сервера.</p>
Вообще говоря, пакет может состоять из одного оператора, но обычно в пакет объединяются несколько операторов. Очень часто пакет хранится как файл операционной системы и затем вызывается на исполнение утилитой isql.</p>
В языке Transact-SQL предусмотрены специальные ключевые слова, которые собственно и образуют язык управления заданиями и которые позволяют пользователю влиять на последовательность выполнения операторов. Команды языка управления можно использовать как в отдельных операторах, так и в пакетах, а также в сохраненных процедурах и триггерах.</p>
Без команд управления отдельные SQL операторы выполняется последовательно в порядке их поступления. Исключение здесь составляют коррелированные запросы, которые обсуждались в главе 5 “Подзапросы: использование запросов внутри других запросов”. Команды управления позволяют изменять последовательность выполнения операторов в зависимости от получаемых результатов с помощью конструкций, используемых в языках программирования.</p>
Такие конструкции, как if…else, предназначенная для ветвления по условию, и while, предназначенная для циклического выполнения, позволяют управлять последовательностью выполнения SQL операторов. Язык управления заданиями, включенный в Transact-SQL, по существу, превращает стандартный&nbsp; SQL в язык программирования очень высокого уровня.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Правила составления пакетов</td></tr></table></div>&nbsp;</p>
В пакет можно включать только определенные SQL операторы. При составлении пакетов следует придерживаться следующих правил:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="19">&#183;</td><td>Следующие команды нельзя включать в пакет вместе с другими операторами: creat procedure (создать процедуру), creat rule (создать правило), creat default (создать значение по умолчанию), creat trigger (создать триггер), creat view (создать вьювер);</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="19">&#183;</td><td>Следующие команды можно включать в пакет: creat database (можно создать базу данных, но из того же пакета нельзя обращаться к ее объектам), creat table (создать таблицу), creat index (создать индекс);</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="19">&#183;</td><td>Правила и умолчания можно связывать со столбцами, но нельзя сразу использовать в одном и том же пакете. Например, вызов процедур sp_bindrule (присоединить правило) и sp_bindefault (присоединить значение по умолчанию) нельзя располагать в одном пакете с оператором insert, который использует эти правила и умолчания;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="19">&#183;</td><td>Команда use (использовать базу данных) должна содержаться в пакете, который выполняется перед пакетом, в котором располагаются операторы, обращающиеся к&nbsp; объектам этой базы;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="19">&#183;</td><td>Нельзя выполнить команду drop (удалить), а затем вновь создать тот же объект в этом же пакете;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="19">&#183;</td><td>Все опции, установленные в пакете с помощью команды set (установить), начинают действовать только после окончания выполнения этого пакета. Можно включить команду set и запросы к таблицам в один пакет, но опции, установленные этой командой, не будут действовать во время выполнения этих запросов.</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Примеры использования пакетов</td></tr></table></div>&nbsp;</p>
В этом разделе приводятся примеры, иллюстрирующие использование пакетов с утилитой isql, которая имеет специальную команду “go” для запуска пакета на исполнение. В следующий пакет включены два оператора выбора:</p>
&nbsp;</p>
select count(*) from titles</p>
select count(*) from authors</p>
go</p>
&nbsp;</p>
 ---------------------</p>
 &nbsp; &nbsp; &nbsp; &nbsp;18</p>
 ----------------------</p>
 &nbsp; &nbsp; &nbsp; &nbsp;23</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
Можно в одном пакете создать таблицу и сразу обратиться к ней. В следующем примере пакета создается таблица, затем в нее вставляется строка, после чего эта строка выбирается из таблицы:</p>
&nbsp;</p>
create table test </p>
 &nbsp; (column1 char(10), column2 int) </p>
insert test </p>
  values ("hello", 598) </p>
select * from test </p>
go </p>
&nbsp;</p>
(Выбрана 1 строка)</p>
column1&nbsp; column2 </p>
--------&nbsp;&nbsp; ---------</p>
&nbsp;</p>
hello&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 598</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
Команда creat view (создать вьювер) должна быть единственной командой в пакете. В следующем пакете, состоящем из одного оператора, создается вьювер:</p>
&nbsp;</p>
creat view testview as</p>
 &nbsp; &nbsp; &nbsp; &nbsp;select column1 from test</p>
go</p>
&nbsp;</p>
Команду use можно включать в пакет вместе с другими операторами, если эти операторы обращаются к базе данных, которая была текущей перед вызовом пакета. В следующем примере происходит выборка из таблицы базы данных master, а затем открывается база данных pubs2. Здесь предполагается, что база данных master была текущей перед вызовом пакета. После выполнения этого пакета текущей становится база данных pubs2.</p>
&nbsp;</p>
select count(*) from sysdatabase</p>
use pubs2</p>
go</p>
&nbsp;</p>
------------------</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; 9</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
Команду drop (удалить объект) можно включать в пакет вместе с другими операторами, если в том же пакете уже не нужно будет обращаться к удаляемому объекту или вновь создавать его. В следующем примере показан пакет, состоящий из оператора drop и оператора select:</p>
&nbsp;</p>
drop table test</p>
select count(*) from titles</p>
go</p>
&nbsp;</p>
----------------------</p>
 &nbsp;&nbsp; 18</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
Если в пакете где-нибудь имеется синтаксическая ошибка, то в нем не будет выполнен ни один оператор. Например, в следующем пакете имеется опечатка в последнем операторе, поэтому в результате появляется сообщение об ошибке:</p>
&nbsp;</p>
select count(*) from titles </p>
select count(*) from authors </p>
slect count(*) from publishers </p>
go </p>
&nbsp;</p>
Msg 156, Level 15, State 1:</p>
SQL Server 'MAGOO', LIne 3:</p>
Incorrect syntax near the keyword 'count'.&nbsp; (Неправильная команда около слова &#8216;count&#8217;).</p>
&nbsp;</p>
Пакеты, в которых нарушены правила их составления, также вызывают сообщение об ошибке. Далее приводятся примеры неправильных пакетов:</p>
&nbsp;</p>
create table test </p>
 &nbsp;&nbsp; (column1 char(10), column2 int) </p>
insert test </p>
 &nbsp;&nbsp; values ("hello", 598) </p>
select * from test </p>
create view testview as select column1 from test </p>
go </p>
&nbsp;</p>
Msg 111, Level 15, State 3: </p>
Server 'hq', Line 6: </p>
CREATE VIEW must be the first command in a query batch.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Команда создания вьювера должна быть первой в пакете.)</p>
&nbsp;</p>
&nbsp;</p>
create view testview as select column1 from test </p>
insert testview values ("goodbye") </p>
go </p>
&nbsp;</p>
Msg 127, Level 15, State 1: </p>
Server 'hq', Procedure 'testview', Line 3: </p>
This CREATE may only contain 1 statement. (Команда создания вьювера должна быть&nbsp; единственной в пакете.) </p>
&nbsp;</p>
Следующий пакет будет работать только в том случае, если текущей базой данных будет база данных, указанная в операторе use. Если же он будет запущен из другой базы данных, например master, то будет выдано сообщение об ошибке.</p>
&nbsp;</p>
use pubs2 </p>
select * from titles </p>
go</p>
&nbsp;</p>
Msg 208, Level 16, State 1: </p>
Server 'hq', Line 2: </p>
Invalid object name 'titles'.&nbsp;&nbsp;&nbsp;&nbsp; (Неправильный объект 'titles'.)</p>
&nbsp;</p>
drop table test </p>
create table test </p>
(column1 char(10), column2 int) </p>
go </p>
&nbsp;</p>
Msg 2714, Level 16, State 1: </p>
Server 'hq', Line 2: </p>
There is already an object named 'test' in the database.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
 (В базе данных уже имеется объект с&nbsp; названием 'test'.)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Пакетные файлы</td></tr></table></div>&nbsp;</p>
Пакет можно сохранить в виде файла операционной системы, а затем вызвать его на исполнение утилитой isql. Файл может содержать несколько пакетов, каждый из которых заканчивается ключевым словом “go”.</p>
Например, следующий файл содержит три пакета:</p>
&nbsp;</p>
use pubs2 </p>
go </p>
select count(*) from titles </p>
select count(*) from authors </p>
go </p>
create table test </p>
 &nbsp; (column1 char(10), column2 int) </p>
insert test </p>
 &nbsp; values ("hello", 598) </p>
select * from test </p>
go</p>
&nbsp;</p>
При выполнении этого файла утилитой isql получаются следующие результаты:</p>
&nbsp;</p>
------------- </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 18 </p>
&nbsp;</p>
(Выбрана 1 строка)</p>
------------- </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 23 </p>
&nbsp;</p>
(Выбрана 1 строка)</p>
(Выбрана 1 строка)</p>
column1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; column2 </p>
---------&nbsp;&nbsp;&nbsp; --------- </p>
&nbsp;</p>
hello&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 598</p>
&nbsp;</p>
(выбрана 1 строка)</p>
В справочном руководстве по утилитам SQL Сервера в разделе об утилите isql приводится информация о зависимости выполнения пакетных файлов от операционного окружения (среды).</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Язык управления заданиями</td></tr></table></div>&nbsp;</p>
Команды языка управления заданиями можно использовать как в интерактивном режиме, так и в пакетном, а также в сохраненных процедурах. Ключевые слова языка управления заданиями и их значение приведены в следующей таблице:</p>
&nbsp;</p>
Таблица 13-1: Ключевые слова языка управления заданиями</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >Ключевое слово</p>
</td>
<td >Функциональное назначение</p>
</td>
</tr>
<tr >
<td >if</p>
</td>
<td >Определяет условное выполнение. </p>
</td>
</tr>
<tr >
<td >…else</p>
</td>
<td >Определяет альтернативную ветвь выполнения, если условие, указанное в if ложно.</p>
</td>
</tr>
<tr >
<td >Begin</p>
</td>
<td >Начало блока операторов.</p>
</td>
</tr>
<tr >
<td >…end</p>
</td>
<td >Конец блока операторов.</p>
</td>
</tr>
<tr >
<td >While</p>
</td>
<td >Циклическое выполнение операторов, пока условие, указанное в while истинно.</p>
</td>
</tr>
<tr >
<td >Break</p>
</td>
<td >Принудительный выход из цикла.</p>
</td>
</tr>
<tr >
<td >…continue</p>
</td>
<td >Повторить выполнение цикла while.</p>
</td>
</tr>
<tr >
<td >Declare</p>
</td>
<td >Объявление локальной переменной.</p>
</td>
</tr>
<tr >
<td >goto label</p>
</td>
<td >Переход на метку (label), которая расположена в блоке операторов.</p>
</td>
</tr>
<tr >
<td >Return</p>
</td>
<td >Безусловный выход.</p>
</td>
</tr>
<tr >
<td >Waitfor</p>
</td>
<td >Установить задержку на выполнение команды.</p>
</td>
</tr>
<tr >
<td >Print</p>
</td>
<td >Вывести на экран сообщение, которое указано пользователем или хранится в локальной переменной. </p>
</td>
</tr>
<tr >
<td >Raiserror</p>
</td>
<td >Вывести на экран сообщение об ошибке, указанное пользователем или хранящееся в локальной переменной, и установить глобальную переменную @@error (ошибка).</p>
</td>
</tr>
<tr >
<td >/* comment */</p>
</td>
<td >Внести комментарий (комментарий можно указать в любом месте SQL оператора).
</td>
</tr>
</table>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Условный оператор if…else</td></tr></table></div>&nbsp;</p>
Ключевое слово if (если), независимо от своего дополнения else (иначе), служит для указания условия, которое определяет нужно ли выполнять следующий оператор. Следующий оператор выполняется, если это условие истинно, т.е. если его значение равно TRUE (истина).</p>
Ключевое слово else служит для указания альтернативного SQL оператора, который выполняется, если условие, указанное в конструкции if оказалось ложным (FALSE).</p>
Условный оператор имеет следующий синтаксис:</p>
&nbsp;</p>
if булевское_выражение</p>
 &nbsp; &nbsp; &nbsp; &nbsp;оператор</p>
[else [if булевское_выражение]</p>
 &nbsp; &nbsp; &nbsp; &nbsp;оператор ]</p>
&nbsp;</p>
Булевское выражение это выражение, значением которого является истина (TRUE) или ложь (FALSE). Оно может состоять из названий табличных столбцов и констант, соединенных арифметическими или булевскими операциями, или подзапросов, если эти подзапросы возвращают одно (скалярное) значение. Если булевское выражение содержит оператор выбора select, то этот оператор должен быть заключен в скобки и должен возвращать скалярное (невекторное) значение.</p>
Далее приводится пример условного оператора, который содержит только условие if и одну команду:</p>
&nbsp;</p>
if exists (select postalcode from authors </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; where postalcode = '94705') </p>
print "Berkeley author"</p>
&nbsp;</p>
В этом примере будет выводиться сообщение “Berkeley author”, если почтовые индексы некоторых авторов из таблицы authors равны “94705”. Оператор выбора в этом примере возвращает скалярное значение, которое равно либо TRUE либо FALSE, поскольку перед ним указано ключевое слово exists (существует). Ключевое слово exists действует здесь точно также, как и в подзапросах (см. главу 5 “Подзапросы: использование запросов внутри других запросов”).</p>
В следующем примере используются оба ключевых слова if и else. Здесь проверяется наличие объектов, созданных пользователями, которым присваиваются идентификационные номера, большие 50. Если такие объекты существует, то они выбираются из таблицы в конструкции else и для каждого из них указывается название, тип и номер.</p>
&nbsp;</p>
if (select max(id) from sysobjects) &lt; 50 </p>
 &nbsp; print "There are no user-created objects in this database." </p>
else </p>
 &nbsp; select name, type, id from sysobjects </p>
 &nbsp; where id &gt; 50 and type = "U" </p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
 name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; type&nbsp;&nbsp;&nbsp; id </p>
------------&nbsp;&nbsp;&nbsp; -------------- </p>
 authors &nbsp; &nbsp; &nbsp; &nbsp;U 1088006907&nbsp; </p>
 publishers &nbsp; &nbsp; &nbsp; &nbsp;U 1120007021&nbsp; </p>
 roysched &nbsp; &nbsp; &nbsp; &nbsp;U 1152007135&nbsp; </p>
 sales &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;U 1184007249&nbsp; </p>
 titleauthor&nbsp;&nbsp;&nbsp; U 1216007363&nbsp; </p>
 titles &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;U 1248007477&nbsp; </p>
 stores&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; U 1280007591&nbsp; </p>
 discounts &nbsp; &nbsp; &nbsp; &nbsp;U 1312007705&nbsp; </p>
 test &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;U 1648008902</p>
&nbsp;</p>
(Выбрано 9 строк)</p>
&nbsp;</p>
Условный оператор часто используется в сохраненных процедурах для проверки наличия некоторого параметра.</p>
Условие проверки может указываться внутри другого условия либо в части if либо в части else. Условие проверки должно иметь скалярное значение. В каждой части условного оператора может быть только по одному SQL оператору. Чтобы указать несколько SQL операторов, необходимо использовать операторные скобки begin…end. Максимальное число вложенных друг в друга условий проверки if зависит от сложности операторов выбора (или других языковых конструкций), которые используются в условном операторе.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Операторные скобки begin…end</td></tr></table></div>&nbsp;</p>
Ключевые слова begin и end используются как операторные скобки для выделения единого блока операторов, который может использоваться, например, в условном операторе. Последовательность операторов, заключенная в скобки begin и end, называется операторным блоком.</p>
Конструкция begin…end имеет следующий вид:</p>
&nbsp;</p>
begin</p>
 &nbsp;&nbsp;&nbsp; блок операторов</p>
end</p>
&nbsp;</p>
Рассмотрим следующий пример:</p>
&nbsp;</p>
if (select avg(price) from titles) &lt; $15 </p>
begin </p>
 &nbsp; update titles </p>
 &nbsp; set price = price * 2 </p>
 &nbsp; select title, price </p>
 &nbsp; from titles </p>
 &nbsp; where price &gt; $28 </p>
end</p>
&nbsp;</p>
В этом примере без ключевых слов begin и end условие if относилось бы только к первому SQL оператору этого блока. Второй и последующие операторы выполнялись бы независимо от выполнения этого условия.</p>
Операторный блок begin…end можно включать внутрь другого операторного блока begin…end.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Циклический оператор while и команды break…continue</td></tr></table></div>&nbsp;</p>
Команда while (до тех пор, пока) используется для циклического (повторного) выполнения оператора или блока операторов. Операторы выполнятся до тех пор, пока истинно указанное условие.</p>
Эта команда имеет следующий вид:</p>
&nbsp;</p>
while булевское_выражение</p>
 &nbsp; &nbsp; &nbsp; &nbsp;оператор</p>
&nbsp;</p>
В следующем примере операторы select и update будут выполняться в цикле, пока средняя цена книги будет меньше $30:</p>
&nbsp;</p>
while (select avg(price) from titles) &lt; $30 </p>
begin </p>
 &nbsp; select title_id, price </p>
 &nbsp; from titles </p>
 &nbsp; where price &gt; $20 </p>
 &nbsp; update titles </p>
 &nbsp; set price = price * 2 </p>
end </p>
&nbsp;</p>
(Выбрано 0 строк)</p>
title_id&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; price </p>
------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------- </p>
PC1035 &nbsp; &nbsp; &nbsp; &nbsp;22.95 </p>
PS1372 &nbsp; &nbsp; &nbsp; &nbsp;21.59 </p>
TC3218 &nbsp; &nbsp; &nbsp; &nbsp;20.95 </p>
&nbsp;</p>
(Выбрано 3 строки)</p>
(Выбрано 10 строк)</p>
(Выбрано 0 строк)</p>
title_id&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; price </p>
------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------- </p>
BU1032 &nbsp; &nbsp; &nbsp; &nbsp;39.98 </p>
BU1111 &nbsp; &nbsp; &nbsp; &nbsp;23.90 </p>
BU7832 &nbsp; &nbsp; &nbsp; &nbsp;39.98 </p>
MC2222 &nbsp; &nbsp; &nbsp; &nbsp;39.98 </p>
PC1035 &nbsp; &nbsp; &nbsp; &nbsp;45.90 </p>
PC8888 &nbsp; &nbsp; &nbsp; &nbsp;40.00 </p>
PS1372 &nbsp; &nbsp; &nbsp; &nbsp;43.18 </p>
PS2091 &nbsp; &nbsp; &nbsp; &nbsp;21.90 </p>
PS3333 &nbsp; &nbsp; &nbsp; &nbsp;39.98 </p>
TC3218 &nbsp; &nbsp; &nbsp; &nbsp;41.90 </p>
TC4203 &nbsp; &nbsp; &nbsp; &nbsp;23.90 </p>
TC7777 &nbsp; &nbsp; &nbsp; &nbsp;29.98</p>
&nbsp;</p>
(Выбрано 12 строк)</p>
(Выбрано 18 строк)</p>
(Выбрано 0 строк)</p>
&nbsp;</p>
Команды break (прервать) и continue (продолжить) управляют последовательностью выполнения операторов внутри цикла while. Команда break прекращает выполнение цикла. После этого управление передается оператору, следующему за ключевым словом&nbsp; end, которое указывает на конец цикла. Команда continue передает управление на начало цикла, поэтому все операторы, расположенные внутри цикла и следующие за этой командой, выполняться не будут. Командам break и continue часто предшествует проверка некоторого условия.</p>
Синтаксис команд break и continue имеет следующий вид:</p>
&nbsp;</p>
while булевское_выражение</p>
 &nbsp; begin</p>
 &nbsp; &nbsp; &nbsp; &nbsp;оператор</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; ….</p>
 &nbsp; &nbsp; &nbsp; &nbsp;[оператор]</p>
 &nbsp; &nbsp; &nbsp; &nbsp;break</p>
 &nbsp; &nbsp; &nbsp; &nbsp;[оператор]</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; ….</p>
 &nbsp; &nbsp; &nbsp; &nbsp;continue</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; ….</p>
 &nbsp; &nbsp; &nbsp; &nbsp;[оператор]</p>
 &nbsp; end</p>
&nbsp;</p>
Далее приводится пример использования команд while, break, continue и if, в котором производится действие, обратное инфляционному действию предыдущего примера. До тех пор пока средняя цена книги остается большей $20, все цены уменьшаются наполовину. Затем выбирается максимальная цена. Если она меньше 40 долларов, то происходит выход из цикла, в противном случае цикл выполняется снова. Команда continue не допустит выполнение оператора вывода (печати) print, если средняя цена меньше $20. После окончания цикла while в этом примере выводится список самых дорогих книг и информационное сообщение "Not Too Expensive" (Не очень дорого).</p>
&nbsp;</p>
while (select avg(price) from titles) &gt; $20 </p>
begin </p>
 &nbsp;&nbsp; update titles </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; set price = price / 2 </p>
 &nbsp;&nbsp; if (select max(price) from titles) &lt; $40 </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; break </p>
 &nbsp;&nbsp; else</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; if (select avg(price) from titles) &lt; $20</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; continue </p>
 &nbsp;&nbsp; print "Average price still over $20"</p>
end</p>
select title_id, price from titles</p>
 &nbsp;&nbsp; where price &gt; $20 </p>
&nbsp;</p>
print "Not Too Expensive"</p>
&nbsp;</p>
Average price still over $20</p>
&nbsp;</p>
title_id&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; price&nbsp; </p>
--------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------</p>
PC1035&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 22.95&nbsp; </p>
PS1372&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 21.59&nbsp; </p>
TC3218&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 20.95&nbsp; </p>
&nbsp;</p>
(Выбрано 3 строки)</p>
Not Too Expensive</p>
&nbsp;</p>
Если циклы while вложены друг в друга, то команда break возвращает управление в наименьший внешний цикл, который содержит данный цикл. После этого возобновляется выполнение этого внешнего цикла с самого начала.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Оператор declare и локальные переменные</td></tr></table></div>&nbsp;</p>
Переменная - это объект, которому присваивается некоторое значение. Это значение может изменяться в процессе исполнения пакета или сохраненной процедуры, в которых используется эта переменная. У SQL Сервера имеется два вида переменных: локальные и глобальные. Локальные переменные определяются пользователем, в то время как глобальные переменные являются системными и определяются заранее.</p>
Для задания локальных переменных используется ключевое слово declare (объявить), после которого следует указать название переменной, ее тип. После этого переменной можно присвоить начальное значение с помощью оператора выбора. Локальные переменные можно использовать только в том пакете или процедуре, в которых они объявлены.</p>
Локальные переменные часто используются в пакетах или процедурах как счетчики циклов в операторе while, а также внутри операторного блока if…else. Когда переменные используются в сохраненной процедуре, они должны быть объявлены как автоматические для неинтерактивного использования во время выполнения сохраненной процедуры.</p>
Названия локальных переменных должны начинаться со знака “@” и отвечать правилам, установленным для идентификаторов. Для каждой локальной переменной нужно указать ее тип, который может быть задан пользователем или определяться системой, но не совпадать ни с одним из системных типов text, image, sysname.</p>
Объявление локальных переменных имеет следующий вид:</p>
&nbsp;</p>
declare @название_переменной&nbsp;&nbsp; тип_данных</p>
[,@название_переменной&nbsp; тип_данных] …</p>
&nbsp;</p>
После объявления переменной она имеет значение NULL. Чтобы присвоить ей значение следует использовать оператор выбора. Этот оператор имеет следующий синтаксис:</p>
&nbsp;</p>
select @название_переменной = { выражение | (оператор_выбора) }</p>
 &nbsp;&nbsp;&nbsp; [, @название_переменной = { выражение | (оператор_выбора) } … ]</p>
[from конструкция] [where конструкция] [group by конструкция] </p>
[having конструкция] [order by конструкция] [compute конструкция]</p>
&nbsp;</p>
Локальные переменные должны объявляться в том же пакете или процедуре, в которых они используются.</p>
Оператор выбора, с помощью которого переменной присваивается значение обычно возвращает одно значение. Подзапрос, который возвращает значение для локальной переменной должен возвращать только одно значение. Далее приводятся несколько примеров присваивания значений переменным:</p>
&nbsp;</p>
declare @veryhigh money </p>
select @veryhigh = max(price) </p>
 &nbsp; from titles </p>
if @veryhigh &gt; $20 </p>
 &nbsp; print "Ouch!" </p>
&nbsp;</p>
declare @one varchar(18), @two varchar(18) </p>
select @one = "this is one", @two = "this is two" </p>
if @one = "this is one" </p>
 &nbsp; print "you got one" </p>
if @two = "this is two" </p>
 &nbsp; print "you got two" </p>
else print "nope" </p>
&nbsp;</p>
declare @tcount int, @pcount int </p>
select @tcount = (select count(*) from titles), </p>
 &nbsp; @pcount = (select count(*) from publishers) </p>
select @tcount, @pcount</p>
&nbsp;</p>
Если оператор выбора возвращает более одного значения, то переменной присваивается последнее возвращаемое значение.</p>
С точки зрения эффективного использования памяти и времени лучше использовать оператор:</p>
&nbsp;</p>
select @a=1, @b=2, @c=3</p>
&nbsp;</p>
по сравнению с оператором:</p>
&nbsp;</p>
select @a=1</p>
select @b=2</p>
select @c=3</p>
&nbsp;</p>
То же правило применимо к оператору declare. Гораздо более эффективно выполняется оператор:</p>
&nbsp;</p>
declare @a int, @b char(20), @c float</p>
&nbsp;</p>
по сравнению с последовательностью операторов:</p>
&nbsp;</p>
declare @a int</p>
declare @b char(20)</p>
declare @c float</p>
&nbsp;</p>
Оператор выбора, который присваивает значение локальной переменной, можно использовать только для этой цели. Его нельзя использовать для выборки данных из таблицы пользователя. В следующем примере первый оператор выбора присваивает значение локальноц переменной @veryhigh, но для вывода ее значения необходимо использовать второй оператор выбора:</p>
&nbsp;</p>
declare @veryhigh money </p>
select @veryhigh = max(price) </p>
 &nbsp; from titles </p>
select @veryhigh</p>
&nbsp;</p>
Если оператор выбора, который присваивает значение переменной, возвращает более одного значения, то переменной присваивается последнее возвращаемое значение. В следующем примере переменной присваивается последнее возвращаемое значение аванса из таблицы titles:</p>
&nbsp;</p>
declare @m money</p>
select @m = advance from titles</p>
select @m</p>
&nbsp;</p>
(Выбрано 18 строк)</p>
------------------------ </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 8,000.00</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
Заметим, что оператор выбора, присваивающий значение переменной, также выводит число строк, которые были при этом выбраны.</p>
Если оператор выбора, присваивающий значение переменной, не возвращает никакого значения, то значение переменной не изменяется.</p>
Локальные переменные могут использоваться как аргументы в командах print и raiserror.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Переменные и неопределенное значение</td></tr></table></div>&nbsp;</p>
После объявления локальной переменной ей присваивается неопределенное значение NULL. Кроме того, это значение можно присвоить с помощью оператора выбора. Предусмотрены специальные правила сравнения неопределенных значений переменных с другими значениями.</p>
В следующей таблице приведены результаты сравнения неопределенного значения, находящегося в столбце таблицы, с неопределенным значением выражения при выполнении различных операций сравнения. (Выражение может быть переменной, литералом или комбинацией переменных и литералов, соединенных арифметическими операциями).</p>
&nbsp;</p>
Таблица 13-2: Сравнение неопределенных значений</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >
</td>
<td ><p>Операции =, !=, &lt;&gt;</p>
</td>
<td ><p>Операции &lt;, &gt;, &lt;=, !&lt;, !&gt;</p>
</td>
</tr>
<tr >
<td ><p>Сравнение табличного_значения с табличным_значением</p>
</td>
<td ><p>FALSE</p>
</td>
<td ><p>FALSE</p>
</td>
</tr>
<tr >
<td ><p>Сравнение табличного_значения с выражением </p>
</td>
<td ><p>TRUE</p>
</td>
<td ><p>FALSE</p>
</td>
</tr>
<tr >
<td ><p>Сравнение выражения с табличным_значением </p>
</td>
<td ><p>TRUE</p>
</td>
<td ><p>FALSE</p>
</td>
</tr>
<tr >
<td ><p>Сравнение выражения с выражением</p>
</td>
<td ><p>TRUE</p>
</td>
<td ><p>FALSE
</td>
</tr>
</table>
Например, в следующем примере только первое сравнение дает положительный результат:</p>
&nbsp;</p>
declare @v int, @i int</p>
if @v = @i select "null = null, true"</p>
if @v &gt; @i select "null &gt; null, true"</p>
&nbsp;</p>
----------------- </p>
null = null, true</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
&nbsp;</p>
В следующем примере из таблицы titles выбираются все строки, в которых значение аванса (advance) является неопределенным:</p>
&nbsp;</p>
declare @m money</p>
select title_id, advance</p>
from titles</p>
where advance = @m</p>
&nbsp;</p>
title_id&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; advance&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
--------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ----------------</p>
&nbsp;</p>
MC3026&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL </p>
PC9999&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL </p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Оператор declare и глобальные переменные</td></tr></table></div>&nbsp;</p>
Глобальные переменные являются заранее определенными системными переменными. Названия глобальных переменных отличаются от локальных двумя, расположенными впереди, знаками “@”, например, @@error.</p>
В следующей таблице приводится список глобальных переменных.</p>
&nbsp;</p>
&nbsp;</p>
&nbsp;</p>
Таблица 13-3: Глобальные переменные SQL Сервера</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td ><p>Переменная</p>
</td>
<td ><p>Значение</p>
</td>
</tr>
<tr >
<td ><p>@@char_convert</p>
</td>
<td ><p>Равна 0, если не установлено преобразование алфавитов (множества символов). Равна 1, если такое преобразование установлено.</p>
</td>
</tr>
<tr >
<td ><p>@@client_csname</p>
</td>
<td ><p>Содержит название алфавита клиента. Равна NULL, если алфавит клиента никогда не инициализировался, в противном случае содержит название последнего использованного алфавита.</p>
</td>
</tr>
<tr >
<td ><p>@@client_csid</p>
</td>
<td ><p>Содержит идентификатор алфавита клиента. Устанавливается в -1, если алфавит клиента никогда не инициализировался, в противном случае содержит идентификатор последнего использованного алфавита из таблицы syscharset. </p>
</td>
</tr>
<tr >
<td ><p>@@connections</p>
</td>
<td ><p>Равна числу зарегистрированных входов в систему (logins) или попыток регистраций.</p>
</td>
</tr>
<tr >
<td ><p>@@cpu_busy</p>
</td>
<td ><p>Равна времени (в тактах процессора) загрузки процессора задачами SQL Сервера, начиная с последнего старта SQL Сервера.</p>
</td>
</tr>
<tr >
<td ><p>@@error</p>
</td>
<td ><p>Равна 0, если последняя транзакция была успешно выполнена. В противном случае, содержит последний номер ошибки, выданный системой. Эта переменная часто используется для проверки ошибок после исполнения последнего оператора. Оператор типа if @@error != 0 return используется для выхода при возникновении ошибки.</p>
</td>
</tr>
<tr >
<td ><p>@@identity</p>
</td>
<td ><p>Содержит последний номер, записанный в столбец счетчика оператором insert или select&nbsp; into. Эта переменная изменяется при вставке каждой новой строки. Если оператор вставляет несколько строк, то данной переменной присваивается номер последней строки. Если в изменяемой таблице нет счетчика, то данной переменной присваивается 0.</p>
<p>Значение этой переменной не меняется при ошибочном выполнении операторов вставки или при восстановлении транзакции, которая содержит эти операторы. Значение этой переменной не восстанавливается, даже если оператор, увеличивший ее, был ошибочным.</p>
</td>
</tr>
<tr >
<td ><p>@@idle</p>
</td>
<td ><p>Равна количеству времени (в тактах процессора), в течении которого у SQL Сервера не было работы.</p>
</td>
</tr>
<tr >
<td ><p>@@io_busy</p>
</td>
<td ><p>Равна количеству времени (в тактах процессора), в течении которого SQL Сервер выполнял операции ввода-вывода.</p>
</td>
</tr>
<tr >
<td ><p>@@isolation</p>
</td>
<td ><p>Указывает на уровень изоляции Transact-SQL программы. Этот уровень может изменяться от 1 до 3.</p>
</td>
</tr>
<tr >
<td ><p>@@langid</p>
</td>
<td ><p>Указывает на идентификатор текущего языка, который берется из таблицы идентификаторов syslanguges.langid.</p>
</td>
</tr>
<tr >
<td ><p>@@language</p>
</td>
<td ><p>Указывает на название текущего языка, который берется из таблицы syslanguges.name.</p>
</td>
</tr>
<tr >
<td ><p>@@maxcharlen</p>
</td>
<td ><p>Указывает на максимальную длину (в байтах) символа из мультибайтового алфавита.</p>
</td>
</tr>
<tr >
<td ><p>@@max_connections</p>
</td>
<td ><p>Указывает на максимальное число соединений, которые могут быть установлены с SQL Сервером в данной вычислительной среде. Пользователь может установить любое число соединений, не превосходящее значения этой переменной, с помощью процедуры sp_configure &#8216;number of user connections&#8217;.</p>
</td>
</tr>
<tr >
<td ><p>@@ncharsize</p>
</td>
<td ><p>Равно средней длине (в байтах) символа национального алфавита.</p>
</td>
</tr>
<tr >
<td ><p>@@nestlevel</p>
</td>
<td ><p>Указывает на текущей уровень вложенности исполнения, который сначала равен нулю. При каждом вызове сохраненной процедуры или триггера из другой процедуры или триггера, уровень вложенности увеличивается на единицу. Если будет превзойден порог, равный 16, транзакция прерывается.</p>
</td>
</tr>
<tr >
<td ><p>@@pack_received</p>
</td>
<td ><p>Указывает на число входных пакетов (packet), прочитанных SQL Сервером.</p>
</td>
</tr>
<tr >
<td ><p>@@pack_sent</p>
</td>
<td ><p>Указывает на число выходных пакетов (packet), записанных SQL Сервером.</p>
</td>
</tr>
<tr >
<td ><p>@@pack_errors</p>
</td>
<td ><p>Указывает на число ошибок, которые возникли во время получения или пересылки пакетов.</p>
</td>
</tr>
<tr >
<td ><p>@@procid</p>
</td>
<td ><p>Содержит идентификатор выполняемой в данный момент сохраненной процедуры.</p>
</td>
</tr>
<tr >
<td ><p>@@rowcount</p>
</td>
<td ><p>Указывает на число строк, которые обрабатывались в последнем запросе. Эта переменная устанавливается в ноль любой командой, которая не работает со строками, как например, оператор if.</p>
</td>
</tr>
<tr >
<td ><p>@@servername</p>
</td>
<td ><p>Содержит название данного SQL Сервера.</p>
</td>
</tr>
<tr >
<td ><p>@@spid</p>
</td>
<td ><p>Указывает серверный идентификатор текущего процесса.</p>
</td>
</tr>
<tr >
<td ><p>@@sqlstatus</p>
</td>
<td ><p>Содержит информацию о состоянии, выданную последним оператором fetch (вызвать).</p>
</td>
</tr>
<tr >
<td ><p>@@textcolid</p>
</td>
<td ><p>Содержит идентификатор столбца, на который ссылается текстовый указатель, хранящийся в глобальной переменной  @@textptr. Эта переменная имеет тип tinyint.</p>
</td>
</tr>
<tr >
<td ><p>@@textdbid</p>
</td>
<td ><p>Указывает идентификатор базы данных, которая содержит столбец, на который ссылается указатель, хранящийся в переменной @@textptr. Эта переменная имеет тип smallint.</p>
</td>
</tr>
<tr >
<td ><p>@@textobjid</p>
</td>
<td ><p>Указывает идентификатор объекта, который содержит столбец, на который ссылается текстовый указатель переменной @@textptr. Эта переменная имеет тип int.</p>
</td>
</tr>
<tr >
<td ><p>@@textptr</p>
</td>
<td ><p>Содержит текстовый указатель, который использовался при последнем обращении к тестовому или графическому столбцу. Эта переменная имеет тип binary(16). Не следует путать эту переменную с функцией textptr.</p>
</td>
</tr>
<tr >
<td ><p>@@textsize</p>
</td>
<td ><p>Указывает на максимальное число байтов, которые можно выбрать из текстового или графического поля оператором select. Для утилиты isql по умолчанию это значение равно 32К, но значение, принимаемое по умолчанию, зависит от программного обеспечения клиента. Значение этой переменной для данной сессии можно установить командой set textsize.</p>
</td>
</tr>
<tr >
<td ><p>@@textts</p>
</td>
<td ><p>Указывает на момент последнего обращения к текстовому столбцу, на который указывает переменная @@textptr. Эта переменная имеет тип varbinary(8).</p>
</td>
</tr>
<tr >
<td ><p>@@tresh_hysteresis</p>
</td>
<td ><p>Указывает на минимально допустимую величину свободной памяти, после которой необходимо активизировать порог (threshold). Эта величина, известная также как величина гистерезиса (hysteresis), измеряется в страницах размера 2К. Она определяет насколько близко пороги могут быть расположены в сегменте базы данных.</p>
</td>
</tr>
<tr >
<td ><p>@@timeticks</p>
</td>
<td ><p>Указывает длительность такта процессора в микросекундах. Эта величина, конечно, является машинно-зависимой.</p>
</td>
</tr>
<tr >
<td ><p>@@totalerrors</p>
</td>
<td ><p>Указывает на общее число ошибок, возникших в процессе передачи данных SQL Сервером.</p>
</td>
</tr>
<tr >
<td ><p>@@total_read</p>
</td>
<td ><p>Указывает на число чтений с диска, которые SQL Сервер выполнил со времени последнего старта.</p>
</td>
</tr>
<tr >
<td ><p>@@total_write</p>
</td>
<td ><p>Указывает на число записей с диска, которые SQL Сервер выполнил со времени последнего старта.</p>
</td>
</tr>
<tr >
<td ><p>@@tranchained</p>
</td>
<td ><p>Указывает на текущий режим транзакций Transact-SQL программы. Значение этой переменной равно 0, если установлен несвязный (unchained) режим и 1, если связный. </p>
</td>
</tr>
<tr >
<td ><p>@@trancount</p>
</td>
<td ><p>Указывает число активных транзакций текущего пользователя.</p>
</td>
</tr>
<tr >
<td ><p>@@transtate</p>
</td>
<td ><p>Указывает текущее состояние транзакции после выполнения оператора. Но в отличии от переменной @@error, эта переменная не очищается после выполнения каждого оператора.</p>
</td>
</tr>
<tr >
<td ><p>@@version</p>
</td>
<td ><p>Указывает дату создания текущей версии SQL Сервера.
</td>
</tr>
</table>
С помощью системной процедуры sp_monitor (монитор) можно получить информацию о многих из этих глобальных переменных. Полная информация о системных процедурах приводится в Справочном руководстве SQL Сервера.</p>
Если пользователь объявляет локальную переменную, название которой совпадает с глобальной переменной, то эта переменная рассматривается как локальная.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Команда перехода goto</td></tr></table></div>&nbsp;</p>
Команда goto (перейти на) вызывает безусловный переход на указанную пользователем метку. Эту команду перехода и метки можно использовать в пакетах и сохраненных процедурах. Название метки должно отвечать правилам, установленным для идентификаторов, и должно заканчиваться двоеточием, когда оно приводится впервые. Но двоеточие не нужно указывать, когда метка используется для ссылки в команде goto.</p>
Эта команда имеет следующий вид: </p>
&nbsp;</p>
метка:</p>
goto метка</p>
&nbsp;</p>
Далее приводится пример использования меток и команды безусловного перехода, команды цикла while и локальной переменной, которая используется в качестве счетчика:</p>
&nbsp;</p>
declare @count smallint </p>
select @count = 1 </p>
restart: </p>
print "yes" </p>
select @count = @count + 1 </p>
while @count &lt;=4 </p>
 &nbsp; goto restart</p>
&nbsp;</p>
Как и в этом примере, команде перехода обычно предшествует проверка некоторого условия с помощью команд while или if, чтобы избежать появления бесконечного цикла между командой goto и меткой.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Команда выхода return</td></tr></table></div>&nbsp;</p>
Команда return (возврат) предназначена для безусловного выхода из пакета или процедуры. Она может использоваться в любом месте пакета или процедуры. Когда она используется в сохраненной процедуре, то ее можно дополнить аргументом для возврата состояния вызывающей процедуре. Операторы, расположенные после оператора возврата, не исполняются.</p>
Эта команда имеет следующий простой вид:</p>
&nbsp;</p>
return [int_выражение]</p>
&nbsp;</p>
В следующем примере в сохраненной процедуре используется оператор return вместе с условным оператором и операторными скобками begin…end:</p>
&nbsp;</p>
create procedure findrules @nm varchar(30) = null as </p>
if @nm is null </p>
begin </p>
  print "You must give a user name" </p>
  return </p>
end </p>
else </p>
begin </p>
 &nbsp; select sysobjects.name, sysobjects.id, sysobjects.uid </p>
 &nbsp; from sysobjects, master..syslogins </p>
 &nbsp; where master..syslogins.name = @nm </p>
 &nbsp; and sysobjects.uid = master..syslogins.suid </p>
 &nbsp; and sysobjects.type = "R" </p>
end</p>
&nbsp;</p>
Если процедуре findrules (найти правила) не задается имя пользователя в качестве параметра, то команда return вызывает выход из процедуры после сообщения, выдаваемого на экран пользователя. Если имя задано, то из соответствующих системных таблиц выбираются все правила, принадлежащие данному пользователю.</p>
По своему действию команда return аналогична команде break, которая используется для выхода из цикла.</p>
Примеры возврата значений с помощью этой команды приводятся в главе 14 “Использование сохраненных процедур”. </p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Команда вывода print</td></tr></table></div>&nbsp;</p>
Команда print (печатать), которая уже использовалась в предыдущих примерах, предназначена для вывода на экран сообщений пользователя или значений локальных переменных. Локальная переменная должна быть объявлена в том же пакете или процедуре, где она используется. Выводимое сообщение должно быть не длиннее 255 байт.</p>
Эта команда имеет следующий вид:</p>
&nbsp;</p>
print {форматированная_строка_вывода | @локальная_переменная | </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; @@глобальная_переменная} [, список_аргументов]</p>
&nbsp;</p>
Приведем пример использования этой команды:</p>
&nbsp;</p>
if exists (select postalcode from authors </p>
 &nbsp; where postalcode = '94705') </p>
print "Berkeley author"</p>
&nbsp;</p>
В следующем примере команда print используется для вывода значения локальной переменной:</p>
&nbsp;</p>
declare @msg char(50) </p>
select @msg = "What's up doc?" </p>
print @msg</p>
&nbsp;</p>
В команде print можно использовать форматные символы (placeholders). В выводимой строке можно указать до 20 таких символов, расположенных в любом порядке. Эти символы заменяются форматированными строками, указанными в списке аргументов, следующими за выводимой строкой, когда текст сообщения передается клиенту.</p>
Форматные символы нумеруются, чтобы можно было изменить порядок следования аргументов, когда выводимая строка должна быть переведена на язык с другой грамматической структурой. Форматные символы для аргументов имеют следующий вид: %nn!. Вначале указывается символ процентов, за которым следует целое число от 1 до 20, заканчивающееся восклицательным знаком. Целое число указывает позицию соответствующего аргумента в строке на исходном языке. Например, “%1!” указывает на позицию первого аргумента в строке, “%2!” второго и т.д. Такое указание позиции аргумента позволяет корректно перевести фразу на различные языки, даже в том случае, когда при переводе необходимо изменить порядок слов.</p>
Например, предположим, что выдается следующее сообщение на английском:</p>
&nbsp;</p>
%1! is not allowed in %2!.&nbsp; (%1! не допускается в %2!.)</p>
&nbsp;</p>
На немецком языке это сообщение будет выглядеть следующим образом:</p>
&nbsp;</p>
%1! ist in %2! nicht zulаssig.</p>
&nbsp;</p>
В этом примере %1! во всех языках представляет собой один и тот же первый&nbsp; аргумент, а %2! второй аргумент. В этом примере также можно увидеть изменение расположения аргументов, когда фраза переводится на другой язык. Аргументы нужно нумеровать последовательно, хотя порядок расположения аргументов может и не соответствовать их порядковым номерам. Например, нельзя использовать 1 и 3 аргументы, когда в выводимой строке нет 2 аргумента.</p>
Необязательный список_аргументов может быть последовательностью переменных и констант. Аргумент может иметь любой тип за исключением text (текстовый) и image (графический). Аргумент конвертируется в тип char (символьный) перед тем, как помещается в окончательное сообщение. Если аргументов нет, то исходная строка выводится в том виде, в каком она задана и в этом случае в ней не должны быть никаких форматных символов.</p>
Максимальная длина выводимой строки с уже подставленными аргументами составляет 512 байт.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Команда raiserror</td></tr></table></div>&nbsp;</p>
Команда raiserror (возникновение ошибки) выводит на экран пользователя сообщение об ошибке и устанавливает системный флаг, который фиксирует факт возникновения ошибки. Как и в команде print здесь в качестве сообщения может выступать значение локальной переменной, но в этом случае локальная переменная должна быть объявлена в том же пакете или процедуре, где она используется. Сообщение должно быть не длиннее 255 символов.</p>
Команда raiserror имеет следующий вид:</p>
&nbsp;</p>
raiserror номер_ошибки </p>
[{форматированная_строка_вывода | @локальная_переменная }] [,список_аргументов]</p>
[extended_value = extended_value [{, extended_value = extended_value }...]]</p>
&nbsp;</p>
Номер_ошибки запоминается в глобальной переменной @@error, которая содержит последний номер системной или пользовательской ошибки, выданный SQL Сервером. Номера ошибок для сообщений, которые выдаются пользователями, должны быть больше 17000. Если номер_ошибки находится между 17000 и 19999 и выводимая строка отсутствует или пуста (“”), то SQL Сервер выбирает текст сообщения об ошибке из системной таблицы sysmessages базы данных master. Эти сообщения об ошибке используются главным образом системными процедурами.</p>
Длина форматированной_строки_вывода самой по себе не должна превышать 255 байтов. Длина окончательного сообщения вместе с подставленными аргументами составляет 512 байтов. Локальные переменные используемые для вывода сообщения должны иметь тип char или varchar. Можно не указывать выводимую строку или локальную переменную. В этом случае SQL Сервер использует сообщение из&nbsp; таблицы sysusermessages, которое соответствует указанному номеру ошибки. Как и команде print здесь можно подставлять в выводимую строку значения констант или переменных, задав их в качестве аргументов.</p>
В качестве опции можно определить дополнительные значения ошибки для использования в Open Client (открытый клиент) приложении. В этом случае в команду raiserror нужно включить конструкцию extended_value (дополнительное значение). Более детальную информацию о дополнительных значениях ошибки можно посмотреть в документации по Open Client приложениям или в разделе о команде raiserror в Справочном руководстве SQL Сервера.</p>
Команду raiserror следует использовать вместо команды print, когда необходимо запомнить номер ошибки в переменной @@error. Например, в процедуре findrules можно было бы использовать следующее сообщение об ошибке:</p>
&nbsp;</p>
raiserror 99999 "You must give a user name"&nbsp;&nbsp; (Нужно указать имя пользователя).</p>
&nbsp;</p>
Уровень строгости (severity) всех сообщений об ошибках, выдаваемых пользователями, равен 16. Этот уровень указывает, что у пользователя возникла нефатальная ошибка.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Сообщения пользователя в командах print и raiserror</td></tr></table></div>&nbsp;</p>
Пользователь может выбирать сообщения из таблицы sysusermessages (системные сообщения пользователя) с помощью системной процедуры sp_getmassage (выдать сообщение) для их последующего использования в командах print или raiserror. Для записи сообщений в эту таблицу следует использовать системную процедуру sp_addmassage (добавить сообщение).</p>
В следующем примере демонстрируется использование процедур sp_getmassage, sp_addmassage и команды print для записи сообщений в таблицу sysusermessages как на английском, так на немецком языке, с последующим их использованием в сохраненной процедуре и выводом на экран:</p>
&nbsp;</p>
/*</p>
** Install messages</p>
** First, the English (langid = NULL)</p>
*/</p>
set language us_english</p>
go</p>
sp_addmessage 25001,</p>
  "There is already a remote user named '%1!' for remote server '%2!'."</p>
go</p>
/* Then German*/</p>
sp_addmessage 25001, </p>
 &nbsp; "Remotebenutzername '%1!' existiert bereits auf dem Remoteserver '%2!'.","german"</p>
go</p>
&nbsp;</p>
create procedure test_proc @remotename varchar(30), </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; @remoteserver varchar(30)</p>
as</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; declare @msg varchar(255)</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; declare @arg1 varchar(40)</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /*</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ** check to make sure that there is not </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ** a @remotename for the @remoteserver.</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; */</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; if exists (select *</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; from master.dbo.sysremotelogins l,</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; master.dbo.sysservers s</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; where l.remoteserverid = s.srvid</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; and s.srvname = @remoteserver</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; and l.remoteusername = @remotename)</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; begin</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; exec sp_getmessage 25001, @msg output</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; select @arg1=isnull(@remotename,"null")</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; print @msg, @arg1, @remoteserver</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; return (1)</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; end</p>
return(0)</p>
go</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Команда waitfor</td></tr></table></div>&nbsp;</p>
Команда waitfor (ожидать до) предназначена задержки исполнения блока операторов, сохраненной процедуры или транзакции до наступления указанного времени, истечения временного интервала или наступления некоторого события.</p>
Эта команда имеет следующий синтаксис:</p>
&nbsp;</p>
waitfor {delay "время" | time "время" | errorexit |&nbsp; processexit | mirrorexit}</p>
&nbsp;</p>
Ключевое слово delay (задержка) сообщает SQL Серверу, что нужно ожидать до истечения указанного временного интервала. Ключевое слово time (время) сообщает SQL Серверу, что нужно ожидать до указанного момента времени, который должен быть задан в одном из форматов типа datetime.</p>
Однако при этом нельзя указывать календарные даты, поскольку календарная часть даты здесь не допускается. Время задержки, которое указывается в операторах waitfor time или waitfor delay, может включать часы, минуты, секунды, и оно не должно быть больше 24 часов. Для указания времени следует использовать формат “чч:мм:сс”. Например, команда waitfor time “16:23” сообщает SQL Серверу, что нужно ожидать до 16 часов 23 минут. Оператор waitfor delay “01:30” задерживает исполнение на один час 30 минут. Форматы указания времени можно также посмотреть в главе 8 “Добавление, изменение и удаление данных”.</p>
Ключевое слово errorexit (выход по ошибке) сообщает SQL Серверу, что нужно ожидать до тех пор, пока процесс завершится ненормально. Ключевое слово processexit (выход по выполнению) сообщает SQL Серверу, что нужно ожидать до тех пор, пока процесс завершится по какой-либо причине. Ключевое слово mirrorexit (выход по зеркалу) сообщает SQL Серверу, что нужно ожидать до тех пор, пока не появится ошибка по чтению или записи на одном из зеркальных (mirror) устройств.</p>
Команда waitfor errorexit обычно используется для удаления процесса, который закончился ошибкой, чтобы освободить системные ресурсы. Чтобы проверить какой процесс оказался ошибочным, следует посмотреть таблицу sysprocesses (системные процессы) с помощью системной процедуры sp_who.</p>
В следующем примере SQL Сервер ожидает наступления 14 часов 20 минут. Затем обновляется таблица chess (шахматы), в которую записывается очередной ход и исполняется сохраненная процедура sendmessage (послать сообщение), которая вставляет это сообщение в одну из таблиц Джуди (Judy), указывая ей тем самым, что сделан очередной ход шахматной партии. Этот пример имеет следующий вид:</p>
&nbsp;</p>
begin </p>
waitfor time "14:20" </p>
insert chess(next_move) </p>
values('Q-KR5') </p>
execute sendmessage 'judy'</p>
end</p>
&nbsp;</p>
Чтобы Джуди получила сообщение через 10 секунд, а не 14:20, нужно изменить команду ожидания следующим образом: </p>
&nbsp;</p>
waitfor delay "0:00:10"</p>
&nbsp;</p>
После выдачи команды waitfor нельзя использовать связь с SQL Сервером до тех пор, пока истечет указанный промежуток времени или наступит соответствующее событие.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Комментарии</td></tr></table></div>&nbsp;</p>
Комментарии обычно вносятся в операторы, пакеты и сохраненные процедуры для лучшего их понимания. Комментарий выглядит следующим образом:</p>
&nbsp;</p>
/* Текст комментария */</p>
&nbsp;</p>
На длину комментариев не накладывается никаких ограничений и они могут вносится в любое место, либо в виде отдельной строки, либо в конце строки. Допускаются также комментарии, занимающие несколько строк, но при этом каждая строка должна начинаться с наклонной черты (слеша) и звездочки и заканчиваться звездочкой и слешем. Все, что находиться между символами “/*” и “*/”, рассматривается как комментарий. Комментарии могут быть вложенными друг в друга.</p>
Для длинных комментариев, занимающих несколько строк, вводится также следующее стилистическое соглашение. Комментарий должен начинаться символами “/*”, а все последующие строки двумя звездочками “**”. Такой комментарий, как обычно, должен заканчиваться символами “*/”. В следующем примере можно увидеть подобный комментарий:</p>
&nbsp;</p>
select * from titles </p>
/* A comment here might explain the rules</p>
** associated with using an asterisk as </p>
** shorthand in the select list.*/ </p>
where price &gt; $5</p>
&nbsp;</p>
В следующем примере приводится процедура вместе с сопровождающими ее комментариями:</p>
&nbsp;</p>
/* this procedure finds rules by user name*/ </p>
create procedure findrules2 @nm varchar(30) = null </p>
as if @nm is null /*if no parameter is given*/ </p>
print "You must give a user name" </p>
else </p>
begin </p>
 &nbsp; select sysobjects.name, sysobjects.id, </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sysobjects.uid </p>
 &nbsp; from sysobjects, master..syslogins </p>
 &nbsp; where master..syslogins.name = @nm </p>
 &nbsp; and sysobjects.uid = master..syslogins.suid </p>
 &nbsp; and sysobjects.type = "R" </p>
end</p>
&nbsp;</p>
