<h1>Обучающее руководство по PostgreSQL</h1>
<div class="date">01.01.2007</div>


<p class="author">Автор: Команда разработчиков PostgreSQL</p>
<p>Под редакцией: Thomas Lockhart</p>

<p><b>Авторские права и торговые марки</b></p>
<p>Авторское право на PostgreSQL принадлежит Postgres Global Development Group</p>
<p>Этот документ является пользовательским руководством для систем управления базами данных PostgreSQL, изначально разработанной в калифорнийском университете Berkeley. PostgreSQL основан на Postgres версии 4.2. Проект Postgres ,возглавляемый профессором Michael Stonebraker, был субсидирован в рамках министерства обороны агентством по перспективным научным проектам (DARPA), Army Research Office (ARO), национальным научным фондом (NSF), и ESL, Inc. </p>

<p>Резюме</p>
Postgres изначально разрабатывался в UC Berkeley Computer Science Department, цитадели многих объектно-реляционных концепций, теперь ставших доступными в некоторых коммерческих базах данных. Он обеспечивает поддержку языка SQL92/SQL3, целостность транзакций и расширяемость типов. PostgreSQL является всеобщим достоянием, потомком с открытыми исходными текстами этого оригинального кода Berkeley. </p>

<h2>Глава 1. Введение</h2>
<p>Оглавление:</p>
<p>Что такое Postgres? </p>
<p>Краткая история Postgres </p>
<p>Об этой версии </p>
<p>Ресурсы </p>
<p>Терминология </p>
<p>Нотация </p>
<p>О Y2K </p>

<p>Что такое Postgres?</p>
Традиционные реляционные системы управления базами данных (DBMSs) поддерживают модель данных, состоящую из набора именованных отношений, содержащих атрибуты определенных типов. В настоящий момент, коммерческие системы включают такие возможные типы: числа с плавающей точкой, целые, строки символов, денежную единицу и даты. Обычно признаётся, что эта модель недостаточна для работы приложений с типами данных, которые появятся в будущем. Реляционная модель успешно замещает предыдущие модели, в частности, из-за её "спартанской простоты". Однако иногда, эта простота часто делает реализацию некоторых приложений очень сложной. Postgres предлагает значительную дополнительную мощность, объединяя следующие четыре дополнительные концепции с основными таким образом, что пользователи могут легко расширить систему: </p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td ><p>классы</p>
</td>
</tr>
<tr >
<td ><p>наследование</p>
</td>
</tr>
<tr >
<td ><p>типы</p>
</td>
</tr>
<tr >
<td ><p>функции
</td>
</tr>
</table>
Прочие свойства обеспечивают дополнительную мощность и гибкость: </p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td ><p>ограничения</p>
</td>
</tr>
<tr >
<td ><p>триггеры</p>
</td>
</tr>
<tr >
<td ><p>правила</p>
</td>
</tr>
<tr >
<td ><p>целостность транзакций
</td>
</tr>
</table>
Из-за этих свойств Postgres относят к категории баз данных, называемых объектно-реляционными. Обратите внимание, что они отличаются от так называемых объектно-ориентированных, которые, в общем, плохо подходят для традиционных языков реляционных баз данных. Но хотя Postgres и имеет некоторые объектно-ориентированные свойства, он остаётся в мире реляционных баз данных. Фактически, некоторые новые коммерческие базы данных включают свойства, открытые Postgres. </p>

<p>Краткая история Postgres</p>
Объектно-реляционная система управления базами данных, теперь известная как PostgreSQL (и сокращённо называемая Postgres95) , происходит от пакета Postgres , написанного в Berkeley. После десятилетия разработки, PostgreSQL это наиболее прогрессивная база данных с открытыми исходными текстами, доступная везде, предлагает многовариантное управление параллелизмом, поддерживает почти все конструкции SQL (включая вложенную выборку, транзакции, и определяемые пользователем типы и функции), и имеет широкий ряд связей с языками (включая C, C++, Java, perl, tcl, и python). </p>
<p>Проект Berkeley Postgres</p>
Реализация Postgres DBMS началась в 1986. Первоначальные концепции системы представлены в Задачи Postgres, а определение первоначальной модели данных показано в Модель данных Postgres. Проект правил системы для этого времени описывается в Проектирование системы правил Postgres. Логическое обоснование и архитектура администратора хранения описана в Система хранения Postgres. </p>
Postgres за это время пережил несколько основных версий. Первая система "demoware" заработала в 1987 и была представлена в 1988 на ACM-SIGMOD конференции. Мы выпустили Версию 1, описываемую в Реализация Postgres, для нескольких внешних пользователей в июне 1989. В ответ на критику первого правила системы (Комментарий к системе правил Postgres), система правил была переконструирована (О правилах, процедурах, кэшировании и представлениях в системах баз данных) и Версия 2 увидела свет в июне 1990 с новой системой правил. Версия 3 появилась в 1991 и добавила поддержку для составного администратора хранения, улучшился исполнитель запросов, и была переписана система правил перезаписи. По большей части, после выпуска Postgres95 (смотри ниже) всё внимание было перенесено на портативность и надёжность. </p>
Postgres использовался для реализации многих различных исследований и производства приложений. Среди них: система анализа финансовых данных, пакет контроля за производительностью реактивных двигателей, база данных передвижения астероидов и несколько географических информационных систем. Postgres также использовался как учебное пособие в нескольких университетах. Наконец, Illustra Information Technologies (потом слилась с Informix) подобрала код и коммерциализовала его. Позже, в 1992 году, Postgres стал первичным администратором данных для Sequoia 2000, научного вычислительного проекта. </p>
Размер сообщества внешних пользователей в течении 1993 года практически удвоился. Становилось всё больше и больше понятно, что сопровождение прототипа кода и поддержка заберут большое количество времени, которое должно было быть посвящено исследованию баз данных. Из-за этого напряжения сократилась поддержка на накладные расходы, и проект официально прекратился с версией 4.2. </p>
<p>Postgres95</p>
В 1994 году, Andrew Yu и Jolly Chen добавили интерпретатор языка SQL в Postgres. Впоследствии, Postgres95 был запущен в паутину, найдя свой собственный путь в мир в качестве всеобщего достояния, как потомок с открытым исходным текстом, изначально бывшим Berkeley кодом Postgres . </p>
Код Postgres95 был полностью на ANSI C и урезан в размере на 25%. Много внешних изменений улучшили производительность и обслуживаемость. Postgres95 v1.0.x запускался на 30-50% быстрее на Wisconsin Benchmark по сравнению с Postgres v4.2. Кроме исправленных багов, появились такие улучшения: </p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Язык запросов Postquel был заменён на SQL (реализован в сервере). Подзапросы не поддерживались до PostgreSQL (смотри ниже), но они могли быть съимитированы в Postgres95 с помощью функций SQL, определённых пользователем. Сложные функции были реализованы заново. Также был добавлен пункт поддержки запросов GROUP BY. Для программ на C остался доступен интерфейс &lt;&gt;. </td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>В дополнении к программе мониторинга, появилась программа (psql) , которая позволяла выполнять интерактивные запросы SQL, используя GNU readline. </td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Новая клиентская библиотека, libpgtcl, стала поддерживать клиентов основанных на Tcl. Пример на shell, pgtclsh, обеспечивал новые Tcl команды для связи tcl программ с Postgres95 сервером. </td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Взаимодействие с большими объектами было основательно перестроено. От перестановки больших объектов остался только механизм хранения больших объектов. (Перестановочная файловая система была удалена.) </td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Объектно-уровневое системное правило было удалено. Правила еще доступны как правила перезаписи. </td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Вместе с исходным кодом стало распространяться краткое обучающее руководство по официальным возможностям SQL, работающим в Postgres95. </td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Для сборки стал использоваться GNU make (вместо BSD make). Также, Postgres95 может быть скомпилирован с помощью непропатченного gcc (выравнивание данных типа double было исправлено). </td></tr></table></div><p>PostgreSQL</p>
В 1996 году, стало ясно, что название &#8220;Postgres95&#8221; не выдержало испытания временем. Мы выбрали новое имя, PostgreSQL, отражающее взаимосвязь между первоначальным Postgres и возможностями SQL в более новых версиях. В тоже время, мы установили нумерацию версий, начиная с 6.0, вернув нумерацию обратно к прежней последовательности изначально начатой проектом Postgres. </p>
При разработке Postgres95 акцент делался на установление и понимание существующих проблем в коде сервера. В PostgreSQL акцент был сдвинут на прибавление свойств и возможностей, хотя работа продолжалась во всех областях. </p>
Основные улучшения в PostgreSQL включают: </p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Блокировка на уровне таблиц была заменена на многовариантное управление параллелизмом, который позволяет читающему продолжать чтение согласованных данных во время деятельности пишущего и разрешает горячее резервирование из pg_dump, и то же время база данных остаётся доступной для запросов. </td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Были реализованы важные свойства сервера, включая вложенную выборку, значения по умолчанию, ограничители, и триггеры. </td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Были добавлены дополнительные свойства языка SQL92, включая первичные ключи, объявление идентификаторов, преобразование литерального строкового типа, приведение типа, и ввод двоичных и шестнадцатеричных целых. </td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Были улучшены встроенные типы, включая новые широкомасштабные типы даты/время и поддержка дополнительных геометрических типов. </td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Скорость всего кода сервера была увеличена приблизительно на 20-40%, и время запуска сервера было уменьшено на 80%, начиная с выпуска v6.0. </td></tr></table></div>&nbsp;</p>
<p>Терминология</p>
В последующем тексте, термин сайтозначает хост машину, на которой установлен Postgres. Т.к. возможно установить более одной базы данных Postgres на один хост, то этот термин более точно указывает на любой отдельный набор установленных исполняемых файлов и баз данных Postgres. </p>
Суперпользователь Postgres - это имя пользователя postgres, которому принадлежат исполняемые и файлы баз данных Postgres. Для суперпользователя, все механизмы защиты пропускаются и доступны любые произвольные данные.К тому же, суперпользователю Postgres позволено запускать некоторые программы поддержки, которые, в основном, недоступны для всех пользователей. Заметим, что суперпользователь Postgres - это не суперпользователь Unix (на который будем ссылаться как на root). Суперпользователь должен иметь не нулевой идентификатор пользователя (UID) по причинам безопасности. </p>
Администратор базы данных или DBA - это человек, который отвечает за установку механизмов Postgres в соответствии с политикой безопасности сайта. DBA может добавлять новых пользователей по методике, описанной ниже и поддерживать набор шаблонов баз данных для использования с createdb. </p>
postmaster - это процесс, который работает как расчётная палата для запросов к системе Postgres. Клиентские приложения подключаются к postmaster, который отслеживает любые системные ошибки и взаимодействие с процессами сервера. postmaster может принимать некоторые аргументы из командной строки для настройки своего поведения. Однако, указывать аргументы необходимо только если ты намереваешься запускаться на нескольких сайтах или не на сайте по умолчанию. </p>
Сервер Postgres (т.е. исполняемая программа postgres) может быть запущена прямо из пользовательского shell суперпользователем Postgres (с именем базы данных в качестве аргумента). Однако, из-за этого не принимается во внимание разделяемый буферный пул и блокировка таблиц, связанных с postmaster/сайтом, поэтому это не рекомендуется на многопользовательском cайте. </p>
<p>Нотация</p>
&#8220;...&#8221; или /usr/local/pgsql/ в начале имени файла используются для представления пути к домашнему каталогу суперпользователя Postgres. </p>
В командном синтаксисе, скобки (&#8220;[&#8221; и &#8220;]&#8221;) показывают, что выражение или ключевое слово необязательны. Всё в фигурных скобках (&#8220;{&#8221; и &#8220;}&#8221;) и содержащие вертикальные штрихи (&#8220;|&#8221;) показывают, что ты можешь выбрать из них что-то одно. </p>
В примерах, круглые скобки (&#8220;(&#8221; и &#8220;)&#8221;) используются для группировки логических выражений. &#8220;|&#8221; - это логический оператор OR. </p>
В примерах показано выполнение команд из различных бюджетов и программ. Команды, выполняемые из бюджета root предваряются &#8220;&gt;&#8221;. Команды, выполняемые из бюджета суперпользователя Postgres предваряются &#8220;%&#8221;, в то время как команды выполняемые из бюджета непревелигерованных пользователей предваряются &#8220;$&#8221;. Команды SQL предваряются &#8220;=&gt;&#8221; или не имеют приглашения, в зависимости от смысла. </p>

<h2>Глава 2. SQL</h2>
<p>Оглавление:</p>
<p>Реляционная модель данных </p>
<p>Формальное описание реляционной модели данных </p>
<p>Операции в реляционной модели данных </p>
<p>Язык SQL </p>
Эта глава изначально появилась как часть диссертации Stefan Simkovicss (Simkovics, 1998). </p>
SQL стал наиболее популярным реляционным языком запросов. Название &#8220;SQL&#8221; это абривиатура Язык структурированных запросов. В 1974 году Donald Chamberlin и другие в IBM Research разработали язык SEQUEL (Язык английских структурированных запросов). Этот язык был впервые реализован в прототипе IBM названном SEQUEL-XRM в 1974-75 годах. В 1976-77 годах зародилась пересмотренная версия SEQUEL называемая SEQUEL/2 и впоследствии название было изменено на SQL. </p>
В 1977 году был разработан новый прототип, названный System R. System R реализовывал большое подмножество SEQUEL/2 (сейчас SQL) и в течении проекта SQL было сделано много изменений. System R была установлена на многих пользовательских сайтах, как на внутренних сайтах IBM так и на некоторых выбранных клиентских сайтах. Благодаря успеху и приёму System R на этих пользовательских сайтах IBM начала разрабатывать коммерческие продукты, которые реализовывали язык SQL, основанный на технологии System R. </p>
Через несколько лет IBM и еще несколько других продавцов анонсировали такие SQL продукты как SQL/DS(IBM), DB2 (IBM), ORACLE (Oracle Corp.), DG/SQL (Data General Corp.), и SYBASE (Sybase Inc.). </p>
SQL стал, также, официальным стандартом. В 1982 году Американский национальный институт стандартов (ANSI) заказал своему комитету по базам данных X3H2 разработать план по стандартизации реляционного языка. Этот план был утверждён в 1986 году и состоял преимущественно из IBM-кого диалекта SQL. В 1987 году этот ANSI стандарт также был принят в качестве международного стандарта международной организацией по стандартизации (ISO). Эту версия первоначального стандарта SQL часто называют неформально как "SQL/86". В 1989 году первоначальный стандарт был расширен и этот новый стандарт часто, опять же неформально, стали называть как "SQL/89". Также в 1989 году, был разработан родственный стандарт, называемый Встроенный язык баз данных SQL (ESQL). </p>
Комитеты ISO и ANSI много лет работали над определением значительно дополненной версии изначального стандарта, неформально называемого SQL2 или SQL/92. Эта версия стала утверждённым стандартом - "Международный стандарт ISO/IEC 9075:1992, языка баз данных SQL" - в конце 1992 года. SQL/92 - это версия обычно используется людьми, хотя они подразумевают " стандарт SQL". Подробное описание SQL/92 дано Дейтом и Дарвеном в 1997 году. За время написания этого документа стал разрабатываться новый стандарт, неформально называемый как SQL3. Планируется сделать SQL полным языком по Тьюрингу, т.е. сделать возможными все вычислимые запросы (например рекурсивные запросы). Это очень сложная задача и поэтому завершения нового стандарта не стоит ждать ранее 1999 года. </p>
<p>Реляционная модель данных</p>
Как упоминалось выше, SQL это реляционный язык. Это значит, что он основывается на реляционной модели данных, впервые опубликованной E.F. Codd в 1970 году. Мы дадим формальное описание реляционной модели позже (в Формальное описание реляционной модели данных), но во-первых, мы хотели бы взглянуть на неё с интуитивно понятной стороны. </p>
Реляционная база данных это база данных, которая воспринимается пользователями в виде набора таблиц (и ничего больше кроме таблиц). Таблица состоит из строк и столбцов, где каждая строка означает запись и каждый столбец означает атрибут записи, содержащейся в таблице. В База данных поставщиков и деталей показан пример базы данных, состоящей из трёх таблиц: </p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>SUPPLIER это таблица, в которой хранится номер (SNO), название (SNAME) и город (CITY) поставщика. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>PART это таблица, в которой хранится номер (PNO), название (PNAME) и цена (PRICE) детали. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>В SELLS хранится информация о том какую деталь (PNO) продаёт поставщик (SNO). Она служит в буквальном смысле для объединения двух других таблиц вместе. </td></tr></table></div>Пример 2-1. База данных поставщиков и деталей </p>
<p> &nbsp; SUPPLIER&nbsp;&nbsp; SNO |&nbsp; SNAME&nbsp; |&nbsp; CITY&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SELLS&nbsp;&nbsp; SNO | PNO</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----+---------+--------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----+-----</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp; |&nbsp; Smith&nbsp; | London&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp; |&nbsp; 1</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2&nbsp; |&nbsp; Jones&nbsp; | Paris&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp; |&nbsp; 2</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3&nbsp; |&nbsp; Adams&nbsp; | Vienna&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2&nbsp; |&nbsp; 4</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4&nbsp; |&nbsp; Blake&nbsp; | Rome&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3&nbsp; |&nbsp; 1</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3&nbsp; |&nbsp; 3</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4&nbsp; |&nbsp; 2</p>
<p> &nbsp; PART&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PNO |&nbsp; PNAME&nbsp; |&nbsp; PRICE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4&nbsp; |&nbsp; 3 </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----+---------+---------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4&nbsp; |&nbsp; 4</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp; |&nbsp; Screw&nbsp; |&nbsp;&nbsp; 10</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2&nbsp; |&nbsp; Nut&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp; 8</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3&nbsp; |&nbsp; Bolt&nbsp;&nbsp; |&nbsp;&nbsp; 15</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4&nbsp; |&nbsp; Cam&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp; 25</p>
Таблицы PART и SUPPLIER можно рассматривать как объекты, а SELLS как связь между отдельной деталью и отдельным поставщиком. </p>
Как мы увидим позднее, SQL оперирует таблицами подобно тем, что определены, но перед этим мы изучим теорию реляционной модели. </p>

<p>Формальное описание реляционной модели данных</p>
Математическая концепция, лежащая в основе реляционной модели - это теоретико-множественное отношение, которое является подмножеством декартова произведения набора доменов. Это теоретико-множественное отношение и дало имя этой модели (не путайте с взаимоотношением из Entity-Relationship model). Формально, домен - это просто набор значений. Например, набор целых чисел - это домен. Также, набор символьных строк длинной 20 и дробные числа являются доменами. </p>
Декартово произведение доменов D1, D2, ... Dk записывается как D1 ? D2 ? ... ? Dk - это множество всех k-кортежей v1, v2, ... vk, таких что v1 ? D1, v1 ? D1, ... vk ? Dk. </p>
Например, когда мы имеем k=2, D1={0,1} и D2={a,b,c} то D1 ? D2 is {(0,a),(0,b),(0,c),(1,a),(1,b),(1,c)}. </p>
Отношение - это любое подмножество декартова произведения одного или более доменов: R ? D1 ? D2 ? ... ? Dk. </p>
Например, {(0,a),(0,b),(1,a)} - это отношение; фактически, это подмножество D1 ? D2, упомянутого выше. </p>
Члены отношения называются кортежами. Каждое отношение некоторого декартова произведения D1 ? D2 ? ... ? Dk, говорят, имеет степень k и поэтому это множество k-кортежное. </p>
Отношение можно рассматривать как таблицу (мы это уже делали, вспомни Базу данных поставщиков и деталей, где каждый кортеж представлен строкой и каждая колонка соответствует одному элементу кортежа. Заданные названия (называемые атрибутами) колонок приводят к определению реляционной схемы. </p>
Реляционная схема R - это ограниченное множество атрибутов A1, A2, ... Ak. Существует домен Di для каждого атрибута Ai, 1 &lt;= i &lt;= &lt;TTCLASS="LITERAL"k, откуда берутся значения атрибутов. Мы часто записываем реляционную схему в виде R(A1, A2, ... Ak). </p>
Замечание: Реляционная схема это только шаблон, тогда как отношение - это экземпляр реляционной схемы. Отношение состоит из кортежей (и поэтому может отображаться в виде таблицы); в отличие от реляционной схемы. </p>
<p>Домены и типы данных</p>
В последнем разделе мы часто упоминали о доменах. Вспомним, что домены, формально, просто набор значений (например, набор целых или дробных чисел). В терминах систем баз данных мы часто говорим о типах данных вместо доменов. Когда мы определяем таблицу, мы решаем какие атрибуты включать. Также, мы решаем, какие данные будут храниться как значения атрибутов. Например, значениями SNAME из таблицы SUPPLIER будут символьные строки, тогда как SNO будет содержать целые числа. Мы определили это, назначив тип данных каждому атрибуту. Типом SNAME является VARCHAR(20) (это SQL тип для символьных строк длиной &lt;= 20), типом SNO является INTEGER. Назначая тип данных, мы также выбираем домен для атрибута. Доменом SNAME является множество всех символьных строк длиной &lt;= 20, доменом SNO является множество всех целых значений. </p>

<p>Операции в реляционной модели данных</p>
В предыдущем разделе (Формальное описание реляционной модели данных), мы обозначили математическое представление о реляционной модели. Теперь мы знаем, как можно хранить данные с помощью реляционной модели данных, но мы не знаем что делать с всеми этими таблицами, чтобы получить от базы данных что-нибудь ещё. Например, кто-то хочет узнать имена всех поставщиков, которые продают деталь 'Screw'. Можно определить два различных типа записи отражающих операции над отношениями: </p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Реляционная алгебра т.е. алгебраическое изображение, в котором запросы выражаются с помощью специальных операторов отношений. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Реляционное исчисление т.е. логическое изображение, в котором запросы выражаются с помощью формулирования некоторых логических ограничений, которым должны удовлетворять кортежи. </td></tr></table></div><p>Реляционная алгебра</p>
Реляционная алгебра была представлена E. F. Codd в 1972 году. Она состоит из множества операций над отношениями: </p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>ВЫБОРКА(SELECT) (?): извлечь кортежи из отношения, которые удовлетворяют заданным условиям. Пусть R - таблица, содержащая атрибут A. ?A=a(R) = {t ? R &amp;mid; t(A) = a} где t обозначает кортеж R и t(A) обозначает значение атрибута A кортежа t. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>ПРОЕКЦИЯ(PROJECT) (?): извлечь заданные атрибуты (колонки) из отношения. Пусть R отношение, содержащее атрибут X. ?X(R) = {t(X) &amp;mid; t ? R}, где t(X) обозначает значение атрибута X кортежа t. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>ПРОИЗВЕДЕНИЕ(PRODUCT) (?): построить декартово произведение двух отношений. Пусть R - таблица, со степенью k1 и пусть S таблица со степенью k2. R ? S - это множество всех k1 + k2 - кортежей, где первыми являются k1 элементы кортежа R и где последними являются k2 элементы кортежа S. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>ОБЪЕДИНЕНИЕ(UNION) (?): построить теоретико-множественное объединение двух таблиц. Даны таблицы R и S (обе должны иметь одинаковую степень),объединение R ? S - это множество кортежей, принадлежащих R или S или обоим. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>ПЕРЕСЕЧЕНИЕ(INTERSECT) (?): построить теоретико-множественное пересечение двух таблиц. Даны таблицы R и S, R ? S - это множество кортежей, принадлежащих R и S. Опять необходимо, чтобы R и S имели одинаковую степень. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>ВЫЧИТАНИЕ(DIFFERENCE) (? или &amp;setmn;): построить множество различий двух таблиц. Пусть R и S опять две таблицы с одинаковой степенью. R - S - это множество кортежей R,не принадлежащих S. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>СОЕДИНЕНИЕ(JOIN) (?): соединить две таблицы по их общим атрибутам. Пусть R будет таблицей с атрибутами A,B и C и пусть S будет таблицей с атрибутами C,D и E. Есть один атрибут, общий для обоих отношений,атрибут C. R ? S = ?R.A,R.B,R.C,S.D,S.E(?R.C=S.C(R ? S)). Что же здесь происходит? Во-первых, вычисляется декартово произведение R ? S. Затем, выбираются те кортежи, чьи значения общего атрибута C эквивалентны (?R.C = S.C). Теперь мы имеем таблицу, которая содержит атрибут C дважды и мы исправим это, выбросив повторяющуюся колонку. </td></tr></table></div>Пример 2-2. Внутреннее соединение </p>
Давайте посмотрим на таблицы, которые получаются в результате шагов, необходимых для объединения. Пусть даны следующие две таблицы: </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; R&nbsp;&nbsp; A | B | C&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; S&nbsp;&nbsp; C | D | E</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ---+---+---&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ---+---+---</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1 | 2 | 3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3 | a | b</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4 | 5 | 6&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 6 | c | d</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7 | 8 | 9</p>
Во-первых, мы вычислим декартово произведение R ? S и получим: </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; R x S&nbsp;&nbsp; A | B | R.C | S.C | D | E</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ---+---+-----+-----+---+---</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1 | 2 |&nbsp; 3&nbsp; |&nbsp; 3&nbsp; | a | b</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1 | 2 |&nbsp; 3&nbsp; |&nbsp; 6&nbsp; | c | d</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4 | 5 |&nbsp; 6&nbsp; |&nbsp; 3&nbsp; | a | b</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4 | 5 |&nbsp; 6&nbsp; |&nbsp; 6&nbsp; | c | d</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7 | 8 |&nbsp; 9&nbsp; |&nbsp; 3&nbsp; | a | b</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7 | 8 |&nbsp; 9&nbsp; |&nbsp; 6&nbsp; | c | d</p>
После выборки ?R.C=S.C(R ? S)получим: </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A | B | R.C | S.C | D | E</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ---+---+-----+-----+---+---</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1 | 2 |&nbsp; 3&nbsp; |&nbsp; 3&nbsp; | a | b</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4 | 5 |&nbsp; 6&nbsp; |&nbsp; 6&nbsp; | c | d</p>
Удалить повторяющуюся колонку S.C можно с помощью проекции следующей операцией: ?R.A,R.B,R.C,S.D,S.E(?R.C=S.C(R ? S))и получим: </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A | B | C | D | E</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ---+---+---+---+---</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1 | 2 | 3 | a | b</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4 | 5 | 6 | c | d</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>ДЕЛЕНИЕ(DIVIDE) (?): Пусть R будет таблицей с атрибутами A, B, C, и D и пусть S будет таблицей с атрибутами C и D. Мы можем определить деление как: R ? S = {t &amp;mid; ? ts ? S ? tr ? R так, что tr(A,B)=t?tr(C,D)=ts} где tr(x,y)означает кортеж таблицы R, который состоит только из элементов x и y. Заметим, что кортеж t состоит только из элементов A и B отношения R. </td></tr></table></div>Зададим следующие таблицы </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; R&nbsp;&nbsp; A | B | C | D&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; S&nbsp;&nbsp; C | D</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ---+---+---+---&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ---+---</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; a | b | c | d&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; c | d</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; a | b | e | f&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; e | f</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; b | c | e | f</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; e | d | c | d</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; e | d | e | f</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; a | b | d | e</p>
R ? S получается </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A | B</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ---+---</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; a | b</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; e | d</p>
Более подробное описание и определение реляционной алгебры смотри у [Ullman, 1988 год] или [Дейта, 1994 год]. </p>
Пример 2-3. Запрос с использованием реляционной алгебры </p>
Вспомним, что мы формулируем все эти реляционные операторы для того чтобы получить данные из базы данных. Давайте вернёмся к нашему примеру из предыдущего раздела (Операции в реляционной модели данных), где кто-то захотел узнать имена всех поставщиков, продающих деталь Screw. На этот вопрос можно ответить, используя следующие операции реляционной алгебры: </p>
<p>?SUPPLIER.SNAME(?PART.PNAME='Screw'(SUPPLIER ? SELLS ? PART))</p>
Мы назовём такую операцию запросом. Если мы применим, приведённый выше запрос к таблицам нашего примера (База данных поставщиков и деталей), то получим следующий результат: </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SNAME</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Smith</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Adams</p>
<p>Реляционное исчисление</p>
Реляционное исчисление основано на логике первого порядка. Если два варианта реляционного исчисления: </p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>The Исчисление доменов (DRC), где переменными являются элементы (атрибуты) кортежа. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>The исчисление кортежей (TRC), где переменными являются кортежи. </td></tr></table></div>Мы хотим обсудить исчисление кортежей потомучто оно лежит в основе большинства реляционных языков. Подробное обсуждение DRC (и также TRC) смотри у [Дейта, 1994 год] или [Ullman, 1988 год]. </p>
<p>Исчисление кортежей</p>
Запросы, использующие TRC, представлены в следующем виде: x(A) &amp;mid; F(x) где x - это переменная кортежа, A - это множество атрибутов и F - формула. Результирующие отношение состоит из всех кортежей t(A), которые удовлетворяют F(t). </p>
Если мы хотим ответить на вопрос из примера Запрос с использованием реляционной алгебры, с помощью TRC, то мы сформулируем следующий запрос: </p>
<p> &nbsp;&nbsp;&nbsp; {x(SNAME) &amp;mid; x ? SUPPLIER ? \nonumber</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ? y ? SELLS ? z ? PART (y(SNO)=x(SNO) ? \nonumber</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; z(PNO)=y(PNO) ? \nonumber</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; z(PNAME)='Screw')} \nonumber</p>
Вычисление запроса над таблицами из Базы данных поставщиков и товаров опять приведёт к тому же результату что и в Запрос с использованием реляционной алгебры. </p>
<p>Реляционная алгебра и реляционное исчисление</p>
Реляционная алгебра и реляционное исчисление имеют одинаковую выражающую мощность; т.е. все запросы, которые можно сформулировать с помощью реляционной алгебры, могут быть также сформулированы с помощью реляционного исчисления и наоборот. Первым это доказал E. F. Codd в 1972 году. Это доказательство основано на алгоритме (&#8220;алгоритм редукции Кодда&#8221;) по которому произвольное выражение реляционного исчисления может быть сокращено до семантически эквивалентного выражения реляционной алгебры. Более подробное обсуждение смотри у [Дейта, 1994 год] и [Ullman, 1988 год]. </p>
Иногда говорят, что языки, основанные на реляционном исчислении "высокоуровневые" или "более описательные", чем языки, основанные на реляционной алгебре, потому что алгебра (частично) задаёт порядок операций, тогда как исчисление оставляет компилятору или интерпретатору определять наиболее эффективный порядок вычисления. </p>
<p>Язык SQL</p>
Как и большинство современных реляционных языков, SQL основан на исчислении кортежей. В результате, каждый запрос, сформулированный с помощью исчисления кортежей (или иначе говоря, реляционной алгебры), может быть также сформулирован с помощью SQL. Однако, он имеет способности, лежащие за пределами реляционной алгебры или исчисления. Вот список некоторых дополнительных свойств, предоставленных SQL, которые не являются частью реляционной алгебры или исчисления: </p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Команды вставки, удаления или изменения данных. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Арифметические возможности: в SQL возможно вызвать арифметические операции, так же как и сравнения, например A &lt; B + 3. Заметим, что + или других арифметических операторов нет ни в реляционной алгебре ни в реляционном исчислении. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Команды присвоения и печати: возможно напечатать отношение, созданное запросом и присвоить вычисленному отношению имя отношения. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Итоговые функции: такие операции как average, sum, max, и т.д. могут применяться к столбцам отношения для получения единичной величины. </td></tr></table></div><p>Выборка</p>
Наиболее часто используемая команда SQL - это оператор SELECT, используемый для получения данных. Синтаксис: </p>
<p> &nbsp; SELECT [ALL|DISTINCT] </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; { * | expr_1</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [AS c_alias_1] [, ... </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [, expr_k [AS c_alias_k]]]}</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FROM table_name_1</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [t_alias_1] </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [, ... [, table_name_n</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [t_alias_n]]]</p>
<p> &nbsp; [WHERE condition]</p>
<p> &nbsp; [GROUP BY name_of_attr_i </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [,... [, name_of_attr_j</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ]] [HAVING condition]]</p>
<p> &nbsp; [{UNION [ALL] | INTERSECT | EXCEPT} SELECT ...]</p>
<p> &nbsp; [ORDER BY name_of_attr_i </p>
<p> &nbsp; [ASC|DESC]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [, ... [, name_of_attr_j [ASC|DESC]]]];</p>
Сейчас на различных примерах, мы покажем сложные выражения оператора SELECT. Таблицы, используемые в примерах, определены в Базе данных поставщиков и деталей. </p>
<p>Простые выборки</p>
Вот несколько простых примеров использования оператора SELECT: </p>
Пример 2-4. Простой ограничивающий запрос </p>
Получить все кортежи из таблицы PART, где атрибут PRICE больше 10: </p>
<p> &nbsp; SELECT * FROM PART</p>
<p> &nbsp;&nbsp;&nbsp; WHERE PRICE &gt; 10;</p>
<p>Получаемая таблица:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PNO |&nbsp; PNAME&nbsp; |&nbsp; PRICE</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----+---------+--------</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3&nbsp; |&nbsp; Bolt&nbsp;&nbsp; |&nbsp;&nbsp; 15</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4&nbsp; |&nbsp; Cam&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp; 25</p>
Использовав "*" в операторе SELECT, получаем все атрибуты из таблицы. Если мы хотим получить только атрибуты PNAME и PRICE из таблицы PART, то используем следующее выражение: </p>
<p> &nbsp; SELECT PNAME, PRICE </p>
<p> &nbsp; FROM PART</p>
<p> &nbsp; WHERE PRICE &gt; 10;</p>
<p>В этом случае получим:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PNAME&nbsp; |&nbsp; PRICE</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------+--------</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bolt&nbsp;&nbsp; |&nbsp;&nbsp; 15</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cam&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp; 25</p>
<p>Заметим, что SQL SELECT соответствует "проекции" в реляционной алгебре, а не "выборке" (подробней смотри Реляционная алгебра). </p>
Ограничения в операторе WHERE могут также быть логически соединены с помощью ключевых слов OR, AND, и NOT: </p>
<p> &nbsp; SELECT PNAME, PRICE </p>
<p> &nbsp; FROM PART</p>
<p> &nbsp; WHERE PNAME = 'Bolt' AND</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (PRICE = 0 OR PRICE &lt; 15);</p>
<p>приведёт к результату:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PNAME&nbsp; |&nbsp; PRICE</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------+--------</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bolt&nbsp;&nbsp; |&nbsp;&nbsp; 15</p>
Арифметические операции могут использоваться в списке объектов и операторе WHERE. Например, если нам надо знать сколько будут стоить две штуки одной детали, то используем следующий запрос: </p>
<p> &nbsp; SELECT PNAME, PRICE * 2 AS DOUBLE</p>
<p> &nbsp; FROM PART</p>
<p> &nbsp; WHERE PRICE * 2 &lt; 50;</p>
<p>и мы получим:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PNAME&nbsp; |&nbsp; DOUBLE</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------+---------</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Screw&nbsp; |&nbsp;&nbsp;&nbsp; 20</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nut&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp; 16</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bolt&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp; 30</p>
<p>Заметим, что слово DOUBLE после ключевого слова AS - это новый заголовок второго столбца. Эта техника может быть использована для любого элемента списка объектов, для того чтобы задать новый заголовок столбцу результата. Этот новый заголовок часто называют псевдонимом. Псевдонимы не могут просто использоваться в запросе. </p>
<p>Соединения</p>
Следующий пример показывает, как осуществлять соединения в SQL. </p>
Для объединения трёх таблиц SUPPLIER, PART и SELLS по их общим атрибутам, мы формулируем следующее выражение: </p>
<p> &nbsp; SELECT S.SNAME, P.PNAME</p>
<p> &nbsp; FROM SUPPLIER S, PART P, SELLS SE</p>
<p> &nbsp; WHERE S.SNO = SE.SNO AND</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; P.PNO = SE.PNO;</p>
<p>и получаем следующую таблицу в качестве результата:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SNAME | PNAME</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------+-------</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Smith | Screw</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Smith | Nut</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Jones | Cam</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Adams | Screw</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Adams | Bolt</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Blake | Nut</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Blake | Bolt</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Blake | Cam</p>
В операторе FROM мы вводим псевдоним имени для каждого отношения, так как в отношениях есть общие названия атрибутов (SNO и PNO). Теперь мы можем различить общие имена атрибутов, просто предварив имя атрибута псевдонимом с точкой. Соединение вычисляется тем же путём, как показано во внутреннем соединением. Во-первых, определяется декартово произведение SUPPLIER ? PART ? SELLS. Потом выбираются только те кортежи, которые удовлетворяют условиям, заданным в операторе WHERE (т.е. где общие именованные атрибуты равны).Наконец, убираются все колонки кроме S.SNAME и P.PNAME. </p>
<p>Итоговые операторы</p>
SQL снабжён итоговыми операторами (например AVG, COUNT, SUM, MIN, MAX), которые принимают название атрибута в качестве аргумента. Значение итогового оператора высчитывается из всех значений заданного атрибута(столбца) всей таблицы. Если в запросе указана группа, то вычисления выполняются только над значениями группы (смотри следующий раздел). </p>
Пример 2-5. Итоги </p>
Если мы хотим узнать среднюю стоимость всех деталей в таблице PART, то используем следующий запрос: </p>
<p> &nbsp; SELECT AVG(PRICE) AS AVG_PRICE</p>
<p> &nbsp; FROM PART;</p>
<p> Результат:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; AVG_PRICE</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----------</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 14.5</p>
Если мы хотим узнать количество деталей, хранящихся в таблице PART, то используем выражение: </p>
<p> &nbsp; SELECT COUNT(PNO)</p>
<p> &nbsp; FROM PART;</p>
<p>и получим:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; COUNT</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4</p>
<p>Итоги по группам</p>
SQL позволяет разбить кортежи таблицы на группы. После этого итоговые операторы, описанные выше, могут применяться к группам (т.е. значение итогового оператора вычисляется не из всех значений указанного столбца, а над всеми значениями группы. Таким образом, итоговый оператор вычисляет индивидуально для каждой группы.) </p>
Разбиение кортежей на группы выполняется с помощью ключевых слов GROUP BY и следующим за ними списком атрибутов, которые определяют группы.Если мы имеем GROUP BY A1, &amp;tdot;, Ak мы разделяем отношение на группы так, что два кортежа будут в одной группе, если у них соответствуют все атрибуты A1, &amp;tdot;, Ak. </p>
Пример 2-6. Итоги </p>
Если мы хотим узнать сколько деталей продаёт каждый поставщик, то мы так сформулируем запрос: </p>
<p> &nbsp; SELECT S.SNO, S.SNAME, COUNT(SE.PNO)</p>
<p> &nbsp; FROM SUPPLIER S, SELLS SE</p>
<p> &nbsp; WHERE S.SNO = SE.SNO</p>
<p> &nbsp; GROUP BY S.SNO, S.SNAME;</p>
<p>и получим:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SNO | SNAME | COUNT</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----+-------+-------</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp; | Smith |&nbsp;&nbsp; 2</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2&nbsp; | Jones |&nbsp;&nbsp; 1</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3&nbsp; | Adams |&nbsp;&nbsp; 2</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4&nbsp; | Blake |&nbsp;&nbsp; 3</p>
Теперь давайте посмотрим что здесь происходит. Во-первых, соединяются таблицы SUPPLIER и SELLS: </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; S.SNO | S.SNAME | SE.PNO</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------+---------+--------</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp;&nbsp; |&nbsp; Smith&nbsp; |&nbsp;&nbsp; 1</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp;&nbsp; |&nbsp; Smith&nbsp; |&nbsp;&nbsp; 2</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2&nbsp;&nbsp; |&nbsp; Jones&nbsp; |&nbsp;&nbsp; 4</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3&nbsp;&nbsp; |&nbsp; Adams&nbsp; |&nbsp;&nbsp; 1</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3&nbsp;&nbsp; |&nbsp; Adams&nbsp; |&nbsp;&nbsp; 3</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4&nbsp;&nbsp; |&nbsp; Blake&nbsp; |&nbsp;&nbsp; 2</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4&nbsp;&nbsp; |&nbsp; Blake&nbsp; |&nbsp;&nbsp; 3</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4&nbsp;&nbsp; |&nbsp; Blake&nbsp; |&nbsp;&nbsp; 4</p>
Затем, мы разбиваем кортежи на группы, помещая все кортежи вместе, у которых соответствуют оба атрибута S.SNO и S.SNAME: </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; S.SNO | S.SNAME | SE.PNO</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------+---------+--------</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp;&nbsp; |&nbsp; Smith&nbsp; |&nbsp;&nbsp; 1</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp; 2</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------------------------</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2&nbsp;&nbsp; |&nbsp; Jones&nbsp; |&nbsp;&nbsp; 4</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------------------------</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3&nbsp;&nbsp; |&nbsp; Adams&nbsp; |&nbsp;&nbsp; 1</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp; 3</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------------------------</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4&nbsp;&nbsp; |&nbsp; Blake&nbsp; |&nbsp;&nbsp; 2</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp; 3</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp; 4</p>
В нашем примере мы получили четыре группы и теперь мы можем применить итоговый оператор COUNT для каждой группы для получения итогового результата запроса, данного выше. </p>
Заметим, что для получения результата запроса, использующего GROUP BY и итоговых операторов, атрибуты сгруппированных значений должны также быть в списке объектов. Все остальные атрибуты, которых нет в выражении GROUP BY, могут быть выбраны при использовании итоговых функций. С другой стороны ты можешь не использовать итоговые функции на атрибутах, имеющихся в выражении GROUP BY. </p>
<p>Having</p>
Оператор HAVING выполняет ту же работу что и оператор WHERE, но принимает к рассмотрению только те группы, которые удовлетворяют определению оператора HAVING. Выражения в операторе HAVING должны вызывать итоговые функции. Каждое выражение, использующее только простые атрибуты, принадлежат оператору WHERE. С другой стороны каждое выражение вызывающее итоговую функцию должно помещаться в оператор HAVING. </p>
Пример 2-7. Having </p>
Если нас интересуют поставщики, продающие более одной детали, используем запрос: </p>
<p> &nbsp; SELECT S.SNO, S.SNAME, COUNT(SE.PNO)</p>
<p> &nbsp; FROM SUPPLIER S, SELLS SE</p>
<p> &nbsp; WHERE S.SNO = SE.SNO</p>
<p> &nbsp; GROUP BY S.SNO, S.SNAME</p>
<p> &nbsp; HAVING COUNT(SE.PNO) &gt; 1;</p>
<p>и получим:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SNO | SNAME | COUNT</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----+-------+-------</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp; | Smith |&nbsp;&nbsp; 2</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3&nbsp; | Adams |&nbsp;&nbsp; 2</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4&nbsp; | Blake |&nbsp;&nbsp; 3</p>
<p>Подзапросы</p>
В операторах WHERE и HAVING используются подзапросы (вложенные выборки), которые разрешены в любом месте, где ожидается значение. В этом случае значение должно быть получено предварительно подсчитав подзапрос. Использование подзапросов увеличивает выражающую мощность SQL. </p>
Пример 2-8. Вложенная выборка </p>
Если мы хотим узнать все детали, имеющие цену больше чем деталь 'Screw', то используем запрос: </p>
<p> &nbsp; SELECT * </p>
<p> &nbsp; FROM PART </p>
<p> &nbsp; WHERE PRICE &gt; (SELECT PRICE FROM PART</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; WHERE PNAME='Screw');</p>
<p> Результат:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PNO |&nbsp; PNAME&nbsp; |&nbsp; PRICE</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----+---------+--------</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3&nbsp; |&nbsp; Bolt&nbsp;&nbsp; |&nbsp;&nbsp; 15</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4&nbsp; |&nbsp; Cam&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp; 25</p>
Если мы посмотрим на запрос выше, то увидим ключевое слово SELECT два раза. Первый начинает запрос - мы будем называть его внешним запросом SELECT - и второй в операторе WHERE, который начинает вложенный запрос - мы будем называть его внутренним запросом SELECT. Для каждого кортежа внешнего SELECT внутренний SELECT необходимо вычислить. После каждого вычисления мы узнаём цену кортежа с названием 'Screw' и мы можем проверить выше ли цена из текущего кортежа. </p>
Если мы хотим узнать поставщиков, которые ничего не продают (например, чтобы удалить этих поставщиков из базы данных) используем: </p>
<p> &nbsp; SELECT * </p>
<p> &nbsp; FROM SUPPLIER S</p>
<p> &nbsp; WHERE NOT EXISTS</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (SELECT * FROM SELLS SE</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; WHERE SE.SNO = S.SNO);</p>
В нашем примере результат будет пустым, потому что каждый поставщик продаёт хотя бы одну деталь. Заметим, что мы использовали S.SNO из внешнего SELECT внутри оператора WHERE в внутреннем SELECT. Как описывалось выше подзапрос вычисляется для каждого кортежа из внешнего запроса т.е. значение для S.SNO всегда берётся из текущего кортежа внешнего SELECT. </p>
<p>Объединение, пересечение, исключение</p>
Эти операции вычисляют объединение, пересечение и теоретико-множественное вычитание кортежей из двух подзапросов. </p>
Пример 2-9. Объединение, пересечение, исключение </p>
Следующий запрос - пример для UNION(объединение): </p>
<p> &nbsp; SELECT S.SNO, S.SNAME, S.CITY</p>
<p> &nbsp; FROM SUPPLIER S</p>
<p> &nbsp; WHERE S.SNAME = 'Jones'</p>
<p> &nbsp; UNION</p>
<p> &nbsp; SELECT S.SNO, S.SNAME, S.CITY</p>
<p> &nbsp; FROM SUPPLIER S</p>
<p> &nbsp; WHERE S.SNAME = 'Adams';&nbsp;&nbsp;&nbsp; </p>
<p>даёт результат:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SNO | SNAME |&nbsp; CITY</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----+-------+--------</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2&nbsp; | Jones | Paris</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3&nbsp; | Adams | Vienna</p>
<p>Вот пример для INTERSECT(пересечение):</p>
<p> &nbsp; SELECT S.SNO, S.SNAME, S.CITY</p>
<p> &nbsp; FROM SUPPLIER S</p>
<p> &nbsp; WHERE S.SNO &gt; 1</p>
<p> &nbsp; INTERSECT</p>
<p> &nbsp; SELECT S.SNO, S.SNAME, S.CITY</p>
<p> &nbsp; FROM SUPPLIER S</p>
<p> &nbsp; WHERE S.SNO &gt; 2;</p>
<p>даёт результат:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SNO | SNAME |&nbsp; CITY</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----+-------+--------</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2&nbsp; | Jones | Paris</p>
<p>Возвращаются только те кортежи, которые есть в обоих частях запроса</p>
<p>и имеют $SNO=2$.</p>
<p> Наконец, пример для EXCEPT(исключение):</p>
<p> &nbsp; SELECT S.SNO, S.SNAME, S.CITY</p>
<p> &nbsp; FROM SUPPLIER S</p>
<p> &nbsp; WHERE S.SNO &gt; 1</p>
<p> &nbsp; EXCEPT</p>
<p> &nbsp; SELECT S.SNO, S.SNAME, S.CITY</p>
<p> &nbsp; FROM SUPPLIER S</p>
<p> &nbsp; WHERE S.SNO &gt; 3;</p>
<p>даёт результат:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SNO | SNAME |&nbsp; CITY</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----+-------+--------</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2&nbsp; | Jones | Paris</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3&nbsp; | Adams | Vienna</p>
<p>Определение данных</p>
Существует набор команд, использующихся для определения данных, включенных в язык SQL. </p>
<p>Создание таблицы</p>
Самая основная команда определения данных - это та, которая создаёт новое отношение (новую таблицу). Синтаксис команды CREATE TABLE: </p>
<p> &nbsp; CREATE TABLE table_name</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (name_of_attr_1</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; type_of_attr_1</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [, name_of_attr_2</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; type_of_attr_2 </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [, ...]]);</p>
Пример 2-10. Создание таблицы </p>
Для создания таблиц, определённых в Базе данных поставщиков и деталей, используются следующие SQL выражения: </p>
<p> &nbsp; CREATE TABLE SUPPLIER</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (SNO&nbsp;&nbsp; INTEGER,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SNAME VARCHAR(20),</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CITY&nbsp; VARCHAR(20));</p>

<p> &nbsp; CREATE TABLE PART</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (PNO&nbsp;&nbsp; INTEGER,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PNAME VARCHAR(20),</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PRICE DECIMAL(4 , 2));</p>

<p> &nbsp; CREATE TABLE SELLS</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (SNO INTEGER,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PNO INTEGER);</p>
<p>Типы данных SQL</p>
Вот список некоторых типов данных, которые поддерживает SQL: </p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>INTEGER: знаковое полнословное двоичное целое (31 бит для представления данных). </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>SMALLINT: знаковое полсловное двоичное целое (15 бит для представления данных). </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>DECIMAL (p [,q]): знаковое упакованное десятичное число с p знаками представления данных, с возможным q знаками справа от десятичной точки. (15 ? p ? qq ? 0). Если q опущено, то предполагается что оно равно 0. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>FLOAT: знаковое двусловное число с плавающей точкой. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>CHAR(n): символьная строка с постоянной длиной n. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>VARCHAR(n): символьная строка с изменяемой длиной, максимальная длина n. </td></tr></table></div><p>Создание индекса</p>
Индексы используются для ускорения доступа к отношению. Если отношение R проиндексировано по атрибуту A, то мы можем получить все кортежи tимеющие t(A) = a за время приблизительно пропорциональное числу таких кортежей t, в отличие от времени, пропорциональному размеру R. </p>
Для создания индекса в SQL используется команда CREATE INDEX. Синтаксис: </p>
<p> &nbsp; CREATE INDEX index_name </p>
<p> &nbsp; ON table_name ( name_of_attribute );</p>
Пример 2-11. Создание индекса </p>
Для создания индекса с именем I по атрибуту SNAME отношения SUPPLIER используем следующее выражение: </p>
<p> &nbsp; CREATE INDEX I</p>
<p> &nbsp; ON SUPPLIER (SNAME);</p>
Созданный индекс обслуживается автоматически, т.е. при вставке ново кортежа в отношение SUPPLIER, индекс I будет перестроен. Заметим, что пользователь может ощутить изменения в при существовании индекса только по увеличению скорости. </p>
<p>Создание представлений</p>
Представление можно рассматривать как виртуальную таблицу, т.е. таблицу, которая в базе данных не существует физически, но для пользователя она как-бы там есть. По сравнению, если мы говорим о базовой таблице, то мы имеем в виду таблицу, физически хранящую каждую строку где-то на физическом носителе. </p>
Представления не имеют своих собственных, физически самостоятельных, различимых хранящихся данных. Вместо этого, система хранит определение представления (т.е. правила о доступе к физически хранящимся базовым таблицам в порядке претворения их в представление) где-то в системных каталогах (смотри Системные каталоги). Обсуждение различных технологий реализации представлений смотри в SIM98. </p>
Для определения представлений в SQL используется команда CREATE VIEW. Синтаксис: </p>
<p> &nbsp; CREATE VIEW view_name</p>
<p> &nbsp; AS select_stmt</p>
<p>где select_stmt, допустимое выражение выборки, как определено в Выборка. Заметим, что select_stmt не выполняется при создании представления. Оно только сохраняется в системных каталогах и выполняется всякий раз когда делается запрос представления. </p>
Пусть дано следующее определение представления (мы опять используем таблицы из Базы данных поставщиков и деталей): </p>
<p> &nbsp; CREATE VIEW London_Suppliers</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; AS SELECT S.SNAME, P.PNAME</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FROM SUPPLIER S, PART P, SELLS SE</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; WHERE S.SNO = SE.SNO AND</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; P.PNO = SE.PNO AND</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; S.CITY = 'London';</p>
Теперь мы можем использовать это виртуальное отношение London_Suppliers как если бы оно было ещё одной базовой таблицей: </p>
<p> &nbsp; SELECT *</p>
<p> &nbsp; FROM London_Suppliers</p>
<p> &nbsp; WHERE P.PNAME = 'Screw';</p>
<p>которое возвращает следующую таблицу:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SNAME | PNAME</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------+-------</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Smith | Screw&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
Для вычисления этого результата система базы данных в начале выполняет скрытый доступ к базовым таблицам SUPPLIER, SELLS и PART. Это делается с помощью выполнения заданных запросов в определении представления к этим базовым таблицам. После, это дополнительное определедение (заданное в запросе к представлению) можно использовать для получения результирующей таблицы. </p>
<p>Drop Table, Drop Index, Drop View</p>
Для уничтожения таблицы (включая все кортежи, хранящиеся в этой таблице) используется команда DROP TABLE: </p>
<p> &nbsp; DROP TABLE table_name;</p>
Для уничтожения таблицы SUPPLIER используется следующее выражение: </p>
<p> &nbsp; DROP TABLE SUPPLIER;</p>
<p> Команда DROP INDEX используется для уничтожения индекса:</p>
<p> &nbsp; DROP INDEX index_name;</p>
<p>Наконец, для уничтожения заданного представления используется</p>
<p>команда DROP VIEW:</p>
<p> &nbsp; DROP VIEW view_name;</p>
<p>Манипулирование данными</p>
<p>Insert Into</p>
После создания таблицы (смотри Создание таблицы), её можно заполнять кортежами с помощью команды INSERT INTO. Синтаксис: </p>
<p> &nbsp; INSERT INTO table_name (name_of_attr_1 </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [, name_of_attr_2 [,...]])</p>
<p> &nbsp; VALUES (val_attr_1 </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [, val_attr_2 [, ...]]);</p>
Чтобы вставить первый кортеж в отношение SUPPLIER (из База данных поставщиков и деталей) мы используем следующее выражение: </p>
<p> &nbsp; INSERT INTO SUPPLIER (SNO, SNAME, CITY)</p>
<p> &nbsp; VALUES (1, 'Smith', 'London');</p>
<p> Чтобы вставить первый кортеж в отношение SELLS используется:</p>
<p> &nbsp; INSERT INTO SELLS (SNO, PNO)</p>
<p> &nbsp; VALUES (1, 1);</p>
<p>Обновление</p>
Для изменения одного или более значений атрибутов кортежей в отношении используется команда UPDATE. Синтаксис: </p>
<p> &nbsp; UPDATE table_name</p>
<p> &nbsp; SET name_of_attr_1 = value_1 </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [, ... [, name_of_attr_k = value_k]]</p>
<p> &nbsp; WHERE condition;</p>
Чтобы изменить значение атрибута PRICE детали 'Screw' в отношении PART используется: </p>
<p> &nbsp; UPDATE PART</p>
<p> &nbsp; SET PRICE = 15</p>
<p> &nbsp; WHERE PNAME = 'Screw';</p>
<p>Новое значение атрибута PRICE кортежа, чьё имя равно 'Screw' теперь стало 15. </p>
<p>Удаление</p>
Для удаления кортежа из отдельной таблицы используется команда DELETE FROM. Синтаксис: </p>
<p> &nbsp; DELETE FROM table_name</p>
<p> &nbsp; WHERE condition;</p>
Чтобы удалить поставщика называемого 'Smith', из таблицы SUPPLIER используем следующее выражение: </p>
<p> &nbsp; DELETE FROM SUPPLIER</p>
<p> &nbsp; WHERE SNAME = 'Smith';</p>
<p>Системные каталоги</p>
В каждой системе базы данных SQL определены системные каталоги, которые используются для хранения записей о таблицах, представлениях, индексах и т.д. К системным каталогам также можно строить запросы, как если бы они были нормальными отношениями. Например, один каталог используется для определения представлений. В этом каталоге хранятся запросы об определении представлений. Всякий раз когда делается запрос к представлению, система сначала берёт запрос определения представления из этого каталога и материализует представление перед тем, как обработать запрос пользователя (подробное описание смотри в SIM98). Более полную информацию о системных каталогах смотри у Дейта. </p>
<p>Встраивание SQL</p>
В этом разделе мы опишем в общих чертах как SQL может быть встроен в конечный язык (например в C). Есть две главных причины, по которым мы хотим пользоваться SQL из конечного языка: </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Существуют запросы, которые нельзя сформулировать на чистом SQL(т.е. рекурсивные запросы). Чтобы выполнить такие запросы, нам необходим конечный язык, обладающий большей мощностью выразительности, чем SQL. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Просто нам необходим доступ к базе данных из другого приложения, которое написано на конечном языке (например, система бронирования билетов с графическим интерфейсом пользователя написана на C и информация об оставшихся билетах хранится в базе данных, которую можно получить с помощью встроенного SQL). </td></tr></table></div>Программа, использующая встроенный SQL в конечном языке, состоит из выражений конечного языка и выражений встроенного SQL (ESQL). Каждое выражение ESQL начинается с ключевых слов EXEC SQL. Выражения ESQL преобразуются в выражения на конечном языке с помощью прекомпилятора (который обычно вставляет вызовы библиотечных процедур, которые выполняют различные команды SQL). </p>
Если мы посмотрим на все примеры из Выборка мы поймём, что результатом запроса очень часто являются множество кортежей. Большинство конечных языков не предназначено для работы с множествами, поэтому нам нужен механизм доступа к каждому отдельному кортежу из множества кортежей, возвращаемого выражением SELECT. Этот механизм можно предоставить, определив курсор. После этого, мы можем использовать команду FETCH для получения кортежа и установления курсора на следующий кортеж. </p>

<p>Архитектурные концепции Postgres</p>
Перед тем как мы начнём, ты должен понимать основы архитектуры системы Postgres. Понимание того, как части Postgres взаимодействуют друг с другом, поможет сделать следующую главу отчасти понятней. На жаргоне баз данных, Postgres использует простую "один процесс на пользователя" модель клиент/сервер. Работающий Postgres состоит из следующих взаимодействующих процессов Unix (программ): </p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Контролирующий процесс демон (postmaster), </td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>клиентское приложение пользователя (например, программа psql), </td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>одна или более серверных частей базы данных (сам процесс postgres). </td></tr></table></div>Отдельный postmaster управляет заданным набором баз данных на отдельном хосте. Такой набор баз данных называется установочным или сайтом. Клиентские приложения, которые хотят получить доступ к определенной базе данных в установочном наборе делают вызовы к библиотеке. Библиотека посылает запросы пользователя по сети postmaster (Как устанавливается соединение), который запускает новый очередной серверный процесс </p>
Рисунок 3-1. Как устанавливается соединение </p>
<img src="/pic/embim1738.png" width="288" height="96" vspace="1" hspace="1" border="0" alt=""><br>
<p>и соединяет клиентский процесс с новым сервером. С этого места, клиентский процесс и и серверная часть взаимодействуют без вмешательства postmaster. Поэтому, postmaster всегда запущен, ждет запросов, несмотря на то, что клиентский и серверный процессы приходят и уходят. </p>
Библиотека libpq позволяет одному клиенту делать несколько подключений к серверным процессам. Однако, клиентское приложение все же является однопотоковым процессом. Многопотоковые клиент/серверные соединения в настоящий момент не поддерживаются в libpq. Смысл этой архитектуры в том, что postmaster и сервер всегда запущены на одной машине (сервере баз данных), в то время как клиентское приложение может работать где-то еще. Ты должен помнить об этом, потому что файлы, которые доступны на клиентской машине могут быть недоступны (или доступны, но под другим именем) на машине сервере баз данных. </p>
Также, ты должен знать, что postmaster и postgres сервера запускаются с id пользователя Postgres "суперпользователь." Заметим, что суперпользователь Postgres не должен быть специальным пользователем (например, пользователем с именем "postgres"). Более того, суперпользователь Postgres определенно не должен быть суперпользователем Unix ("root")! В любом случае, все файлы относящиеся к базе данных, должны принадлежать суперпользователю Postgres. </p>

<p>Начнём</p>
<p>Оглавление </p>
<p>Настройка среды </p>
<p>Запуск интерактивного монитора (psql) </p>
<p>Управление базой данных </p>
С чего начать работу с Postgres новому пользователю.</p>
Некоторые шаги, необходимые для использования Postgres могут быть выполнены любым пользователем Postgres, а некоторые должны выполняться администратором базы данных сайта. Администратор сайта - это человек, который устанавливает программное обеспечение, создает каталоги базы данных и запускает процесс postmaster. Это человек не должен быть суперпользователем Unix (&#8220;root&#8221;) или компьютерным системным администратором; человек может устанавливать и использовать Postgres без специальных бюджетов или привилегий. </p>
Если ты устанавливаешь Postgres сам, то посмотри в Руководстве администратора инструкции по установке, и вернись к этому руководству когда установка закончится. </p>
Во всех примерах этого руководства начальным символом &#8220;%&#8221; отмечены команды, которые должны быть набраны в командной строке Unix. Примеры, которые начинаются с символа &#8220;*&#8221; - это команды на языке запросов Postgres SQL. </p>
<p>Настройка среды</p>
В этом разделе обсуждается как настроить среду, так чтобы можно было использовать клиентские приложения. Предполагается, что Postgres был уже успешно установлен и запущен; смотри Руководство администратора и замечания по установке, о том как установить Postgres. </p>
Postgres - это приложение клиент/сервер. Пользователю необходим доступ только к клиентской части установки (например, такое клиентское приложение как интерактивный монитор psql). Для простоты предполагается, что Postgres установлен в каталог /usr/local/pgsql. Поэтому, если ты видишь каталог /usr/local/pgsql, то вместо него нужно подставить название каталога где установлен Postgres. Все команды Postgres установлены в каталоге /usr/local/pgsql/bin. Поэтому, нужно добавить этот каталог в путь к командам shell. Если используются различные Berkeley C shell, такие как csh или tcsh, то нужно добавить </p>
<p>% set path = ( /usr/local/pgsql/bin path )</p>
<p>в файл .login в домашний каталог пользователя. Если используются различные Bourne shell, такие как sh, ksh, или bash, то нужно добавить </p>
<p>% PATH=/usr/local/pgsql/bin:$PATH</p>
<p>% export PATH</p>
<p>в файл .profile в домашний каталог пользователя. Отсюда предполагается, что bin каталог Postgres добавлен в путь. Кроме того, мы будем часто упоминать &#8220;установка переменных shell&#8221; или &#8220;установка переменных среды&#8221; во всём этом документе. Если ты полностью не понял последний параграф про изменение пути поиска, то почитай страницы руководства Unix, которые описывают shell, перед тем как двигаться дальше. </p>
Если администратор сайта не установил это по умолчанию, то тебе необходимо выполнить еще кое-какую работу. Например, если сервер базы данных - удаленная машина, то нужно задать в переменной среды PGHOST имя машины сервера базы данных. Можно также установить PGPORT. И напоследок: если ты пытаешься запустить программу приложение и она жалуется что не может подключиться к postmaster, то тебе немедленно нужно проконсультироваться у администратора сайта чтобы убедиться что среда правильно настроена. </p>

<p>Запуск интерактивного монитора (psql)</p>
Предполагается, что администратор сайта правильно запустил процесс postmaster и у тебя есть право использовать базу данных, и ты (пользователь) можешь запускать приложения. Как упоминалось выше, ты должен добавить /usr/local/pgsql/bin в свой путь поиска shell. В большинстве случаев, это все приготовления, которые необходимо сделать. </p>
Как и в Postgres v6.3, есть два стиля подключения. Администратор сайта может позволить подключаться через сетевое соединение TCP/IP или ограничиться доступом к базе данных только локальной машиной (той же машиной) подключением через сокеты. Этот выбор становится значимым, если ты столкнулся с проблемой в подключении к базе данных. </p>
Если ты получил следующие сообщения об ошибках при командах Postgres (таких как psql или createdb): </p>
<p>% psql template1</p>
<p>Connection to database 'postgres' failed.</p>
<p>connectDB() failed: Is the postmaster running and accepting connections</p>
<p> &nbsp;&nbsp; at 'UNIX Socket' on port '5432'?</p>
<p>или</p>
<p>% psql -h localhost template1</p>
<p>Connection to database 'postgres' failed.</p>
<p>connectDB() failed: Is the postmaster running and accepting TCP/IP</p>
<p> &nbsp;&nbsp; (with -i) connections at 'localhost' on port '5432'?</p>
<p>то это обычно из-за того что: (1) postmaster не запущен, или (2) ты попытался подключиться к не тому хосту-серверу. Если ты получил следующее сообщение об ошибках: </p>
<p>FATAL 1:Feb 17 23:19:55:process userid (2360) != database owner (268)</p>
<p>это значит, что администратор сайта запустил postmaster с неправильным пользователем. Попроси его перезапуститься как суперпользователь Postgres. </p>

<p>Управление базами данных</p>
Теперь, когда Postgres установлен и запущен, мы можем создать несколько баз данных для экспериментирования с ними. Здесь, мы опишем основные команды для управления базами данных. </p>
Большинство Postgres приложений предполагают, что имя базы данных, если не задано, то же самое имя что и имя твоего компьютерного бюджета. </p>
Если администратор баз данных создал твой бюджет без права создания баз данных, то он должен сказать тебе имя твоей базы данных. Если это как раз твой случай, то ты можешь пропустить разделы по созданию и удалению баз данных. </p>
<p>Создание базы данных</p>
Скажем, ты хочешь создать базу данным с именем mydb. Это можно сделать с помощью следующей команды: </p>
<p>% createdb mydb</p>
Если у тебя нет прав необходимых для создания базы данных, ты увидишь следующее: </p>
<p>% createdb mydb</p>
<p>WARN:user "your username" is not allowed to create/destroy databases</p>
<p>createdb: database creation failed on mydb.</p>
Postgres позволяет создавать любое количество баз данных на одном сайте и ты автоматически становишься администратором только что созданной базы данных. Имя базы данных должно начинаться с символа алфавита и ограничиваться длиной в 32 символа. Не каждый пользователь имеет право быть администратором базы данных. Если Postgres отказал тебе в создании базы данных, то администратору сайта нужно разрешить тебе создание баз данных. Поговори с администратором сайта, если это произошло. </p>
<p>Доступ к базе данных</p>
После создания базы данных, ты можешь получить к ней доступ: </p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>запустив Postgres программу управления на терминале (например psql), который позволит тебе в диалоговом режиме вводить, редактировать, и выполнять команды SQL. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>написав программы на C, с помощью библиотеки подпрограмм LIBPQ. Это позволит тебе использовать команды SQL из C и получать ответы и сообщения о статусе обратно в твою программу. Этот интерфейс обсуждается далее в Руководство программиста PostgreSQL. </td></tr></table></div><p>Ты можешь захотеть запустить psql, чтобы опробовать примеры из этого руководства. Это может быть выполнено с базой данных mydb при введении команды: </p>
<p>% psql mydb</p>
<p>Ты увидишь приветствующее сообщение: </p>
<p>Welcome to the POSTGRESQL interactive sql monitor:</p>
<p>  Please read the file COPYRIGHT for copyright terms of POSTGRESQL</p>
<p> &nbsp; type \? for help on slash commands</p>
<p> &nbsp; type \q to quit</p>
<p> &nbsp; type \g or terminate with semicolon to execute query</p>
<p> You are currently connected to the database: template1</p>
<p>mydb=&gt;</p>
Эта подсказка показывает, что монитор терминала ждет ввода и что ты можешь вводить SQL запросы в рабочую область, контролируемую монитором терминала. Программа psql распознает управляющие коды, которые начинаются с символа обратного слэша &#8220;\&#8221;, например, можно получить справку о синтаксисе различных команд Postgres SQLнабрав: </p>
<p>mydb=&gt; \h</p>
<p>После того как ты закончишь вводить запрос в рабочую область, можно передать содержимое рабочей области на сервер Postgres, набрав: </p>
<p>mydb=&gt; \g</p>
<p>Это приказывает серверу обработать запрос. Если в конце запроса ты поставил точку с запятой, то &#8220;\g&#8221; не нужна. psql автоматически автоматически обрабатывает запросы, оканчивающиеся точкой с запятой. Чтобы прочитать запрос из файла myFile, вместо интерактивного ввода, набери: </p>
<p>mydb=&gt; \i fileName</p>
<p>Чтобы выйти из psql и вернуться в Unix, набери </p>
<p>mydb=&gt; \q</p>
<p>и psql закроется и ты вернешься в shell. (Другие управляющие коды можно посмотреть набрав \h в строке монитора.) Свободное место (т.е., пробелы, символы табуляции и новые строки) можно свободно использовать в SQL запросах. Одностроковые комментарии обозначаются &#8220;--&#8221;. Все после пунктира игнорируется до конца строки. Многостроковые комментарии - это комментарии внутри строк, ограниченных &#8220;/* ... */&#8221; </p>
<p>Удаление базы данных</p>
Если ты являешься администратором базы данных mydb, то можешь удалить ее, с помощью следующей команды Unix: </p>
<p>% destroydb mydb</p>
<p>Это действие физически удаляет все файлы Unix, связанные с базой данных, и обратно вернуть ничего нельзя, поэтому оно должно выполняться только предвидев, что она уже никому не понадобится. </p>

<p>Язык запросов</p>
<p>Оглавление </p>
<p>Интерактивный монитор </p>
<p>Концепции </p>
<p>Создание нового класса </p>
<p>Заполнение класса экземплярами </p>
<p>Запрос к классу </p>
<p>Перенаправление запросов SELECT </p>
<p>Объединение классов </p>
<p>Обновление </p>
<p>Удаление </p>
<p>Использование итоговых функций </p>
Язык запросов Postgres отличается от проекта SQL3 - следующего поколения стандарта. Он имеет много расширений, например, расширяемую систему типов, наследование, функции и образования правил. Эти свойства остались от первоначального языка запросов Postgres, PostQuel. Этот раздел содержит краткий обзор того, как использовать Postgres SQL для выполнения простых операций. Это руководство предназначено только для того, чтобы показать идеи разновидности нашего SQL и никоим образом не претендует на полный справочник по SQL. Было написано много книг по SQL, включая [MELT93] и [DATE97]. Ты должен сознавать, что некоторые свойства языка расширяют ANSI стандарт. </p>
<p>Интерактивный монитор</p>
В примерах ниже, мы предполагаем, что ты создал базу данных mydb как описывалось в предыдущем разделе и запустил psql. Примеры из этого руководства также можно найти в /usr/local/pgsql/src/tutorial/. Обратись к файлу README в том же каталоге чтобы понять как их использовать. Чтобы запустить обучающее руководство, сделай следующее: </p>
<p>% cd /usr/local/pgsql/src/tutorial</p>
<p>% psql -s mydb</p>
<p>Welcome to the POSTGRESQL interactive sql monitor:</p>
<p>  Please read the file COPYRIGHT for copyright terms of POSTGRESQL</p>
<p> &nbsp; type \? for help on slash commands</p>
<p> &nbsp; type \q to quit</p>
<p> &nbsp; type \g or terminate with semicolon to execute query</p>
<p> You are currently connected to the database: postgres</p>
<p>mydb=&gt; \i basics.sql</p>
Опция \i указывает читать запросы из заданных файлов. Опция -s переключает в пошаговый режим, который делает паузу перед посылкой запроса на сервер. Запросы этого раздела находятся в файле basics.sql. </p>
У psql есть различные команды \d для отображения системной информации. Рассмотри эти команды более подробно; чтобы вывести весь список, набери \? в командной строке psql. </p>

<p>Концепции</p>
Основное понятие в Postgres - это класс, т.е. именованный набор экземпляров объектов. Каждый экземпляр имеет одинаковое множество именованных атрибутов, а каждый атрибут имеет определенный тип. К тому же, каждый экземпляр имеет постоянный идентификатор объекта (OID), который является уникальным во всей установке. Т.к. синтаксис SQL ссылается на таблицы, мы будем использовать термины таблица и класс как взаимозаменяемые. Также, SQL строка - это экземпляр и SQL колонки - это атрибуты. Как уже говорилось, классы группируются в базы данных, а наборы баз данных управляются одним postmaster процессом, созданным установкой или сайтом. </p>

<p>Создание нового класса</p>
Можно создать новый класс, указав имя класса вместе со всеми именами атрибутов и их типами: </p>
<p>CREATE TABLE weather (</p>
<p> &nbsp;&nbsp; city&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; varchar(80),</p>
<p> &nbsp;&nbsp; temp_lo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; int,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -- минимальная температура</p>
<p> &nbsp;&nbsp; temp_hi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; int,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -- максимальная температура</p>
<p> &nbsp;&nbsp; prcp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; real,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -- осадки</p>
<p> &nbsp;&nbsp; date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; date</p>
<p>);</p>
Заметим, что ключевые слова и идентификаторы регистронезависимы; идентификаторы могут стать регистрозависимым, если написать их в двойных кавычках, как в SQL92. Postgres SQL поддерживает обычные для SQL типы int, float, real, smallint, char(N), varchar(N), date, time, и timestamp, так и другие типы общих утилит и богатый набор геометрических типов. Как мы увидим позже, в Postgres можно создать произвольное количество типов данных, определенных пользователем. Следовательно, имена типов не должны быть ключевыми словами, кроме необходимой поддержки специальных случаев в SQL92 стандарте. Несомненно, команда Postgres create выглядит также как и команда создания таблиц в традиционной реляционной системе. Однако, вскоре мы увидим, что классы имеют свойства, которые расширяют реляционную модель. </p>

<p>Заполнение класса экземплярами</p>
Выражение insert используется для заполнения класса экземплярами: </p>
<p>INSERT INTO weather</p>
<p> &nbsp;&nbsp; VALUES ('San Francisco', 46, 50, 0.25, '11/27/1994');</p>
Также можно использовать команду copy, чтобы выполнить загрузку большого количества данных из плоских (ASCII) файлов. Обычно это быстрее, потомучто данные читаются (или записываются) как единичная атомарная транзакция напрямую в или из заданной таблицы. Для примера: </p>
<p>COPY INTO weather FROM '/home/user/weather.txt'</p>
<p> &nbsp;&nbsp; USING DELIMITERS '|';</p>
<p>где файл источник должен быть доступен для машины сервера, а не клиента, т.к. серверная часть читает файл напрямую. </p>

<p>Запрос к классу</p>
Класс weather может быть опрошен с помощью обычных запросов реляционной выборки и проекции. Для этого используется выражение SQL - select. Выражение делится на список объектов (часть, которая описывает возвращаемые атрибуты) и определение (часть, в которой указаны любые ограничения). Например, получить все строки из weather: </p>
<p>SELECT * FROM WEATHER;</p>
<p>и получим:</p>
<p>CLASS="PROGRAMLISTING"</p>
<p>+--------------+---------+---------+------+------------+</p>
<p>|city&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | temp_lo | temp_hi | prcp | date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p>+--------------+---------+---------+------+------------+</p>
<p>|San Francisco | 46&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | 50&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | 0.25 | 11-27-1994 |</p>
<p>+--------------+---------+---------+------+------------+</p>
<p>|San Francisco | 43&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | 57&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | 0&nbsp;&nbsp;&nbsp; | 11-29-1994 |</p>
<p>+--------------+---------+---------+------+------------+</p>
<p>|Hayward&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | 37&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | 54&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | 11-29-1994 |</p>
<p>+--------------+---------+---------+------+------------+</p>
<p>Можно указывать любые произвольные выражения в списке объектов. Например: </p>
<p>SELECT city, (temp_hi+temp_lo)/2 AS temp_avg, date FROM weather;</p>
Произвольные логические операторы (and, or и not) разрешены в определении любого запроса. Например, </p>
<p>SELECT * FROM weather</p>
<p> &nbsp;&nbsp; WHERE city = 'San Francisco'</p>
<p> &nbsp;&nbsp; AND prcp &gt; 0.0;</p>
<p>в результате:</p>
<p>+--------------+---------+---------+------+------------+</p>
<p>|city&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | temp_lo | temp_hi | prcp | date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p>+--------------+---------+---------+------+------------+</p>
<p>|San Francisco | 46&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | 50&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | 0.25 | 11-27-1994 |</p>
<p>+--------------+---------+---------+------+------------+</p>
В качестве последнего замечания, можно указать, чтобы результаты выборки возвращались в отсортированными и с удалением экземпляров копий. </p>
<p>SELECT DISTINCT city</p>
<p> &nbsp;&nbsp; FROM weather</p>
<p> &nbsp;&nbsp; ORDER BY city;</p>
<p>Перенаправление запросов SELECT</p>
Любой запрос выборки можно перенаправить в новый класс </p>
<p>SELECT * INTO TABLE temp FROM weather;</p>
Это формирует неявную команду create, создавая новый класс temp с именами атрибутов и типами, указанными списке объектов команды select into. Затем, мы можем, конечно, выполнить любую операцию над классом результатом, такие какие мы могли выполнять над другими классами. </p>

<p>Соединение классов</p>
До сих пор, наши запросы имели доступ только к одному классу одновременно. Запросам доступны несколько классов одновременно, или доступен один класс таким образом, что многочисленные экземпляры класса обрабатываются одновременно. Запрос, который работает с несколькими экземплярами одного или разных классов одновременно, называется соединительный запрос. Например, мы хотим найти все записи, которые лежат в температурном диапазоне других записей. В действительности, нам нужно сравнить атрибуты temp_lo и temp_hi каждого экземпляра EMP с атрибутами temp_lo и temp_hi всех остальных экземпляров EMP. </p>
Замечание: Это только умозрительная модель. На самом деле, соединение может выполняться более эффективно, но это незаметно для пользователя. </p>
<p>Мы можем сделать это с помощью следующего запроса: </p>
<p>SELECT W1.city, W1.temp_lo AS low, W1.temp_hi AS high,</p>
<p> &nbsp;&nbsp; W2.city, W2.temp_lo AS low, W2.temp_hi AS high</p>
<p> &nbsp;&nbsp; FROM weather W1, weather W2</p>
<p> &nbsp;&nbsp; WHERE W1.temp_lo &lt; W2.temp_lo</p>
<p> &nbsp;&nbsp; AND W1.temp_hi &gt; W2.temp_hi;</p>
<p>+--------------+-----+------+---------------+-----+------+</p>
<p>|city&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | low | high | city&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | low | high |</p>
<p>+--------------+-----+------+---------------+-----+------+</p>
<p>|San Francisco | 43&nbsp; | 57&nbsp;&nbsp; | San Francisco | 46&nbsp; | 50&nbsp;&nbsp; |</p>
<p>+--------------+-----+------+---------------+-----+------+</p>
<p>|San Francisco | 37&nbsp; | 54&nbsp;&nbsp; | San Francisco | 46&nbsp; | 50&nbsp;&nbsp; |</p>
<p>+--------------+-----+------+---------------+-----+------+</p>
Замечание: Семантика такого соединения, означает что ограничение выражения истинно, для определённого декартова произведения классов, указанных в запросе. Для тех экземпляров из декартова произведения, для которых ограничение верно, Postgres вычисляет и возвращает значения, указанные в списке объектов. Postgres SQL, не принимает в внимание повторяющие значения в таких выражениях. Это значит, что Postgres иногда пересчитывает один и тот же объект несколько раз; это часто случается когда логические выражения соединяются с помощью "or". Для удаления таких повторений, ты должен использовать выражение select distinct. </p>
В этом случае, оба W1 и W2 заменяются экземпляром класса weather, и он действует на все экземпляры класса. (По терминологии большинства систем баз данных, W1 и W2 известны как переменные диапазона.) Запрос может содержать произвольное число названий классов и суррогатов. </p>

<p>Обновление</p>
Можно обновлять существующие экземпляры с помощью команды update. Предположим, что температура понизилась на 2 градуса 28 ноября, ты можешь обновить данные так: </p>
<p>UPDATE weather</p>
<p> &nbsp;&nbsp; SET temp_hi = temp_hi - 2,&nbsp; temp_lo = temp_lo - 2</p>
<p> &nbsp;&nbsp; WHERE date &gt; '11/28/1994';</p>
<p>Удаление</p>
Удаление выполняется с помощью команды delete: </p>
<p>DELETE FROM weather WHERE city = 'Hayward';</p>
<p>Все записи о погоде в Hayward будут удалены. Надо быть осторожным с запросами в форме </p>
<p>DELETE FROM classname;</p>
<p>Без ограничения, delete просто удаляет все экземпляры данного класса, делая его пустым. Система не запрашивает подтверждения перед тем как сделать это. </p>

<p>Использование итоговых функций</p>
Как и большинство других языков запросов, PostgreSQL поддерживает итоговые функции. Текущая реализация Postgres имеет некоторые ограничения для итоговых функций. Особенно, пока существует подсчет итогов такими функциями как count, sum, avg (среднее), max (максимум) и min (минимум) над множествами экземпляров, итоги могут только появляться в списке объектов запроса, и не прямо в определении (в предложении). Например, </p>
<p>SELECT max(temp_lo) FROM weather;</p>
<p>разрешено, хотя в</p>
<p>SELECT city FROM weather WHERE temp_lo = max(temp_lo);</p>
<p>нет. Однако, это часто требуется и для достижения нужного</p>
<p>результата может использоваться вложенная выборка:</p>
<p>SELECT city FROM weather WHERE temp_lo = (SELECT max(temp_lo) FROM weather);</p>
Итоги могут также быть при group by предложениях: </p>
<p>SELECT city, max(temp_lo)</p>
<p> &nbsp;&nbsp; FROM weather</p>
<p> &nbsp;&nbsp; GROUP BY city;</p>
<p>Расширенные свойства PostgresSQL</p>
<p>Оглавление </p>
<p>Наследование </p>
<p>Неатомарные значения </p>
<p>Time Travel </p>
<p>Остальные свойства </p>
Получив основы использования e&gt;Postgre&gt; SQL для доступа к данным, теперь мы поговорим о таких свойствах Postgres, которые отличают его от обычных администраторов данных. Эти свойства включают наследование, time travel и неатомарные значения данных (массивы и многозначные атрибуты).Примеры этого раздела можно также найти в advance.sql в каталоге tutorial. (Смотри Главу 5 как их использовать.) </p>
<p>Наследование</p>
Давайте создадим два класса. Класс capitals содержит столицы штатов, которые также есть и в cities. Естественно, класс capitals должен наследоваться от cities. </p>
<p>CREATE TABLE cities (</p>
<p> &nbsp;&nbsp; name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; text,</p>
<p> &nbsp;&nbsp; population&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; float,</p>
<p> &nbsp;&nbsp; altitude&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; int&nbsp;&nbsp;&nbsp;&nbsp; -- (in ft)</p>
<p>);</p>
<p>CREATE TABLE capitals (</p>
<p> &nbsp;&nbsp; state&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; char(2)</p>
<p>) INHERITS (cities);</p>
<p>В этом случае, экземпляр класса capitals наследует все атрибуты (name, population, и altitude) от своего родителя, cities. Тип атрибута name - это text, родной тип Postgres для ASCII строк переменной длины. Тип атрибута population - это float, родной тип Postgres для дробных чисел двойной точности. Строение capitals имеет дополнительный атрибут, state, который отображает штат. В Postgres, классы могут наследоваться от нуля и более классов, и запросы могут относится или ко всем экземплярам класса или ко всем экземплярам класса плюс ко всем его потомкам. </p>
Замечание: Наследственная иерархия - это прямой нециклический граф. </p>
<p>Например, следующий запрос ищет все города, которые расположены на высоте 500ft или выше: </p>
<p>SELECT name, altitude</p>
<p> &nbsp;&nbsp; FROM cities</p>
<p> &nbsp;&nbsp; WHERE altitude &gt; 500;</p>
<p>+----------+----------+</p>
<p>|name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | altitude |</p>
<p>+----------+----------+</p>
<p>|Las Vegas | 2174&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p>+----------+----------+</p>
<p>|Mariposa&nbsp; | 1953&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p>+----------+----------+</p>
С другой стороны, вот запрос как найти названия всех городов, включая столицы штатов, которые расположены на высоте ниже 500ft: </p>
<p>SELECT c.name, c.altitude</p>
<p> &nbsp;&nbsp; FROM cities* c</p>
<p> &nbsp;&nbsp; WHERE c.altitude &gt; 500;</p>
<p>который возвращает: </p>
<p>+----------+----------+</p>
<p>|name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | altitude |</p>
<p>+----------+----------+</p>
<p>|Las Vegas | 2174&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p>+----------+----------+</p>
<p>|Mariposa&nbsp; | 1953&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p>+----------+----------+</p>
<p>|Madison&nbsp;&nbsp; | 845&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p>+----------+----------+</p>
<p>Здесь &#8220;*&#8221; после cities показывает, что запрос должен касаться всего cities и всех классов ниже cities в наследственной иерархии. Многие из команд, про которые мы уже говорили (select, and&gt;upand&gt; и delete) поддерживают &#8220;*&#8221; тип записи, как и другие типа alter. </p>

<p>Неатомарные значения</p>
Одним из принципов реляционной модели является то, что атрибуты отношения атомарны. Postgres не имеет этого ограничения; атрибуты могут сами содержать под-значения, которые могут быть доступны из языка запросов. Например, можно создать атрибут, который является массивом базового типа. </p>
<p>Массивы</p>
Postgres разрешает атрибуты экземпляров определяемые как многомерные массивы постоянной или переменной длины. Можно создавать массивы любого базового типа или типа определенного пользователем. Чтобы проиллюстрировать их использование, сначала создадим класс с массивами базовых типов. </p>
<p>CREATE TABLE SAL_EMP (</p>
<p> &nbsp;&nbsp; name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; text,</p>
<p> &nbsp;&nbsp; pay_by_quarter&nbsp; int4[],</p>
<p> &nbsp;&nbsp; schedule&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; text[][]</p>
<p>);</p>
Запрос выше создает класс SAL_EMP с text строкой (name), одномерным массивом int4 (pay_by_quarter), который представляет из себя зарплату рабочему за квартал и двумерный массив text (schedule), который представляет из себя задание рабочему на неделю. Теперь мы выполним несколько вставок INSERTS; заметим, что при добавлении в массив, мы заключаем значения в скобки и разделяем их запятыми. Если ты знаешь язык C, то это похоже на синтаксис при инициализации структур. </p>
<p>INSERT INTO SAL_EMP</p>
<p> &nbsp;&nbsp; VALUES ('Bill',</p>
<p> &nbsp;&nbsp; '{10000, 10000, 10000, 10000}',</p>
<p> &nbsp;&nbsp; '{{"meeting", "lunch"}, {}}');</p>
<p>INSERT INTO SAL_EMP</p>
<p> &nbsp;&nbsp; VALUES ('Carol',</p>
<p> &nbsp;&nbsp; '{20000, 25000, 25000, 25000}',</p>
<p> &nbsp;&nbsp; '{{"talk", "consult"}, {"meeting"}}');</p>
<p>По умолчанию, Postgres использует "начало с единицы" соглашение о нумерации -- то есть, массив из n элементов начинается с array[1] и заканчивается array[n]. Теперь, мы можем выполнить несколько запросов к SAL_EMP. Во-первых, мы покажем как получить доступ к элементам массива по одному. Этот запрос возвращает имена рабочих, оплата которых изменилась во втором квартале: </p>
<p>SELECT name</p>
<p> &nbsp;&nbsp; FROM SAL_EMP</p>
<p> &nbsp;&nbsp; WHERE SAL_EMP.pay_by_quarter[1] &lt;&gt;</p>
<p> &nbsp;&nbsp; SAL_EMP.pay_by_quarter[2];</p>
<p>+------+</p>
<p>|name&nbsp; |</p>
<p>+------+</p>
<p>|Carol |</p>
<p>+------+</p>
Этот запрос возвращает зарплату рабочих в третьем квартале: </p>
<p>SELECT SAL_EMP.pay_by_quarter[3] FROM SAL_EMP;</p>
<p>+---------------+</p>
<p>|pay_by_quarter |</p>
<p>+---------------+</p>
<p>|10000&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p>+---------------+</p>
<p>|25000&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p>+---------------+</p>
Нам также доступны произвольные части массива, или подмассивы. Этот запрос возвращает первую часть задания Billа для первых двух дней недели. </p>
<p>SELECT SAL_EMP.schedule[1:2][1:1]</p>
<p> &nbsp;&nbsp; FROM SAL_EMP</p>
<p> &nbsp;&nbsp; WHERE SAL_EMP.name = 'Bill';</p>
<p>+-------------------+</p>
<p>|schedule&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p>+-------------------+</p>
<p>|{{"meeting"},{""}} |</p>
<p>+-------------------+</p>

