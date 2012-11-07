<h1>Соединения: выбор данных из нескольких таблиц</h1>
<div class="date">01.01.2007</div>


<p>Соединения: Выбор данных из нескольких таблиц</p>
</p>
В этой главе начинается обсуждение операций, которые связаны с выбором данных из нескольких таблиц. Эти таблицы могут быть расположены как в одной и той же базе данных (локальные таблицы), так и в разных базах данных. До сих пор рассматривались примеры выбора данных из одной таблицы.</p>
</p>
В этой главе рассматривается мультитабличная операция соединения (join). Подзапросы, которые обращаются к нескольким таблицам, будут рассмотрены в главе 5 “Подзапросы: Использование запросов внутри других запросов”. Часто cоединения могут выступать в качестве подзапросов.</p>
</p>
В этой главе обсуждаются следующие темы:</p>
</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Общий обзор операций соединения;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Как соединять таблицы в запросе;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Как SQL Сервер выполняет соединение;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Как влияют неопределенные значения на соединение;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Как указывать столбцы для соединения.</td></tr></table></div></p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Что такое соединения ?</td></tr></table></div></p>
Соединение двух и более таблиц можно рассматривать как процесс сравнения данных в указанных столбцах этих таблиц и формирования новой таблицы из строк исходных таблиц, которые дают положительный результат при сравнении. Оператор join (соединить) сравнивает данные в указанных столбцах каждой таблицы строка за строкой и компонует из строк, прошедших сравнение, новые строки. Обычно в качестве операции сравнения выступает равенство, т.е. данные сравниваются на полное совпадение, но возможны и другие типы соединения. Результаты соединения будут иметь содержательный смысл, если сравниваемые величины имеют один и тот же тип или подобные типы.</p>
Операция соединения имеет свой собственный жаргон. Слово “join” может использоваться и как глагол и как существительное, кроме того оно может означать либо операцию, либо запрос, содержащий эту операцию, либо результаты этого запроса.</p>
Имеется также несколько разновидностей соединений: соединения с равенством (эквисоединения), естественные (natural) соединения, внешние соединения и т.д.</p>
Наиболее часто встречающейся разновидностью соединений являются соединения, основанные на равенстве. Ниже приведен пример запроса на соединение, в котором ищутся имена авторов и издателей, живущих в одном и том же городе:</p>
</p>
select au_fname, au_lname, pub_name</p>
from authors, publishers</p>
where authors.city = publishers.city</p>
</p>
au_fname      au_lname      pub_name</p>
-------------      ------------     -----------------------------</p>
Cheryl           Carson        Algodata Infosystems</p>
Abraham       Bennet        Algodata Infosystems</p>
</p>
(Выбрано 2 строки)</p>
</p>
Поскольку требуемая информация находится в двух таблицах publishers и authors, то для ее выбора необходимо соединение этих таблиц.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Соединения и реляционная модель</td></tr></table></div></p>
Операция соединения является отличительным признаком реляционной модели данных в системах управления базами данных (СУБД). Причем это самый существенный признак реляционных систем управления базами данных, который отличает их от систем других типов.</p>
В структурных СУБД, известных также как сетевые или иерархические системы, связи между данными должны быть заранее определены. В таких системах после создания базы данных уже трудно сделать запрос относительно связей между данными, которые не были заранее предусмотрены.</p>
В реляционных СУБД, наоборот, при создании базы данных связи между данными не фиксируются. Они проявляются лишь при обработке данных, т.е. в момент запроса к базе данных, а не при ее создании. Можно обратиться с любым запросом, который приходит в голову, относительно хранящейся в базе информации, независимо от того с какой целью создавалась эта база.</p>
В соответствии с правилами проектирования баз данных, известными как правила нормализации, каждая таблица должна описывать один вид сущностей - человека, место, событие или вещь. По этой причине, когда нужно сравнить информацию, относящуюся к различным объектам, необходима операция соединения. Взаимосвязи, существующие между данными, расположенными в различных таблицах, проявляются путем их соединения.</p>
Как следствие из этого правила, операция соединения дает неограниченную гибкость в добавлении новых видов данных в базу. Всегда можно создать новую таблицу, которая содержит данные, относящиеся к разным сущностям. Если новая таблица имеет поле, подобное некоторому полю в уже существующей таблице, то его можно добавить в эту таблицу путем соединения.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Соединение таблиц в запросах</td></tr></table></div></p>
Оператор соединения, как и оператор выбора, начинается с ключевого слова select. Данные из столбцов, указанных после этого ключевого слова, включаются в результаты запроса в нужном порядке. В предыдущем примере это были столбцы с именами и фамилиями писателей и названиями издательств.</p>
Названия столбцов в этом примере pub_name, au_lname и au_fname не нужно уточнять названием таблицы, поскольку здесь нет неоднозначности относительно того, какой таблице они принадлежат. Но название столбца city, который используется в операции сравнения уже нуждается в уточнении, поскольку столбцы с таким названием имеются в обеих таблицах. Хотя в этом примере ни один из столбцов city не появляется в результатах запроса, SQL Серверу необходимо уточнение для выполнения операции сравнения.</p>
Как и в операторе выбора, здесь можно включить все столбцы в результат запроса с помощью сокращения “*”. Например, для того чтобы включить все столбцы таблиц authors и publishers в результат предыдущего соединения, необходимо выполнить следующий запрос:</p>
</p>
select *</p>
from authors, publishers</p>
where authors.city = publishers.city</p>
</p>
au_id                au_lname        au_fname        phone                address                city</p>
state        postalcode        contract        pub_id                pub_name                city        state</p>
---------------        ----------        ----------        ------------------        ----------------</p>
------        --------------        --------                ---------                -----------------------------  ---------</p>
238-95-7766        Carson                Cheryl                415 548-7723        589 Darwin Ln.                Berkeley</p>
CA        94705                1                1389                Algodata Infosystems        Berkeley  CA</p>
</p>
409-56-7008        Bennet                Abraham        415 658-9932        223 Bateman St        Berkeley</p>
CA        94705                1                1389                Algodata Infosystems        Berkeley  CA</p>
</p>
(Выбрано 2 строки)</p>
</p>
Отсюда видно, что результирующая строка составлена из строк исходных таблиц и состоит из тринадцати столбцов каждая. Поскольку ширины печатной страницы не хватает, то каждая результирующая строка размещается на двух текстовых строках. Когда используется символ “*”, то столбцы выводятся в том порядке, в каком они расположены в таблицах.</p>
В списке выбора можно указать названия столбцов только из одной таблицы, участвующей в соединении. Например, чтобы найти авторов, живущих в одном городе с некоторым издателем, не обязательно указывать названия столбцов из таблицы publishers:</p>
</p>
select au_lname, au_fname</p>
from authors, publishers</p>
where authors.city = publishers.city</p>
</p>
Необходимо помнить, что, как и в любом операторе выбора, названия столбцов в списке выбора и названия таблиц в предложении (конструкции) from должны разделяться запятыми.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Предложение from</td></tr></table></div></p>
В предложении from оператора соединения указываются названия всех таблиц и вьюверов, участвующих в соединении. Именно это предложение указывает SQL Серверу, что необходимо выполнить соединение. Таблицы и вьюверы в этом предложении можно указывать в произвольном порядке. Порядок расположения названий таблиц влияет на результат только при использовании сокращения “*” в списке выбора.</p>
В предложении from можно указывать от 2 до 16 отдельных названий для таблиц или выюверов. При подсчете максимально допустимого числа нужно учитывать, что отдельным членом этого предложения считаются следующие названия:</p>
</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Название таблицы (или вьювера), указанное в предложении from;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Каждая копия названия одной и той же таблицы (самосоединение);</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Название таблицы, указанное в подзапросе;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Названия базовых таблиц, на которые ссылаются вьюверы, указанные в     предложении from.</td></tr></table></div></p>
Соединения, в которых участвует более двух таблиц, рассматриваются далее в главе “Соединение более двух таблиц”.</p>
Как отмечалось во второй главе “Запросы: Выбор данных из таблицы”, названия таблиц и вьюверов могут уточняться названием владельца и названием базы данных.</p>
Вьюверы можно использовать точно также, как и таблицы. В главе 9 будут рассмотрены вьюверы, но во всех приводимых там примерах будут использоваться только таблицы.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Предложение where</td></tr></table></div></p>
В предложении where (где) указываются отношения, которые устанавливаются между таблицами, перечисленными в предложении from, для выбора результирующих строк. В нем приводятся названия столбцов, по которым производится соединение, дополненные при необходимости названиями таблиц, и операция сравнения, которой обычно является равенство, но иногда здесь могут встречаться и отношения “больше чем” или “меньше чем”. Детальное описание синтаксиса предложения where приводится в главе 2 этого руководства и в главе “Предложение where” в Справочном руководстве SQL Сервера.</p>
</p>
Замечание. Можно получить совершенно неожиданный результат, если опустить предложение where в операторе соединения. Без этого предложения все вышеприведенные запросы на соединение будут выдавать 27 строк вместо 2. В следующем разделе будет объяснено почему так происходит.</p>
</p>
Соединения, в которых данные сравниваются на совпадение, называются эквисоединениями (equijoins). Более точное определение эквисоединения дается позже в этой главе, также как и примеры соединений, основанных не на равенстве.</p>
Соединение может основываться на следующих операциях сравнения:</p>
</p>
Таблица 4.1. Операции сравнения</p>
</p>
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
</p>
Соединения, основанные на операциях сравнения, в общем называются тетасоединениями (theta joins). Другой класс соединений образуют внешние соединения, которые рассматриваются позже в этой же главе. К числу внешних операций соединения относятся следующие операции.</p>
</p>
Таблица 4.2. Операции внешнего соединения</p>
</p>
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
</p>
Названия соединяемых столбцов могут не совпадать, хотя на практике они часто совпадают. Кроме того, они могут содержать данные различных типов (см. главу 7).</p>
Однако, если типы данных не совпадают, то они должны быть совместимыми, чтобы SQL Сервер мог автоматически преобразовать их между собой. Например, SQL Сервер автоматически преобразует друг в друга любые числовые типы данных: int, smallint, tinyint, decimal, float, а также любые строковые типы и типы даты: char, varchar, nchar, nvarchar  и datetime.  Более детально преобразование типов рассматривается в главе 10 “Использование встроенных функций в запросах” и в главе “Функции преобразования типов данных” Справочного руководства SQL Сервера.</p>
</p>
Замечание. Таблицы нельзя соединять по текстовым или графическим полям. Однако можно сравнивать длины текстовых полей в предложении where, например, следующим образом:</p>
</p>
where datalength(textab_1.textcol) &gt; datalength(textab_2.textcol)</p>
</p>
Предложение where оператора соединения может включать и другие условия, отличные от условия соединения. Другими словами, операторы соединения и выбора можно объединить в одном SQL операторе. Далее в этой главе будут приведены соответствующие примеры.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Как выполнются соединения</td></tr></table></div></p>
Знание того, как выполняется соединения помогает в их понимании и позволяет объяснить, почему получаются неожиданные результаты, когда соединение задано неправильно. В этом разделе описывается процесс выполнения соединения в концептуальном плане. Конечно, SQL Сервер выполняет эту процедуру более сложным образом.</p>
Вообще говоря, первый шаг в выполнении соединения состоит в образовании декартова произведения таблиц, т.е. в образовании всех возможных комбинаций строк этих таблиц друг с другом. Число строк в декартовом (прямом) произведении двух таблиц, равно произведению числа строк в первой таблице на число строк во второй таблице.</p>
Например, число строк в декартовом произведении таблиц author и publishers равно 69 ( 23 автора, умноженные на 3 издателя).</p>
Декартово произведение строится в любом запросе, который содержит более одной таблицы в списке выбора, более одной таблицы в предложении from и не содержит предложения where. Например, если убрать предложение where из предыдущего запроса на соединение, то SQL Сервер скомбинирует 23 автора с 3 издателями и возвратит в результате 69 строк.</p>
Декартово произведение не содержит какой-либо полезной информации. На самом деле оно даже вводит в заблуждение, поскольку создает видимость, что каждый автор имеет отношение к каждому издателю, что совершенно неверно.</p>
По этой причине соединение должно включать предложение where, которое отбирает связанные между собой строки и указывает как именно они должны быть связаны. Оно может включать также дополнительные ограничения. Из декартового произведения происходит удаление тех строк, которые не удовлетворяют условиям в предложении where.</p>
В предыдущем примере предложение where удаляет те строки, в которых город, где проживает автор, отличен от города, где живет  издатель.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Еквисоединения и естественные соединения</td></tr></table></div></p>
Еквисоединением называется соединение, в котором данные в столбцах сравниваются на равенство, и все столбцы соединяемых таблиц включаются в результат.</p>
Запрос, который был рассмотрен ранее:</p>
</p>
select *</p>
from authors, publishers</p>
where authors.city = publishers.city</p>
</p>
является примером еквисоединения. В результате этого запроса столбец city появляется дважды. Из определения следует, что результат эквисоединения содержит два одинаковых столбца. Поскольку обычно нет необходимости повторять одну и ту же информацию, то один из этих столбцов можно удалить путем модификации запроса. Результат этой модификации, показанный далее, называется естественным соединением.</p>
</p>
select publishers.pub_id, publishers.pub_name, publishers.state, authors.*</p>
from publishers, authors</p>
where publishers.city = authors.city</p>
</p>
В этом примере столбец publishers.city уже не появится в результате запроса.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Соединения с дополнительными условиями</td></tr></table></div></p>
Предложение where запроса на соединение может содержать кроме условия соединения, также дополнительные критерии отбора. Например, для выбора названий и издателей всех книг, по которым был выплачен аванс больший чем 7500 долларов, можно воспользоваться следующим запросом:</p>
</p>
select title, pub_name, advance</p>
from titles, publishers</p>
where titles.pub_id = publishers.pub_id and advance &gt; $7500</p>
</p>
title                                                            pub_name                           advance</p>
----------------------------------------------        ----------------------------        -------------</p>
You Can Combat Computer Stress!          New Age Books                10,125.00</p>
The Gourmet        Microwave                Binnet &amp; Hardley                15,000.00</p>
Secrets of Silicon Valley                      Algodata Infosystems         8,000.00</p>
Sushi, Anyone?                        Binnet &amp; Hardley                 8,000.00</p>
</p>
(Выбрано 4 строки)</p>
</p>
Заметим, что столбцы, по которым происходит соединение, не обязательно должны включаться в список выбора, поэтому в данном случае их нет в результате.</p>
В оператор соединения можно включать произвольное число дополнительных критериев отбора. Порядок следования этих критериев и условия соединения не имеет значения.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Соединения, не основанные на равенстве</td></tr></table></div></p>
Условие соединения таблиц не обязательно является равенством. Здесь можно использовать любую другую операцию сравнения: не равно (!=), больше чем (&gt;), меньше чем (&lt;), больше или равно (&gt;=), меньше или равно (&lt;=). Язык Transact-SQL также содержит операции !&gt; и !&lt; , которые эквивалентны операциям меньше или равно и больше или равно соответственно.</p>
В следующем примере используется операция “больше чем” для нахождения авторов, которые публиковались издательством New Age Books и которые живут в штатах, названия которых больше чем название штата Массачусетс (в алфавитном порядке):</p>
</p>
select pub_name, publishers.state, au_lname, au_fname, authors.state</p>
from publishers, authors</p>
where authors.state &gt; publishers.state and pub_name = "New Age Books"</p>
</p>
pub_name        state           au_lname               au_fname        state</p>
---------------------        ------        -----------------        ----------------        -----</p>
New Age Books        MA      Greene                 Morningstar        TN</p>
New Age Books        MA      Blotchet-Halls         Reginald        OR</p>
New Age Books        MA      del Castillo             Innes                MI</p>
New Age Books        MA      Panteley                Sylvia                MD</p>
New Age Books        MA      Ringer                  Anne                UT</p>
New Age Books        MA      Ringer                  Albert                UT</p>
</p>
(Выбрано 6 строк)</p>
</p>
В следующем примере в соединении используются операции &gt;= и &lt;  для правильного нахождения скидок (royalty) в таблице roysched, связанных с общим объемом продаж:</p>
</p>
select t.title_id, t.total_sales, r.royalty</p>
from titles t, roysched r</p>
where t.title_id = r.title_id and t.total_sales &gt;= r.lorange and t.total_sales &lt; r.hirange</p>
</p>
title_id                total_sales        royalty</p>
-----------                -----------        -------         ----------</p>
BU1032                 4095                10</p>
BU1111                 3876                10</p>
BU2075                 1872                24</p>
BU7832                 4095                10</p>
MC2222                 2032                12</p>
MC3021                22246                24</p>
PC1035                 8780                16</p>
PC8888                 4095                10</p>
PS1372                  375                10</p>
PS2091                 2045                12</p>
PS2106                  111                10</p>
PS3333                 4072                10</p>
PS7777                 3336                10</p>
TC3218                  375                10</p>
TC4203                15096                14</p>
TC7777                 4095                10</p>
</p>
(Выбрано 16 строк)</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Самосоединения и корреляция названий</td></tr></table></div></p>
Можно соединять между собой столбцы одной и той же таблицы с помощью самосоединения (self-join). Например, можно использовать самосоединение для нахождения авторов, живущих в городе Окленде штата Калифорния в одном и том же почтовом округе.</p>
Поскольку этот запрос включает столбцы одной таблицы authors, то эта таблица выступает в двух ролях. Чтобы различить эти роли, необходимо временно присвоить ей в предложении from различные коррелирующиеся (согласующиеся) названия, такие как au1 и au2. Эти согласующиеся названия будут использоваться для уточнения названий столбцов в следующем запросе. В этом случае самосоединение выглядит следующим образом:</p>
</p>
select au1.au_fname, au1.au_lname, au2.au_fname, au2.au_lname</p>
from authors au1, authors au2</p>
where au1.city = "Oakland" and au2.city = "Oakland"</p>
and au1.state = "CA" and au2.state = "CA"</p>
and au1.postalcode = au2.postalcode</p>
</p>
au_fname   au_lname  au_fname     au_lname</p>
------------    -----------   -----------      ------------</p>
Marjorie     Green           Marjorie    Green</p>
Dick           Straight        Dick           Straight</p>
Dick           Straight        Dirk           Stringer</p>
Dick           Straight        Livia          Karsen</p>
Dirk           Stringer        Dick           Straight</p>
Dirk           Stringer        Dirk           Stringer</p>
Dirk           Stringer        Livia          Karsen</p>
Stearns       MacFeather  Stearns      MacFeather</p>
Livia          Karsen          Dick          Straight</p>
Livia          Karsen          Dirk          Stringer</p>
Livia          Karsen          Livia         Karsen</p>
</p>
(Выбрано 11 строк)</p>
</p>
Чтобы исключить из результатов этого запроса строки, в которых авторы соединяются сами с собой, а также строки, отличающиеся лишь порядком следования авторов, необходимо добавить в самосоединение дополнительное условие:</p>
</p>
select au1.au_fname, au1.au_lname, au2.au_fname, au2.au_lname</p>
from authors au1, authors au2</p>
where au1.city = "Oakland" and au2.city = "Oakland"</p>
and au1.state = "CA" and au2.state = "CA"</p>
and au1.postalcode = au2.postalcode</p>
and au1.au_id &lt; au2.au_id</p>
</p>
au_fname   au_lname    au_fname  au_lname</p>
---------       -----------     -----------   ----------</p>
Dick                Straight       Dirk           Stringer</p>
Dick                  Straight       Livia          Karsen</p>
Dirk           Stringer       Livia          Karsen</p>
</p>
                    (Выбрано 3 строки)</p>
</p>
Теперь понятно, что Дик Страйт, Дик Стрингер и Ливия Карсен живут в одном и том же почтовом округе.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Соединения с условием “не равно”</td></tr></table></div></p>
 Условие “не равно” особенно полезно для отбора строк при</p>
самосоединении. Например, это условие используется в следующем самосоединении для нахождения всех категорий (типов) книг, в которых есть по крайней мере две недорогих (меньше чем 15 долларов) книги с различными ценами:</p>
</p>
select distinct t1.type, t1.price</p>
from titles t1, titles t2</p>
where t1.price &lt;$15 and t2.price &lt;$15</p>
and t1.type = t2.type</p>
and t1.price != t2.price</p>
</p>
type                          price</p>
----------              --------</p>
business          2.99</p>
business             11.95</p>
psychology           7.00</p>
psychology           7.99</p>
psychology          10.95</p>
trad_cook          11.95</p>
trad_cook           14.99</p>
</p>
                      (Выбрано 7 строк)</p>
</p>
Замечание. Выражение “not название_столбца1 = название_столбца2” эквивалентно выражению “название_столбца1 != название_столбца2”.</p>
</p>
В следующем примере соединение с условием “не равно” комбинируется с самосоединением. В этом запросе ищутся строки в таблице titleauthor, у которых одинаково значение поля title_id, но различно значение поля au_id, т.е. ищутся книги, у которых, по крайней мере, два автора.</p>
</p>
select distinct t1.au_id, t1.title_id</p>
from titleauthor t1, titleauthor t2</p>
where t1.title_id = t2.title_id and t1.au_id != t2.au_id</p>
order by t1.title_id</p>
</p>
au_id               title_id</p>
----------------      -----------</p>
213-46-8915      BU1032</p>
409-56-7008      BU1032</p>
267-41-2394      BU1111</p>
724-80-9391      BU1111</p>
722-51-5454      MC3021</p>
899-46-2035      MC3021</p>
427-17-2319      PC8888</p>
846-92-7186      PC8888</p>
724-80-9391      PS1372</p>
756-30-7391      PS1372</p>
899-46-2035      PS2091</p>
998-72-3567      PS2091</p>
267-41-2394      TC7777</p>
472-27-2349      TC7777</p>
672-71-3249      TC7777</p>
</p>
(Выбрано 15 строк)</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Соединения с условием “не равно” и подзапросы</td></tr></table></div>Иногда соединения с условием “не равно” бывает недостаточно и его необходимо заменить подзапросом. Например, предположим, что необходимо получить список авторов, которые живут в городах, где нет издательств. Для простоты ограничим этот список авторами, фамилии которых начинаются на буквы “А”, “В” и “С”. Запрос с условием “не равно” может иметь следующий вид:</p>
</p>
select distinct au_lname, authors.city</p>
from publishers, authors</p>
where au_lname like "[ABC]%" and publishers.city != authors.city</p>
</p>
Но получаемые на него результаты вовсе не являются ответом на этот вопрос!</p>
au_lname             city</p>
----------------         ------------</p>
Bennet               Berkeley</p>
Carson               Berkeley</p>
Blotchet-Halls       Corvallis</p>
</p>
Система интерпретирует этот SQL оператор следующим образом: “Найти фамилии авторов, которые живут в городе, в котором нет некоторого издательства”. Все авторы, имеющиеся в таблице, удовлетворяют этому условию, включая авторов, живущих в Беркли, в котором расположено издательство Algodata Inforsystems.</p>
В этом случае способ, которым система выполняет соединение (предварительно строя все возможные комбинации с последующей проверкой остальных условий), является причиной появления нежелательного результата. В случаях подобных этому необходимо использовать подзапрос для получения желаемого результата. Подзапрос может выполнить предварительное удаление ненужных строк, а затем уже будет выполняться последующий отбор.</p>
Правильный оператор будет иметь следующий вид:</p>
</p>
select distinct au_lname, city</p>
from authors</p>
where au_lname like "[ABC]%" and city not in</p>
(select city from publishers</p>
where authors.city = publishers.city)</p>
</p>
Теперь получается нужный результат:</p>
</p>
au_lname             city</p>
-------------------      ------------</p>
Blotchet-Halls       Corvallis</p>
</p>
                    (Выбрана 1 строка)</p>
</p>
Подзапросы будут подробно рассмотрены в главе 6.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Соединение более чем двух таблиц</td></tr></table></div></p>
Таблица titleauthor базы pubs2 дает хороший пример ситуации, в которой полезно соединить более чем две таблицы. Чтобы найти названия всех книг заданного типа и имена их авторов, можно использовать следующий запрос:</p>
</p>
select au_lname, au_fname, title</p>
from authors, titles, titleauthor</p>
where authors.au_id = titleauthor.au_id</p>
and titles.title_id = titleauthor.title_id</p>
and titles.type = "trad_cook"</p>
</p>
au_lname            au_fname       title</p>
--------------        -----------        -----------------------------------------------</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 189px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="95">Panteley</td><td>Sylvia            Onions, Leeks, and Garlic: Сooking      Secrets of the Mediterranean</td></tr></table></div>Blotchet-Halls      Reginald       Fifty Years in Buckingham Palace                                                       Kitchens</p>
O'Leary                Michael          Sushi, Anyone?</p>
Gringlesby             Burt                Sushi, Anyone?</p>
Yokomoto             Akiko             Sushi, Anyone?</p>
</p>
(Выбрано 5 строк)</p>
</p>
Заметим, что одна из таблиц в предложении from, а именно titleauthor, не передает в окончательный результат свои данные, поскольку ни данные из столбца au_id, ни данные из столбца title_id  не включены в результат. Однако само соединение стало возможным лишь при использовании этой таблицы как промежуточной.</p>
В одном операторе можно также соединять по более чем двум столбцам. Например, в следующем запросе показан общий объем продаж каждой книги, интервал в который попадает этот объем, и результирующая скидка:</p>
</p>
select titles.title_id, total_sales, lorange, hirange, royalty</p>
from titles, roysched</p>
where titles.title_id = roysched.title_id</p>
  and total_sales &gt;= lorange and total_sales &lt; hirange</p>
</p>
title_id        total_sales           lorange            hirange               royalty</p>
-----------------------        ----------                     -------               ----</p>
 BU1032          4095                      0                 5000                10</p>
 BU1111          3876                      0                 4000                10</p>
 BU2075        18722                14001                50000                24</p>
 BU7832          4095                      0                 5000                10</p>
 MC2222  2032                 2001                 4000              12</p>
 MC3021  2224                12001                50000                      24</p>
 PC1035          8780                 4001                10000                16</p>
 PC8888          4095                      0                 5000                10</p>
 PS1372            375                      0                 10000                10</p>
 PS2091          2045                 1001                 5000                12</p>
 PS2106            111                      0                 2000                10</p>
 PS3333          4072                      0                 5000                10</p>
 PS7777          3336                      0                 5000                10</p>
 TC3218            375                      0                 2000                10</p>
 TC4203         15096                 8001                6000                14</p>
 TC7777          4095                      0                 5000                10</p>
</p>
                       (Выбрано 16 строк)</p>
</p>
Когда в одном операторе совмещаются несколько соединений или когда соединяются более двух таблиц, “соединительные выражения” обычно связываются логической операцией and (И), как это было в предыдущих примерах. Однако, их можно связывать и логической операции or (ИЛИ).</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Внешние соединения</td></tr></table></div></p>
В рассматриваемых ранее соединениях в результат включались только строки, которые удовлетворяли условию соединения. По существу эти соединения исключали информацию, которая содержалась в строках, которые не удовлетворяли этому условию.</p>
Однако, иногда, в результат желательно включить именно информацию, которая содержится в этих строках. В таких случаях нужно использовать внешнее соединение. Язык Transact-SQL является одной из версий языка SQL, которая содержит внешние соединения.</p>
Операции внешнего соединения в языке Transact-SQL имеют следующий вид:</p>
</p>
Таблица 4.3. Список операций внешнего соединения</p>
</p>
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
</p>
Напомним, что запрос, в котором искались авторы, проживающие в одном городе с издателем, возращал двух людей: Абрахама Беннета и Черил Карсон. Чтобы включить в результат всех авторов независимо от местонахождения издателя, необходимо использовать внешнее соединение. Соответствующий запрос и его результаты имеют следующий вид:</p>
</p>
select au_fname, au_lname, pub_name</p>
from authors, publishers</p>
where authors.city *= publishers.city</p>
</p>
au_fname      au_lname         pub_name</p>
-----------        --------------      ----------------------------</p>
Johnson         White             NULL</p>
Marjorie        Green             NULL</p>
Cheryl           Carson            Algodata Infosystems</p>
Michael         O'Leary          NULL</p>
Dick              Straight           NULL</p>
Meander        Smith              NULL</p>
Abraham       Bennet            Algodata Infosystems</p>
Ann               Dull                 NULL</p>
Burt              Gringlesby       NULL</p>
Chastity        Locksley          NULL</p>
Morningstar  Greene             NULL</p>
Reginald       Blotche-Halls   NULL</p>
Akiko           Yokomoto        NULL</p>
Innes            del Castillo       NULL</p>
Michel         DeFrance          NULL</p>
Dirk             Stringer            NULL</p>
Stearns         MacFeather      NULL</p>
Livia            Karsen              NULL</p>
Sylvia          Panteley            NULL</p>
Sheryl          Hunter              NULL</p>
Heather        McBadden       NULL</p>
Anne           Ringer               NULL</p>
Albert         Ringer               NULL</p>
</p>
(Выбраны 23 строки)</p>
</p>
Операция сравнения “*=” отличает внешнее соединение от обычного. Это “левое” внешнее соединение, которое сообщает SQL Серверу, что необходимо включить в результат все строки первой таблицы authors, независимо от результата сравнения их с полем city таблицы publishers. Заметим, что для большинства авторов результат сравнения отрицательный, поэтому в столбец pub_name в этом случае записывается неопределенное значение NULL. Заметим также, что правая таблица publishers  называется в этом случае внутренней таблицей внешнего соединения.</p>
</p>
</p>
Замечание. Поскольку столбцы с данными типа “бит” не допускают неопределенных значений, то при их внешнем соединении в соответствующих позициях записывается “0”.</p>
</p>
“Правое” внешнее соединение задается операцией сравнения “=*”, которая указывает, что в результат должны включаться все строки из второй таблицы независимо от выполнения условия сравнения с соответствующим полем первой таблицы. В этом случае первая таблица называется внутренней.</p>
Если ввести эту операцию в предыдущий запрос, то получим следующий результат:</p>
</p>
select au_fname, au_lname, pub_name</p>
from authors, publishers</p>
where authors.city =* publishers.city</p>
</p>
au_fname     au_lname    pub_name</p>
---------        ---------       --------------------</p>
NULL         NULL        New Age Books</p>
NULL         NULL        Binnet &amp; Hardley</p>
Cheryl         Carson      Algodata Infosystems</p>
Abraham     Bennet      Algodata Infosystems</p>
</p>
(Выбраны 4 строки)</p>
</p>
Можно и дальше уточнять результаты внешнего соединения путем сравнения их с константой. Это означает, что точно будут указываться только те величины, которые действительно необходимы, а остальные как бы оказываются за чертой. Для примера рассмотрим сначала эквисоединение, а затем сравним его с внешним соединением. Предположим, что необходимо найти все книги, объем продаж которых в некотором магазине оказался больше 500 экземпляров:</p>
</p>
select distinct salesdetail.stor_id, title</p>
from titles, salesdetail</p>
where qty &gt; 500</p>
and salesdetail.title_id = titles.title_id</p>
</p>
stor_id      title</p>
-------       ------------------------------------------------------------------------</p>
5023       Sushi, Anyone?</p>
5023       Is Anger the Enemy?</p>
5023       The Gourmet Microwave</p>
5023       But Is It User Friendly?</p>
5023       Secrets of Silicon Valley</p>
5023       Straight Talk About Computers</p>
5023       You Can Combat Computer Stress!</p>
5023       Silicon Valley Gastronomic Treats</p>
5023       Emotional Security: A New Algorithm</p>
5023       The Busy Executive's Database Guide</p>
5023       Fifty Years in Buckingham Palace Kitchens</p>
5023       Prolonged Data Deprivation: Four Case Studies</p>
5023       Cooking with Computers: Surreptitious Balance Sheets</p>
7067       Fifty Years in Buckingham Palace Kitchens</p>
</p>
(Выбрано 14 строк)</p>
</p>
Чтобы увидеть кроме того книги, объем продаж которых ни в одном магазине не был больше 500 экземпляров, можно использовать внешнее соединение:</p>
</p>
select distinct salesdetail.stor_id, title</p>
from titles, salesdetail</p>
where qty &gt; 500</p>
and salesdetail.title_id =* titles.title_id</p>
</p>
 stor_id     title</p>
 -------       ---------- ------------------------------------------------------------</p>
 NULL      Net Etiquette</p>
 NULL      Life Without Fear</p>
 5023        Sushi, Anyone?</p>
 5023        Is Anger the Enemy?</p>
 5023        The Gourmet Microwave</p>
 5023        But Is It User Friendly?</p>
 5023        Secrets of Silicon Valley</p>
 5023        Straight Talk About Computers</p>
 5023        You Can Combat Computer Stress!</p>
 5023        Silicon Valley Gastronomic Treats</p>
 5023       Emotional Security: A New Algorithm</p>
 5023       The Busy Executive's Database Guide</p>
 5023       Fifty Years in Buckingham Palace Kitchens</p>
 7067       Fifty Years in Buckingham Palace Kitchens</p>
 5023       Prolonged Data Deprivation: Four Case Studies</p>
 5023       Cooking with Computers: Surreptitious Balance Sheets</p>
 NULL     Computer Phobic and Non-Phobic Individuals: Behavior Variations</p>
 NULL      Onions, Leeks, and Garlic: Cooking Secrets of the Mediterranean</p>
</p>
(Выбрано 18 строк)</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Ограничения на внешнее соединение</td></tr></table></div></p>
В языке Transact-SQL нельзя одну таблицу использовать и во внешнем соединении и в обычном соединении. Следующий запрос является ошибочным, поскольку таблица salesdetail участвует одновременно в двух соединениях:</p>
</p>
select distinct sales.stor_id, stor_name, title</p>
from sales, stores, titles, salesdetail</p>
where qty &gt; 500</p>
and salesdetail.title_id =* titles.title_id</p>
and sales.stor_id = salesdetail.stor_id</p>
and sales.stor_id = stores.stor_id</p>
</p>
Msg 303, Level 16, State 1:</p>
Server 'RAW', Line 1:</p>
The table 'salesdetail' is an inner member of an outer-join clause. This is not allowed if the table also participates in a regular join clause.</p>
</p>
(Таблица &#8216;salesdetail&#8217; является внутренним членом внешнего соединения. Это недопустимо, поскольку эта таблица также участвует в обычном соединении.)</p>
</p>
Если необходимо определить название магазина, продавшего более 500 экземпляров некоторой книги, нужно сделать второй запрос. Если запрос с внешним соединением содержит также условие отбора по столбцу внутренней таблицы, то  могут получиться неожиданные результаты. В этом случае условие отбора не повлияет на число выводимых строк, но приведет к появлению неопределенных значений в столбцах внутренней таблицы в тех строках, которые не удовлетворяют этому условию.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Как неопределенные значения влияют на соединения</td></tr></table></div></p>
Если в столбцах соединяемых таблиц имеются неопределенные значения, то они будут всегда давать отрицательный результат при сравнении. В частности, отрицательный результат будет получаться и при сравнении значения NULL с NULL. Поскольку значение NULL представляет собой неизвестное или невозможное значение, то нет никаких оснований надеяться, что две неизвестные величины совпадают друг с другом.</p>
Присутствие неопределенных значений в соединяемых таблицах можно обнаружить только при внешнем соединении.  Здесь для примера приведены две таблицы, каждая из которых содержит неопределенные значения в столбцах, которые участвуют в соединении. При левом внешнем соединении можно увидеть неопределенные значения в первой таблице.</p>
</p>
Таблица 1:</p>
 a                   b</p>
------------      --------</p>
        1           one</p>
   NULL        three</p>
        4           join4</p>
</p>
Таблица 2:</p>
c                   d</p>
---------         -------</p>
   NULL       two</p>
        4          four</p>
</p>
Левое внешнее соединение:</p>
select *</p>
from t1, t2</p>
where a *= c</p>
</p>
 a          b           c             d</p>
 -------  -------     --------     --------</p>
     1      one       NULL     NULL</p>
NULL  three      NULL     NULL</p>
     4     join4               4     four</p>
</p>
Заметим, что в этом результате непросто различить неопределенные значения, имеющиеся в таблице, от неопределенных значений, появившихся в результате соединения. Поэтому, когда в таблице имеются неопределенные значения, лучше удалить их из результатов путем использования обычного соединения.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Как выбираются столбцы для соединения таблиц</td></tr></table></div></p>
Имеется системная процедура SP_HELPJOINS, которая указывает наиболее подходящие для соединения столбцы двух таблиц. Ее можно вызвать с помощью  следующей команды:</p>
</p>
sp_helpjoins таблица1, таблица2</p>
</p>
Например, можно вызвать эту процедуру с таблицами titleauthor и titles в качестве аргументов:</p>
</p>
sp_helpjoins titleauthor, titles</p>
</p>
Процедура SP_HELPJOINS выбирает пары столбцов для соединения на основе двух условий. Во-первых, просматривается таблица syskeys (системные ключи) текущей базы даных для поиска ключей импорта (foreign keys) процедурой SP_FOREIGNKEY. Затем проверяется есть ли у этих таблиц общие ключи с помощью процедуры SP_COMMONKEY. Если общих ключей нет, то ищутся любые ключи, подходящие для соединения. Наконец, если таких ключей найти не удалось, то выбираются столбцы с одинаковым названием или одинаковым типом данных.</p>
Более полная информация о системных процедурах дается в Справочном руководстве по SQL Серверу.</p>
