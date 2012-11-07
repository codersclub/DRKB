<h1>XML: будущее гипертекста?</h1>
<div class="date">01.01.2007</div>


<p>XML: будущее гипертекста?</p>
Дмитрий Шипилов, www.submarine.ru</p>
Спросите у любого среднестатистического пользователя компьютера, на чем базируется Internet, с помощью чего создаются Web-странички и размещаются на них данные. Скорее всего, вам скажут о языке разметки гипертекста HTML. На сегодняшний день это, пожалуй, верно. Однако все большую популярность на глазах приобретает сравнительно новая спецификация - XML. Судя по всему, будущее именно за этим языком. А значит, неплохо было бы познакомиться с ним поближе. Нет проблем!</p>
Как известно, прародителем HTML был язык SGML (Standard Generalized Markup Language - стандартизованный обобщенный язык разметки), созданный в 60-х годах группой разработчиков компании IBM. Целью проекта был перенос документов между различными платформами и системами. Первым результатом деятельности группы, основными разработчиками в которой были Чарльз Голдфарб, Эд Мошер и Рэй Лори, стал язык GML (Generalized Markup Language - обобщенный язык разметки), предназначенный для документов на платформе IBM. Несколько лет спустя GML распространился на другие, помимо IBM, платформы. В 1986 г. язык GML попал под патронаж Международной организации стандартизации ISO и под именем SGML стал официальным стандартом (ISO 8879).</p>
В последнее время сотрудники Internet-консорциума W3C осознали, что язык HTML уже не может разрешить все проблемы и задачи, возлагаемые на него постоянно развивающимся миром Internet. Возникла необходимость в расширяемой (в отличие от статической в HTML) системе разметки, которая позволила бы создавать максимально приближенную к содержанию и тематике документа разметку. Применять SGML в подобном случае непрактично, что и послужило причиной создания XML (eXtensible Markup Language). Язык XML позволяет объединить достоинства SGML и HTML, однако его возможности простираются за пределы Internet и разметки.</p>
 <br>
<p>Сайт Wall Street Journal Interactive edition создан с помощью XML, затем преобразован в HTML при помощи технологии XSL</p>
В ближайшее время, прежде чем создать какую-нибудь страничку, разработчики сначала будут осмысливать, что именно им необходимо создать. На основе поставленной задачи и разрабатывается словарь DTD, при использовании которого и появится конечный документ как для публикации в Сети, так и для любой другой электронной презентации.</p>
Разметка<br>
<p></p>
Прежде всего необходимо понять, что же такое разметка. Рассмотрим небольшой фрагмент текста:</p>
Глава 1. "WWW"</p>
Рождение WWW произошло в Европейской лаборатории физики частиц (CERN - European Laboratory for Particle Physics), находящейся в Швейцарии.</p>
Применяя какой-нибудь язык разметки, мы могли бы описать данный фрагмент следующим образом:</p>

<pre>
&lt;BOOK&gt;
&lt;CHAPTER NUMBER=1&gt;
&lt;TITLE&gt;WWW&lt;/TITLE&gt;
&lt;PARAGRAPH&gt;
Рождение WWW произошло в Европейской лаборатории физики частиц (CERN &#8212; European Laboratory for Particle Physics), находящейся в Швейцарии.
&lt;/PARAGRAPH&gt;
&lt;/CHAPTER&gt;
&lt;/BOOK&gt;
</pre>

<p>Парными тегами &lt;BOOK&gt; и &lt;/BOOK&gt; мы сообщаем, что описываем книгу (или отрывок из нее). Теги &lt;CHAPTER&gt; и &lt;/CHAPTER&gt; заключают внутри себя одну главу книги. Параметр NUMBER сообщает о номере главы. Теги &lt;TITLE&gt; и &lt;/TITLE&gt; определяют название главы, и наконец внутри пары тегов &lt;PARAGRAPH&gt; и &lt;/PARAGRAPH&gt; мы можем поместить текст абзаца.</p>
Document Type Definition (DTD) и сам XML-документ<br>
<p></p>
Любой документ на XML состоит из двух взаимосвязанных составляющих - описания разметки в DTD и собственно самого документа, который описан с помощью этой разметки.</p>
DTD описывает словарь, которым будет пользоваться разработчик документа. В этот словарь входят определения всех элементов и их атрибутов, разнообразные объекты (например, графические файлы или нестандартные символы), а также правила, определяющие взаимодействие всех этих элементов языка. DTD написаны с помощью специальных правил, напоминающих конструкции SGML. При написании XML-документа необходимо указать DTD-словарь, который используется, и далее строго придерживаться этих правил. Последняя версия HTML 4.0 была также описана с помощью DTD, что показывает дальнейшее развитие языка HTML. HTML не умрет, он не будет полностью заменен XML. HTML станет лишь еще одним DTD-словарем XML.</p>
Рассмотрим компоненты, из которых состоит любой язык разметки и которые будут описываться в DTD.</p>
Первым и основным компонентом является элемент. Элементы - ключевые структуры XML. Они указываются в разметке с помощью тегов, логически определяющих структуру документа - &lt;P&gt;...&lt;/P&gt;, &lt;BR&gt;, &lt;H1&gt;...&lt;/H1&gt; и т. д. Все другие компоненты лишь дополняют и уточняют информацию об элементах.</p>
Атрибуты дают более конкретную информацию. В HTML, атрибуты чаще всего указывали, каким образом следует отобразить данный элемент. В XML же практически не используются атрибуты, описывающие форматирование документа - для этого применяются таблицы стилей, определяющие, как необходимо отобразить тот или иной элемент документа. Примерами могут служить атрибуты FACE, COLOR или SIZE тега &lt;FONT&gt;.</p>
Еще одним компонентом разметки XML являются объекты. Объекты могут быть набором каких-нибудь двоичных данных, графическим или звуковым файлом или специальным символом, не входящим в набор ASCII. Все используемые в XML-документе объекты (т. е., к примеру, все изображения и другие внешние объекты) должны быть описаны в DTD. С их помощью можно также объединять несколько XML-файлов в один и многое другое.</p>
Пока XML еще не стал стандартом в Сети, приходится выполнять преобразование из XML в HTML, сайт JavaLobby</p>
Следующим составляющим DTD являются модели содержания. Они определяют способ и правила вложенности тегов. Обратимся к HTML за примером - упорядоченный список помещается между тегами &lt;OL&gt; и &lt;/OL&gt;, элементы списка задаются внутри конструкции &lt;LI&gt; и &lt;/LI&gt;. Использовать какие-либо другие кроме &lt;LI&gt; теги сразу же после &lt;OL&gt; запрещено. Модели содержания в DTD указывают способ вложения тегов друг в друга, порядок вложения, количество экземпляров каждого тега, которое можно применять внутри какой-нибудь конструкции и т. д. Таким образом, поддерживается четкая структуризация документа. Вообще XML-интерпретаторы (в отличие от HTML-броузеров) очень строго следят за соблюдением правил, перечисленных в DTD. Если возникает какая-либо ошибка, интерпретация XML-документа прекращается и выводится соответствующее сообщение. Никаких поблажек и вольностей анализаторы XML не допускают.</p>
Гиперссылки являются неотделимым элементом Всемирной паутины. XML значительно расширяет возможности ссылок. С помощью специального механизма XLink создаются многонаправленные связи между документами. Ссылки могут указывать на любое заданное место в XML-документе, причем определить его можно по имени или по определенному фактору, например по контексту или положению в документе. Связи активируются самыми различными способами: при использовании автоматической активации или при включении связываемого документа в тело исходного XML-документа.</p>
XML-документы представляют собой текст, написанный с помощью языка разметки, который в свою очередь определен в соответствующем DTD-словаре. Единственным отличием в стиле написания от HTML являются непарные теги. Если в HTML тег принудительного возврата каретки, к примеру, записывался как &lt;BR&gt;, то в XML подобный тег выглядел бы как &lt;BR /&gt;. Также в XML изначально закладывались правила точной записи разметки. Иными словами, крайне важно соблюдать все правила, заданные в DTD. XML-интерпретаторы "не прощают" ошибок, и некорректно написанный документ просто не будет отображаться. К самым частым ошибкам бывших HTML-кодеров относятся потери закрывающих тегов и нарушение последовательности тегов.</p>
Свой язык собственными руками<br>
<p></p>
Для осознания сути XML создадим на его основе свой собственный язык разметки, предназначенный для описания, скажем, набора видеокассет. Будем использовать следующие элементы языка:</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>TAPE - определяет запись о кассете;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>RUSSIANTITLE - название фильма в русскоязычном прокате;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>ORIGINALTITLE - оригинальное название фильма;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>COUNTRY - страна - производитель фильма;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>YEAR - год выпуска;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>TIME - длительность фильма;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>DIRECTOR - режиссер;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>STARRINGLIST - список актеров;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>ACTOR - имя актера, из списка актеров;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>CATEGORY - жанр;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>RATING - оценка;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>COMMENTS - комментарий к фильму.</td></tr></table></div>Примером описания одного фильма на XML при использовании нашего словаря будет:</p>

<pre>
&lt;TAPE&gt;
&lt;RUSSIANTITLE&gt;Чужой &lt;/RUSSIANTITLE&gt;
&lt;ORIGINALTITLE&gt;Alien &lt;/ORIGINALTITLE&gt;
&lt;COUNTRY&gt;Великобритания &#8212; США&lt;/COUNTRY&gt;
&lt;YEAR VALUE="1979" /&gt;
&lt;TIME VALUE="117" /&gt;
&lt;DIRECTOR&gt;Ридли Скотт&lt;/DIRECTOR&gt;
&lt;STARRINGLIST&gt;
&lt;ACTOR&gt;Сигурни Уивер&lt;/ACTOR&gt;
&lt;ACTOR&gt;Том Скеррит&lt;/ACTOR&gt;
&lt;ACTOR&gt;Яфет Котто&lt;/ACTOR&gt;
&lt;ACTOR&gt;Джон Хёрт&lt;/ACTOR&gt;
&lt;/STARRINGLIST&gt;
&lt;CATEGORY CLASS="SCIFI" /&gt;
&lt;RATING NUMBER="5" /&gt;
&lt;/TAPE&gt;
</pre>

Для использования подобного языка разметки необходимо определить DTD-словарь. Поместим его в файл video.dtd. Ниже подробно рассматриваются все шаги по созданию DTD-словаря.</p>

Описание элементов языка<br>
<p></p>
Для начала необходимо описать все использующиеся элементы языка. Делается это с помощью директивы &lt;!ELEMENT&gt;, которая имеет следующий формат:</p>

<pre>
&lt;!ELEMENT имя_элемента
(модель_содержания)&gt; 
</pre>

Модель содержания, заключенная в круглые скобки, сообщает, какие элементы или текст могут быть вложены в описываемый элемент. При ее задании используются следующие правила: сначала идет имя элемента, за ним следует знак препинания, который сообщает о правиле появления элемента.</p>
Значения знаков препинания:</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>запятая (,) - разделяет типы элементов в списке или последовательности;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>вертикальная черта (|) - разделяет элементы в списке;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>плюс (+) - указывает, что элемент будет использоваться один или более раз;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>вопросительный знак (?) - указывает, что элемент не будет использоваться или будет использоваться один раз;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>звездочка (*) - указывает, что элемент не будет использоваться или будет использоваться несколько раз.</td></tr></table></div>Примером может служить конструкция списка &lt;OL&gt; в HMTL, описание которой выглядело бы следующим образом:</p>
<pre>
&lt;!ELEMENT OL (LI+)&gt;
</pre>
Эта запись говорит о том, что элемент &lt;LI&gt; может встречаться внутри тега элемента &lt;OL&gt; один или несколько раз. Другой пример - конструкция &lt;DL&gt; (список определений), которая выглядела бы в DTD следующим образом:</p>
<pre>
&lt;!ELEMENT DL (DT, DD+)+&gt;
</pre>
Данная запись говорит о том, что элемент &lt;DL&gt; содержит один или несколько экземпляров элемента &lt;DT&gt;, сопровождаемых одним или несколькими экземплярами элемента &lt;DD&gt;. Поскольку знак плюс находится за скобками, он сообщает, что описанная в скобках конструкция может повторяться один или более одного раза. Использование запятой строго задает последовательность элементов, т. е. следующая запись для элемента &lt;HTML&gt; говорит, что сначала должен идти элемент &lt;HEAD&gt;, а затем элемент &lt;BODY&gt;:</p>
<pre>
&lt;!ELEMENT HTML (HEAD, BODY)&gt;
</pre>
Внутри элемента можно использовать не только другие элементы, но и какой-нибудь текст. Для этого предназначено специальное ключевое слово #PCDATA. Если элемент будет содержать только текст (например, элемент &lt;SUP&gt; из HTML), то его описание выглядит следующим образом:</p>
<pre>
&lt;!ELEMENT имя_элемента (#PCDATA)&gt;
</pre>
Если же внутри элемента присутствуют как текстовые данные, так и другие элементы, то употребляется следующая запись:</p>
<pre>
&lt;!ELEMENT имя_элемента (#PCDATA | элемент | элемент | элемент)*&gt;
</pre>
Она сообщает, что в описываемый элемент может входить в некотором количестве или не входить вообще простой текст и указанные в списке элементы.</p>
Еще одним вариантом описания модели содержания служит ключевое слово ANY, которое сообщает XML-интерпретатору, что элемент имеет произвольное содержание.</p>
 <br>
<p>После преобразования с помощью таблиц стилей XSL броузер получает XML-документ в формате HTML &#8212; сайт разработчиков программ Media Design in-Progress</p>
В директиве &lt;!ELEMENT&gt; можно указывать на то, что описываемый элемент является пустым или одиночным и он не требует закрывающих тегов. Примером из HTML служат теги &lt;BR&gt; или &lt;HR&gt;:</p>
<pre>
&lt;!ELEMENT HR EMPTY&gt;
</pre>
Таким образом, описание элементов нашего языка будет выглядеть следующим образом:</p>
<pre>
&lt;!ELEMENT TAPE (RUSSIANTITLE, ORIGINALTITLE, COUNTRY?, YEAR, TIME?, DIRECTOR, STARRINGLIST, CATEGORY, RATING, COMMENTS)&gt;
&lt;!ELEMENT RUSSIANTITLE (#PCDATA)&gt;
&lt;!ELEMENT ORIGINALTITLE (#PCDATA)&gt;
&lt;!ELEMENT COUNTRY (#PCDATA)&gt;
&lt;!ELEMENT YEAR EMPTY&gt;
&lt;!ELEMENT TIME EMPTY&gt;
&lt;!ELEMENT DIRECTOR (#PCDATA)&gt;
&lt;!ELEMENT STARRINGLIST (ACTOR+)&gt;
&lt;!ELEMENT ACTOR (#PCDATA)&gt;
&lt;!ELEMENT CATEGORY EMPTY&gt;
&lt;!ELEMENT RATING EMPTY&gt;
&lt;!ELEMENT COMMENTS (#PCDATA)&gt;
</pre>
Обратите внимание на то, что элемент ACTOR не перечисляется в списке используемых элементов для TAPE. Он может применяться только внутри элемента STARRINGLIST, который уже в свою очередь может помещаться внутри основного тега TAPE. Вопросительные знаки после элементов COUNTRY, TIME и COMMENTS внутри описания TAPE говорят о том, что данные элементы являются необязательными.</p>
Описание атрибутов элемента<br>
<p></p>
Атрибуты элемента конкретизируют его содержание. Для описания атрибутов элементов применяется директива &lt;!ATTLIST&gt;. Атрибуты в XML подразделяются на три вида: обязательные, фиксированные и неявные.</p>
Для обязательных атрибутов, о чем и говорит название, необходимо явно указывать их значение при каждом использовании элемента. Примером обязательного атрибута в HTML служит SRC для элемента &lt;IMG&gt;.</p>
Фиксированные атрибуты не могут быть изменены разработчиком документа. Они присутствуют в качестве значений по умолчанию и если разработчик явно использует их, то присваиваемое значение должно строго совпадать с указанным в DTD-словаре.</p>
Если атрибут не является ни обязательным, ни фиксированным, то он называется неявным. Его применение необязательно, и он не имеет значения по умолчанию. Примером такого атрибута служит параметр BACKGROUND тега &lt;BODY&gt;.</p>
Для каждого из атрибутов можно задать тип используемых значений. В XML существует четыре типа значений для атрибутов. Первый из них - это простой текст, задаваемый разработчиком документа. Он используется для задания значений, которые нельзя предугадать создателю DTD. В основном текстовые значения атрибутов связаны с неявными атрибутами.</p>
 <br>
<p>Один из примеров использования XML &#8212; язык описания фильмов FlixML</p>
Следующим типом атрибута является уникальный идентификатор. Он применяется для однозначного определения элемента в документе. Если используется этот тип значения атрибута, то в одном документе не могут появиться два элемента с одинаковыми идентификационными значениями.</p>
Для атрибута можно указать предопределенные значения. Разработчик документа будет использовать одно из указанных в DTD значений для данного атрибута. Применение предопределенных значений гарантирует, что данный атрибут имеет корректное значение.</p>
Последним типом значений для атрибута является нетекстовый объект. Для того чтобы применять нетекстовый объект в документе (например, графический файл), необходимо сначала определить этот объект в DTD, а затем использовать его в элементе документа с помощью атрибута, имеющего в качестве типа значения нетекстовый объект.</p>
Синтаксис определения атрибутов в DTD имеет следующий вид:</p>
<pre>
&lt;!ATTLIST имя_элемента имя_атрибута тип_значения тип_атрибута "значение_по_умолчанию"&gt;
</pre>
Секция описания атрибута может повторяться для того, чтобы описать все атрибуты указанного элемента. Каждая секция должна содержать, как минимум, имя атрибута и тип его значения. Тип значения указывается следующим образом:</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>простой текст - CDATA;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>уникальный идентификатор - ID;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>предопределенные значения - (значение|значение|...);</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>нетекстовый объект - ENTITY.</td></tr></table></div></p>
Тип атрибута описывается следующими ключевыми словами:</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>обязательный - #REQUIRED;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>фиксированный - #FIXED;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>неявный - #IMPLIED.</td></tr></table></div>Например, сокращенный вариант описания атрибутов элемента HTML &lt;IMG&gt; выглядел бы следующим образом:</p>
<pre>
&lt;!ATTLIST IMG
SRC ENTITY #IMPLIED
ALT CDATA #IMPLIED
ALIGN (LEFT|RIGHT|CENTER| ABSCENTER) #REQUIRED
VALIGN CDATA #FIXED "MIDDLE"&gt;
</pre>
Вернемся к нашему языку... Мы имеем четыре элемента, для которых необходимы атрибуты - YEAR, TIME, CATEGORY и RATING. В первом и втором случае мы имеем атрибуты с текстовыми значениями (т. к. невозможно предугадать их значения). В последних двух случаях необходимо использовать предопределенные значения. В результате имеем следующую запись в нашем DTD-словаре:</p>
<pre>&lt;!ATTLIST YEAR VALUE CDATA #REQUIRED&gt;
&lt;!ATTLIST TIME VALUE CDATA #REQUIRED&gt;
&lt;!ATTLIST CATEGORY CLASS (ACTION|HORROR|SCIFI| HISTORICAL|COMEDY|DRAMA| DOCUMENTAL) #REQUIRED&gt;
&lt;!ATTLIST RATING NUMBER (1| 2|3|4|5) #REQUIRED&gt;
</pre>
Использование объектов<br>
<p></p>
Объектами в XML могут выступать самые различные данные - от текста до двоичных файлов. Объекты в HTML использовались при описании специальных символов и в редких случаях служили для описания внешних источников данных (с помощью тега &lt;OBJECT&gt;). В XML объекты применяются гораздо шире. Существует четыре типа объектов:</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Текстовые объекты. Они содержат часто используемые фразы или целые блоки текста. Текстовые объекты могут содержать как обыкновенный текст, так и элементы разметки. Пример - обычная строка копирайта. Вместо того чтобы везде в тексте писать целую строку "Copyright by ABCD Inc., 2000" можно применять объекты. Когда интерпретатор встретит в документе ссылку на объект, он подставит вместо нее текст, ассоциируемый с этим объектом. Использование текстовых объектов облегчает написание документа, а также упрощает изменение каких-либо значений в тексте. Если строку копирайта необходимо изменить на "Copyright by EFGH Inc., 2001", то вам достаточно только изменить значение объекта. В противном случае вам бы пришлось искать необходимый для изменения текст во всех документах и только тогда исправлять его на новое значение.</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Двоичные объекты. К двоичным объектам относят все те объекты, которые содержат нетекстовые данные. Двоичные объекты требуют специальной обработки перед их использованием в документе. При указании двоичных объектов в DTD необходимо описать их тип и приложение, которое будет обрабатывать данный тип двоичного файла.</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Параметрические объекты. Это специальный тип объекта, который применяется только внутри DTD. Параметрические объекты облегчают написание самих DTD, они содержат часто используемые блоки текста из описания DTD. К примеру, если некоторое число элементов имеет одни и те же атрибуты, то можно задать список описания атрибутов в качестве значения параметрического объекта и позже, при описании необходимых элементов, просто воспользоваться ссылкой на объект.</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Символьные объекты. Этот тип объектов наиболее часто употребляется в HTML. Они даны для описания нетекстовых или зарезервированных символов (например, символ открывающейся угловой скобки '&lt;' = &lt;), а также всех символов Unicode.</td></tr></table></div></p>
Для объявления объекта в DTD предназначена директива &lt;!ENTITY&gt;, которая имеет следующий синтаксис:</p>
<pre>
&lt;!ENTITY имя_объекта "содержание"&gt;
</pre>
В зависимости от типа объекта могут добавляться дополнительные параметры. Объекты также бывают внутренними и внешними. Содержимое внутренних объектов задается при их описании, а для внешних объектов приводится ссылка на внешний файл. Параметрические объекты всегда внутренние, а двоичные, как правило, внешние. Текстовые и символьные объекты могут быть обоих типов. При применении объектов важно соблюдать правило о том, чтобы объект был определен строго до его использования.</p>
Описание текстовых объектов довольно прозрачно и не требует дополнительных параметров. Например:</p>
<pre>
&lt;!ENTITY copyright "Copyright (c)"&gt;
</pre>
Для использования этого объекта необходимо будет применять ссылку на объект:</p>
<pre>
&amp;copyright;
</pre>
Объект copyright является внутренним, поскольку его содержание описано при его объявлении. Текстовые объекты также могут быть внешними. Тогда при его определении необходимо указать адрес файла, который содержит текст объекта. Вдобавок необходимо будет задать идентификатор внешнего объекта, сообщающий о физическом расположении файла объекта. Если будет использовано ключевое слово SYSTEM, то XML-интерпретатор считает, что файл хранится в локальной файловой системе. Идентификатор PUBLIC сообщает о том, что файл широко доступен и он не обязательно находится в локальной системе. Например:</p>
<pre>
&lt;!ENTITY mypara "/texts/mypara.xml" SYSTEM&gt;
</pre>
Для описания двоичного объекта необходимо использовать ключевое слово NDATA и идентификатор типа двоичного объекта. Например:</p>
<pre>
&lt;!ENTITY myphoto "/jpegs/myphoto.jpg" SYSTEM NDATA JPEG&gt;
</pre>
Важно, чтобы тип двоичного объекта был известен системе и интерпретатору. Для этого необходимо воспользоваться директивой &lt;!NOTIFY&gt;:</p>
<pre>
&lt;!NOTIFY BMP SYSTEM "pbrush.exe"&gt;
</pre>
Совсем необязательно, что интерпретатор воспользуется указанной программой для обработки переданного двоичного файла. Вполне возможно, что он имеет внутреннюю поддержку данного формата двоичных данных, однако в случае отсутствия оной интерпретатор будет обращаться к указанной программе.</p>
<p>Параметрические объекты объявляются следующим образом:</p>
<pre>
&lt;!ENTITY % имя_объекта "содержание"&gt;
</pre>

<p>Использование параметрического объекта также отличается от обычного применения объектов:</p>
<table>
<tr>
<td><p>%name;</p>
</td>
</tr>
<tr>
<td>По умолчанию, XML-интерпретатор предоставляет доступ к символьным объектам из набора символов ISO-Latin-1. Для того чтобы получить доступ ко всему множеству символов Unicode, необходимо определить внешний параметрический объект, содержащий таблицу символов, и затем применить его. Например, следующие строки предоставляют доступ ко всем символам Latin 1:</p>
</td>
</tr>
<tr>
<td><p>&lt;!ENTITY % HTMLlat1 PUBLIC "-//W3C//ENTITIES Full Latin 1//EN//HTML"&gt; %HTMLlat1;</p>
</td>
</tr>
<tr>
<td>Использование двоичных объектов отличается от остальных, которые примяются в любом месте документа. Двоичные же объекты можно использовать только в качестве значения атрибута, с нетекстовыми данными, т. е., если мы определим двоичный объект, как:</p>
</td>
</tr>
<tr>
<td><p>&lt;!ENTITY myphoto "/jpegs/myphoto.jpg" SYSTEM NDATA JPEG&gt;</p>
</td>
</tr>
<tr>
<td>Использование &amp;myphoto; приведет к генерации некорректного документа. Необходим элемент, принимающий двоичные данные, например:</p>
</td>
</tr>
<tr>
<td><p>&lt;BODY BACKGROUND="1267/tr&gt;</p>
</td>
</tr>
<tr>
<td>Необходимо заметить, что в качестве значения передается имя объекта, а не имя файла. Конструкция вида</p>
</td>
</tr>
<tr>
<td><p>&lt;BODY BACKGROUND="1267/tr&gt;</p>
</td>
</tr>
<tr>
<td>будет неверна, даже при вышеуказанном описании объекта. В этом состоит одна из ошибок при переходе от HTML к XML.
</td>
</tr>
</table>
XML-документ<br>
<p></p>
Теперь рассмотрим, как, собственно, формировать сам XML-документ. Внутри себя, помимо разметки и текста документа, каждый XML-документ содержит команды обработки (processing instructions). Они сообщают некоторую дополнительную информацию XML-интерпретатору, помогающую правильно обработать документ. Первой строкой каждого XML-документа должна стоять инструкция, идентифицирующая документ как данные на языке XML. Она имеет следующий вид:</p>
<pre>
&lt;?xml version="1.0" encoding="кодировка" ?&gt;
</pre>
Параметр VERSION сообщает версию XML, на данный момент существует только версия 1.0. Необязательный параметр ENCODING указывает кодировку, в которой написан документ. После объявления XML-документа необходимо описать или сделать ссылку на DTD-словарь, который будет использоваться в документе, например:</p>
<pre>
&lt;!DOCTYPE VIDEO SYSTEM "video.dtd"&gt;
</pre>
VIDEO - имя всеобъемлющего элемента класса "документ" (наподобие элемента &lt;HTML&gt;), SYSTEM - сообщает о том, что файл со словарем необходимо искать в локальной системе (можно также использовать ключевое слово PUBLIC); video.dtd - имя файла с DTD. Допускается описание словаря и внутри XML-документа, для этого необходимо использовать директиву &lt;!DOCTYPE&gt; следующим образом:</p>
<pre>
&lt;!DOCTYPE VIDEO [

&lt;!ELEMENT TAPE (RUSSIANTITLE, ORIGINALTITLE, COUNTRY?, YEAR, TIME?, DIRECTOR, STARRINGLIST, CATEGORY, RATING, COMMENTS?)&gt;

&lt;!ATTLIST RATING NUMBER
(1| 2|3|4|5) #REQUIRED&gt;
]&gt;
</pre>
XML в процессе создания...<br>

Не стоит забывать, что работа над постоянным усовершенствованием и стандартизацией XML и его спецификаций все еще ведется. В целом XML - это крайне обширная тема, и в данной статье была затронута лишь вершина айсберга информации о всех спецификациях и стандартах XML. В частности, были опущены такие темы, как механизмы связей - XLink и XPointer, а также XML-стили XSL. Для более полной информации рекомендуется обращаться к специальным информационным сайтам, посвященным XML, или специальным книгам.</p>
</p>
Параллельно с разработкой спецификаций ведутся описания по созданию XML-броузеров интерпретаторов. Сейчас практически каждая компания, представленная на рынке информационных технологий, интегрирует свои достижения с XML. Уже существует множество DTD-словарей, применяющихся в самых разных областях. Примером могут служить каналы Microsoft, CDF, написанные на XML, или язык математической разметки MathML. Прогресс идет, и XML - это несомненное будущее разметки и гипертекста.</p>
</p>
