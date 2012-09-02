<h1>Разработка Internet-приложений с использованием Borland Delphi и Kylix</h1>
<div class="date">01.01.2007</div>

<p>Разработка Internet-приложений с использованием Borland Delphi и Kylix</p>
<p>Никита Попов</p>

<p>Введение</p>
<p>За последние несколько лет восприятие и использование Internet как очередной технологической &#171;игрушки&#187; закономерно трансформировались в осознание тех широчайших возможностей, которые Сеть способна предоставить пользователям в плане как человеческого общения, так и ведения бизнеса. Неизбежно возникший в результате подобной трансформации Internet-бум, безусловно, несколько исказил общее восприятие Internet как еще одного средства для построения информационной инфраструктуры коммерческого предприятия, поскольку все наперебой старались применить возможности Сети для малоподходящих целей. Однако сегодня ажиотаж вокруг Internet-технологий постепенно начинает спадать, уступая место пониманию действительно ценных возможностей Сети, а также путей их применения.</p>
<p>Безусловно, применение Internet-технологий для построения информационной инфраструктуры является относительно новым полем деятельности, однако к настоящему моменту в мире образовалось достаточно большое число компаний, поставляющих на рынок средства разработки и поддержки бизнес-приложений, использующих Internet-технологии. Многие из этих компаний создаются непосредственно под Internet-рынок, однако не меньше игроков &#8212; выходцы из области &#171;классических&#187; средств разработки. Одним из известнейших поставщиков средств разработки приложений долгое время была и остается компания Borland, известная своими RAD-инструментами для платформы Windows, такими как Borland Delphi, Borland C++Builder, а также кросс-платформенным средством разработки JBuilder, использующим технологии Java.</p>
<p>Исторически являющаяся одной из компаний-первопроходцев в различных направлениях разработки программного обеспечения, Borland вполне закономерно обратила свое внимание на набирающее рост направление Internet-технологий, представив различные средства для создания, внедрения и поддержки Internet-приложений.</p>
<p>В данной статье речь пойдет о поддержке разработки Internet-приложений в двух наиболее известных инструментах компании Borland: Delphi и Kylix.</p>
<p>Delphi &#8212; это интегрированная среда для быстрого создания приложений баз данных, настольных и Internet-приложений, построенная на основе разработанной Borland визуальной библиотеки компонентов (Visual Components Library, VCL), включающая в себя средства разработки интерфейса приложений с двусторонней связью с исходным кодом (Two-Way Tools), широкий спектр средств отладки приложений и различных вспомогательных средств.</p>
<p>За короткое время с момента выхода первой версии этого продукта, совершившего в некотором смысле революцию в области средств быстрой разработки приложений (Rapid Application Development) &#8212; за счет простоты использования, интуитивной понятности интерфейса и широкого набора средств разработки, Delphi собрал под свои знамена огромное число разработчиков со всего мира, что, безусловно, не могло не стимулировать появление поддержки данным продуктом Internet-технологий и разработки соответствующих приложений.</p>
<p>Kylix, Delphi для Linux &#8212; это аналог Delphi, предназначенный для разработки приложений для операционной системы Linux, которая в последнее время все более широко распространяется в мире1. Подобно своему Windows-аналогу &#8212; Delphi, Kylix имеет для своей платформы чрезвычайно важное значение хотя бы потому, что до настоящего времени для Linux не существовало средств разработки, сравнимых с Delphi по мощности и простоте использования, что, в свою очередь, привело к сужению круга разработчиков программного обеспечения для этой платформы и в значительной степени затормозило ее распространение в качестве настольной операционной системы, временно ограничив Linux лишь достаточно узкой областью серверной платформы и Internet-хостинга.</p>
<p>Однако с появлением Kylix ситуация вполне может кардинально измениться в лучшую сторону, поскольку теперь для множества разработчиков открывается возможность создавать приложения для Linux не менее быстро и эффективно, чем для Windows, а в перспективе, с выходом следующей версии Delphi, &#8212; и создавать кросс-платформенные приложения, переносимые с одной платформы на другую без переработки.</p>
<p>Подобно Delphi, Kylix базируется на аналогичной VCL технологии, получившей название CLX (произносится как &#171;кликс&#187;) &#8212; Component Library for Cross Platform Development, а также на наборе средств разработки, аналогичных Delphi. При этом Kylix даже более ориентирован на разработку Internet-приложений, нежели Delphi, который в настоящее время является более универсальным продуктом. Текущая версия Kylix, точнее Kylix Server Developer, помимо средств разработки приложений баз данных, настольных приложений и &#171;классических&#187; Internet-приложений, то есть клиентов, использующих различные Internet-службы и протоколы, и серверов, применяющих технологии CGI (Common Gateway Interface), а также реализующих ответные, серверные части Internet-служб, включает в себя ряд средств для разработки расширений Web-сервера Apache, представляющего собой сегодня один из наиболее распространенных Web-серверов в мире.</p>
<p>Поскольку Kylix был официально анонсирован компанией Borland раньше новой версии Delphi, целесообразно начать наш обзор именно с этого продукта.</p>
<p>Итак, какие именно инструменты для разработки Internet-приложений имеет в своем арсенале Delphi для Linux?</p>
<p>Средства разработки Internet-приложений из состава Borland Kylix</p>
<p>Как уже было сказано выше, в основе своей Kylix максимально уподоблен Delphi как по общей идеологии (интегрированная среда разработки, визуальные средства создания интерфейса приложений, полностью совместимая с Delphi версия языка Object Pascal и т.д.), так и по набору компонентов визуальной библиотеки &#8212; конечно, с учетом особенностей операционной системы Linux. Именно эти особенности обусловили некоторое различие элементов Internet-технологий в Kylix и их аналогов в Delphi.</p>
<p>Kylix поддерживает два типа серверных Internet-приложений: приложения на основе технологии CGI и расширения сервера Apache &#8212; Apache DSO (Dynamic Shared Objects, динамические объекты совместного использования).</p>
<p>Shared Objects &#8212; это некий аналог Windows-модулей DLL для Linux, обеспечивающих совместное использование программных элементов несколькими приложениями. Практически вся функциональность Linux, включая большую часть ядра ОС, построена с применением Shared Objects (SO). Kylix также использует эту технологию, в частности для переноса технологии пакетов (packages) на Linux, и, конечно, позволяет разрабатывать собственные SO-модули.</p>
<p>В свою очередь, DSO-модули &#8212; это специальным образом организованные библиотеки Shared Objects, обладающие расширенными возможностями взаимодействия с сервером Apache за счет доступа к его API (Application Programming Interface, прикладного программного интерфейса) и использующиеся как стандартное средство расширения возможностей этого сервера.</p>
<p>Сервер Apache является проектом Open Source, координируемым Apache Group. Как и большинство проектов Open Source, Apache распространяется бесплатно вместе с исходным кодом в соответствии со специальной лицензией и, опять-таки подобно большинству OS-проектов, активно развивается, получая все больший набор возможностей. Несомненно, эти особенности, а также высокая надежность, простота в использовании и доступность для очень широкого спектра операционных систем (большинство клонов UNIX, Win32 и т.д.) явились причинами широкого распространения сервера Apache в качестве платформы для Internet-хостинга и корпоративных Web-приложений.</p>
<p>Поскольку Apache входит в поставку большинства клонов Linux, логично было включить его поддержку в Kylix Server Developer, что и было осуществлено компанией Borland в дополнение к поддержке технологии CGI.</p>
<p>Другие технологии, такие как WinCGI и ISAPI/NSAPI, по понятным причинам не вошли в состав Kylix, поскольку предназначены для использования для серверных расширений на платформе Windows.</p>
<p>В состав Kylix входит иерархия компонентов для создания Internet-приложений, построенная на иерархии WebBroker, аналогичной применяемой в Delphi 5: WebModule, WebDispatcher, WebActionItem и т.д. Все они являются невизуальными компонентами, отвечающими за создание иерархии обработки запросов протокола HTTP и генерации соответствующих ответных действий на эти запросы путем образования слоя Internet-компонентов среднего уровня, обеспечивающих взаимодействие клиентских и серверных Internet-приложений на уровне протокола HTTP. Основой приложения, построенного на архитектуре WebBroker, является контейнер типа WebModule, в котором размещаются другие Web-компоненты, генерируемые автоматически (WebDispatcher) или создаваемые в процессе разработки приложения (WebActionItem, PageProducer и т.д.). Компонент WebDispatcher создается контейнером WebModule автоматически и является центром обработки HTTP-запросов. Следует еще раз подчеркнуть, что данная иерархия полностью аналогична Delphi-реализации, и потому работа Internet-приложения, созданного при помощи Kylix, будет полностью совпадать с работой подобного Delphi-приложения, основанного на архитектуре WebBroker.</p>
<p>При поступлении HTTP-запроса он передается объекту WebDispatcher, который производит просмотр списка компонентов типа WebActionItem и автодиспетчеризуемых компонентов, пытаясь найти компонент, способный обработать именно тот тип запроса, который является текущим в очереди. В том случае, если подходящего компонента не обнаружено, запрос передается объекту WebActionItem с пометкой Default (внутри WebModule может быть только один такой объект). В том случае, если Default WebActionItem имеет средства для обработки такого запроса, производятся необходимые действия, а затем (при необходимости) генерируется ответ, который передается обратно объекту WebDispatcher, а от него клиенту &#8212; отправителю запроса.</p>
<p>Каждый из компонентов WebActionItem может быть наделен специальными возможностями по обработке отдельных видов запросов, например будет генерировать отдельную станицу Web-сайта при запросе конкретного URI или же наоборот &#8212; выдавать сообщение об ошибочной ссылке на страницу (код 404 протокола HTTP) либо на корневую страницу Web-сайта при обращении к корневому URI, что, как правило, делает Default WebActionItem.</p>
<p>Как и любой компонент или класс Object Pascal, для компонента WebActionItem могут создаваться наследники &#8212; с целью расширения или специализации функциональности. Например, можно создать компонент-наследник WebActionItem, который будет специальным образом реагировать на ошибку в описании URI (URL) вместо выдачи стандартного сообщения 404 &#171;Страница не найдена&#187;, генерируя более развернутый текст сообщения или производя какие-либо иные действия.</p>
<p>Непосредственно генерация содержания страниц производится визуальными компонентами типа PageProducer и их наследниками, работающими в связке с компонентами WebActionItem, или же при помощи обработчиков событий OnAction, реализованных непосредственно для компонентов WebActionItem. Визуальные компоненты генерации содержания входят в состав палитры Internet, в которой также располагаются визуальные Internet-компоненты нижнего уровня, обеспечивающие работу непосредственно с протоколами TCP/IP и UDP, речь о которых пойдет ниже. </p>
<p>Первый слева компонент является визуальным вариантом автоматически создаваемого WebDispatcher и предназначен для преобразования в WebModule контейнера DataModule, о чем речь пойдет позже.</p>
<p>Базовый компонент PageProducer обладает возможностью генерации содержимого страницы по заданному в свойстве HTMLDoc- или HTMLFile-шаблону или через событие OnHTMLTag, позволяющему реализовать реакцию Web-приложения на специальные тэги в составе шаблона, например динамическую подстановку данных.</p>
<p>Помимо универсальной реализации PageProducer в набор Internet-компонентов среднего уровня в Kylix входят также наследники PageProducer, предназначенные для реализации более специализированных действий, например для публикации и ввода данных: DataSetTableProducer, DataSetPageProducer, QueryTableProducer и SQLQueryTableProducer. Эти компоненты содержатся в палитре Internet и составляют слой Internet-компонентов верхнего уровня, изолированных от протокольной части компонентами архитектуры WebBroker. </p>
<p>Назначение этих компонентов можно понять из имен классов:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>DataSetTableProducer и DataSetPageProducer предназначены для публикации данных из источников данных в виде таблиц или набора полей при отсутствии необходимости ввода параметров отбора данных из источника; </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>QueryTableProducer и SQLQueryTableProducer позволяют публиковать данные из источников, требующих для формирования набора данных входных параметров, которые передаются в виде параметров HTTP-запроса в случае запроса типа GET или в виде полей свойства ContentFields объекта запроса типа POST. </td></tr></table></div><p>В любом случае поля данных подставляются на свое место в HTML-документе с помощью &#171;прозрачных&#187; для HTML-парсеров тэгов, содержащихся в шаблоне страницы, которые затем заменяются непосредственно значениями полей данных. Например, при использовании компонента TPageProducer и его события OnHTMLTag для генерации HTML-страницы, шаблон вида:</p>
<pre>
&lt;HEAD&gt;
&lt;TITLE&gt;Sample Delphi Web server application&lt;/TITLE&gt;
&lt;/HEAD&gt;
&lt;BODY&gt;
&lt;H2&gt;Customer Order Information&lt;/H2&gt;
&lt;HR&gt;
Click a customer name to view their orders.&lt;P&gt;
&lt;#CUSTLIST&gt;&lt;P&gt;
&lt;/BODY&gt;
&lt;/HTML&gt;
</pre>
<p>после замещения тэга &lt;#CUSTLIST&gt; реальными данными (в данном примере &#8212; списком клиентов из демонстрационной базы данных customer.db) будет преобразован в следующий HTML-код:</p>
<pre>
&lt;HTML&gt;
&lt;HEAD&gt;
&lt;TITLE&gt;Sample Delphi Web server application&lt;/TITLE&gt;
&lt;/HEAD&gt;
&lt;BODY&gt;
&lt;H2&gt;Customer Order Information&lt;/H2&gt;
&lt;HR&gt;
Click a customer name to view their orders.&lt;P&gt;
&lt;A HREF=&#8221;/cgi-bin/cgidemo.exe/runquery?CustNo=1645"&gt;Action Club&lt;/A&gt;
&lt;BR&gt;&lt;A HREF=&#8221;/cgi-bin/cgidemo.exe/runquery?CustNo=3158"&gt;Action    Diver Supply&lt;/A&gt;
&lt;BR&gt;&lt;A HREF=&#8221;/cgi-bin/cgidemo.exe/runquery?CustNo=1984"&gt;Adventure    Undersea&lt;/A&gt;
&lt;BR&gt;&lt;A HREF=&#8221;/cgi-bin/cgidemo.exe/runquery?CustNo=3053"&gt;American    SCUBA Supply&lt;/A&gt;
&#8230;
&lt;/BODY&gt;
&lt;/HTML&gt;
</pre>
<p>Компоненты DataSetTableProducer и QueryTableProducer используют для формирования HTML-документа шаблоны, генерируемые автоматически в зависимости от содержания публикуемого набора данных и настроек самого компонента. Обращение к данным из этих компонентов и их наследников производится через иерархию классов dbExpress, которая в Kylix и в новой версии Delphi является основным средством доступа к данным.</p>
<p>Помимо компонентов генерации HTML-контента, в состав Internet-компонентов входит такой компонент, как WebDispatcher. Этот компонент предназначен для преобразования обычного приложения баз данных (или desktop-приложения) в Internet-приложение. Достигается это следующим образом.</p>
<p>Сначала компонент WebDispatcher помещается в обычный модуль (DataModule) данных, при этом для него создается дерево компонентов WebActionItem &#8212; аналогично тому, как это происходит в WebModule, поскольку WebModule автоматически поддерживает создание иерархии компонентов WebBroker, WebDispatcher и WebActionItem на уровне своей реализации. После того как DataModule был соответствующим образом подготовлен, им можно заменить с помощью автоматически созданного при генерации нового приложения мастера Web Server Application WebModule (при этом перенеся все компоненты доступа к данным) другие невизуальные компоненты, содержащиеся в исходном DataModule, и, конечно, сопутствующий исходный код во вновь созданное Internet-приложение.</p>
<p>Рассмотренные выше компоненты составляют верхний (PageProducer и его наследники) и средний (WebBroker, WebDispatcher, WebActionItem) уровни иерархии классов для создания Internet-приложений и работают с протоколом HTTP на уровне компонента WebBroker.</p>
<p>Для непосредственного доступа к возможностям базовых Internet-протоколов TCP/IP и UDP в состав Kylix включены компоненты нижнего уровня &#8212; ClientSocket, ServerSocket, TcpClient, TcpServer и UDPSocket, которые предназначены для создания клиентских и серверных приложений, работающих непосредственно через TCP-соединение.</p>
<p>Компоненты ClientSocket и ServerSocket позволяют осуществлять обмен данными через TCP-соединение за счет использования событий OnReceive и OnSend с последующей их обработкой внутри соответствующего приложения. При этом обеспечивается базовая функциональность для создания и управления TCP-соединением с возможностью локации по URL или непосредственно через указание TCP-адреса и порта.</p>
<p>Компоненты TcpClient и TcpServer являются наследниками ClientSocket и ServerSocket, соответственно расширяя их функциональность возможностью работы с тем или иным протоколом по выбору: IP, TCP, UDP или другим сетевым протоколом, а также за счет ряда дополнительных свойств и методов, упрощающих создание приложений на основе этих компонентов.</p>
<p>Компонент UDPSocket обеспечивает создание и управление соединением на базе протокола UDP, то есть на самом нижнем протокольном уровне Internet-соединений. По функциональности этот компонент аналогичен ClientSocket и ServerSocket. </p>
<p>Перечисленные выше компоненты являются частью CLX (Component Library for Cross-platform) и разработаны компанией Borland с учетом современных Internet-стандартов, образуя фундамент для построения Internet-приложений с использованием Kylix. Однако помимо базовых служб и протоколов существует широкий набор дополнительных служб и задач, возможности которых часто используются Internet-разработчиками. К тому же далеко не всегда возможность отображения информации через HTML-браузер является приемлемым решением для разработки Internet-приложений. В этом случае разумно использовать Internet-инфраструктуру для обмена данными, а отображение информации обеспечить за счет более сложных клиентских приложений, разработанных на Kylix. Аналогично зачастую требуется реализовать специализированную серверную логику, которая не заложена в стандартные Web-серверы.</p>
<p>Для решения такого класса задач в состав Kylix включена библиотека стороннего разработчика &#8212; компании Nevrona Design: Internet Direct (Indy).</p>
<p>Данная библиотека была разработана компанией Nevrona Design специально для Borland Delphi и насчитывает в своей истории уже восемь версий, последняя из которых вошла в состав Kylix и новой версии Delphi. Набор компонентов этой библиотеки разделен на три группы: Indy Clients, Indy Servers и Indy Misc.</p>
<p>Как видно из названий групп, первые две предназначены для разработки Internet-приложений клиентов и серверов, а третья содержит различные вспомогательные компоненты.</p>
<p>Большинство компонентов Indy Clients и IndyServers являются &#171;ответными&#187; частями клиент-серверных пар протоколов и служб, за исключением отдельных, в основном серверных, компонентов типа TunnelMaster и TunnelSlave, и позволяют использовать такие протоколы, как TCP/IP, UDP, NNTP, SMTP, FTP, HTTP, а также службы ECHO, FINGER, WHOIS и т.д.</p>

<p>Подкатегория Indy Misc включает в себя такие компоненты, как кодеки BASE64, UUE, Quoted Printable и других распространенных форматов обмена данными через e-mail, кодеры MD2, MD4 и MD5 &#8212; стандартов криптографии, используемых для хранения паролей и электронных подписей в необратимом (не поддающемся расшифровке) виде, а также множество других полезных компонентов и утилит, часто применяющихся при разработке Internet-приложений.</p>
<p>Компоненты протокольных клиентов и серверов могут быть использованы для разработки серверных и клиентских Internet-приложений, совместно или взамен базовых компонентов ClientSocket, ServerSocket и т.д. в тех случаях, когда это оказывается удобнее по тем или иным причинам. Подобно ClientSocket, ServerSocket и другим компонентам из состава палитры Internet, компоненты Indy не используют архитектуру WebBroker, реализуя поддержку Internet-протоколов и служб на нижнем уровне непосредственно в своем исходном коде.</p>
<p>Примеры использования компонентов Internet и Indy можно найти в каталогах %KYLIX%/Demos/Internet и %KYLIX/Demos/Indy.</p>
<p>Следует отметить, что в состав Kylix не входят компоненты InternetExpress, поскольку они используют технологию MIDAS (интерфейс IAppServer и т.д.) для работы с данными, а поддержка этой технологии не включена в состав текущей версии Kylix.</p>
<p>Как уже говорилось выше, Kylix, по своей функциональности в целом и по возможностям разработки Internet-приложений в частности, повторяет возможности Delphi 5, за исключением определенных отличий, связанных с особенностями операционной системы Linux. Однако в настоящее время Delphi перешел на &#171;новый уровень эволюции&#187;, что обеспечено выходом новой версии этого продукта, на примере которой, точнее на примере Delphi 6 Enterprise, мы рассмотрим, какие возможности, связанные с разработкой Internet-приложений, нам обеспечивает новая версия Delphi, во многом являющегося &#171;законодателем мод&#187; среди инструментов разработки от Borland.</p>

<p>Средства разработки Internet-приложений из состава Borland Delphi 6</p>
<p>Отвечая ожиданиям многих разработчиков, новая версия Delphi содержит множество улучшений и новшеств в различных областях, включая усовершенствованную IDE (Integrated Development Environment &#8212; интегрированную среду разработки), новую базовую библиотеку компонентов CLX (Component Library for Cross-platform &#8212; библиотеку компонентов для кросс-платформенной разработки) и т.д.1 И конечно, в состав новой версии Delphi входит множество новых компонентов, поддерживающих передовые стандарты в области разработки Internet-приложений.</p>
<p>Помимо возможностей Delphi 5 и Kylix, то есть набора компонентов нижнего уровня (ClientSocket, ServerSocket, TcpClient, TcpServer и UDPSocket) и компонентов верхнего уровня (PageProducer, DataSetTableProducer, QueryTableProducer и WebDispatcher), которые были рассмотрены выше, Delphi 6 включает в себя новый набор компонентов, реализующий технологию WebSnap, компоненты WebServices, реализующие поддержку технологии SOAP (Simple Object Activation Protocol &#8212; простой протокол активации объектов), а также входящий в состав Delphi 5 набор компонентов InternetExpress, позволяющий создавать Internet-приложения для работы с данными через MIDAS с передачей данных в формате XML DataPackets (пакетов данных XML).</p>
<p>Технология WebSnap является дальнейшей эволюцией технологии WebBroker, реализованной в Delphi 5 и Kylix, и позволяет создавать более мощные и сложные по структуре Internet-приложения. </p>
<p>Общие принципы разработки приложений с использованием WebSnap примерно схожи с разработкой приложений на основе WebBroker, за исключением особенностей, перечисленных в таблице.</p>
<p>архитектура WebSnap действительно поддерживает гораздо больше различных компонентов для создания Web-страниц по сравнению с WebBroker.</p>
<p>Компоненты типа &#171;адаптер&#187; (TAdapter, TPagedAdapter, TDataSetAdapter, TLoginFormAdapter, TApplicationAdapter и т.д.) служат для реализации поддержки языков сценария на стороне сервера. Так, например, компонент TDataSetAdapter служит для использования языка сценария при формировании отображения содержимого набора данных. При этом может использоваться JScript или VBScript, в зависимости от типа сервера, для которого разрабатывается приложение. Немаловажным фактом является то, что WebSnap поддерживает JScript на стороне сервера в соответствии со спецификацией ECMA (ECMA-262), описывающей объектно-ориентированный язык сценариев для формирования содержания HTML-страниц. Дополнительную информацию об этом стандарте можно получить на странице этой организации по адресу http://www.ecma.ch/. </p>
<p>Другая часть компонентов WebSnap относится к классу &#171;диспетчер&#187; (TPageDispatcher, TAdapterDispatcher) и обеспечивает диспетчеризацию HTTP-запросов и ответов на них в соответствии с заданной бизнес-логикой.</p>
<p>Компоненты типа &#171;список&#187; (TStringsValuesList, TDataSetValuesList, TWebUserList) позволяют включать в содержимое HTML-страниц различные списки (текстовых строк, строк наборов данных, списки пользователей и т.д.).</p>
<p>Компоненты типа &#171;продюсер&#187; (TXSLPageProducer, TAdapterPageProducer) позволяют генерировать страницы на основе компонентов типа &#171;адаптер&#187; и других, представляющих собой отдельные элементы HTML-страницы, &#171;собирая&#187; их в единый HTML-документ. При этом TXSLPageProducer позволяет формировать содержимое страницы на основе XML-трансформации исходного шаблона, описанного в соответствии со стандартами XML (eXtensible Markup Language) и XSL (eXtensible Stylesheet Language), и исходных данных в формате XML, которые, в свою очередь, могут быть сформированы непосредственно внутри приложения, считаны из внешнего файла или получены через компоненты доступа к данным (dbExpress, DataSnap).</p>
<p>В основе Internet-приложения на основе WebSnap по-прежнему лежит компонент-контейнер, который, однако, теперь может быть в приложении не единственным. Контейнером в иерархии WebSnap является компонент TWebSnapDataModule или TWebAppPageModule, то есть подразумевается разбиение приложения на страницы подобно &#171;классическому&#187; Web-сайту. Внутри этого контейнера располагаются визуальные компоненты для генерации содержания и невизуальные компоненты WebActionItem, отвечающие за построение дерева реакций приложения на HTTP-запросы. </p>
<p>Как можно увидеть из этого рисунка, WebSnap действительно допускает использование компонентов WebBroker совместно с компонентами новой архитектуры, что открывает чрезвычайно большой выбор возможностей реализации той или иной задачи построения Internet-приложения в зависимости от ее сложности и других факторов. При этом компоненты WebBroker, вложенные в контейнер TWebAppPageModule, будут работать в новой, многоконтейнерной архитектуре приложения WebSnap точно так же, как и в одноконтейнерной архитектуре WebBroker, что позволит при необходимости осуществить переход к новой архитектуре без внесения многочисленных изменений в существующее приложение.</p>
<p>Дерево обработки HTTP-запроса по-прежнему описывается при помощи компонентов WebActionItem, как это делалось в архитектуре WebBroker, за исключением того, что, помимо возможности разбиения приложения на несколько контейнеров (например, по аналогии со страницами Web-сайта), внутри каждого контейнера может иметься несколько компонентов-диспетчеров, содержащих отдельные деревья WebActionItems для различных типов запросов и, следовательно, реализующих специальные алгоритмы их обработки внутри одного контейнера, (тогда как в архитектуре WebBroker все запросы должны были обрабатываться внутри одного дерева компонентов WebActionItem).</p>
<p>Архитектура WebSnap обеспечивается большим числом мастеров (wizards) для первичной генерации &#171;скелетов&#187; Internet-приложений, а также для выполнения повторяющихся промежуточных операций.</p>
<p>В отличие от реализации поддержки WebBroker в Delphi 5 и Kylix, поддержка WebSnap в Delphi 6 включает в себя расширенные средства визуальной разработки и предварительного просмотра генерируемых данных. Так, средство Page Module View позволяет осуществлять предварительный просмотр результатов генерации содержания страницы на основании отдельного Page Module без компиляции и запуска приложения под управлением Web-сервера, что существенно облегчает отладку Internet-приложений. При этом, в отличие от средств поддержки WebBroker, для WebSnap используется встроенный браузер, что исключает привязку архитектуры к какому-либо одному средству просмотра (как это было с WebBroker), по причине чего в Kylix и Delphi 5 не были включены средства предварительного просмотра результатов генерации компонентов типа PageProducer и DataSetProducer (при этом предварительный просмотр поддерживался только для компонентов InternetExpress за счет использования сервера OLE Automation от MS Internet Explorer, что, естественно, автоматически исключало перенос этого сервиса, например, на платформу Linux).</p>
<p>Помимо просмотра сгенерированного HTML-содержания средства предварительного просмотра Delphi 6/WebSnap позволяют отображать результаты построения XML- и XSL-деревьев без компиляции приложения, что также значительно упрощает процесс создания и отладки приложений.</p>
<p>Также в состав средств поддержки XML, которая вообще является в Delphi 6 одним из наиболее значимых нововведений, входит средство построения схем связей XML (XML Data Binding Wizard), позволяющее на основе файлов данных в формате XML формировать файлы связей, описывающих типы объектов и их атрибуты на основе исходных данных, которые затем могут быть использованы для выполнения трансформаций внутри приложений.</p>
<p>Как мы говорили выше, Delphi 6 по-прежнему поддерживает и компоненты InternetExpress, которые также могут быть использованы совместно с компонентами WebSnap.</p>
<p>Компоненты InternetExpress позволяют осуществлять включение данных в содержание HTML-страниц за счет использования механизма &#171;прозрачных&#187; HTML-тэгов при генерации содержания. InternetExpress состоит из компонентов InetXPageProducer и XMLBroker.</p>
<p>Первый является наследником PageProducer и производит непосредственную генерацию HTML-содержания с &#171;прозрачными&#187; HTML-тэгами. Второй осуществляет обмен данными с сервером (источником) данных на основе технологии MIDAS, то есть практически с любым существующим поставщиком данных, реализующим один из поддерживаемых MIDAS стандартов (CORBA, COM/DCOM, Sockets и т.д.).</p>
<p>При этом для передачи данных к клиентской части приложения (Web-странице внутри HTML-браузера) используются XML DataPackets, содержащие как собственно данные, так и их описание в формате XML. Для передачи изменений в данных, которые могут быть произведены внутри клиентской части Internet-приложения на основе InternetExpress, используются DeltaPackets, опять-таки в формате XML, описывающие исключительно изменения, которые должны быть внесены в данные на сервере, что позволяет снизить трафик между клиентами и Web-сервером. За генерацию пакетов данных (data packets) и расшифровку разностных пакетов (delta packets) отвечает компонент XMLBroker, который также транслирует изменения серверу данных.</p>
<p>Изюминкой архитектуры InternetExpress является то, что, в отличие от компонента PageProducer и его наследников &#8212; DataSetPageProducer и других, InetXPageProducer не включает данные в состав HTML-страниц. Вместо этого данные, переданные в виде XML DataPackets клиентскому приложению (браузеру), подставляются на место &#171;прозрачных&#187; HTML-тэгов за счет реализации DOM (Document Object Model &#8212; объектной модели документа) внутри браузера-клиента, которая, в частности, описывает замещение &#171;прозрачных&#187; тэгов-свойств документа реальными значениями. В случае если браузер не имеет встроенной реализации DOM, используется реализация на JavaScript, как, например, это сделано для Netscape Navigator. Набор соответствующих сценариев включен в поставку Delphi, а InetXPageProducer может обеспечивать передачу этих сценариев на сторону клиента при первом обращении к Internet-приложению на основе InternetExpress за счет включения ссылок на них в содержание генерируемых страниц.</p>
<p>Как обычно, на базе компонентов InternetExpress могут быть созданы их расширенные версии, позволяющие реализовать внутреннюю обработку дополнительных &#171;прозрачных&#187; тэгов, вынести типовые свойства HTML-страниц, например заголовки или кодировку, в свойства компонентов-генераторов содержания.</p>
<p>Компоненты InternetExpress вкладываются в контейнер WebModule или WebSnapDataModule/WebSnapPageModule и могут использоваться совместно с другими компонентами архитектур WebBroker и WebSnap.</p>
<p>Таким образом, архитектура WebSnap позволяет использовать существующие разработки на основе архитектуры WebBroker при создании Internet-приложений на базе новых технологий, предлагаемых Delphi 6. При этом также остается возможность разработки кросс-платформенных Internet-приложений на основе библиотеки CLX и архитектуры WebBroker, которые будут поддерживаться как Delphi 6, так и Kylix, причем в случае соблюдения при разработке определенных правил перенос проекта между платформами не будет односторонним, то есть появляется возможность вести параллельную разработку для обеих операционных систем, с последующим переносом приложения с &#171;ведущей&#187; ОС на &#171;ведомую&#187;.</p>
<p>Заключение</p>
<p>Итак, мы рассмотрели основные возможности разработки Internet-приложений с использованием Kylix и Delphi 6. Безусловно, в силу ограниченного объема статьи было невозможно уместить здесь более подробный обзор вновь появившихся технологий, однако основной нашей целью было показать, что нового привнесли в область разработки приложений для Internet два новых продукта компании Borland, и постараться заинтересовать как разработчиков уже существующих проектов этого класса, так и тех, кто находится в стадии принятия решения о выборе средства разработки и операционной системы для своего проекта, поскольку с выходом Kylix и Delphi 6 возможности разработки приложений, использующих Internet-технологии, многократно возросли. Надеемся, что данный обзор поможет вам разобраться в новых возможностях указанных продуктов. </p>
<p>КомпьютерПресс 6'2001</p>
<p>Взято из<a href="https://delphi.chertenok.ru" target="_blank"> http://delphi.chertenok.ru</a></p>
