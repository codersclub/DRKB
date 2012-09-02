<h1>Подзапросы: запросы внутри запросов</h1>
<div class="date">01.01.2007</div>


<p>Подзапросы: Запросы внутри запросов</p>
&nbsp;</p>
Подзапрос - это оператор выбора, который содержится внутри другого оператора выбора, вставки, обновления или удаления, внутри условного оператора или внутри другого подзапроса.</p>
В этой главе обсуждаются следующие темы:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 151px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Что такое подзапросы;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 151px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Типы подзапросов;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 151px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Выражения с подзапросами;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 151px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Квантифицированные предикаты с подзапросами;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 151px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Коррелирующиеся подзапросы.</td></tr></table></div>&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Что такое подзапросы</td></tr></table></div>&nbsp;</p>
Подзапросы обычно содержатся в предложениях where или having SQL оператора или в списке выбора этого оператора. С помощью подзапросов можно проводить дальнейший отбор данных из результатов других запросов. Оператор, содержащий подзапрос, может обрабатывать строки некоторой таблицы, основываясь на результатах вычисления списка выбора подзапроса, который в свою очередь может ссылаться на эту же таблицу как внешний запрос, или обращаться к другой таблице. В языке Transact-SQL подзапросы допускаются почти везде, где допускаются выражения,&nbsp; если подзапрос возвращает одно значение.</p>
Операторы выбора, содержащие один или несколько подзапросов, называются также составными запросами или составными операторами выбора. Возможность включения одного оператора выбора внутрь другого является одной из причин, по которой язык SQL называется “структурированным” (Structured Query Language).</p>
SQL оператор, который включает подзапросы, называемые также внутренними запросами, можно иногда заменить соединением. Есть вопросы, которые можно сформулировать только с помощью подзапросов. Некоторые люди предпочитают всегда использовать подзапросы, поскольку находят их легкими для понимания. Другие стремятся их избегать всегда, когда это возможно. Читатель может выбрать сам удобный для себя способ. (SQL Сервер также переводит некоторые подзапросы в соединения, прежде чем выполнять их).</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Примеры использования подзапросов</td></tr></table></div>&nbsp;</p>
Если нужно найти все книги, имеющие ту же цену, что и книга Straight Talk About Computers, то это можно сделать за два шага. Во-первых найти цену этой книги:</p>
&nbsp;</p>
select price </p>
from titles </p>
where title = "Straight Talk About Computers" </p>
&nbsp;</p>
price </p>
------------- </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $19.99</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
Затем, используя этот результат во втором запросе, уже можно найти все книги, имеющие ту же стоимость, что и Straight Talk: </p>
&nbsp;</p>
select title, price </p>
from titles </p>
where price = $19.99 </p>
&nbsp;</p>
title&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;price </p>
-------------------------------------------------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------</p>
The Busy Executive's Database Guide &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;19.99 </p>
Straight Talk About Computers&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;19.99 </p>
Silicon Valley Gastronomic Treats&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;19.99 </p>
Prolonged Data Deprivation: Four Case Studies  &nbsp; &nbsp; &nbsp; &nbsp;19.99</p>
&nbsp;</p>
(Выбрано 4 строки)</p>
&nbsp;</p>
С помощью подзапроса эта задача решается одним оператором:</p>
&nbsp;</p>
select title, price </p>
from titles </p>
where price = </p>
 &nbsp; (select price </p>
 &nbsp;&nbsp; from titles </p>
 &nbsp;&nbsp; where title = "Straight Talk About Computers")</p>
&nbsp;</p>
title&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;price </p>
--------------------------------------------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------</p>
The Busy Executive's Database Guide&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;19.99 </p>
Straight Talk About Computers &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;19.99 </p>
Silicon Valley Gastronomic Treats&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;19.99 </p>
Prolonged Data Deprivation: Four Case Studies  &nbsp; &nbsp; &nbsp; &nbsp;19.99</p>
&nbsp;</p>
(Выбрано 4 строки)</p>
&nbsp;</p>
Общие правила написания и синтаксис подзапросов</p>
&nbsp;</p>
Оператор выбора в подзапросе всегда должен быть заключен в круглые скобки. Синтаксис оператора выбора в подзапросе подчиняется общим правилам написания операторов выбора с некоторыми ограничениями, которые показаны на следующей схеме:</p>
&nbsp;</p>
(select [distinct] список_выбора_подзапроса </p>
[from [[database.]owner.]{название_таблицы | название_вьювера}</p>
 [({index название_индекса | prefetch size |[lru|mru]})]}</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [holdlock | noholdlock] [shared]</p>
 &nbsp;&nbsp;&nbsp; [,[[database.]owner.]{ название_таблицы | название_вьювера }</p>
 [({index название_индекса | prefetch size |[lru|mru]})]}</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [holdlock | noholdlock] [shared]]... ] </p>
[where условия_отбора] </p>
[group by выражение_без_агрегации [, </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; выражение_без_агрегации]... ] </p>
[having условия_отбора])</p>
&nbsp;</p>
Подзапросы могут быть вложенными в конструкциях (предложениях) where или having внешних операторов выбора (select), вставки (insert), обновления (update) или удаления (delete), а также вложенными в другие подзапросы или помещены в список выбора.</p>
В языке Transact-SQL подзапрос можно помещать почти везде, где допустимы выражения, если этот подзапрос возвращает единственное значение в качестве результата.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Ограничения на подзапросы</td></tr></table></div>&nbsp;</p>
На подзапросы накладываются следующие ограничения:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Подзапросы нельзя использовать в списках предложений order by, group by и compute by.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Подзапрос не может содержать предложения for browse или union.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Список выбора внутреннего подзапроса, которому предшествует операция сравнения, может содержать только одно выражение или название столбца, и подзапрос должен возвращать единственный результат. При этом тип данных столбца, указанного в конструкции where внешнего оператора, должен быть совместим c типом данных в столбце, указанным в списке выбора подзапроса (правила здесь такие же как и при соединении).</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>В подзапросах не допускаются текстовые (text) и графические (image) данные.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Подзапросы не могут обрабатывать свои результаты внутренним образом, т.е. подзапрос не может содержать конструкций order by, compute, или ключевого слова into.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Коррелирующиеся (повторяющиеся) подзапросы не допускаются в конструкции select обновляемого курсора, определенного с помощью declare cursor (определить курсор).</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Количество вложенных уровней для подзапросов не должно превышать 16. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Максимальное число подзапросов на каждой стороне объединения не больше 16. </td></tr></table></div>&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Расширенные названия столбцов</td></tr></table></div>&nbsp;</p>
В следующем примере столбец pub_id в конструкции where внешнего запроса неявно определяется таблицей publishers из конструкции from этого запроса. Обращение к столбцу pub_id в списке выбора подзапроса определяется конструкцией from подзапроса, т.е. таблицей titles:</p>
&nbsp;</p>
select pub_name </p>
from publishers </p>
where pub_id in </p>
 &nbsp; (select pub_id </p>
 &nbsp;&nbsp; from titles </p>
 &nbsp;&nbsp; where type = "business")</p>
&nbsp;</p>
Общее правило таково: названия столбцов в операторе неявно определяются таблицей, которая указана в конструкции from этого уровня вложенности.</p>
Если раскрыть все неявные предположения, то запрос будет выглядеть следующим образом:</p>
&nbsp;</p>
select pub_name </p>
from publishers </p>
where publishers.pub_id in </p>
 &nbsp; (select titles.pub_id </p>
 &nbsp;&nbsp; from titles </p>
 &nbsp;&nbsp; where type = "business")</p>
&nbsp;</p>
Никогда нелишне явно указывать название таблицы и всегда можно заменить неявные предположения явным использованием расширенных названий столбцов вместе с названием таблицы.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Подзапросы с коррелирующимися названиями&nbsp; </td></tr></table></div>&nbsp;</p>
Как отмечалось в главе 5, "Соединения: Выбор данных из нескольких таблиц", коррелирующиеся (согласующиеся) названия таблиц необходимы в самосоединениях, поскольку таблица, присоединенная сама к себе, выступает в двух различных ролях. Коррелирующиеся названия могут также использоваться во вложенных запросах, которые ссылаются на одну и ту же&nbsp; таблицу, как во внутреннем, так и во внешнем запросе.</p>
Например, с помощью следующего подзапроса можно найти писателей, живущих в одном городе с Ливией Карсен:</p>
&nbsp;</p>
select au1.au_lname, au1.au_fname, au1.city </p>
from authors au1 </p>
where au1.city in </p>
 &nbsp; (select au2.city </p>
 &nbsp;&nbsp; from authors au2 </p>
 &nbsp;&nbsp; where au2.au_fname = "Livia" </p>
 &nbsp;&nbsp; and au2.au_lname = "Karsen") </p>
&nbsp;</p>
au_lname&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;au_fname&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;city </p>
-----------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------------&nbsp;&nbsp;&nbsp;&nbsp; ----------- </p>
Green&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Marjorie&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Oakland </p>
Straight&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Dick&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Oakland </p>
Stringer&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Dirk&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Oakland </p>
MacFeather&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Stearns&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Oakland </p>
Karsen&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Livia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Oakland</p>
&nbsp;</p>
(Выбрано 5 строк)</p>
&nbsp;</p>
Явное использование коррелирующихся названий позволяет понять, что как внешний, так и внутренний запрос ссылаются на одну и ту же таблицу authors.&nbsp;&nbsp;&nbsp; </p>
Без явной корреляции подзапрос выглядит следующим образом:</p>
&nbsp;</p>
select au_lname, au_fname, city </p>
from authors </p>
where city in </p>
 &nbsp; (select city </p>
 &nbsp;&nbsp; from authors </p>
 &nbsp;&nbsp; where au_fname = "Livia" </p>
 &nbsp;&nbsp; and au_lname = "Karsen")</p>
&nbsp;</p>
Вышеприведенный запрос и другие операторы, в которых подзапрос и внешний запрос ссылаются на одну и ту же таблицу, могут быть заменены самосоединением:</p>
&nbsp;</p>
select au1.au_lname, au1.au_fname, au1.city </p>
from authors au1, authors au2 </p>
where au1.city = au2.city </p>
and au2.au_lname = "Karsen" </p>
and au2.au_fname = "Livia"</p>
&nbsp;</p>
Подзапрос, замененный соединением, может выдавать результаты в другом порядке и потребовать ключевого слова distinct для исключения повторений.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Несколько уровней вложенности</td></tr></table></div>&nbsp;</p>
Подзапрос может содержать в себе один или несколько подзапросов следующего уровня. Оператор может содержать подзапросы 16 уровней вложенности.</p>
Рассмотрим следующую задачу, которая может быть решена с помощью оператора с подзапросами нескольких уровней: "Найти имена писателей, которые принимали участие в написании, по крайней мере, одной популярной компьютерной книги".</p>
&nbsp;</p>
select au_lname, au_fname </p>
from authors </p>
where au_id in </p>
 &nbsp; (select au_id </p>
 &nbsp;&nbsp; from titleauthor </p>
 &nbsp;&nbsp; where title_id in </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (select title_id </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; from titles </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; where type = "popular_comp") )</p>
&nbsp;</p>
au_lname&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;au_fname </p>
----------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------ </p>
Carson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Cheryl </p>
Dull&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Ann </p>
Hunter&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Sheryl </p>
Locksley&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Chastity</p>
&nbsp;</p>
(Выбрано 4 строки)</p>
&nbsp;</p>
Самый внешний запрос выбирает имена и фамилии всех писателей. Запрос следующего уровня находит идентификационные номера писателей, а самый внутренний запрос возвращает идентификационные номера книг PC1035, PC8888 и PC9999.</p>
Этот запрос также можно выразить с помощью соединения:</p>
&nbsp;</p>
select au_lname, au_fname </p>
from authors, titles, titleauthor </p>
where authors.au_id = titleauthor.au_id </p>
and titles.title_id = titleauthor.title_id </p>
and type = "popular_comp"</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Подзапросы в операторах модификации удаления и вставки&nbsp; </td></tr></table></div>&nbsp;</p>
Подзапроcы могут быть вложенными в операторах&nbsp; модификации (update), удаления (delete) и вставки (insert) так же, как и в операторе выбора.</p>
&nbsp;</p>
Замечание: Выполнение следующих примеров изменит содержимое базы данных pubs2. Следует обратиться к системному администратору, чтобы получить исходную копию этой базы.</p>
&nbsp;</p>
В следующем запросе удваиваются цены всех книг, изданных компанией New Age Books. Этот оператор модифицирует таблицу titles, а подзапрос обращается к таблице publishers.</p>
&nbsp;</p>
update titles </p>
set price = price * 2 </p>
where pub_id in </p>
 &nbsp; (select pub_id </p>
 &nbsp;&nbsp; from publishers </p>
 &nbsp;&nbsp; where pub_name = "New Age Books")</p>
&nbsp;</p>
Эквивалентный предыдущему оператор модификации, в котором используется соединение, выглядит следующим образом:</p>
&nbsp;</p>
update titles </p>
set price = price * 2 </p>
from titles, publishers </p>
where titles.pub_id = publishers.pub_id </p>
and pub_name = "New Age Books"</p>
&nbsp;</p>
Можно удалить все записи о продажах книг по бизнесу с помощью следующего вложенного оператора выбора:</p>
&nbsp;</p>
delete salesdetail </p>
where title_id in </p>
 &nbsp; (select title_id </p>
 &nbsp;&nbsp; from titles </p>
 &nbsp;&nbsp; where type = "business")</p>
&nbsp;</p>
Эквивалентный предыдущему оператор удаления, использующий соединение, выглядит следующим образом:</p>
&nbsp;</p>
delete salesdetail </p>
from salesdetail, titles </p>
where salesdetail.title_id = titles.title_id </p>
and type = "business"</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Подзапросы в условных операторах</td></tr></table></div>&nbsp;</p>
Подзапросы можно также использовать в условных операторах. Предыдущий запрос, в котором удалялись все записи о продажах книг по бизнесу, можно переписать следующим образом, чтобы проверить наличие таких записей перед их уничтожением:</p>
&nbsp;</p>
if exists (select title_id </p>
 &nbsp;&nbsp; from titles </p>
 &nbsp;&nbsp; where type = "business")</p>
begin</p>
 &nbsp;&nbsp; delete salesdetail </p>
 &nbsp;&nbsp; where title_id in </p>
 &nbsp;&nbsp;&nbsp;&nbsp; (select title_id </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; from titles </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; where type = "business") </p>
end</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Использование подзапросов на месте выражений</td></tr></table></div>&nbsp;</p>
В языке Transact-SQL подзапрос можно подставлять почти в любое место в операторах выбора, модификации, вставки и удаления, где может размещаться выражение. Подзапросы нельзя использовать в списках выбора предложения order by. Ниже приведены некоторые примеры, которые показывают, как правильно&nbsp; использовать это расширение языка Transact-SQL.</p>
В следующем запросе выбираются названия и типы книг, которые были написаны авторами, живущими в Калифорнии, и изданные там же:</p>
&nbsp;</p>
select title, type </p>
from titles </p>
where title in </p>
 &nbsp; (select title </p>
 &nbsp;&nbsp; from titles, titleauthor, authors </p>
 &nbsp;&nbsp; where titles.title_id = titleauthor.title_id </p>
 &nbsp;&nbsp; and titleauthor.au_id = authors.au_id </p>
 &nbsp;&nbsp; and authors.state = "CA") </p>
and title in </p>
 &nbsp; (select title </p>
 &nbsp;&nbsp; from titles, publishers </p>
 &nbsp;&nbsp; where titles.pub_id = publishers.pub_id </p>
 &nbsp;&nbsp; and publishers.state = "CA") </p>
&nbsp;</p>
title&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;type</p>
--------------------------------------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------------</p>
The Busy Executive's Database Guide &nbsp; &nbsp; &nbsp; &nbsp;business</p>
Cooking with Computers: </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Surreptitious Balance Sheets&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; business</p>
Straight Talk About Computers&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; business</p>
But Is It User Friendly?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;popular_comp</p>
Secrets of Silicon Valley&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;popular_comp</p>
Net Etiquette&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;popular_comp</p>
&nbsp;</p>
(Выбрано 6 строк)</p>
&nbsp;</p>
В следующем операторе выбираются&nbsp; названия всех книг, которых было продано более 5000 экземпляров, их цены, и цена самой дорогой книги:</p>
&nbsp;</p>
select title, price, </p>
 &nbsp;&nbsp; (select max(price) from titles)</p>
 &nbsp;&nbsp; from titles</p>
 &nbsp;&nbsp; where total_sales &gt; 5000</p>
&nbsp;</p>
title                                 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;price</p>
-----------------------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------&nbsp;&nbsp;&nbsp;&nbsp; ------- </p>
You Can Combat Computer Stress!&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; 2.99  &nbsp; &nbsp; &nbsp; &nbsp;22.95</p>
The Gourmet Microwave&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; 2.99&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;22.95</p>
But Is It User Friendly?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;22.95&nbsp;&nbsp;&nbsp; 22.95</p>
Fifty Years in Buckingham Palace &nbsp; &nbsp; &nbsp; &nbsp;11.95&nbsp;&nbsp;&nbsp; 22.95</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Kitchens</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Типы подзапросов</td></tr></table></div>&nbsp;</p>
Существуют два основных типа подзапросов:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Подзапросы, которым предшествует немодифицированная операция сравнения и которые возвращают единственное значение, называются подзапросами- выражениями (скалярными подзапросами).</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Подзапросы, которые возвращают список значений и которым предшествует&nbsp; ключевое слово in (принадлежит) или операция сравнения, модифицированная кванторами&nbsp; any (некоторый) или all (все), а также подзапросы, проверяющие существование&nbsp; с помощью квантора exists (существует), называются квантифицированными предикатными подзапросами.</td></tr></table></div>&nbsp;</p>
Подзапросы любого из этих типов могут быть либо коррелированными (повторяющимися), либо некоррелированными.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Некоррелированный подзапрос может вычисляться как независимый запрос. Иначе говоря, результаты подзапроса подставляются в основной оператор (или внешний запрос). Это не значит, что SQL-сервер именно так выполняет операторы с подзапросами. Некорреляционные подзапросы могут быть заменены соединением и будут выполняться как соединения SQL-сервером.</td></tr></table></div>&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Коррелированные подзапросы не могут выполняться как независимые запросы, поскольку они могут обращаться к данным, находящихся в столбцах таблицы, указанной в списке from  внешнего запроса. Коррелированные подзапросы детально обсуждаются в конце этой главы. </td></tr></table></div>&nbsp;</p>
В следующих разделах этой главы&nbsp; рассматриваются различные типы подзапросов.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Подзапросы-выражения</td></tr></table></div>&nbsp;</p>
Подзапросам-выражениям предшествует одна из операций сравнения =, !=, &lt;&gt;, &gt;, &gt;=, &lt;, !&lt; или &lt;= и они имеют следующую общую форму:</p>
&nbsp;</p>
[Начало оператора выбора, вставки, модификации, удаления или подзапроса]</p>
where  выражение операция_сравнения (подзапрос)</p>
[Конец оператора выбора, вставки, модификации, удаления или подзапроса]</p>
&nbsp;</p>
Подзапрос, которому предшествует немодифицированная операция сравнения, т.е. операция сравнения без квантора any или all, должен возвращать единственное значение. В противном случае SQL-сервер выдает сообщение об ошибке.&nbsp;&nbsp; </p>
В идеале, для использования подзапроса с немодифицированной операцией сравнения, пользователь должен достаточно хорошо знать табличные данные и понимать природу задачи, чтобы быть уверенным, что подзапрос выдаст единственное значение.</p>
Например, предположим, что каждое издательство находится только в одном городе. Тогда для нахождения писателей, живущих в городе, где располагается издательство Algodata Infosystems, необходимо выполнить оператор с подзапросом, которому предшествует сравнение на равенство:</p>
&nbsp;</p>
select au_lname, au_fname </p>
from authors </p>
where city = </p>
 &nbsp; (select city </p>
 &nbsp;&nbsp; from publishers </p>
 &nbsp;&nbsp; where pub_name = "Algodata Infosystems")</p>
&nbsp;</p>
au_lname&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; au_fname </p>
--------------&nbsp;&nbsp;&nbsp;&nbsp; -------------- </p>
Carson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cheryl </p>
Bennet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Abraham</p>
&nbsp;</p>
(Выбраны 2 строки)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Использование скалярных аггрегирующих функций для достижения единственности результата</td></tr></table></div>&nbsp;</p>
Подзапросы, которым предшествует немодифицированная операция сравнения, часто содержат скалярные аггрегирующие функции, поскольку они возвращают единственное значение.</p>
Например, следующий оператор находит все названия книг, которые стоят больше минимальной цены:</p>
&nbsp;</p>
select title </p>
from titles </p>
where price &gt; </p>
 &nbsp; (select min(price) </p>
 &nbsp;&nbsp; from titles)</p>
&nbsp;</p>
title </p>
---------------------------------------------------</p>
The Busy Executive's Database Guide </p>
Cooking with Computers: Surreptitious Balance Sheets</p>
Straight Talk About Computers </p>
Silicon Valley Gastronomic Treats </p>
But Is It User Friendly? </p>
Secrets of Silicon Valley </p>
Computer Phobic and Non-Phobic Individuals: Behavior Variations </p>
Is Anger the Enemy? </p>
Life Without Fear </p>
Prolonged Data Deprivation: Four Case Studies </p>
Emotional Security: A New Algorithm </p>
Onions, Leeks, and Garlic: Cooking Secrets of the Mediterranean </p>
Fifty Years in Buckingham Palace Kitchens </p>
Sushi, Anyone?</p>
&nbsp;</p>
(Выбрано 14 строк)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Предложения group by и having в подзапросах-выражениях</td></tr></table></div>&nbsp;</p>
Поскольку подзапросы, которым предшествует немодифицированная операция сравнения, должны возвращать скалярную величину, то обычно они не могут включать предложений group by и having, за исключением случая, когда в результате группировки действительно получается одна группа.</p>
Например, в следующем запросе выбираются все книги, цена которых выше наименьшей цены книги в категории trad_cook:</p>
&nbsp;</p>
select title </p>
from titles </p>
where price &gt; </p>
 &nbsp; (select min(price) </p>
 &nbsp;&nbsp; from titles </p>
 &nbsp;&nbsp; group by type </p>
 &nbsp;&nbsp; having type = "trad_cook")</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Использование опции distinct в подзапросе-выражении</td></tr></table></div>&nbsp;</p>
Подзапросы, которым предшествует немодифицированная операция сравнения, часто содержат ключевое слово distinct (различные), чтобы в результате получалась скалярная величина.</p>
Например, следующий запрос без слова distinct был бы неправильным, потому что в результате получилась бы векторная величина:</p>
&nbsp;</p>
select pub_name from publishers</p>
 &nbsp;&nbsp; where pub_id =</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (select distinct pub_id</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; from titles</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; where pub_id&nbsp; = publishers.pub_id)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Квантифицированные предикатные подзапросы</td></tr></table></div>&nbsp;</p>
Квантифицированные подзапросы - это подзапросы, возвращающие несколько значений (или никаких значений), которым в предложениях where или having, предшествует один из кванторов any (некоторый), all (все), in (в) или exist (существует). Кванторы any и all модифицируют операции сравнения.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Подзапросы, которым предшествует модифицированная операция сравнения, и которые могут&nbsp; содержать предложения where или having, имеют следующий общий вид:</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&nbsp;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28"></td><td>[ Начало оператора выбора, вставки, модификации, удаления или подзапроса]</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28"></td><td> &nbsp; &nbsp; &nbsp; &nbsp;where выражение операция_сравнения [any | all] (подзапрос)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28"></td><td>[ Конец оператора выбора, вставки, модификации, удаления или подзапроса]</td></tr></table></div>&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Подзапросы, которым предшествует ключевые слова in (принадлежит) и not in (не принадлежит) имеют следующий общий вид:</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&nbsp;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28"></td><td>[ Начало оператора выбора, вставки, модификации, удаления или подзапроса]</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28"></td><td> &nbsp; &nbsp; &nbsp; &nbsp;where выражение [not] in (подзапрос)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28"></td><td>[ Конец оператора выбора, вставки, модификации, удаления или подзапроса]</td></tr></table></div>&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Подзапросы с кванторами exists (существует) и not exists (не существует), проверяющие существование некоторых значений, имеют следующий общий вид:</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&nbsp;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28"> </td><td>[ Начало оператора выбора, вставки, модификации, удаления или подзапроса]</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28"></td><td> &nbsp; &nbsp; &nbsp; &nbsp;where [not] exists (подзапрос)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28"></td><td>[ Конец оператора выбора, вставки, модификации, удаления или подзапроса]</td></tr></table></div>&nbsp;</p>
Хотя ключевое слово distinct допускается в подзапросах с кванторами, тем не менее при исполнении оно игнорируется, т.е. выполнение происходит также, как и при его отсутствии.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Подзапросы с кванторами any и all </td></tr></table></div>&nbsp;</p>
Ключевые слова all и any модифицируют операцию сравнения, которая формирует подзапрос.</p>
Рассмотрим в качестве примера операцию &gt; (больше):</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>&gt;all означает больше чем любое значение или, что равносильно, больше максимальной величины. Например, &gt;all (1,2,3) означает больше чем 3.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>&gt;any означает больше, по крайней мере, одного значения или, что равносильно, больше минимальной величины. Поэтому, &gt;any (1,2,3) означает меньше 1.</td></tr></table></div>&nbsp;</p>
Если подзапросу предшествует квантор all и подзапрос возвращает пустое множество строк, то весь запрос считается ошибочным.</p>
Использование кванторов all и any требует внимательности, поскольку компьютер не допускает двусмысленности, которая свойственна этим словам в обычном языке. Например, можно задать вопрос: “По каким книгам выплачен аванс, больший чем по любой (any) книге, опубликованной издательством New Age Books?”.</p>
Этот вопрос можно перефразировать в SQL в более точной форме: “По каким книгам выплачен аванс, больший чем максимальный аванс, выплаченный издательством New Age Books?”. В данном случае нужно использовать ключевое слово all (все), а не any:</p>
&nbsp;</p>
select title </p>
from titles </p>
where advance &gt; all </p>
 &nbsp; (select advance </p>
 &nbsp;&nbsp; from publishers, titles </p>
 &nbsp;&nbsp; where titles.pub_id = publishers.pub_id </p>
 &nbsp;&nbsp; and pub_name = "New Age Books")</p>
&nbsp;</p>
title </p>
---------------------------------------- </p>
The Gourmet Microwave</p>
&nbsp;</p>
(Выбрана одна строка)</p>
&nbsp;</p>
Для каждой книги внешний запрос выбирает название и аванс из таблицы titles и сравнивает его со всеми авансами, выплаченными издательством New Age Books, которые возвращаются подзапросом. Внешний запрос находит максимальное значение в этом списке и определяет является ли аванс по данной книге большим этого максимального значения.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>&gt;all означает больше чем все значения</td></tr></table></div>&nbsp;</p>
В контексе подзапроса квантор &gt;all означает, что текущая строка будет удовлетворять условию, указанному во внешнем запросе, если значение в указанном столбце будет больше всех значений, которые возвращаются подзапросом.</p>
Например, чтобы найти книги, которые стоят больше чем самая дорогая книга в группе mod_cook, нужно сделать следующий запрос:&nbsp; </p>
&nbsp;</p>
select title from titles where price &gt; all</p>
 &nbsp;&nbsp; (select price from titles </p>
 &nbsp;&nbsp; where type =&nbsp; "mod_cook")</p>
&nbsp;</p>
title</p>
---------------------------------------------------</p>
But Is It User Friendly?</p>
Secrets of Silicon Valley</p>
Computer Phobic and Non-Phobic Individuals: Behavior Variations</p>
Onions, Leeks, and Garlic: Cooking Secrets of the Mediterranean</p>
&nbsp;</p>
(Выбрано 4 строки)</p>
&nbsp;</p>
Однако, если множество значений, возвращаемое подзапросом, содержит неопределенное значение NULL, то запрос возвращает 0 строк (пустое множество), поскольку невозможно сравнить конкретную величину с неопределенным значением.</p>
Например, можно попытаться найти книги, которые стоят больше чем самая дорогая книга в группе popular_comp: </p>
&nbsp;</p>
select title from titles where price &gt; all</p>
 &nbsp;&nbsp; (select price from titles </p>
 &nbsp;&nbsp; where title_id = "popular_comp")</p>
&nbsp;</p>
title</p>
---------------------------------------------------</p>
(0 rows affected)</p>
&nbsp;</p>
В результате возвращается пустое множество, поскольку в подзапросе обнаруживается, что книга Net Etiquette имеет неопределенную цену.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>=all означает равно каждому значению</td></tr></table></div>&nbsp;</p>
Квантор =all означает равенство каждому возвращаемому значению. Текущая строка будет удовлетворять условию, указанному во внешнем запросе, если значение в сравниваемом столбце будет равно каждому значению, которое возвращается подзапросом.</p>
Например, в следующем запросе находятся авторы, живущие в одном городе, путем сравнения их почтовых индексов:</p>
&nbsp;</p>
select au_fname, au_lname, city</p>
from authors</p>
where city = all</p>
     (select city</p>
     from authors</p>
     where postalcode like "946%")</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>&gt;any означает больше, по крайней мере, одного значения</td></tr></table></div>&nbsp;</p>
Квантор &gt;any означает, что текущая строка будет удовлетворять условию, указанному во внешнем запросе, если значение в сравниваемом столбце будет больше, по крайней мере, одного значения, которое возвращается подзапросом.</p>
В следующем запросе приводится пример подзапроса, в котором операция сравнения модифицируется квантором any. В нем ищутся все книги, по которым выплачен аванс, больший, чем некоторый аванс, выплаченный издательством New Age Books.</p>
&nbsp;</p>
select title </p>
from titles </p>
where advance &gt; any </p>
 &nbsp; (select advance </p>
 &nbsp;&nbsp; from titles, publishers </p>
 &nbsp;&nbsp; where titles.pub_id = publishers.pub_id </p>
 &nbsp;&nbsp; and pub_name = "New Age Books") </p>
&nbsp;</p>
title </p>
--------------------------------------------------- </p>
Sushi, Anyone? </p>
Life Without Fear </p>
Is Anger the Enemy?</p>
The Gourmet Microwave </p>
But Is It User Friendly? </p>
Secrets of Silicon Valley </p>
Straight Talk About Computers</p>
You Can Combat Computer Stress!</p>
Emotional Security: A New Algorithm</p>
The Busy Executive's Database Guide</p>
Fifty Years in Buckingham Palace Kitchens</p>
Cooking with Computers: Surreptitious Balance Sheets</p>
Computer Phobic and Non-Phobic Individuals: Behavior Variations </p>
Onions, Leeks, and Garlic: Cooking Secrets of the Mediterranean</p>
&nbsp;</p>
(Выбрано 14 строк)</p>
&nbsp;</p>
Для каждой книги, выбираемой во внешнем запросе, внутренний запрос возвращает список выплаченных авансов издательством New Age Books. Во внешнем запросе определяется, существует ли в этом списке значение, меньшее аванса, выплаченного за рассматриваемую книгу. Другими словами, в этом примере ищутся книги с авансом большим, чем наименьший аванс, выплаченный издательством New Age Books.</p>
Если подзапрос не возвращает никаких значений, то весь запрос считается ошибочным.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td> =any означает равно некоторому значению</td></tr></table></div>&nbsp;</p>
Квантор =any означает проверку существования, поэтому он эквивалентен условию in (в). Например, чтобы найти всех авторов, которые живут в одном городе с некоторым издателем, можно использовать как =any, так и in:</p>
&nbsp;</p>
select au_lname, au_fname </p>
from authors </p>
where city = any </p>
 &nbsp; (select city </p>
 &nbsp;&nbsp; from publishers) </p>
&nbsp;</p>
select au_lname, au_fname </p>
from authors </p>
where city in </p>
 &nbsp; (select city </p>
 &nbsp;&nbsp; from publishers) </p>
&nbsp;</p>
au_lname&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; au_fname </p>
--------------&nbsp;&nbsp;&nbsp;&nbsp; -------------- </p>
Carson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cheryl </p>
Bennet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Abraham</p>
&nbsp;</p>
(Выбраны 2 строки)</p>
&nbsp;</p>
Однако, квантор !=any будет не равносилен условию not in (не в). Квантор !=any означает “не а или не в или не с”, в то время как условие not in означает “не а и не в и не с”.</p>
Например, чтобы найти всех авторов, которые живут в городах, где нет никаких издательств, можно попытаться сделать следующий запрос:&nbsp; </p>
&nbsp;</p>
select au_lname, au_fname </p>
from authors </p>
where city != any </p>
 &nbsp; (select city </p>
 &nbsp;&nbsp; from publishers)</p>
&nbsp;</p>
В результате будут перечислены все 23 автора, поскольку каждый автор живет в городе, где нет некоторого издательства.</p>
Это происходит потому, что во внутреннем запросе строится список всех городов, где расположены издательства, а затем для каждого города, где живет автор, внешний запрос находит в этом списке отличный от него город, в котором, разумеется, данный автор не живет.</p>
Посмотрим, что произойдет, если в тот же самый запрос вставить условие not in: </p>
&nbsp;</p>
select au_lname, au_fname </p>
from authors </p>
where city not in </p>
 &nbsp; (select city </p>
 &nbsp;&nbsp; from publishers)</p>
&nbsp;</p>
au_lname&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;au_fname </p>
--------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ------------ </p>
del Castillo&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Innes </p>
Blotchet-Halls&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Reginald </p>
Gringlesby&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Burt </p>
DeFrance&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Michel </p>
Smith&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Meander </p>
White&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Johnson </p>
Greene&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Morningstar </p>
Green&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Marjorie </p>
Straight&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Dick </p>
Stringer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Dirk </p>
MacFeather&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Stearns </p>
Karsen&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Livia </p>
Dull&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Ann </p>
Hunter&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Sheryl </p>
Panteley&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Sylvia </p>
Ringer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Anne </p>
Ringer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Albert </p>
Locksley&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Chastity </p>
O'Leary&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Michael </p>
McBadden&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Heather </p>
Yokomoto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Akiko</p>
&nbsp;</p>
(Выбрана 21 строка )</p>
&nbsp;</p>
Это как раз тот результат, который необходимо было получить. Он включает всех авторов, за исключением Cheryl Carson и Abraham Bennet, которые живут в Беркли, где расположено издательство Algodata Infosystem.</p>
Тот же результат можно получить с помощью квантора !=all, который эквивалентен условию not in:</p>
&nbsp;</p>
select au_lname, au_fname </p>
from authors </p>
where city != all </p>
 &nbsp; (select city </p>
 &nbsp;&nbsp; from publishers)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Подзапросы с условием in</td></tr></table></div>&nbsp;</p>
Подзапросы с ключевым словом in (в) возвращают список значений, который может быть пустым. Например, в следующем запросе ищутся названия издательств, которые опубликовали книги по бизнесу:</p>
&nbsp;</p>
select pub_name </p>
from publishers </p>
where pub_id in </p>
 &nbsp; (select pub_id </p>
 &nbsp;&nbsp; from titles </p>
 &nbsp;&nbsp; where type = "business") </p>
&nbsp;</p>
pub_name </p>
------------------------------ </p>
New Age Books </p>
Algodata Infosystems</p>
&nbsp;</p>
(Выбраны 2 строки)</p>
&nbsp;</p>
Этот оператор вычисляется за два шага. На первом шаге внутренний запрос возвращает список номеров издателей, которые печатают книги по бизнесу, а именно номера 1389 и 0736. На втором шаге эти величины подставляются во внешний запрос, чтобы найти названия этих издательств в таблице publishers. На этом шаге запрос выглядит следующим образом: </p>
&nbsp;</p>
select pub_name </p>
from publishers </p>
where pub_id in ("1389", "0736")</p>
&nbsp;</p>
Другой способ задания этого запроса с помощью подзапроса выглядит следующим образом: </p>
&nbsp;</p>
select pub_name </p>
from publishers </p>
where "business" in </p>
 &nbsp; (select type </p>
 &nbsp;&nbsp; from titles </p>
 &nbsp;&nbsp; where pub_id = publishers.pub_id)</p>
&nbsp;</p>
Заметим, что выражение, следующее за ключевым словом where, может быть как константой, так и названием столбца. Можно также использовать выражения других типов, в которых встречаются и константы и названия столбцов: </p>
&nbsp;</p>
select distinct pub_name </p>
from publishers, titles </p>
where publishers.pub_id = titles.pub_id </p>
and type = "business"</p>
&nbsp;</p>
Как этот запрос, так и запрос с подзапросом, будут находить издательства, публикующие книги по бизнесу. Оба они корректны и выдают одинаковые результаты, за исключением того, что в последнем случае используется слово distinct, чтобы исключить повторы.</p>
Однако, одно из преимуществ запроса на соединение перед запросом с подзапросом заключается в том, что в этом случае можно помещать в результат данные из различных таблиц. Например, чтобы включить в результат названия книг по бизнесу, можно воспользоваться следующим запросом на соединение:</p>
&nbsp;</p>
select pub_name, title </p>
from publishers, titles </p>
where publishers.pub_id = titles.pub_id </p>
and type = "business" </p>
&nbsp;</p>
pub_name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; title</p>
----------------------------&nbsp;&nbsp; -----------------------------------------------------</p>
Algodata Infosystems&nbsp;&nbsp; The Busy Executive's Database Guide</p>
Algodata Infosystems&nbsp;&nbsp; Cooking with Computers: Surreptitious&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Balance Sheets</p>
New Age Books&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; You Can Combat Computer Stress!</p>
Algodata Infosystems&nbsp;&nbsp; Straight Talk About Computers</p>
&nbsp;</p>
(Выбрано 4 строки)</p>
&nbsp;</p>
Далее рассмотрим еще один пример, который можно сформулировать как через подзапрос, так и через соединение. На естественном языке этот запрос формулируется следующим образом: “Найти имена всех вторых авторов, кто живет в Калифорнии и получил менее 30 процентов гонорара за книгу”. С использованием подзапроса, оператор будет выглядеть следующим образом:</p>
&nbsp;</p>
select au_lname, au_fname </p>
from authors </p>
where state = "CA" </p>
and au_id in </p>
 &nbsp; (select au_id </p>
 &nbsp;&nbsp; from titleauthor </p>
 &nbsp;&nbsp; where royaltyper &lt; 30 </p>
 &nbsp;&nbsp; and au_ord = 2)</p>
&nbsp;</p>
au_lname&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; au_fname </p>
------------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------ </p>
MacFeather&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Stearns</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
Внешний запрос формирует список из 15 авторов, живущих в Калифорнии. Затем выполняется внутренний запрос и формируется список авторов, которые удовлетворяют всем условиям.</p>
Заметим, что как во внешнем, так и во внутреннем запросе, приходится использовать несколько условий в предложении where.</p>
С использованием соединения, оператор выглядит следующим образом:</p>
&nbsp;</p>
select au_lname, au_fname </p>
from authors, titleauthor </p>
where state = "CA" </p>
  and authors.au_id = titleauthor.au_id </p>
  and royaltyper &lt; 30 </p>
  and au_ord = 2</p>
&nbsp;</p>
Соединение всегда может быть выражено с помощью подзапроса. Подзапрос также часто может быть выражен как соединение.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Подзапросы с условием not in</td></tr></table></div>&nbsp;</p>
Подзапросы, которым предшествует ключевая фраза not in (не в), также возвращают список из ни одного или&nbsp; нескольких значений. Эта фраза означает “не а и не в и не с”.</p>
Следующий запрос находит названия издательств, которые не публиковали книг по бизнесу, то есть запрос обратный запросу рассмотренному в начале предыдущего раздела. </p>
&nbsp;</p>
select pub_name from publishers </p>
where pub_id not in </p>
 &nbsp; (select pub_id </p>
 &nbsp;&nbsp; from titles </p>
 &nbsp;&nbsp; where type = "business")</p>
&nbsp;</p>
pub_name </p>
---------------------------------------- </p>
Binnet &amp; Hardley</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
Этот запрос в точности совпадает с ранее рассмотренным за исключением фразы not in, которая подставлена вместо in. Однако, этот запрос нельзя заменить соединением. Соединение через “не равно” будет иметь другой смысл, а именно, оно будет искать названия издательств, которые опубликовали некоторую книгу не по бизнесу. Трудности, возникающие в интерпретации запросов на соединение, в которых используется неравенство, подробно обсуждались в предыдущей главе 5 “Соединения: Выбор данных из нескольких таблиц”.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Подзапросы с условием not in, содержащие NULL</td></tr></table></div>&nbsp;</p>
Подзапрос, которому предшествует not in, возвращает список значений для каждой строки внешнего запроса. Если значение поля, указанного во внешнем запросе, не содержится в этом списке, то фраза not in интерпретируется как истинная (TRUE) и внешний запрос помещает рассмотреную запись в результирующий список.</p>
Однако, если список значений, возвращаемый внутренним запросом (подзапросом), не содержит указанного значения, но содержит неопределенное значение NULL, то фраза not in интерпретируется как логически неопределенная (UNKNOWN), поскольку в этом случае невозможно точно опеределить принадлежность указанного значения к возвращаемому списку. В этом случае внешний запрос не включает рассмотренную строку (запись) в результат запроса. </p>
Проиллюстрируем это на следующем примере, используя базу pubs2:</p>
&nbsp;</p>
select pub_name</p>
 &nbsp;&nbsp; from publishers</p>
 &nbsp;&nbsp; where $100.00 not in</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (select price</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; from titles</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; where titles.pub_id = publishers.pub_id)</p>
&nbsp;</p>
returns:</p>
&nbsp;</p>
pub_name</p>
----------------------</p>
New Age Books</p>
&nbsp;</p>
В результате указано только издательство New Age Books, которое не публиковало книг по цене 100 долларов. Издательства Binnet &amp; Handley и Algodata Infosystems не были включены в результат, поскольку каждое из них публиковало книги с неустановленной ценой.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Подзапросы с квантором exists</td></tr></table></div>&nbsp;</p>
Подзапросы, которым предшествует ключевое слово exists (существует), осуществляют проверку существования. Другими словами, в предложении where внешнего запроса проверяется существование, хотя бы одной строки, удовлетворяющей подзапросу. На самом деле подзапрос не возвращает никаких данных, а вместо этого возвращает логическое значение TRUE (истина) или FALSE (ложь).</p>
Например, следующий запрос находит названия всех издательств, которые публиковали книги по бизнесу:</p>
&nbsp;</p>
select pub_name </p>
from publishers </p>
where exists </p>
 &nbsp; (select * </p>
 &nbsp;&nbsp; from titles </p>
 &nbsp;&nbsp; where pub_id = publishers.pub_id </p>
 &nbsp;&nbsp; and type = "business")</p>
&nbsp;</p>
pub_name </p>
---------------------------------------- </p>
New Age Books </p>
Algodata Infosystems</p>
&nbsp;</p>
(Выбрано 2 строки)</p>
&nbsp;</p>
Чтобы понять выполнение этого запроса, рассмотрим по порядку название каждого издательства. Будет ли в результате подзапроса хотя бы одна строка с этим названием? Другими словами, будет ли проверка существования истинной (TRUE)?</p>
 В результате предыдущего запроса на втором месте указано издательство Algodata Inforsystems, которое имеет идентификационный номер 1389. Имеется ли хотя бы одна строка в таблице titles, в которой поле pub_id имеет значение 1389 и поле type значение “business”? Если так, то издательство “Algodata Inforsystems” должно попасть в результат. Подобная проверка осуществляется для каждого издательства.</p>
Подзапрос, которому предшествует квантор существования exists, имеет по&nbsp; сравнению с другими подзапросами следующие особенности:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Перед ключевым словом exists не должно быть названий столбцов, констант или других выражений.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Подзапрос с квантором существования возвращает значения TRUE или FALSE и не возвращает никаких данных из таблицы.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Список выбора такого подзапроса часто состоит из одной звездочки (*). Здесь нет необходимости указывать названия столбцов, поскольку осуществляется просто проверка существования строк, удовлетворяющих условиям, указанным в подзапросе. Здесь можно и явно указать список выбора, следуя обычным правилам. </td></tr></table></div>&nbsp;</p>
Ключевое слово exists является очень важным, поскольку часто не существует альтернативного способа выбора данных без использования подзапроса. Подзапросы, которым предшествует квантор exists всегда являются коррелирующимися подзапросами (см. раздел “Использование коррелирующихся подзапросов).</p>
Как уже отмечалось, некоторые запросы с квантором существования нельзя выразить иным способом, но все запросы с условием in или с оператором сравнения, дополненным квантором all или any, можно выразить с помощью подзапроса с exists. Далее приводятся несколько примеров операторов с квантором exists и их эквивалентные альтернативные переформулировки.</p>
Здесь показано два способа нахождения авторов, которые живут в одном городе с издателем:</p>
&nbsp;</p>
select au_lname, au_fname </p>
from authors </p>
where city =any </p>
 &nbsp; (select city </p>
 &nbsp;&nbsp; from publishers)</p>
&nbsp;</p>
select au_lname, au_fname </p>
from authors </p>
where exists </p>
 &nbsp; (select * </p>
 &nbsp;&nbsp; from publishers </p>
 &nbsp;&nbsp; where authors.city = publishers.city)</p>
&nbsp;</p>
au_lname&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; au_fname </p>
--------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------------- </p>
Carson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cheryl </p>
Bennet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Abraham</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 2 строки)</p>
&nbsp;</p>
Далее приводятся два запроса, которые находят книги, опубликованные издательством, расположенном в городе, название которого начинается на букву “В”:</p>
&nbsp;</p>
select title </p>
from titles </p>
where exists </p>
 &nbsp; (select * </p>
 &nbsp;&nbsp; from publishers </p>
 &nbsp;&nbsp; where pub_id = titles.pub_id </p>
 &nbsp;&nbsp; and city like "B%")</p>
&nbsp;</p>
select title </p>
from titles </p>
where pub_id in </p>
 &nbsp; (select pub_id </p>
 &nbsp;&nbsp; from publishers </p>
 &nbsp;&nbsp; where city like "B%") </p>
&nbsp;</p>
title</p>
---------------------------------------------------</p>
The Busy Executive's Database Guide </p>
Cooking with Computers: Surreptitious Balance Sheets</p>
You Can Combat Computer Stress!&nbsp;&nbsp;&nbsp;&nbsp; </p>
Straight Talk About Computers&nbsp;&nbsp;&nbsp; </p>
But Is It User Friendly?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
Secrets of Silicon Valley </p>
Net Etiquette</p>
Is Anger the Enemy?</p>
Life Without Fear</p>
Prolonged Data Deprivation: Four Case Studies</p>
Emotional Security: A New Algorithm</p>
&nbsp;</p>
(Выбрано 11 строк)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Подзапросы с not exists</td></tr></table></div>&nbsp;</p>
Действие квантора not exists (не существует) аналогично действию квантора exists за исключением того, что предложение where, где он используется, считается истинным, когда ни одна строка не удовлетворяет подзапросу.</p>
Например, следующий запрос находит названия издательств, которые не публиковали книг по бизнесу:</p>
&nbsp;</p>
select pub_name </p>
from publishers </p>
where not exists </p>
 &nbsp; (select * </p>
 &nbsp;&nbsp; from titles </p>
 &nbsp;&nbsp; where pub_id = publishers.pub_id </p>
 &nbsp;&nbsp; and type = "business")</p>
&nbsp;</p>
pub_name </p>
------------------------------- </p>
Binnet &amp; Hardley</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
Следующий запрос находит названия книг, которые не покупались:</p>
&nbsp;</p>
select title </p>
from titles </p>
where not exists </p>
 &nbsp; (select title_id </p>
 &nbsp;&nbsp; from salesdetail </p>
 &nbsp;&nbsp; where title_id = titles.title_id) </p>
&nbsp;</p>
title </p>
----------------------------------------- </p>
The Psychology of Computer Cooking </p>
Net Etiquette</p>
&nbsp;</p>
(Выбрано 2 строки)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Нахождение пересечения и разности множеств с помощью exists</td></tr></table></div>&nbsp;</p>
Подзапросы, которым предшествуют кванторы exists и not exists, можно использовать для выполнения двух операций над множествами: пересечения и разности. Пересечение двух множеств состоит из элементов, принадлежащих обеим множествам. Разность состоит из элементов, принадлежащих только первому множеству.</p>
Пересечение таблиц authors и publishers по столбцу city состоит из множества городов, в которых есть и авторы и издательства: </p>
&nbsp;</p>
select distinct city </p>
from authors </p>
where exists </p>
  (select * </p>
 &nbsp; from publishers </p>
 &nbsp; where authors.city = publishers.city) </p>
&nbsp;</p>
city </p>
-------------------- </p>
Berkeley</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
Разность таблиц authors и publishers по столбцу city состоит из множества городов, где проживает автор, но нет издательств, т.е. всех городов за исключением Беркли:</p>
&nbsp;</p>
select distinct city </p>
from authors </p>
where not exists </p>
  (select * </p>
 &nbsp; from publishers </p>
 &nbsp; where authors.city = publishers.city) </p>
&nbsp;</p>
city </p>
-------------------- </p>
Gary&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
Covelo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
Oakland&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
Lawrence&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
San Jose&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
Ann Arbor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
Corvallis&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
Nashville&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
Palo Alto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
Rockville&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
Vacaville&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
Menlo Park&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
Walnut Creek&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
San Francisco&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
Salt Lake City</p>
&nbsp;</p>
(Выбрано 15 строк)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Использование коррелированных подзапросов</td></tr></table></div>&nbsp;</p>
Многие из предыдущих запросов можно было бы выполнить путем однократного вычисления подзапроса и подстановки его результатов в предложение where внешнего запроса. Такие подзапросы называются некоррелированными (независимыми). В запросах, которые требуют повторного вычисления подзапроса, называемого в этом случае коррелированным (зависимым) подзапросом, результаты возвращаемые подзапросом зависят от значений, передаваемых внешним запросом. В этом случае подзапрос выполняется повторно для каждой стоки, которая выбирается во внешнем запросе.</p>
С помощью следующего запроса можно найти всех авторов, получавших 100 процентов гонорара за свои книги.</p>
&nbsp;</p>
select au_lname, au_fname </p>
from authors </p>
where 100 in </p>
 &nbsp; (select royaltyper </p>
 &nbsp;&nbsp; from titleauthor </p>
 &nbsp;&nbsp; where au_id = authors.au_id) </p>
&nbsp;</p>
au_lname&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; au_fname </p>
--------------&nbsp;&nbsp;&nbsp;&nbsp; -------------- </p>
Carson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cheryl&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
Ringer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Albert&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
Straight&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Dick&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
White&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Johnson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
Green&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Marjorie&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
Panteley&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sylvia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
Locksley&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Chastity&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
del Castillo&nbsp;&nbsp;&nbsp; Innes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
Blotchet-Hall&nbsp;&nbsp; Reginald</p>
&nbsp;</p>
(Выбрано 9 строк)</p>
&nbsp;</p>
В противоположность большинству ранее рассмотреных примеров, подзапрос в данном случае нельзя вычислять независимого от основного запроса. В нем используется значение authors.au_id, которое является переменным и зависит от строки, которую SQL Сервер рассматривает в таблице authors.</p>
Рассмотрим подробнее как вычисляется предыдущий запрос. Сначала Transact-SQL просматривает каждую строку в таблице authors и, чтобы выяснить какую из них надо включить в результат, передает соответствующее значение во внутренний подзапрос. Например, предположим, что Transact-SQL просматривает строку, соответствующую Cheryl Carson. Ее идентификатор (authors.au_id) равен “238-95-7766”, поэтому это значение подставляется во внутренний запрос:</p>
select royaltyper </p>
from titleauthor </p>
where au_id = "238-95-7766"</p>
&nbsp;</p>
В результате получим число 100, поэтому внешний запрос в этом случае будет выглядеть следующим образом:</p>
&nbsp;</p>
select au_lname, au_fname </p>
from authors </p>
where 100 in (100)</p>
&nbsp;</p>
Поскольку предложение where является очевидно истинным, то строка Cheryl Carson включается в результат. Если эту же процедуру повторить для Абрахама Беннета (Abraham Bennet), то можно увидеть, почему этот автор не попал в окончательный результат. </p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Коррелированные подзапросы с коррелирующимися названиями</td></tr></table></div>&nbsp;</p>
С помощью коррелированного подзапроса можно найти типы книг, которые публиковались несколькими издательствами: </p>
&nbsp;</p>
select distinct t1.type </p>
from titles t1 </p>
where t1.type in </p>
 &nbsp; (select t2.type </p>
 &nbsp;&nbsp; from titles t2 </p>
 &nbsp;&nbsp; where t1.pub_id != t2.pub_id)</p>
&nbsp;</p>
type </p>
-------------------- </p>
business </p>
psychology</p>
&nbsp;</p>
(Выбрано 2 строки)</p>
&nbsp;</p>
Здесь необходимы коррелирующиеся (согласующиеся) названия, чтобы различить роли, в которых используется таблица titles. Этот многоуровневый запрос эквивалентен следующему запросу на самосоединение:</p>
&nbsp;</p>
select distinct t1.type </p>
from titles t1, titles t2 </p>
where t1.type = t2.type </p>
and t1.pub_id != t2.pub_id</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Коррелированные подзапросы с операциями сравнения</td></tr></table></div>&nbsp;</p>
Подзапросы-выражения также могут быть коррелирующимися. Например, можно следующим образом найти заказы на книги по психологии, в которых количество заказанных книг меньше, чем средний объем продаж этой книги:</p>
&nbsp;</p>
select s1.ord_num, s1.title_id, s1.qty </p>
from salesdetail s1 </p>
where title_id like "PS%" </p>
and s1.qty &lt; </p>
 &nbsp; (select avg(s2.qty) </p>
 &nbsp;&nbsp; from salesdetail s2 </p>
 &nbsp;&nbsp; where s2.title_id = s1.title_id) </p>
&nbsp;</p>
Далее приводятся результаты этого запроса:</p>
&nbsp;</p>
ord_num&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;title_id&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; qty&nbsp;&nbsp;&nbsp;&nbsp; </p>
------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----</p>
91-A-7&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;PS3333&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 90&nbsp; </p>
91-A-7&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;PS2106&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 30&nbsp; </p>
55-V-7&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;PS2106&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 31&nbsp; </p>
AX-532-FED-452-2Z7&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;PS7777&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 125</p>
BA71224&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;PS7777&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 200&nbsp; </p>
NB-3.142&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;PS2091&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 200&nbsp; </p>
NB-3.142&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;PS7777&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 250&nbsp; </p>
NB-3.142&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;PS3333&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 345&nbsp; </p>
ZD-123-DFG-752-9G8  &nbsp; &nbsp; &nbsp; &nbsp;PS3333&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 750&nbsp; </p>
91-A-7&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;PS7777&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 180&nbsp; </p>
356921&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;PS3333&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 200</p>
&nbsp;</p>
(Выбрано 11 строк)</p>
&nbsp;</p>
Внешний запрос выбирает книги из таблицы sales (или “s1”) одну за другой. Подзапрос вычисляет среднее значение числа экземпляров этой книги продаваемых в одном заказе и если это значение превосходит число запрашиваемых экзепляров, то соответствующий заказ включается в результат.</p>
В некоторых случаях коррелированный подзапрос имитирует действие оператора, содержащего предложение group by. Следующий запрос находит названия книг, имеющих цену, превосходящую среднюю цену книг этого типа:</p>
&nbsp;</p>
select t1.type, t1.title </p>
from titles t1 </p>
where t1.price &gt; </p>
 &nbsp; (select avg(t2.price) </p>
 &nbsp;&nbsp; from titles t2 </p>
 &nbsp;&nbsp; where t1.type = t2.type) </p>
&nbsp;</p>
type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;title </p>
---------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------------------------------------------------------------</p>
business&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; The Busy Executive's Database Guide </p>
business&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; Straight Talk About Computers </p>
mod_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; Silicon Valley Gastronomic Treats </p>
popular_comp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; But Is It User Friendly? </p>
psychology&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; Computer Phobic and Non-Phobic Individuals: Behavior Variations </p>
psychology&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;  Prolonged Data Deprivation: Four Case Studies </p>
trad_cook&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;  Onions, Leeks, and Garlic: Cooking Secrets of&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; the Mediterranean</p>
&nbsp;</p>
(Выбрано 7 строк)</p>
&nbsp;</p>
Для каждой строки из таблицы t1 Transact-SQL вычисляет подзапрос и включает строку в результат, если цена книги, указанная в этой строке, больше чем вычисленная средняя цена. Здесь нет необходимости явно группировать книги по типам, поскольку строки, по которым вычисляются средняя цена, отбираются в предложении where подзапроса.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td> Коррелированные подзапросы в предложении having </td></tr></table></div>&nbsp;</p>
Квантифицированные подзапросы также могут быть коррелированными. В следующем примере с коррелированным подзапросом, расположенном в предложении having, ищутся типы книг, по которым максимальный выплаченный аванс более чем вдвое превосходит средний аванс, выплаченный для книг данного типа:</p>
&nbsp;</p>
select t1.type </p>
from titles t1 </p>
group by t1.type </p>
having max(t1.advance) &gt;=any </p>
 &nbsp; (select 2 * avg(t2.advance) </p>
 &nbsp; from titles t2 </p>
 &nbsp; where t1.type = t2.type)</p>
&nbsp;</p>
type </p>
------------- </p>
mod_cook</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
Этот подзапрос будет вычисляться один раз для каждой группы, опеределенной во внешнем запросе, т.е. один раз для каждого типа книг.</p>
&nbsp;</p>
