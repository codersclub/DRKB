<h1>Подведение итогов, группировка и сортировка</h1>
<div class="date">01.01.2007</div>


<p>Подведение итогов, Группировка и Сортировка Результатов Запроса</p>
&nbsp;</p>
В операторе выбора select можно подводить итоги (суммировать), группировать, сортировать результаты запросов с помощью агрегирующих функций, которые располагаются в конструкциях group by (группировка), having (имеющий), order by (упорядочение). В языке Transact SQL можно также использовать агрегирующие функции в конструкции compute (вычислить) для получения отчета с итоговыми строками. Оператор union (объединение) позволяет соединять результаты запросов.</p>
&nbsp;</p>
В этой главе рассматриваются следующие темы:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Как вычислить итоговые значения, используя агрегирующие функции;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Как организовать группу данных из результатов запроса;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Как отбирать группы данных;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Как упорядочить результаты запроса;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Как вычислить итоговое значение по группам данных;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Как соединять результаты запросов.</td></tr></table></div>&nbsp;</p>
Если ваш SQL Server не различает регистр символов, то в Справочном руководстве SQL Сервера можно посмотреть примеры зависимости возвращаемых результатов от регистра символов в конструкциях compute и group by.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Вычисление итоговых значений с помощью агрегирующих функций</td></tr></table></div>&nbsp;</p>
Агрегирующие функции вычисляют итоговые значения по данным, расположенным в отдельном столбце.</p>
&nbsp;</p>
Агрегирующие функции можно применять ко всем строкам таблицы, к части строк, отобранных с помощью конструкции where (где), или к одной или нескольким группам строк в таблице. Для каждого подмножества строк, к которому применяется агрегирующуя функция, вычисляется отдельное итоговое значение.</p>
&nbsp;</p>
В следующем примере вычисляется общая сумма, вырученная от продажи книг в текущем году:</p>
&nbsp;</p>
select sum(total_sales)</p>
from titles</p>
-----------------------------&nbsp;</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 97446</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрана 1 строка)</p>
&nbsp;</p>
Заметим, что при вычислении агрегирующих функций следует сначала указать название функции, а затем в скобках название столбца, к которому она применяется. В общем случае агрегирующая функция задается следующим образом:</p>
&nbsp;</p>
aggregate_function ([all | distinct] выражение)</p>
&nbsp;</p>
К агрегирующим функциям относятся sum (сумма), avg (среднее значение), max (максимум), min (минимум), count (подсчет количества) и count(*) (общее число). Опция distinct (различные), которая может использоваться в фукциях sum, avg и count, позволяет исключить дублирующие значения и вести подсчет только различных значений указанного поля данных. Эту опцию нельзя использовать в функциях max, min и count(*). Для функций sum, avg и count по умолчанию предполагается опция all (все), которая указывает на выполнение операций по всем значениям, включая дублирующиеся. Опцию all можно не указывать.</p>
&nbsp;</p>
Выражение, выступающее в качестве аргумента агрегирующей функции, является обычно названием столбца таблицы. Но в качестве аргумента можно также указать константу, функцию или любую комбинацию из названий столбцов, констант и функций, соединенных арифметическими или битовыми операциями. В качестве аргумента может также выступать подзапрос.</p>
&nbsp;</p>
Например, в следующем запросе выясняется какой будет средняя цена книги, если все цены на книги предварительно удвоить:</p>
&nbsp;</p>
select avg(price * 2)</p>
from titles</p>
--------------------------</p>
 &nbsp; &nbsp; &nbsp; &nbsp;29.53</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрана 1 строка)</p>
&nbsp;</p>
В следующей таблице указан синтаксис агрегирующих функций и результаты, которые они возвращают.</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td>Функция</p>
</td>
<td>Результат</p>
</td>
</tr>
<tr>
<td>sum([all | distinct] выражение)</p>
</td>
<td>Общая сумма (различных) значений выражения</p>
</td>
</tr>
<tr>
<td>avg([all | distinct] выражение)</p>
</td>
<td>Средняя величина (различных) значений выражения</p>
</td>
</tr>
<tr>
<td>count([all | distinct] выражение)</p>
</td>
<td>Число (различных) отличных от нее значений выражения</p>
</td>
</tr>
<tr>
<td>count(*)</p>
</td>
<td>Общее число выбранных строк</p>
</td>
</tr>
<tr>
<td>max(выражение)</p>
</td>
<td>Максимальное значение выражения</p>
</td>
</tr>
<tr>
<td>min(выражение)</p>
</td>
<td>Минимальное значение выражения
</td>
</tr>
</table>
&nbsp;</p>
Таблица 3-1: Синтаксис и результаты агрегирующих функций</p>
&nbsp;</p>
Агрегирующие функции можно использовать в списке выбора, как это было показано в предыдущем примере, или в конструкции having (см. главу “Выбор Групп Данных: Конструкция having”).</p>
&nbsp;</p>
Агрегирующие функции нельзя использовать в конструкции where (где).</p>
&nbsp;</p>
Однако, оператор выбора, содержащий агрегирующие функции в списке выбора, часто содержит конструкцию where, предназначенную для отбора строк, к которым применяются агрегирующие функции. В вышеприведенных примерах каждая агрегирующая функция давала одно итоговое значение для всей таблицы (без отбора строк).</p>
&nbsp;</p>
Если оператор выбора содержит конструкцию where, но не содержит конструкцию group by (группировка), то агрегирующая функция будет выдавать одно значение для подмножества строк, отобранных конструкцией where. Однако, в расширении Transact-SQL можно также указать название столбца в списке выбора, в результате чего в каждой строке будет повторяться одно и то же итоговое значение. В этом случае результат запроса будет таким же, как и при использовании конструкции having, как это описывается в главе “Выбор Групп Данных: Конструкция having”.</p>
&nbsp;</p>
В следующем запросе вычисляется среднее значение аванса и общая годовая сумма, вырученная только от продажи книг по бизнесу.</p>
&nbsp;</p>
select avg(advance), sum(total_sales)</p>
from titles</p>
where type = “business”</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------------------</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 6,281.25&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 30788</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрана 1 строка)</p>
&nbsp;</p>
Когда агрегирующая функция используется в операторе выбора, который не содержит конструкции group by, то в результате появится одно итоговое значение независимо от наличия или отсутствия конструкции отбора where. Это называется скалярным агрегированием.</p>
&nbsp;</p>
Заметим, что можно использовать несколько агрегирующих функций в одном и том же списке выбора и получить несколько скалярных итоговых значений в одном операторе выбора.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Агрегирующие функции и типы данных</td></tr></table></div>&nbsp;</p>
Функции sum (сумма) и avg (среднее) могут применяться только к числовым типам - int (целое), smallint (малое целое), tinyint (очень малое целое), decimal (десятичное), numeric (числовой), float (плавающий), money (денежный).</p>
&nbsp;</p>
Функции min (минимум) и max (максимум) нельзя применять к данным типа bit (бит).</p>
&nbsp;</p>
Агрегирующие функции, отличные от count(*), нельзя применять к данным типа text (текст) и image (графика).</p>
&nbsp;</p>
С указанными ограничениями, агрегирующие функции можно применять к любым типам данных. Например, можно вычислить минимум в поле, имеющем символьный (character) тип, по отношению к словарному порядку:</p>
&nbsp;</p>
select min(au_lname)</p>
from authors</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------------------------</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bennet</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрана 1 строка)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Использование функции count(*)</td></tr></table></div>&nbsp;</p>
Функция count(*) (общее число) не имеет аргумента, поскольку по определению она относится ко всей таблице, а не к отдельному ее столбцу. Она используется для нахождения общего числа строк в таблице. В следующем запросе находится общее число книг, имеющихся в таблице:</p>
&nbsp;</p>
select count(*)</p>
from titles</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------------------------</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 18</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрана 1 строка)</p>
&nbsp;</p>
Функция count(*) возвращает общее число строк в таблице, включая одинаковые строки. При этом каждая строка считается отдельно, включая строки, содержащие неопределенные (пустые) значения.</p>
&nbsp;</p>
Как и другие агрегирующие функции, функция count(*) может комбинироваться с другими агрегирующими функциями в списке выбора, с конструкцией where и т.д. Например:</p>
&nbsp;</p>
select count(*), avg(price)</p>
from titles</p>
where advance &gt; 1000</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ---------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------------------</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 15 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;14.2</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрана 1 строка)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Использование агрегирующих функций с опцией distinct</td></tr></table></div>&nbsp;</p>
Как уже отмечалось, опцию distinct (различные) можно использовать в функциях sum, avg и count. Ее нельзя использовать в функциях min, max и count(*). Если используется эта опция, то перед применением агрегирующей функции устраняются все дублирующиеся значения аргумента.</p>
&nbsp;</p>
Кроме того, если используется эта опция, то аргумент не может быть арифметическим выражением. Он должен состоять только из названия столбца таблицы.</p>
&nbsp;</p>
Опция distinct должна быть расположена внутри скобок перед названием столбца. Например, для нахождения числа различных городов, где живут авторы книг, можно использовать следующий запрос:</p>
&nbsp;</p>
select count(distinct city)</p>
from authors</p>
--------------------------</p>
 &nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;16</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрана 1 строка)</p>
&nbsp;</p>
Следующий оператор возвращает среднюю величину различных цен для книг по бизнесу:</p>
&nbsp;</p>
select avg(distinct price)</p>
from titles</p>
where type = “business”</p>
-------------------------------</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 11.64</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрана 1 строка)</p>
&nbsp;</p>
Если несколько книг имеют одинаковую цену и используется опция distinct, то их цена будет посчитана только один раз. Конечно, для правильного подсчета средней цены, необходимо удалить опцию distinct:</p>
&nbsp;</p>
select avg(price)</p>
from titles</p>
where type = “business”</p>
-------------------------------</p>
   &nbsp; &nbsp; &nbsp; &nbsp;13.73</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрана 1 строка)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Неопределенные значения и агрегирующие функции</td></tr></table></div>&nbsp;</p>
Любое неопределенное значение, появляющееся в столбце по которому вычисляется агрегирующая функция, будет игнорироваться. Если установлена опция ansinull, SQL Сервер каждый раз будет выдавать сообщение об ошибке при появлении неопределенного значения. Более детальную информацию о команде установки опций set можно посмотреть в Справочном руководстве SQL Сервера.</p>
&nbsp;</p>
Если все значения в столбце таблицы являются неопределенными, то функция count(column_name) возвратит ноль. Например, результат запроса на подсчет числа выданных авансов, хранящихся в таблице titles, может отличаться от числа книг, хранящихся в этой таблице, поскольку в столбце advance (аванс) могут встретиться неопределенные значения:</p>
&nbsp;</p>
select count(advance)</p>
from titles</p>
--------------------------</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 16</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрана 1 строка)</p>
&nbsp;</p>
select count(titles)</p>
from titles</p>
--------------------------</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 18</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрана 1 строка)</p>
&nbsp;</p>
Исключением здесь является функция count(*), которая считает и строки с неопределенным значением.</p>
&nbsp;</p>
Если ни одна строка не удовлетворяет условиям отбора, содержащимся в конструкции where, то функция count возвращает нулевое значение. Все остальные функции в этом случае возвращают неопределенное значение NULL. Ниже приводятся два примера:</p>
&nbsp;</p>
select count(distinct title)</p>
from titles</p>
where type = “poetry”</p>
-------------------------------</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрана 1 строка)</p>
&nbsp;</p>
select avg(advance)</p>
from titles</p>
where type = “poetry”</p>
-------------------------------</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрана 1 строка)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>   Группировка результатов запроса: Конструкция group by</td></tr></table></div>&nbsp;</p>
Конструкция group by (группировка) используется в операторе выбора для разделения результатов на группы. Группировку можно проводить по одному или нескольким названиям столбцов, или по результат вычисления, используя числовые типы данных в выражении. В конструкции group by максимальное число названий столбцов и выражений не должно превосходить 16.</p>
&nbsp;</p>
Примечание. Нельзя проводить группировку по столбцам типа text или image.</p>
&nbsp;</p>
Конструкция group by почти всегда появляется в операторе при вычислении агрегирующих функций, поскольку в этом случае агрегирующая функция будет вычисляться для каждой группы. Это называется векторным агрегированием. Напомним, что скалярное агрегирование заключается в вычислении одного значения агрегирующей функции в операторе, не содержащем конструкции group by.</p>
&nbsp;</p>
В следующем примере на векторное агрегирование вычисляется средняя величина аванса и годовая сумма продаж по каждому виду книг:</p>
&nbsp;</p>
select type, avg(advance), sum(total_sales)</p>
from titles</p>
group by type</p>
&nbsp;</p>
type</p>
------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------------&nbsp;&nbsp;&nbsp; ----------</p>
UNDECIDED &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;NULL &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;NULL</p>
business &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 6,281.25 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 30788</p>
mod_cook &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;7,500.00 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 24278</p>
popular_comp &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;7,500.00 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 12875</p>
psychology &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;4,255.00 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 9939</p>
trad_cook &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;6,333.33&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;19566</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 6 строк)</p>
&nbsp;</p>
Итоговые значения при векторном агрегировании появляются в виде столбца значений по одному в строке для каждой группы. В противоположность этому при скалярном агрегировании появляется только одна строка итоговых значений на каждый столбец исходных величин. Например:</p>
&nbsp;</p>
select avg(advance), sum(total_sales)</p>
from titles</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------------&nbsp;&nbsp;&nbsp;&nbsp; ------------</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5,962.50 &nbsp; &nbsp; &nbsp; &nbsp;97466</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрана 1 строка)</p>
&nbsp;</p>
Хотя формально можно использовать группировку без агрегирования, но эта конструкция не имеет особого смысла и может иногда привести к абсурдному результату. В следующем примере делается попытка использовать группировку по видам книг без агрегирования:</p>
&nbsp;</p>
select type, advance</p>
from titles</p>
group by type</p>
&nbsp;</p>
type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; advance</p>
------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ---------------</p>
business&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5,000.00</p>
business&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5,000.00</p>
business&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 10,125.00</p>
business&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5,000.00</p>
mod_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0.00</p>
mod_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 15,000.00</p>
UNDECIDED&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
popular_comp&nbsp;&nbsp;&nbsp; 7,000.00</p>
popular_comp&nbsp;&nbsp;&nbsp; 8,000.00</p>
popular_comp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
psychology&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7,000.00</p>
psychology&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2,275.00</p>
psychology&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 6,000.00</p>
psychology&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2,000.00</p>
psychology&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4,000.00</p>
trad_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7,000.00</p>
trad_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4,000.00</p>
trad_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 8,000.00</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 18 строк)</p>
&nbsp;</p>
Таким образом, без агрегирования по столбцу advance, выдаются результаты для каждой строки таблицы.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Синтаксис конструкции group by</td></tr></table></div>&nbsp;</p>
Повторим здесь полный синтаксис оператора select, чтобы посмотреть в общем контексте на конструкцию group by.</p>
&nbsp;</p>
select [all | distinct] список_выбора</p>
  [into&nbsp; [[database.] owner.] название_таблицы]</p>
  [from [[database.] owner.] { название_таблицы | название_вьювера</p>
 &nbsp;&nbsp;&nbsp; [(index название_индекса [prefetch размер] [lru | mru] ) ] }</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [holdlock | noholdlock] [shared]</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [,[[database.] owner.] { название_таблицы | название_вьювера</p>
 &nbsp;&nbsp;&nbsp; [(index название_индекса [prefetch размер] [lru | mru] ) ] }</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [ holdlock | noholdlock ] [shared] ] ... ]</p>
  [where условия_выбора ]</p>
  [group by [all] итоговое_выражение</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [, итоговое_выражение ] ... ]</p>
  [having условия_поиска ]</p>
  [order by</p>
  { [[database.] owner.] { название_таблицы. | название_вьювера. } ]</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; название_столбца | номер_списка_выбора | выражение }</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [ask | desc]</p>
  [, { [[database.] owner.] { название_таблицы. | название_вьювера. } ]</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; название_столбца | номер_списка_выбора | выражение }</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [ask | desc] ... ]</p>
  [compute row_agregate (название_столбца)</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [, row_agregate (название_столбца) ] ...</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [by название_столбца [, название_столбца] ... ]]</p>
  [for {read only | update [of список_названий_столбцов] } ]</p>
  [at isolation {read uncommitted | read committed |</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; serializable} ]</p>
  [for browse]</p>
&nbsp;</p>
Напомним, что указанный порядок следования конструкций в операторе выбора является обязательным. Можно пропустить любое число необязательных конструкций, но если конструкция присутствует, то она обязательно должна появиться в указанном порядке.</p>
&nbsp;</p>
Стандарт SQL на использование конструкции group by является более строгим по сравнению с вышеуказанным. Стандарт требует соблюдения следующих условий:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Названия столбцов, находящиеся в списке выбора, должны присутствовать&nbsp;&nbsp;&nbsp; также в&nbsp; конструкции group by или быть аргументами агрегирующих функций.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Названия столбцов в конструкции group by должны присутствовать также в списке выбора за исключением тех, которые выступают только как аргументы агрегирующих функций.</td></tr></table></div>&nbsp;</p>
Результаты группировки, построенной в соответствии со стандартом, будут содержать по одной строке и по одному итоговому значению на каждую группу. В некоторых версиях языка Transact-SQL (описываемых в следующих главах) эти ограничения ослаблены, но за счет возрастания сложности получаемых результатов. Если пользователь хочет воздержаться от использования этих расширений, то он может установить опцию fipsflagger:</p>
&nbsp;</p>
set fipsflagger on</p>
&nbsp;</p>
В этом случае при использовании дополнительных возможностей языка Transact-SQL будет выдаваться предупреждающее сообщение. Дополнительную информацию об этой опции и о команде установки опций set можно посмотреть в Справочном руководстве SQL Сервера.</p>
&nbsp;</p>
Группировку можно вести по нескольким столбцам, чтобы разбить таблицу на более мелкие группы. Например, в следующем запросе вычисляется средняя цена книги и годовая сумма продаж для каждого книжного издательства и для каждого вида книг, выпускаемого этим издательством:</p>
&nbsp;</p>
select pub_id, type, avg(price), sum(total_sales)</p>
from titles</p>
group by pub_id, type</p>
&nbsp;</p>
pub_id&nbsp; type</p>
------&nbsp; -----------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------&nbsp;&nbsp;&nbsp; -------</p>
&nbsp;</p>
0736&nbsp;&nbsp;&nbsp; business &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2.99&nbsp;&nbsp; 18722</p>
0736&nbsp;&nbsp;&nbsp; psychology &nbsp; &nbsp; &nbsp; &nbsp;11.48&nbsp;&nbsp;&nbsp; 9564</p>
0877&nbsp;&nbsp;&nbsp; UNDECIDED &nbsp; &nbsp; &nbsp; &nbsp;NULL&nbsp;&nbsp;&nbsp; NULL</p>
0877&nbsp;&nbsp;&nbsp; mod_cook &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;11.49&nbsp;&nbsp; 24278</p>
0877&nbsp;&nbsp;&nbsp; psychology &nbsp; &nbsp; &nbsp; &nbsp;21.59&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 375</p>
0877&nbsp;&nbsp;&nbsp; trad_cook &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;15.96&nbsp;&nbsp; 19566</p>
1389&nbsp;&nbsp;&nbsp; business &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;17.31&nbsp;&nbsp; 12066</p>
1389&nbsp;&nbsp;&nbsp; popular_comp &nbsp; &nbsp; &nbsp; &nbsp;21.48&nbsp;&nbsp; 12875</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 8 строк)</p>
&nbsp;</p>
Можно разбивать группы на все более мелкие подгруппы до тех пор, пока вложенность названий столбцов и выражений в конструкции group by не достигнет 16.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Ссылка на другие столбцы в запросах с использованием group by</td></tr></table></div>&nbsp;</p>
С целью расширения возможностей, заложенных в стандартном SQL, в языке Transact-SQL не накладывается никаких ограничений на содержание списка выбора в операторе select, который содержит конструкцию группировки:</p>
1. Названия столбцов в списке выбора не обязаны присутствовать также в&nbsp;&nbsp;&nbsp; конструкции группировки или быть аргументами агрегирующих функций.</p>
2.&nbsp; Названия столбцов в конструкции группировки не обязаны присутствовать в списке выбора.</p>
&nbsp;</p>
Векторное агрегирование предполагает, что названия нескольких столбцов указаны в конструкции группировки. Стандарт SQL требует, чтобы все названия столбцов в списке выбора, к которым не применяются агрегирующие функции, присутствовали также в конструкции group by. Однако первое из вышеуказанных расширений позволяет указывать “дополнительные” столбцы в списке выбора запроса.</p>
&nbsp;</p>
Например, следующий запрос, в котором введен дополнительный столбец title_id в список выбора, был бы неправильным для большинства версий SQL, но он является вполне допустимым в языке Transact-SQL:</p>
&nbsp;</p>
select type, title_id, avg(price), avg(advance)</p>
from titles</p>
group by type</p>
&nbsp;</p>
type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; title_id</p>
-------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------&nbsp;&nbsp; -----------</p>
business&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;BU1032 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 13.73&nbsp;&nbsp; 6,281.25</p>
business &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BU1111 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 13.73&nbsp;&nbsp; 6,281.25</p>
business&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;BU2075 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 13.73&nbsp;&nbsp; 6,281.25</p>
business&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;BU7832 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 13.73&nbsp;&nbsp; 6,281.25</p>
mod_cook &nbsp; &nbsp; &nbsp; &nbsp;MC2222 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 11.49&nbsp;&nbsp; 7,500.00</p>
mod_cook &nbsp; &nbsp; &nbsp; &nbsp;MC3021 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 11.49&nbsp;&nbsp; 7,500.00</p>
UNDECIDED &nbsp; &nbsp; &nbsp; &nbsp;MC3026 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp; NULL</p>
popular_comp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PC1035 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 21.48&nbsp;&nbsp; 7,500.00</p>
popular_comp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PC8888 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 21.48&nbsp;&nbsp; 7,500.00</p>
popular_comp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PC9999 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 21.48&nbsp;&nbsp; 7,500.00</p>
psychology &nbsp; &nbsp; &nbsp; &nbsp;PS1372 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 13.50&nbsp;&nbsp; 4,255.00</p>
psychology &nbsp; &nbsp; &nbsp; &nbsp;PS2091 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 13.50&nbsp;&nbsp; 4,255.00</p>
psychology &nbsp; &nbsp; &nbsp; &nbsp;PS2106 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 13.50&nbsp;&nbsp; 4,255.00</p>
psychology &nbsp; &nbsp; &nbsp; &nbsp;PS3333&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 13.50&nbsp;&nbsp; 4,255.00</p>
psychology &nbsp; &nbsp; &nbsp; &nbsp;PS7777 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 13.50&nbsp;&nbsp; 4,255.00</p>
trad_cook &nbsp; &nbsp; &nbsp; &nbsp;TC3218 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 15.96&nbsp;&nbsp; 6,333.33</p>
trad_cook &nbsp; &nbsp; &nbsp; &nbsp;TC4203&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 15.96&nbsp;&nbsp; 6,333.33</p>
trad_cook &nbsp; &nbsp; &nbsp; &nbsp;TC7777 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 15.96&nbsp;&nbsp; 6,333.33</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 18 строк)</p>
&nbsp;</p>
В этом примере по группам, определяемым видом (типом) книг type, вычисляется среднее значение в столбцах price и advance, но в результате дополнительно выводится номер книги в столбце title_id, поэтому среднее значение цены и аванса повторяется для всех книг из одной группы.</p>
&nbsp;</p>
Второе из вышеуказанных расширений позволяет проводить группировку по столбцам, которых нет в списке выбора данного запроса. Эти столбцы не появляются в результате запроса, однако они влияют на образование групп, а следовательно и на&nbsp; результаты вычисления итоговых значений. Например:</p>
&nbsp;</p>
select state, count(au_id)</p>
from authors</p>
group by state, city</p>
&nbsp;</p>
&nbsp;</p>
state</p>
-----------&nbsp; ---------</p>
AU &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1</p>
CA &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2</p>
CA &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1</p>
CA &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;5</p>
CA &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2</p>
CA &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1</p>
CA &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1</p>
CA &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1</p>
CA &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1</p>
IN &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1</p>
KS &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1</p>
MD &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1</p>
MI &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1</p>
OR &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1</p>
TN &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1</p>
UT &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 16 строк)</p>
&nbsp;</p>
В этом примере группировка осуществляется по штату (state) и городу (city), где проживает автор, однако из результата этого запроса не видно какие именно города участвовали в образовании групп.</p>
&nbsp;</p>
Из этих примеров видно, что достаточно трудно понимать результаты запросов, использующих эти расширения. Для понимания таких запросов необходимо знать, как SQL Сервер будет исполнять их. Например, на первый взгляд кажется, что в ответ на следующий запрос, будут выданы такие же результаты, что и в предыдущем примере, поскольку векторная агрегация сводится к подсчету числа авторов, проживающих в одном городе:</p>
&nbsp;</p>
select state, count(au_id)</p>
from authors</p>
group by city</p>
&nbsp;</p>
Однако, результаты будут совершенно другими (и вводящими в заблуждение). Поскольку не была проведена группировка по штатам и городам, в запросе будет подсчитано число авторов в каждом городе, но при выводе результатов итоговое значение будет выведено для каждой строки в таблице authors, в которой встречается данный город, вместо того чтобы сгруппировать их в один результат для каждого города.</p>
&nbsp;</p>
Когда расширенные возможности языка Transact-SQL используются в сложных запросах, включающих соединение и конструкцию where, то понять их бывает еще труднее. Чтобы избежать ошибок и заблуждений при использовании конструкции group by, следует очень осторожно использовать эти расширения. Следует также установить опцию (флаг) fipsflagger, чтобы выделить запросы, использующие эти дополнительные возможности.</p>
&nbsp;</p>
Дополнительную информацию о расширениях языка Transact-SQL, касающихся группировки,&nbsp; и о том как они исполняются можно посмотреть в Справочном руководстве SQL Сервера.</p>
&nbsp;</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Выражения и конструкция group by</td></tr></table></div>&nbsp;</p>
Другой дополнительной возможностью языка Transact-SQL по отношению к SQL является группировка по выражению, которое не содержит агрегирующих функций. В стандартном языке SQL группировку можно проводить только по названиям столбцов. Например, следующий запрос допустим в языке Transact-SQL:</p>
&nbsp;</p>
select avg(total_sales), total_sales * price</p>
from titles</p>
group by total_sales * price</p>
&nbsp;</p>
----------------&nbsp;&nbsp;&nbsp; -------------------</p>
 &nbsp;&nbsp;&nbsp;&nbsp; 111&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 777.00&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp; 375&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7,856.25&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp; 375&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 8,096.25</p>
 &nbsp;&nbsp;&nbsp; 2045&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 22,392.75&nbsp;</p>
 &nbsp;&nbsp;&nbsp; 3336&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 26,654.64&nbsp;</p>
 &nbsp;&nbsp;&nbsp; 2032&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 40,619.68&nbsp;</p>
 &nbsp;&nbsp;&nbsp; 3876&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 46,318.20&nbsp;</p>
 &nbsp;&nbsp; 18722&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 55,978.78&nbsp;</p>
 &nbsp;&nbsp;&nbsp; 4095&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 61,384.05&nbsp;</p>
 &nbsp;&nbsp; 22246&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 66,515.54&nbsp;</p>
 &nbsp;&nbsp;&nbsp; 4072&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 81,399.28&nbsp;</p>
 &nbsp;&nbsp;&nbsp; 4095&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 81,859.05&nbsp;</p>
 &nbsp;&nbsp;&nbsp; 4095&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 81,900.00&nbsp;</p>
 &nbsp;&nbsp; 15096&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 180,397.20&nbsp;</p>
 &nbsp;&nbsp;&nbsp; 8780&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 201,501.00</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 15 строк)</p>
&nbsp;</p>
Нельзя группировать по заголовкам столбцов или псевдонимам (alias),&nbsp; хотя псевдонимы можно использовать в списке выбора. Следующий запрос вызовет сообщение об ошибке:</p>
&nbsp;</p>
select Category = type, title_id, avg(price), avg(advance)</p>
from titles</p>
group by Category /* Неправильное использование заголовка */</p>
&nbsp;</p>
Чтобы скорректировать этот запрос, следует в конструкции group by указать название столбца type.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Вложенное агрегирование с группировкой</td></tr></table></div>&nbsp;</p>
Еще одним расширением языка Transact-SQL является возможность вложенного агрегирования, то есть использование векторного агрегирования внутри скалярного. Например, в следующем запросе вычисляется средняя цена для каждого вида книг:</p>
&nbsp;</p>
select avg(price)</p>
from titles</p>
group by type</p>
&nbsp;</p>
----------------</p>
NULL</p>
13.73</p>
11.49</p>
21.48</p>
13.50</p>
15.96</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 6 строк)</p>
&nbsp;</p>
Но можно в одном запросе сразу найти максимальное значение средней цены по всем видам книг путем композиции агрегирующих функций avg и max:</p>
&nbsp;</p>
select max(avg(price))</p>
from titles</p>
group by type</p>
&nbsp;</p>
---------------------</p>
 &nbsp; &nbsp; &nbsp; &nbsp;21.48</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрана 1 строка)</p>
&nbsp;</p>
По определению конструкция group by применяется всегда к самой внутренней агрегирующей функции - в данном случае к функции avg.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Неопределенные значения и конструкция group by</td></tr></table></div>&nbsp;</p>
Если столбец, по которому проводится группировка, содержит неопределенные значения, то все строки содержащие это значение (null), собираются в одну группу.</p>
&nbsp;</p>
Например, столбец advance из таблицы titles содержит несколько неопределенных значений. В следующем примере проводится группировка по этому столбцу:</p>
&nbsp;</p>
select advance, avg(price * 2)</p>
from titles</p>
group by advance</p>
&nbsp;</p>
advance&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
------------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----------------&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 39.98&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2,000.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 39.98&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2,275.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 21.90&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4,000.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 19.94&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5,000.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 34.62&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 6,000.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 14.00&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7,000.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 43.66&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 8,000.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 34.99&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 10,125.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5.98&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 15,000.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5.98</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 11 строк)</p>
&nbsp;</p>
Если используется агрегирующая функция count(название_столбца) и группировка проводится по столбцу, содержащему неопределенные значения, то для группы строк, соответствующей неопределенному значению, будет выдан в результате ноль, поскольку функция count не считает неопределенные значения. В большинстве случаев здесь для подсчета нужно использовать функцию count(*). В следующем примере проводится группировка по столбцу price из таблицы titles и для сравнения выводятся значения функций count и count(*):</p>
&nbsp;</p>
select price, count(price), count(*)</p>
from titles</p>
group by price</p>
&nbsp;</p>
price&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
---------------&nbsp;&nbsp; -----&nbsp;&nbsp; -----</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2.99&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7.99&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 10.95&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 11.95&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 14.99&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 19.99&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 20.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 20.95&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 21.59&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 212px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">22.95</td><td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</td></tr></table></div>&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 12 строк)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Конструкции where и group by</td></tr></table></div>&nbsp;</p>
В операторе, содержащем конструкцию группировки, можно также использовать конструкцию отбора where (где). В этом случае строки, не удовлетворяющие условиям отбора, выключаются из процесса группировки, как это продемонстрировано в следующем примере:</p>
&nbsp;</p>
select type, avg(price)</p>
from titles</p>
where advance &gt; 5000</p>
group by type</p>
&nbsp;</p>
type</p>
--------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------</p>
business &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2.99</p>
mod_cook &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2.99</p>
popular_comp &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;21.48</p>
psychology &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;14.30</p>
trad_cook &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;17.97</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 5 строк)</p>
&nbsp;</p>
Здесь группируются только строки, для которых величина аванса (advance) превосходит $5000, и затем вычисляются значения агрегирующих функций. Результаты этого запроса будут сильно отличаться от результатов запроса, в котором отсутствует конструкция where.</p>
&nbsp;</p>
Однако, способ, которым SQL Сервер вычисляет результаты, когда в списке выбора присутствует дополнительный столбец, на первый взгляд противоречат условиям отбора. Действительно, рассмотрим следующий пример:</p>
&nbsp;</p>
select type, advance, avg(price)</p>
from titles</p>
where advance &gt; 5000</p>
group by type</p>
&nbsp;</p>
type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; advance</p>
-------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------&nbsp;&nbsp;&nbsp;&nbsp; ----------</p>
business&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5,000.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2.99</p>
business&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5,000.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2.99</p>
business&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 10,125.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2.99</p>
business&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5,000.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2.99</p>
mod_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2.99</p>
mod_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 15,000.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2.99</p>
popular_comp&nbsp; 7,000.00&nbsp;&nbsp;&nbsp;&nbsp; 21.48</p>
popular_comp&nbsp; 8,000.00&nbsp;&nbsp;&nbsp;&nbsp; 21.48</p>
popular_comp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp; 21.48</p>
psychology&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7,000.00&nbsp;&nbsp;&nbsp;&nbsp; 14.30</p>
psychology&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2,275.00&nbsp;&nbsp;&nbsp;&nbsp; 14.30</p>
psychology&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 6,000.00&nbsp;&nbsp;&nbsp;&nbsp; 14.30</p>
psychology&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2,000.00&nbsp;&nbsp;&nbsp;&nbsp; 14.30</p>
psychology&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4,000.00&nbsp;&nbsp;&nbsp;&nbsp; 14.30</p>
trad_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7,000.00&nbsp;&nbsp;&nbsp;&nbsp; 17.97</p>
trad_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4,000.00&nbsp;&nbsp;&nbsp;&nbsp; 17.97</p>
trad_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 8,000.00&nbsp;&nbsp;&nbsp;&nbsp; 17.97</p>
&nbsp;</p>
(Выбрано 17 строк)</p>
&nbsp;</p>
Здесь кажется, что условие отбора было проигнорировано, поскольку в (дополнительном) столбце аванса появились значения, которые ему не удовлетворяют. На самом деле SQL Сервер по прежнему проводит векторное агрегирование только по строкам, удовлетворящим условию в конструкции where, но в результат выводятся все значения аванса, имеющиеся в таблице, поскольку этот столбец был указан в списке выбора. Чтобы устранить лишние строки из результата, здесь нужно использовать конструкцию having, которая будет описана далее в этой же главе.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Конструкция group by и опция all</td></tr></table></div>&nbsp;</p>
Ключевое слово all (все) в конструкции group by является еще одним расширением языка Transact-SQL по сравнению с обычным SQL. Оно имеет смысл только в том случае, если содержащий его оператор выбора, содержит также конструкцию отбора where.</p>
&nbsp;</p>
Если используется опция all, то в результат запроса выводятся все группы, включая пустые, которые не содержат ни одной строки. Если эта опция отсутствует, то пустые группы не показываются в результатах оператора выбора.</p>
&nbsp;</p>
Это иллюстрируется следующим примером:</p>
&nbsp;</p>
select type, avg(advance)</p>
from titles</p>
where advance &gt; 1000 and advance &lt; 10000</p>
group by type</p>
&nbsp;</p>
type</p>
-------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ----------------------</p>
business &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5,000.00</p>
popular_comp &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;7,500.00</p>
psychology &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;4,255.00</p>
trad_cook &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;6,333.00</p>
&nbsp;</p>
(Выбрано 4 строки)</p>
&nbsp;</p>
select type, avg(advance)</p>
from titles</p>
where advance &gt; 1000 and advance &lt; 10000</p>
group by all type</p>
&nbsp;</p>
type</p>
-------------------&nbsp;&nbsp;&nbsp;&nbsp; -----------------------</p>
UNDECIDED &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;NULL</p>
business &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;5,000.00</p>
mod_cook &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;NULL</p>
popular_comp &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;7,500.00</p>
psychology &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;4,255.00</p>
trad_cook &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;6,333.00</p>
&nbsp;</p>
(Выбрано 6 строк)</p>
&nbsp;</p>
В первом операторе в результат попадают только непустые группы, содержащие книги, по которым был выплачен аванс больший $1000 и меньший $10000. Поскольку ни одна книга по современной кулинарии не удовлетворяет этому условию, то группа mod_cooking не попала в результат.</p>
&nbsp;</p>
Во втором операторе в результат попали все группы, включая группу по современнной кулинарии и группу с неопределенным значением аванса (UNDECIDED), несмотря на то, что группа mod_cooking пуста. Для пустых групп SQL Сервер выводит неопределенное значение NULL в столбце результатов вычисления агрегирующей функции (в примере это средняя величина аванса).</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Использование агрегации без группировки</td></tr></table></div>&nbsp;</p>
По определению, скалярная агрегация состоит в вычислении одного значения для всей таблицы по каждой агрегирующей функции. Еще одно расширение языка Transact-SQL состоит в том, что допускается введение дополнительных столбцов в список выбора при скалярной агрегации, подобно тому, как это допускается для векторной агрегации. Например:</p>
&nbsp;</p>
select pub_id, count(pub_id)</p>
from publishers</p>
&nbsp;</p>
pub_id</p>
-----------&nbsp;&nbsp;&nbsp;&nbsp; ----------</p>
0736 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;3</p>
0877 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;3</p>
1389 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;3</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 3 строки)</p>
&nbsp;</p>
SQL Сервер рассматривает столбец данных publishers как одну группу, поэтому агрегирующая функция применяется ко всему столбцу таблицы. Результат повторяется во всех строках результирующей таблицы, поскольку в списке выбора, кроме агрегирующей функции, есть дополнительный столбец.</p>
&nbsp;</p>
Конструкция where учитывается при скалярной агрегации также, как и при векторной. С помощью нее происходит отбор данных в указанных столбцах, к которым применяется агрегирующая функция, но она не оказывает влияния на вывод данных из дополнительных столбцов списка выбора. Например:</p>
&nbsp;</p>
select pub_id, count(pub_id)</p>
from publishers</p>
where pub_id &lt; “1000”</p>
&nbsp;</p>
pub_id</p>
-----------&nbsp;&nbsp;&nbsp; ----------</p>
0736 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2</p>
0877 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2</p>
1389 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 3 строки)</p>
&nbsp;</p>
Подобно другим дополнительным возможностям языка Transact-SQL, касающимся группировки, этой возможностью нужно пользоваться осторожно, поскольку бывает трудно понять результаты подобных запросов, особенно для больших таблиц или запросов, включающих многотабличные соединения.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Выбор Групп Данных: Конструкция having</td></tr></table></div>&nbsp;</p>
В конструкции having (имеющие) указываются условия отбора групп, подобно тому, как в конструкции where (где) указываются условия отбора строк.</p>
&nbsp;</p>
Условия отбора, задаваемые в конструкции having аналогичны условиям, задаваемым в конструкции where за одним исключением. В условиях where нельзя использовать агрегирующих функций, в то время как в конструкции having можно. Число условий в конструкции having должно быть не больше 128.</p>
&nbsp;</p>
Следующий оператор иллюстрирует использование конструкции having с агрегирующей функцией. Он группирует строки таблицы titles по типам книг, но удаляет группы, содержащие только одну книгу.</p>
&nbsp;</p>
select type</p>
from titles</p>
group by type</p>
having count(*) &gt; 1</p>
&nbsp;</p>
type</p>
-------------------</p>
business</p>
mod_cook</p>
popular_comp</p>
psychology</p>
trad_cook</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 5 строк)</p>
&nbsp;</p>
Далее приводится пример конструкции having без агрегирующей функции. В нем данные из таблицы titles группируются по типам книг и удаляются те типы, которые не начинаются с буквы “p”.</p>
&nbsp;</p>
select type</p>
from titles</p>
group by type</p>
having type like &#8216;p%&#8217;</p>
&nbsp;</p>
type</p>
-------------------</p>
popular_comp</p>
psychology</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 2 строки)</p>
&nbsp;</p>
Когда в конструкции having присутствует несколько условий, то они должны соединяться логическими операциями and (и), or (или), not (не). Например, в следующем запросе данные из таблицы titles группируются по издателям, а в результат попадают только те издатели, чей идентификационный номер больше 0800, заплатившие более $15000 общего аванса и чьи книги стоят в среднем менее $18:</p>
&nbsp;</p>
select pub_id, sum(advance), avg(price)</p>
from titles</p>
group by pub_id</p>
having sum(advance) &gt; 15000</p>
 &nbsp; &nbsp; &nbsp; &nbsp;and avg(price) &lt; 18</p>
 &nbsp; &nbsp; &nbsp; &nbsp;and pub_id &gt; “0800”</p>
&nbsp;</p>
pub_id</p>
------------&nbsp;&nbsp;&nbsp;&nbsp; -----------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------------</p>
0877 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;41,000.00 &nbsp; &nbsp; &nbsp; &nbsp;15.41</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрана 1 строка)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Взимосвязи между конструкциями having, group by и where</td></tr></table></div>&nbsp;</p>
Когда в запросе вместе присутствуют конструкции having, group by и where, то на окончательный результат влияет порядок их применения. Эти конструкции применяются в следующем порядке:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Сначала применяется конструкция where и отбираются строки, удовлетворящие условиям отбора;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Затем применяется конструкция group by и оставшиеся строки собираются в группы, каждая из которых соответствует одному значению группового выражения;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Затем к группам применяются агрегирующие функции, указанные в списке выбора и для каждой группы вычисляются итоговые значения;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Наконец, применяется конструкция having и из окончательного результата удаляются те группы, которые не удовлетворяют условиям отбора.</td></tr></table></div>&nbsp;</p>
Следующий запрос иллюстрирует использование этих конструкций в одном операторе выбора:</p>
&nbsp;</p>
select stor_id, title_id, sum(qty)</p>
from salesdetail</p>
where title_id like “PS%”</p>
group by stor_id, title_id</p>
having sum(qty) &gt; 200</p>
&nbsp;</p>
stor_id&nbsp; title_id</p>
-------&nbsp;&nbsp;&nbsp; -------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----------</p>
5023&nbsp;&nbsp;&nbsp;&nbsp; PS1372&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 375</p>
5023&nbsp;&nbsp;&nbsp;&nbsp; PS2091&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1845</p>
5023&nbsp;&nbsp;&nbsp;&nbsp; PS3333&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3437</p>
5023&nbsp;&nbsp;&nbsp;&nbsp; PS7777&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2206</p>
6380&nbsp;&nbsp;&nbsp;&nbsp; PS7777&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 500</p>
7067&nbsp;&nbsp;&nbsp;&nbsp; PS3333&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 345</p>
7067&nbsp;&nbsp;&nbsp;&nbsp; PS7777&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 250</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 7 строк)</p>
&nbsp;</p>
В этом запросе конструкция where отбирает книги, номер которых начинается с префикса “PS” (книги по психологии), затем конструкция group by группирует их по значениям данных в столбцах stor_id и title_id. Затем вычисляется общая сумма проданных книг по каждой группе и из окончательного результата с помощью конструкции having удаляются те группы, в которых объем продаж оказался меньше 200 книг.</p>
&nbsp;</p>
Во всех вышеприведенных примерах использование конструкции having соответствует стандарту SQL, который утверждает, что названия столбцов, расположенные в конструкции having, должны присутствовать либо в списке выбора, либо в конструкции group by. Однако в языке Transact-SQL разрешается использовать в конструкции having дополнительные столбцы.</p>
&nbsp;</p>
Следующий пример иллюстрирует это расширение. В нем определяется средняя цена книги каждого вида, но из результата удаляются те виды книг, для которых общий объем продаж оказался меньше чем 10000, хотя функция суммы (sum) не появляется в результате.</p>
&nbsp;</p>
select type, avg(price)</p>
from titles</p>
group by type</p>
having sum(total_sales) &gt; 10000</p>
&nbsp;</p>
type</p>
-----------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------</p>
business &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 13.73</p>
mod_cook &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;11.49</p>
popular_comp &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;21.48</p>
trad_cook &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;15.96</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 4 строки)</p>
&nbsp;</p>
Это расширение равносильно тому, что дополнительный столбец или выражение как-бы является членом списка выбора, который просто не появляется в результате. Если в конструкции having дополнительный столбец задается без агрегирующей функции, то результат будет похож на ранее описанный в этой главе, когда “дополнительный” столбец явно указывался в списке выбора. Например:</p>
&nbsp;</p>
select type, avg(price)</p>
from titles</p>
group by type</p>
having total_sales &gt; 4000</p>
&nbsp;</p>
type</p>
-----------------------&nbsp;&nbsp; ------------</p>
business &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 13.73</p>
business &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 13.73</p>
business &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 13.73</p>
mod_cook &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;11.49</p>
popular_comp &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;21.48</p>
popular_comp &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;21.48</p>
psychology &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;13.50</p>
trad_cook &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;15.96</p>
trad_cook &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;15.96</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 9 строк)</p>
&nbsp;</p>
Однако, теперь дополнительный столбец (в данном случае total_sales) является невидимым и не появляется в результате. Поэтому число одинаковых строк по каждому виду книг будет зависеть от объемов продаж отдельных книг этого вида. Из результатов запроса видно, что имеются 3 книги по бизнесу, 1 по современной кулинарии, 2 по компьютерам, 1 по психологии и 2 по традиционной кулинарии, объем продаж которых превысил 4000.</p>
&nbsp;</p>
Как было отмечено ранее, способ которым SQL Сервер обрабатывает дополнительный столбец создает впечатление, что при выводе результатов игнорируется условие, указанное в конструкции where. Чтобы результаты, показываемые в дополнительном столбце, соответствовали условию из конструкции where, нужно повторить это условие в конструкции having. Например:</p>
&nbsp;</p>
select type, advance, avg(price)</p>
from titles</p>
where advance &gt; 5000</p>
group by type</p>
having advance &gt; 5000</p>
&nbsp;</p>
type &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;advance</p>
----------------------- &nbsp; &nbsp; &nbsp; &nbsp;------------- &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;------------</p>
business &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 10,125.00 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2.99</p>
mod_cook &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;15,000.00 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2.99</p>
popular_comp &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 7,000.00 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;21.48</p>
popular_comp &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 8,000.00 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;21.48</p>
psychology &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 7,000.00 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;14.30</p>
psychology &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 6,000.00 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;14.30</p>
trad_cook &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 7,000.00 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;17.97</p>
trad_cook &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 8,000.00 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;17.97</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 1 строку)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Использование конструкции having без группировки</td></tr></table></div>&nbsp;</p>
Запрос, содержащий конструкцию having, обычно содержит также и конструкцию group by. Если последняя отсутствует, то все строки, удовлетворяющие условию в конструкции where, собираются в одну группу.</p>
&nbsp;</p>
Поскольку нет группировки, то конструкции having и where не могут выполняться независимо друг от друга. В этом случае конструкция having выполняет роль аналогичную конструкции where, поскольку с ее помощью проводится дополнительный отбор строк в уже образованной группе. Отличие между ними состоит в том, что в конструкции having, можно использовать агрегирующие функции.</p>
&nbsp;</p>
В следующем примере конструкция having используется для дополнительного отбора тех книг из таблицы titles, у которых цена превосходит среднюю цену книг, по которым был выплачен аванс меньший $4000:</p>
&nbsp;</p>
select title_id, advance, price</p>
from titles</p>
where advance &lt; 4000</p>
having price &gt; avg(price)</p>
&nbsp;</p>
title_id&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; advance&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; price</p>
-------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------------&nbsp;&nbsp; ---------</p>
BU1032&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5,000.00&nbsp;&nbsp;&nbsp;&nbsp; 19.99</p>
BU7832&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5,000.00&nbsp;&nbsp;&nbsp;&nbsp; 19.99</p>
MC2222&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0.00&nbsp;&nbsp;&nbsp;&nbsp; 19.99</p>
PC1035&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7,000.00&nbsp;&nbsp;&nbsp;&nbsp; 22.95</p>
PC8888&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 8,000.00&nbsp;&nbsp;&nbsp;&nbsp; 20.00</p>
PS1372&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7,000.00&nbsp;&nbsp;&nbsp;&nbsp; 21.59</p>
PS3333&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2,000.00&nbsp;&nbsp;&nbsp;&nbsp; 19.99</p>
TC3218&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7,000.00&nbsp;&nbsp;&nbsp;&nbsp; 20.95</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 8 строк)</p>
&nbsp;</p>
В языке Transact-SQL можно также использовать конструкцию having без группировки в запросах, содержащих агрегирующие функции в списке выбора. В этом случае агрегация будет применяться ко всей таблице (скалярная агрегация), поскольку вся таблица будет рассматриваться как одна группа.</p>
&nbsp;</p>
В следующем примере сначала вычисляется агрегирующуя функция для всей таблицы, поскольку нет группировки, а затем конструкция having удаляет некоторые строки из окончательного результата.</p>
&nbsp;</p>
select pub_id, count(pub_id)</p>
from publishers</p>
having pub_id &lt; “1000”</p>
&nbsp;</p>
pub_id</p>
-------------&nbsp; ---------</p>
0736 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;3</p>
0877 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;3</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 1 строку)</p>
&nbsp;</p>
Дополнительную информацию об использовании конструкции having без группировки можно получить Справочном руководстве SQL Сервера.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Сортировка результатов запроса: конструкция order by</td></tr></table></div>&nbsp;</p>
Конструкция order by (упорядочить) позволяет расположить (рассортировать) результаты запроса в соответствии с содержимым выделенных столбцов. Выделять для сортировки можно не более 16 столбцов. Упорядочение по каждому столбцу должно быть либо возрастающим (asc), либо убывающим (desc). По умолчанию предполагается возрастающее упорядочение. В следующем запросе результаты упорядочиваются по столбцу pub_id:</p>
&nbsp;</p>
select pub_id, type, title_id</p>
from titles</p>
order by pub_id</p>
&nbsp;</p>
pub_id&nbsp; type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; title_id</p>
------&nbsp;&nbsp;&nbsp;&nbsp; ---------------&nbsp;&nbsp;&nbsp;&nbsp; ------------</p>
0736&nbsp;&nbsp;&nbsp; business&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BU2075</p>
0736&nbsp;&nbsp;&nbsp; psychology&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PS2091</p>
0736&nbsp;&nbsp;&nbsp; psychology&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PS2106</p>
0736&nbsp;&nbsp;&nbsp; psychology&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PS3333</p>
0736&nbsp;&nbsp;&nbsp; psychology&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PS7777</p>
0877&nbsp;&nbsp;&nbsp; UNDECIDED&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MC3026</p>
0877&nbsp;&nbsp;&nbsp; mod_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MC2222</p>
0877&nbsp;&nbsp;&nbsp; mod_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MC3021</p>
0877&nbsp;&nbsp;&nbsp; psychology&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PS1372</p>
0877&nbsp;&nbsp;&nbsp; trad_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TC3218</p>
0877&nbsp;&nbsp;&nbsp; trad_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TC4203</p>
0877&nbsp;&nbsp;&nbsp; trad_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TC7777</p>
1389&nbsp;&nbsp;&nbsp; business&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BU1032</p>
1389&nbsp;&nbsp;&nbsp; business&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BU1111</p>
1389&nbsp;&nbsp;&nbsp; business&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BU7832</p>
1389&nbsp;&nbsp;&nbsp; popular_comp&nbsp;&nbsp; PC1035</p>
1389&nbsp;&nbsp;&nbsp; popular_comp&nbsp;&nbsp; PC8888</p>
1389&nbsp;&nbsp;&nbsp; popular_comp&nbsp;&nbsp; PC9999</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 1 строку)</p>
&nbsp;</p>
Если в конструкции order by указано несколько столбцов, то проводится комбинированная сортировка. Следующий оператор упорядочивает строки из таблицы titles сначала в убывающем порядке по издателям, затем по каждому издателю книги располагаются в возрастающем порядке по типу и, наконец, книги имеющие одного издателя и один тип располагаются по номерам (также по умолчанию в возрастающем порядке). Неопределенные значения в любой группе указываются первыми.</p>
&nbsp;</p>
select pub_id, type, title_id</p>
from titles</p>
order by pub_id desc, type, title_id</p>
&nbsp;</p>
pub_id&nbsp;&nbsp;&nbsp; type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; title_id</p>
---------&nbsp;&nbsp; -------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------</p>
1389&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; business &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BU1032</p>
1389&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; business &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BU1111</p>
1389&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; business &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BU7832</p>
1389&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; popular_comp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PC1035</p>
1389&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; popular_comp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;PC8888</p>
1389&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; popular_comp &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PC9999</p>
0877&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; UNDECIDED &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;MC3026</p>
0877&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; mod_cook &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;MC2222</p>
0877&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; mod_cook &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;MC3021</p>
0877&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; psychology &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;PS1372</p>
0877&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; trad_cook &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;TC3218</p>
0877&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; trad_cook &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;TC4203</p>
0877&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; trad_cook &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;TC7777</p>
0736&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; business &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BU2075</p>
0736&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; psychology &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;PS2091</p>
0736&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; psychology &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;PS2106</p>
0736&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; psychology &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;PS3333</p>
0736&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; psychology &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;PS7777</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 18 строк)</p>
&nbsp;</p>
Для сортировки вместо названий столбцов можно использовать их порядковые номера, по которым они располагаются в списке выбора. При этом названия столбцов и их номера можно чередовать друг с другом. Оба следующих оператора выдают те же результаты, что и предыдущий оператор.</p>
&nbsp;</p>
select pub_id, type, title_id</p>
from titles</p>
order by 1 desc, 2, 3</p>
&nbsp;</p>
select pub_id, type, title_id</p>
from titles</p>
order by 1 desc, type, 3</p>
&nbsp;</p>
В большинстве версий SQL требуется, чтобы названия столбцов в конструкции order by брались из списка выбора. В языке Transact-SQL этого не требуется. Можно сортировать результаты предыдущего запроса по столбцу title (заголовок), хотя этого столбца нет в списке выбора.</p>
&nbsp;</p>
Замечание: Нельзя проводить сортировку по столбцам типа text (текст) и image (графика).</p>
&nbsp;</p>
В конструкции order by нельзя также использовать подзапросы, агрегирующие функции и выражения, содержащие константы и переменные.</p>
&nbsp;</p>
Результаты упорядочения по данным различного типа зависят от процедур сортировки, установленных на SQL Сервере. Обычно это процедуры двоичной и словарной сортировки, в которой не учитывается регистр символов. Системная процедура SP_HELPSORT позволяет увидеть установленный на Сервере порядок сортировки. Детали можно посмотреть в разделе order by в Справочном руководстве SQL Сервера.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Конструкции order by и group by</td></tr></table></div>&nbsp;</p>
Конструкцию order by можно использовать для сортировки результатов группировки.</p>
&nbsp;</p>
Напомним, что конструкцию order by нужно использовать после конструкции group by. В следующем примере находится средняя цена книг каждого типа, а затем результаты располагаются в соответствии с этими средними ценами:</p>
&nbsp;</p>
select type, avg(price)</p>
from titles</p>
group by type</p>
order by avg(price)</p>
&nbsp;</p>
type</p>
-------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----------------</p>
UNDECIDED &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;NULL</p>
mod_cook &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;11.49</p>
psychology &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;13.50</p>
business &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 13.73</p>
trad_cook &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;15.96</p>
popular_comp &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;21.48</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 6 строк)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Вычисление итоговых значений по группам: конструкция compute</td></tr></table></div>&nbsp;</p>
Конструкция compute (вычислить) является еще одним расширением языка Transact-SQL по отношению к SQL. Она используется вместе с агрегирующими функциями для вывода отчетов, в которых отражаются итоговые значения по отдельным столбцам данных. Такие отчеты обычно подготавливаются с помощью генератора отчетов и называются отчетами с раздельными итогами (control-break), поскольку итоговые значения появляются в них между группами данных, как бы разделяя их на части.</p>
&nbsp;</p>
Итоговые значения появляются в результатах запроса в виде дополнительных строк, в противоположность результатам векторного агрегирования, определяемых конструкцией group by, которые образуют новые столбцы.</p>
&nbsp;</p>
Конструкция compute позволяет увидеть конкретные и итоговые величины в результатах одного оператора выбора. Итоговые значение можно вычислять по группам и для каждой группы можно вычислить несколько агрегирующих функций.</p>
&nbsp;</p>
Синтаксис конструкции compute имеет следующий вид:</p>
&nbsp;</p>
compute агрегирующая_функция(название_столбца)</p>
 &nbsp; &nbsp; &nbsp; &nbsp;[, агрегирующая_функция(название_столбца) ] ...</p>
 &nbsp; &nbsp; &nbsp; &nbsp;[by название_столбца [, название_столбца] ...]</p>
В конструкции compute можно использовать агрегирующие функции sum, avg, min, max и count. Функции sum и avg используются только с числовыми типами данных. В отличии от конструкции order by здесь нельзя использовать порядковые номера столбцов списка выбора вместо названия столбцов.</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Замечание: Нельзя использовать столбцы типа text (текст) и image (графика) в&nbsp; конструкции compute.</p>
&nbsp;</p>
Далее показаны два запроса и их результаты. В первом из них проводится обычная группировка с вычислением агрегирующих функций. Во втором используется конструкция compute вместе с теми же агрегирующими функциями. Обратите внимание на совершенно различные получаемые результаты.</p>
&nbsp;</p>
select type, sum(price), sum(advance)</p>
from titles</p>
group by type</p>
&nbsp;</p>
type</p>
-------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----------------&nbsp;&nbsp;&nbsp; --------------------</p>
UNDECIDED &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;NULL &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;NULL</p>
business &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 54.92 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;25,125.00</p>
mod_cook &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;22.98 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;15,000.00</p>
popular_comp &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;42.95 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;15,000.00</p>
psychology &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;67.52 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;21,275.00</p>
trad_cook &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;47.89 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;19,000.00</p>
&nbsp;</p>
(Выбрано 6 строк)</p>
&nbsp;</p>
select type, price, advance</p>
from titles</p>
order by type</p>
compute sum(price), sum(advance) by type</p>
&nbsp;</p>
type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; price&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; advance</p>
-------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ---------------&nbsp;&nbsp;&nbsp;&nbsp; --------------</p>
UNDECIDED&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------------&nbsp;&nbsp;&nbsp; -------------</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
&nbsp;</p>
type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; price&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; advance</p>
-------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------------&nbsp;&nbsp;&nbsp; --------------</p>
business&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2.99&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 10,125.00</p>
business&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 11.95&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5,000.00</p>
business&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 19.99&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5,000.00</p>
business&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 19.99&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5,000.00</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------------&nbsp;&nbsp;&nbsp; -------------</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 54.92&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 25,125.00</p>
&nbsp;</p>
type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; price&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; advance</p>
-------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ---------------</p>
mod_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2.99&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 15,000.00</p>
mod_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 19.99&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0.00</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 22.98&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 15,000.00</p>
&nbsp;</p>
type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; price&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; advance</p>
-------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------------</p>
popular_comp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
popular_comp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 20.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 8,000.00</p>
popular_comp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 22.95&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7,000.00</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------------</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 42.95&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 15,000.00</p>
&nbsp;</p>
type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; price&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; advance</p>
-------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------------</p>
psychology&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 6,000.00</p>
psychology&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7.99&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4,000.00</p>
psychology&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 10.95&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2,275.00</p>
psychology&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 19.99&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2,000.00</p>
psychology&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 21.59&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7,000.00</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------------</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 67.52&nbsp;&nbsp;&nbsp;&nbsp; 21,275.00</p>
&nbsp;</p>
type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; price&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; advance</p>
-------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------------</p>
trad_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 11.95&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4,000.00</p>
trad_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 14.99&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 8,000.00</p>
trad_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 20.95&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7,000.00</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------------</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 276px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">47.89</td><td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 19,000.00</td></tr></table></div>&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 24 строки)</p>
Итоговые значения выводятся в отдельных строках, поэтому после вывода результатов SQL Сервер выдает информационное сообщение “Выведено 24 строки”.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Агрегирующие функции и конструкция compute</td></tr></table></div>&nbsp;</p>
В следующей таблице перечислены агрегирующие функции, которые можно использовать в конструкции compute:</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td>Функция</p>
</td>
<td>Результат</p>
</td>
</tr>
<tr>
<td>sum</p>
</td>
<td>Сумма значений выражения</p>
</td>
</tr>
<tr>
<td>avg</p>
</td>
<td>Среднее значение выражения</p>
</td>
</tr>
<tr>
<td>max</p>
</td>
<td>Максимальное значение выражения</p>
</td>
</tr>
<tr>
<td>min</p>
</td>
<td>Минимальное значение выражения</p>
</td>
</tr>
<tr>
<td>count</p>
</td>
<td>Число выбранных строк
</td>
</tr>
</table>
&nbsp;</p>
Таблица 3-2: Агрегирующие функции, используемые в конструкции compute</p>
&nbsp;</p>
Из этой таблицы видно, что здесь можно использовать те же агрегирующие функции, что и в конструкции group by за исключением функции count(*). Чтобы найти итоговое значение, получаемое с помощью конструкции group by и и функции count(*), следует использовать конструкцию compute без приставки by.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Правила для конструкции compute</td></tr></table></div>&nbsp;</p>
В конструкции compute нужно придерживаться следующих правил:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>При агрегации нельзя использовать ключевые слова в качестве названий&nbsp; столбцов;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Названия столбцов в конструкции compute должны присутствовать в списке выбора;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Если в операторе выбора есть конструкция compute, то в нем нельзя использовать конструкцию into (в), поскольку в этом случае выводимые строки нельзя вставлять в таблицу;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Если в конструкции compute используется ключевое слово by, то в этом же операторе должна присутствовать конструкция order by. Кроме того, список названий столбцов, следующих после приставки by, должен быть подсписком списка конструкции order by, т.е. начинаться с того же первого столбца и следовать в том же порядке слева направо без пропусков, кончая некоторым промежуточным или последним столбцом;</td></tr></table></div> &nbsp; &nbsp; &nbsp; &nbsp;Например, пусть конструкция order by имеет вид:</p>
 &nbsp; &nbsp; &nbsp; &nbsp;order by a,b,c</p>
 &nbsp; &nbsp; &nbsp; &nbsp;Тогда для конструкции compute допустимо одно из следующих предложений:</p>
&nbsp;</p>
 &nbsp; &nbsp; &nbsp; &nbsp;compute агрегирующая_функция(название_столбца) by a,b,c</p>
 &nbsp; &nbsp; &nbsp; &nbsp;compute агрегирующая_функция(название_столбца) by a,b</p>
 &nbsp; &nbsp; &nbsp; &nbsp;compute агрегирующая_функция(название_столбца) by a</p>
&nbsp;</p>
 &nbsp; &nbsp; &nbsp; &nbsp;В этом случае конструкция compute не может быть ни одним из следующих  &nbsp; &nbsp; &nbsp; &nbsp;предложений:</p>
&nbsp;</p>
 &nbsp; &nbsp; &nbsp; &nbsp;compute агрегирующая_функция(название_столбца) by b,c</p>
 &nbsp; &nbsp; &nbsp; &nbsp;compute агрегирующая_функция(название_столбца) by a,c</p>
 &nbsp; &nbsp; &nbsp; &nbsp;compute агрегирующая_функция(название_столбца) by c</p>
&nbsp;</p>
 &nbsp; &nbsp; &nbsp; &nbsp;В конструкции order by нужно использовать название столбца или выражение,  &nbsp; &nbsp; &nbsp; &nbsp;следовательно нельзя сортировать по заголовкам столбцов (alias).</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 104px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Ключевое слово compute можно использовать без пристаки by для подсчета общей суммы, общего числа, и т.д. В этом случае не обязательно включать конструкцию order by. Использование конструкции compute без приставки by рассматривается далее.</td></tr></table></div>&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Указание нескольких столбцов в конструкции compute by</td></tr></table></div>&nbsp;</p>
Если составить список из нескольких столбцов после ключевого слова by, то произойдет разбиение групп на более мелкие подгруппы и агрегирующие функции будут вычисляться для всех уровней группировки. Например, в следующем запросе вычисляется сумма цен книг по психологии по каждому издателю:</p>
&nbsp;</p>
select type, pub_id, price</p>
from titles</p>
where type = "psychology"</p>
order by type, pub_id, price</p>
compute sum(price) by type, pub_id</p>
&nbsp;</p>
type &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;pub_id&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; price</p>
-----------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ---------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------------</p>
psychology&nbsp;&nbsp;&nbsp; 0736&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7.00</p>
psychology&nbsp;&nbsp;&nbsp; 0736&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7.99</p>
psychology&nbsp;&nbsp;&nbsp; 0736&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 10.95</p>
psychology&nbsp;&nbsp;&nbsp; 0736&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 19.99</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------------</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 45.93</p>
&nbsp;</p>
type &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;pub_id&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; price</p>
 ----------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------------</p>
 psychology&nbsp;&nbsp;&nbsp; 0877&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 21.59</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------------</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 21.59</p>
&nbsp;</p>
(Выбрано 7 строк)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Использование нескольких конструкций compute</td></tr></table></div>&nbsp;</p>
Можно проводить агрегацию разных уровней в одном операторе, используя несколько конструкций compute. Следующий запрос очень похож на предыдущий. Отличие состоит в том, что здесь вычисляется также общая сумма цен всех книг по психологии, а не только суммы по каждому издателю:</p>
&nbsp;</p>
select type, pub_id, price</p>
from titles</p>
where type = "psychology"</p>
order by type, pub_id, price</p>
compute sum(price) by type, pub_id</p>
compute sum(price) by type</p>
&nbsp;</p>
type &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;pub_id&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; price</p>
-----------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ---------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------------</p>
psychology&nbsp;&nbsp;&nbsp; 0736&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7.00</p>
psychology&nbsp;&nbsp;&nbsp; 0736&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7.99</p>
psychology&nbsp;&nbsp;&nbsp; 0736&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 10.95</p>
psychology&nbsp;&nbsp;&nbsp; 0736&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 19.99</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------------</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 45.93</p>
&nbsp;</p>
type &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;pub_id&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; price</p>
 ----------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------------</p>
 psychology&nbsp;&nbsp;&nbsp; 0877&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 21.59</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------------</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 21.59</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------------</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 67.52</p>
&nbsp;</p>
(Выбрано 8 строк)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Подведение итогов по нескольким столбцам</td></tr></table></div>&nbsp;</p>
В одной конструкции compute можно применить одну и ту же агрегирующую функцию к нескольким столбцам. В следующем запросе вычисляется как сумма цен, так и сумма авансов для книг по кулинарии:</p>
&nbsp;</p>
select type, price, advance</p>
from titles</p>
where type like "%cook"</p>
order by type</p>
compute sum(price), sum(advance) by type</p>
&nbsp;</p>
type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; price&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; advance</p>
---------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----------&nbsp;&nbsp;&nbsp; ---------------</p>
mod_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2.99&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 15,000.00</p>
mod_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 19.99&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0.00</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----------&nbsp;&nbsp;&nbsp; ---------------</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 22.98&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 15,000.00</p>
type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; price&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; advance</p>
---------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----------&nbsp;&nbsp;&nbsp; ---------------</p>
trad_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 11.95&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4,000.00</p>
trad_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 14.99&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 8,000.00</p>
trad_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 20.95&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7,000.00</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----------&nbsp;&nbsp;&nbsp;&nbsp; ---------------</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 47.89&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 19,000.00</p>
&nbsp;</p>
(Выбрано 7 строк)</p>
&nbsp;</p>
Напомним, что столбцы, к которым применяется агрегирующуя функция должны быть указаны также в списке выбора.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Использование различных агрегирующих функций в одной конструкции compute</td></tr></table></div>&nbsp;</p>
Можно использовать различные агрегирующие функции в одной конструкции compute.</p>
&nbsp;</p>
select type, pub_id, price</p>
from titles</p>
where type like "%cook"</p>
order by type, pub_id</p>
compute sum(price), max(pub_id) by type</p>
&nbsp;</p>
type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; pub_id&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; price</p>
-----------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------------</p>
mod_cook&nbsp;&nbsp;&nbsp; 0877&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2.99</p>
mod_cook&nbsp;&nbsp;&nbsp; 0877&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 19.99</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------------</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 22.98</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; max</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0877</p>
type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; pub_id&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; price</p>
-----------&nbsp;&nbsp;&nbsp;&nbsp; -------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------------</p>
trad_cook&nbsp;&nbsp; 0877&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 11.95</p>
trad_cook&nbsp;&nbsp; 0877&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 14.99</p>
trad_cook&nbsp;&nbsp; 0877&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 20.95</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------------</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 47.89</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; max</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0877</p>
&nbsp;</p>
(Выбрано 7 строк)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Общие итоговые значения: конструкция compute без приставки by</td></tr></table></div>&nbsp;</p>
Ключевое слово compute можно использовать без приставки by. В этом случае будут выдаваться общие итоговые значения, вычисленные по всем группам, т.е. общая сумма, общее число и т.д.</p>
&nbsp;</p>
С помощью следующего оператора вычисляются общие суммы цен и авансов для всех типов книг, цена которых превышает $20:</p>
&nbsp;</p>
select type, price, advance</p>
from titles</p>
where price &gt; $20</p>
compute sum(price), sum(advance)</p>
&nbsp;</p>
type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; price&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; advance</p>
------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ---------&nbsp;&nbsp;&nbsp; -------------</p>
popular_comp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 22.95&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7,000.00</p>
psychology&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 21.59&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7,000.00</p>
trad_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 20.95&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7,000.00</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; =====&nbsp;&nbsp; ======&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 65.49&nbsp;&nbsp;&nbsp;&nbsp; 21,000.00</p>
&nbsp;</p>
(Выбрано 4 строки)</p>
&nbsp;</p>
Можно также использовать конструкцию compute с приставкой by и без этой приставки в одном и том же запросе. Например, в следующем запросе сначала вычисляются суммы цен и авансов по типам книг, а затем вычисляются общие суммы цен и авансов, взятые по всем типам книг.</p>
&nbsp;</p>
select type, price, advance</p>
from titles</p>
where type like "%cook"</p>
order by type</p>
compute sum(price), sum(advance) by type</p>
compute sum(price), sum(advance)</p>
&nbsp;</p>
type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; price&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; advance</p>
-----------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----------------&nbsp;&nbsp;&nbsp; ------------</p>
mod_ cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2.99&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 15,000.00</p>
mod_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 19.99&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0.00</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----------------&nbsp;&nbsp;&nbsp; ------------</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 22.98&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 15,000.00</p>
&nbsp;</p>
type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; price&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; advance</p>
-----------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----------------&nbsp; ------------</p>
trad_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 11.95&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4,000.00</p>
trad_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 14.99&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 8,000.00</p>
trad_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 20.95&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7,000.00</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ---------------&nbsp;&nbsp;&nbsp; ------------</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 47.89&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 19,000.00</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sum</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; =======&nbsp; ========</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 70.87&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 34,000.00</p>
&nbsp;</p>
(Выбрано 8 строк)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Объединение запросов: Команда union</td></tr></table></div>&nbsp;</p>
Команда union (объединить) языка Transact-SQL позволяет объединить результаты нескольких запросов в одно результирующее множество. Этот оператор имеет следующий синтаксис:</p>
&nbsp;</p>
подзапрос1</p>
[union [all] подзапросN] ...</p>
[конструкция order by]</p>
[конструкция compute]</p>
&nbsp;</p>
где подзапрос1 имеет вид:</p>
&nbsp;</p>
select список_выбора</p>
[конструкция into]</p>
[конструкция from]</p>
[конструкция where]</p>
[конструкция group by]</p>
[конструкция having]</p>
&nbsp;</p>
а подзапросN  имеет следующий вид:</p>
&nbsp;</p>
select список_выбора</p>
[конструкция from]</p>
[конструкция where]</p>
[конструкция group by]</p>
[конструкция having]</p>
&nbsp;</p>
Например, предположим, что имеются две следующих таблицы T1 и T2:</p>
&nbsp;</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Table T1</p>
</td>
<td>
</td>
<td>
</td>
<td><p>Table T2</p>
</td>
<td>
</td>
</tr>
<tr>
<td><p>a</p>
<p>char(4)</p>
</td>
<td><p>b</p>
<p>int</p>
</td>
<td>
</td>
<td><p>a</p>
<p>char(4)</p>
</td>
<td><p>b</p>
<p>int</p>
</td>
</tr>
<tr>
<td><p>abc</p>
<p>def</p>
<p>ghi</p>
</td>
<td><p>1</p>
<p>2</p>
<p>3</p>
</td>
<td>
</td>
<td><p>ghi</p>
<p>jkl</p>
<p>mno</p>
</td>
<td><p>3</p>
<p>4</p>
<p>5
</td>
</tr>
</table>
&nbsp;</p>
Рис. 3.1.</p>
&nbsp;</p>
В следующем запросе строится объединение этих двух таблиц:</p>
&nbsp;</p>
select * from T1</p>
union</p>
select * from T2</p>
&nbsp;</p>
Результаты этого запроса показаны в следующей таблице:</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Table</p>
</td>
<td>
</td>
<td>
</td>
</tr>
<tr>
<td><p>a</p>
<p>char(4)</p>
</td>
<td><p>b</p>
<p>int</p>
</td>
<td>
</td>
</tr>
<tr>
<td><p>abc</p>
<p>def</p>
<p>ghi</p>
<p>jkl</p>
<p>mno</p>
</td>
<td><p>1</p>
<p>2</p>
<p>3</p>
<p>4</p>
<p>5</p>
</td>
<td><p>&nbsp;
</td>
</tr>
</table>
&nbsp;</p>
Заметим, что по умолчанию команда union удаляет дублирующиеся строки из результатов. Если указывается опция all (все), то в результат включаются все строки, в том числе и&nbsp; дублирующиеся. Заметим также, что названия столбцов для результирующей таблицы берутся из таблицы T1. В оператор языка Transact-SQL можно включать любое число команд union. Например,</p>
&nbsp;</p>
x&nbsp; union&nbsp; y&nbsp; union&nbsp; z</p>
&nbsp;</p>
По умолчанию SQL-Сервер обрабатывает команды union слева направо. Необходимо использовать скобки, чтобы указать другой порядок объединения. Например, следующие выражения:</p>
&nbsp;</p>
x&nbsp; union&nbsp; all (y&nbsp; union&nbsp; z)</p>
&nbsp;</p>
и</p>
&nbsp;</p>
(x&nbsp; union&nbsp; all y)&nbsp; union&nbsp; z</p>
&nbsp;</p>
не являются эквивалентными. В первом случае, дублирующиеся строки в таблицах y и z будут удалены в процессе объединения, а затем произойдет объединение x с результирующей таблицей, в которой дублирующиеся строки будут сохранены. Во втором случае, сначала будут объединены таблицы x и y с сохранением дублирующихся строк, а затем результирующее множество будет объединено с z без дублирования, поэтому в этом случае опция all не окажет влияния на окончательный результат.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Правила для запросов с командой union</td></tr></table></div>&nbsp;</p>
Следует руководствоваться следующими правилами при использовании операторов с union:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Списки выбора в операторе union должны содержать одинаковое число выражений (таких как названия столбцов, арифметические выражения и агрегирующие функции). Следующий оператор является неправильным, поскольку первый список выбора длиннее второго:</td></tr></table></div>&nbsp;</p>
 &nbsp; &nbsp; &nbsp; &nbsp;select stor_id, date, ord_num from stores</p>
 &nbsp; &nbsp; &nbsp; &nbsp;union</p>
 &nbsp; &nbsp; &nbsp; &nbsp;select stor_id, ord_num from stores_east</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Соответсвующие столбцы во всех таблицах должны быть однотипными, или должна иметься возможность неявного преобразования двух типов друг к другу, или должно быть явно указано преобразование типов. Например, объединение невозможно между столбцом типа char (символьный) и столбцом одного из числовых типов int (целый), если не указано явное преобразование типов. Однако, объединение возможно между столбцом типа money (деньги) и столбцом числового типа int. Более детальную информацию о преобразовании типов и операторе union можно получить в разделе “Функции преобразования типов” Справочного руководства SQL Сервера.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Соответствующие столбцы в отдельных запросах оператора union должны следовать в одинаковом порядке, поскольку оператор union соединяет данные из столбцов именно в том порядке, в каком они указаны в отдельных запросах. Например, предположим, что у нас имеется две следующих таблицы T3 и T4:</td></tr></table></div>&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Table T3</p>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td><p>Table T4</p>
</td>
<td>
</td>
</tr>
<tr>
<td><p>a</p>
<p>int</p>
</td>
<td><p>b</p>
<p>char(4)</p>
</td>
<td><p>c</p>
<p>char(4)</p>
</td>
<td>
</td>
<td><p>a</p>
<p>char(4)</p>
</td>
<td><p>b</p>
<p>int</p>
</td>
</tr>
<tr>
<td><p>1</p>
<p>2</p>
<p>3</p>
</td>
<td><p>abc</p>
<p>def</p>
<p>ghi</p>
</td>
<td><p>jkl</p>
<p>mno</p>
<p>pqr</p>
</td>
<td>
</td>
<td><p>abc</p>
<p>def</p>
<p>ghi</p>
</td>
<td><p>1</p>
<p>2</p>
<p>3
</td>
</tr>
</table>
&nbsp;</p>
 &nbsp; &nbsp; &nbsp; &nbsp;Рис. 3.2.</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Тогда запрос:</p>
&nbsp;</p>
 &nbsp; &nbsp; &nbsp; &nbsp;select a, b from T3</p>
 &nbsp; &nbsp; &nbsp; &nbsp;union</p>
 &nbsp; &nbsp; &nbsp; &nbsp;select b, a from T4</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; приведет к следующему результату:</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>a</p>
</td>
<td><p>b</p>
</td>
</tr>
<tr>
<td><p>1</p>
<p>2</p>
<p>3</p>
</td>
<td><p>abc</p>
<p>def</p>
<p>ghi
</td>
</tr>
</table>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; В то же время следующий запрос:</p>
&nbsp;</p>
 &nbsp; &nbsp; &nbsp; &nbsp;select a, b from T3</p>
 &nbsp; &nbsp; &nbsp; &nbsp;union</p>
 &nbsp; &nbsp; &nbsp; &nbsp;select a, b from T4</p>
&nbsp;</p>
вызовет сообщение об ошибке, поскольку соответствующие столбцы имеют различный тип. Когда в операторе union объединяются данные различных, но совместимых типов, таких как float (плавающий) и int (целый), то они преобразуются к типу имеющему наибольшую точность.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Названия столбцов в таблице, полученной после выполнения команды объединения, берутся из первого подзапроса оператора union. Следовательно, если необходимо переименовать столбец объединенной таблицы, то это нужно сделать в первом подзапросе. Кроме того, если необходимо использовать новое название столбца в объединенной таблице, например в конструкции order by, то новое название должно быть введено в первом операторе выбора. Например, следующий запрос является правильным:</td></tr></table></div>&nbsp;</p>
 &nbsp; &nbsp; &nbsp; &nbsp;select Cities = city from stores</p>
 &nbsp; &nbsp; &nbsp; &nbsp;union</p>
 &nbsp; &nbsp; &nbsp; &nbsp;select city from authors</p>
 &nbsp; &nbsp; &nbsp; &nbsp;order by Cities</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Использование union с другими командами языка Transact-SQL</td></tr></table></div>&nbsp;</p>
При использовании оператора union с другими командами языка Transact-SQL следует руководствоваться следующими правилами:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Первый подзапрос в операторе union может содержать конструкцию into (в), которая создает таблицу, содержащую результирующее множество данных. Например, следующий оператор создает таблицу под названием results, которая является объединением таблиц publishers, stores и salesdetail:</td></tr></table></div> &nbsp; &nbsp; &nbsp; &nbsp;</p>
 &nbsp; &nbsp; &nbsp; &nbsp;select pub_id, pub_name, city into results from publishers</p>
 &nbsp; &nbsp; &nbsp; &nbsp;union</p>
 &nbsp; &nbsp; &nbsp; &nbsp;select stor_id, store_name, city from stores</p>
 &nbsp; &nbsp; &nbsp; &nbsp;union</p>
 &nbsp; &nbsp; &nbsp; &nbsp;select stor_id, title_id, ord_num from salesdetail</p>
&nbsp;</p>
Конструкция into может использоваться только в первом подзапросе. Если она расположена в другом месте, то появится сообщение об ошибке.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Конструкции order by и compute  могут использоваться только в конце оператора union для определия порядка расположения окончательных результатов или вычисления итоговых значений. Их нельзя использовать в отдельных подзапросах, составляющих оператор union.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Конструкции group by и having могут использоваться только в отдельных подзапросах. Их нельзя использовать для результирующего множества.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Команду union можно использовать также в операторе insert (вставить). Например:</td></tr></table></div>&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 85px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28"></td><td>insert into tour</td></tr></table></div> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;select city, state from stores</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;union</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;select city, state from authors</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td> Команду union нельзя использовать в операторе creat view (создать вьювер).</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Конструкцию for browse (для просмотра) нельзя использовать в операторах, содержащих команду union.</td></tr></table></div>
