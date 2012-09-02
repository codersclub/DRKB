<h1>Использование встроенных функций</h1>
<div class="date">01.01.2007</div>


<p>Использование встроенных функций</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Системные функции</td></tr></table></div>&nbsp;</p>
Системные функции позволяют получить специализированную информацию из базы данных. Применение большинства таких функций является самым простым способом получения информации из системных таблиц. </p>
Общий синтаксис вызова системных функций выглядит следующим образом:</p>
&nbsp;</p>
select название_функции(аргумент[ы])</p>
&nbsp;</p>
Системные функции могут использоваться в списке выбора оператора select, в конструкции where, а также в любом другом месте, где допускается использование выражений. </p>
Например, чтобы найти идентификационный номер коллеги, зарегистрированного в системе как “harold”, следует выполнить оператор:</p>
&nbsp;</p>
select user_id(“harold”)</p>
&nbsp;</p>
Если предположить, что идентификационный номер пользователя, работающего под именем “harold”, равен 13, то результат этого запроса будет выглядеть так:</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ---------------------</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  13</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
Вообще говоря, название системной функции говорит о том, информация какого типа будет возвращена. </p>
Системная функция user_name (имя пользователя) использует в качестве аргумента идентификационный номер (ID) пользователя и возвращает имя пользователя:</p>
&nbsp;</p>
select user_name(13)</p>
--------</p>
harold</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
Для нахождения имени текущего пользователя, т.е. пользователя выполняющего запрос, аргумент этой функции можно опустить:</p>
&nbsp;</p>
select user_name()</p>
------------------</p>
dbo</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
Заметим, что системный администратор является владельцем любой базы данных, предполагая, что его серверный идентификатор ID равен 1. Пользователь-гость (guest) всегда получает серверный идентификатор, равный -1. Внутри базы данных значением функции user_name для владельца базы данных всегда является значение “dbo”, а его или ее&nbsp; пользовательский идентификатор (ID) равен 1. Внутри базы данных пользователь-гость всегда получает идентификатор 2. </p>
Ниже приведен список названий системных функций, а также их аргументов и возвращаемых результатов:</p>
&nbsp;</p>
&nbsp;</p>
Таблица 10-1: Системные функции, аргументы и результаты</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >Название функции</p>
</td>
<td >Аргумент</p>
</td>
<td >Результат</p>
</td>
</tr>
<tr >
<td >col_name</p>
</td>
<td >(object_id, column_id [, database_id])</p>
</td>
<td >Возвращает название столбца.</p>
</td>
</tr>
<tr >
<td >col_length</p>
</td>
<td >(название_объекта,</p>
название_столбца)</p>
</td>
<td >Возвращает указанную длину столбца. Действительную длину столбца можно узнать с помощью функции datalength.</p>
</td>
</tr>
<tr >
<td >Curunreservedpgs</p>
</td>
<td >(dbid, lstart,</p>
 unreservedpgs)</p>
</td>
<td >Возвращает количество свободных страниц на диске. Если база данных открыта, то это значение берется из памяти; если же база данных закрыта, то значение функции берется из столбца unreservedpgs таблицы sysusages.</p>
</td>
</tr>
<tr >
<td >data_pgs</p>
</td>
<td >(object_id, {doampg | ioampg})</p>
</td>
<td >Возвращает количество страниц, занимаемых таблицей (doampg)&nbsp; или индексами (ioampg). В результат не включаются страницы, которые используются для внутренних структур.</p>
</td>
</tr>
<tr >
<td >Datalength</p>
</td>
<td >(выражение)</p>
</td>
<td >Возвращает длину выражения в байтах. Выражением обычно является название столбца. Если выражение это символьная константа, то она должна быть заключена в кавычки.</p>
</td>
</tr>
<tr >
<td >db_id</p>
</td>
<td >([название_базы_данных])</p>
</td>
<td >Возвращает идентификатор базы данных. Название базы данных должно быть символьным выражением; если же это константа, то она должна быть заключена в кавычки. Если же название базы данных вообще не указано, то функция db_id возвращает идентификатор&nbsp; текущей базы данных.</p>
</td>
</tr>
<tr >
<td >db_name</p>
</td>
<td >([database_id])</p>
</td>
<td >Возвращает название базы данных. Аргумент database_id должен быть числовым выражением. Если же аргумент не указан, то функция db_name возвращает название текущей базы данных.</p>
</td>
</tr>
<tr >
<td >host_id</p>
</td>
<td >()</p>
</td>
<td >Возвращает идентификатор текущего клиентского процесса на сервере.</p>
</td>
</tr>
<tr >
<td >host_name</p>
</td>
<td >()</p>
</td>
<td >Возвращает название текущего клиентского процесса на сервере.</p>
</td>
</tr>
<tr >
<td >index_col</p>
</td>
<td >(object_name, index_id, key_# [, user_id]) </p>
</td>
<td >Возвращает название индексированного столбца; если аргумент object_name не является названием таблицы или вьювера, то возвращается NULL.</p>
</td>
</tr>
<tr >
<td >isnull</p>
</td>
<td >(выражение1,</p>
 выражение2)</p>
</td>
<td >Возвращается значение выражения2, если значение выражение1 равно NULL. Типы данных этих выражений должны неявно преобразовываться друг в друга, в противном случае нужно использовать функцию convert.</p>
</td>
</tr>
<tr >
<td >lct_admin</p>
</td>
<td >({{ "lastchance" | "logfull" | "unsuspend" } , database_id} | "reserve", log_pages})</p>
</td>
<td >Эта функция управляет пороговым значением для числа повторных обращений к сегментам журнала транзакций (last-chance thresold).</p>
 &nbsp;&nbsp;&nbsp; Аргумент lastchance задает пороговое значение для числа повторений в указанной базе данных.</p>
 &nbsp;&nbsp;&nbsp; Аргумент logfull возвращает 1, если чило попыток превысило пороговое значение в указанной базе данных, и 0 в противном случае.</p>
 &nbsp;&nbsp;&nbsp; Аргумент unsuspend разблокирует отложенные задания в указанной базе данных и обнуляет число повторений, если оно превысило пороговое значение.</p>
 &nbsp;&nbsp;&nbsp; Аргумент reserve возвращает число свободных страниц журнала транзакций указанного размера, которые необходимы для успешного завершения транзакции.</p>
</td>
</tr>
<tr >
<td >object_id</p>
</td>
<td >(название_объекта)</p>
</td>
<td >Возвращает идентификатор (ID) объекта. </p>
</td>
</tr>
<tr >
<td >object_name</p>
</td>
<td >(object_id[, database_id])</p>
</td>
<td >Возвращает название объекта.</p>
</td>
</tr>
<tr >
<td >proc_role</p>
</td>
<td >("sa_role" | "sso_role" | "oper_role")</p>
</td>
<td >Проверяет, имеет ли пользователь, вызывающий процедуру, право на выполнение этой процедуры. Если такое право есть, то возвращается 1, иначе возвращается 0. </p>
</td>
</tr>
<tr >
<td >reserved_pgs</p>
</td>
<td >(object_id, {doampg |</p>
ioampg})</p>
</td>
<td >Возвращает количество страниц, отведенных для таблицы или индекса. В результате этой функции учитываются страницы, предназначенные для внутренних структур. </p>
</td>
</tr>
<tr >
<td >rowcnt</p>
</td>
<td >(doampg)</p>
</td>
<td >Возращает число строк в таблице.</p>
</td>
</tr>
<tr >
<td >show_role</p>
</td>
<td >()</p>
</td>
<td >Возвращает текущий статус пользователя, если он есть в списке (sa_role, sso_role, oper_role). В противном случае возращается NULL. </p>
</td>
</tr>
<tr >
<td >suser_id</p>
</td>
<td >([серверное_имя_пользователя])</p>
</td>
<td >Возвращает серверный идентификационный номер (ID) пользователя, взятый из таблицы syslogins. Если имя пользователя&nbsp; не указано, то возвращается серверный идентификатор (ID) текущего пользователя.</p>
</td>
</tr>
<tr >
<td >suser_name</p>
</td>
<td >([server_user_id])</p>
</td>
<td >Возвращает серверное имя пользователя по указанному серверному&nbsp; идентификатору пользователя (ID), которые хранятся в таблице syslogins. Если аргумент (server_user_id) не указывается, то возвращается имя текущего пользователя.</p>
</td>
</tr>
<tr >
<td >used_pgs</p>
</td>
<td >(object_id, doampg, ioampg)</p>
</td>
<td >Выводит общее число страниц, используемых для хранения таблицы и ее кластеризованного индекса. </p>
</td>
</tr>
<tr >
<td >tsequal</p>
</td>
<td >(timestamp,timestamp2)</p>
&nbsp;</p>
</td>
<td >Сравнивает значения в столбце timestamp с указанным временем, чтобы не обновлять строку, кото-рая модифицируется в режиме просмотра (browsing). Аргумент timestamp указывает на время в просматриваемой строке, а timestamp2 в сохраняемой строке. Это позволяет использовать режим просмотра без вызова DB-Library. (См. “Режим просмотра”).</p>
</td>
</tr>
<tr >
<td >user</p>
</td>
<td >&nbsp;</p>
</td>
<td >Возвращает имя пользователя</p>
</td>
</tr>
<tr >
<td >user_id</p>
</td>
<td >([имя_пользователя])</p>
</td>
<td >Возвращает идентификационный номер пользователя. Этот номер берется из таблицы sysusers текущей базы данных. Если имя пользователя не указывается, то возвращается идентификатор&nbsp; текущего пользователя.</p>
</td>
</tr>
<tr >
<td >user_name</p>
</td>
<td >([user_id])</p>
</td>
<td >Возвращает имя пользователя по его идентификтору в текущей базе данных. Если аргумент (user_id) не указывается, то возвращается имя текущего пользователя. </p>
</td>
</tr>
<tr >
<td >valid_name</p>
</td>
<td >(символьное_выражение)</p>
</td>
<td >Возвращает 0, если символьное выражение является некоректным идентификатором (т.е. содержит недопустимые символы или его длина превышает 30 байтов), и ненулевое число, если аргумент является правильным идентификатором.</p>
</td>
</tr>
<tr >
<td >valid_user</p>
</td>
<td >(server_user_id)</p>
</td>
<td >Возвращает 1, если указанный аргумент является правильным идентификатором пользователя, по крайней мере, одной базы данных SQL Сервера. Пользователь должен иметь права (уровень) sa_role или sso_role, чтобы вызывать эту функцию с аргументом, отличным от своего идентификатора.
</td>
</tr>
</table>
Если аргумент системной функции является необязательным, то в качестве него подразумевается текущая база данных, сервер (host computer), текущий пользователь сервера или текущий пользователь базы данных. Во всех встроенных функциях (за исключением функции user) аргумент всегда заключается в скобки, даже если он является пустым.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Примеры использования системных функций</td></tr></table></div>&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Функция col_length</td></tr></table></div>&nbsp;</p>
В следующем запросе определяется длина столбца title из таблицы titles (выражение “х=“ указывается для того, чтобы результат запроса имел заголовок): </p>
&nbsp;</p>
select x = col_length("titles", "title") </p>
&nbsp;</p>
 x </p>
-------- </p>
 &nbsp;&nbsp; 80</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Функция datalength</td></tr></table></div>В отличие от функции col_length, которая находит длину столбца, определенную при создании таблицы, функция datalength показывает действительную длину (в байтах) всех данных, хранящихся в таблице. Эта функция полезна для данных типа varchar, nvarchar, varbinary, text  и image, поскольку размер этих данных может изменяться. Функция datalength возвращает неопределенное значение NULL, если аргумент равен NULL. Для всех остальных типов данных, кроме перечисленных выше, функция datalength показывает длину, которая была указана при их определении. Ниже приведен пример, в которым находится длина данных из столбца pub_name таблицы publishers:</p>
&nbsp;</p>
select Length=datalength(pub_name), pub_name </p>
from publishers </p>
&nbsp;</p>
Length&nbsp;&nbsp; pub_name</p>
-------&nbsp;&nbsp; ------------------------ </p>
13&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; New Age Books</p>
16&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Binnet &amp; Hardley</p>
20&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Algodata Infosystems</p>
&nbsp;</p>
(Выбрано 3 строки)</p>
&nbsp;</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Функция isnull</td></tr></table></div>&nbsp;</p>
Следующий запрос находит среднюю цену всех книг из таблицы titles, при этом заменяя неопределенные значения NULL в столбце price значением “$10.00”:&nbsp;&nbsp;&nbsp; </p>
&nbsp;</p>
select avg(isnull(price,$10.00)) </p>
from titles</p>
------------</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 14.24</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Функция user_name</td></tr></table></div>В следующем запросе ищется строка из таблицы sysusers, в которой имя пользователя совпадает с результатом применения системной функции user_name  к идентификатору пользователя, равному 1:&nbsp; </p>
&nbsp;</p>
select name </p>
from sysusers </p>
where name = user_name(1) </p>
&nbsp;</p>
name</p>
------------------------ </p>
dbo</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Строковые функции</td></tr></table></div>&nbsp;</p>
Строковые функции используются для выполнения различных операций над символьными строками и выражениями. Некоторые из строковых функций могут выполняться как с двоичными, так и с символьными данными. Можно также приписывать (соединять) двоичные данные к символьным строкам или выражениям.</p>
Встроенные строковые функции обычно используются для выполнения различных операций над символьными данными. Названия строковых функций не являются ключевыми словами.</p>
Синтаксис строковых функций имеет следующий общий вид:</p>
&nbsp;</p>
select название_функции(аргументы)</p>
&nbsp;</p>
Можно выполнить конкатенацию (приписывание) двоичных или символьных выражений следующим образом:</p>
&nbsp;</p>
select (выражение + выражение + [выражение]...) </p>
&nbsp;</p>
При конкатенации несимвольных или недвоичных выражений нужно использовать функцию преобразования данных convert, как показано ниже:</p>
&nbsp;</p>
select "The price is " + convert(varchar(12),price)</p>
from titles</p>
Большинство строковых функций выполняются только над данными типа char, nchar, varchar и nvarchar и над данными, которые неявно можно преобразовать в данные типа char и varchar. Однако некоторые строковые функции могут также выполняться над данными типа binary и varbinary. Функция patindex может выполняться над данными типа text, char, nchar, varchar, nvarchar.</p>
Конкатенация может выполняться с данными типа binary или varbinary, а также char, nchar, varchar и nvarchar. Однако, конкатенация данных из столбцов типа text не разрешается. </p>
Строковые функции могут быть вложенными одна в другую и могут применяться везде, где допустимы выражения. Константы в строковых функциях&nbsp; должны быть заключены в простые или двойные кавычки. </p>
В таблице 10-2 перечислены аргументы, которые используются в строковых функциях. Если функция имеет несколько аргументов одного типа, то они нумеруются по порядку char_expr1, char_expr2.</p>
&nbsp;</p>
Таблица 10-2: Аргументы строковых функций</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >Тип аргумента</p>
</td>
<td >Может быть заменен</p>
</td>
</tr>
<tr >
<td >char_expr</p>
</td>
<td >Названием столбца, содержащим символьные данные, переменной или выражением типа char, varchar, nchar и nvarchar. Особо отмечается случай, когда в качестве выражения можно задавать текст (text). Символические константы должны быть заключены в кавычки.</p>
</td>
</tr>
<tr >
<td >expression</p>
</td>
<td >Названием столбца, содержащим двоичные или символьные данные, переменной или константой. Данные могут иметь тип char, varchar, nchar, nvarchar, как для аргумента char_expr, а также&nbsp; binary и varbinary.</p>
</td>
</tr>
<tr >
<td >pattern</p>
</td>
<td >Символьным выражением типа char, nchar, varchar, или  nvarchar, которое кроме того может содержать символы замены, поддерживаемые SQL Сервером.</p>
</td>
</tr>
<tr >
<td >approx_numeric</p>
</td>
<td >Названием столбца, содержащим данные типа (float, real, double precision), переменной, константой или выражением.</p>
</td>
</tr>
<tr >
<td >integer_expr</p>
</td>
<td >Любым целым числом (типа tinyint, smallint или int), названием столбца, переменной или выражением целого типа. Максимальная величина числа отмечается в пояснении, если это необходимо.</p>
</td>
</tr>
<tr >
<td >start</p>
</td>
<td >Выражением вида integer_expr.</p>
</td>
</tr>
<tr >
<td >length</p>
</td>
<td >Выражением вида integer_expr.
</td>
</tr>
</table>
Каждой строковой функции можно также задавать аргументы, которые неявно преобразуются к нужному типу. Например, функции, имеющие&nbsp; аргументы приближенного числового типа (approximate numeric), будут также работать и с аргументами целого типа. В этом случае SQL Сервер автоматически преобразует аргумент функции к нужному типу.</p>
&nbsp;</p>
Таблица 10-3: Строковые функции, аргументы и результаты</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >Функция</p>
</td>
<td >Аргумент</p>
</td>
<td >Результат</p>
</td>
</tr>
<tr >
<td >ascii&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
</td>
<td >(char_expr)</p>
</td>
<td >Возвращает ASCII код первого символа в аргументе.</p>
</td>
</tr>
<tr >
<td >char</p>
</td>
<td >(integer_expr)</p>
</td>
<td >Преобразует однобайтовое значение типа integer в значение типа character. Функция char  обычно используется как обратная к функции ascii. Значение аргумента integer_expr должно находиться между 0 до 255. Результат будет иметь тип char. Если&nbsp; результирующее значение будет первым байтом многобайтового символа, то результат может быть не определен. </p>
</td>
</tr>
<tr >
<td >charindex</p>
</td>
<td >(expression1, expression2)</p>
</td>
<td >В выражении expression2 проводится поиск первого вхождения выражения expression1 и возвращается номер позиции, с которой оно начинается. Если выражение expression1 не было найдено, то возвращается 0. Если же выражение expression1 содержит символы замены, то при выполнении функции charindex они рассматриваются как литералы.</p>
&nbsp;</p>
</td>
</tr>
<tr >
<td >char_length</p>
</td>
<td >(char_expr)</p>
</td>
<td >Возвращает длину (число символов)&nbsp; в символьном выражении или тексте. Для данных, имеющих переменную длину, функция char_length не учитывает концевые пробелы. Длина выражений с многобайтовыми символами обычно меньше, чем число байтов, поэтому для определения числа байтов&nbsp; в этом случае следует использовать системную функцию datalength.</p>
</td>
</tr>
<tr >
<td >difference</p>
</td>
<td >(char_expr1, char_expr2)</p>
</td>
<td >Возвращает целое число, являющееся разностью двух значений&nbsp; soundex. Функция soundex рассматривается ниже.</p>
</td>
</tr>
<tr >
<td >lower</p>
</td>
<td >(char_expr)</p>
</td>
<td >Преобразует символы верхнего регистра в нижний. Результат имеет символьный тип.</p>
</td>
</tr>
<tr >
<td >ltrim</p>
</td>
<td >(char_expr)</p>
</td>
<td >Удаляет пробелы в начале&nbsp; символьного выражения. Удаляются только те символы, которые эквивалентны пробелу в спецификации специальных символов SQL Сервера.</p>
</td>
</tr>
<tr >
<td >patindex</p>
</td>
<td >("%pattern%", char_expr [using {bytes | chars | characters}] )</p>
</td>
<td >Возвращает номер позиции, с которой&nbsp; начинается первое вхождение строки pattern (образца) в указанное символьное выражение char_expr, и 0, если образец pattern не входит в нее. По умолчанию, функция patindex возвращает номер символа. Чтобы получить смещение в байтах для строк в многобайтовых алфавитах, необходимо указать опцию using bytes. Символ &#8216;%&#8217; должен находиться до и после образца pattern, за исключением&nbsp; случаев, когда поиск происходит с начала или с конца строки. Об использовании символов замены в этой функции подробнее можно посмотреть в разделе “Символы замены” Справочного Руководства по SQL Серверу. Она может также использоваться для текстовых данных. </p>
</td>
</tr>
<tr >
<td >replicate</p>
</td>
<td >(char_expr, integer_expr)</p>
</td>
<td >Возвращает строку того же типа, что и аргумент char_expr, состоящую из повторения выражения char_expr, указанное число раз, или столько раз, сколько умещается в 255 байтах, в зависимости от того, что меньше.</p>
</td>
</tr>
<tr >
<td >reverse</p>
</td>
<td >(char_expr)</p>
</td>
<td >Возвращает символьное выражение char_expr в обратном порядке (перевернутым). Например, если char_expr это строка “abcd”, то обратной будет “dcba”.</p>
</td>
</tr>
<tr >
<td >right</p>
</td>
<td >(char_expr, integer_expr)</p>
</td>
<td >Возвращает правую часть символьного выражения, начиная с указанного номера. Результат имеет тот же тип, что и символьное выражение. </p>
</td>
</tr>
<tr >
<td >rtrim</p>
</td>
<td >(char_expr)</p>
</td>
<td >Удаляет концевые пробелы. Удаляются только те символы, которые эквивалентны пробелу в спецификации специальных символов SQL Сервера. </p>
</td>
</tr>
<tr >
<td >soundex</p>
</td>
<td >(char_expr)</p>
</td>
<td >Возвращает четырехсимвольный код soundex заданной строки, который строится из последовательности одно и двухбайтовых латинских символов.</p>
</td>
</tr>
<tr >
<td >space</p>
</td>
<td >(integer_expr)</p>
</td>
<td >Возвращает строку, состоящую из&nbsp; указанного числа однобайтовых пробелов. </p>
</td>
</tr>
<tr >
<td >str</p>
</td>
<td >(approx_numeric[, length [, decimal] ])</p>
</td>
<td >Возвращает символьное представление&nbsp; числа с плавающей точкой. Параметр&nbsp; length задает общее число возвращаемых символов (включая десятичную точку и все разряды слева и справа от нее), а параметр decimal задает число возвращаемых десятичных разрядов.</p>
 &nbsp;&nbsp; Параметры length&nbsp; и decimal являются необязательными. Если они указываются, то они должны быть неотрицательными. По умолчанию, значение length равно 10, а decimal равно 0. Функция str округляет число таким образом, чтобы результат не превышал заданную длину length.</p>
</td>
</tr>
<tr >
<td >stuff</p>
</td>
<td >(char_expr1, start, length, char_expr2)</p>
</td>
<td >Из строки char_expr1 удаляются символы, начиная с позиции, заданной параметром start. Число удаляемых символов определяется параметром length. После этого строка char_expr2 вставляется в строку char_expr1, начиная с позиции start. Чтобы просто удалить символы из строки, нужно задать строку char_expr2 равной NULL, но не пробелу “ “, который является обычным символом.</p>
  </p>
</td>
</tr>
<tr >
<td >substring</p>
</td>
<td >(expression, start, length)</p>
</td>
<td >Возвращает часть символьной или двоичной строки (подстроку). Параметр start указывает позицию первого символа подстроки, а параметр length определяет число символов в подстроке.&nbsp; </p>
</td>
</tr>
<tr >
<td >upper</p>
</td>
<td >(char_expr)</p>
</td>
<td >Преобразует символы с нижнего регистра в верхний. Результат имеет символьный тип.
</td>
</tr>
</table>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Примеры использования строковых функций</td></tr></table></div>&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Функции charindex и patindex</td></tr></table></div>Функции charindex и patindex возвращают начальную позицию строки-образца (pattern), которая задается пользователем. Обе функции имеют по два аргумента, но выполняются по разному. Функция patindex допускает использование символов замены в искомой строке, а функция charindex нет. Функцию charindex можно применять только к данным типа char, nchar, varchar и nvarchar, а функцию patindex, кроме вышеуказанных типов, можно применять к текстовым данным (text).</p>
Каждая из этих функций имеет два аргумента. Первый аргумент является искомой строкой (pattern), которую нужно найти. Для функции patindex этот аргумент заключается с двух сторон в символы процента %, за исключением тех случаев, когда происходит поиск с начала строки (тогда следует опустить начальный символ %) или с конца строки (тогда следует опустить последний символ %). Для функции charindex образец не может содержать символов замены. Вторым аргументом для обеих функций является символьное выражение, которое обычно задается названием табличного столбца и в котором происходит поиск указанного образца.</p>
Следующий запрос демонстрирует использование этих функций для нахождения вхождения слова “wonderfull” в символьную строку, находящуюся в столбце notes таблицы titles: </p>
&nbsp;</p>
select charindex("wonderful", notes), patindex("%wonderful%", notes) </p>
from titles </p>
where title_id = "TC3218" </p>
&nbsp;</p>
------------&nbsp;&nbsp;&nbsp; ------------- </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 46&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 46</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
Если не указывать строки, в которых нужно проводить поиск, то в результате будут указаны все строки таблицы, при этом для строк, не содержащих образца, будет выводиться нулевое значение 0. В следующем примере показано, как с помощью функции patindex находятся все строки в таблице sysobject, которые начинаются с символов “sys” и в которых четвертым символом является любой из символов a,b,c, или d:</p>
&nbsp;</p>
&nbsp;</p>
select name </p>
from sysobjects </p>
where patindex("sys[a-d]%", name) &gt; 0 </p>
&nbsp;</p>
name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
------------------------------&nbsp; </p>
sysalternates</p>
sysattributes</p>
syscharsets</p>
syscolumns</p>
syscomments</p>
sysconfigures</p>
sysconstraints</p>
syscurconfigs</p>
sysdatabases</p>
sysdepends</p>
sysdevices</p>
&nbsp;</p>
(Выбрано 11 строк)</p>
&nbsp;</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Функция str</td></tr></table></div>&nbsp;</p>
Функция str преобразует числа в строки символов. Ее необходимыми аргументами являются длина результирующей строки (включая знак, десятичную точку, и разряды справа и слева от десятичной точки) и число разрядов после десятичной точки. </p>
Если указываются аргументы этой функции, то они должны быть положительными. По умолчанию будет возвращаться строка длиной 10 символов без дробной части. Длина строки должна быть достаточной для того, чтобы включить в нее знак и десятичную точку. Дробная часть числа округляется, чтобы длина результирующей строки не превышала заданной величины. Если же длина целой части результата также не умещается в указанное число разрядов, то функция str возвращает строку звездочек указанной длины. </p>
Например:</p>
&nbsp;</p>
select str(123.456, 2, 4) </p>
&nbsp;</p>
-- </p>
**</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
Данные короткого типа approx_numeric выравниваются вправо до указанной длины, а данные длинного типа approx_numeric укорачиваются до указанного числа десятичных разрядов.</p>
&nbsp;</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Функция stuff</td></tr></table></div>&nbsp;</p>
Функция stuff выполняет подстановку одной строки в другую. Эта функция удаляет указанное число символов из строки expr1, начиная с указанной позиции, а затем вставляет строку expr2  на это место вместо удаленных символов. Если в качестве начальной позиции или длины указано отрицательное число, то возвращается неопределенное значение NULL.</p>
Если начальный номер превосходит длину строки expr1, то также возвращается неопределенное значение. Если же длина удаляемой подстроки превышает длину строки expr1, то удаляется вся часть слова вплоть до последнего символа. Например:</p>
&nbsp;</p>
select stuff("abc", 2, 3, "xyz") </p>
&nbsp;</p>
---- </p>
axyz </p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
Для того, чтобы с помощью функции stuff удалить символы из строки, следует аргументу expr_2  присвоить неопределенное значение NULL, но не символ пробела в кавычках. Использование символа “ “ приведет к вставке пробела вместо удаленных символов. Например:</p>
&nbsp;</p>
select stuff("abcdef", 2, 3, null)</p>
--- </p>
aef </p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
select stuff("abcdef", 2, 3, " ")</p>
---- </p>
a ef</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
&nbsp;</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Функции soundex и difference</td></tr></table></div>&nbsp;</p>
Функция soundex преобразует символьную строку в четырехразрядный код, используемый при сравнении строк. Гласные буквы игнорируются при сравнении. Неалфавитные символы рассматриваются как терминаторы строки при вычислении функции soundex. Эта функция всегда возвращает некоторое значение. Следующие два имени имеют одинаковый код soundex:</p>
&nbsp;</p>
select soundex("smith"), soundex("smythe") </p>
&nbsp;</p>
----- -----&nbsp; </p>
S530&nbsp; S530 </p>
&nbsp;</p>
Функция difference (различие) производит сравнение кодов soundex двух строк и оценивает числом от 0 до 4 степень их сходства друг с другом. Значение 4 означает максимальное сходство. Например:</p>
&nbsp;</p>
select difference("smithers", "smothers") </p>
--------- </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4</p>
&nbsp;</p>
select difference("smothers", "brothers") </p>
 --------- </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2</p>
&nbsp;</p>
Большинство оставшихся строковых функций легки для понимания и использования. Например:</p>
&nbsp;</p>
Таблица 10-4: Примеры строковых функций</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >Оператор</p>
</td>
<td >Результат</p>
</td>
</tr>
<tr >
<td >select right(“abcde”,3)</p>
</td>
<td >cde</p>
</td>
</tr>
<tr >
<td >select right(“abcde”, 6)</p>
</td>
<td >abcde</p>
</td>
</tr>
<tr >
<td >select upper(“torso”)</p>
</td>
<td >TORSO</p>
</td>
</tr>
<tr >
<td >select ascii(“ABC”)</p>
</td>
<td >65
</td>
</tr>
</table>
&nbsp;</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Функция substring</td></tr></table></div>В следующем примере демонстируется применение функции substring.&nbsp; Здесь выбираются фамилии и инициалы каждого автора из таблицы authors, например, “Bennet A”.</p>
&nbsp;</p>
select au_lname, substring (au_f name, 1, 1) </p>
from authors </p>
&nbsp;</p>
Функция substring (подстрока) действительно соответствует своему названию: ее результатом является часть символьной или двоичной строки.</p>
Для функции substring всегда нужно указывать три аргумента. Первый аргумент может быть символьной или двоичной строкой, названием столбца таблицы, или выражением, включающем название столбца. Второй аргумент указывает позицию, с которой должна начинаться подстрока. А третий определяет число символов (длину) возвращаемой подстроки. </p>
Синтаксис функции substring имеет следующий вид:</p>
&nbsp;</p>
substring(выражение, начальная позиция, длина) </p>
&nbsp;</p>
Например, в следующем операторе показано, как получить второй, третий и четвертый символы из строки “abcdef”:</p>
&nbsp;</p>
select x = substring("abcdef", 2, 3)</p>
&nbsp;</p>
x </p>
--------- </p>
bcd</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Конкатенация</td></tr></table></div>&nbsp;</p>
С помощью операции конкатенации (+) можно приписывать (соединять) символьные или двоичные строки друг с другом.</p>
Если соединяются между собой символьные строки, то их нужно заключать в одинарные или двойные кавычки.</p>
Эта операция имеет следующий вид: </p>
&nbsp;</p>
select (выражение + выражение [+ выражение]...) </p>
&nbsp;</p>
В следующем примере показано, как можно соединить две символьных строки:</p>
&nbsp;</p>
select ("abc" + "def") </p>
------- </p>
abcdef </p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
В следующем запросе выбираются фамилии и имена всех авторов, живущих в Калифорнии, причем фамилия отделяются от имени запятой и пробелом: </p>
&nbsp;</p>
select Moniker = (au_lname + ", " + au_fname) </p>
from authors </p>
where state = "CA" </p>
&nbsp;</p>
Moniker </p>
-----------------------</p>
White, Johnson </p>
Green, Marjorie </p>
Carson, Cheryl </p>
O'Leary, Michael </p>
Straight, Dick </p>
Bennet, Abraham </p>
Dull, Ann </p>
Gringlesby, Burt </p>
Locksley, Chastity </p>
Yokomoto, Akiko </p>
Stringer, Dirk </p>
MacFeather, Stearns </p>
Karsen, Livia </p>
Hunter, Sheryl </p>
McBadden, Heather </p>
&nbsp;</p>
(Выбрано 15 строк)</p>
&nbsp;</p>
Для конкатенации числовых данных или данных типа даты необходимо использовать функцию преобразования типов convert:</p>
&nbsp;</p>
select "The due date is " + convert(varchar(30), pubdate)&nbsp; </p>
from titles </p>
where title_id = "BU1032" </p>
&nbsp;</p>
--------------------------------------- </p>
The due date is Jun 12 1985 12:00AM</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Конкатенация и пустая строка</td></tr></table></div>При конкатенации пустая строка (“” или “) заменяется одним пробелом, например следующий оператор:</p>
&nbsp;</p>
select "abc" + "" + "def"</p>
&nbsp;</p>
выдаст следующий результат: </p>
&nbsp;</p>
abc def </p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Композиция строковых функций</td></tr></table></div>&nbsp;</p>
Строковые функции можно применять одну за другой, т.е. выполнять композицию (суперпозицию) функций. Например, следующий оператор выводит фамилию и инициалы каждого автора, причем после фамилии следует запятая, а&nbsp; инициалы заканчиваются точкой: </p>
&nbsp;</p>
select (au_lname + "," + " " + substring(au_fname, 1, 1) + ".") </p>
from authors </p>
where city = "Oakland" </p>
&nbsp;</p>
---------------------- </p>
Green, M. </p>
Straight, D. </p>
Stringer, D. </p>
MacFeather, S. </p>
Karsen, L. </p>
&nbsp;</p>
(Выбрано 5 строк)</p>
&nbsp;</p>
Чтобы получить идентификатор издателя, за которым следуют два первых символа идентификатора книги, стоящей больше 20 долларов, можно воспользоваться следующим оператором:</p>
&nbsp;</p>
select substring(pub_id + title_id, 1, 6) </p>
from titles </p>
where price &gt; $20 </p>
-------------- </p>
1389PC </p>
0877PS </p>
0877TC</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Текстовые функции</td></tr></table></div>&nbsp;</p>
Встроенные текстовые функции используются для обработки текстовых (text) и графических (image) данных. Текстовые функции перечислены в следующей таблице.</p>
&nbsp;</p>
Таблица 10-5: Встроенные текстовые функции</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >patindex</p>
</td>
<td >("%pattern%", char_expr [using {bytes | chars | characters}] )</p>
</td>
<td >Возвращает номер позиции, с которой&nbsp; начинается первое вхождение строки pattern (образца) в указанное символьное выражение char_expr, и 0, если образец pattern не входит в нее. По умолчанию, функция patindex возвращает номер символа. Чтобы получить смещение в байтах для строк в многобайтовых алфавитах, необходимо указать опцию using bytes. Символ &#8216;%&#8217; должен находиться до и после образца pattern, за исключением&nbsp; случаев, когда поиск происходит с начала или с конца строки. Об использовании символов замены в этой функции подробнее можно посмотреть в разделе “Символы замены” Справочного Руководства по SQL Серверу. </p>
</td>
</tr>
<tr >
<td >textptr</p>
</td>
<td >(название_столбца)</p>
</td>
<td >Возвращает текстовый указатель, который является 16-ти байтовым адресом. Указатель должен указывать на первую текстовую страницу.</p>
</td>
</tr>
<tr >
<td >textvalid</p>
</td>
<td >(“название_таблицы.. название_столбца”, текстовый_указатель)</p>
</td>
<td >Проводится проверка правильности тектового указателя. Отметим, что название столбца должно быть расширено названием таблицы. Возвращает 1, если указатель правильный, и 0, в противном случае.</p>
</td>
</tr>
<tr >
<td >set textsize</p>
</td>
<td >{ n | 0}</p>
</td>
<td >Указывает ограничение на объем текстовых или графических данных в&nbsp; байтах, которые можно возвратить оператором select. Текущая установка хранится в глобальной переменной @@textsize. Параметр n определяет число возвращаемых байтов, а 0 устанавливает значение по умолчанию, равное 32К.
</td>
</tr>
</table>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
Кроме этих функций для текстовых данных можно использовать функцию datalength, которая была описана в разделе о системных функциях. Пользователь может также использовать глобальные переменные @@textcolid, @@textdbid, @@textobjid, @@textptr и @@textsize для обработки текстовых и графических данных.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Примеры использования текстовых функций</td></tr></table></div>&nbsp;</p>
В следующем примере фунция textptr используется для локализации текстового поля blurb книги с идентификатором BU7832 в таблице texttest. Текстовый указатель, являющийся 16-ти байтовой двоичной строкой, хранится в текстовой переменной @val и передается как параметр команде readtext. Эта команда возвращает 5 байтов текста, начиная со второго байта со смещением в один байт.</p>
&nbsp;</p>
create table texttest&nbsp; </p>
(title_id varchar(6), blurb text null, pub_id char(4))</p>
&nbsp;</p>
insert texttest values ("BU7832", "Straight Talk About Computers is an annotated</p>
 &nbsp;&nbsp;&nbsp;&nbsp; analysis of what computers can do for you: a no-hype guide for the critical user", </p>
 &nbsp;&nbsp;&nbsp;&nbsp; "1389") </p>
&nbsp;</p>
declare @val varbinary(16) </p>
select @val = textptr(blurb) from texttest where title_id = "BU7832" </p>
readtext texttest.blurb @val 1 5</p>
&nbsp;</p>
Фунция textptr возвращает 16-ти байтовый адрес. Целесообразно сохранить значение этого указателя в локальной переменной, как было показано, чтобы затем использовать его для ссылки на текстовое поле.</p>
Еще один способ (альтенативный использованию фунции textptr) связан&nbsp; с глобальной переменной @@textptr и приведен в следующем примере: </p>
&nbsp;</p>
create table texttest </p>
(title_id varchar(6),blurb text null, pub_id char(4))</p>
&nbsp;</p>
insert texttest values ("BU7832", "Straight Talk About Computers is an annotated</p>
 &nbsp;&nbsp;&nbsp;&nbsp; analysis of what computers can do for you: a no-hype guide for the critical user", </p>
 &nbsp;&nbsp;&nbsp;&nbsp; "1389") </p>
&nbsp;</p>
readtext texttest.blurb @@textptr 1 5</p>
&nbsp;</p>
Значение глобальной переменной @@textptr устанавливается при последнем по времени выполнении оператора вставки или обновления, который обращается к текстовому или графическому полю в текущем процессе SQL Сервера. Операторы модификации, выполняемые в других процессах, не влияют на эту переменную в текущем процессе.</p>
Для преобразования текстовых данных в типы char, nchar, varchar или nvarchar, а также для преобразования графических данных в типы binary или varbinary, необходимо явно выполнить функцию преобразования типов convert, но при этом текстовые или графические данные укорачиваются до 255 байтов. Не допускается преобразование текстовых и графических данных в другие типы ни явно, ни неявно.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Математические функции</td></tr></table></div>&nbsp;</p>
Встроенные математические функции предназначены для выполнения часто встречающихся математических операций.</p>
Вызов математических функций имеет следующий общий вид:</p>
&nbsp;</p>
название_функции(аргументы)</p>
&nbsp;</p>
В следующей таблице приведены типы аргументов, используемые во встроенных математических функциях.</p>
&nbsp;</p>
Таблица 10-6: Аргументы математических функций</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >Тип аргумента</p>
</td>
<td >Может быть заменен на</p>
</td>
</tr>
<tr >
<td >approx_numeric</p>
</td>
<td >Любое название табличного столбца приближенного числового типа (float, real, double precision), переменная, константа или выражение этого типа.</p>
&nbsp;</p>
</td>
</tr>
<tr >
<td >integer</p>
</td>
<td >Любое название табличного столбца целого типа (tinyint, smallint, int), переменная, константа или выражение этого типа.</p>
</td>
</tr>
<tr >
<td >numeric</p>
</td>
<td >Любое название табличного столбца приближенного числового (float, real, double precision), точного числового (numeric, dec, decimal, tinyint, smallint, int) или денежного (money) типа, переменная, константа или выражение этих типов или их комбинация.</p>
</td>
</tr>
<tr >
<td >power</p>
</td>
<td >Любое название табличного столбца приближенного числового, точного числового или денежного типа, переменная, константа или выражение этих типов или их комбинация.
</td>
</tr>
</table>
&nbsp;</p>
Каждой функции можно также задавать аргументы, которые неявно преобразуются к нужному типу. Например, функции, имеющие&nbsp; аргументы приближенного числового типа (approximate numeric), будут также работать и с аргументами целого типа. В этом случае SQL Сервер автоматически преобразует аргумент функции к нужному типу.</p>
Если функция имеет несколько аргументов одного типа, то они нумеруются по порядку (например, approx_numeric1, approx_numeric2).</p>
В следующей таблице приведены математические функции, их аргументы и возвращаемые результаты.</p>
&nbsp;</p>
Таблица 10-7:</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >Функция</p>
</td>
<td >Аргумент</p>
</td>
<td >Результат</p>
</td>
</tr>
<tr >
<td >abs</p>
</td>
<td >(numeric)</p>
</td>
<td >Возвращает абсолютную величину указанного выражения. Результат имеет тот же тип, точность и шкалу, что и аргумент.</p>
</td>
</tr>
<tr >
<td >acos</p>
</td>
<td >(approx_numeric)</p>
</td>
<td >Возвращает значение угла (в радианах), косинус которого равен указанной величине.</p>
</td>
</tr>
<tr >
<td >asin</p>
</td>
<td >(approx_numeric)</p>
</td>
<td >Возвращает значение угла (в радианах), синус которого равен указанной величине.</p>
</td>
</tr>
<tr >
<td >atan</p>
</td>
<td >(approx_numeric)</p>
</td>
<td >Возвращает значение угла (в радианах), тангенс которого равен указанной величине.</p>
</td>
</tr>
<tr >
<td >atn2</p>
</td>
<td >(approx_numeric1, approx_numeric2)</p>
</td>
<td >Возвращает значение угла (в радианах), тангенс которого равен частному от деления первого аргумента на второй.</p>
</td>
</tr>
<tr >
<td >ceiling</p>
</td>
<td >(numeric)</p>
</td>
<td >Возвращает наименьшее целое число, большее или равное указанной величине. Результат имеет тот же тип, что и аргумент. Для аргументов типа numeric и decimal результат будет иметь ту же точность, что и аргумент, и нулевую шкалу.</p>
</td>
</tr>
<tr >
<td >cos</p>
</td>
<td >(approx_numeric)</p>
</td>
<td >Возвращает значение тригонометрического косинуса указанного угла (заданного в радианах).</p>
</td>
</tr>
<tr >
<td >cot</p>
</td>
<td >(approx_numeric)</p>
</td>
<td >Возвращает значение тригонометрического котангеса указанного угла (заданного в радианах).</p>
</td>
</tr>
<tr >
<td >degrees</p>
</td>
<td >(numeric)</p>
</td>
<td >Преобразует радианы в градусы. Результат имеет тот же тип, что и аргумент. Для аргументов типа numeric и decimal результат будет иметь внутреннюю точность, равную 77 и шкалу, равную шкале аргумента. Когда аргумент имеет денежный тип, то внутреннее преобразование к типу float может привести к потере точности.</p>
</td>
</tr>
<tr >
<td >exp</p>
</td>
<td >(approx_numeric)</p>
</td>
<td >Возвращает экспоненту указанной величины.</p>
</td>
</tr>
<tr >
<td >floor</p>
</td>
<td >(numeric)</p>
</td>
<td >Возвращает целую часть числа (наибольшее целое число, меньшее или равное указанной величине). Результат имеет тот же тип, что и аргумент. Для аргументов типа numeric и decimal результат будет иметь ту же точность, что и аргумент, и нулевую шкалу.</p>
</td>
</tr>
<tr >
<td >log</p>
</td>
<td >(approx_numeric)</p>
</td>
<td >Возвращает натуральный логарифм указанной величины.</p>
</td>
</tr>
<tr >
<td >log10</p>
</td>
<td >(approx_numeric)</p>
</td>
<td >Возвращает десятичный логарифм указанной величины.</p>
</td>
</tr>
<tr >
<td >pi</p>
</td>
<td >()</p>
</td>
<td >Возвращает константу пи, равную 3.1415926535897931. </p>
</td>
</tr>
<tr >
<td >power</p>
</td>
<td >(numeric, power)</p>
</td>
<td >Возвращает значение степени, основанием которой является первый аргумент numeric, а показателем второй аргумент power. Для выражений типа numeric и decimal результат будет иметь внутреннюю точность, равную 77 и шкалу, равную шкале выражения.</p>
</td>
</tr>
<tr >
<td >radians</p>
</td>
<td >(numeric_expr)</p>
</td>
<td >Преобразует градусы в радианы. Результат имеет тот же тип, что и аргумент. Для аргументов типа numeric и decimal результат будет иметь внутреннюю точность, равную 77 и шкалу, равную шкале аргумента. Когда аргумент имеет денежный тип, то внутреннее преобразование к типу float может привести к потере точности.</p>
</td>
</tr>
<tr >
<td >rand</p>
</td>
<td >([integer])</p>
</td>
<td >Возвращает случайное число, заключенное между 0 и 1. Необязательный аргумент используется в качестве параметра.</p>
</td>
</tr>
<tr >
<td >round</p>
</td>
<td >(numeric, integer)</p>
</td>
<td >Округляет первый аргумент numeric до указанного числа (integer) значящих цифр. Если второй аргумент положителен, то он определяет число&nbsp; знаков после десятичной точки. Если второй аргумент отрицателен, то он определяет число&nbsp; знаков до десятичной точки. Результат имеет тот же тип, что и первый аргумент и для выражений типа numeric и decimal будет иметь внутреннюю точность, равную 77, а шкалу, равную шкале этого выражения.</p>
</td>
</tr>
<tr >
<td >sign</p>
</td>
<td >(numeric)</p>
</td>
<td >Возвращает знак аргумента, а именно возвращает +1, если он положителен, ноль, если он равен нулю (0) и -1, если он отрицателен. Результат имеет тот же тип и ту же точность и шкалу, что и аргумент.</p>
</td>
</tr>
<tr >
<td >sin</p>
</td>
<td >(approx_numeric)</p>
</td>
<td >Возвращает значение тригонометрического синуса указанного угла (заданного в радианах).</p>
</td>
</tr>
<tr >
<td >sqrt</p>
</td>
<td >(approx_numeric)</p>
</td>
<td >Возвращает значение квадратного корня указанной величины.</p>
</td>
</tr>
<tr >
<td >tan</p>
</td>
<td >(approx_numeric)</p>
</td>
<td >Возвращает значение тригонометрического тангеса указанного угла (заданного в радианах).
</td>
</tr>
</table>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Примеры использования математических функций</td></tr></table></div>&nbsp;</p>
Встроенные математические функции работают с числовыми данными. Аргументы этих функций должны иметь целочисленный или приближенный тип. Многие функции выполняются с точными или приближенными числовыми значениями, или с данными денежного типа. Точность вычисления встроенных функций для данных типа float составляет по умолчанию&nbsp; 6 десятичных знаков.</p>
При вычислении математических функций предусматривается реакция на возникновение ситуаций, связанных с ошибками в типах данных или выходом за указанный диапазон. Пользователь может установить опции arithabot или arithignore, чтобы определить вид ошибки, возникшей при вычислении функции. Более подробно об этих опциях будет рассказано в разделе “Ошибки преобразования”.</p>
Ниже приведены простые примеры вычисления математических функций:&nbsp; </p>
&nbsp;</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >Функция</p>
</td>
<td >Результат</p>
</td>
</tr>
<tr >
<td >select floor(123)</p>
</td>
<td >123</p>
</td>
</tr>
<tr >
<td >select floor(123.45)</p>
</td>
<td >123.000000</p>
</td>
</tr>
<tr >
<td >select floor(1.2345E2)</p>
</td>
<td >123.000000</p>
</td>
</tr>
<tr >
<td >select floor(-123.45)</p>
</td>
<td >-124.000000</p>
</td>
</tr>
<tr >
<td >select floor(-1.2345E2)</p>
</td>
<td >-124.000000</p>
</td>
</tr>
<tr >
<td >select floor($123.45)</p>
</td>
<td >123.00</p>
</td>
</tr>
<tr >
<td >select ceiling(123.45)</p>
</td>
<td >124.000000</p>
</td>
</tr>
<tr >
<td >select ceiling(-123.45)</p>
</td>
<td >-123.000000</p>
</td>
</tr>
<tr >
<td >select ceiling(1.2345E2)</p>
</td>
<td >124.000000</p>
</td>
</tr>
<tr >
<td >select ceiling(-1.2345E2)</p>
</td>
<td >-123.000000</p>
</td>
</tr>
<tr >
<td >select ceiling($123.45)</p>
</td>
<td >124.00 </p>
</td>
</tr>
<tr >
<td >select round(123.4545, 2)</p>
</td>
<td >123.4500</p>
</td>
</tr>
<tr >
<td >select round(123.45, -2)</p>
</td>
<td >100.00</p>
</td>
</tr>
<tr >
<td >select round(1.2345E2, 2)</p>
</td>
<td >123.450000</p>
</td>
</tr>
<tr >
<td >select round(1.2345E2, -2)</p>
</td>
<td >100.000000
</td>
</tr>
</table>
&nbsp;</p>
Функция round(numeric,integer) всегда возвращает некоторую величину. Если второй аргумент (integer) отрицателен и по величине превосходит число значащих цифр в первом аргументе (numeric), то SQL Сервер округляет только&nbsp; старший разряд. Например следующий оператор:</p>
&nbsp;</p>
select round(55.55, -3)</p>
&nbsp;</p>
возвращает число 100.000000. (Число разрядов после десятичной точки равно шкале первого аргумента numeric.)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Календарные функции</td></tr></table></div>&nbsp;</p>
Встроенные календарные функции используются для получения информации о датах и времени. Они выполняют арифметические операции над&nbsp; данными типа datatime и smalldatetime.</p>
Каледарные функции можно использовать в списке выбора оператора select, в конструкции where, а также в любом месте, где допускаются выражения.</p>
Данные типа datatime представляются в SQL Сервере двумя 4-х байтовыми целыми числами. Первые четыре байта предназначены для хранения числа дней перед или после базовой даты, которая для этой системы установлена на 1 января 1900 года. Тип данных datatime не допускает дат, предшествующих 1 января 1753. Вторые четыре байта внутреннего представления даты предназначены для хранения моментов времени с точностью до 1/3000 доли секунды.</p>
Данные типа smalldatetime представляют даты и моменты времени с меньшей точностью чем данные типа datatime. Данные типа smalldatetime  представляются двумя 2-х байтовыми целыми числами. В первых двух байтах хранится число дней после 1 января 1900 года. В следующих двух байтах хранится число минут, прошедших после полуночи до указанного момента времени. Таким образом, с помощью данных этого типа можно представлять даты из диапазона от 1 января 1900 года до 6 июня 2079 года с точностью до минуты.</p>
Формат вывода дат, принимаемый по умолчанию, выглядит следующим образом:</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Apr 15 1987 10:23PM</p>
&nbsp;</p>
В одном из последующих разделов этой главы, в котором рассматривается функция преобразования типов convert, будет дана информация об изменении форматов вывода даты для типов данных datatime и smalldatetime. Когда вводятся данные этих типов, их следует заключать в простые или двойные кавычки. SQL Сервер распознает большое число форматов для данных типа даты и времени. Дополнительную информацию о данных типа datatime и smalldatetime можно посмотреть в главе 7 “Создание баз данных и таблиц” и главе 8 “Добавление, изменение и удаление данных”.</p>
В следующей таблице приведены календарные функции и их результаты. </p>
&nbsp;</p>
Таблица 10-9: Календарные функции</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >Функция</p>
</td>
<td >Аргумент</p>
</td>
<td >Результат </p>
</td>
</tr>
<tr >
<td >getdate</p>
</td>
<td >()</p>
</td>
<td >Текущая дата и время.</p>
</td>
</tr>
<tr >
<td >datename</p>
</td>
<td >(datepart,date)</p>
</td>
<td >Возвращает указанную часть значения типа datatime и smalldatetime как строку символов (ASCII строку).&nbsp; </p>
</td>
</tr>
<tr >
<td >datepart</p>
</td>
<td >(datepart,date)</p>
</td>
<td >Возвращает указанную часть значения типа datatime и smalldatetime, например, месяц, день или час, как целое число.&nbsp; </p>
</td>
</tr>
<tr >
<td >datediff</p>
</td>
<td >(datepart,date, date)</p>
</td>
<td >Количество времени между первой и второй датами, выраженное в месяцах, днях или часах.</p>
</td>
</tr>
<tr >
<td >dateadd</p>
</td>
<td >(datepart,number,date)</p>
</td>
<td >Дата, полученная из указанной даты добавлением указанного временного интервала.
</td>
</tr>
</table>
&nbsp;</p>
Функции datename, datepart и dateadd получают в качестве аргумента часть даты, т.е. год, месяц, час и т.д. В следующей таблицы перечислены части даты, их сокращения (если оно есть) и возможные целочисленные значения для этой части. Функция datename выдает строку символов там, где это имеет смысл, например, для названия дней недели.</p>
&nbsp;</p>
Таблица 10-10: Части даты</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >Часть даты</p>
</td>
<td >Сокращение</p>
</td>
<td >Интервал значений</p>
</td>
</tr>
<tr >
<td >year</p>
</td>
<td >yy</p>
</td>
<td >1753-9999 </p>
</td>
</tr>
<tr >
<td >quarter</p>
</td>
<td >qq</p>
</td>
<td >1 - 4 </p>
</td>
</tr>
<tr >
<td >month</p>
</td>
<td >mm</p>
</td>
<td >1 - 12 </p>
</td>
</tr>
<tr >
<td >week</p>
</td>
<td >wk</p>
</td>
<td >1 - 366 </p>
</td>
</tr>
<tr >
<td >day</p>
</td>
<td >dd</p>
</td>
<td >1 - 31 </p>
</td>
</tr>
<tr >
<td >dayofyear</p>
</td>
<td >dy</p>
</td>
<td >1 - 54 </p>
</td>
</tr>
<tr >
<td >weekday</p>
</td>
<td >dw</p>
</td>
<td >1 - 7 (Воскресенье 1 день для us_english).</p>
</td>
</tr>
<tr >
<td >hour</p>
</td>
<td >hh</p>
</td>
<td >0 - 23 </p>
</td>
</tr>
<tr >
<td >minute</p>
</td>
<td >mi</p>
</td>
<td >0 - 59 </p>
</td>
</tr>
<tr >
<td >second</p>
</td>
<td >ss</p>
</td>
<td >0 - 59 </p>
</td>
</tr>
<tr >
<td >millisecond</p>
</td>
<td >ms</p>
</td>
<td >0 - 999
</td>
</tr>
</table>
&nbsp;</p>
Заметим, что названия дней недели могут зависеть от установленного языка (language setting).</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Получение текущей даты: getdate</td></tr></table></div>&nbsp;</p>
Функция getdate возвращает текущую дату и время во внутреннем формате SQL Сервера, который используется данных типа datatime и smalldatetime. Эта функция не имеет аргументов, поэтому при ее вызове нужно указать только скобки ().</p>
Например, чтобы определить текущую дату и время, можно выполнить следующий оператор:</p>
&nbsp;</p>
select getdate() </p>
&nbsp;</p>
-------------------------- </p>
Jul 29 1991&nbsp; 2:50&nbsp; PM</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
Эту функцию можно использовать при печати отчетов, чтобы текущая дата автоматически печалась в момент вывода отчета. Эта функция также полезна для регистрации моментов выполнения транзакции.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Получение частей даты в виде числа или строки</td></tr></table></div>&nbsp;</p>
Функции datepart и datename возвращают указанную часть даты, т.е. год, квартал, день, час и т.д., либо в виде числа, либо в виде строки символов. Поскольку данные типа smalldatetime представляют время только с точностью до минут, то, когда в качестве аргумента этих функций используются данные этого типа, количество секунд и миллисекунд всегда равно нулю.</p>
В следующих примерах предполагается, что текущей датой является 29 июля, как и в предыдущем примере. </p>
&nbsp;</p>
select datepart(month, getdate()) </p>
--------------</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7 </p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
select datename(month, getdate()) </p>
------------- </p>
July</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Вычисленные календарных интервалов</td></tr></table></div>&nbsp;</p>
Функция datediff вычисляет промежуток времени между указанными второй и первой датами, другими словами она находит календарный интервал между двумя датами. Результатом будет целое число со знаком, являющееся разностью между указанными частями второй и первой даты (date2 - date1).</p>
В следующем запросе используется дата, равная 30 ноября 1985 года, для подсчета числа дней между этой датой и датами публикации книг, находящимися в столбце pubdate:&nbsp; </p>
&nbsp;</p>
select newdate = datediff(day, pubdate, "Nov 30 1985") </p>
from titles </p>
&nbsp;</p>
Для книги, опубликованной 21 октября 1985 года, в предыдущем запросе будет получено число 40, т.е. число дней между 21 октября и 30 ноября. В следующем запросе календарный интервал вычисляется в месяцах: </p>
&nbsp;</p>
select interval = datediff(month, pubdate,&nbsp; "Nov 30 1985") </p>
from titles</p>
&nbsp;</p>
Этот запрос укажет интервал в 1 месяц для книг, опубликованных в октябре, и 5 месяцев для книг, опубликованных в июне. Если первый аргумент функции datediff является более поздней датой по сравнению со вторым, то результат будет отрицательным. Поскольку для двух книг в таблице titles по умолчанию в столбце pubdate была указана функция getdate, то для них в этом столбце будет указана дата создания базы данных pubs. По этой причине в предыдущих запросах для этих книг будут получены отрицательные результаты.</p>
Если один или оба аргумента этой функции имеют тип smalldatetime, то в процессе ее выполнения они преобразуются к типу datetime, чтобы вычисление было более точным. Секунды и миллисекунды для этого типа автоматически устанавливаются равными нулю при вычислении временного интервала. </p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Добавление календарного интервала: dateadd</td></tr></table></div>&nbsp;</p>
Функция dateadd добавляет календарный интервал к указанной дате. Например, даты публикации всех книг из таблицы titles, увеличенные на три дня, можно получить с помощью следующего оператора:</p>
&nbsp;</p>
select dateadd(day, 3, pubdate) </p>
from titles </p>
&nbsp;</p>
----------------------- </p>
Jun 15 1985 12:00AM </p>
Jun 12 1985 12:00AM </p>
Jul&nbsp;&nbsp; 3 1985 12:00AM </p>
Jun 25 1985 12:00AM </p>
Jun 12 1985 12:00AM </p>
Jun 21 1985 12:00AM </p>
Sep 11 1986 11:02AM </p>
Jul&nbsp;&nbsp; 3&nbsp; 1985 12:00AM </p>
Jun 15 1985 12:00AM </p>
Sep 11 1986 11:02AM </p>
Oct 24 1985 12:00AM </p>
Jun 18 1985 12:00AM </p>
Oct&nbsp; 8 1985 12:00AM </p>
Jun 15 1985 12:00AM </p>
Jun 15 1985 12:00AM </p>
Oct 24 1985 12:00AM </p>
Jun 15 1985 12:00AM </p>
Jun 15 1985 12:00AM</p>
&nbsp;</p>
(Выбрано 18 строк)</p>
&nbsp;</p>
Если в качестве аргумента этой функции указана дата типа smalldatetime, то результат также будет иметь этот тип. Фунцию dateadd можно использовать для добавления секунд или миллисекунд к дате типа smalldatetime, но результат будет иметь смысл только в том случае, если добавляется больше одной минуты.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Функции преобразования типов данных</td></tr></table></div>&nbsp;</p>
Функции преобразования типов данных, как следует из их названия, преобразуют типы выражений из одного типа в другой и переформатируют информацию о датах и времени. SQL Сервер автоматически выполняет некоторые преобразования типов. Это называется неявным (implicit) преобразованием. Например, если пользователь сравнивает выражение типа char с выражением типа datetime, или выражение типа smallint с выражением типа int, или выражения типа char, имеющие различную длину, то SQL Сервер автоматически преобразует эти типы друг к другу.</p>
Другие преобразования пользователь должен выполнять явно (explicitly), используя встроенные функции преобразования типов данных. Например, перед конкатенацией числовых выражений, их необходимо преобразовать к строковому типу.</p>
SQL Сервер имеет три функции преобразования типов: convert (преобразовать), inttohex (целое в 16-ричное), hextoint (16-ричное в целое). Эти функции можно использовать в списке выбора, в предложении where, и везде, где допускаются выражения.</p>
SQL Сервер не допускает некоторых преобразований типов данных. Например, нельзя преобразовать тип smallint к типу datetime или наоборот. Попытка выполнения недопустимого преобразования приводит к сообщению об ошибке.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Допустимые преобразования</td></tr></table></div>&nbsp;</p>
На рисунке 10-1 показаны преобразования типов данных, поддерживаемые SQL Сервером:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="19">&#183;</td><td>Преобразования, помеченные буквой “I”, выполняются автоматически (неявно). Для них можно не указывать функции преобразования типа, хотя использование функции convert в этих случаях не является ошибкой;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="19">&#183;</td><td>Преобразования, помеченные буквой “Е”, должны выполняться пользователем явным образом с помощью соответствующей функции преобразования типов;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="19">&#183;</td><td>Преобразования, помеченные буквой “IЕ”, выполняются автоматически в том случае, если при преобразовании не теряется точность или шкала и&nbsp; установлена опция arithabort numeric_truncation, в противном случае эти преобразования нужно выполнить явно.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="19">&#183;</td><td>Преобразования, помеченные буквой “U”, недопустимы и не поддерживаются SQL Сервером. Если пользователь попытается выполнить такое преобразование, то SQL Сервер выдаст сообщение об ошибке;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="19">&#183;</td><td>Преобразования типа к самому себе, помещены символом “_”. В общем случае SQL Сервер допускает явное преобразование типа к самому себе, но такие преобразования не имют смысла.<img src="/pic/embim1735.png" width="488" height="461" vspace="1" hspace="1" border="0" alt=""></td></tr></table></div>Рис. 10-1: Явные, неявные и недопустимые преобразования типов данных</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Использование функции convert</td></tr></table></div>&nbsp;</p>
Функция преобразования общего назначения convert предназначена для выполнения разнообразных преобразований типов данных и изменения форматов представления даты и времени. Она имеет следующий общий вид:</p>
&nbsp;</p>
convert(тип_данных, выражение [, стиль] ) </p>
&nbsp;</p>
В следующем примере функция преобразования используется в списке выбора:</p>
&nbsp;</p>
select title, convert(char(5), total_sales) </p>
from titles </p>
where type = "trad_cook" </p>
&nbsp;</p>
title </p>
-----------------------------------------------------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------- </p>
Onions, Leeks, and Garlic: Cooking</p>
 Secrets of the Mediterranean&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; 125 </p>
Fifty Years in Buckingham Palace </p>
Kitchens&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  15096 </p>
Sushi, Anyone?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5405</p>
&nbsp;</p>
(Выбрано 3 строки) </p>
&nbsp;</p>
В этом примере данные из столбца total_sales, имеющие тип int, преобразуются к типу char(5), чтобы их можно использовать при поиске по образцу с ключевым словом like:</p>
&nbsp;</p>
select title, total_sales </p>
from titles </p>
where convert(char(5), total_sales) like "15%"&nbsp; and type = "trad_cook"</p>
&nbsp;</p>
title </p>
----------------------------------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------- </p>
Fifty Years in Buckingham Palace</p>
 Kitchens&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 15096</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
Некоторые типы данных имеют либо длину, либо точность и шкалу. Если длина не указана, то SQL Сервер по умолчанию устанавливает длину, равную 30 символам, для строковых и двоичных данных. Если не указана точность или шкала, то SQL Сервер по умолчанию устанавливает для них значения 18 и 0 соответственно.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Правила преобразования</td></tr></table></div>&nbsp;</p>
В следующих разделах описываются правила преобразования, которых нужно придерживаться при преобразовании различных типов информации.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Преобразование строковых данных к нестроковому типу</td></tr></table></div>&nbsp;</p>
Строку символов можно преобразовать к нестроковому типу, такому как денежный тип, тип даты или времени, приближенный числовый тип, если все символы этой строки являются допустимыми для нового типа. Начальные пробелы при этом игнорируются. Если строка содержит недопустимые символы, то выдается сообщение о синтаксической ошибке. Ниже приводятся несколько примеров, когда выдаются сообщения о синтаксических ошибках:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="19">&#183;</td><td>Запятая или точка в данных целого типа;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="19">&#183;</td><td>Запятая в данных денежного типа;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="19">&#183;</td><td>Буквы в данных точного или приближенного числового типа или в строке битов;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="19">&#183;</td><td>Неправильное название месяца в данных типа даты.</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Преобразование одного строкового типа к другому</td></tr></table></div>&nbsp;</p>
Когда преобразуются символы из мультибайтового алфавита в однобайтовый, то символы, не имеющие эквивалента в однобайтовом алфавите, заменяются пробелами.</p>
Текстовые данные (text) можно явно преобразовывать в типы char, nchar, varchar и nvarchar. Максимальная длина строковых типов данных составляет 255 байтов. Если длина строки не указана, то по умолчанию устанавливается длина, равная 30 байтам.</p>
&nbsp;</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Преобразование чисел к строковому типу</td></tr></table></div>&nbsp;</p>
Как точные, так и приближенные числовые значения можно преобразовывать к строковому типу. Если длина строки не позволяет разместить все цифры числа, то выдается сообщение о недостаточности этой длины. Например, при попытке разместить 5 байтовое число в одном байте выдается следующее сообщение об ошибке: </p>
&nbsp;</p>
select convert(char(1), 12.34)</p>
&nbsp;</p>
Insufficient result space for explicit conversion </p>
of NUMERIC value '12.34' to a CHAR field.</p>
&nbsp;</p>
(Недостаточно места для размещения числового</p>
 значения “12.34” в строковом поле).</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Округление при преобразовании к денежному типу</td></tr></table></div>&nbsp;</p>
Денежные типы данных money и smallmoney позволяют сохранять четыре знака после десятичной точки, но при выводе они округляются до сотых долей (0.01) денежной единицы. Когда данные преобразуются к денежному типу, то они округляются до четырех знаков в дробной части.</p>
Значения, которые преобразуются из денежного типа, округляются таким же образом, если это возможно. Если денежное значение преобразуется к точному числовому типу с менее чем тремя знаками после точки, то оно округляется в соответствии со шкалой, определенной для этого типа. Например, значение $4.50 преобразуется в целое число следующим образом:</p>
&nbsp;</p>
select convert(int, $4.50)</p>
----------- </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4</p>
&nbsp;</p>
Предполагается, что значения, преобразуемые к денежному типу, измеряются в полных (основных) денежных единицах, т.е. в долларах, а не в центах. Например, если установлена языковая опция (опция страны) us_english (американский английский), то целое число 4 эквивалентно 4 долларам, а не 4 центам.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Преобразование дат и моментов времени</td></tr></table></div>&nbsp;</p>
Значения, эквивалентные календарным датам, можно преобразовывать к типам datetime и smalldatetime. Неправильно указанное название месяца приводит к сообщениям о синтаксической ошибке. Данные, которые не попадают в диапазон значений календарного типа, вызывают сообщение об арифметическом переполнении.</p>
Когда значение типа datetime преобразуется к типу smalldatetime, то оно округляется до минут.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Преобразование числовых типов</td></tr></table></div>&nbsp;</p>
Числовые значения можно преобразовывать из одного типа в другой. Если значение преобразуется к точному числовому типу и установленная для него точность и шкала являются недостаточными для размещения нового числа, то может появиться сообщение об ошибке. Пользователь может использовать опции arithabort и arithignore, чтобы подготовить реакцию на возникновение этой ситуации.</p>
&nbsp;</p>
Замечание. Опции arithabort и arithignore были переопределены в версии 10.0 SQL Сервера. Если пользователь использует эти опции в своем приложении, то необходимо убедиться в том, что они соответствуют своему функциональному назначению. </p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Преобразование двоичных типов</td></tr></table></div>&nbsp;</p>
Типы данных SQL Сервера binary и varbinary зависят от аппаратной платформы, т.е. от аппаратуры компьютера. На некоторых платформах первый байт, следующий за префиксом 0х, является старшим, а на других - младшим.</p>
Функция convert трактует двоичные данные как строки символов, а не как числовые значения. Эта функция не учитывает, принятое для данной платформы, старшинство байтов, когда преобразует двоичное значение к целому числу или наоборот. Поэтому результат преобразования может быть различным на различных платформах.</p>
Перед тем как преобразовать двоичную строку в целое число, функция convert удаляет начальный префикс 0х. Если строка состоит из нечетного числа цифр, то впереди добавляется 0. Если строка слишком велика для целого типа, то функция convert укорачивает ее. Если значение слишком мало, то функция convert выравнивает его вправо и добавляет нули.</p>
Предположим, что надо преобразовать строку 0х00000100 в целое число. На некоторых платформах эта строка представляет число 1, на других число 256. В зависимости от того, на какой платформе выполняется функция convert, результат будет равен 1 или 256. </p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Преобразование шестнадцатиричных данных</td></tr></table></div>&nbsp;</p>
Для того, чтобы результат преобразования не зависел от платформы, следует использовать функции hextoint и inttohex.</p>
Аргументами функции hextoint являются литералы или переменные, состоящие из цифр и букв от A до F (заглавных или строчных) с префиксом 0х или без него. Ниже приводятся примеры допустимых аргументов для функции hextoint:</p>
&nbsp;</p>
hextoint("0x00000100FFFFF")</p>
hextoint("0x00000100")</p>
hextoint("100")</p>
&nbsp;</p>
Функция hextoint удаляет у них префикс 0х. Если строка состоит более чем из восьми цифр, то функция hextoint укорачивает ее. Если длина строки меньше восьми, то функция hextoint выравнивает ее вправо и добавляет впереди нули. Затем функция hextoint вычисляет эквивалентное целое число, которое не зависит от платформы. Для вышеуказанного значения всегда будет выдаваться число 256 независимо от платформы.</p>
Функция inttohex преобразует целое число в шестнадцатиричную строку из 8 символов без префикса 0х. Функция inttohex также возвращает всегда одно и то же значение независимо от платформы.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Преобразование графических данных в тип binary и varbinary </td></tr></table></div>&nbsp;</p>
Пользователь может использовать функцию convert для преобразования графических данных типа image в данные типа binary или varbinary. Ограничением здесь является длина строки для типа binary, которая должна быть не больше 255 байтов. Если длина не указывается, то по умолчанию устанавливается длина в 30 символов.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Ошибки преобразования</td></tr></table></div>&nbsp;</p>
В следующих разделах, описываются ошибки, которые могут возникнуть при преобразовании данных.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Арифметическое переполнение и деление на ноль</td></tr></table></div>&nbsp;</p>
Ошибка, связанная с делением на ноль, может возникнуть, если число делится на ноль. Ошибки, связанные с арифметическим переполнением, могут возникнуть, если новый тип данных не позволяет разместить все цифры результата. Переполнение может возникнуть в следующих ситуациях:&nbsp;&nbsp; </p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="19">&#183;</td><td>При явном или неявном преобразовании точных числовых типов, когда указаны слишком маленькие значения для точности или шкалы;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="19">&#183;</td><td>При явном или неявном преобразовании данных, когда результирующее значение не попадает в диапазон, отведенный для денежного или календарного типа;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="19">&#183;</td><td>При преобразовании строк с длиной большей 4-х байтов с помощью функции hextoint.</td></tr></table></div>&nbsp;</p>
Как ошибки переполнения, так и деление на ноль, рассматриваются как серьезные ошибки, даже если они возникли в процессе явного или неявного преобразования. В этом случае следует использовать опцию arithabort arith_overflow, чтобы указать SQL Серверу как обработать эту ошибку. По умолчанию опция arithabort arith_overflow является включенной, что вызывает откат всей транзакции или всего пакета, в котором произошла такая ошибка. Если выключить опцию arithabort arith_overflow, то SQL Сервер прервет лишь выполнение текущего оператора, в котором появилась ошибка, но продолжит процесс выполнения других операторов в транзакции или в пакете. Пользователь может использовать глобальную переменную @@error, чтобы проверить результаты ошибочного оператора.</p>
Опция arithignore arith_overflow определяет должен ли SQL Сервер выводить сообщение об ошибке после появления таких ошибок. По умолчанию эта опция выключена, т.е. выводится предупреждающее сообщение об ошибке при делении на ноль или потере точности. Включив эту опцию, можно устранить предупреждающее сообщение после появления таких ошибок. Необязательное ключевое слово arith_overflow можно не указывать в этих опциях.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Ошибки при выборе шкалы</td></tr></table></div>&nbsp;</p>
Если в процессе явного преобразования происходит переполнение шкалы, то результаты округляются без предупреждающего сообщения. Например, если пользователь явно преобразует один из типов float, numeric или decimal в целый тип, то SQL Сервер автоматически отбрасывает дробную часть числа.</p>
В процессе неявного преобразования типов numeric или decimal переполнение шкалы вызывает сообщение об ошибке. В этом случае следует использовать опцию arithabort numeric_truncation, чтобы указать насколько серьезной нужно считать эту ошибку. По умолчанию опция arithabort numeric_truncation, включена, что вызывает прерывание ошибочного оператора, но разрешает дальнейшее выполнение других операторов в транзакции или пакете. Если эта опция выключена, то SQL Сервер автоматически округляет результат и продолжает обработку запроса.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Ошибки при выборе диапазона</td></tr></table></div>&nbsp;</p>
Функция convert выдает сообщение об ошибке диапазона (области), когда аргумент этой функции не попадает в определенный для него диапазон. Это случается достаточно редко.</p>
&nbsp;</p>
Преобразования между двоичными и целыми типами данных</p>
&nbsp;</p>
Данные типа binary и varbinary можно рассматривать как шестнадцатиричные числа, состоящие из префикса 0х, за которым следует строка из цифр и букв. Эти числа интерпретируются различным образом на различных платформах. Например, строка 0х0000100 представляет число 65536 на платформах, у которых нулевой байт является самым старшим, и число 256 на платформах, у которых нулевой байт является самым младшим.</p>
&nbsp;</p>
Функция convert и неявные преобразования </p>
&nbsp;</p>
Данные двоичного типа могут преобразовываться в целые числа как явно с использованием функции convert, так и неявно. При этом от двоичного значения отбрасывается префикс 0х, затем добавляются слева нули, если оно слишком короткое, или отбрасываются лишняя часть, если оно слишком длинное.</p>
Как явное, так и неявное преобразование двоичных типов зависит от платформы. По этой причине результат преобразования может быть различным на различных платформах. Чтобы сделать эти результаты независимыми от платформы, следует использовать функцию hextoint при преобразовании 16-ричных строк в целые числа и функцию inttohex при обратном преобразовании.</p>
&nbsp;</p>
Функция hextoint</p>
&nbsp;</p>
Функция hextoint выполняет независимое от платформы преобразование 16-ричных строк в целые числа. Эта функция получает в качестве аргумента правильную 16-ричную строку с префиксом 0х или без него, заключенную в скобки, или название переменной, или название столбца строкового типа.</p>
Функция hextoint возвращает целое число, эквивалентное 16-ричной строке. Функция hextoint возвращает всегда одно и то же эквивалентное целочисленное значение независимо от платформы. </p>
&nbsp;</p>
Функция inttohex</p>
&nbsp;</p>
Функция inttohex выполняет независимое от платформы преобразование целых чисел в 16-ричные строки. Аргументом этой функции может быть любое выражение, имеющее целочисленное значение. Эта функция всегда возвращает одну и ту же эквивалентную заданному аргументу 16-ричную строку независимо от платформы.</p>
&nbsp;</p>
Преобразование графических данных в двоичный вид</p>
&nbsp;</p>
Функция convert может использоваться для преобразования графических данных (image) в типы binary и varbinary. Единственным ограничением здесь является длина двоичных данных, которая должна быть не больше 255 байтов. Если длина двоичной строки не указывается, то по умолчанию она устанавливается равной 30 символам.</p>
&nbsp;</p>
Преобразование других типов данных в битовый тип</p>
&nbsp;</p>
Точные и приближенные числовые типы могут преобразовываться к битовому типу неявно. Строковые типы нужно явно конвертировать в битовый тип с помощью функции convert.</p>
Преобразуемое строковое выражение может содержать только цифры, десятичную точку, символ валюты, а также знаки плюс и минус. Присутствие других символов недопустимо и вызывает сообщение о синтаксической ошибке. Битовый эквивалент нуля равен 0. Битовый эквивалент любого другого числа равен 1.</p>
&nbsp;</p>
Изменение форматов представления даты</p>
&nbsp;</p>
Параметр style (стиль) функции convert предоставляет возможность выбора большого числа форматов для представления данных типа datetime и smalldatetime, когда они преобразуются в типы char и varchar. Числовой аргумент этой функции указывает номер стиля и тем самым влияет на форму представления данных. Например, год в дате может представляться двумя или четырьмя цифрами. Чтобы год выводился в формате (yyyy), т.е. четырьмя цифрами с указанием столетия (века), нужно прибавить число 100 к значению параметра style.</p>
В следующей таблице указаны возможные значения парметра style и связанные с этим значением форматы представления даты. Если этот параметр используется с данными типа smalldatetime, то в форматах, содержащих значения секунд и миллисекунд, будут выводиться нули на соответствующих местах.</p>
&nbsp;</p>
Таблица 10-11: Значения стилевого параметра, определяющего формат даты</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >Без века</p>
(уу)</p>
</td>
<td >С веком</p>
(уууу)</p>
</td>
<td >Стандарт</p>
</td>
<td >Выходной формат</p>
</td>
</tr>
<tr >
<td >-</p>
</td>
<td >0 или 100</p>
</td>
<td >По умолчанию</p>
</td>
<td >мес дд гггг ча:ми AM (PM)</p>
</td>
</tr>
<tr >
<td >1</p>
</td>
<td >101</p>
</td>
<td >США</p>
</td>
<td >мм/дд/гг</p>
</td>
</tr>
<tr >
<td >2</p>
</td>
<td >2</p>
</td>
<td >SQL стандарт</p>
</td>
<td >гг.мм.дд</p>
</td>
</tr>
<tr >
<td >3</p>
</td>
<td >103</p>
</td>
<td >Англия/Франция</p>
</td>
<td >дд/мм/гг</p>
</td>
</tr>
<tr >
<td >4</p>
</td>
<td >104</p>
</td>
<td >Германия/Россия</p>
</td>
<td >дд.мм.гг</p>
</td>
</tr>
<tr >
<td >5</p>
</td>
<td >105</p>
</td>
<td >&nbsp;</p>
</td>
<td >дд-мм-гг</p>
</td>
</tr>
<tr >
<td >6</p>
</td>
<td >106</p>
</td>
<td >&nbsp;</p>
</td>
<td >дд мес гг</p>
</td>
</tr>
<tr >
<td >7</p>
</td>
<td >107</p>
</td>
<td >&nbsp;</p>
</td>
<td >мес дд, гг</p>
</td>
</tr>
<tr >
<td >8</p>
</td>
<td >108</p>
</td>
<td >&nbsp;</p>
</td>
<td >ча:ми:се</p>
</td>
</tr>
<tr >
<td >-</p>
</td>
<td >109</p>
</td>
<td >По умолчанию + мс</p>
</td>
<td >мес дд гггг ча:ми:мсе AM (PM)</p>
</td>
</tr>
<tr >
<td >10</p>
</td>
<td >110</p>
</td>
<td >США</p>
</td>
<td >мм-дд-гг</p>
</td>
</tr>
<tr >
<td >11</p>
</td>
<td >111</p>
</td>
<td >Япония</p>
</td>
<td >гг/мм/дд</p>
</td>
</tr>
<tr >
<td >12</p>
</td>
<td >112</p>
</td>
<td >ISO</p>
</td>
<td >ггммдд
</td>
</tr>
</table>
&nbsp;</p>
По умолчанию для стилевого параметра устанавливаются значения 0 или 100, а также 9 или 109, т.е. всегда указывается столетие (уууу) в дате.</p>
В следующем примере показано, как используется параметр style в функции convert:</p>
&nbsp;</p>
select convert(char(12), getdate(), 3)</p>
&nbsp;</p>
Этот оператор конвертирует текущую дату в строковый тип и представляет ее в соответствии с третьим форматом (style = 3), т.е. в виде дд/мм/гг.</p>
