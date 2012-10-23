<h1>Соединения: выбор данных из нескольких таблиц</h1>
<div class="date">01.01.2007</div>


<p>Соединения: Выбор данных из нескольких таблиц</p>
&nbsp;</p>
В этой главе начинается обсуждение операций, которые связаны с выбором данных из нескольких таблиц. Эти таблицы могут быть расположены как в одной и той же базе данных (локальные таблицы), так и в разных базах данных. До сих пор рассматривались примеры выбора данных из одной таблицы.</p>
&nbsp;</p>
В этой главе рассматривается мультитабличная операция соединения (join). Подзапросы, которые обращаются к нескольким таблицам, будут рассмотрены в главе 5 “Подзапросы: Использование запросов внутри других запросов”. Часто cоединения могут выступать в качестве подзапросов.</p>
&nbsp;</p>
В этой главе обсуждаются следующие темы:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Общий обзор операций соединения;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Как соединять таблицы в запросе;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Как SQL Сервер выполняет соединение;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Как влияют неопределенные значения на соединение;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Как указывать столбцы для соединения.</td></tr></table></div>&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Что такое соединения ?</td></tr></table></div>&nbsp;</p>
Соединение двух и более таблиц можно рассматривать как процесс сравнения данных в указанных столбцах этих таблиц и формирования новой таблицы из строк исходных таблиц, которые дают положительный результат при сравнении. Оператор join (соединить) сравнивает данные в указанных столбцах каждой таблицы строка за строкой и компонует из строк, прошедших сравнение, новые строки. Обычно в качестве операции сравнения выступает равенство, т.е. данные сравниваются на полное совпадение, но возможны и другие типы соединения. Результаты соединения будут иметь содержательный смысл, если сравниваемые величины имеют один и тот же тип или подобные типы.</p>
Операция соединения имеет свой собственный жаргон. Слово “join” может использоваться и как глагол и как существительное, кроме того оно может означать либо операцию, либо запрос, содержащий эту операцию, либо результаты этого запроса.</p>
Имеется также несколько разновидностей соединений: соединения с равенством (эквисоединения), естественные (natural) соединения, внешние соединения и т.д.</p>
Наиболее часто встречающейся разновидностью соединений являются соединения, основанные на равенстве. Ниже приведен пример запроса на соединение, в котором ищутся имена авторов и издателей, живущих в одном и том же городе:</p>
&nbsp;</p>
select au_fname, au_lname, pub_name</p>
from authors, publishers</p>
where authors.city = publishers.city</p>
&nbsp;</p>
au_fname&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; au_lname&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; pub_name</p>
-------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------&nbsp;&nbsp;&nbsp;&nbsp; -----------------------------</p>
Cheryl&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Carson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Algodata Infosystems</p>
Abraham&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bennet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Algodata Infosystems</p>
&nbsp;</p>
(Выбрано 2 строки)</p>
&nbsp;</p>
Поскольку требуемая информация находится в двух таблицах publishers и authors, то для ее выбора необходимо соединение этих таблиц.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Соединения и реляционная модель</td></tr></table></div>&nbsp;</p>
Операция соединения является отличительным признаком реляционной модели данных в системах управления базами данных (СУБД). Причем это самый существенный признак реляционных систем управления базами данных, который отличает их от систем других типов.</p>
В структурных СУБД, известных также как сетевые или иерархические системы, связи между данными должны быть заранее определены. В таких системах после создания базы данных уже трудно сделать запрос относительно связей между данными, которые не были заранее предусмотрены.</p>
В реляционных СУБД, наоборот, при создании базы данных связи между данными не фиксируются. Они проявляются лишь при обработке данных, т.е. в момент запроса к базе данных, а не при ее создании. Можно обратиться с любым запросом, который приходит в голову, относительно хранящейся в базе информации, независимо от того с какой целью создавалась эта база.</p>
В соответствии с правилами проектирования баз данных, известными как правила нормализации, каждая таблица должна описывать один вид сущностей - человека, место, событие или вещь. По этой причине, когда нужно сравнить информацию, относящуюся к различным объектам, необходима операция соединения. Взаимосвязи, существующие между данными, расположенными в различных таблицах, проявляются путем их соединения.</p>
Как следствие из этого правила, операция соединения дает неограниченную гибкость в добавлении новых видов данных в базу. Всегда можно создать новую таблицу, которая содержит данные, относящиеся к разным сущностям. Если новая таблица имеет поле, подобное некоторому полю в уже существующей таблице, то его можно добавить в эту таблицу путем соединения.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Соединение таблиц в запросах</td></tr></table></div>&nbsp;</p>
Оператор соединения, как и оператор выбора, начинается с ключевого слова select. Данные из столбцов, указанных после этого ключевого слова, включаются в результаты запроса в нужном порядке. В предыдущем примере это были столбцы с именами и фамилиями писателей и названиями издательств.</p>
Названия столбцов в этом примере pub_name, au_lname и au_fname не нужно уточнять названием таблицы, поскольку здесь нет неоднозначности относительно того, какой таблице они принадлежат. Но название столбца city, который используется в операции сравнения уже нуждается в уточнении, поскольку столбцы с таким названием имеются в обеих таблицах. Хотя в этом примере ни один из столбцов city не появляется в результатах запроса, SQL Серверу необходимо уточнение для выполнения операции сравнения.</p>
Как и в операторе выбора, здесь можно включить все столбцы в результат запроса с помощью сокращения “*”. Например, для того чтобы включить все столбцы таблиц authors и publishers в результат предыдущего соединения, необходимо выполнить следующий запрос:</p>
&nbsp;</p>
select *</p>
from authors, publishers</p>
where authors.city = publishers.city</p>
&nbsp;</p>
au_id &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;au_lname &nbsp; &nbsp; &nbsp; &nbsp;au_fname &nbsp; &nbsp; &nbsp; &nbsp;phone &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;address &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;city</p>
state &nbsp; &nbsp; &nbsp; &nbsp;postalcode &nbsp; &nbsp; &nbsp; &nbsp;contract &nbsp; &nbsp; &nbsp; &nbsp;pub_id &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;pub_name &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;city &nbsp; &nbsp; &nbsp; &nbsp;state</p>
--------------- &nbsp; &nbsp; &nbsp; &nbsp;---------- &nbsp; &nbsp; &nbsp; &nbsp;---------- &nbsp; &nbsp; &nbsp; &nbsp;------------------ &nbsp; &nbsp; &nbsp; &nbsp;----------------</p>
------ &nbsp; &nbsp; &nbsp; &nbsp;-------------- &nbsp; &nbsp; &nbsp; &nbsp;-------- &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;--------- &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;-----------------------------&nbsp; ---------&nbsp;</p>
238-95-7766 &nbsp; &nbsp; &nbsp; &nbsp;Carson &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Cheryl &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;415 548-7723 &nbsp; &nbsp; &nbsp; &nbsp;589 Darwin Ln. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Berkeley</p>
CA &nbsp; &nbsp; &nbsp; &nbsp;94705 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1389 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Algodata Infosystems &nbsp; &nbsp; &nbsp; &nbsp;Berkeley&nbsp; CA</p>
&nbsp;</p>
409-56-7008 &nbsp; &nbsp; &nbsp; &nbsp;Bennet &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Abraham &nbsp; &nbsp; &nbsp; &nbsp;415 658-9932 &nbsp; &nbsp; &nbsp; &nbsp;223 Bateman St &nbsp; &nbsp; &nbsp; &nbsp;Berkeley</p>
CA &nbsp; &nbsp; &nbsp; &nbsp;94705 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1389 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Algodata Infosystems &nbsp; &nbsp; &nbsp; &nbsp;Berkeley&nbsp; CA</p>
&nbsp;</p>
(Выбрано 2 строки)</p>
&nbsp;</p>
Отсюда видно, что результирующая строка составлена из строк исходных таблиц и состоит из тринадцати столбцов каждая. Поскольку ширины печатной страницы не хватает, то каждая результирующая строка размещается на двух текстовых строках. Когда используется символ “*”, то столбцы выводятся в том порядке, в каком они расположены в таблицах.</p>
В списке выбора можно указать названия столбцов только из одной таблицы, участвующей в соединении. Например, чтобы найти авторов, живущих в одном городе с некоторым издателем, не обязательно указывать названия столбцов из таблицы publishers:</p>
&nbsp;</p>
select au_lname, au_fname</p>
from authors, publishers</p>
where authors.city = publishers.city</p>
&nbsp;</p>
Необходимо помнить, что, как и в любом операторе выбора, названия столбцов в списке выбора и названия таблиц в предложении (конструкции) from должны разделяться запятыми.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Предложение from</td></tr></table></div>&nbsp;</p>
В предложении from оператора соединения указываются названия всех таблиц и вьюверов, участвующих в соединении. Именно это предложение указывает SQL Серверу, что необходимо выполнить соединение. Таблицы и вьюверы в этом предложении можно указывать в произвольном порядке. Порядок расположения названий таблиц влияет на результат только при использовании сокращения “*” в списке выбора.</p>
В предложении from можно указывать от 2 до 16 отдельных названий для таблиц или выюверов. При подсчете максимально допустимого числа нужно учитывать, что отдельным членом этого предложения считаются следующие названия:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Название таблицы (или вьювера), указанное в предложении from;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Каждая копия названия одной и той же таблицы (самосоединение);</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Название таблицы, указанное в подзапросе;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Названия базовых таблиц, на которые ссылаются вьюверы, указанные в&nbsp;&nbsp;&nbsp;&nbsp; предложении from.</td></tr></table></div>&nbsp;</p>
Соединения, в которых участвует более двух таблиц, рассматриваются далее в главе “Соединение более двух таблиц”.</p>
Как отмечалось во второй главе “Запросы: Выбор данных из таблицы”, названия таблиц и вьюверов могут уточняться названием владельца и названием базы данных.</p>
Вьюверы можно использовать точно также, как и таблицы. В главе 9 будут рассмотрены вьюверы, но во всех приводимых там примерах будут использоваться только таблицы.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Предложение where</td></tr></table></div>&nbsp;</p>
В предложении where (где) указываются отношения, которые устанавливаются между таблицами, перечисленными в предложении from, для выбора результирующих строк. В нем приводятся названия столбцов, по которым производится соединение, дополненные при необходимости названиями таблиц, и операция сравнения, которой обычно является равенство, но иногда здесь могут встречаться и отношения “больше чем” или “меньше чем”. Детальное описание синтаксиса предложения where приводится в главе 2 этого руководства и в главе “Предложение where” в Справочном руководстве SQL Сервера.</p>
&nbsp;</p>
Замечание. Можно получить совершенно неожиданный результат, если опустить предложение where в операторе соединения. Без этого предложения все вышеприведенные запросы на соединение будут выдавать 27 строк вместо 2. В следующем разделе будет объяснено почему так происходит.</p>
&nbsp;</p>
Соединения, в которых данные сравниваются на совпадение, называются эквисоединениями (equijoins). Более точное определение эквисоединения дается позже в этой главе, также как и примеры соединений, основанных не на равенстве.</p>
Соединение может основываться на следующих операциях сравнения:</p>
&nbsp;</p>
Таблица 4.1. Операции сравнения &nbsp;</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td>Операция</p>
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
<td>Больше чем</p>
</td>
</tr>
<tr>
<td>&gt;=</p>
</td>
<td>Больше или равно</p>
</td>
</tr>
<tr>
<td>&lt;</p>
</td>
<td>Меньше чем</p>
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
<td>!&gt;</p>
</td>
<td>Меньше или равно (не больше)</p>
</td>
</tr>
<tr>
<td>!&lt;</p>
</td>
<td>Больше или рано (не меньше)
</td>
</tr>
</table>
&nbsp;</p>
Соединения, основанные на операциях сравнения, в общем называются тетасоединениями (theta joins). Другой класс соединений образуют внешние соединения, которые рассматриваются позже в этой же главе. К числу внешних операций соединения относятся следующие операции.</p>
&nbsp;</p>
Таблица 4.2. Операции внешнего соединения &nbsp;</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td>Операция</p>
</td>
<td>Действие</p>
</td>
</tr>
<tr>
<td>*=</p>
</td>
<td>В результат включаются все строки из первой таблицы, а не только строки, удовлетворящие условию сравнения.</p>
</td>
</tr>
<tr>
<td>=*</p>
</td>
<td>В результат включаются все строки из второй таблицы, а не только строки, удовлетворящие условию сравнения.
</td>
</tr>
</table>
&nbsp;</p>
Названия соединяемых столбцов могут не совпадать, хотя на практике они часто совпадают. Кроме того, они могут содержать данные различных типов (см. главу 7).</p>
Однако, если типы данных не совпадают, то они должны быть совместимыми, чтобы SQL Сервер мог автоматически преобразовать их между собой. Например, SQL Сервер автоматически преобразует друг в друга любые числовые типы данных: int, smallint, tinyint, decimal, float, а также любые строковые типы и типы даты: char, varchar, nchar, nvarchar  и datetime.&nbsp; Более детально преобразование типов рассматривается в главе 10 “Использование встроенных функций в запросах” и в главе “Функции преобразования типов данных” Справочного руководства SQL Сервера.</p>
&nbsp;</p>
Замечание. Таблицы нельзя соединять по текстовым или графическим полям. Однако можно сравнивать длины текстовых полей в предложении where, например, следующим образом:</p>
&nbsp;</p>
where datalength(textab_1.textcol) &gt; datalength(textab_2.textcol)</p>
&nbsp;</p>
Предложение where оператора соединения может включать и другие условия, отличные от условия соединения. Другими словами, операторы соединения и выбора можно объединить в одном SQL операторе. Далее в этой главе будут приведены соответствующие примеры.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Как выполнются соединения</td></tr></table></div>&nbsp;</p>
Знание того, как выполняется соединения помогает в их понимании и позволяет объяснить, почему получаются неожиданные результаты, когда соединение задано неправильно. В этом разделе описывается процесс выполнения соединения в концептуальном плане. Конечно, SQL Сервер выполняет эту процедуру более сложным образом.</p>
Вообще говоря, первый шаг в выполнении соединения состоит в образовании декартова произведения таблиц, т.е. в образовании всех возможных комбинаций строк этих таблиц друг с другом. Число строк в декартовом (прямом) произведении двух таблиц, равно произведению числа строк в первой таблице на число строк во второй таблице.</p>
Например, число строк в декартовом произведении таблиц author и publishers равно 69 ( 23 автора, умноженные на 3 издателя).</p>
Декартово произведение строится в любом запросе, который содержит более одной таблицы в списке выбора, более одной таблицы в предложении from и не содержит предложения where. Например, если убрать предложение where из предыдущего запроса на соединение, то SQL Сервер скомбинирует 23 автора с 3 издателями и возвратит в результате 69 строк.</p>
Декартово произведение не содержит какой-либо полезной информации. На самом деле оно даже вводит в заблуждение, поскольку создает видимость, что каждый автор имеет отношение к каждому издателю, что совершенно неверно.</p>
По этой причине соединение должно включать предложение where, которое отбирает связанные между собой строки и указывает как именно они должны быть связаны. Оно может включать также дополнительные ограничения. Из декартового произведения происходит удаление тех строк, которые не удовлетворяют условиям в предложении where.</p>
В предыдущем примере предложение where удаляет те строки, в которых город, где проживает автор, отличен от города, где живет&nbsp; издатель.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Еквисоединения и естественные соединения</td></tr></table></div>&nbsp;</p>
Еквисоединением называется соединение, в котором данные в столбцах сравниваются на равенство, и все столбцы соединяемых таблиц включаются в результат.</p>
Запрос, который был рассмотрен ранее:</p>
&nbsp;</p>
select *</p>
from authors, publishers</p>
where authors.city = publishers.city</p>
&nbsp;</p>
является примером еквисоединения. В результате этого запроса столбец city появляется дважды. Из определения следует, что результат эквисоединения содержит два одинаковых столбца. Поскольку обычно нет необходимости повторять одну и ту же информацию, то один из этих столбцов можно удалить путем модификации запроса. Результат этой модификации, показанный далее, называется естественным соединением.</p>
&nbsp;</p>
select publishers.pub_id, publishers.pub_name, publishers.state, authors.*</p>
from publishers, authors</p>
where publishers.city = authors.city</p>
&nbsp;</p>
В этом примере столбец publishers.city уже не появится в результате запроса.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Соединения с дополнительными условиями</td></tr></table></div>&nbsp;</p>
Предложение where запроса на соединение может содержать кроме условия соединения, также дополнительные критерии отбора. Например, для выбора названий и издателей всех книг, по которым был выплачен аванс больший чем 7500 долларов, можно воспользоваться следующим запросом:</p>
&nbsp;</p>
select title, pub_name, advance</p>
from titles, publishers</p>
where titles.pub_id = publishers.pub_id and advance &gt; $7500</p>
&nbsp;</p>
title &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; pub_name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; advance</p>
---------------------------------------------- &nbsp; &nbsp; &nbsp; &nbsp;---------------------------- &nbsp; &nbsp; &nbsp; &nbsp;-------------</p>
You Can Combat Computer Stress!&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; New Age Books &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;10,125.00</p>
The Gourmet &nbsp; &nbsp; &nbsp; &nbsp;Microwave &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Binnet &amp; Hardley &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;15,000.00</p>
Secrets of Silicon Valley &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Algodata Infosystems  &nbsp; &nbsp; &nbsp; &nbsp;8,000.00</p>
Sushi, Anyone? &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Binnet &amp; Hardley &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 8,000.00</p>
&nbsp;</p>
(Выбрано 4 строки)</p>
&nbsp;</p>
Заметим, что столбцы, по которым происходит соединение, не обязательно должны включаться в список выбора, поэтому в данном случае их нет в результате.</p>
В оператор соединения можно включать произвольное число дополнительных критериев отбора. Порядок следования этих критериев и условия соединения не имеет значения.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Соединения, не основанные на равенстве</td></tr></table></div>&nbsp;</p>
Условие соединения таблиц не обязательно является равенством. Здесь можно использовать любую другую операцию сравнения: не равно (!=), больше чем (&gt;), меньше чем (&lt;), больше или равно (&gt;=), меньше или равно (&lt;=). Язык Transact-SQL также содержит операции !&gt; и !&lt; , которые эквивалентны операциям меньше или равно и больше или равно соответственно.</p>
В следующем примере используется операция “больше чем” для нахождения авторов, которые публиковались издательством New Age Books и которые живут в штатах, названия которых больше чем название штата Массачусетс (в алфавитном порядке):</p>
&nbsp;</p>
select pub_name, publishers.state, au_lname, au_fname, authors.state</p>
from publishers, authors</p>
where authors.state &gt; publishers.state and pub_name = "New Age Books"</p>
&nbsp;</p>
pub_name &nbsp; &nbsp; &nbsp; &nbsp;state &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; au_lname&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; au_fname &nbsp; &nbsp; &nbsp; &nbsp;state</p>
--------------------- &nbsp; &nbsp; &nbsp; &nbsp;------ &nbsp; &nbsp; &nbsp; &nbsp;----------------- &nbsp; &nbsp; &nbsp; &nbsp;---------------- &nbsp; &nbsp; &nbsp; &nbsp;-----</p>
New Age Books &nbsp; &nbsp; &nbsp; &nbsp;MA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Greene&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Morningstar &nbsp; &nbsp; &nbsp; &nbsp;TN</p>
New Age Books &nbsp; &nbsp; &nbsp; &nbsp;MA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Blotchet-Halls  &nbsp; &nbsp; &nbsp; &nbsp;Reginald &nbsp; &nbsp; &nbsp; &nbsp;OR</p>
New Age Books &nbsp; &nbsp; &nbsp; &nbsp;MA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; del Castillo&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Innes &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;MI</p>
New Age Books &nbsp; &nbsp; &nbsp; &nbsp;MA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Panteley&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Sylvia &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;MD</p>
New Age Books &nbsp; &nbsp; &nbsp; &nbsp;MA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ringer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; Anne &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;UT</p>
New Age Books &nbsp; &nbsp; &nbsp; &nbsp;MA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ringer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Albert &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;UT</p>
&nbsp;</p>
(Выбрано 6 строк)</p>
&nbsp;</p>
В следующем примере в соединении используются операции &gt;= и &lt;&nbsp; для правильного нахождения скидок (royalty) в таблице roysched, связанных с общим объемом продаж:</p>
&nbsp;</p>
select t.title_id, t.total_sales, r.royalty</p>
from titles t, roysched r</p>
where t.title_id = r.title_id and t.total_sales &gt;= r.lorange and t.total_sales &lt; r.hirange</p>
&nbsp;</p>
title_id &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;total_sales &nbsp; &nbsp; &nbsp; &nbsp;royalty</p>
----------- &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;----------- &nbsp; &nbsp; &nbsp; &nbsp;-------  &nbsp; &nbsp; &nbsp; &nbsp;----------</p>
BU1032 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 4095 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;10&nbsp;</p>
BU1111 &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;3876 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;10&nbsp;</p>
BU2075 &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;1872 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;24&nbsp;</p>
BU7832 &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;4095 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;10&nbsp;</p>
MC2222 &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;2032 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;12&nbsp;</p>
MC3021 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;22246 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;24&nbsp;</p>
PC1035 &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;8780 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;16&nbsp;</p>
PC8888 &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;4095 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;10&nbsp;</p>
PS1372 &nbsp; &nbsp; &nbsp; &nbsp;   &nbsp; &nbsp; &nbsp; &nbsp;375 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;10&nbsp;</p>
PS2091 &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;2045 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;12&nbsp;</p>
PS2106 &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; 111 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;10&nbsp;</p>
PS3333 &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;4072 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;10&nbsp;</p>
PS7777 &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;3336 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;10&nbsp;</p>
TC3218 &nbsp; &nbsp; &nbsp; &nbsp;   &nbsp; &nbsp; &nbsp; &nbsp;375 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;10&nbsp;</p>
TC4203 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;15096 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;14&nbsp;</p>
TC7777 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 4095 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;10</p>
&nbsp;</p>
(Выбрано 16 строк)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Самосоединения и корреляция названий</td></tr></table></div>&nbsp;</p>
Можно соединять между собой столбцы одной и той же таблицы с помощью самосоединения (self-join). Например, можно использовать самосоединение для нахождения авторов, живущих в городе Окленде штата Калифорния в одном и том же почтовом округе.</p>
Поскольку этот запрос включает столбцы одной таблицы authors, то эта таблица выступает в двух ролях. Чтобы различить эти роли, необходимо временно присвоить ей в предложении from различные коррелирующиеся (согласующиеся) названия, такие как au1 и au2. Эти согласующиеся названия будут использоваться для уточнения названий столбцов в следующем запросе. В этом случае самосоединение выглядит следующим образом:</p>
&nbsp;</p>
select au1.au_fname, au1.au_lname, au2.au_fname, au2.au_lname</p>
from authors au1, authors au2</p>
where au1.city = "Oakland" and au2.city = "Oakland"</p>
and au1.state = "CA" and au2.state = "CA"</p>
and au1.postalcode = au2.postalcode</p>
&nbsp;</p>
au_fname&nbsp;&nbsp; au_lname&nbsp; au_fname&nbsp;&nbsp;&nbsp;&nbsp; au_lname</p>
------------&nbsp;&nbsp;&nbsp; -----------&nbsp;&nbsp; -----------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------</p>
Marjorie&nbsp;&nbsp;&nbsp;&nbsp; Green&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Marjorie&nbsp;&nbsp;&nbsp; Green</p>
Dick&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Straight&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Dick&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Straight</p>
Dick&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Straight&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Dirk&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Stringer</p>
Dick&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Straight&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Livia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Karsen</p>
Dirk&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Stringer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Dick&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Straight</p>
Dirk&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Stringer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Dirk&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Stringer</p>
Dirk&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Stringer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Livia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Karsen</p>
Stearns&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MacFeather&nbsp; Stearns&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MacFeather</p>
Livia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Karsen&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Dick&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Straight</p>
Livia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Karsen&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Dirk&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Stringer</p>
Livia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Karsen&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Livia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Karsen</p>
&nbsp;</p>
(Выбрано 11 строк)</p>
&nbsp;</p>
Чтобы исключить из результатов этого запроса строки, в которых авторы соединяются сами с собой, а также строки, отличающиеся лишь порядком следования авторов, необходимо добавить в самосоединение дополнительное условие:</p>
&nbsp;</p>
select au1.au_fname, au1.au_lname, au2.au_fname, au2.au_lname</p>
from authors au1, authors au2</p>
where au1.city = "Oakland" and au2.city = "Oakland"</p>
and au1.state = "CA" and au2.state = "CA"</p>
and au1.postalcode = au2.postalcode</p>
and au1.au_id &lt; au2.au_id</p>
&nbsp;</p>
au_fname&nbsp;&nbsp; au_lname&nbsp;&nbsp;&nbsp; au_fname&nbsp; au_lname</p>
---------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----------&nbsp;&nbsp;&nbsp;&nbsp; -----------&nbsp;&nbsp; ----------</p>
Dick&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Straight&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Dirk&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Stringer</p>
Dick&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Straight&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Livia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Karsen</p>
Dirk&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Stringer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Livia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Karsen</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 3 строки)</p>
&nbsp;</p>
Теперь понятно, что Дик Страйт, Дик Стрингер и Ливия Карсен живут в одном и том же почтовом округе.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Соединения с условием “не равно”</td></tr></table></div>&nbsp;</p>
 Условие “не равно” особенно полезно для отбора строк при</p>
самосоединении. Например, это условие используется в следующем самосоединении для нахождения всех категорий (типов) книг, в которых есть по крайней мере две недорогих (меньше чем 15 долларов) книги с различными ценами:</p>
&nbsp;</p>
select distinct t1.type, t1.price</p>
from titles t1, titles t2</p>
where t1.price &lt;$15 and t2.price &lt;$15</p>
and t1.type = t2.type</p>
and t1.price != t2.price</p>
&nbsp;</p>
type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;   &nbsp; &nbsp; &nbsp; &nbsp;price</p>
----------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;--------</p>
business&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;2.99</p>
business&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;11.95</p>
psychology&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;7.00</p>
psychology&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;7.99</p>
psychology&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;10.95</p>
trad_cook&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;11.95</p>
trad_cook&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;14.99</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 7 строк)</p>
&nbsp;</p>
Замечание. Выражение “not название_столбца1 = название_столбца2” эквивалентно выражению “название_столбца1 != название_столбца2”.</p>
&nbsp;</p>
В следующем примере соединение с условием “не равно” комбинируется с самосоединением. В этом запросе ищутся строки в таблице titleauthor, у которых одинаково значение поля title_id, но различно значение поля au_id, т.е. ищутся книги, у которых, по крайней мере, два автора.</p>
&nbsp;</p>
select distinct t1.au_id, t1.title_id</p>
from titleauthor t1, titleauthor t2</p>
where t1.title_id = t2.title_id and t1.au_id != t2.au_id</p>
order by t1.title_id</p>
&nbsp;</p>
au_id&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; title_id&nbsp;</p>
----------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----------&nbsp;</p>
213-46-8915&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BU1032&nbsp;&nbsp;&nbsp;</p>
409-56-7008&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BU1032&nbsp;&nbsp;&nbsp;</p>
267-41-2394&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BU1111&nbsp;&nbsp;&nbsp;</p>
724-80-9391&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BU1111&nbsp;&nbsp;&nbsp;</p>
722-51-5454&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MC3021&nbsp;&nbsp;&nbsp;</p>
899-46-2035&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MC3021&nbsp;&nbsp;&nbsp;</p>
427-17-2319&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PC8888&nbsp;&nbsp;&nbsp;</p>
846-92-7186&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PC8888&nbsp;&nbsp;&nbsp;</p>
724-80-9391&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PS1372&nbsp;&nbsp;&nbsp;</p>
756-30-7391&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PS1372&nbsp;&nbsp;&nbsp;</p>
899-46-2035&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PS2091&nbsp;&nbsp;&nbsp;</p>
998-72-3567&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PS2091&nbsp;&nbsp;&nbsp;</p>
267-41-2394&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TC7777&nbsp;&nbsp;&nbsp;</p>
472-27-2349&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TC7777&nbsp;&nbsp;&nbsp;</p>
672-71-3249&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TC7777</p>
&nbsp;</p>
(Выбрано 15 строк)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Соединения с условием “не равно” и подзапросы</td></tr></table></div>Иногда соединения с условием “не равно” бывает недостаточно и его необходимо заменить подзапросом. Например, предположим, что необходимо получить список авторов, которые живут в городах, где нет издательств. Для простоты ограничим этот список авторами, фамилии которых начинаются на буквы “А”, “В” и “С”. Запрос с условием “не равно” может иметь следующий вид:</p>
&nbsp;</p>
select distinct au_lname, authors.city</p>
from publishers, authors</p>
where au_lname like "[ABC]%" and publishers.city != authors.city</p>
&nbsp;</p>
Но получаемые на него результаты вовсе не являются ответом на этот вопрос!</p>
au_lname&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; city&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
----------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------&nbsp;</p>
Bennet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Berkeley&nbsp;</p>
Carson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Berkeley&nbsp;</p>
Blotchet-Halls&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Corvallis</p>
&nbsp;</p>
Система интерпретирует этот SQL оператор следующим образом: “Найти фамилии авторов, которые живут в городе, в котором нет некоторого издательства”. Все авторы, имеющиеся в таблице, удовлетворяют этому условию, включая авторов, живущих в Беркли, в котором расположено издательство Algodata Inforsystems.</p>
В этом случае способ, которым система выполняет соединение (предварительно строя все возможные комбинации с последующей проверкой остальных условий), является причиной появления нежелательного результата. В случаях подобных этому необходимо использовать подзапрос для получения желаемого результата. Подзапрос может выполнить предварительное удаление ненужных строк, а затем уже будет выполняться последующий отбор.</p>
Правильный оператор будет иметь следующий вид:</p>
&nbsp;</p>
select distinct au_lname, city</p>
from authors</p>
where au_lname like "[ABC]%" and city not in</p>
(select city from publishers</p>
where authors.city = publishers.city)</p>
&nbsp;</p>
Теперь получается нужный результат:</p>
&nbsp;</p>
au_lname&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; city&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
-------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------</p>
Blotchet-Halls&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Corvallis</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрана 1 строка)</p>
&nbsp;</p>
Подзапросы будут подробно рассмотрены в главе 6.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Соединение более чем двух таблиц</td></tr></table></div>&nbsp;</p>
Таблица titleauthor базы pubs2 дает хороший пример ситуации, в которой полезно соединить более чем две таблицы. Чтобы найти названия всех книг заданного типа и имена их авторов, можно использовать следующий запрос:</p>
&nbsp;</p>
select au_lname, au_fname, title</p>
from authors, titles, titleauthor</p>
where authors.au_id = titleauthor.au_id</p>
and titles.title_id = titleauthor.title_id</p>
and titles.type = "trad_cook"</p>
&nbsp;</p>
au_lname&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; au_fname&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; title</p>
--------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----------------------------------------------</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 189px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="95">Panteley</td><td>Sylvia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Onions, Leeks, and Garlic: Сooking&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Secrets of the Mediterranean</td></tr></table></div>Blotchet-Halls&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Reginald&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fifty Years in Buckingham Palace&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Kitchens</p>
O'Leary&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Michael&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sushi, Anyone?</p>
Gringlesby&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Burt&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sushi, Anyone?</p>
Yokomoto&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Akiko&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sushi, Anyone?</p>
&nbsp;</p>
(Выбрано 5 строк)</p>
&nbsp;</p>
Заметим, что одна из таблиц в предложении from, а именно titleauthor, не передает в окончательный результат свои данные, поскольку ни данные из столбца au_id, ни данные из столбца title_id  не включены в результат. Однако само соединение стало возможным лишь при использовании этой таблицы как промежуточной.</p>
В одном операторе можно также соединять по более чем двум столбцам. Например, в следующем запросе показан общий объем продаж каждой книги, интервал в который попадает этот объем, и результирующая скидка:</p>
&nbsp;</p>
select titles.title_id, total_sales, lorange, hirange, royalty</p>
from titles, roysched</p>
where titles.title_id = roysched.title_id</p>
  and total_sales &gt;= lorange and total_sales &lt; hirange</p>
&nbsp;</p>
title_id &nbsp; &nbsp; &nbsp; &nbsp;total_sales&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; lorange&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; hirange&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; royalty</p>
----------------------- &nbsp; &nbsp; &nbsp; &nbsp;---------- &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;----</p>
 BU1032 &nbsp; &nbsp; &nbsp; &nbsp;  4095 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 0 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 5000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;10</p>
 BU1111 &nbsp; &nbsp; &nbsp; &nbsp;  3876 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 0 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 4000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;10</p>
 BU2075 &nbsp; &nbsp; &nbsp; &nbsp;18722 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;14001 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;50000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;24</p>
 BU7832 &nbsp; &nbsp; &nbsp; &nbsp;  4095 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 0 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 5000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;10</p>
 MC2222&nbsp; 2032 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2001 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 4000&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;12</p>
 MC3021&nbsp; 2224 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;12001 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;50000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 24</p>
 PC1035 &nbsp; &nbsp; &nbsp; &nbsp;  8780 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 4001 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;10000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;16</p>
 PC8888 &nbsp; &nbsp; &nbsp; &nbsp;  4095 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 0 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 5000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;10</p>
 PS1372 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; 375 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 0 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 10000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;10</p>
 PS2091 &nbsp; &nbsp; &nbsp; &nbsp;  2045 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 1001 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 5000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;12</p>
 PS2106 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; 111 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 0 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;10</p>
 PS3333 &nbsp; &nbsp; &nbsp; &nbsp;  4072 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 0 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 5000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;10</p>
 PS7777 &nbsp; &nbsp; &nbsp; &nbsp;  3336 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 0 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 5000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;10</p>
 TC3218 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; 375 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 0 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;10</p>
 TC4203 &nbsp; &nbsp; &nbsp; &nbsp; 15096 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 8001 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;6000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;14</p>
 TC7777 &nbsp; &nbsp; &nbsp; &nbsp;  4095 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 0 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 5000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;10</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Выбрано 16 строк)</p>
&nbsp;</p>
Когда в одном операторе совмещаются несколько соединений или когда соединяются более двух таблиц, “соединительные выражения” обычно связываются логической операцией and (И), как это было в предыдущих примерах. Однако, их можно связывать и логической операции or (ИЛИ).</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Внешние соединения</td></tr></table></div>&nbsp;</p>
В рассматриваемых ранее соединениях в результат включались только строки, которые удовлетворяли условию соединения. По существу эти соединения исключали информацию, которая содержалась в строках, которые не удовлетворяли этому условию.</p>
Однако, иногда, в результат желательно включить именно информацию, которая содержится в этих строках. В таких случаях нужно использовать внешнее соединение. Язык Transact-SQL является одной из версий языка SQL, которая содержит внешние соединения.</p>
Операции внешнего соединения в языке Transact-SQL имеют следующий вид:</p>
&nbsp;</p>
Таблица 4.3. Список операций внешнего соединения</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td>Операция</p>
</td>
<td>Действие</p>
</td>
</tr>
<tr>
<td>*=</p>
</td>
<td>В результат включаются все строки из первой таблицы.</p>
</td>
</tr>
<tr>
<td>=*</p>
</td>
<td>В результат включаются все строки из второй таблицы.
</td>
</tr>
</table>
&nbsp;</p>
Напомним, что запрос, в котором искались авторы, проживающие в одном городе с издателем, возращал двух людей: Абрахама Беннета и Черил Карсон. Чтобы включить в результат всех авторов независимо от местонахождения издателя, необходимо использовать внешнее соединение. Соответствующий запрос и его результаты имеют следующий вид:</p>
&nbsp;</p>
select au_fname, au_lname, pub_name</p>
from authors, publishers</p>
where authors.city *= publishers.city</p>
&nbsp;</p>
au_fname&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; au_lname&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; pub_name</p>
-----------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ----------------------------</p>
Johnson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; White&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
Marjorie&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Green&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
Cheryl&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Carson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Algodata Infosystems</p>
Michael&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; O'Leary&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
Dick&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Straight&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
Meander&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Smith&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
Abraham&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bennet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Algodata Infosystems</p>
Ann&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Dull&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
Burt&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Gringlesby&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
Chastity&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Locksley&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
Morningstar&nbsp; Greene&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
Reginald&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Blotche-Halls&nbsp;&nbsp; NULL</p>
Akiko&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Yokomoto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
Innes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; del Castillo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
Michel&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DeFrance&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
Dirk&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Stringer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
Stearns&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MacFeather&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
Livia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Karsen&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
Sylvia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Panteley&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
Sheryl&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Hunter&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
Heather&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; McBadden&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
Anne&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ringer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
Albert&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ringer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
&nbsp;</p>
(Выбраны 23 строки)</p>
&nbsp;</p>
Операция сравнения “*=” отличает внешнее соединение от обычного. Это “левое” внешнее соединение, которое сообщает SQL Серверу, что необходимо включить в результат все строки первой таблицы authors, независимо от результата сравнения их с полем city таблицы publishers. Заметим, что для большинства авторов результат сравнения отрицательный, поэтому в столбец pub_name в этом случае записывается неопределенное значение NULL. Заметим также, что правая таблица publishers  называется в этом случае внутренней таблицей внешнего соединения.</p>
&nbsp;</p>
&nbsp;</p>
Замечание. Поскольку столбцы с данными типа “бит” не допускают неопределенных значений, то при их внешнем соединении в соответствующих позициях записывается “0”.</p>
&nbsp;</p>
“Правое” внешнее соединение задается операцией сравнения “=*”, которая указывает, что в результат должны включаться все строки из второй таблицы независимо от выполнения условия сравнения с соответствующим полем первой таблицы. В этом случае первая таблица называется внутренней.</p>
Если ввести эту операцию в предыдущий запрос, то получим следующий результат:</p>
&nbsp;</p>
select au_fname, au_lname, pub_name</p>
from authors, publishers</p>
where authors.city =* publishers.city</p>
&nbsp;</p>
au_fname&nbsp;&nbsp;&nbsp;&nbsp; au_lname&nbsp;&nbsp;&nbsp; pub_name</p>
---------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ---------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------------------</p>
NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; New Age Books</p>
NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Binnet &amp; Hardley</p>
Cheryl&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Carson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Algodata Infosystems</p>
Abraham&nbsp;&nbsp;&nbsp;&nbsp; Bennet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Algodata Infosystems</p>
&nbsp;</p>
(Выбраны 4 строки)</p>
&nbsp;</p>
Можно и дальше уточнять результаты внешнего соединения путем сравнения их с константой. Это означает, что точно будут указываться только те величины, которые действительно необходимы, а остальные как бы оказываются за чертой. Для примера рассмотрим сначала эквисоединение, а затем сравним его с внешним соединением. Предположим, что необходимо найти все книги, объем продаж которых в некотором магазине оказался больше 500 экземпляров:</p>
&nbsp;</p>
select distinct salesdetail.stor_id, title</p>
from titles, salesdetail</p>
where qty &gt; 500</p>
and salesdetail.title_id = titles.title_id</p>
&nbsp;</p>
stor_id&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; title&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
-------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------------------------------------------------------------------</p>
5023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sushi, Anyone?</p>
5023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Is Anger the Enemy?</p>
5023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; The Gourmet Microwave&nbsp;</p>
5023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; But Is It User Friendly?</p>
5023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Secrets of Silicon Valley&nbsp;</p>
5023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Straight Talk About Computers&nbsp;</p>
5023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; You Can Combat Computer Stress!&nbsp;</p>
5023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Silicon Valley Gastronomic Treats&nbsp;</p>
5023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Emotional Security: A New Algorithm</p>
5023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; The Busy Executive's Database Guide</p>
5023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fifty Years in Buckingham Palace Kitchens</p>
5023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Prolonged Data Deprivation: Four Case Studies</p>
5023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cooking with Computers: Surreptitious Balance Sheets</p>
7067&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fifty Years in Buckingham Palace Kitchens</p>
&nbsp;</p>
(Выбрано 14 строк)</p>
&nbsp;</p>
Чтобы увидеть кроме того книги, объем продаж которых ни в одном магазине не был больше 500 экземпляров, можно использовать внешнее соединение:</p>
&nbsp;</p>
select distinct salesdetail.stor_id, title</p>
from titles, salesdetail</p>
where qty &gt; 500</p>
and salesdetail.title_id =* titles.title_id</p>
&nbsp;</p>
 stor_id&nbsp;&nbsp;&nbsp;&nbsp; title&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
 -------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ---------- ------------------------------------------------------------</p>
 NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Net Etiquette&nbsp;</p>
 NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Life Without Fear&nbsp;</p>
 5023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sushi, Anyone?</p>
 5023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Is Anger the Enemy?</p>
 5023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; The Gourmet Microwave&nbsp;</p>
 5023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; But Is It User Friendly?&nbsp;</p>
 5023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Secrets of Silicon Valley&nbsp;</p>
 5023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Straight Talk About Computers&nbsp;</p>
 5023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; You Can Combat Computer Stress!</p>
 5023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Silicon Valley Gastronomic Treats&nbsp;</p>
 5023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Emotional Security: A New Algorithm&nbsp;</p>
 5023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; The Busy Executive's Database Guide&nbsp;</p>
 5023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fifty Years in Buckingham Palace Kitchens</p>
 7067&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fifty Years in Buckingham Palace Kitchens</p>
 5023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Prolonged Data Deprivation: Four Case Studies&nbsp;</p>
 5023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cooking with Computers: Surreptitious Balance Sheets&nbsp;</p>
 NULL&nbsp;&nbsp;&nbsp;&nbsp; Computer Phobic and Non-Phobic Individuals: Behavior Variations&nbsp;</p>
 NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Onions, Leeks, and Garlic: Cooking Secrets of the Mediterranean</p>
&nbsp;</p>
(Выбрано 18 строк)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Ограничения на внешнее соединение</td></tr></table></div>&nbsp;</p>
В языке Transact-SQL нельзя одну таблицу использовать и во внешнем соединении и в обычном соединении. Следующий запрос является ошибочным, поскольку таблица salesdetail участвует одновременно в двух соединениях:</p>
&nbsp;</p>
select distinct sales.stor_id, stor_name, title</p>
from sales, stores, titles, salesdetail</p>
where qty &gt; 500</p>
and salesdetail.title_id =* titles.title_id</p>
and sales.stor_id = salesdetail.stor_id</p>
and sales.stor_id = stores.stor_id</p>
&nbsp;</p>
Msg 303, Level 16, State 1:</p>
Server 'RAW', Line 1:</p>
The table 'salesdetail' is an inner member of an outer-join clause. This is not allowed if the table also participates in a regular join clause.</p>
&nbsp;</p>
(Таблица &#8216;salesdetail&#8217; является внутренним членом внешнего соединения. Это недопустимо, поскольку эта таблица также участвует в обычном соединении.)</p>
&nbsp;</p>
Если необходимо определить название магазина, продавшего более 500 экземпляров некоторой книги, нужно сделать второй запрос. Если запрос с внешним соединением содержит также условие отбора по столбцу внутренней таблицы, то&nbsp; могут получиться неожиданные результаты. В этом случае условие отбора не повлияет на число выводимых строк, но приведет к появлению неопределенных значений в столбцах внутренней таблицы в тех строках, которые не удовлетворяют этому условию.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Как неопределенные значения влияют на соединения</td></tr></table></div>&nbsp;</p>
Если в столбцах соединяемых таблиц имеются неопределенные значения, то они будут всегда давать отрицательный результат при сравнении. В частности, отрицательный результат будет получаться и при сравнении значения NULL с NULL. Поскольку значение NULL представляет собой неизвестное или невозможное значение, то нет никаких оснований надеяться, что две неизвестные величины совпадают друг с другом.</p>
Присутствие неопределенных значений в соединяемых таблицах можно обнаружить только при внешнем соединении.&nbsp; Здесь для примера приведены две таблицы, каждая из которых содержит неопределенные значения в столбцах, которые участвуют в соединении. При левом внешнем соединении можно увидеть неопределенные значения в первой таблице.</p>
&nbsp;</p>
Таблица 1:</p>
 a&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; b&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; one&nbsp;&nbsp;</p>
 &nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; three&nbsp;&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; join4&nbsp;&nbsp;&nbsp;</p>
&nbsp;</p>
Таблица 2:</p>
c&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; d&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
---------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------&nbsp;</p>
 &nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; two&nbsp;&nbsp;&nbsp;&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; four&nbsp;&nbsp;&nbsp;</p>
&nbsp;</p>
Левое внешнее соединение:</p>
select *</p>
from t1, t2</p>
where a *= c</p>
&nbsp;</p>
 a&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; b&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; c&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; d&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
 -------&nbsp; -------&nbsp;&nbsp;&nbsp;&nbsp; --------&nbsp;&nbsp;&nbsp;&nbsp; --------&nbsp;</p>
 &nbsp;&nbsp;&nbsp; 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; one&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
NULL&nbsp; three&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
 &nbsp;&nbsp;&nbsp; 4&nbsp;&nbsp;&nbsp;&nbsp; join4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4&nbsp;&nbsp;&nbsp;&nbsp; four</p>
&nbsp;</p>
Заметим, что в этом результате непросто различить неопределенные значения, имеющиеся в таблице, от неопределенных значений, появившихся в результате соединения. Поэтому, когда в таблице имеются неопределенные значения, лучше удалить их из результатов путем использования обычного соединения.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Как выбираются столбцы для соединения таблиц</td></tr></table></div>&nbsp;</p>
Имеется системная процедура SP_HELPJOINS, которая указывает наиболее подходящие для соединения столбцы двух таблиц. Ее можно вызвать с помощью&nbsp; следующей команды:</p>
&nbsp;</p>
sp_helpjoins таблица1, таблица2</p>
&nbsp;</p>
Например, можно вызвать эту процедуру с таблицами titleauthor и titles в качестве аргументов:</p>
&nbsp;</p>
sp_helpjoins titleauthor, titles</p>
&nbsp;</p>
Процедура SP_HELPJOINS выбирает пары столбцов для соединения на основе двух условий. Во-первых, просматривается таблица syskeys (системные ключи) текущей базы даных для поиска ключей импорта (foreign keys) процедурой SP_FOREIGNKEY. Затем проверяется есть ли у этих таблиц общие ключи с помощью процедуры SP_COMMONKEY. Если общих ключей нет, то ищутся любые ключи, подходящие для соединения. Наконец, если таких ключей найти не удалось, то выбираются столбцы с одинаковым названием или одинаковым типом данных.</p>
Более полная информация о системных процедурах дается в Справочном руководстве по SQL Серверу.</p>
