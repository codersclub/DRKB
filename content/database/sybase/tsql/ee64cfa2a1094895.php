<h1>Запросы: выбор данных из таблицы</h1>
<div class="date">01.01.2007</div>


<p>Запросы: Выбор Данных из Таблицы</p>
</p>
Команда select (выбор) используется для извлечения данных из таблицы. Эту команду можно использовать для выбора данных как по строкам, так по столбцам из одной или нескольких таблиц.</p>
</p>
В данной главе рассматриваются следующие темы:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Выбор данных по всем столбцам таблицы.</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Выбор данных по указанным столбцам таблицы.</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Изменение формы представления результатов в операторе выбора путем переименования  заголовков столбцов и добаления символьных строк.</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Включение  простых вычисляемых величин в оператор выбора.</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Устранение одинаковых строк с помощью команды distinct (различные).</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Использование конструкции from (из) для указания таблиц и вьюверов (views).</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Использование в конструкции where (где) операций сравнения, логических операций, а также операций between (между), in (в), any (любой) и like (как).</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Использование значений null (неопределенный) и not null (определенный).</td></tr></table></div></p>
В этой главе основное внимание уделено простым запросам выбора данных из одной таблицы. Опытные пользователи могут найти для себя полезную информацию, касающуюся более сложных способов выбора, в последующих главах этого руководства.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Что такое Запросы ?</td></tr></table></div></p>
Запрос это обращение к базе данных с целью получения результирующих данных. Этот процесс также называется нахождением данных. Все SQL запросы выражаются через оператор выбора (select). Этот оператор можно использовать как для выбора записей (строк) из  одной или нескольких таблиц, так и для построения проекций (projections), т.е. выбора данных по некоторому подмножеству атрибутов (столбцов) из одной или нескольких таблиц.</p>
</p>
В упрощенном виде оператор select можно записать следующим образом:</p>
<pre>
select список_выбора 
from список_таблиц
where условия_выбора
</pre>
</p>
</p>
После ключевого слова select указываются атрибуты (столбцы), по которым осуществляется выбор данных. После ключевого слова from указываются таблицы, из которых происходит выбор данных по указанным атрибутам. После ключевого слова where указываются условия, по которым выбираются записи (строки) из таблиц. Например, в следующем операторе select из таблицы authors (авторы) выбираютя имена и фамилии писателей, живуших в Окленде.</p>
<pre>
select au_fname, au_lname 
from authors
where city = “Oakland”
</pre>
</p>
</p>
Результаты этого запроса могут иметь, например, следующий вид:</p>
</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>au_fname</p>
</td>
<td><p>au_lname</p>
</td>
</tr>
<tr>
<td><p>----------</p>
</td>
<td><p>--------------------</p>
</td>
</tr>
<tr>
<td><p>Marjorie</p>
</td>
<td><p>Green</p>
</td>
</tr>
<tr>
<td><p>Dick</p>
</td>
<td><p>Straight</p>
</td>
</tr>
<tr>
<td><p>Dick</p>
</td>
<td><p>Stringer</p>
</td>
</tr>
<tr>
<td><p>Stearns</p>
</td>
<td><p>MacFeather</p>
</td>
</tr>
<tr>
<td><p>Livia</p>
</td>
<td><p>Karsen
</td>
</table>
</tr>
(Выбрано 5 строк)</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Синтаксис оператора select</td></tr></table></div></p>
Синтаксис оператора select может быть и проще и сложнее по сравнению с приведенным выше примером. Проще, потому что единственным обязательным словом в этом операторе является само слово select. Конструкция from почти всегда присутствует в операторе выбора, но, строго говоря, она необходима только при выборе данных из таблиц. Конструкция where является необязательной, как и все остальные конструкции. С другой стороны, полный синтаксис оператора select включает следующие ключевые слова и фразы:</p>
</p>
select [all | distinct] список_выбора</p>
  [into  [[database.] owner.] название_таблицы]</p>
  [from [[database.] owner.] { название_таблицы | название_вьювера</p>
     [(index название_индекса [prefetch размер] [lru | mru] ) ] }</p>
              [holdlock | noholdlock] [shared]</p>
       [,[[database.] owner.] { название_таблицы | название_вьювера</p>
     [(index название_индекса [prefetch размер] [lru | mru] ) ] }</p>
              [ holdlock | noholdlock ] [shared] ] ... ]</p>
  [where условия_выбора ]</p>
  [group by [all] итоговое_выражение</p>
         [, итоговое_выражение ] ... ]</p>
  [having условия_поиска ]</p>
  [order by</p>
  { [[database.] owner.] { название_таблицы. | название_вьювера. } ]</p>
       название_столбца | номер_списка_выбора | выражение }</p>
                  [ask | desc]</p>
  [, { [[database.] owner.] { название_таблицы. | название_вьювера. } ]</p>
       название_столбца | номер_списка_выбора | выражение }</p>
                  [ask | desc] ... ]</p>
  [compute row_agregate (название_столбца)</p>
                [, row_agregate (название_столбца) ] ...</p>
           [by название_столбца [, название_столбца] ... ]]</p>
  [for {read only | update [of список_названий_столбцов] } ]</p>
  [at isolation {read uncommitted | read committed |</p>
          serializable} ]</p>
  [for browse]</p>
</p>
Конструкции в операторе выбора должны следовать в указанном здесь порядке. Другими словами, если оператор включает конструкции group by (группировка) и order by (сортировка), то конструкция group by должна предшествовать конструкции order by.</p>
</p>
Как отмечается в разделе “Идентификаторы”, название объектов базы данных должны дополняться (уточняться) в тех случаях, когда они имеют одинаковые имена и непонятно на какой из них указывает данное название. Например, если несколько столбцов (атрибутов) называются name (имя), то name должно быть дополнено либо названием базы данных, либо именем владельца, либо названием таблицы.</p>
</p>
Поскольку в этой главе рассматриваются в основном простые запросы, обращающиеся к одной таблице, то названия атрибутов обычно не будут дополняться названиями базы данных, именем владельца или именем таблицы, откуда они взяты. Эти компоненты не указываются, чтобы сделать примеры более наглядными, но следует помнить, что включение правильных уточнителей никогда не приведет к ошибке. В следующих разделах этой главы более подробно анализируется синтаксис оператора выбора.</p>
</p>
В этой главе рассматриваются лишь некоторые  конструкции и ключевые слова, составляющие  оператор select. Конструкции group by, having (имеющие), order by и compute (вычислить) будут рассмотрены в третьей главе “Итоговые значения, Группировка и Сортировка Результатов Запроса”. Конструкция into (в) описывается в главе 7 “Создание Баз данных и Таблиц”. Конструкция at isolation (изоляция) будет описана в главе 17 “Транзакции: Сохранение Целостности Данных и Восстановление”.</p>
</p>
Ключевые слова holdlock, noholdlock и shared (которые связаны с блокировкой доступа в SQL Сервере) и ключевое слово index (индекс) описываются в Руководство по оптимизации и настройке SQL Сервера.</p>
</p>
Замечание: Конструкция for browse не рассматривается в       данном руководстве. Она используется только в DB-Library&trade;- приложениях. Детали этой конструкции описываются в руководстве Open Client DB-Library/C Reference Manual.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Указание Столбцов в Запросе</td></tr></table></div></p>
Список выбора часто состоит из последовательности названий столбцов, разделенных запятыми, или из звездочки, указывающей на выбор по всем столбцам в порядке их следования в таблице.</p>
</p>
Однако, в этом списке могут находиться одно или несколько выражений, разделенных запятыми, которые могут быть константами, названиями столбцов, функциями, подзапросами, или любые их комбинации, соединенные между собой арифметическими или битовыми операциями и скобками. Общий синтаксис для списка выбора выглядит следующим образом:</p>
</p>
select expression [, expression]...</p>
from table_list</p>
</p>
Если хотя бы одно название таблицы или название столбца не является допустимым идентификатором, то необходимо установить опцию set quoted_identifier и заключить это название в двойные кавычки.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Выбор данных из всех столбцов: оператор seleс t *</td></tr></table></div></p>
Звездочка (*) имеет особое значение в операторах select. Она указывает на выбор данных по всем столбцам во всех таблицах, указанных в предложении from. Звездочку следует использовать для экономии времени и уменьшения числа ошибок, когда необходимо просмотреть все столбцы в таблице.</p>
</p>
Оператор выбора в этом случае имеет следующий общий вид:</p>
</p>
select *</p>
from table_list</p>
</p>
Поскольку оператор select * выбирает данные из всех столбцов таблицы, то любые изменения в структуре таблицы, такие как добавление, удаление или переименования столбцов автоматически изменяют результаты оператора select *. Явное указание столбцов позволяет более точно контролировать результаты запросов.</p>
С помощью следующего оператора выбираются все столбцы таблицы publishers (издатели) и выводятся в том порядке, в каком они расположены в этой таблице. Поскольку здесь не указан ограничитель where (где), то в результат включается каждая строка таблицы.</p>
</p>
select *</p>
from publishers</p>
Результат может выглядеть следующим образом:</p>
</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>pub_id</p>
</td>
<td><p>pub_name</p>
</td>
<td><p>city</p>
</td>
<td><p>state</p>
</td>
</tr>
<tr>
<td><p>----------</p>
</td>
<td><p>--------------------</p>
</td>
<td><p>--------</p>
</td>
<td><p>------------</p>
</td>
</tr>
<tr>
<td>0736</p>
</td>
<td>New Age Books</p>
</td>
<td>Boston</p>
</td>
<td>MA</p>
</td>
</tr>
<tr>
<td>0877</p>
</td>
<td>Binnet &amp; Hardley</p>
</td>
<td>Washington</p>
</td>
<td>DC</p>
</td>
</tr>
<tr>
<td>1389</p>
</td>
<td>lgodata Infosistems</p>
</td>
<td>Berkeley</p>
</td>
<td>CA
</td>
</table>
</tr>
</p>
(Выбрано 3 строки)</p>
</p>
Такой же результат будет получен, если по порядку указать названия всех столбцов после ключевого слова select:</p>
select pub_id, pub_name, city, state</p>
from publishers</p>
</p>
В запросе можно использовать звездочку (*) несколько раз:</p>
select *,*</p>
from publishers</p>
</p>
В результате каждое название столбца и все данные в столбце будут выведены дважды. Как и название столбца, звездочка может дополняться названием таблицы, что показано в следующем запросе:</p>
select publishers.*</p>
from publishers</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Выбор данных из указанных столбцов</td></tr></table></div></p>
Для выбора данных только из определенных столбцов таблицы, нужно использовать следующий синтаксис:</p>
</p>
select column_ name[, column_name]...</p>
from table_name</p>
</p>
Каждое название столбца должно быть отделено от предшествующего запятой.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Изменение порядка следования столбцов</td></tr></table></div></p>
Порядок, в котором названия столбцов указываются в запросе, определяет порядок, в котором данные из этих столбцов будут выводиться в результате запроса. Следующие два примера показывают, как изменять порядок следования столбцов. В каждом из них выводятся наименования издателей и их идентификационные номера из трех строк таблицы publishers. В первом примере сначала выводится номер из столбца pub_id, а затем наименование из столбца pub_name, а во втором - наоборот. В обоих примерах по существу выводится одинаковая информация, но форма ее представления различна.</p>
</p>
select pub_id, pub_name</p>
from publishers</p>
</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>pub_id</p>
</td>
<td><p>pub_name</p>
</td>
</tr>
<tr>
<td><p>----------</p>
</td>
<td><p>--------------------</p>
</td>
</tr>
<tr>
<td>0736</p>
</td>
<td>New Age Books</p>
</td>
</tr>
<tr>
<td>0877</p>
</td>
<td>Binnet &amp; Hardley</p>
</td>
</tr>
<tr>
<td>1389</p>
</td>
<td>lgodata Infosistems
</td>
</table>
</tr>
</p>
(Выбрано 3 строки)</p>
</p>
select pub_name, pub_id</p>
from publishers</p>
</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td>pub_name</p>
</td>
<td>pub_id</p>
</td>
</tr>
<tr>
<td>--------------------</p>
</td>
<td>------------------</p>
</td>
</tr>
<tr>
<td>New Age Books</p>
</td>
<td>0736</p>
</td>
</tr>
<tr>
<td>Binnet &amp; Hardley</p>
</td>
<td>0877</p>
</td>
</tr>
<tr>
<td>lgodata Infosistems</p>
</td>
<td>1389
</td>
</table>
</tr>
</p>
(3 строки выведены)</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Переименование столбцов в запросе</td></tr></table></div></p>
В процессе вывода результатов запроса по умолчанию предполагается, что заголовок каждого столбца совпадает с его названием в таблице. Однако это заголовок можно изменить, используя одно из следующих предложений:</p>
</p>
 column_heading= column_name</p>
или</p>
column_name _column_heading</p>
или</p>
column_name _as_ column_heading</p>
</p>
Этой заменой целесообразно пользоваться, когда измененное название столбца является более удобным для чтения. Например, для изменения названия столбца pub_name на "Publishers" в предыдущем запросе можно воспользоваться одним из следующих операторов:</p>
</p>
select Publisher = pub_name, pub_id</p>
from publishers</p>
</p>
select pub_name Publisher, pub_id</p>
from publishers</p>
</p>
select pub_name as Publisher, pub_id</p>
from publishers</p>
</p>
Результат будет выглядеть следующим образом:</p>
</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Publisher</p>
</td>
<td><p>pub_id</p>
</td>
</tr>
<tr>
<td><p>--------------------</p>
</td>
<td><p>----------</p>
</td>
</tr>
<tr>
<td><p>New Age Books</p>
</td>
<td><p>0736</p>
</td>
</tr>
<tr>
<td><p>Binnet &amp; Hardley</p>
</td>
<td><p>0877</p>
</td>
</tr>
<tr>
<td><p>lgodata Infosistems</p>
</td>
<td><p>1389
</td>
</table>
</tr>
 (3 строки выведены)</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Заключенные в кавычки заголовки столбцов</td></tr></table></div></p>
В заголовке столбца можно использовать любые символы, даже пробелы, если его заключить в кавычки. При этом не обязательно включать опцию quoted_identifier. Если заголовок столбца не ограничен кавычками, то он должен подчиняться правилу, действующему для идентификаторов. Оба из следующих запросов:</p>
</p>
select "Publisher's Name" = pub_name from publishers</p>
и</p>
select pub_name "Publisher's Name" from publishers</p>
</p>
порождают одинаковый результат:</p>
</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Publisher&#8217;s Name</p>
</td>
</tr>
<tr>
<td><p>--------------------------------</p>
</td>
</tr>
<tr>
<td><p>New Age Books</p>
</td>
</tr>
<tr>
<td><p>Binnet &amp; Hardley</p>
</td>
</tr>
<tr>
<td><p>lgodata Infosistems
</td>
</table>
</tr>
</p>
Кроме того, в заголовках столбцов можно также использовать зарезервированные слова языка Transact-SQL, заключенные в кавычки. Например, в следующем запросе зарезервированное слово sum используется как заголовок столбца:</p>
</p>
select "sum" = sum(total_sales) from titles</p>
</p>
Длина заголовка столбца, заключенного в кавычки, не должны превышать 30 байтов.</p>
</p>
                               Замечание: Перед использованием кавычек в названиях столбцов в операторах   create table, alter table, select into, create view необходимо включить опцию set quoted_identifier.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Символьные строки в результатах запросов</td></tr></table></div></p>
Как было сказано выше, оператор select выбирает данные из таблиц, указанных в предложении from (из). Кроме этого, в результат запроса можно включать символьные строки.</p>
</p>
Для этого строку символов нужно заключить в апострофы или кавычки и отделить от других элементов списка выбора запятыми. Если в символьной строке встречается апостроф, то эту строку необходимо заключить в кавычки, иначе апостроф будет интерпретироваться как признак начала или конца строки.</p>
</p>
Ниже приведен пример запроса, перед результатами которого выводится символьная строка:</p>
</p>
select "The publisher's name is", Publisher = pub_name</p>
from publishers</p>
</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td></p>
</td>
<td>Publisher</p>
</td>
</tr>
<tr>
<td>---------------------------------------</p>
</td>
<td>------------------------------------</p>
</td>
</tr>
<tr>
<td>The publisher's name is</p>
</td>
<td>New Age Books</p>
</td>
</tr>
<tr>
<td><p>The publisher's name is</p>
</td>
<td><p>Binnet &amp; Hardley</p>
</td>
</tr>
<tr>
<td><p>The publisher's name is</p>
</td>
<td><p>Algodata Infosystems
</td>
</table>
</tr>
</p>
(Выбраны 3 строки)</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Вычисляемые значения в списке выбора</td></tr></table></div></p>
Над числовыми данными из столбцов, указанных в операторе выбора, можно выполнять вычисления с использованием числовых констант.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Арифметические операции</td></tr></table></div>В приведенной ниже таблице указаны арифметические операции, которые можно выполнять над данными. Информацию о логических операциях над битами можно посмотреть в Справочном руководстве SQL Сервера.</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Символ операции</p>
</td>
<td><p>Операция</p>
</td>
</tr>
<tr>
<td><p>+</p>
</td>
<td><p>Сложение</p>
</td>
</tr>
<tr>
<td><p>-</p>
</td>
<td><p>Вычитание</p>
</td>
</tr>
<tr>
<td><p>/</p>
</td>
<td><p>Деление</p>
</td>
</tr>
<tr>
<td><p>*</p>
</td>
<td><p>Умножение</p>
</td>
</tr>
<tr>
<td><p>%</p>
</td>
<td><p>Остаток от деления
</td>
</table>
</tr>
</p>
Таблица 2-1: Арифметические операции</p>
</p>
Арифметические операции - сложение, вычитание, умножение и деление - выполняются над данными любого числового типа: int , smallint, tinyint, numeric, decimal, float, money. Операция взятия по модулю не может использоваться для данных типа money. Взятие по модулю это целочисленная операция, которая двум целым числам сопоставляет остаток от деления первого на второе. Например, 21%9 = 3, поскольку частное от деления 21 на 9 равняется 2, а остаток 3.</p>
</p>
Некоторые арифметические операции могут также выполняться над данными типа datetime (дата, время) с помощью функций, работающих с датами. Эти функции приводятся в главе 10 "Использование встроенных функций в запросах". Все вышеперечисленные операции могут использоваться в списке выбора в любой комбинации с названиями столбцов и числовыми константами. Например, чтобы увидеть увеличенные на 100 процентов объемы продаж книг из таблицы titles, достаточно выполнить следующий запрос:</p>
<pre>
select title_id, total_sales, total_sales * 2
from titles
</pre>
</p>
Результаты будут выглядеть следующим образом:</p>
</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>title_id</p>
</td>
<td><p>total_sales</p>
</td>
<td>
</td>
</tr>
<tr>
<td><p>------------</p>
</td>
<td><p>--------------</p>
</td>
<td><p>----------</p>
</td>
</tr>
<tr>
<td><p>BU1032</p>
</td>
<td><p>4095</p>
</td>
<td><p>8190</p>
</td>
</tr>
<tr>
<td><p>BU1111</p>
</td>
<td><p>3876</p>
</td>
<td><p>7752</p>
</td>
</tr>
<tr>
<td><p>BU2075</p>
</td>
<td><p>18722</p>
</td>
<td><p>37444</p>
</td>
</tr>
<tr>
<td><p>BU7832</p>
</td>
<td><p>4095</p>
</td>
<td><p>8190</p>
</td>
</tr>
<tr>
<td><p>MC2222</p>
</td>
<td><p>2032</p>
</td>
<td><p>4064</p>
</td>
</tr>
<tr>
<td><p>MC3021</p>
</td>
<td><p>22246</p>
</td>
<td><p>44492</p>
</td>
</tr>
<tr>
<td><p>MC3026</p>
</td>
<td><p>NULL</p>
</td>
<td><p>NULL</p>
</td>
</tr>
<tr>
<td><p>PC1035</p>
</td>
<td><p>8780</p>
</td>
<td><p>17560</p>
</td>
</tr>
<tr>
<td><p>PC8888</p>
</td>
<td><p>4095</p>
</td>
<td><p>8190</p>
</td>
</tr>
<tr>
<td><p>PC9999</p>
</td>
<td><p>NULL</p>
</td>
<td><p>NULL</p>
</td>
</tr>
<tr>
<td><p>PS1372</p>
</td>
<td><p>375</p>
</td>
<td><p>750</p>
</td>
</tr>
<tr>
<td><p>PS2091</p>
</td>
<td><p>2045</p>
</td>
<td><p>4090</p>
</td>
</tr>
<tr>
<td><p>PS2106</p>
</td>
<td><p>111</p>
</td>
<td><p>222</p>
</td>
</tr>
<tr>
<td><p>PS3333</p>
</td>
<td><p>4072</p>
</td>
<td><p>8144</p>
</td>
</tr>
<tr>
<td><p>PS7777</p>
</td>
<td><p>33</p>
</td>
<td><p>6672</p>
</td>
</tr>
<tr>
<td><p>TC3218</p>
</td>
<td><p>375</p>
</td>
<td><p>750</p>
</td>
</tr>
<tr>
<td><p>TC4203</p>
</td>
<td><p>1596</p>
</td>
<td><p>30192</p>
</td>
</tr>
<tr>
<td><p>TC7777</p>
</td>
<td><p>4095</p>
</td>
<td><p>8190
</td>
</table>
</tr>
</p>
(Выбрано 18 строк)</p>
</p>
Следует обратить внимание на пустые значения (NULL) в столбце total_sales и вычисляемом столбце. Пустое значение не имеет точно определенной величины, поэтому выполнение любой арифметической операции над пустым значением приводит снова к пустому значению. Столбцу с вычисленным значением можно дать заголовок "proj_sale" (план продаж):</p>
</p>
select title_id, total_sales,</p>
          proj_sales = total_sales*2</p>
from titles</p>
</p>
Можно также добавить символьные строки "Current sales=" и "Projected sales are" в оператор select. Столбец, из которого выбирались исходные значения, не обязательно включать в список выбора. Например, в приведенных примерах столбец total_sales показан только для сравнения его значений со значениями вычисленного столбца total_sales*2. Для того, чтобы увидеть только вычисленные значения, необходимо выполнить следующий запрос:</p>
</p>
select title_id, total_sales*2</p>
from titles</p>
</p>
Можно также выполнять арифметические операции непосредственно над значениями данных в указанных столбцах без использования констант. Например:</p>
select title_id, total_sales * price</p>
from titles</p>
</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td colspan="2" ><p>title_id</p>
</td>
<td colspan="2" ><br>
</td>
</tr>
<tr>
<td colspan="2" ><p>------------</p>
</td>
<td colspan="2" ><p>---------------</p>
</td>
</tr>
<tr>
<td colspan="2" ><p>BUI032</p>
</td>
<td colspan="2" ><p>81,859.05</p>
</td>
</tr>
<tr>
<td colspan="2" ><p>BU1111</p>
</td>
<td colspan="2" ><p>46,318.20</p>
</td>
</tr>
<tr>
<td colspan="2" ><p>BU2075</p>
</td>
<td colspan="2" ><p>55,978.20</p>
</td>
</tr>
<tr>
<td colspan="2" ><p>BU7832</p>
</td>
<td colspan="2" ><p>81,859.05</p>
</td>
</tr>
<tr>
<td><br>
</td>
<td colspan="2" ><p>MC2222</p>
</td>
<td><p>40,619.68</p>
</td>
</tr>
<tr>
<td><br>
</td>
<td colspan="2" ><p>MC3021</p>
</td>
<td><p>66,515.54</p>
</td>
</tr>
<tr>
<td><br>
</td>
<td colspan="2" ><p>MC3026</p>
</td>
<td><p>NULL</p>
</td>
</tr>
<tr>
<td><br>
</td>
<td colspan="2" ><p>PC1035</p>
</td>
<td><p>201,501.00</p>
</td>
</tr>
<tr>
<td><br>
</td>
<td colspan="2" ><p>PC8888</p>
</td>
<td><p>81,900.00</p>
</td>
</tr>
<tr>
<td><br>
</td>
<td colspan="2" ><p>PC9999</p>
</td>
<td><p>NULL</p>
</td>
</tr>
<tr>
<td><br>
</td>
<td colspan="2" ><p>PS1372</p>
</td>
<td><p>8,096.25</p>
</td>
</tr>
<tr>
<td><br>
</td>
<td colspan="2" ><p>PS2091</p>
</td>
<td><p>22,392.75</p>
</td>
</tr>
<tr>
<td><br>
</td>
<td colspan="2" ><p>PS2106</p>
</td>
<td><p>777.00</p>
</td>
</tr>
<tr>
<td><br>
</td>
<td colspan="2" ><p>PS3333</p>
</td>
<td><p>81,399.28</p>
</td>
</tr>
<tr>
<td><br>
</td>
<td colspan="2" ><p>PS7777</p>
</td>
<td><p>26,654.64</p>
</td>
</tr>
<tr>
<td><br>
</td>
<td colspan="2" ><p>TC3218</p>
</td>
<td><p>7,856.25</p>
</td>
</tr>
<tr>
<td><br>
</td>
<td colspan="2" ><p>TC4203</p>
</td>
<td><p>180,397.20</p>
</td>
</tr>
<tr>
<td><br>
</td>
<td colspan="2" ><p>TC7777</p>
</td>
<td><p>61,384.05
</td>
</table>
</tr>
</p>
(Выбрано 18 строк)</p>
</p>
Наконец, исходные данные для вычисления можно выбирать из нескольких таблиц. В главах, где рассмотрены соединение таблиц и подзапросы, дается более полная инфомацию о том, как работать с запросами из нескольких таблиц, а здесь приведем лишь небольшой пример.</p>
</p>
Следующий запрос вычисляет сумму, вырученную от продажи книги по психологии, по количеству проданных экземпляров (столбец qty в таблице salesdetail), и их цене (столбец price из таблицы titles):</p>
</p>
select salesdetail.title_id, stor_id, qty * price</p>
from titles, salesdetail</p>
where titles.title_id = salesdetail.title_id</p>
and titles.title_id = "PS2106"</p>
</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>title_id</p>
</td>
<td><p>stor_id</p>
</td>
<td>
</td>
<td rowspan="2"><br>
</td>
</tr>
<tr>
<td><p>---------------</p>
</td>
<td><p>------------</p>
</td>
<td><p>---------------</p>
</td>
</tr>
<tr>
<td><p>PS2106</p>
</td>
<td><p>8042</p>
</td>
<td colspan="2" ><p>210.00</p>
</td>
</tr>
<tr>
<td><p>PS2106</p>
</td>
<td><p>8042</p>
</td>
<td colspan="2" ><p>350.00</p>
</td>
</tr>
<tr>
<td><p>PS2106</p>
</td>
<td><p>8042</p>
</td>
<td colspan="2" ><p>217.00
</td>
</table>
</tr>
</p>
(Выбрано 3 строки)</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Старшинство Арифметических Операций</td></tr></table></div></p>
Если в арифметическом выражении присутствуют несколько операций, то первыми выполняются умножение, деление и взятие по модулю, а затем сложение и вычитание. Если все операции в арифметическом выражении имеют одинаковое старшинство, то они выполняются слева направо. Выражения, взятые в скобки, вычисляются в первую очередь.</p>
</p>
Например, в следующем операторе select общее количество проданных книг умножается на их цену для вычисления вырученной суммы, а затем из этой суммы вычитается половина авторского аванса.</p>
</p>
Первым вычисляется произведение чисел из столбцов total_sales и price, затем аванс делится пополам и результат деления вычитается из полученного произведения.</p>
</p>
select title_id, total_sales * price - advance / 2</p>
from titles</p>
</p>
Чтобы избежать недоразумений, следует использовать скобки. Следующий запрос порождает такой же результат как и в предыдущий, но выглядит более простым для понимания:</p>
</p>
select title_id, (total_sales * price) - (advance / 2)</p>
from titles</p>
</p>
<table cellspacing="0" cellpadding="3" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>title_id</p>
</td>
<td>
</td>
<td rowspan="9"><br>
</td>
</tr>
<tr>
<td><p>----------------</p>
</td>
<td><p>-----------------</p>
</td>
</tr>
<tr>
<td><p>BUI032</p>
</td>
<td><p>79359.05</p>
</td>
</tr>
<tr>
<td><p>BU1111</p>
</td>
<td><p>43818.20</p>
</td>
</tr>
<tr>
<td><p>BU2075</p>
</td>
<td><p>50916.28</p>
</td>
</tr>
<tr>
<td><p>BU7832</p>
</td>
<td><p>79359.05</p>
</td>
</tr>
<tr>
<td><p>MC2222</p>
</td>
<td><p>40619.68</p>
</td>
</tr>
<tr>
<td><p>MC3021</p>
</td>
<td><p>59015.54</p>
</td>
</tr>
<tr>
<td><p>MC3026</p>
</td>
<td><p>NULL</p>
</td>
</tr>
<tr>
<td><p>PC1035</p>
</td>
<td colspan="2" ><p>198001.00</p>
</td>
</tr>
<tr>
<td><p>PC8888</p>
</td>
<td colspan="2" ><p>77900.00</p>
</td>
</tr>
<tr>
<td><p>PC9999</p>
</td>
<td colspan="2" ><p>NULL</p>
</td>
</tr>
<tr>
<td><p>PS1372</p>
</td>
<td colspan="2" ><p>4596.25</p>
</td>
</tr>
<tr>
<td><p>PS2091</p>
</td>
<td colspan="2" ><p>1255.25</p>
</td>
</tr>
<tr>
<td><p>PS2106</p>
</td>
<td colspan="2" ><p>-2223.00</p>
</td>
</tr>
<tr>
<td><p>PS3333</p>
</td>
<td colspan="2" ><p>80399.28</p>
</td>
</tr>
<tr>
<td><p>PS7777</p>
</td>
<td colspan="2" ><p>24654.64</p>
</td>
</tr>
<tr>
<td><p>TC3218</p>
</td>
<td colspan="2" ><p>4356.25</p>
</td>
</tr>
<tr>
<td><p>TC4203</p>
</td>
<td colspan="2" ><p>178397.20</p>
</td>
</tr>
<tr>
<td><p>TC7777</p>
</td>
<td colspan="2" ><p>57384.05
</td>
</table>
</tr>
</p>
(Выбрано 18 строк)</p>
</p>
Скобки можно использовать для изменения порядка выполнения операций; тогда первыми, будут выполняться действия в скобках. Если встречаются вложенные скобки, то выполнение начинается с самых внутренних скобок. В следующем примере с помощью скобок изменен порядок выполнения операций, для того чтобы вычитание выполнялось перед делением.</p>
</p>
select title_id , (total_sales * price - advance) / 2</p>
from titles</p>
</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>title_id</p>
</td>
<td>
</td>
</tr>
<tr>
<td><p>-------------</p>
</td>
<td><p>----------------------</p>
</td>
</tr>
<tr>
<td><p>BUI032</p>
</td>
<td><p>38429.53</p>
</td>
</tr>
<tr>
<td><p>BU1111</p>
</td>
<td><p>20659.10</p>
</td>
</tr>
<tr>
<td><p>BU2075</p>
</td>
<td><p>22926.89</p>
</td>
</tr>
<tr>
<td><p>BU7832</p>
</td>
<td><p>38429.53</p>
</td>
</tr>
<tr>
<td><p>MC2222</p>
</td>
<td><p>20309.84</p>
</td>
</tr>
<tr>
<td><p>MC3021</p>
</td>
<td><p>25757.77</p>
</td>
</tr>
<tr>
<td><p>MC3026</p>
</td>
<td><p>NULL</p>
</td>
</tr>
<tr>
<td><p>PC1035</p>
</td>
<td><p>97250.50</p>
</td>
</tr>
<tr>
<td><p>PC8888</p>
</td>
<td><p>36950.00</p>
</td>
</tr>
<tr>
<td><p>PC9999</p>
</td>
<td><p>NULL</p>
</td>
</tr>
<tr>
<td><p>PS1372</p>
</td>
<td><p>548.13</p>
</td>
</tr>
<tr>
<td><p>PS2091</p>
</td>
<td><p>10058.88</p>
</td>
</tr>
<tr>
<td><p>PS2106</p>
</td>
<td><p>-2611.50</p>
</td>
</tr>
<tr>
<td><p>PS3333</p>
</td>
<td><p>39699.64</p>
</td>
</tr>
<tr>
<td><p>PS7777</p>
</td>
<td><p>11327.32</p>
</td>
</tr>
<tr>
<td><p>TC3218</p>
</td>
<td><p>428.13</p>
</td>
</tr>
<tr>
<td><p>TC4203</p>
</td>
<td><p>88198.60</p>
</td>
</tr>
<tr>
<td><p>TC7777</p>
</td>
<td><p>26692.03
</td>
</table>
</tr>
</p>
(Выбрано 18 строк)</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Выбор текстовых и графических значений</td></tr></table></div></p>
Когда в списке выбора имеются текстовые (text) и графические (image) данные, то ограничение на длину выходных результатов зависит от значения глобальной переменной @@textsize. Значение, установленное по умолчанию для этой переменной, зависит от системных программ, которые обеспечивают доступ к SQL-серверу, и для утилиты ISQL оно равно 32К. Значение этой переменной можно изменять с помощью команды set (установить):</p>
</p>
set textsize 25</p>
</p>
После этой установки в запросах будут выводиться только первые 25 байтов в столбцах с текстовыми данными.</p>
</p>
                              Замечание: Когда производится выбор графических данных, то в результат    включаются символы "0х", которые указывают на то, что данные представлены в шестнадцатиричном виде. Эти два символа необходимо учитывать при установке значения глобальной переменной @@textsize.</p>
</p>
Для установки первоначального значения (32К) глобальной переменной @@textsize  следует использовать оператор:</p>
</p>
set textsize 0</p>
</p>
По умолчанию в результат включается полный текст, если его длина меньше чем значение переменной @@textsize. Более подробная информации о текстовых и графических типах данных дается в главе 6 "Использование и Создание Типов Данных".</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Использование оператора readtext</td></tr></table></div></p>
Команда readtext (читать текст) обеспечивает другой способ выбора текстовых и графических значений. В этой команде в качестве аргументов указываются название таблицы и столбца, текстовый указатель, начальное смещение внутри текста и количество символов или байтов, которые необходимо выбрать. В следующем примере выводятся 6 символов из столбца copy в таблице blurbs:</p>
</p>
declare @val varbinary (16)</p>
select @val = textptr(copy) from blurbs</p>
where au_id = "648-92-1872"</p>
readtext blurbs.copy @val 2 6 using chars</p>
</p>
В этом примере команда readtext выводит с 3 по 8 символы из столбца copy, поскольку смещение равно 2. Полный синтаксис команды readtext имеет следующий вид:</p>
</p>
readtext [[database.]owner.]table_name.column_name  text_ptr  offset</p>
     size [holdlock]</p>
[using {bytes I chars I characters}]</p>
[at isolation {read uncommited I read commited I serializable</p>
</p>
Функция textptr (текстовый указатель) возвращает 16-байтовую двоичную строку. Необходимо объявить локальную переменную для текстового указателя, а затем использовать эту переменную в команде readtext. Флаг holdlock (защелка) фиксирует текстовое значение до окончания текущей транзакции. Другие пользователи могут только читать этот текст, не изменяя его. Конструкция at isolation описана в главе 17, "Транзакции: Сохранение Целостности Данных и Восстановление”.</p>
</p>
При использовании многобайтовых символов опция using позволяет уточнить в команде readtext как интерпретировать величину смещения в байтах или в символах.</p>
</p>
Для указания смещения в символах можно использвать как chars, так и characters. Эта опция игнорируется при использовании однобайтовых символов или графических значений (команда readtext читает графические данные только по байтам). Если опция using отсутствует, то по умолчанию смещение задается в байтах.</p>
</p>
SQL сервер должен определить количество байтов, которые нужно послать клиенту (пользователю) в ответ на команду readtext. Когда смещение и размер указаны в байтах, то определение количества возвращаемых байтов не представляет труда. Когда смещение и размер указаны в символах, то SQL-сервер должен выполнить дополнительный шаг для вычисления количества байтов выводимого для клиента текста. В результате, во втором случае запрос может выполняться медленнее, поэтому использование опции using characters полезно только тогда, когда SQL-сервер использует множество многобайтовых символов. Эта опция гарантирует, что команда readtext не выдаст только часть символов.</p>
</p>
Когда смещение указывается в байтах, SQL-сервер может встретить только часть кода символа в начале или в конце текста, который нужно вернуть. Если такая ситуация возникла, то перед выдачей текста пользователю сервер заменяет каждый неполный символ знаком вопроса.</p>
</p>
Команду readtext нельзя использовать для выбора текстовых и графических данных во вьюверах.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Резюме относительно списка выбора</td></tr></table></div></p>
Итак, список выбора может содержать звездочку * (выбор всех столбцов в том порядке, в каком они создавались), названия столбцов, перечисленных в любом порядке, символьные строки, заголовки столбцов и выражения, содержащие арифметические операции. Можно также включить сюда аггрегирующие функции, о которых упоминалось в этой главе в разделе о конструкции группировки (group by), и в главе 3 "Подведение итогов, Группировка и Сортировка Результатов Запроса". Приведем здесь еще несколько примеров операторов выбора, обращающихся к демонстрационной базе данных pubs2:</p>
</p>
1. select titles.*</p>
   from titles</p>
</p>
2. select Name = au_fname, Surname = au_lname</p>
   from authors</p>
</p>
3. select Sales = total_sales * price,</p>
   ToAuthor = advance,</p>
   ToPublisher = (total_sales * price) - advance</p>
   from titles</p>
</p>
4. select 'Social security #', au_id</p>
   from authors</p>
</p>
5. select this_year = advance, next_year = advance + advance/10,</p>
           third_year = advance/2,</p>
          'for book title #', title_id</p>
   from titles</p>
</p>
6.select 'Total income is',</p>
   Revenue = price * total_sales,</p>
  'for', Book# = title_id</p>
   from titles</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Исключение дубликатов из результата запроса с помощью distinct</td></tr></table></div></p>
Необязательное ключевое слово distinct (различные) исключает повторяющиеся строки из результата выполнения оператора выбора.</p>
</p>
Если слово distinct не было указано, то в результат попадают все строки, включая повторяющиеся. Такой же результат получится, если в начале списка выбора указано ключевое слово all (все). Таким образом, по умолчанию в начале списка выбора подразумевается ключевое слово all.</p>
</p>
Например, если выбираются все идентификационные коды писателей из таблицы titleauthor без ключевого слова distinct , то в результат попадут следующие строки:</p>
</p>
select au_id</p>
from titleauthor</p>
</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>au_id</p>
</td>
</tr>
<tr>
<td><p>-------------------</p>
</td>
</tr>
<tr>
<td><p>172-32-1176</p>
</td>
</tr>
<tr>
<td><p>213-46-8915</p>
</td>
</tr>
<tr>
<td><p>213-46-8915</p>
</td>
</tr>
<tr>
<td><p>238-95-7766</p>
</td>
</tr>
<tr>
<td><p>267-41-2394</p>
</td>
</tr>
<tr>
<td><p>267-41-2394</p>
</td>
</tr>
<tr>
<td><p>274-80-9391</p>
</td>
</tr>
<tr>
<td><p>409-56-7008</p>
</td>
</tr>
<tr>
<td><p>427-17-2319</p>
</td>
</tr>
<tr>
<td><p>472-27-2349</p>
</td>
</tr>
<tr>
<td><p>486-29-1786</p>
</td>
</tr>
<tr>
<td><p>486-29-1786</p>
</td>
</tr>
<tr>
<td><p>648-92-1872</p>
</td>
</tr>
<tr>
<td><p>672-71-3249</p>
</td>
</tr>
<tr>
<td><p>712-45-1867</p>
</td>
</tr>
<tr>
<td><p>722-51-5454</p>
</td>
</tr>
<tr>
<td><p>724-80-9391</p>
</td>
</tr>
<tr>
<td><p>724-80-9391</p>
</td>
</tr>
<tr>
<td><p>756-30-7391</p>
</td>
</tr>
<tr>
<td><p>807-91-6654</p>
</td>
</tr>
<tr>
<td><p>846-92-7186</p>
</td>
</tr>
<tr>
<td><p>899-46-2035</p>
</td>
</tr>
<tr>
<td><p>899-46-2035</p>
</td>
</tr>
<tr>
<td><p>998-72-3567</p>
</td>
</tr>
<tr>
<td><p>998-72-3567
</td>
</table>
</tr>
</p>
(Выбрано 25 строк)</p>
</p>
Из этого результата видно, что некоторые строки повторяются. Дублирование можно исключить с помощью ключевого слова distinct и получить только различные номера:</p>
</p>
select distinct au_id</p>
from titleauthor</p>
</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>au_id</p>
</td>
</tr>
<tr>
<td>
</td>
</tr>
<tr>
<td><p>172-32-1176</p>
</td>
</tr>
<tr>
<td><p>213-46-8915</p>
</td>
</tr>
<tr>
<td><p>238-95-7766</p>
</td>
</tr>
<tr>
<td><p>-------------------</p>
</td>
</tr>
<tr>
<td><p>274-80-9391</p>
</td>
</tr>
<tr>
<td><p>409-56-7008</p>
</td>
</tr>
<tr>
<td><p>427-17-2319</p>
</td>
</tr>
<tr>
<td><p>472-27-2349</p>
</td>
</tr>
<tr>
<td><p>486-29-1786</p>
</td>
</tr>
<tr>
<td><p>648-92-1872</p>
</td>
</tr>
<tr>
<td><p>672-71-3249</p>
</td>
</tr>
<tr>
<td><p>712-45-1867</p>
</td>
</tr>
<tr>
<td><p>722-51-5454</p>
</td>
</tr>
<tr>
<td><p>724-80-9391</p>
</td>
</tr>
<tr>
<td><p>756-30-7391</p>
</td>
</tr>
<tr>
<td><p>807-91-6654</p>
</td>
</tr>
<tr>
<td><p>846-92-7186</p>
</td>
</tr>
<tr>
<td><p>899-46-2035</p>
</td>
</tr>
<tr>
<td><p>998-72-3567
</td>
</table>
</tr>
</p>
(Выбрано 19 строк)</p>
</p>
                              Замечание:   Для совместимости с другими реализациями языка SQL, допускается  использование ключевого слова all для явного указания на выбор всех строк. Однако, как правило, нет необходимости в использовании этого слова, поскольку выбор "всех строк" подразумевается по умолчанию.</p>
</p>
При указании слова distinct пустые значения (null) рассматриваются как повторяющиеся. Другими словами, если в операторе выбора указано слово distinct, то возвращается всегда не более одного пустого значения, независисмо от того сколько пустых значений встречается в базе данных.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Указание таблиц: конструкция from</td></tr></table></div></p>
Конструкция from (из) необходима в каждом операторе select, выбирающем данные из таблиц или вьюверов. Она используется для перечисления всех таблиц и вьюверов, содержащих столбцы, указанные в списке выбора и в конструкции where (где). Если конструкция from содержит более одной таблицы или вьювера, то их названия разделяются запятыми.</p>
</p>
Максимальное количество таблиц и вьюверов, которое можно указать в запросе, равно 16. Это число включает таблицы, перечисленные в конструкции from, базовые таблицы, указанные в определении вьювера, все таблицы, упомянутые в подзапросах, а также все таблицы, которые выбираются по ограничениям ссылочной целостности.</p>
</p>
Синтаксис конструкции from выглядит следующим образом:</p>
</p>
select select _list</p>
  [from [[database.]owner.]{table_name I view_name}</p>
                  [holdlock I noholdlock] [shared]</p>
          [,[[database.]owner.]{table_name I view_name}</p>
                [holdlock I noholdlock] [shared]]... ]</p>
</p>
Названия таблиц могут иметь длину от 1 до 30 байтов. В качестве первого символа можно использовать буквы, а также символы @, #, или _. Следующие символы могут быть цифрами, буквами,или символами: @, #, $, _,Ґили Ј. Названия временных таблиц должны либо начинаться с символа # (номер), если они созданы вне базы данных tempbd, либо предваряться префиксом “tempbd..”. Если временная таблица создается вне базы tempbd, то ее название не должно превышать 13 байтов в длину, поскольку SQL-сервер добавляет к названиям временных таблиц внутренний числовой суффикс для того, чтобы это название было уникальным. Дополнительную  информацию о названиях можно посмотреть в главе 7, ”Создание Баз Данных и Таблиц”. В конструкции from полное название для таблиц и вьюверов выглядит следующим образом:</p>
</p>
database.owner.table_name</p>
database.owner.view_name</p>
</p>
Полное название необходимо указывать только в том случае, когда может возникнуть неопределнность относительно названий. Для экономии времени можно указывать в списке выбора сокращенные (correlation) названия таблиц. Эти сокращенные названия должны быть также указаны в конструкции from после названия таблицы, наример:</p>
</p>
select p.pub_id, p.pub_name</p>
from publishers p</p>
</p>
Во всех остальных конструкциях этого оператора, например в конструкции where, при обращениях к этой таблице должны использоваться сокращенные названия. Сокращенные названия не могут начинаться с цифры.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Выбор строк: конструкция where</td></tr></table></div></p>
Конструкция where в операторе select определяет критерий (условие) для отбора строк. Общий формат этой конструкции имеет следующий вид:</p>
</p>
select select_list</p>
   from table_list</p>
   where search_conditions</p>
</p>
Условия отбора (search conditions) или ограничители, в конструкции where включают:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>операции сравнения (=, &lt;, &gt;, и т.д.)</td></tr></table></div>          where advance * 2 &gt; total _sales * price</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Интервалы попадания (between и not between)</td></tr></table></div>          where total_sales between 4095 and 12000</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>списки принадлежности (in ,not in)</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>      where state in (“CA”, “IN”, “MD”)</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>вхождение подстрок (like и not like)</td></tr></table></div>      where phone not like “415%”</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>неопределенные значения (is null и is not null)</td></tr></table></div>          where advance is null</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>комбинации вышеприведенных условий через логические операции (and,or)</td></tr></table></div>          where advance &lt; 5000 or total_sales between 2000 and 2500</p>
</p>
Кроме того, ключевое слово where может вводить:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Условия соединения (см.главу 4:”Соединения: Выбор Данных из Нескольких Таблиц”)</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Подзапросы (см.главу 5:”Подзапросы: Использование Запросов в Других Запросах”.</td></tr></table></div></p>
                                 Замечание:   Единственной операцией отбора, которую можно использовать в конструкции where для текстовых данных (text), является операция вхождение подстрок like (или not like.)</p>
</p>
Полный список всех допустимых условий отбора можно посмотреть в разделах: “Допустимые Условия” и “Конструкция clause” в Руководстве пользователя по SQL-серверу.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Операции Сравнения</td></tr></table></div></p>
В языке Transact-SQL используются следующие операции сравнения:</p>
</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td>Оператор</p>
</td>
<td>Значение</p>
</td>
</tr>
<tr>
<td>=</p>
</td>
<td>Равно</p>
</td>
</tr>
<tr>
<td>&gt;</p>
</td>
<td>Больше</p>
</td>
</tr>
<tr>
<td>&lt;</p>
</td>
<td>Меньше</p>
</td>
</tr>
<tr>
<td>&gt;</p>
</td>
<td>Больше или равно</p>
</td>
</tr>
<tr>
<td>&lt;=</p>
</td>
<td>Меньше или равно</p>
</td>
</tr>
<tr>
<td>!=</p>
</td>
<td>Не равно</p>
</td>
</tr>
<tr>
<td>&lt;&gt;</p>
</td>
<td>Не равно</p>
</td>
</tr>
<tr>
<td>!&gt;</p>
</td>
<td>Не больше</p>
</td>
</tr>
<tr>
<td>!&lt;</p>
</td>
<td>Не меньше
</td>
</table>
</tr>
</p>
Таблица 2-2: Операции сравнения языка SQL</p>
</p>
Синтаксис этих операций выглядит следующим образом:</p>
</p>
where expression comparison_operator expression</p>
</p>
где expression (выражение) может быть константой, названием столбца, функцией, подзапросом или любой их комбинацией, соединенных арифметическими или логическими операциями. При сравнении символьных данных оператор &lt; означает меньше по лексикографическому (словарному) порядку, а &gt; означает больше по этому же порядку. (Чтобы увидеть лексикографический порядок сортировки, используемый вашим SQL-сервером, необходимо использовать системную процедуру sp_helpsort).</p>
</p>
При сравнении пробелы в конце строк игнорируются. Например, “Dirk” (без пробела) означает то же самое, что и “Dirk “ (с пробелом). При сравнении дат &lt; означает раньше, а &gt; означает позже. Нужно заключать в апострофы и кавычки данные типа char, nchar, varchar, nvarchar, text, datetime.</p>
См. главу 8: ”Добавление, Изменение и Уничтожение Данных” об информации относительно данных типа datetime (дата, время).</p>
</p>
Ниже приведены примеры операторов select, использующих операции сравнения:</p>
</p>
select *</p>
from titleauthor</p>
where royaltyper &lt; 50</p>
</p>
select authors.au_lname, authors.au_fname</p>
from authors</p>
whereau_lname &gt; &#8216;McBadden&#8217;</p>
</p>
select au_id, phone</p>
from authors</p>
where phone !=&#8216;415 658-9932&#8217;</p>
</p>
select title_id, newprice = price * $1.15</p>
from pubs2..titles</p>
where advance &gt; 5000</p>
</p>
Операция not (не) означает логическое отрицание выражения. Следующие два запроса находят все книги по психологии и бизнесу, выплаченный аванс по которым не превышает $ 5 500. Однако, следует обратить внимание на различное расположение операции логического отрицания (not) и операции сравнения не больше (!&gt;).</p>
</p>
select title_id, type, advance</p>
from titles</p>
where (type = “buseness” or type = “psychology”)</p>
and not advance &gt; 5500</p>
</p>
select title_id, type, advance</p>
from titles</p>
where (type = “buseness” or type = “psychology”)</p>
and advance !&gt; 5500</p>
</p>
<p>                                   title_id                                   type                                        advance</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>BU1032</p>
</td>
<td><p>business</p>
</td>
<td><p>5,000.00</p>
</td>
</tr>
<tr>
<td><p>BU1111</p>
</td>
<td><p>business</p>
</td>
<td><p>5,000.00</p>
</td>
</tr>
<tr>
<td><p>BU7832</p>
</td>
<td><p>business</p>
</td>
<td><p>5,000.00</p>
</td>
</tr>
<tr>
<td><p>PS2091</p>
</td>
<td><p>psychology</p>
</td>
<td><p>2,275.00</p>
</td>
</tr>
<tr>
<td><p>PS3333</p>
</td>
<td><p>psychology</p>
</td>
<td><p>2,000.00</p>
</td>
</tr>
<tr>
<td>
</td>
<td><p>PS7777</p>
</td>
<td><p>4,000.00
</td>
</table>
</tr>
</p>
(Выбраны 6 строк)</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Интервалы (between и not between)</td></tr></table></div></p>
Ключевое слово between (между) можно использовать для задания интервала значений, в котором указываются нижняя и верхняя границы отсечения.</p>
</p>
Например, для выбора всех книг, объем продажи которых составил величину от 4 095 до 12 000 экземпляров включительно, следует выполнить запрос:</p>
</p>
select title_id, total_sales</p>
from titles</p>
where total_sales between 4095 and 12000</p>
</p>
<p>                                  title_id                           total_sales</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>BU1032</p>
</td>
<td><p>4095</p>
</td>
</tr>
<tr>
<td><p>BU7832</p>
</td>
<td><p>4095</p>
</td>
</tr>
<tr>
<td><p>PC1035</p>
</td>
<td><p>8780</p>
</td>
</tr>
<tr>
<td><p>PC8888</p>
</td>
<td><p>4095</p>
</td>
</tr>
<tr>
<td><p>TC7777</p>
</td>
<td><p>4095
</td>
</table>
</tr>
<p>                                  (5 строк найдено)</p>
</p>
Следует заметить, что книги объем продаж которых точно равен 4095 также включены в результат. Если бы имелись книги с объемом продаж 12000, то они также были бы включены в результат запроса. Можно определить открытый интервал с исключенными концами с помощью операций меньше (&lt;) и больше (&gt;). Такой же запрос с исключением концов интервала приводит к следующему результату:</p>
</p>
select title_id, total_sales</p>
from titles</p>
where total_sales &gt; 4095 and total_sales &lt; 12000</p>
</p>
<p>                                   title_id                           total_sales</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>PC1035</p>
</td>
<td><p>8780
</td>
</table>
</tr>
</p>
<p>                                  (Выбрана 1 строка)</p>
</p>
Операция not between (не между) отбирает все значения, которые не попадают в указанный интервал. Например, для нахождения всех книг, число продаж которых не попадает в интервал от 4095 до 12000, следует выполнить запрос:</p>
</p>
select title_id, total_sales</p>
from titles</p>
where total_sales not between 4095 and 12000</p>
</p>
<table cellspacing="0" cellpadding="2" border="1" style="border: solid 1px #000000; border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>title_id</p>
</td>
<td><p>total_sales</p>
</td>
</tr>
<tr>
<td><p>----------------</p>
</td>
<td><p>-----------------</p>
</td>
</tr>
<tr>
<td><p>BU1111</p>
</td>
<td><p>3876</p>
</td>
</tr>
<tr>
<td><p>BU2075</p>
</td>
<td><p>18722</p>
</td>
</tr>
<tr>
<td><p>MC2222</p>
</td>
<td><p>2032</p>
</td>
</tr>
<tr>
<td><p>MC3021</p>
</td>
<td><p>22246</p>
</td>
</tr>
<tr>
<td><p>PS1372</p>
</td>
<td><p>375</p>
</td>
</tr>
<tr>
<td><p>PS2091</p>
</td>
<td><p>2045</p>
</td>
</tr>
<tr>
<td><p>PS2106</p>
</td>
<td><p>111</p>
</td>
</tr>
<tr>
<td><p>PS3333</p>
</td>
<td><p>4072</p>
</td>
</tr>
<tr>
<td><p>PS7777</p>
</td>
<td><p>3336</p>
</td>
</tr>
<tr>
<td><p>TC3218</p>
</td>
<td><p>375</p>
</td>
</tr>
<tr>
<td><p>TC4203</p>
</td>
<td><p>15096
</td>
</table>
</tr>
</p>
(Выбрано 11 строк)</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Вхождение в список ( in и not in)</td></tr></table></div></p>
Ключевое слово in (в) позволяет выбирать значения, которые входят в указанный список значений. Например, если не пользоваться операцией in, то для выбора всех писаталей, проживающих в Калифорнии, Индиане, или Мэриленде, можно выполнить следующий запрос:</p>
</p>
select au_lname, state</p>
from authors</p>
where state = &#8216;CA&#8217; or state = &#8216;IN&#8217; or state = &#8216;MD&#8217;</p>
</p>
Однако, с помощью ключевого слова in можно получить тот же результат более экономно. Элементы списка, следующие за ключевым словом in, должны быть разделены запятыми и заключены в скобки.</p>
</p>
select au_lname, state</p>
from authors</p>
where state in( &#8216;CA&#8217;, &#8216;IN&#8217;, &#8216;MD&#8217;)</p>
</p>
Результат этих запросов будет следующим:</p>
</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td>au_lname</p>
</td>
<td>state</p>
</td>
</tr>
<tr>
<td>------------------</p>
</td>
<td>-----------</p>
</td>
</tr>
<tr>
<td>White</p>
</td>
<td>CA</p>
</td>
</tr>
<tr>
<td>Green</p>
</td>
<td>CA</p>
</td>
</tr>
<tr>
<td>Carson</p>
</td>
<td>CA</p>
</td>
</tr>
<tr>
<td>O&#8217;Leary</p>
</td>
<td>CA</p>
</td>
</tr>
<tr>
<td>Straight</p>
</td>
<td>CA</p>
</td>
</tr>
<tr>
<td>Bennet</p>
</td>
<td>CA</p>
</td>
</tr>
<tr>
<td>Dull</p>
</td>
<td>CA</p>
</td>
</tr>
<tr>
<td>Gringlesby</p>
</td>
<td>CA</p>
</td>
</tr>
<tr>
<td>Locksley</p>
</td>
<td>CA</p>
</td>
</tr>
<tr>
<td>Yokomoto</p>
</td>
<td>IN</p>
</td>
</tr>
<tr>
<td>DeFrance</p>
</td>
<td>CA</p>
</td>
</tr>
<tr>
<td>Stringer</p>
</td>
<td>CA</p>
</td>
</tr>
<tr>
<td>MacFeather</p>
</td>
<td>CA</p>
</td>
</tr>
<tr>
<td>Karsen</p>
</td>
<td>CA</p>
</td>
</tr>
<tr>
<td>Panteley</p>
</td>
<td>MD</p>
</td>
</tr>
<tr>
<td>Hunter</p>
</td>
<td>CA</p>
</td>
</tr>
<tr>
<td>McBadden</p>
</td>
<td>CA
</td>
</table>
</tr>
</p>
(Выбрано 17 строк)</p>
</p>
Однако, может быть самым важным является использование ключевого слова in во вложенных запросах, известных также как подзапросы. Полное описание подзапросов можно посмотреть в главе 5: ”Подзапросы: Использование Запросов Внутри Других Запросов”. В следующем примере иллюстрируется использование ключевого слова in во вложенном запросе.</p>
</p>
Предположим, что надо узнать фамилии писателей, которые получили меньше 50 процентов общего гонорара за книгу, соавторами которой они являлись. Таблица authors (авторы) содержит имена и фамилии писателей , а таблица titleauthor дает информацию о гонорарах. Соединяя эти таблицы с помощью ключевого слова in, можно получить результат без указания этих таблиц в конструкции from. Следующий запрос можно проинтерпретировать следующим образом: в таблице titleauthor найти номера всех авторов в столбце au_id, которые получили менее 50 процентов гонорара за некоторую книгу. Затем нужно выбрать из таблицы authors имена и фамилии тех авторов, номера которых удовлетворяют предыдущему запросу к таблице titleauthor. В результате будут отобраны несколько писателей, попадающих в эту категорию.</p>
</p>
select au_lname, au_fname</p>
from authors</p>
where au_id in</p>
        (select au_id</p>
        from titleauthor</p>
        where royaltyper &lt;50)</p>
</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>au_lname</p>
</td>
<td><p>au_fname</p>
</td>
</tr>
<tr>
<td><p>------------------</p>
</td>
<td><p>------------------</p>
</td>
</tr>
<tr>
<td><p>Green</p>
</td>
<td><p>Marjorie</p>
</td>
</tr>
<tr>
<td><p>O&#8217;Leary</p>
</td>
<td><p>Michael</p>
</td>
</tr>
<tr>
<td><p>O&#8217;Leary</p>
</td>
<td><p>Michael</p>
</td>
</tr>
<tr>
<td><p>Gringlesby</p>
</td>
<td><p>Burt</p>
</td>
</tr>
<tr>
<td><p>Yokomoto</p>
</td>
<td><p>Akiko</p>
</td>
</tr>
<tr>
<td><p>MacFeather</p>
</td>
<td><p>Stearns</p>
</td>
</tr>
<tr>
<td><p>Ringer</p>
</td>
<td><p>Anne
</td>
</table>
</tr>
<p>                                  (Выбрано 7 строк)</p>
</p>
Операция not in (не в) отбирает авторов, которые не попали в список. Следующий запрос находит писателей, которые получили не менее 50 процентов гонорара по крайней мере за одну книгу.</p>
</p>
select au_lname, au_fname</p>
from authors</p>
where au_id not in</p>
        (select au_id</p>
        from titleauthor</p>
        where royaltyper &lt;50)</p>
</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>au_lname</p>
</td>
<td><p>au_fname</p>
</td>
</tr>
<tr>
<td><p>----------------------</p>
</td>
<td><p>-----------------------</p>
</td>
</tr>
<tr>
<td><p>White</p>
</td>
<td><p>Johnson</p>
</td>
</tr>
<tr>
<td><p>Carson</p>
</td>
<td><p>Cheryl</p>
</td>
</tr>
<tr>
<td><p>Straight</p>
</td>
<td><p>Dick</p>
</td>
</tr>
<tr>
<td><p>Smith</p>
</td>
<td><p>Meander</p>
</td>
</tr>
<tr>
<td><p>Bennet</p>
</td>
<td><p>Abraham</p>
</td>
</tr>
<tr>
<td><p>Dull</p>
</td>
<td><p>Ann</p>
</td>
</tr>
<tr>
<td><p>Locksley</p>
</td>
<td><p>Charstity</p>
</td>
</tr>
<tr>
<td><p>Greene</p>
</td>
<td><p>Morningstar</p>
</td>
</tr>
<tr>
<td><p>Blotcher-Hall</p>
</td>
<td><p>Reginald</p>
</td>
</tr>
<tr>
<td><p>del Castillo</p>
</td>
<td><p>Innes</p>
</td>
</tr>
<tr>
<td><p>DeFrance</p>
</td>
<td><p>Michel</p>
</td>
</tr>
<tr>
<td><p>Stringer</p>
</td>
<td><p>Dirk</p>
</td>
</tr>
<tr>
<td><p>Karsen</p>
</td>
<td><p>Livia</p>
</td>
</tr>
<tr>
<td><p>Panteley</p>
</td>
<td><p>Sylvia</p>
</td>
</tr>
<tr>
<td><p>Hunter</p>
</td>
<td><p>Sheryl</p>
</td>
</tr>
<tr>
<td><p>McBadden</p>
</td>
<td><p>Heather</p>
</td>
</tr>
<tr>
<td><p>Ringer</p>
</td>
<td><p>Albert
</td>
</table>
</tr>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Операция сравнения строк: like</td></tr></table></div></p>
Ключевое слово like (как) используется для выбора данных, которые содержат указанную текстовую подстроку. Эта операция используется с полями типа char, nchar, varchar, nvarchar, binary, varbynary, text, и datetime .</p>
</p>
Данные в столбце (поле) сравниваются на “совпадение” с указанным шаблоном, который может содержать следующие специальные символы:</p>
</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Символ</p>
</td>
<td><p>Значение</p>
</td>
</tr>
<tr>
<td><p>%</p>
</td>
<td><p>Заменяет любую строку символов</p>
</td>
</tr>
<tr>
<td><p>-</p>
</td>
<td><p>Заменяет любой символ</p>
</td>
</tr>
<tr>
<td><p>[specifier]</p>



</td>
<td><p>Спецификатор интервала или множества заключается в квадратные скобки, например, [a-f] или [abcdef]. Спецификатор может иметь следующие  два вида:</p>
<p>интервала rangespec1- rangespec2,</p>
<p>где rangespec1 указывает на первую букву интервала символов, -(дефис) указывает на интервал, а rangespec2 указывает на последнюю букву интервала символов;</p>
<p>множества set</p>
<p>которое задается перечислением входящих в него символов, например, [a2bR].</p>
<p>Заметим, что интервал [a-f], и множества [abcdef] и [fcbdae] задают одно и то же множество значений.</p>
</td>
</tr>
<tr>
<td>[^specifier]</p>
</td>
<td><p>Символ ^, поставленный перед спецификатором множества означает дополнение множества. Напимер, [^a-f] означает “не попадающий в интервал a-f”, а [^a2bR] означает “не а, не 2, не b и не R”.
</td>
</table>
</tr>
</p>
Таблица 2-3: Специальные символы, используемые при сравнении строк</p>
</p>
Текстовые данные в столбце могут сравниваться с константами, переменными, или данными из других столбцов, содержащих указанные в таблице маскирующие (wildcard) символы. Когда используются константы, то сравниваемые строки заключаются в кавычки. Например, используя операцию like можно выполнить следующие действия с таблицей authors:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Операция like “Mc%” находит все фамилии, которые начинаются с приставки “Мс” (McBadden).</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Операция like “%inger” находит все фамилии, которые заканчиваются суффиксом “inger” (Ringer,Stringer)</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Операция like “%en%” находит все фамилии, содержащие подстроку ”en” (Bennet, Green, McBadden).</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Операция like “_heryl” находит все имена из шести букв, которые заканчиваются на “heryl” (Cheryl).</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Операция like “[CK]ars[eo]n” находит фамилии “Carsen”, “Karsen” “Carson”, и“Karson”(Carson).</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Операция like “[M-Z]inger” находит все фамилии, заканчивающиеся на “inger” и начинающиеся с любой из букв от M до Z (Ringer).</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Операция like “M[^c]%] находит все фамилии, которые начинаются с буквы ”M”, и не содержат вторую букву “c”.</td></tr></table></div></p>
Следующий запрос выбирает из таблицы authors все номера телефонов, которые начинаются кодом 415:</p>
</p>
select phone</p>
from authors</p>
where phone like “415%”</p>
</p>
Операцию not like (не как) можно использовать с теми же маскирующими символами. Например, чтобы найти все номера телефонов из таблицы authors, которые не начинаются с кода 415, можно выполнить один из следующих двух запросов:</p>
</p>
select phone</p>
from authors</p>
where phone not like “415%”</p>
</p>
select phone</p>
from authors</p>
where not phone like “415%”</p>
</p>
Операция like является единственной операцией, которую можно использовать в условии отбора where (где) для текстовых полей. Следующий запрос находит все строки в таблице blurbs, которые в столбце copy содержат подслово “computer”:</p>
</p>
select * from blurbs</p>
where copy like “%computer%”</p>
</p>
Маскирующие символы (символы замены) интерпретируются как обычные символы, если они используются без операции like. В этом случае они в точности представляют свои литеральные значения. В следующем запросе выбираются все номера телефонов, которые состоят только из четырех символов “415%”. Здесь не будут выбираться номера телефонов, которые начинаются с кода 415.</p>
</p>
select phone</p>
from authors</p>
where phone = “415%”</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Использование маскирующих символов как литер</td></tr></table></div>Маскирующие символы можно использовать в строках как обычные символы (литеры), по которым происходит сравнение. Существуют два способа использования маскирующих символов как литер в операции like: с помощью квадратных скобок и конструкции escape (пропуск).</p>
</p>
Как уже отмечалось, шаблон поиска может содержать маскирующие символы и быть значением переменной или содержимым некоторого столбца. Более подробно об операции like  и о маскирующих символах (включая информацию об использовании операции like для строк символов из мультибайтовых алфавитов и поиска подстрок независимо от регистра) рассказывается в Справочном Руководстве по SQL Серверу.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Использование Квадратных Скобок (расширение Transact-SQL)</td></tr></table></div>Маскирующие символы, к которым относятся символы процентов, подчеркивания и открывающая квадратная скобка, следует заключать в квадратные скобки для того, чтобы они интерпретировались как обычные символы. Закрывающая квадратная скобка не требует для себя специальных скобок, поэтому ее можно использовать саму по себе. Для использования дефиса в качестве литеры, а не в качестве указателя интервала, следует указать его первым внутри квадратных скобок.</p>
</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Операция like</p>
</td>
<td><p>Значение</p>
</td>
</tr>
<tr>
<td><p>like ”5%”</p>
</td>
<td><p>Любая строка, начинающаяся с цифры 5.</p>
</td>
</tr>
<tr>
<td><p>like ”5[%]”</p>
</td>
<td><p>Слово 5%</p>
</td>
</tr>
<tr>
<td><p>like ”_n”</p>
</td>
<td><p>Слова из двух букв, заканчивающиеся на “n” (an, in, on,и т.д.)</p>
</td>
</tr>
<tr>
<td><p>like “[_]n”</p>
</td>
<td><p>Слово _n</p>
</td>
</tr>
<tr>
<td><p>like “[a-cdf]”</p>
</td>
<td><p>Буквы a, b, c, d, e, f.</p>
</td>
</tr>
<tr>
<td><p>like “[-acdf]”</p>
</td>
<td><p>Символы -, a, b, c, d, e, f.</p>
</td>
</tr>
<tr>
<td><p>like “[[]”</p>
</td>
<td><p>Символ [</p>
</td>
</tr>
<tr>
<td><p>like “]”</p>
</td>
<td><p>Символ ]
</td>
</table>
</tr>
</p>
Таблица 2-4: Использование квадратных скобок для маскирующих символов</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Конструкция escape (Стандарт SQL)</td></tr></table></div>Конструкция escape (отмена) позволяет пропускать некоторые символы в строке, задаваемой в операции like. При пропуске символов действуют следующие правила:</p>
</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td>Операция like</p>
</td>
<td>Содержание</p>
</td>
</tr>
<tr>
<td>like “5@%” escape ”@”</p>
</td>
<td>5%</p>
</td>
</tr>
<tr>
<td>like “*_n” escape “*”</p>
</td>
<td>_n</p>
</td>
</tr>
<tr>
<td>like “%80@%%” escape “@”</p>
</td>
<td>строка с    строка, содержащая подстроку 80%</p>
</td>
</tr>
<tr>
<td>like “*_sql**%” escape “*”</p>
</td>
<td>строка, содержащая  подстроку _sql*</p>
</td>
</tr>
<tr>
<td>like “%#####_#%%” escape “#”</p>
</td>
<td>строка, содержащая подстроку ##_%
</td>
</table>
</tr>
</p>
Таблица 2-5: Использование конструкции escape</p>
</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 104px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Аргументом конструкции escape должна быть строка, состоящая из одного символа. Пропускаемым символом может быть любой символ из стандартного набора. Если будет указана строка, состоящая из более чем одного символа, то возникает ошибка SQLSTATE и SQL-сервер выдает сообщение об ошибке. Например, следующие конструкции escape вызывают сообщения об ошибке:</td></tr></table></div></p>
        like “%XX_%” escape “XX”</p>
        like “%XX_%X_%” escape “XX”</p>
</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 104px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Конструкция escape действует только внутри операции like, где она указана, и не действует на другие операции like, содержащиеся в том же операторе.</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 104px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Единственными символами, которые можно указывать после пропускаемого символа, являются маскирующие символы (_, %, [, ], или [^]) или сам пропускающийся символ. Если пропускаемый символ появляется два раза, то второе его вхождение не игнорируется. Таким образом, если строка может содержать два подряд пропускаемых символа, то в шаблоне следует указать 4 этих символа подряд (см. 5-й пример в таблице 2-5). Если после пропускаемого символа указан символ другого типа, не относящийся к вышеуказанным, то возникает ошибка SQLSTATE и выдается сообщение об ошибке. Например, следующие конструкции escape вызывают сообщение об ошибке:</td></tr></table></div></p>
        like “P%X%%X” escape “X”</p>
        like “%X%%Xd_%” escape “X”</p>
        like “%?X%” escape “?”</p>
        like “_e%&amp;u%” escape “&amp;”</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Чередование квадратных скобок и конструкции escape</td></tr></table></div></p>
Конструкция escape сохраняет свое действие внутри квадратных скобок в отличие от маскирующих символов, таких как подчеркивание, знак процентов и открывающая квадратная скобка.</p>
</p>
Не рекомендуется использовать маскирующие символы в качестве пропускаемых по следующим причинам:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Если указывается подчеркивание (_) или знак процентов (%) в качестве пропускаемых символов, то они теряют свое специальное значение в операции like и пропускаются как обычные символы.</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Если указывается открывающая или закрывающая квадратные скобки в качестве пропускаемых символов, то они теряют свое специальное значение в операции like, которое они имеют в языке TRANSACT-SQL.</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Если указывается дефис (-) или [^] в качестве пропускаемых символов, то они теряют свое специальное значение , которое обычно приписывается им внутри квадратных скобок, и пропускаются как обычные символы.</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Концевые пробелы и %</td></tr></table></div></p>
Концевые пробелы, указанные после знака “%” в операции like сводятся к одному концевому пробелу. Например, операция like “%  ” (процент, сопровождаемый двумя пробелами) будет иметь положительный результат сравнения со всеми строками “Х “ (один пробел); “Х  “ (два пробела); и вообще со сторокой, в которой указано любое число концевых пробелов.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Использование в столбцах маскирующих символов</td></tr></table></div></p>
Маскирующие символы могут использоваться в названиях столбцов в таблице и в названиях столбцов в операции like. В демонстрационной базе данных pubs2 есть таблица, называемая special_discount, в которой указываются скидки при продаже отдельных видов книг.</p>
</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td>id_type</p>
</td>
<td>discount</p>
</td>
</tr>
<tr>
<td>BU%</p>
</td>
<td>10</p>
</td>
</tr>
<tr>
<td>PS%</p>
</td>
<td>12</p>
</td>
</tr>
<tr>
<td>MC%</p>
</td>
<td>15
</td>
</table>
</tr>
</p>
В следующем запросе используется маскирующий символ в столбце id_type этой таблицы в конструкции where:</p>
</p>
select title_id, discount, price, price - (price * discount/100)</p>
from special_discount, titles</p>
where title_id like id_type</p>
</p>
На этот запрос выдаются следующие результаты:</p>
</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>title_id</p>
</td>
<td><p>discount</p>
</td>
<td><p>price</p>
</td>
<td>
</td>
</tr>
<tr>
<td><p>----------------</p>
</td>
<td><p>----------------</p>
</td>
<td><p>-------------------</p>
</td>
<td><p>---------------------------</p>
</td>
</tr>
<tr>
<td><p>BU1032</p>
</td>
<td><p>10</p>
</td>
<td><p>19.99</p>
</td>
<td><p>17.99</p>
</td>
</tr>
<tr>
<td><p>BU1111</p>
</td>
<td><p>10</p>
</td>
<td><p>11.95</p>
</td>
<td><p>10.76</p>
</td>
</tr>
<tr>
<td><p>BU2075</p>
</td>
<td><p>10</p>
</td>
<td><p> 2.99</p>
</td>
<td><p> 2.69</p>
</td>
</tr>
<tr>
<td><p>BU7832</p>
</td>
<td><p>10</p>
</td>
<td><p>19.99</p>
</td>
<td><p>17.99</p>
</td>
</tr>
<tr>
<td><p>PS1372</p>
</td>
<td><p>12</p>
</td>
<td><p>21.59</p>
</td>
<td><p>19.00</p>
</td>
</tr>
<tr>
<td><p>PS2091</p>
</td>
<td><p>12</p>
</td>
<td><p>10.95</p>
</td>
<td><p> 9.64</p>
</td>
</tr>
<tr>
<td><p>PS2106</p>
</td>
<td><p>12</p>
</td>
<td><p> 7.00</p>
</td>
<td><p> 6.16</p>
</td>
</tr>
<tr>
<td><p>PS3333</p>
</td>
<td><p>12</p>
</td>
<td><p>19.99</p>
</td>
<td><p>17.59</p>
</td>
</tr>
<tr>
<td><p>PS7777</p>
</td>
<td><p>12</p>
</td>
<td><p> 7.99</p>
</td>
<td><p> 7.03</p>
</td>
</tr>
<tr>
<td><p>MC2222</p>
</td>
<td><p>15</p>
</td>
<td><p>19.99</p>
</td>
<td><p>16.99</p>
</td>
</tr>
<tr>
<td><p>MC3021</p>
</td>
<td><p>15</p>
</td>
<td><p> 2.99</p>
</td>
<td><p> 2.54</p>
</td>
</tr>
<tr>
<td><p>MC3026</p>
</td>
<td><p>15</p>
</td>
<td><p>NULL</p>
</td>
<td><p>NULL
</td>
</table>
</tr>
</p>
(Выбрано 12 строк)</p>
</p>
Это позволяет проводить сложный поиск подстрок без использования цепочки or (или) предложений.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Символьные строки и кавычки</td></tr></table></div></p>
Когда вводятся или ищутся символьные данные и даты (типа char, nchar, varchar, nvarchar, datetime и smalldatetime), их нужно заключать в одинарные или двойные кавычки.</p>
</p>
Замечание:    Если опция quoted_identifier (идентификатор в кавычках) включена, не следует использовать двойные кавычки для выделения символьных строк и дат, поскольку SQL-Сервер может принять их за идентификаторы. В этом случае следует использовать одинарные кавычки (апостроф).</p>
</p>
Есть два способа для включения знака кавычек в символьную строку. Первый способ заключается в использовании двух подряд расположенных кавычек. Например, если строка начинается с апострофа и необходимо ввести еще один апостроф внутри строки, то в этом месте следует ввести два подряд апострофа:</p>
</p>
&#8216;I don&#8217;&#8217;t understand.&#8217;</p>
</p>
Следующий пример иллюстрирует использование двойных кавычек:</p>
</p>
“He said, “”It is not really confusing.”””</p>
</p>
Второй способ заключается в использовании внутри строки кавычек другого типа. Другими словами, внутри строки, заключенной в двойные кавычки, нужно использовать одинарные и наоборот. Здесь приведены несколько примеров:</p>
</p>
&#8216;George said, “There must be a better way.”&#8217;</p>
“Isn&#8217;t there a better way?”</p>
&#8216;George asked, “Isn&#8217;&#8217;t there a better way?”&#8217;</p>
</p>
Чтобы продолжить строку, которая выходит за край строки экрана, можно вставить обратную косую наклонную черту (\) перед тем как перейти к следующей строке.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Неопределенное значение: NULL</td></tr></table></div></p>
Когда в таблице встречается значение NULL, то это означает, что данное значение еще не определено. Значение данных в этом столбце “неопределено” или “недоступно”.</p>
</p>
Значение NULL не означает нулевого значения (числовой величины) или “пробела” (символьное значение). Более того, неопределенное значение позволяет отличить нулевое значение в числовых столбцах и пробел в текстовых столбцах от  отсутствия всякого значения в этих столбцах.</p>
</p>
Значение NULL можно указать как значение поля в тех столбцах, где допускается неопределенное значение. Это можно сделать оператором create table (создать таблицу) двумя способами:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Если не указано никакого значения данных, то SQL-сервер   автоматически вставляет значение NULL.</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Пользователь может явно набрать слово “NULL” или “null” без  одинарных или двойных кавычек.</td></tr></table></div></p>
Если слово “NULL” введено в текстовое поле в одинарных или двойных кавычках, то оно будет рассматриваться как строка, а не как неопределенное значение.</p>
</p>
При выводе результатов запроса неопределенные значения указываются словом NULL в соответствующих позициях. Например, в столбце advance таблицы titles допускаются неопределенные значения. Просмотрев этот столбец, можно сказать, была ли предусмотрена невыплата аванса по соглашению с автором ( см. нулевое значение в столбце advance в строке MC2222) или размер аванса не был известен в момент заполнения таблицы ( см. значение NULL в строке MC3026).</p>
</p>
select title_id, type, advance</p>
from titles</p>
where pub_id = “0877”</p>
</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td colspan="2" >title_id</p>
</td>
<td>type</p>
</td>
<td>advance</p>
</td>
</tr>
<tr>
<td colspan="2" >-----------------</p>
</td>
<td>--------------------</p>
</td>
<td>---------------</p>
</td>
</tr>
<tr>
<td colspan="2" >MC2222</p>
</td>
<td>mod_cook</p>
</td>
<td>0.00</p>
</td>
</tr>
<tr>
<td colspan="2" >MC3021</p>
</td>
<td>mod_cook</p>
</td>
<td>15,000</p>
</td>
</tr>
<tr>
<td colspan="2" >MC3026</p>
</td>
<td>UNDECIDED</p>
</td>
<td>NULL</p>
</td>
</tr>
<tr>
<td colspan="2" >PS1372</p>
</td>
<td>psychology</p>
</td>
<td>7,000</p>
</td>
</tr>
<tr>
<td colspan="2" >TC3218</p>
</td>
<td>trad_cook</p>
</td>
<td>7,000</p>
</td>
</tr>
<tr>
<td colspan="2" >TC4203</p>
</td>
<td>trad_cook</p>
</td>
<td>4,000</p>
</td>
</tr>
<tr>
<td>TC7777</p>
</td>
<td colspan="2" >trad_cook</p>
</td>
<td>8,000
</td>
</table>
</tr>
</p>
(Выбрано 7 строк)</p>
</p>
Transact-SQL интерпретирует неопределенные значения различным образом в зависимости от выполняемых операций и типов сравниваемых величин. Указанные ниже операторы возвращают следующие результаты при сравнении с неопределенным значением NULL:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>= (равно) возвращает все строки, содержащие NULL.</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>!= или &lt;&gt; (не равно) возвращает  все строки, которые не содержат NULL.</td></tr></table></div></p>
Однако, когда установлена опция ansinull для соответствия стандарту SQL, операции = и != не возвращают никаких результатов при сравнении с NULL. Независимо от этой опции операции &lt;, &lt;=, !&lt;, &gt;, &gt;=, !&gt; никогда не возвращают результатов при сравнении с неопределенным значением NULL.</p>
</p>
SQL-сервер может распознать неопределенное значение в столбце. Таким образом, равенство</p>
</p>
column1 = NULL</p>
</p>
может быть истинным. Однако, сравнение</p>
</p>
where column1 &gt; NULL</p>
</p>
не имеет смысла, поскольку NULL означает “имеет неизвестную величину”. Нет никаких оснований предполагать, что две неопределенных величины одинаковы.</p>
</p>
Эти правила применимы также к сравнению данных из столбцов, указанных в конструкции where, при объединении двух таблиц. Если конструкция (предложение) имеет вид “where column1 = column2”, то строки содержащие неопределенные значения не попадут в результат.</p>
</p>
Неопределенные [определенные] значение можно выбирать из базы данных с помощью конструкции:</p>
</p>
where column_name is [not] null</p>
</p>
Если попытаться найти неопределенное значение в столбце данных, имеющих тип NOT NULL, то SQL-сервер выдаст сообщение об ошибке.</p>
</p>
Некоторые строки в таблице titles могут содержать неопределенные значения. Например, при вводе информации о книге Psychology of Computer Cooking (Психология компьютерной кулинарии) указывается ее название, идентификационный номер книги, предполагаемый издатель. Но поскольку контракт с автором еще не заключен, то в столбцах price, advance, royalty, total_sales, notes сначала появятся неопределенные значения. Так как неопределенное значение не дает положительного результата сравнения ни с какой величиной, то в следующем запросе, выбирающем книги, по котороым был выплачен умеренный аванс (меньше $5 000), не появится вышеназванная книга по компьютерной кулинарии с номером MC3026.</p>
</p>
select title_id, advance</p>
from titles</p>
where advance &lt; $5000</p>
</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td>title_id</p>
</td>
<td>advance</p>
</td>
</tr>
<tr>
<td>--------------</p>
</td>
<td>---------------</p>
</td>
</tr>
<tr>
<td>MC2222</p>
</td>
<td>0.00</p>
</td>
</tr>
<tr>
<td>PS2091</p>
</td>
<td>2,275.00</p>
</td>
</tr>
<tr>
<td>PS3333</p>
</td>
<td>2,000.00</p>
</td>
</tr>
<tr>
<td>PS7777</p>
</td>
<td>4,000.00</p>
</td>
</tr>
<tr>
<td>TC4203</p>
</td>
<td>4,000.00
</td>
</table>
</tr>
</p>
(Выбрано 5 строк)</p>
</p>
Ниже приведен запрос, выбирающий книги, за которые был выплачен аванс меньше $5 000  или имеющих неопределенное значение в столбце advance (аванс):</p>
</p>
select title_id, advance</p>
from titles</p>
where advance &lt; $5000</p>
        or advance is null</p>
</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td>title_id</p>
</td>
<td>advance</p>
</td>
</tr>
<tr>
<td>--------------</p>
</td>
<td>---------------</p>
</td>
</tr>
<tr>
<td>MC2222</p>
</td>
<td>0.00</p>
</td>
</tr>
<tr>
<td>MC3026</p>
</td>
<td>NULL</p>
</td>
</tr>
<tr>
<td>PC9999</p>
</td>
<td>NULL</p>
</td>
</tr>
<tr>
<td>PS2091</p>
</td>
<td>2,275.00</p>
</td>
</tr>
<tr>
<td>PS3333</p>
</td>
<td>2,000.00</p>
</td>
</tr>
<tr>
<td>PS7777</p>
</td>
<td>4,000.00</p>
</td>
</tr>
<tr>
<td>TC4203</p>
</td>
<td>4,000.00
</td>
</table>
</tr>
</p>
(Выбрано 7 строк)</p>
</p>
В главе 7 “Создание баз`данных и таблиц” можно посмотреть дополнительную информацию о неопределенном значении NULL в операторе create table (создание таблицы) и о соотношении между неопределенным значением NULL и значениями по умолчанию. В главе 8 “Добавление, Изменение и Удаление Данных” можно посмотреть дополнительную информацию о вставке неопределенных значений в таблицу. См. также раздел “Неопределенные Значения” в Справочном Руководстве по SQL-серверу.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Соединение условий через логические операции</td></tr></table></div></p>
Логические операции and (и), or (или) и not (не) используются для составления сложных условий отбора в конструкции where (где).</p>
</p>
Операция and (и) соединяет два или больше условий в одно составное условие, которое является истинным, когда все входящие в него условия являются истинными.  Например, в следующем запросе выбираются все строки, в которых в столбце фамилий авторов встречается фамилия Ringer, а в столбце имен встречается имя Anne. Строка с именем и фамилией Albert Ringer разумеется не появится в результате этого запроса.</p>
</p>
select *</p>
from authors</p>
where au_lname = &#8216;Ringer&#8217; and au_fname = &#8216;Anne&#8217;</p>
</p>
Операция or (или) соединяет два или больше условий в одно составное условие, которое является истинным, когда, по крайней мере одно, из этих условий является истинным. В следующем запросе выбираются строки, содержащие имена Anne или Ann в столбце au_fname.</p>
</p>
select *</p>
from authors</p>
where au_fname = &#8216;Anne&#8217; or au_fname = &#8216;Ann&#8217;</p>
</p>
Операция not (не) отрицает условие, которое следует за ней. В следующем запросе выбираются все авторы, которые не живут в штате Калифорния:</p>
</p>
select * from authors</p>
where not state = &#8216;CA&#8217;</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Старшинство логических операций</td></tr></table></div></p>
Арифметические и битовые (bitwice) операции выполняются перед логическими операциями. Если в операторе имеется несколько логических операций, то сначала выполняется отрицание (not), затем конъюнкция (and) и, наконец, дизъюнкция (or). Информацию о битовых операциях можно получить в Справочном руководстве SQL сервера.</p>
</p>
Например, в следующем запросе выбираются все книги по бизнесу из таблицы titles независимо от выплаченного аванса и все книги по психологии, по которым был выплачен аванс, больший чем $ ,500. Условие на аванс относится только к книгам по психологии, поскольку операция and будет выполняться перед операцией or.</p>
</p>
select title_id, type, advance</p>
from titles</p>
where type = “business” or type = “psychology” and advance &gt; 5500</p>
</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td>title_id</p>
</td>
<td>type</p>
</td>
<td>advance</p>
</td>
</tr>
<tr>
<td>----------------</p>
</td>
<td>-----------------</p>
</td>
<td>-----------------</p>
</td>
</tr>
<tr>
<td>BU1032</p>
</td>
<td>business</p>
</td>
<td>5,000</p>
</td>
</tr>
<tr>
<td>BU1111</p>
</td>
<td>business</p>
</td>
<td>5,000</p>
</td>
</tr>
<tr>
<td>BU2075</p>
</td>
<td>business</p>
</td>
<td>10,125</p>
</td>
</tr>
<tr>
<td>BU7832</p>
</td>
<td>business</p>
</td>
<td>5,000</p>
</td>
</tr>
<tr>
<td>PS1372</p>
</td>
<td>psychology</p>
</td>
<td>7,000</p>
</td>
</tr>
<tr>
<td>PS2106</p>
</td>
<td>psychology</p>
</td>
<td>6,000
</td>
</table>
</tr>
</p>
(Выбрано 6 строк)</p>
</p>
Можно изменить смысл этого запроса, добавив скобки в логическое выражение, чтобы выполнить сначала операцию or. В этом случае будут выбираться все книги по бизнесу и психологии, по которым был выплачен аванс больший чем 5 500 долларов:</p>
</p>
select title_id, type, advance</p>
from titles</p>
where (type = “business” or type = “psychology”) and advance &gt; 5500</p>
</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td>title_id</p>
</td>
<td>type</p>
</td>
<td>advance</p>
</td>
</tr>
<tr>
<td>----------------</p>
</td>
<td>-----------------</p>
</td>
<td>-----------------</p>
</td>
</tr>
<tr>
<td>BU2075</p>
</td>
<td>business</p>
</td>
<td>10,125</p>
</td>
</tr>
<tr>
<td>PS1372</p>
</td>
<td>psychology</p>
</td>
<td>7,000</p>
</td>
</tr>
<tr>
<td>PS2106</p>
</td>
<td>psychology</p>
</td>
<td>6,000
</td>
</table>
</tr>
</p>
