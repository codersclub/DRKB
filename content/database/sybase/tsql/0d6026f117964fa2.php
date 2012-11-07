<h1>Использование сохраненных процедур</h1>
<div class="date">01.01.2007</div>


<p>Использование сохраненных процедур</p>
</p>
SQL операторы и команды языка управления заданиями можно использовать в сохраненных процедурах для того, чтобы улучшить работу SQL Сервера. Можно также использовать несколько заранее определенных процедур, называемых системными сохраненными процедурами, для выполнения административных функций и обновления системных таблиц.</p>
В этой главе обсуждаются следующие темы:</p>
</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Дается общий обзор сохраненных процедур;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Объясняется, как создавать и выполнять сохраненные процедуры;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Объясняется, как возвращать информацию из сохраненных процедур;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Приводятся правила, связанные с сохраненными процедурами;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Объясняется, как удалять и переименовывать сохраненные процедуры;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Описывается, как использовать системные сохраненные процедуры;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Объясняется, как получать информацию о сохраненных процедурах.</td></tr></table></div></p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Что такое сохраненные процедуры</td></tr></table></div></p>
Сохраненная процедура - это подпрограмма, состоящая из SQL операторов и команд языка управления заданиями. План выполнения процедуры подготавливается во время запуска процедуры, поэтому собственно выполнение процедуры происходит очень быстро. Сохраненная процедура может:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Содержать параметры (аргументы);</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Вызывать другие процедуры;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Возвращать свой статус вызывающей процедуре или пакету, указывающий на успешное окончание или ошибку, и в случае ошибки на ее причину;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Возвращать значения параметров вызывающей процедуре или пакету;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Выполняться на удаленном SQL Сервере.</td></tr></table></div></p>
Сохраненные процедуры значительно увеличивают мощность, эффективность и гибкость языка SQL. Скомпилированные процедуры  значительно ускоряют выполнение SQL-операторов и пакетов. Кроме того, сохраненные процедуры могут выполняться на другом SQL Сервере, если для обоих серверов допускается удаленная регистрация. Пользователь может написать триггер для своего локального SQL Сервера, который вызывает процедуры на удаленном сервере, при локальном выполнении таких операторов как удаление, обновление или вставка.</p>
Сохраненные процедуры отличаются от обычных SQL операторов и пакетов SQL операторов тем, что они заранее компилируются. Во время первого исполнения процедуры процессор запросов SQL Сервера анализирует процедуру и готовит план выполнения, который хранится в системной таблице. Впоследствии, процедура выполняется в соответствии с сохраненным планом. Поскольку основная часть обработки запросов при этом уже была выполнена, то сохраненные процедуры выполняются почти мгновенно.</p>
С SQL Сервером предоставляется большое число сохраненных процедур в качестве удобных инструментов для пользователя. Эти сохраненные процедуры называются системными сохраненными процедурами.</p>
Сохраненные процедуры создаются с помощью команды create procedure (создать процедуру). Для выполнения сохраненной процедуры, как системной, так и определенной пользователем, используется команда execute (выполнить). Можно также просто указать название сохраненной процедуры, если оно является первым словом в операторе или пакете.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Примеры создания и использования сохраненных процедур</td></tr></table></div></p>
Синтаксис для создания простой сохраненной процедуры без параметров выглядит так:</p>
</p>
create procedure название_процедуры</p>
    as SQL_операторы</p>
</p>
Сохраненные процедуры являются объектами базы данных и их название должны соответствовать правилам для идентификаторов.</p>
В сохраненной процедуре допускается использование любого числа SQL операторов  любого типа, за исключением операторов create (создать). См. раздел “Правила, связанные с сохраненными процедурами”. Сохраненная процедура может быть состоять из одного оператора, перечисляющего имена пользователей базы данных:</p>
</p>
create procedure namelist</p>
as select name from sysusers</p>
</p>
Для выполнения сохраненной процедуры нужно использовать ключевое слово execute, за которым следует название сохраненной процедуры, или просто указать название процедуры, если оно одно сообщается SQL Серверу, или является первым оператором в пакете. Процедура namelist может быть выполнена любым из следующих способов:</p>
</p>
namelist</p>
execute namelist</p>
exec namelist</p>
</p>
Для выполнения сохраненной процедуры на удаленном SQL Сервере необходимо указать название сервера. Полный синтаксис вызова удаленной процедуры выглядит так:</p>
</p>
execute название_сервера.[название_базы_данных].[владелец].название_процедуры</p>
</p>
В следующих примерах процедура namelist из базы данных pubs2 выполняется на удаленном сервере GATEWAY:</p>
</p>
execute gateway.pubs2..namelist</p>
gateway.pubs2.dbo.namelist</p>
exec gateway...namelist</p>
</p>
Последний вариант будет работает только, если pubs2 является базой данных, заданной по умолчанию.</p>
Название базы данных является необязательным параметром только, если сохраненная процедура находится в базе данных заданной по умолчанию (default database). Имя владельца процедуры является необязательным только, если владельцем процедуры является владелец базы данных (“dbo”) или сам пользователь, вызывающий эту процедуру. Безусловно необходимо иметь разрешение (permission) для выполнения процедуры.</p>
Процедура может содержать несколько операторов.</p>
</p>
create procedure showall as</p>
select count(*) from sysusers</p>
select count(*) from sysobjects</p>
select count(*) from syscolumns</p>
</p>
Во время выполнения процедуры, результаты работы каждой команды выводятся в том порядке, в каком эти команды указаны в процедуре.</p>
</p>
showall</p>
</p>
------------</p>
           5</p>
</p>
(Выбрана 1 строка)</p>
</p>
------------</p>
          88</p>
</p>
(Выбрана 1 строка)</p>
</p>
------------</p>
</p>
         349</p>
</p>
(1 row affected, return status = 0)</p>
</p>
Если команда create procedure выполнилась успешно, то название процедуры заносится в таблицу sysobjects, а ее текст в syscomments.</p>
Текст процедуры может быть выведен с помощью системной процедуры sp_helptext:</p>
</p>
sp_helptext showall</p>
</p>
# Lines of Text</p>
---------------</p>
              1</p>
</p>
(1 row affected)</p>
</p>
text</p>
----------------------------- ----------</p>
create procedure showall as</p>
select count(*) from sysusers</p>
select count(*) from sysobjects</p>
select count(*) from syscolumns</p>
</p>
(1 row affected, return status = 0)</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Сохраненные процедуры и права доступа</td></tr></table></div></p>
Сохраненные процедуры могут служить в качестве механизма обеспечения секретности, поскольку пользователь может получить разрешение на выполнение сохраненной процедуры, даже в том случае если у него или  у нее нет разрешения на обращение к таблицам или вьюверам, к которым обращается процедура, или нет разрешения на выполнение определенных команд. Более детально этот вопрос обсуждается Руководстве пользователя по средствам ограничения доступа SQL Сервера (Security Features User&#8217;s Guide).</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Сохраненные процедуры и производительность</td></tr></table></div></p>
Во время изменения базы данных можно переоптимизировать исходный план запроса, который используется для доступа к таблицам, ре компилируя его с помощью системной процедуры sp_recompile. Это позволяет избежать нахождения, удаления  и повторного создания каждой сохраненной процедуры или триггера. Следующий пример помечает каждую сохраненную процедуру и триггер, который осуществляет доступ к таблице titles, для того, чтобы рекомпилировать их во время каждого следующего выполнения.</p>
</p>
sp_recompile titles</p>
</p>
Более детально о команде sp_recompile можно узнать из Справочного руководства SQL Сервера.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Создание и выполнение сохраненных процедур</td></tr></table></div></p>
Полный синтаксис команды create procedure выглядит так:</p>
</p>
create procedure [владелец.]название_процедуры[;номер] [</p>
[(] @название_параметра тип_данных [= default] [output]</p>
[,  @название_параметра тип_данных [= default] [output]]...[)]] [with</p>
recompile]</p>
as sql_операторы</p>
</p>
Создавать процедуру можно только в текущей базе данных.</p>
Разрешение на создание сохраненной процедуры по умолчанию имеет владелец базы данных, который может передавать его другим пользователям.</p>
Далее приводится полный синтаксис оператора execute:</p>
</p>
[execute] [@return_status =]</p>
        [[[сервер.]база_данных.]владелец.]название_процедуры[;номер]</p>
                [[@название_параметра = ] значение |</p>
                 [@название_параметра = ] @переменная [output]</p>
[,[@название_параметра = ] значение |</p>
         [@название_параметра = ] @переменная [output]...]]</p>
[with recompile]</p>
</p>
                       Замечание: Вызов удаленной процедуры не является частью транзакции. Если вызов удаленной процедуры происходит после слов begin transaction (начать транзакцию), а затем встречается команда rollback transaction (откатить транзакцию), то любые изменения, которые произвела удаленная процедура над удаленными данными, не восстанавливаются. Создатель сохраненной процедуры должен быть уверен, что все условия, которые могут вызвать откат со стороны триггера, должны проверяться перед вызовом удаленной процедуры, которая может изменить удаленные данные.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Параметры</td></tr></table></div></p>
Параметр - это аргумент сохраненной процедуры. Один или несколько параметров могут быть объявлены в операторе создания процедуры. Значение каждого параметра, объявленного в операторе create procedure, должно указываться пользователем в момент вызова процедуры.</p>
Названиям параметров должен предшествовать символ “@”, а сами эти названия должны соответствовать правилам, установленным для идентификаторов. Для всех параметров должен быть указан системный или пользовательский тип данных, и если необходимо длина этого типа данных. Названия параметров являются локальными по отношению к содержащей их  процедуре; такие же названия можно использовать для параметров в другой процедуре. Названия параметров не должны превышать 30 байтов, включая символ “@”.</p>
Далее приведена  сохраненная процедура, которая используется в базе данных pubs2. По заданным именам и фамилиям писателей процедура выдает названия книг этих авторов и название каждого издательства, где они были опубликованы.</p>
</p>
create proc au_info @lastname varchar(40),</p>
  @firstname varchar(20) as</p>
select au_lname, au_fname, title, pub_name</p>
from authors, titles, publishers, titleauthor</p>
where au_fname = @firstname</p>
and au_lname = @lastname</p>
and authors.au_id = titleauthor.au_id</p>
and titles.title_id = titleauthor.title_id</p>
and titles.pub_id = publishers.pub_id</p>
</p>
Теперь выполним процедуру au_info:</p>
</p>
au_info Ringer, Anne</p>
</p>
au_lname au_fname title                             pub_name</p>
-------- -------- ---------------------            ----------</p>
Ringer   Anne     The Gourmet Microwave    Binnet &amp; Hardley</p>
Ringer   Anne     Is Anger the Enemy?                 New Age Books</p>
</p>
(2 rows affected, return status = 0)</p>
</p>
Следующая сохраненная процедура выполняет запросы к системным таблицам. По заданному названию таблицы, процедура выдает название таблицы, названия индексов этой таблицы и идентификаторы индексов.</p>
</p>
create proc showind @table varchar(30) as</p>
select table_name = sysobjects.name,</p>
index_name = sysindexes.name, index_id = indid</p>
from sysindexes, sysobjects</p>
where sysobjects.name = @table</p>
and sysobjects.id = sysindexes.id</p>
</p>
Заголовки столбцов, например table_name, были добавлены для более наглядного чтения результатов. Здесь приведены допустимые формы вызова  этой сохраненной процедуры:</p>
</p>
execute showind titles</p>
exec showind titles</p>
execute showind @table = titles</p>
execute GATEWAY.pubs2.dbo.showind titles</p>
showind titles</p>
</p>
Последняя синтаксическая форма, не содержащая ключевого слова exec или execute, допустима только, если этот оператор является единственным в строке или первым оператором в пакете.</p>
Ниже приведены результаты выполнения процедуры showind в базе данных pubs2, когда параметром является название таблицы titles:</p>
</p>
table_name  index_name  index_id</p>
----------    ----------     ----------</p>
titles                titleidind              1</p>
titles                titleind                      2</p>
</p>
(2 rows affected, return status = 0)</p>
</p>
</p>
Замечание: Если параметры задаются в виде “@параметр=значение”, то их можно задавать в любом порядке. В противном случае, они должны быть заданы в том же порядке, в каком они указаны в операторе create procedure. Если хотя бы один параметр был задан в виде “@параметр=значение ”, то все остальные параметры должны быть заданы в таком же виде.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Значения по умолчанию для параметров</td></tr></table></div></p>
В операторе create procedure для параметра можно указать значение, принимаемое по умолчанию. Это значение, которое может быть любой константой, используется в качестве аргумента процедуры, если для этого параметра не было указано никакого значения.</p>
Далее приведена процедура, которая выводит имена всех авторов, которые написали книги, опубликованные заданным издательством. Если название издательства не указано, то процедура выводит имена авторов, которые изданы в Algodata Infosystems.</p>
</p>
create proc pub_info</p>
  @pubname varchar(40) = "Algodata Infosystems" as</p>
select au_lname, au_fname, pub_name</p>
from authors a, publishers p, titles t, titleauthor ta</p>
where @pubname = p.pub_name</p>
and a.au_id = ta.au_id</p>
and t.title_id = ta.title_id</p>
and t.pub_id = p.pub_id</p>
</p>
Следует заметить, что если значением по умолчанию является символьной строкой, содержащей пробелы и знаки пунктуации, то это значение должно быть заключено в простые или двойные кавычки.</p>
При запуске процедуры pub_info необходимо задать название издательства в качестве значения параметра. Если это название не указано, то по умолчанию используется название Algodata Infosystems.</p>
</p>
exec pub_info</p>
</p>
au_lname   au_fname      pub_name</p>
--------------  ------------ --------------------</p>
Green         Marjorie       Algodata   Infosystems</p>
Bennet        Abraham        Algodata   Infosystems</p>
O'Leary       Michael        Algodata   Infosystems</p>
MacFeather   Stearns        Algodata   Infosystems</p>
Straight       Dick            Algodata   Infosystems</p>
Carson        Cheryl         Algodata  Infosystems</p>
Dull            Ann            Algodata   Infosystems</p>
Hunter        Sheryl         Algodata   Infosystems</p>
Locksley      Chastity      Algodata  Infosystems</p>
</p>
(9 rows affected, return status = 0)</p>
</p>
В следующей процедуре showind2 параметру @table присваивается по умолчанию значение “titles”:</p>
</p>
create proc showind2 @table varchar(30) = titles</p>
as</p>
select table_name = sysobjects.name,</p>
    index_name = sysindexes.name, index_id = indid</p>
from sysindexes, sysobjects</p>
where sysobjects.name = @table</p>
and sysobjects.id = sysindexes.id</p>
</p>
Заголовки столбцов, например table_name, добавлены для более наглядного вывода результатов. Ниже показано, что выдает эта процедура для таблицы authors, заданной в качестве аргумента:</p>
</p>
showind2 authors</p>
</p>
table_name  index_name      index_id</p>
-----------  -------------     ----------</p>
authors       auidind                 1</p>
authors       aunmind               2</p>
</p>
(2 rows affected, return status = 0)</p>
</p>
Если пользователь не указывает никакого параметра для этой процедуры, то SQL Сервер по умолчанию будет использовать таблицу titles:</p>
</p>
showind2</p>
</p>
table_name  index_name    index_id</p>
-----------  -----------      ---------</p>
titles           titleidind          1</p>
titles           titleind            2</p>
</p>
(2 rows affected, return status =0)</p>
</p>
Если в процедуре предусмотрен параметр, но он не указан, и в операторе create procedure для этого параметра не указано никакого значения по умолчанию, то SQL Сервер выводит сообщение об ошибке и перечисляет параметры, которые должны быть заданы.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>NULL как значения по умолчанию для параметра</td></tr></table></div></p>
Значение по умолчанию может быть неопределенным (NULL). В этом случае, если пользователь не указывает параметр, то SQL Сервер не выдает сообщения об ошибке и выполняет сохраненную процедуру.</p>
В определении процедуры может быть указано действие, которое должно быть выполнено в том случае, если пользователь не указал значения параметра,  т.е. когда это значение является неопределенным, как, например, в следующей процедуре:</p>
</p>
create procedure showind3 @table varchar(30) = null</p>
as</p>
if @table is null</p>
    print "Please give a table name"</p>
else</p>
   select table_name = sysobjects.name,</p>
     index_name = sysindexes.name, index_id = indid</p>
   from sysindexes, sysobjects</p>
   where sysobjects.name = @table</p>
   and sysobjects.id = sysindexes.id</p>
</p>
Если пользователь забыл ввести значения параметра, то SQL Сервер выведет на экран указанное в процедуре сообщение.</p>
Другие примеры установки неопределенного значения в качестве значения по умолчанию можно увидеть в тексте системных процедур с помощью процедуры sp_helptext.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Символы замены в значениях по умолчанию параметров</td></tr></table></div></p>
Если в процедуре используется параметр с ключевым словом like, то значение по умолчанию может содержать символы замены (%, _, [] и [^]).</p>
В следующем примере процедура showind изменена таким образом, чтобы она выдавала информацию о системных таблицах, если пользователь не указал название таблицы в качестве параметра:</p>
</p>
create procedure showind4 @table varchar(30)="sys%"</p>
as</p>
select table_name = sysobjects.name,</p>
    index_name = sysindexes.name, index_id = indid</p>
from sysindexes, sysobjects</p>
where sysobjects.name like @table</p>
and sysobjects.id = sysindexes.id</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Использование нескольких параметров</td></tr></table></div></p>
Ниже приведен один из вариантов сохраненной процедуры au_info, которая содержит значения по умолчанию с символами замены для обоих параметров:</p>
</p>
create proc au_info2 @lastname varchar(30) = "D%",</p>
  @firstname varchar(18) = "%" as</p>
select au_lname, au_fname, title, pub_name</p>
from authors, titles, publishers, titleauthor</p>
where au_fname like @firstname</p>
and au_lname like @lastname</p>
and authors.au_id = titleauthor.au_id</p>
and titles.title_id = titleauthor.title_id</p>
and titles.pub_id = publishers.pub_id</p>
</p>
Если процедура au_info2 выполняется  без параметров, то выдаются фамилии всех писателей, которые начинаются с буквы D:</p>
</p>
au_info2</p>
</p>
au_lname   au_fname       title                               pub_name</p>
--------     -------      -------------------------        -------------</p>
Dull          Ann          Secrets of Silicon Valley       Algodata Infosystems</p>
DeFrance Michel        The Gourmet Microwave      Binnet &amp; Hardley</p>
</p>
(2 rows affected)</p>
</p>
Если для параметров указаны значения по умолчанию, то при вызове процедуры параметры могут быть опущены, начиная с последнего параметра, после которого все параметры имеют умолчания. Параметр нельзя пропустить, если его значение по умолчанию не равно NULL.</p>
</p>
Замечание: Если параметры задаются в виде “@параметр=значение”, то они могут располагаться в любом порядке. Можно также пропустить любой параметр, если для него указано значение по умолчанию.</p>
Если хотя бы один параметр был задан в виде “@параметр=значение”, то остальные параметры должны быть заданы в таком же виде.</p>
</p>
Чтобы проиллюстрировать вызов процедуры с явно заданным одним параметром, когда для двух параметров указаны значения по умолчанию, рассмотрим следующий пример, в котором запрашиваются названия всех книг, написанных автором по фамилии «Ringer», вместе с издательствами их опубликовавшими:</p>
</p>
au_info2 Ringer</p>
</p>
au_lname   au_fname    title                              Pub_name</p>
--------   --------    ---------------------            ------------</p>
Ringer     Anne        The Gourmet Microwave    Binnet &amp; Hardley</p>
Ringer     Anne        Is Anger the Enemy?          New Age Books</p>
Ringer     Albert       Is Anger the Enemy?          New Age Books</p>
Ringer     Albert       Life Without Fear              New Age Books</p>
</p>
(4 rows affected)</p>
</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Группы процедур</td></tr></table></div></p>
Необязательная точки с запятой вместе с целым числом после названия процедуры в операторах create procedure и execute позволяют группировать процедуры с одинаковым названиями так, что они могут быть удалены одновременно одним оператором drop procedure (удалить процедуру).</p>
Процедуры, которые используются в одном и том же приложении, часто группируются таким образом. Например, можно создать последовательность процедур orders;1, orders;2, и т.д. Следующий оператор будет удалять всю эту группу:</p>
</p>
drop proc orders</p>
</p>
Если процедуры были сгруппированы путем добавления точки с запятой и целого числа к их названию, то они не могут быть удалены независимо друг от друга. Например, следующий оператор не допустим:</p>
</p>
drop proc orders;2</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Конструкция recompile в операторе create procedure</td></tr></table></div></p>
В операторе создания процедуры create procedure необязательная конструкция with recompile (с перекомпилированием) расположена точно перед SQL-операторами, составляющими тело процедуры. Она сообщает SQL Серверу о том, что не нужно сохранять план выполнения процедуры, поскольку при каждом запуске этой процедуры будет создаваться новый план ее выполнения.</p>
Если конструкция with recompile не указана, то SQL Сервер сохраняет созданный план выполнения процедуры. Обычно этот план является  вполне удовлетворительным.</p>
Однако, возможны ситуации, когда изменения данных или значений параметров, вынуждают SQL Сервер перейти к другому плану выполнения процедуры, отличному от того, который был создан во время первого выполнения процедуры. В таких ситуациях SQL Серверу требуется новый план выполнения процедуры.</p>
Конструкцию with recompile в операторе создания процедуры следует использовать, когда пользователю может потребоваться новый план выполнения процедуры. Дополнительная информация об этом дается также в Справочном руководстве SQL Сервера.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Конструкция recompile в операторе execute</td></tr></table></div></p>
В операторе execute необязательная конструкция with recompile располагается сразу после параметров. Она сообщает SQL Серверу, что нужно создавать новый план выполнения процедуры. Новый план используется при  дальнейших запусках процедуры.</p>
Конструкцию with recompile следует указывать, если данные сильно изменились или среди значений параметров процедуры появились нетипичные, т.е. когда у пользователя есть уверенность, что текущий план выполнения процедуры не оптимален.</p>
</p>
Замечание: Если в определении процедуры используется команда select *, то процедура не распознает новые столбцы, добавленные в таблицу, даже если в операторе execute используется опция with recompile. Такая процедура должна быть удалена и создана заново.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Вложенные процедуры</td></tr></table></div></p>
Вложение процедур возникает, когда одна сохраненная процедура или триггер вызывает другую процедуру. Уровень вложенности увеличивается, когда вызываемая процедура или триггер начинает свое выполнение, и уменьшается, когда вызываемая процедура или триггер заканчивают выполнение. Превышение максимального 16-го уровня вложенности ведет к прерыванию процедуры. Текущий уровень вложенности процедуры хранится в глобальной переменной @@nestlevel.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Временные таблицы в сохраненных процедурах</td></tr></table></div></p>
В сохраненных процедурах разрешается создавать и использовать временные таблицы, но эти таблицы хранятся только на протяжении выполнения сохраненной процедуры, которая создала их. После завершения выполнения процедуры SQL Сервер автоматически удаляет временную таблицу. Процедура может выполнять следующие действия:</p>
</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Создавать временные таблицы;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Вставлять, обновлять и удалять данные;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Выполнять запросы над временными таблицами;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Вызывать другие процедуры, которые обращаются к временной таблице.</td></tr></table></div></p>
Поскольку временная таблица должна уже существовать, когда создается процедура, которая к ней обращается, то далее даются варианты использования временных таблиц в процедурах:</p>
</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="16">1.</td><td>Создайте необходимую временную таблицу с помощью операторов create table или select into. Например:</td></tr></table></div></p>
create table #tempstores</p>
(stor_id char(4), amount money)</p>
</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="16">1.</td><td>Создайте процедуру, которая имеет доступ к временной таблице (но не ту, что создает таблицу).</td></tr></table></div></p>
create procedure inv_amounts</p>
    as</p>
    select stor_id, "Total Due" =sum(amount)</p>
    from #tempstores</p>
    group by stor_id</p>
</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="16">1.</td><td>Удалите временную таблицу:</td></tr></table></div></p>
drop table # tempstores</p>
</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="16">1.</td><td>Создайте процедуру, которая создает временную таблицу и вызывает процедуру, указанную в п. 2:</td></tr></table></div></p>
create procedure inv_proc</p>
as</p>
create table #tempstores</p>
(stor_id char(4), amount money)</p>
</p>
insert #tempstores</p>
select stor_id, sum(qty*(100-discount)/100* rice)</p>
from salesdetail, titles</p>
where salesdetail.title_id = titles.title_id</p>
group by stor_id, salesdetail.title_id</p>
</p>
exec inv_amounts</p>
</p>
Можно создавать временные таблицы без префикса #, используя оператор create table tempdb..tablename.. в самой сохраненной процедуре. Эти таблицы не удаляются после завершения выполнения процедуры, поэтому на них могут ссылаться независимые процедуры. Для создания таких таблиц можно использовать способы, описанные в пп.1-4.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Выполнение удаленных процедур</td></tr></table></div></p>
Процедуры можно выполнять на SQL Сервере, отличном от локального SQL Сервера. Если оба сервера имеют совместимые конфигурации, то можно выполнять любую процедуру на удаленном сервере, просто записывая название сервера как часть идентификатора. Например, для выполнения процедуры remoteproc на удаленном сервере GATEWAY, нужно выполнить следующую команду:</p>
</p>
exec gateway.remotedb.dbo.remoteproc</p>
</p>
Информацию о том, как конфигурировать локальный и удаленный  серверы для выполнения удаленных процедур, можно посмотреть в Руководстве системного администратора. Из пакета или процедуры, содержащей оператор execute, вызывающий удаленную процедуру, можно передать в нее один или несколько значений в качестве параметров. Результаты выполнения процедуры на удаленном сервере появляются на локальном терминале пользователя.</p>
Статус (состояние), возвращаемое процедурой и описываемое в следующих разделах, может использоваться для получения и передачи информации о состоянии выполнения процедуры.</p>
</p>
Внимание: Вызовы удаленных процедур не являются частью транзакции. Поэтому, если вызов удаленной процедуры является частью транзакции, а затем транзакция откатывается назад, то любые изменения, которые  удаленная процедура произвела на удаленном сервере, не восстанавливаются.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Возврат информации из сохраненных процедур</td></tr></table></div></p>
Сохраненные процедуры сообщают свой «статус возврата», который указывает, была ли выполнена процедура полностью, или нет, а также  причины неудачи. Это значение может храниться в переменной, которая передается процедуре при ее вызове, и использоваться в последующих операторах Transact-SQL. SQL Сервер резервирует значения в диапазоне от -1 до -99 для кодов возврата ошибочных ситуаций, которые могут возникнуть при выполнении процедуры; а значения, находящиеся вне этого диапазона, пользователи могут использовать для определения своих статусов (кодов) возврата.</p>
Другой способ возврата информации из сохраненных процедур состоит в возврате значений через выходные параметры. Параметры, определенные как выходные, в операторе create procedure (создать процедуру) или execute (выполнить) используются для возврата значений в место вызова процедуры. Затем с помощью условных операторов можно проверить возвращаемое значение.</p>
Код возврата и выходные параметры позволяют разделить сохраненные процедуры на модули. Группа SQL операторов, которые используются несколькими сохраненными процедурами, могут быть объединены в  одну процедуру, которая сообщает свой статус выполнения или значения своих параметров вызывающей процедуре. Например, многие системные процедуры, поставляемые с SQL Сервером, обращаются к процедуре, которая проверяет являются ли указанные параметры правильными идентификаторами.</p>
Вызовы удаленных процедур, которые являются сохраненными процедурами, выполняемыми на удаленном SQL Сервере, также возвращают  оба вида информации. Все рассмотренные выше примеры могут быть выполнены на удаленном сервере, если при вызове процедуры указать названия сервера, базы данных, имя владельца и название процедуры.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Коды возврата</td></tr></table></div></p>
Сохраненные процедуры могут возвращать целое число, которое называется кодом возврата (return status). Это число показывает, была ли процедура выполнена полностью или указывает на причины неудачного выполнения. SQL Сервер имеет набор заранее определенных кодов возврата. Пользователю может определить свои собственные коды возврата. Ниже приведен пример пакета, в котором оператор execute возвращает код состояния:</p>
</p>
declare @status int</p>
execute  @status = pub_info</p>
select @status</p>
</p>
Статус выполнения (код возврата) процедуры pub_info сохраняется в переменной @status. В этом примере код возврата просто выводится с помощью оператора select; в последующих примерах код возврата будет анализироваться с помощью условных конструкций.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Зарезервированные значения кодов возврата</td></tr></table></div></p>
SQL Сервер резервирует код 0 для указания успешного выполнения процедуры и значения в диапазоне от -1 до -99 для указания различных причин неудачи. В следующей таблице показаны коды возврата от 0 до -14 и даны их описания:</p>
</p>
Таблица 14-1: Зарезервированные значения обратного статуса</p>
</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Код</p>
</td>
<td><p>Значение</p>
</td>
</tr>
<tr>
<td><p>0</p>
</td>
<td><p>Процедура выполнена без ошибок</p>
</td>
</tr>
<tr>
<td><p>-1</p>
</td>
<td><p>Отсутствует объект</p>
</td>
</tr>
<tr>
<td><p>-2</p>
</td>
<td><p>Ошибка в типе данных</p>
</td>
</tr>
<tr>
<td><p>-3</p>
</td>
<td><p>Прекращение выполнения процедуры для выхода из тупика</p>
</td>
</tr>
<tr>
<td><p>-4</p>
</td>
<td><p>Нарушение прав доступа</p>
</td>
</tr>
<tr>
<td><p>-5</p>
</td>
<td><p>Синтаксическая ошибка</p>
</td>
</tr>
<tr>
<td><p>-6</p>
</td>
<td><p>Ошибка пользователя</p>
</td>
</tr>
<tr>
<td><p>-7</p>
</td>
<td><p>Недостаток ресурсов, например, памяти</p>
</td>
</tr>
<tr>
<td><p>-8</p>
</td>
<td><p>Не фатальная внутренняя проблема</p>
</td>
</tr>
<tr>
<td><p>-9</p>
</td>
<td><p>Достижение системного предела</p>
</td>
</tr>
<tr>
<td><p>-10</p>
</td>
<td><p>Фатальная внутренняя проблема</p>
</td>
</tr>
<tr>
<td><p>-11</p>
</td>
<td><p>Фатальная внутренняя проблема</p>
</td>
</tr>
<tr>
<td><p>-12</p>
</td>
<td><p>Испорчена таблица или индекс</p>
</td>
</tr>
<tr>
<td><p>-13</p>
</td>
<td><p>Испорчена база данных</p>
</td>
</tr>
<tr>
<td><p>-14</p>
</td>
<td><p>Аппаратная ошибка
</td>
</tr>
</table>
</p>
Кода от -15 до -99 зарезервированы для дальнейшего использования SQL Сервером.</p>
Если во время выполнения процедуры возникает несколько ошибок, то возвращается наибольший по абсолютной величине код.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Коды возврата пользователя</td></tr></table></div></p>
Пользователь может определить свои собственные коды возврата из сохраненных процедур, добавляя параметр в операторе return (возврат). Коды  от 0 до -99 зарезервированы SQL Сервером; остальные значения можно  использовать для определения своих кодов. В следующем примере возвращается 1, если книга имеет правильный код контракта, и 2 во всех остальных случаях:</p>
</p>
create proc checkcontract @titleid tid</p>
as</p>
if (select contract from titles where</p>
        title_id = @titleid) = 1</p>
   return 1</p>
else</p>
   return 2</p>
</p>
Следующая сохраненная процедура вызывает процедуру checkcontract, а затем код, возвращаемый этой процедурой, анализируется с помощью условного оператора:</p>
</p>
create proc get_au_stat @titleid tid</p>
as</p>
declare @retvalue int</p>
execute @retvalue = checkcontract @titleid</p>
if (@retvalue = 1)</p>
   print "Contract is valid"</p>
else</p>
    print "There is not a valid contract"</p>
</p>
Ниже показан результат выполнения процедуры get_au_stat, аргументом которой является идентификатор книги с правильным номером контракта:</p>
</p>
get_au_stat «MC2222»</p>
</p>
           Contract is valid</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Проверка прав доступа в процедурах</td></tr></table></div></p>
Если сохраненная процедура выполняет задачу системного администрирования, то пользователь должен иметь права на ее использование. (Информацию о правах см. в Руководстве пользователя по средствам ограничения доступа SQL Сервера).  Функция proc_role позволяет проверить права (роль) пользователя во время выполнения процедуры. Она возвращает 1, если пользователь имеет соответствующие права. Различают три степени прав доступа: sa_role, sso_role, и oper_role.</p>
Ниже приведен пример использования функции proc_role в процедуре test_proc, требующей от вызывающего ее пользователя прав доступа системного администратора:</p>
</p>
create proc test_proc</p>
as</p>
if (proc_role("sa_role") = 0)</p>
begin</p>
    print "You don't have the right role"</p>
    return -1</p>
end</p>
else</p>
    print "You have SA role"</p>
    return 0</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Возвращаемые параметры</td></tr></table></div></p>
Если в операторах create procedure и execute указывается опция output (выход) в названии параметра, то процедура возвращает значение этого параметра вызывающему объекту. Этим объектом может быть SQL пакет или  другая сохраненная процедура, которые используют возвращаемые значения в своей дальнейшей работе. Если возвращаемые параметры используются в операторе execute, который является частью пакета, то значения возвращаемых параметров вместе с заголовком выводятся на экран перед выполнением последующих операторов пакета.</p>
Нижеприведенная процедура выполняет умножение двух целых чисел, которые передаются ей в качестве двух первых аргументов, а третий аргумент @result определяется с опцией output:</p>
</p>
create procedure mathtutor @mult1 int, @mult2 int,</p>
  @result int output</p>
as</p>
select @result = @mult1 * @mult2</p>
</p>
Чтобы использовать процедуру mathtutor для целей обучения, можно объявить переменную @result и включить ее в оператор execute. Добавление ключевого слова output в операторе execute позволяет увидеть значения возвращаемого параметра.</p>
</p>
declare @result int</p>
exec mathtutor 5, 6, @result output</p>
</p>
(return status = 0)</p>
</p>
Return parameters:</p>
</p>
-----------</p>
         30</p>
</p>
Обучающийся может вызвать процедуру умножения с тремя целыми числами в качестве аргументов, чтобы проверить правильность ответа, но результат умножения в этом случае не будет выведен, поскольку в процедуре оператор select присваивает значения, но не выводит их на экран:</p>
</p>
mathtutor 5,6,32</p>
(return status=0)</p>
</p>
Значение параметра, определенного с опцией output, должно передаваться через переменную, а не через константу. В следующем примере переменная @guess используется для передачи в процедуру mathtutor значения третьего параметра. При этом SQL Сервер выводит значение возвращаемого параметра:</p>
</p>
declare @guess int</p>
select @guess = 32</p>
exec mathtutor 5, 6, @result = @guess output</p>
</p>
(1 row affected)</p>
(return status = 0)</p>
</p>
Return parameters:</p>
</p>
@result</p>
-----------</p>
        30</p>
</p>
Значения возвращаемых параметров выводятся всегда, независимо от того, изменились эти значения, или нет. Заметим, что:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>В предыдущем примере выходной параметр @result должен передаваться в виде “@параметр=@переменная”. Если бы он не был последним передаваемым параметром, то все следующие за ним параметры также должны передаваться в таком же виде;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Переменную @result  не нужно объявлять в вызывающем пакете, поскольку это название параметра процедуры mathtutor.</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Несмотря на то, что измененное значение параметра @result возвращается через переменную, указанную в операторе execute, в данном случае через переменную @guess, оно выводится под своим названием, т.е. @result.</td></tr></table></div></p>
Если в дальнейшем после оператора execute может потребоваться первоначальное значение переменной @guess, то его нужно сохранить в другой переменной перед вызовом процедуры. Следующий пример иллюстрирует  использование переменной @store для хранения значения переменной во время выполнения сохраненной процедуры, и использование “нового” возвращаемого значения переменной @guess в условных конструкциях:</p>
</p>
declare @guess int</p>
declare @store int</p>
select @guess = 32</p>
select @store = @guess</p>
execute mathtutor 5, 6, @result = @guess output</p>
select Your_answer = @store, Right_answer = @guess</p>
if @guess = @store</p>
    print "Right-o"</p>
else</p>
    print "Wrong, wrong, wrong!"</p>
</p>
(1 row affected)</p>
(1 row affected)</p>
(return status = 0)</p>
</p>
Return parameters:</p>
</p>
@result</p>
-----------</p>
         30</p>
</p>
 Your_answer     Right_answer</p>
 -----------        ------------</p>
          32                30</p>
</p>
(1 row affected)</p>
Wrong, wrong, wrong!<br>
<p></p>
Ниже приведена сохраненная процедура, которая проверяет, влияет ли объем продажи новой книги на изменение гонорара ее автора. Параметр @pc определяется как выходной (output) параметр:</p>
</p>
create proc roy_check @title tid, @newsales int,</p>
        @pc int output</p>
as</p>
declare @newtotal int</p>
select @newtotal = (select titles.total_sales + @newsales</p>
                  from titles where title_id = @title)</p>
select @pc = royalty from  roysched</p>
   where @newtotal  &gt;= roysched.lorange and</p>
          @newtotal &lt; roysched.hirange</p>
   and roysched.title_id = @title</p>
</p>
Следующий SQL пакет вызывает процедуру roy_check после присваивания значения переменной percent. Значения возвращаемых параметров выводятся на экран перед выполнением следующего оператора пакета:</p>
</p>
declare @percent int</p>
select @percent = 10</p>
execute roy_check "BU1032", 1050, @pc = @percent output</p>
select Percent = @percent</p>
</p>
go</p>
(1 row affected)</p>
(return status = 0)</p>
</p>
Return parameters:</p>
</p>
@pc</p>
-----------</p>
         12</p>
</p>
 Percent</p>
 -----------</p>
          12</p>
</p>
(1 row affected)</p>
</p>
Следующая сохраненная процедура вызывает процедуру roy_check и использует возвращаемое в переменной percent значение в условном операторе:</p>
</p>
create proc newsales @title tid, @newsales int</p>
as</p>
declare @percent int</p>
declare @stor_pc int</p>
select @percent = (select royalty from roysched, titles</p>
        where roysched.title_id = @title</p>
        and total_sales &gt;= roysched.lorange</p>
        and total_sales &lt; roysched.hirange</p>
        and roysched.title_id=titles.title_id)</p>
select @stor_pc = @percent</p>
execute roy_check @title, @newsales, @pc = @percent</p>
  output</p>
if</p>
  @stor_pc != @percent</p>
begin</p>
  print "Royalty is changed"</p>
  select Percent = @percent</p>
end</p>
else</p>
  print "Royalty is the same"</p>
</p>
Если выполнить эту сохраненную процедуру с теми же параметрами, которые использовались в предыдущем пакете, то результаты будут следующими:</p>
</p>
execute newsales "BU1032", 1050</p>
</p>
Royalty is changed</p>
Percent</p>
-----------</p>
         12</p>
</p>
(1 row affected, return status = 0)</p>
</p>
В двух предыдущих примерах, где вызывается процедура roy_check, @pc  является названием параметра, который передается процедуре roy_check, а @percent является выходной переменной. Когда процедура newsales вызывает процедуру roy_check, то значение переменной @percent может изменяться в зависимости от значения других передаваемых параметров. Если нужно сравнить возвращаемое значение percent с первоначальным значением параметра @pc, то следует сохранить начальное значение в другой переменной. В предыдущем примере это значение сохраняется в переменной stor_proc.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Передача значений параметров</td></tr></table></div></p>
Значения параметров должны передаваться в следующем виде:</p>
</p>
@параметр=@переменная</p>
</p>
Нельзя использовать константы в качестве параметров. В этом случае значение константы нужно предварительно запомнить в некоторой переменной. Параметры могут иметь любой тип данных языка SQL, за исключением text и image.</p>
</p>
Замечание: Если сохраненная процедура требует нескольких параметров, то либо выходной параметр должен быть указан последним в операторе execute, либо все следующие после него параметры должны быть указаны в виде “@параметр=значение”.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Ключевое слово output</td></tr></table></div></p>
Ключевое слово output (выходной) можно сокращать до out , также как и execute можно сокращать до exec.</p>
Сохраненные процедуры могут возвращать несколько значений, каждое из которых должно определяться как выходная (output) переменная в сохраненной процедуре и вызывающем операторе, например:</p>
</p>
exec myproc @a = @myvara out, @b = @myvarb out</p>
</p>
Если указать ключевое слово output только для переменной в вызывающем операторе, но при этом соответствующий параметр не определен как выходной в сохраненной процедуре, то будет получено сообщение об ошибке. Вообще говоря, не является ошибкой вызов процедуры без объявления переменных как выходных, хотя соответствующие параметры описаны как выходные в сохраненной процедуре. Однако при этом значения возвращаемых параметров будут недоступными. Другими словами, создатель сохраненной процедуры указывает какая информация может быть доступна пользователю, а пользователь управляет доступом к своим переменным.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Правила, связанные с сохраненными процедурами</td></tr></table></div></p>
Приведем некоторые дополнительные правила для создания сохраненных процедур:</p>
</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>В пакет можно поместить только один оператор create procedure (создать процедуру) вместе с  телом этой процедуры и в этом случае в пакете не должно быть других SQL операторов;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Тело процедуры может содержать любое количество SQL операторов любого типа, за  исключением оператора use и следующих операторов создания объектов:</td></tr></table></div></p>
create view</p>
create default</p>
create rule</p>
create trigger</p>
create procedure</p>
</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Другие объекты базы данных можно создавать внутри процедуры. К объекту базы данных можно обратиться внутри этой же процедуры, если он был создан до того как к нему обратились. Поэтому оператор создания объекта базы данных нужно располагать в начале процедуры;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Внутри сохраненной процедуры нельзя создать объект, затем удалить его, а затем снова создать новый объект с таким же названием;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>SQL Сервер создает объекты, определенные в процедуре, во время выполнения процедуры, а не во время ее компилирования;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>При выполнении процедуры, которая вызывает другую процедуру, вызываемая процедура может обращаться к объектам, созданным первой процедурой;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Внутри процедуры разрешается обращаться к временным таблицам;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Если внутри процедуры была создана временная таблица, то она существует только во время выполнения этой процедуры, и исчезает после выхода из процедуры;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Максимальное число параметров сохраненной процедуры равно 255.</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Максимальное число локальных и глобальных переменных процедуры ограничивается только объемом доступной памяти.</td></tr></table></div></p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Расширение названий объектов внутри процедур</td></tr></table></div></p>
Если многие пользователи обращаются к сохраненной процедуре, то названия объектов, которые используются в некоторых командах внутри   процедуры, должны быть расширены именем владельца объекта. Такими командами являются: alter table, create table, drop table, truncate table, create index, drop index, update statistics, dbcc. Названия объектов, которые используются в других операторах, например select или insert, не требуют расширения, поскольку их названия уточняются во время компиляции процедуры.</p>
Например, пользователь “Мэри” (mary), которая является владельцем таблицы marytab, должна расширить название своей таблицы, когда она используется с одной из перечисленных выше команд в том случае, если “Мэри” хочет дать возможность другим пользователям исполнять эту процедуру с указанной таблицей:</p>
</p>
create procedure p1</p>
as</p>
create index marytab_ind</p>
on mary.marytab(col1)</p>
</p>
Дело в том, что названия объектов уточняются во время выполнения процедуры. Если название таблицы marytab не расширить, то при выполнении процедуры пользователем c именем “Джон” (john), SQL Сервер будет искать таблицу marytab, владельцем которой является Джон. В предыдущем примере было показано правильное использование этого правила. SQL Серверу было сообщено, что нужно искать таблицу marytab, владельцем которой является Мэри.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Удаление сохраненных процедур</td></tr></table></div></p>
Сохраненные процедуры удаляются с помощью команды drop procedure (удалить процедуру). Синтаксис этой команды выглядит следующим образом:</p>
</p>
drop procedure [владелец.]название_процедуры</p>
[, [владелец.]название_процедуры] ...</p>
</p>
Если сохраненная процедура, которая удаляется, вызывает другую сохраненную процедуру, то SQL Сервер выдает сообщение об ошибке. Однако, если создать новую процедуру с таким же названием вместо удаленной процедуры, то вызывающие ее процедуры будут успешно выполняться.</p>
Группа процедур, т.е. несколько процедур с одинаковыми названиями, но с разными числовыми суффиксами, удаляются одним оператором drop procedure. Процедуры, объединенные в группу, не могут быть удалены независимо друг от друга.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Изменение названий сохраненных процедур</td></tr></table></div></p>
Сохраненная процедура может быть переименована с помощью системной процедуры sp_rename. Синтаксис вызова этой процедуры выглядит следующим образом:</p>
</p>
sp_rename название_объекта, новое_название</p>
</p>
Например, чтобы процедуру с названием showall переименовать на countall  нужно выполнить следующую команду:</p>
</p>
sp_rename showall, countall</p>
</p>
Безусловно, новое название должно соответствовать правилам, установленным для идентификаторов. Пользователю разрешается изменять  название только своих процедур. Владельцу базы данных разрешается изменять название любой сохраненной процедуры. Сохраненная процедура, название которой изменяется, должна находиться в текущей базе данных.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Переименование объектов внутри процедур</td></tr></table></div></p>
Если в сохраненной процедуре было изменено название какого-либо объекта, то она должна быть удалена и создана заново. На первый взгляд может показаться, что сохраненная процедура, которая обращается к переименованной таблице или вьюверу, выполняется правильно. В действительности, эта процедура будет работать правильно только до тех пор, пока SQL Сервер не перекомпилирует ее. Перекомпиляция может произойти  по многим причинам и без специального уведомления пользователя.</p>
С помощью системной процедуры sp_depends можно получить список объектов, к которым обращается сохраненная процедура.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Процедуры как механизм безопасности</td></tr></table></div></p>
Сохраненные процедуры могут использоваться в качестве механизма обеспечения безопасности для управления доступом к табличной информации и управления модификацией данных. Например, можно не дать разрешения другим пользователям выбирать информацию из вашей таблицы, и создать сохраненную процедуру, которая позволяет им видеть только некоторые строки или столбцы этой таблицы. Сохраненные процедуры могут также использоваться для ограничения операторов update, delete, insert.</p>
Пользователь, который является владельцем сохраненной процедуры, должен также владеть таблицей или вьювером, которые используются внутри этой процедуры. Даже системному администратору не разрешается создавать сохраненную процедуру для выполнения действий над таблицами других пользователей, если ему не был предоставлен доступ к этим таблицам.</p>
Информацию о предоставлении и отзыве прав на сохраненные процедуры и другие объекты базы данных, можно посмотреть в Руководстве пользователя по средствам ограничения доступа SQL Сервера.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Системные процедуры</td></tr></table></div></p>
Системные процедуры могут быть полезными в следующих отношениях:</p>
</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Для ускорения доступа к системным таблицам;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Как механизм выполнения административных функций в базах данных, а также других задач, требующих обновления системных таблиц.</td></tr></table></div></p>
В большинстве случаев системные таблицы обновляются только через сохраненные процедуры. Системный администратор может разрешить непосредственное обновление системных таблиц путем изменения конфигурационной переменной и выдачи команды reconfigure with override (реконфигурация с перезаписью). См. по этому поводу Руководство системного администратора SQL Сервера (System Administration Guide).</p>
Названия всех системных процедур начинаются с приставки «sp_». Они создаются согласно сценарию installmaster (мастер инсталляции) в базе данных sybsystemprocs во время инсталляции SQL Сервера.</p>
Системную процедуру можно запускать из любой базы данных. Если системная процедура вызывается из базы данных, отличной от sybsystemprocs, то любые ссылки к системным таблицам отображаются в базу данных, из которой процедура была запущена. Например, если владелец базы данных pubs2 запускает процедуру sp_adduser (добавить пользователя), то новый пользователь будет добавлен в таблицу pubs2..sysuser.</p>
Если параметром системной процедуры является название объекта и это название дополняется названием базы данных или названием владельца, то все название должно заключаться в одинарные или двойные кавычки.</p>
Поскольку системные процедуры располагаются в базе данных sybsystemprocs, то и предоставления прав доступа к ним также осуществляется из этой базы. Некоторые системные процедуры могут быть вызваны только владельцами баз данных. Эти процедуры проверяют, что к ним обращается  владелец той базы данных, из которой они запускаются.</p>
Другие системные процедуры могут запускаться любым пользователем, которой имеет право на использование оператора execute, но это право должно быть предоставлено из базы данных sybsystemprocs. Отсюда вытекают два следствия:</p>
</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Пользователь имеет право запускать системные процедуры из любой базы данных или ни из одной из них;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Владелец базы данных пользователя не может непосредственно управлять доступом к системным процедурам из своей базы данных.</td></tr></table></div></p>
Более подробную информацию на эту тему см. в Руководстве системного администратора SQL Сервера.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Администрирование доступа</td></tr></table></div></p>
К этой категории относятся процедуры, выполняющие следующие действия:</p>
</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Добавление, удаление и выдача регистраций (logins) SQL Сервера;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Добавление, удаление и выдача имен пользователей, групп и псевдонимов (alieses) базы данных;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Изменение паролей и базы данных, принимаемой по умолчанию;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Изменение владельца базы данных;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Добавление, удаление и выдача удаленных серверов, которые имеют доступ к данному SQL Серверу;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Добавление имен пользователей удаленных серверов, имеющих доступ к данному SQL Серверу.</td></tr></table></div></p>
К этой категории относятся следующие процедуры: sp_addlogin, sp_addalias, sp_addgroup, sp_adduser, sp_changedowner, sp_changegroup, sp_droplogin, sp_dropalias, sp_dropgroup, sp_dropuser, sp_helpgroup, sp_helpprotect, sp_helpuser, sp_password.</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Удаленные серверы</td></tr></table></div></p>
К этой категории относятся процедуры, выполняющие следующие действия:</p>
</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Добавление, удаление и выдача удаленных серверов, которые имеют доступ к данному SQL Серверу;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Добавление имен пользователей удаленных серверов, имеющих доступ к данному SQL Серверу.</td></tr></table></div></p>
К этой категории относятся следующие процедуры: sp_addremotelogin, sp_addserver, sp_dropremotelogin, sp_dropserver, sp_helpremotelogin, sp_helpserver, sp_remoteoption, sp_serveroption.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Определение данных и объекты базы данных</td></tr></table></div></p>
К этой категории относятся процедуры, выполняющие следующие действия:</p>
</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Связывание и развязывание правил и умолчаний;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Добавление, удаление и выдача главных, внешних и общих ключей;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Добавление, удаление и выдача типов данных пользователя;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Переименование объектов базы данных и типов данных пользователя;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Оптимизация сохраненных процедур и триггеров;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Составление отчетов об объектах базы данных, пользовательских типах данных, зависимостях между объектами базы, базах данных, индексах, пространстве, занимаемом таблицами и индексами.</td></tr></table></div></p>
 К этой категории относятся следующие процедуры: sp_bindefault, sp_bindrule, sp_unbindefault,  sp_unbindrule, sp_foreignkey, sp_primarykey,  sp_commonkey, sp_dropkey, sp_depends,  sp_addtype, sp_droptype, sp_rename,  sp_spaceused, sp_help, sp_helpdb, sp_helpindex,  sp_helpjoins, sp_helpkey, sp_helptext,  sp_indsuspect, sp_recompile.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Сообщения пользователя</td></tr></table></div></p>
К этой категории относятся процедуры, выполняющие следующие действия:</p>
</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Добавление сообщений пользователя в таблицу sysusermessages базы данных пользователя;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Удаление сообщений пользователя из таблицы sysusermessages;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Выбор сообщений из таблицы sysusermessages или таблицы sysmessages в базе данных master для вывода их с помощью операторов print и raiserror;</td></tr></table></div></p>
К этой категории относятся следующие процедуры: sp_addmessage, sp_dropmessage sp_getmessage.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Системное администрирование</td></tr></table></div></p>
К этой категории относятся процедуры, выполняющие следующие действия:</p>
</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Добавление, удаление и выдача устройств для хранения базы данных и логирующих (dump) устройств;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Выдача запретов (locks), установленных опций базы данных и выполняющихся процессов пользователя;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Изменение и вывод конфигурационных переменных;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Наблюдение (monitoring) за активностью SQL Сервера.</td></tr></table></div></p>
К этой категории относятся следующие процедуры: sp_addumpdevice, sp_dropdevice, sp_helpdevice, sp_helpsort, sp_logdevice, sp_dboption, sp_diskdefault, sp_configure, sp_monitor, sp_lock, sp_who.</p>
</p>
Дополнительная информация о системных процедурах, которые выполняют административные функции, дается в Руководстве системного администратора SQL Сервера. Полную информацию о системных процедурах можно также получить в Справочном руководстве SQL Сервера.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Получение информации о процедурах</td></tr></table></div></p>
Несколько системных процедур выдают информацию из системных таблиц о сохраненных процедурах.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Процедура sp_help</td></tr></table></div></p>
С помощью системной процедуры sp_help можно получить отчет о сохраненной процедуре. Например, пользователь может получить информацию о сохраненной процедуре byroyalty из базы данных pubs2 с помощью следующей команды:</p>
</p>
sp_help byroyalty</p>
</p>
Name               Owner   type                         Created_on</p>
--------             ------           ----------------            -------------------</p>
byroyalty            dbo              stored procedure    Feb  9 1987  3:56PM</p>
</p>
Data_located_on_segment              When_created</p>
---------------------------                     --------------------</p>
</p>
Parameter_name    Type            Length                   Param_order</p>
--------------                ------            ------                   -----------</p>
@percentage            int                 4                   1</p>
</p>
(return status = 0)</p>
</p>
</p>
С помощью этой же процедуры можно получить информацию (помощь) и о системных процедурах, если запустить sp_help из базы данных sybsystemprocs.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Процедура sp_helptext</td></tr></table></div></p>
Чтобы увидеть текст (тело) сохраненной процедуры, нужно вызвать системную процедуру sp_helptext:</p>
</p>
sp_helptext byroyalty</p>
</p>
# Lines of Text</p>
---------------</p>
              1</p>
</p>
(1 row affected)</p>
</p>
text</p>
---------------------------------------------------</p>
create procedure byroyalty @percentage int</p>
as</p>
select au_id from titleauthor</p>
where titleauthor.royaltyper = @percentage</p>
</p>
(1 row affected, return status = 0)</p>
</p>
Чтобы увидеть текст системной процедуры нужно вызвать процедуру sp_helptext из базы данных sybsystemprocs.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Процедура sp_depends</td></tr></table></div></p>
Системная процедура sp_depends перечисляет все сохраненные процедуры, которые обращаются к указанному объекту, или все объекты, к которым обращается указанная процедура. Например, по следующей команде выдается список всех объектов, к которым обращается сохраненная процедура пользователя byroyalty:</p>
</p>
sp_depends byroyalty</p>
</p>
Things the object references in the current database.</p>
object                type        updated      selected</p>
---------------- ----------- ---------   --------</p>
dbo.titleauthor   user table     no            no</p>
</p>
(return status = 0)</p>
</p>
В следующем операторе процедура sp_depends используется для получения списка объектов, которые обращаются к таблице titleauthor:</p>
</p>
sp_depends titleauthor</p>
</p>
Things inside the current database that reference the object.</p>
object                 type</p>
--------------    ------------------</p>
dbo.titleview      view</p>
dbo.reptq2         stored procedure</p>
dbo.byroyalty      stored procedure</p>
</p>
(return status = 0)</p>
</p>
Необходимо удалить процедуру, а затем вновь создать ее, если какой-либо из объектов внутри процедуры был переименован.</p>
Системные процедуры были кратко рассмотрены в разделе «Системные процедуры» этой главы. Более полная информация о них дается в Справочном руководстве SQL Сервера.</p>
