<h1>Вступление</h1>
<div class="date">01.01.2007</div>

<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18">0 .</td><td></td></tr></table>
<p> Введение</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; В этой главе обсуждаются следующие темы:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 151px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Общий обзор языка SQL и его компонент</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 151px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Соглашения по терминологии, используемые в языке SQL</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 151px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="19">&#183;</td><td> Дополнительные возможности (расширения)&nbsp; языка Transact-SQL</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 151px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Совместимость со стандартом ANSI</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 151px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Как запускать Transact-SQL утилитой ISQL</td></tr></table></div>&nbsp;</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 18px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Общий обзор</td></tr></table></div>&nbsp;</p>
SQL (Structured Query Languade Структурированный язык запросов) является языком высокого уровня, предназначенным для реляционных баз данных. Созданный в исследовательской лаборотории IBM San Jose в конце 70-х годов, язык SQL был адаптирован ко многим системам управления реляционными базами данных (СУРБД). Он был принят Американским Национальным Институтом Стандартов (ANSI) и Международной Организацией по Стандартизации (ISO) в качестве стандарта для языка запросов к реляционным базам данных. Язык Transact-SQL совместим с языком IBM SQL и большинством других коммерческих реализаций языка SQL, и, кроме того, содержит много дополнительных возможностей и функций.</p>
&nbsp;</p>
Несмотря на то, что “Q” означает в аббревиатуре SQL слово “Query” (Запрос), язык SQL содержит не только команды для запросов (извлечения данных из базы), но и команды для создания новых баз данных и объектов баз данных, добавления новых данных, изменения существующих данных и выполнения других функций.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 36px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Запросы, Модификация данных, Команды</td></tr></table></div>&nbsp;</p>
В данном руководстве query означает запрос на выбор данных с помощью команды select. Например:</p>
<pre>
select au_lname, city, state
from authors
where state = 'NY'
</pre>
&nbsp;</p>
&nbsp;</p>
Модификация (изменение) данных означает добавление, удаление или изменение данных с помощью команд insert (вставка), delete (удаление), update (обновление), соответственно. Например: </p>
<pre>
insert into authors (au_lname, au_fname, au_id)
values ("Smith", "Gabriella", "999-03-2346")
</pre>
&nbsp;</p>
&nbsp;</p>
Остальные SQL команды являются инструкциями по выполнению административных функций. Например:</p>
<pre>
drop table author
</pre>
&nbsp;</p>
&nbsp;</p>
Каждая команда или SQL оператор начинается с ключевого слова, например insert (вставить), которое служит названием основной выполняемой операции. Многие из SQL операторов сопровождаются одной или несколькими ключевыми фразами или конструкциями, (предложениями) которые уточняют, что именно нужно сделать. Когда запрос выполнен, Transact-SQL сообщает его результаты пользователю. Если отсутствуют соответствующие запросу данные, то пользователь получает об этом сообщение. Операторы модификации данных и административные операторы не выводят результаты запроса, поскольку они не выбирают данные из базы. Вместо этого TRANSACT-SQL сообщает пользователю о том, какая команда выполнилась.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 36px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Таблицы, столбцы, строки</td></tr></table></div>&nbsp;</p>
Язык SQL является языком баз данных, специально разработанных для реляционной модели управления данными. В реляционных системах данные представляются в виде таблиц, которые также называются отношениями.</p>
&nbsp;</p>
Каждая строка (или запись) таблицы описывает один экземпляр сущности , например, сведения о конкретном человеке, компании, информацию о конкретной продаже или что-нибудь&nbsp; подобное. Каждый столбец (или поле) описывает одну из характеристик этой сущности (атрибут), например, имя человека или его адрес, название компании или имя ее президента, названия проданных товаров, их количество, или дату продажи. В целом база данных представляет собой множество связанных друг с другом таблиц.<img src="/pic/clip0186.gif" width="359" height="152" border="0" alt="clip0186"></p>
Рисунок 1-1: Таблица в реляционной базе данных</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 36px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Реляционные операции</td></tr></table></div>&nbsp;</p>
Основными операциями в реляционной системе являются selection (отбор), projection (проекция) и join (соединение). Все они объединены в SQL в команде select (выбор).</p>
&nbsp;</p>
Selection (известное также как ограничение или селекция) представляет собой выбор подмножества строк в таблице, удовлетворяющих определенным условиям. Например, таким подмножеством может быть список всех писателей, живущих в Калифорнии.</p>
&nbsp;</p>
Projection (проекция) это подмножество столбцов в таблице. Например, в результате выполнения запроса в список могут быть включены только имена&nbsp; всех авторов и их местожительство, исключая название улицы, телефонный номер или другую информацию.</p>
&nbsp;</p>
Join (соединение) соединяет строки из двух (или более) таблиц, путем сравнения значений в указанных полях. Например, у вас имеется одна таблица, содержащая информацию о писателях, включая столбцы au_id (идентификационный номер автора) и au_lname (фамилия автора) и вторая таблица, содержащая информацию о названиях книг, написанных различными авторами, включая столбец au_id, который, как было указано, содержит идентификационный номер автора книги. Необходимо соединить таблицу авторов с таблицей названий книг, проверяя соответствие значений в столбце au_id каждой таблицы. Если значение в этом поле равны, то создается новая строка, содержащая атрибуты (столбцы) обеих таблиц, которая включается в результирующую таблицу. Соединения часто комбинируются с проекциями и селекциями, чтобы выбирать из таблицы только отдельные столбцы и отобранных строк. </p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 18px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Соглашения по терминологии</td></tr></table></div>&nbsp;</p>
В SQL-операторах нужно придерживаться точных синтаксических и структурных правил и использовать только ключевые слова, а также идентификаторы (то есть названия баз данных, названия таблиц или других объектов базы данных), операторы и константы. Символы, используемые в различных частях SQL-оператора могут зависеть от реализации (инсталяции) и определяются в основном тем множеством символов, которое SQL-сервер использует по умолчанию.</p>
&nbsp;</p>
Например, множество символов языка SQL, которое можно использовать в ключевых словах и расширениях языка Transact-SQL, меньше множества символов, которые можно использовать в идентификаторах. Множество символов, с помощью которых записываются данные, значительно шире и включает в себя все символы, используемые в языке SQL и в идентификаторах.</p>
&nbsp;</p>
Рисунок 1-2 показывает соотношение между множеством символов, используемых в ключевых словах, множеством символов, используемых в идентификаторах, и множеством символов значений данных.<img src="/pic/embim1734.png" width="355" height="149" vspace="1" hspace="1" border="0" alt=""></p>
Рисунок 1-2: Множества символов, используемые в SQL операторах</p>
&nbsp;</p>
В следующих главах будут описаны множества символов, которые можно использовать в различных частях SQL выражений. В главе об идентификаторах описываются соглашения, используемые при описании объектов базы данных.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 36px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Символы, с помощью которых записываются данные в SQL</td></tr></table></div>&nbsp;</p>
Множество символов значений данных больше объединения&nbsp; множества символов языка SQL,&nbsp; и множества символов, используемых в идентификаторах. Любой однобайтовый или многобайтовый символ из множества символов, используемых в SQL-Сервере, может быть использован для задания значения данным.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 36px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Символы языка SQL</td></tr></table></div>&nbsp;</p>
Символы, используемые в ключевых словах языка SQL, в расширениях языка Transact-SQL, а также специальные знаки, используемые, например, в операторах сравнения "&gt;","&lt;", представляются 7-битовым ASCII кодом, и включают в себя символы А-Z, a-z, 0-9, а также ASCII символы приведенные в следующей таблице:</p>
&nbsp;</p>
&nbsp;</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td ><p>;</p>
</td>
<td ><p>(точка с запятой)</p>
</td>
<td ><p>(</p>
</td>
<td ><p>(открывающая скобка)</p>
</td>
<td ><p>)</p>
</td>
<td ><p>(закрывающая скобка)</p>
</td>
</tr>
<tr >
<td ><p>,</p>
</td>
<td ><p>(запятая)</p>
</td>
<td ><p>:</p>
</td>
<td ><p>(двоеточие)</p>
</td>
<td ><p>%</p>
</td>
<td ><p>(знак процента)</p>
</td>
</tr>
<tr >
<td ><p>-</p>
</td>
<td ><p>(знак минус)</p>
</td>
<td ><p>?</p>
</td>
<td ><p>(знак вопроса)</p>
</td>
<td >
</td>
<td ><p>(апостроф)</p>
</td>
</tr>
<tr >
<td ><p>“</p>
</td>
<td ><p>(кавычки)</p>
</td>
<td ><p>+</p>
</td>
<td ><p>(знак плюс)</p>
</td>
<td ><p>_</p>
</td>
<td ><p>(подчеркивание)</p>
</td>
</tr>
<tr >
<td ><p>*</p>
</td>
<td ><p>(звездочка)</p>
</td>
<td ><p>/</p>
</td>
<td ><p>(правая черта) </p>
</td>
<td >
</td>
<td ><p>(пробел)</p>
</td>
</tr>
<tr >
<td ><p>&lt;</p>
</td>
<td ><p>(знак меньше)</p>
</td>
<td ><p>&gt;</p>
</td>
<td ><p>(знак больше)</p>
</td>
<td ><p>=</p>
</td>
<td ><p>(знак равенства)</p>
</td>
</tr>
<tr >
<td ><p>&amp;</p>
</td>
<td ><p>(амперсанд)</p>
</td>
<td ><p>|</p>
</td>
<td ><p>(вертикальная черта)</p>
</td>
<td ><p>^</p>
</td>
<td ><p>(верхний суффикс)</p>
</td>
</tr>
<tr >
<td ><p>[</p>
</td>
<td ><p>(левая скобка)</p>
</td>
<td ><p>]</p>
</td>
<td ><p>(правая скобка)</p>
</td>
<td ><p>\</p>
</td>
<td ><p>(левая черта)</p>
</td>
</tr>
<tr >
<td ><p>@</p>
</td>
<td ><p>(знак эт)</p>
</td>
<td ><p>~</p>
</td>
<td ><p>(тильда)</p>
</td>
<td ><p>!</p>
</td>
<td ><p>(восклицательный знак)</p>
</td>
</tr>
<tr >
<td ><p>$</p>
</td>
<td ><p>(знак доллара)</p>
</td>
<td ><p>#</p>
</td>
<td ><p>(числовой знак)</p>
</td>
<td ><p>.</p>
</td>
<td ><p>(точка)
</td>
</tr>
</table>
Таблица 1-1: Символы ASCII, используемые в языке&nbsp; SQL</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 36px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Идентификаторы</td></tr></table></div>&nbsp;</p>
Следующие соглашения используются во всей документации по SQL-серверу. Идентификатор должен иметь длину до 30 байтов, независимо от того, используются ли в нем многобайтные символы. Первый символ идентификатора должен быть буквой из множества символов, используемых SQL-сервером. </p>
&nbsp;</p>
Замечание: В идентификаторах можно использовать множество многобайтных символов. Например, для сервера, работающего на японском языке, могут быть использованы следующие типы символов в качстве первой буквы идентификатора: Zenkaku или Hankaku Katakana, Hiragana, Kanji, Romaji, Cyrillic, Greek, или символы ASCII.</p>
&nbsp;</p>
Также могут быть использованы символы @ (эт) или _ (подчеркивание). Например, признаком локальной переменной, является символ @, стоящий на первой позиции.</p>
&nbsp;</p>
Названия временных таблиц должны либо начинаться с символа # (числовой знак), если они созданы вне базы tempbd, либо предваряться префиксом "tempbd..". Названия временных таблиц, не принадлежащих базе tempbd, не должны превышать 13 байтов в длину, включая числовой знак, поскольку SQL- Сервер присваивает названиям временных таблиц внутренний числовой суффикс. </p>
&nbsp;</p>
Символ, следующий за первым символом в идентификаторе, может быть буквенным, числовым или символом : $ (доллар), # (числовой знак), @ (эт), Ґ (йена) или Ј (фунт стерлингов).</p>
&nbsp;</p>
При инсталляции SQL-сервера устанавливается чувствительность к регистру (case-sensivity), т.е. различаются заглавные и строчные буквы, но эту установку может изменить Системный Администратор. Чтобы проверить эту установку, нужно выполнить команду:</p>
sp_helpsort</p>
&nbsp;</p>
Если сервер не различает заглавных и строчных букв, то идентификаторы MYOBJECT, myobject, MyObject (или любые другие комбинации этих букв) не различаются. Можно создать только один из объектов с таким названием и использовать любую из указанных комбинаций для обращений к нему.</p>
&nbsp;</p>
Внутри идентификаторов не должно быть пробелов и зарезервированных (ключевых) слов. </p>
Список зарезервированных слов приводится в Справочном пособии SQL Сервера.</p>
&nbsp;</p>
Можно использовать функцию valid_ name (правильное имя) для определения допустимости введенного идентификатора. Например,</p>
&nbsp;</p>
select valid name ( "string"),</p>
&nbsp;</p>
где string (строка) является проверяемым идентификатором. Если строка не является допустимым идентификатором, то SQL сервер возвращает 0 (нулевое значение), в противном случае - ненулевое. SQL-сервер возвратит нуль, если проверяемый идентификатор содержит недопустимые символы или имеет длину более 30 байтов.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 54px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Ограниченные кавычками идентификаторы</td></tr></table></div>&nbsp;</p>
Названия таблиц, вьюверов и столбцов (атрибутов) можно заключать в кавычки. Это позволяет избежать некоторых ограничений, накладываемых на названия объектов. Но названия других объектов базы данных, кроме перечисленных, нельзя заключать в кавычки.</p>
&nbsp;</p>
В кавычки можно также заключать зарезервированные слова, превращая их в идентификаторы, либо идентификаторы, которые начинаются не с буквы, либо идентификаторы, содержащие недопустимые символы. Их длина не должна превышать 28 байтов.</p>
&nbsp;</p>
Перед заключением идентификаторов в кавычки, необходимо выполнить следующую команду:</p>
&nbsp;</p>
set quoted _identifier on</p>
&nbsp;</p>
Эта команда позволяет SQL Серверу распознать ограниченные кавычками идентификаторы. При каждом обращении к такому идентификатору в операторе, его нужно заключать в кавычки. Например:</p>
<pre>
create table "lone" (coll char (3))
select * from "lone"
Create table "include spaces" (coll int)
</pre>
&nbsp;</p>
&nbsp;</p>
Замечание: Идентификаторы в кавычках не могут быть параметрами системных процедур или утилиты BCP и могут не поддерживаться прикладным программным обеспечением, работающим у пользователя.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 54px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Соглашения по названиям</td></tr></table></div>&nbsp;</p>
Названия объектов в базе данных могут быть не уникальными. Однако, названия столбцов и индексов внутри таблицы должны быть единственными, а имена других объектов должны быть единственными для каждого собственника (owner) внутри базы данных. Названия баз данных должны быть уникальными для данного SQL Сервера.</p>
&nbsp;</p>
Если попытаться создать столбец с названием, которое уже использовалось в таблице, или создать другой объект базы данных, например, таблицу, вьювер (view) или сохраненную процедуру с названием, которое уже имеется в базе данных, то SQL Сервер выдаст сообщение об ошибке.</p>
&nbsp;</p>
Можно сделать уникальным название любой таблицы или столбца, дополняя название другим именем, например, именем базы данных, именем собственника (владельца), для столбца - названием таблицы или вьювера. Каждая из этих характеристик отделяется от предыдущей точкой:</p>
&nbsp;</p>
database.owner.table_name.column_name</p>
database.owner.view_name.column_name</p>
&nbsp;</p>
Например, если пользователь "sharon" владеет таблицей authors в базе данных pubs2, тогда уникальное название столбца city выглядит так:</p>
&nbsp;</p>
pubs2.sharon.authors.city</p>
&nbsp;</p>
Это синтаксическое правило применимо к любому объекту базы данных, на который можно ссылаться аналогичным образом:</p>
&nbsp;</p>
pubs2.dbo.titleview</p>
dbo.postalcoderule</p>
&nbsp;</p>
Если включена опция quoted_identifier (идентификатор в кавычках), то можно заключать в двойные&nbsp; кавычки названия объектов базы данных. Нужно использовать отдельную пару кавычек для каждого дополнения в названии. Например, следует писать:</p>
&nbsp;</p>
database.owner."table_name"."column_name"</p>
&nbsp;</p>
вместо</p>
&nbsp;</p>
database.owner."table_name.column_name"</p>
&nbsp;</p>
Не всегда можно использовать полные названия в операторе create, поскольку нельзя создать вьювер, процедуру, или триггер в базе данных, отличной от текущей. В этом случае синтаксические правила выглядят следующим образом:</p>
&nbsp;</p>
[[ database.] owner.]object_name</p>
&nbsp;</p>
или</p>
&nbsp;</p>
[owner.] object _name</p>
&nbsp;</p>
По умолчанию в расширенном названии владельцем считается текущий пользователь, а базой данных - текущая базы данных. При ссылке на объект в операторе SQL, отличном от оператора create (создать), без указания названия базы данных и имени владельца, SQL -Сервер просматривает все объекты, владельцем которых является текущий пользователь, а затем объекты в списке Database Owner, который называется "dbo". Пока SQL Сервер обладает достаточной информацией для идентификации объекта, можно использовать сокращенные названия. Промежуточные элементы названия могут быть опущены, а их позиции заменены точкой:</p>
&nbsp;</p>
database .. table_name</p>
&nbsp;</p>
В расширенных названиях столбцов и таблиц в операторе create, необходимо использовать одинаковые аббревиатуры (сокращения) для каждого названия, поскольку они преобразуются в строки, которые должны совпадать. В противном случае будет выдано сообщение об ошибке. Ниже приведены два примера с двумя вариантами названия для одного и того же столбца. Второй пример не будет работать, поскольку в нем указаны различные названия для этого столбца.</p>
<pre>
select pubs2.dbo.publishers.city
from pubs2.dbo.publishers
</pre>
&nbsp;</p>
&nbsp;</p>
city</p>
-----------------------------------------</p>
Boston</p>
Washington</p>
Berkeley</p>
&nbsp;</p>
select pubs2.dbo.publishers.city</p>
from pubs2..publishers</p>
&nbsp;</p>
Этот запрос вызовет сообщение об ошибке, поскольку префикс “pubs2.dbo.publishers” не совпадает с названием таблицы во второй строке.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 54px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Вызов удаленных серверов</td></tr></table></div>&nbsp;</p>
Сохраненные процедуры могут выполняться на удаленном сервере с выводом результататов на терминал, с которого была вызвана процедура. Синтаксис вызова сохраненной процедуры на удаленном сервере имеет следующий вид:</p>
&nbsp;</p>
[execute] server.[database] .[owner].procedure_name</p>
&nbsp;</p>
Ключевое слово execute (выполнить) может быть опущено, если вызов удаленной процедуры является первым оператором пакетного файла. Если другой SQL оператор предшествует вызову удаленной процедуры, то необходимо указать execute или exec. Названия сервера и сохраненной процедуры нужно указывать всегда. Если название базы данных опущено, то SQL сервер ищет procedure_name (название процедуры) в текущей базе данных. Если указывается название базы данных, то, как правило, необходимо указать и имя владельца процедуры, кроме случаев когда пользователь, вызывающий процедуру, является ее владельцем или процедура находится в списке Database Owner (Собственник базы данных).</p>
&nbsp;</p>
Во всех следующих операторах вызывается сохраненная процедура byroyalty из базы данных pubs2, расположенной на сервере GATEWAY:</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td ><p>Оператор</p>
</td>
<td ><p>Замечания</p>
</td>
</tr>
<tr >
<td ><p>GATEWAY.pubs2.dbo.byroyalty</p>
<p>GATEWAY.pubs2..byroyalty</p>
</td>
<td ><p>владельцем byroyalty является в Database Owner</p>
</td>
</tr>
<tr >
<td ><p>GATEWAY...byroyalty</p>
</td>
<td ><p>используется, если pubs2 является текущей базой данных</p>
</td>
</tr>
<tr >
<td ><p>declare @var int</p>
<p>exec GATEWAY...byroyalty</p>
</td>
<td ><p>используется, если этот оператор не является первым в пакетном файле.
</td>
</tr>
</table>
&nbsp;</p>
Об установках SQL сервера, касающихся удаленного доступа, можно посмотреть также в Руководстве системного администратора SQL сервера. Названия удаленного сервера (GATEWAY в приведенном примере) должно совпадать с названием этого сервера в локальном интерфейсном файле SQL сервера (interfaces file) для данного пользователя. Если название сервера в интерфейсном файле указано заглавными (большими) буквами, то название сервера при вызове удаленной процедуры также должно быть указано заглавными буквами.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 18px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Расширения в языке Transact-SQL</td></tr></table></div>&nbsp;</p>
Язык Transact-SQL был создан для расширения возможностей языка SQL и для миниминизации, если не исключется вовсе, необходимости программирования со стороны пользователя для решения поставленной задачи. Язык Transact-SQL шире стандарта ISO и многих других коммерческих версий языка SQL. В этом разделе перечислены большинство дополнительных возможностей языка Transact-SQL (известных также как расширения). Другие расширения, такие как средства администрирования, описаны в соответствующих руководствах.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 36px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Конструкция compute</td></tr></table></div>&nbsp;</p>
Конструкция compute (вычислить) является важным дополнительным средством, содержащимся в Transact-SQL, которое используется вместе с агрегирующими по строкам функциями sum (сумма), max (максимум), min (минимум), avg (среднее) и count (число) для вычисления итоговых значений. Результаты запроса, включающего конструкцию compute, выводятся вместе с результирующими строками и по внешнему виду напоминают отчеты, полученные с помощью генератора отчетов, в которых также предусматриваются специальные строки, содержащие итоговые значения. Конструкция compute рассматривается в главе 3 "Подведение итогов, Группировка и Сортировка Результатов Запроса".</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 36px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Управляющие Операторы</td></tr></table></div>&nbsp;</p>
В языке Transact-SQL имеются управляющие операторы, которые могут использоваться в составе SQL запросов или в пакетных файлах. К ним относятся: begin...end (начало...конец), break (прервать), continue (продолжить), declare (объявить), goto label (перейти на метку), if...else (если...иначе), print (печать), raiserror (генерация ошибки), return (вернуть), waitfor (ожидать для) и while (до тех пор пока). Локальные переменные могут быть определены оператором declare вместе с начальным значением. В системе также имеются несколько заранее определенных глобальных переменных.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 36px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Сохраненные процедуры</td></tr></table></div>&nbsp;</p>
Одним из важнейших дополнительных средств в языке Transact-SQL является возможность создания сохраненных процедур. Эти процедуры могут содержать почти любые SQL операторы вместе с операторами управления. Программист может определить в них параметры, значения которых передаются в момент вызова процедуры. Сохраненные процедуры существенно повышают возможности, эффективность и гибкость языка баз данных SQL. Повторное выполнение этих процедур происходит значительно быстрее отдельных операторов, поскольку план выполнения процедуры сохраняется после ее выполнения.</p>
&nbsp;</p>
SQL-Сервер также содержит сохраненные процедуры, которые называются системными процедурами и служат для системного администрирования. В главе 14 “Использование Сохраненных Процедур” рассматриваются системные процедуры и объясняется как создавать сохраненные процедуры. Системные процедуры также подробно рассматриваются в Справочном руководстве SQL Сервера.</p>
&nbsp;</p>
Пользователь может вызывать сохраненные процедуры на удаленном сервере. Язык Transact-SQL позволяет также возвращать значения, параметры и состояния, определенные пользователем, из сохраненных процедур.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 36px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Триггера</td></tr></table></div>&nbsp;</p>
Триггер - это сохраненная процедура специального вида, которая предназначена для защиты ссылочной (referential) целостности данных, т. е. для отслеживания правил и соотношений, которым должны подчиняться данные из различных таблиц. Триггер активизируется, когда пользователь добавляет или модифицирует (изменяет) данные с помощью операторов insert (вставить), delete (удалить) и update (обновить).</p>
&nbsp;</p>
Триггер может вызвать в системе целую цепочку действий, когда происходит попытка изменения данных. Триггера помогают сохранить целостность базы данных путем предотвращения неправильного, неавторизованного или некорректного изменения данных.</p>
&nbsp;</p>
Триггера могут вызывать локальные или удаленные сохраняемые процедуры или другие триггера. Глубина вложенности при вызове триггеров может достигать 16 уровней.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 36px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Правила и Значения по умолчанию</td></tr></table></div>&nbsp;</p>
В языке Transact-SQL предусмотрены ключевые слова для сохранения смысловой целостности данных (в любом поле должна находиться некоторая величина, если она там предусмотрена) и прикладной целостности данных (значение любого поля должно соответствовать его типу). Триггера, упомянутые выше, помогают сохранить ссылочную целостность данных. Правила и значения по умолчанию налагают ограничения на вводимые и модифицируемые данные.</p>
&nbsp;</p>
Значение по умолчанию относится к значению поля данных, которое устанавливается по умолчанию, если никакое значение не было введено в это поле. Правило вводится пользователем и представляет собой ограничения на значение или тип связанного с ним поля данных, оно действует во время ввода данных. Правила и соглашения рассматриваются в главе 12 “Введение Правил и Соглашений для данных ”.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 36px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Обработка ошибок и Установка Опций</td></tr></table></div>&nbsp;</p>
Программисту в языке Transact-SQL предоставляется много возможностей для обработки ошибочных ситуаций, включая перехват кода состояния, возвращаемого из сохраняемой процедуры, определение специальных кодов возврата для этих процедур, передачу параметров из вызываемой процедуры в вызывающую и, наконец, получение информации из глобальных переменных таких, как @@error (ошибка). С помощью операторов raiserror (генерация ошибки) и print (печать) можно направить сообщение об ошибке непосредственно пользователю Transact-SQL приложения. Разработчики могут вызывать операторы raiserror и print из других языков программирования.</p>
&nbsp;</p>
Установка опций с помощью оператора set (установить) позволяет настроить вывод результатов и статистики, подключить диагностическую помощь при отладке Transact-SQL программ.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 36px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Дополнительные возможности SQL-Сервера </td></tr></table></div>&nbsp;</p>
Отметим другие отличительные особенности языка Transact-SQL:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Вводятся некоторые ограничения на конструкции group by (группировать) и order by (сортировать). См. главу 3 “Подведение итогов, Группировка и Сортировка Результатов Запросов”.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>В запросах можно использовать подзапросы почти везде, где допускаются выражения. См. главу 5 “Подзапросы: Использование Запросов в других Запросах”.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Язык допускает создание временных таблиц и других временных объектов, которые существуют только во время сеанса работы и удаляются после его завершения. См. главу 7 “Создание Баз Данных и Таблиц”.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>В SQL-Сервере допускается создание типов данных, определенных пользователем. См. главу 7 и главу 12 “Введение правил и соглашений для Данных”.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Оператор insert (вставить) можно использовать для вставки данных из таблицы в ту же таблицу. См. главу 8 “Добавление, Изменение и Удаление Данных”.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Опрератор update (обновление) допускает извлечение данных из одной таблицы и их пересылку в другую. См. главу 8.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Оператор delete (удалить) можно применять для удаления связанных данных из нескольких таблиц. См. главу 8.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Оператор truncate table (очистка таблицы) можно использовать для быстрого удаления всех строк из таблицы и освобождения занимаемой ими памяти. См. главу 8.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Допускается просмотр и обновление данных через вьювер. В отличие от других версий языка SQL язык Transact-SQL не накладывает никаких ограничений на выбор данных через вьювер и показывает относительно небольшие ограничения на их обновление. См. глава 9 “Вьюверы: Ограниченный Доступ к Данным”.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>В языке имеется большой набор встроенных функций. См. главу 10 “Использование Встроенных Функций в Запросах”.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Опции в операторе create index (создание индекса) позволяют повысить эффективность выполнения запросов, использующих этот индекс, и управлять обработкой повторяющихся ключей и строк. См. главу 11 “Создание Индексов в Таблицах”.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Пользователь может управлять реакцией системы при появлении повторяющихся ключей в уникальном индексе или повторяющихся строк в таблице. См. главу 11.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Можно использовать битовые операции над данными типа interger (целое) и bit (бит). См. Справочное руководство SQL Сервера.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>В языке поддерживаются типы данных text (текстовый) и image (графический). См. Справочное руководство SQL Сервера.</td></tr></table></div>&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 18px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Соответствие Стандартам</td></tr></table></div>&nbsp;</p>
В настоящее время продолжается развитие стандартов по реляционным СУБД. Эти стандарты принимаются Международным Институтом Стандартов (ISO) и некоторыми национальными агенствами. Первым из этих стандартов был SQL86. Он был заменен стандартом SQL89, который в свою очередь был заменен стандартом SQL92, который и действует в настоящее время. SQL92 предусматривает три уровня согласованности: Входной (Entry), Средней (Intermediate) и Полной (Full). В США Национальным Институтом Стандартов (NIST) был введен Переходный уровень, расположенный между Входным и Средним. </p>
&nbsp;</p>
Некоторые требования стандартов не согласуются с существующими приложениями SQL-серверов. Язык Transact-SQL содержит опцию set (установить), которая позволяет учитывать эти расхождения.</p>
&nbsp;</p>
Поведение, соответсующее стандарту, устанавливается по умолчанию во всех приложениях, использующих встроенный SQL&trade; прекомпилятор. Другие приложения, которые необходимо согласовать с входным стандартом SQL92, могут использовать опции, указанные в таблице 1-2.</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td ><p>Опции</p>
</td>
<td ><p>Установки</p>
</td>
</tr>
<tr >
<td ><p>ansi_permissions</p>
</td>
<td ><p>on (включить)</p>
</td>
</tr>
<tr >
<td ><p>ansinull</p>
</td>
<td ><p>on</p>
</td>
</tr>
<tr >
<td ><p>arithabort</p>
</td>
<td ><p>off(выключить)</p>
</td>
</tr>
<tr >
<td ><p>arithabort numeric_truncation</p>
</td>
<td ><p>on</p>
</td>
</tr>
<tr >
<td ><p>arithignore</p>
</td>
<td ><p>off</p>
</td>
</tr>
<tr >
<td ><p>chained</p>
</td>
<td ><p>on</p>
</td>
</tr>
<tr >
<td ><p>close on endtran</p>
</td>
<td ><p>on</p>
</td>
</tr>
<tr >
<td ><p>fipsflagger</p>
</td>
<td ><p>on</p>
</td>
</tr>
<tr >
<td ><p>quoted_identifier</p>
</td>
<td ><p>on</p>
</td>
</tr>
<tr >
<td ><p>string_rtruncation</p>
</td>
<td ><p>on</p>
</td>
</tr>
<tr >
<td ><p>transaction isolation level</p>
</td>
<td ><p>3
</td>
</tr>
</table>
Таблица 1-2: Установка опций соответствия ANSI стандартам</p>
&nbsp;</p>
В следующих разделах описываются расхождения между стандартным поведением и поведением, по умолчанию принятым в языке Transact-SQL.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 36px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>FIPS сигнализатор</td></tr></table></div>&nbsp;</p>
Для пользователей, создающих приложения, которые должны соответствовать стандарту, в SQL-сервере предусмотрена опция set fipsflagger. Когда эта опция включена, все команды из расширения Transact-SQL, которые не соответствуют входному уровню стандарта SQL92, сопровождаются информационным сообщением.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 36px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Режим транзакций и уровни изоляции</td></tr></table></div>&nbsp;</p>
В SQL-сервере теперь предусмотрен стандартный для SQL режим “сцепленных” (chained) транзакций в качестве опции. В этом режиме все операторы поиска и модификации данных (delete, insert, open, fetch, select, и update) неявно порождают транзакцию. Поскольку этот режим несовместим со многими Transact-SQL приложениями, то режим, в котором отсутствуют транзакции, устанавливается по умолчанию.</p>
&nbsp;</p>
Режим сцепленных транзакций можно ввести с помощью новой опции set chained. Новая опция set transaction isolation level управляет уровнями изоляции транзакций. Информацию об этом см. в главе 17 “Транзакции: Сохранение целостности данных и восстановление”.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 36px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Использование кавычек</td></tr></table></div>&nbsp;</p>
SQL-сервер теперь допускает использование идентификаторов в кавычках (delimited) для названий таблиц, вьюверов и столбцов. Использование кавычек позволяет ослабить некоторые ограничения, накладываемые на названия объектов.</p>
&nbsp;</p>
Для использования идентификаторов в кавычках нужно включить опцию set quoted_identifiers. После этого всепоследовательности символов, заключенные в&nbsp; двойные кавычки, трактуются как идентификаторы. Поскольку подобный режим несовместим со многими существующими приложениями, то по умолчанию он отключен (off).</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 36px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Комментарии в SQL </td></tr></table></div>&nbsp;</p>
Комметарии в языке Transact-SQL заключаются в комбинированные скобки /* */ и могут быть вложенными. Комментарии могут также начинаться с двух знаков минус, как это предусмотрено в стандарте языка SQL, и заканчиваться в конце строки (возвратом каретки):</p>
select “hello” &#8212; this is comment</p>
&nbsp;</p>
Внутри комментария, заключенного в скобки /* */, двойной минус “--” не распознается.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 36px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Обрыв справа символьных строк</td></tr></table></div>&nbsp;</p>
В языке имеется новая опция string_rtruncation команды set, которая согласует со стандартом обрыв справа символьных строк. Если эта опция установлена (on), то строки не обрываются справа по умолчанию, а их обрыв согласуется с требованиями стандарта языка SQL.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 36px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Ограничения на использования операторов update и delete</td></tr></table></div>&nbsp;</p>
Имеется новая опция ansi_permissions команды set, которая регулирует использование операторов update (обновление) и delete (удаление). Когда эта опция включена (on), то SQL-сервер придерживается более жестких ограничений на использование этих операторов, предусмотренных стандартом SQL92. Поскольку такое соглашение несовместимо с большинством существующих приложений, то по умолчанию эта опция выключена (off).</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 36px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Арифметические ошибки</td></tr></table></div>&nbsp;</p>
Опции arithabort и arithignore команды set были переопределены, чтобы соответствовать стандарту SQL92:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Опция arithabort arith_overflow определяет поведение после попыток деления на ноль или потери точности. По умолчанию эта опция включена (on), поэтому при появлении арифметической ошибки происходит отказ от выполнения (откат назад) всей транзакции или пакетного файла, где произошла ошибка. Если эта опция выключена (off), SQL-сервер прекращает выполнение оператора, вызвавшего ошибку, но продолжает выполнение других операторов из текущей транзакции или пакетного файла. Для соответствия стандарту SQL92 эта опция должна быть выключена командой set arithabort arith_overflow off.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Опция arithabort numeric_truncation определяет поведение при необходимости усечения в точных числовых типах. По умолчанию эта опция включена (on), поэтому при появлении ошибки прекращается выполнение оператора, вызвавшего ошибку, но продолжается выполнение остальных операторов из текущей транзакции или пакетного файла. Если эта опция отключена, то SQL-Сервер усекает результаты запроса и продолжает обработку. Для соответствия стандарту SQL92 эта опция должна быть включена командой set arithabort numeric_truncation on.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Опция arithignore arith_overflow определяет, будет ли SQL-Сервер должен выдавать сообщение после попыток деления на ноль или потери точности. По умолчанию эта опция выключена (off), поэтому выдается&nbsp; предупреждающее сообщение после этих ошибок. Установка этой опции (arithignore arith_overflow on) отменяет выдачу сообщений об этих ошибках. Для соответствия стандарту SQL92 нужно отключить эту опцию командой set arithignore arith_overflow off.</td></tr></table></div><p class="p_Heading1">&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 36px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Синонимы в ключевых словах</td></tr></table></div><p class="p_Heading1">&nbsp;</p>
Несколько ключевых слов было добавлено для совместимости со стандартным SQL. Эти слова которые являются синонимами уже существующих в языке Transact-SQL ключевых слов.</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="2" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td ><p>Текущее название</p>
</td>
<td ><p>Добавленный термин</p>
</td>
</tr>
<tr >
<td ><p>tran</p>
<p>transaction</p>
</td>
<td ><p>work</p>
</td>
</tr>
<tr >
<td ><p>any</p>
</td>
<td ><p>some</p>
</td>
</tr>
<tr >
<td ><p>grant all</p>
</td>
<td ><p>grant all privileges</p>
</td>
</tr>
<tr >
<td ><p>revoke all</p>
</td>
<td ><p>revoke all privileges</p>
</td>
</tr>
<tr >
<td ><p>max (выражение)</p>
</td>
<td ><p>max [all distinct] (выражение)</p>
</td>
</tr>
<tr >
<td ><p>user_name (встроенная функция)</p>
</td>
<td ><p>user (ключевое слово)
</td>
</tr>
</table>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Таблица 1-3: Синонимы для стандартных ключевых слов</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 36px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="18"></td><td>Трактовка нулей</td></tr></table></div>&nbsp;</p>
В язык включена новая опция ansinull команды set, которая согласует трактовку неопределенного значения (null) в равенствах (=), неравенствах (!=) и агрегирующих функциях со стандартом SQL. Эта опция не влияет на оценку неопределенных значений в других SQL операторах, таких, например, как creat table (создать таблицу).</p>
&nbsp;</p>
