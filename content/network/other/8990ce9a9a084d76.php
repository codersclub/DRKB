<h1>Протокол SOCKS 5</h1>
<div class="date">01.01.2007</div>

<p>Протокол SOCKS 5</p>
<p>Статус данного документа</p>
<p>  &nbsp;Этот документ описывает протокол связи по стандартам Интернет, и открыт</p>
<p>  &nbsp;для обсуждения и предложений. Пожалуйста обращайтесь к текущей редакции</p>
<p>  &nbsp;"Internet Official Protocol Standards" (STD 1) чтобы справится о стадии</p>
<p>  &nbsp;стандартизации и статусе этого протокола. Распространение этого документа</p>
<p>  &nbsp;не ограничивается.</p>
<p>Благодарности</p>
<p>  &nbsp;Этот документ описывает протокол, который является развитием предыдущей</p>
<p>  &nbsp;версии протокола 4 [1]. Этот новый протокол основывается на бурных</p>
<p>  &nbsp;дискуссиях и прототипах реализаций. Основной вклад внесли:</p>
<p>  &nbsp;Marcus Leech: Bell-Northern Research, David Koblas: Independent Consultant,</p>
<p>  &nbsp;Ying-Da Lee: NEC Systems Laboratory, LaMont Jones: Hewlett-Packard Company,</p>
<p>  &nbsp;Ron Kuris: Unify Corporation, Matt Ganis: International Business Machines.</p>
<p>1. &nbsp;Введение</p>
<p>  &nbsp;Использование сетевых файрволов и систем, эффективно скрывающих </p>
<p>  &nbsp;организацию внутренней сетевой структуры от внешней сети, такой</p>
<p>  &nbsp;как Интернет, становится все более популярным. Эти файрволы обычно </p>
<p>  &nbsp;работают как гэйтэвэи прикладного уровня между сетями, предлагая</p>
<p>  &nbsp;обычно администрируемый TELNET, FTP, и SMTP доступ. С появлением</p>
<p>  &nbsp;более сложных протоколов прикладного уровня предназначенных для</p>
<p>  &nbsp;облегчения глобального информационного взаимодействия, появилась</p>
<p>  &nbsp;потребность в обеспечении общей основы для прозрачной и безопасной</p>
<p>  &nbsp;работы через файрволл для этих протоколов. </p>
<p>Leech, et al &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Standards Track &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [Страница 1]</p>
<p>RFC 1928 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Протокол SOCKS 5 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Март 1996</p>
<p>  &nbsp;Существует также необходимость в строгой аутентификации при работе через</p>
<p>  &nbsp;файрволл, в некоторой степени похожей на используемые сейчас методы. Это </p>
<p>  &nbsp;требование обусловлено тем, что отношения типа клиент-сервер появляются</p>
<p>  &nbsp;между сетями различных организаций, и эти отношения должны быть</p>
<p>  &nbsp;управляемыми и, зачастую, строго аутентифицированны.</p>
<p>  &nbsp;Описываемый здесь протокол разработан чтобы обеспечить основу для</p>
<p>  &nbsp;удобного и безопасного использования сервиса сетевых файрволов для</p>
<p>  &nbsp;приложений типа клиент-сервер работающих по протоколам TCP и UDP.</p>
<p>  &nbsp;Протокол представляет собой "уровень-прокладку" между прикладным</p>
<p>  &nbsp;уровнем и транспортным уровнем, и, как таковой, не обеспечивает</p>
<p>  &nbsp;сервиса гэйтэвэев сетевого уровня, такого как пересылка пакетов ICMP.</p>
<p>2. &nbsp;Текущее положение дел</p>
<p>  &nbsp;Существующий сейчас протокол, SOCKS v4, предназначен для работы через </p>
<p>  &nbsp;файрволл без аутентификации для приложений типа клиент-сервер работающих</p>
<p>  &nbsp;по протоколу TCP, таких как TELNET, FTP и таких популярных протоколов </p>
<p>  &nbsp;обмена информацией, как HTTP, WAIS и GOPHER.</p>
<p>  &nbsp;Новый протокол расширяет модель SOCKS v4 добавляя к ней поддержку UDP,</p>
<p>  &nbsp;обеспечение универсальных схем строгой аутентификации и расширяет </p>
<p>  &nbsp;методы адресации, добавляя поддержку доменных имен и адресов IP v6.</p>
<p>  &nbsp;Реализация протокола SOCKS обычно влечет за собой перекомпиляцию или</p>
<p>  &nbsp;пересборку клиентских программ, работающих по протоколу TCP, для </p>
<p>  &nbsp;использования оответствующх функций SOCKS-библиотеки.</p>
<p>Замечание:</p>
<p>  &nbsp;Если не оговорено обратное, десятичные числа в диаграммах формата </p>
<p>  &nbsp;пакетов обозначают длинну соответствующего поля в октетах (8-битных</p>
<p>  &nbsp;элементах). Если октет должен иметь определенное значение, используется</p>
<p>  &nbsp;обозначение X'hh' для определения значения октета в данном поле.</p>
<p>  &nbsp;Если используется слово 'Variable', это означает, что соответствующее</p>
<p>  &nbsp;поле имеет переменную длинну, определяемую либо связанным (одно- или</p>
<p>  &nbsp;двух-октетным) полем длинны, либо типом данных данного поля.</p>
<p>3. &nbsp;Процедура для клиентов работающих по TCP</p>
<p>  &nbsp;Когда работающий по TCP клиент хочет соединиться с объектом, доступным</p>
<p>  &nbsp;только через файрволл, он должен открыть TCP-соединение c </p>
<p>  &nbsp;соответствующим SOCKS-портом SOCKS-сервера. Сервис SOCKS обычно </p>
<p>  &nbsp;находится на TCP-порту 1080. Если соединение прошло успешно, клиент</p>
<p>  &nbsp;начинает переговоры о методе аутентификации, который будет </p>
<p>Leech, et al &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Standards Track &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [Страница 2]</p>
<p>RFC 1928 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Протокол SOCKS 5 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Март 1996</p>
<p>  &nbsp;использоваваться, проходит аутентификацию по выбранному методу и </p>
<p>  &nbsp;посылает свой запрос. SOCKS-сервер обрабатывает запрос и либо</p>
<p>  &nbsp;пытается установить соответствующее соединение, либо отказывает в нем.</p>
<p>  &nbsp;Клиент соединяется с сервером и посылает сообщение с номером версии</p>
<p>  &nbsp;и выбором соответствующего метода аутентификации:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;+----+----------+----------+</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;|VER | NMETHODS | METHODS &nbsp;|</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;+----+----------+----------+</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;| 1 &nbsp;| &nbsp; &nbsp;1 &nbsp; &nbsp; | 1 to 255 |</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;+----+----------+----------+</p>
<p>  &nbsp;Значение поля VER равно X'05' для данной версии протокола. Поле</p>
<p>  &nbsp;NMETHODS содержит число октетов в идентификаторах методов авторизации</p>
<p>  &nbsp;в поле METHODS.</p>
<p>  &nbsp;Серевер выбирает один из предложенных методов, перечисленных в METHODS,</p>
<p>  &nbsp;и послылает ответ о выбранном методе:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;+----+--------+</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;|VER | METHOD |</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;+----+--------+</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;| 1 &nbsp;| &nbsp; 1 &nbsp; &nbsp;|</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;+----+--------+</p>
<p>  &nbsp;Если выбранный метод в METHOD равен X'FF', то ни один из предложенных </p>
<p>  &nbsp;клиентом методов не применим и клиент должен закрыть соединение.</p>
<p>  &nbsp;Эти значения определены для поля METHOD:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;X'00' аутентификация не требуется</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;X'01' GSSAPI</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;X'02' USERNAME/PASSWORD (см. RFC1929)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;X'03' до X'7F' зарезервировано IANA </p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;X'80' до X'FE' преднозначено для частных методов</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;X'FF' нет применимых методов</p>
<p>  &nbsp;Затем клиент и сервер начинают аутентификацию согласно выбранному методу.</p>
<p>Leech, et al &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Standards Track &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [Страница 3]</p>
<p>RFC 1928 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Протокол SOCKS 5 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Март 1996</p>
<p>  &nbsp;Описание методов аутентификации находится в отдельных документах.</p>
<p>  &nbsp;Разработчики новых методов аутентификации применимых для этого протокола</p>
<p>  &nbsp;должны обращаться в IANA для получения номера метода. Документ с</p>
<p>  &nbsp;выделеными номерами должен дополнить текущий список номеров и </p>
<p>  &nbsp;соответствущих им методов аутентификации.</p>
<p>  &nbsp;Совместимые реализации должны поддерживать GSSAPI и могут поддерживать</p>
<p>  &nbsp;аутентификацию USERNAME/PASSWORD.</p>
<p>4. &nbsp;Запросы</p>
<p>  &nbsp;После того как аутентификация выполнена, клиент посылает детали запроса.</p>
<p>  &nbsp;Если выбранный метод аутентификации требует особое формирование пакетов</p>
<p>  &nbsp;с целью проверки целостности и/или конфедициальности, запросы должны</p>
<p>  &nbsp;инкапсулироваться в пакет, формат которого определяется выбранным </p>
<p>  &nbsp;методом.</p>
<p>  &nbsp;SOCKS-запрос формируется следующим образом:</p>
<p>  &nbsp; &nbsp; &nbsp; +----+-----+-------+------+----------+----------+</p>
<p>  &nbsp; &nbsp; &nbsp; |VER | CMD | &nbsp;RSV &nbsp;| ATYP | DST.ADDR | DST.PORT |</p>
<p>  &nbsp; &nbsp; &nbsp; +----+-----+-------+------+----------+----------+</p>
<p>  &nbsp; &nbsp; &nbsp; | 1 &nbsp;| &nbsp;1 &nbsp;| X'00' | &nbsp;1 &nbsp; | Variable | &nbsp; &nbsp;2 &nbsp; &nbsp; |</p>
<p>  &nbsp; &nbsp; &nbsp; +----+-----+-------+------+----------+----------+</p>
<p>  &nbsp; &nbsp;Где:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;VER &nbsp; &nbsp;версия протокола: X'05'</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;CMD</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;o &nbsp;CONNECT X'01'</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;o &nbsp;BIND X'02'</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;o &nbsp;UDP ASSOCIATE X'03'</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;RSV &nbsp; &nbsp;зарезервировано</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;ATYP &nbsp; тип адреса, следующего вида:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;o &nbsp;IP v4 адрес: X'01'</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;o &nbsp;имя домена: &nbsp;X'03'</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;o &nbsp;IP v6 адрес: X'04'</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;DST.ADDR требуемый адрес</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;DST.PORT требуемый порт (в сетевом порядке октетов)</p>
<p>  &nbsp;SOCKS-сервер обрабатывает запрос на основании исходного и целевого</p>
<p>  &nbsp;адресов и посылает одно или несколько сообщений в ответ, в соответствии</p>
<p>  &nbsp;с типом запроса.</p>
<p>Leech, et al &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Standards Track &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [Страница 4]</p>
<p>RFC 1928 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Протокол SOCKS 5 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Март 1996</p>
<p>5. &nbsp;Адресация</p>
<p>  &nbsp;Тип адреса содержащегося в адресном поле (DST.ADDR, BND.ADDR), </p>
<p>  &nbsp;определяется содержимым поля ATYP:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;X'01'</p>
<p>  &nbsp;адрес является адресом IP v4, длинна адреса 4 октета</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;X'03'</p>
<p>  &nbsp;поле адреса содержит имя домена. Первый октет адресного поля содержит</p>
<p>  &nbsp;число октетов в последующем за ним имени, завершающий NUL-октет в конце</p>
<p>  &nbsp;строки не применяется.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;X'04'</p>
<p>  &nbsp;адрес является адресом IP v6, длинна адреса 16 октет &nbsp; </p>
<p>6. &nbsp;Ответы</p>
<p>  &nbsp;SOCKS-запрос посылается клиентом как только он установил соединение с</p>
<p>  &nbsp;SOCKS-сервером и выполнил аутентификацию. Сервер обрабатывает запрос и</p>
<p>  &nbsp;посылает ответ в следующей форме:</p>
<p>  &nbsp; &nbsp; &nbsp; +----+-----+-------+------+----------+----------+</p>
<p>  &nbsp; &nbsp; &nbsp; |VER | REP | &nbsp;RSV &nbsp;| ATYP | BND.ADDR | BND.PORT |</p>
<p>  &nbsp; &nbsp; &nbsp; +----+-----+-------+------+----------+----------+</p>
<p>  &nbsp; &nbsp; &nbsp; | 1 &nbsp;| &nbsp;1 &nbsp;| X'00' | &nbsp;1 &nbsp; | Variable | &nbsp; &nbsp;2 &nbsp; &nbsp; |</p>
<p>  &nbsp; &nbsp; &nbsp; +----+-----+-------+------+----------+----------+</p>
<p>  &nbsp; &nbsp;Где:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;VER &nbsp; &nbsp;версия протокола: X'05'</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;REP &nbsp; &nbsp;код ответа:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;o &nbsp;X'00' успешный</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;o &nbsp;X'01' ошибка SOCKS-сервера</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;o &nbsp;X'02' соединение запрещено набором правил</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;o &nbsp;X'03' сеть недоступна</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;o &nbsp;X'04' хост недоступен</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;o &nbsp;X'05' отказ в соединении</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;o &nbsp;X'06' истечение TTL</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;o &nbsp;X'07' команда не поддерживается</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;o &nbsp;X'08' тип адреса не поддерживается</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;o &nbsp;X'09' до X'FF' не определены</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;RSV &nbsp; &nbsp;зарезервирован</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;ATYP &nbsp; тип последующего адреса</p>
<p>Leech, et al &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Standards Track &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [Страница 5]</p>
<p>RFC 1928 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Протокол SOCKS 5 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Март 1996</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;o &nbsp;IP v4 адрес: X'01'</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;o &nbsp;имя домена: &nbsp;X'03'</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;o &nbsp;IP v6 адрес: X'04'</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;BND.ADDR &nbsp; &nbsp; &nbsp; выданный сервером адрес</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;BND.PORT &nbsp; &nbsp; &nbsp; выданный сервером порт (в сетевом порядке октетов)</p>
<p>  &nbsp;Значения зарезервированных (RSV) полей должны быть установлены в X'00'.</p>
<p>  &nbsp;Если выбранный метод аутентификации требует особое формирование пакетов</p>
<p>  &nbsp;с целью проверки целостности и/или конфедициальности, запросы должны</p>
<p>  &nbsp;инкапсулироваться в пакет, формат которого определяется выбранным </p>
<p>  &nbsp;методом.</p>
<p>CONNECT</p>
<p>  &nbsp;В ответ на CONNECT, BND.PORT содержит номер порта, который сервер</p>
<p>  &nbsp;назначает для соединения с указанным хостом, а BND.ADDR содержит</p>
<p>  &nbsp;связанный IP-адрес. Выданный BND.ADDR зачастую отличается от </p>
<p>  &nbsp;IP-адреса, который клиент использует для доступа к SOCKS-северу,</p>
<p>  &nbsp;так как такие сервера часто имеют несколько IP-адресов. Ожидается,</p>
<p>  &nbsp;что сервер будет использовать DST.ADDR и DST.PORT и адрес клиента</p>
<p>  &nbsp;при обработке запроса CONNECT.</p>
<p>BIND</p>
<p>  &nbsp;Запрос BIND используется в протоколах, которые требуют чтобы клиент</p>
<p>  &nbsp;принимал соединение со стороны сервера. Хорошим примером этого</p>
<p>  &nbsp;является FTP, который использует основное соединение клиент-к-серверу</p>
<p>  &nbsp;для комманд и сообщений, но может использовать соединение </p>
<p>  &nbsp;сервер-к-клиенту для передачи данных по запросу (например LS, GET, PUT).</p>
<p>  &nbsp;Ожидается, что клиентская сторона прикладного протокола будет</p>
<p>  &nbsp;использовать запрос BIND только для установки вторичного соединения,</p>
<p>  &nbsp;после первичного соединения, установленного с использованием CONNECT.</p>
<p>  &nbsp;Ожидается, что сервер будет использовать DST.ADDR и DST.PORT</p>
<p>  &nbsp;при обработке запроса BIND.</p>
<p>  &nbsp;SOCKS-сервер посылает два ответа клиенту в течении операции BIND.</p>
<p>  &nbsp;Первый послыается после того, как сервер создает и привязывает</p>
<p>  &nbsp;новый сокет. Поле BND.PORT содержит номер порта, который SOCKS-сервер</p>
<p>  &nbsp;выделил для входящего соединения. Поле BND.ADDR содержит связанный</p>
<p>  &nbsp;IP-адрес. Клиент может использовать эту информацию для уведомления</p>
<p>  &nbsp;(через первичное соединение) приложения-сервера об адресе для</p>
<p>  &nbsp;взаимодействия. Второе уведомление происходит после ожидаемого</p>
<p>  &nbsp;входящего соединения или неудачной попытке входящего соединения.</p>
<p>Leech, et al &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Standards Track &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [Страница 6]</p>
<p>RFC 1928 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Протокол SOCKS 5 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Март 1996</p>
<p>  &nbsp;При втором ответе поля BND.PORT и BND.ADDR содержат адрес и номер</p>
<p>  &nbsp;порта присоединившегося хоста.</p>
<p>UDP ASSOCIATE</p>
<p>  &nbsp;Запрос UDP ASSOCIATE используется для установления соединения</p>
<p>  &nbsp;посылающим UDP-сообщения процессом. Поля DST.ADDR и DST.PORT содержат</p>
<p>  &nbsp;адрес и порт, на который клиент собирается слать UDP-датаграммы</p>
<p>  &nbsp;после установки соединения. Сервер может использовать эту информацию</p>
<p>  &nbsp;в целях ограничения доступа. Если клиент не располагает информацией</p>
<p>  &nbsp;об адресе на момент запроса UDP ASSOCIATE, то клиент должен заполнить</p>
<p>  &nbsp;нулями номер порта и адреса.</p>
<p>  &nbsp;UDP-связь обрывается, когда обрывается TCP-соединение выполнившее</p>
<p>  &nbsp;запрос UDP ASSOCIATE.</p>
<p>  &nbsp;В ответе на запрос UDP ASSOCIATE, поля BND.PORT и BND.ADDR определяют</p>
<p>  &nbsp;порт и адрес, куда клиент должен слать UDP-датаграмы для пересылки.</p>
<p>Обработка ответов</p>
<p>  &nbsp;Когда приходит ответ с сообщением о неудаче (значение REP не равно </p>
<p>  &nbsp;X'00'), то SOCKS сервер должен оборвать TCP-соединение вскоре после</p>
<p>  &nbsp;посылки ответа. Это должно произойти не более чем спустя 10 секунд</p>
<p>  &nbsp;после определения причин вызвавших неудачу.</p>
<p>  &nbsp;При получении ответа с сообщением об удаче (значение REP равно X'00'),</p>
<p>  &nbsp;если запросом был BIND или CONNECT, то клиент может начинать передавать</p>
<p>  &nbsp;данные. Если выбранная схема аутентификации требует особое формирование</p>
<p>  &nbsp;пакетов с целью проверки целостности и/или конфедициальности, данные</p>
<p>  &nbsp;должны инкапсулироваться в пакет, формат которого определяется выбранным</p>
<p>  &nbsp;методом. Подобно этому, когда данные для клиента получаются</p>
<p>  &nbsp;SOCKS-сервером, сервер должен инкапсулировать данные согласно тому,</p>
<p>  &nbsp;как это требует выбранный метод аутентификации.</p>
<p>7. &nbsp;Процедура для клиентов работающих по UDP</p>
<p>  &nbsp;Клиент, работающий по UDP, должен посылать свои датаграмы на</p>
<p>  &nbsp;порт пересылающего их UDP-сервера, указанного в поле BND.PORT в</p>
<p>  &nbsp;ответе на запрос UDP ASSOCIATE. Если выбранная схема аутентификации</p>
<p>  &nbsp;требует особое формирование пакетов с целью проверки целостности </p>
<p>  &nbsp;и/или конфедициальности, датаграмма должна инкапсулироваться в пакет,</p>
<p>  &nbsp;формат которого определяется выбранной схемой. Каждая UDP-датаграма</p>
<p>  &nbsp;содержит в себе заголовок UDP-запроса:</p>
<p>Leech, et al &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Standards Track &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [Страница 7]</p>
<p>RFC 1928 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Протокол SOCKS 5 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Март 1996</p>
<p>  &nbsp; &nbsp; +----+------+------+----------+----------+----------+</p>
<p>  &nbsp; &nbsp; |RSV | FRAG | ATYP | DST.ADDR | DST.PORT | &nbsp; DATA &nbsp; |</p>
<p>  &nbsp; &nbsp; +----+------+------+----------+----------+----------+</p>
<p>  &nbsp; &nbsp; | 2 &nbsp;| &nbsp;1 &nbsp; | &nbsp;1 &nbsp; | Variable | &nbsp; &nbsp;2 &nbsp; &nbsp; | Variable |</p>
<p>  &nbsp; &nbsp; +----+------+------+----------+----------+----------+</p>
<p>  &nbsp; &nbsp;Поля заголовка UDP-запроса:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;RSV &nbsp;зарезервировано X'0000'</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;FRAG &nbsp; &nbsp;текущий номер фрагмента</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;ATYP &nbsp; &nbsp;тип адреса:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;o &nbsp;IP v4 адрес: X'01'</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;o &nbsp;имя домена: &nbsp;X'03'</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;o &nbsp;IP v6 адрес: X'04'</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;DST.ADDR &nbsp; &nbsp; &nbsp; требуемый целевой адрес</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;DST.PORT &nbsp; &nbsp; &nbsp; требуемый целевой порт</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;DATA &nbsp; &nbsp; пользовательские данные</p>
<p>  &nbsp;Когда пересылающий UDP-датаграммы сервер пересылает датаграмму, он</p>
<p>  &nbsp;делает это молча, без какого-либо уведомления выполнившего запрос </p>
<p>  &nbsp;клиента. Аналогично, сервер будет молча отбрасывать датаграммы,</p>
<p>  &nbsp;которые он не может или не будет пересылать. Когда пересылающий</p>
<p>  &nbsp;UDP-датаграммы сервер получает ответную датаграмму с удаленного</p>
<p>  &nbsp;хоста, он должен инкапсулировать эту датаграмму используя помимо</p>
<p>  &nbsp;заголовка UDP-запроса еще и инкапсуляцию, определяемую выбранной</p>
<p>  &nbsp;схемой аутентификации.</p>
<p>  &nbsp;Обращение к пересылающему UDP-датаграммы серверу должно производиться</p>
<p>  &nbsp;с ожидаемого SOCKS-сервером IP-адреса клиента, который (клиент) будет</p>
<p>  &nbsp;посылать датаграммы на BND.PORT, данный в ответе на UDP ASSOCIATE.</p>
<p>  &nbsp;Сервер должен отбрасывать датаграммы полученные с любого IP-адреса,</p>
<p>  &nbsp;отличного от того, что был записан для этой связи.</p>
<p>  &nbsp;Поле FRAG показывает, является ли эта датаграмма самостоятельной или</p>
<p>  &nbsp;же фрагментом. Если датаграмма - фрагмент, то установленный старший </p>
<p>  &nbsp;бит является признаком последнего фрагмента, в то время как значение</p>
<p>  &nbsp;X'00' показывает, что это обычная датаграмма. Значения от 1 до 127 </p>
<p>  &nbsp;обозначают на позицию фрагменте в последовательности. Каждый</p>
<p>  &nbsp;получатель будет иметь REASSEMBLY QUEUE (очередь сборки) и REASSEMBLY</p>
<p>  &nbsp;TIMER (таймер сборки) связанные с такой фрагментной датаграммой.</p>
<p>  &nbsp;Очередь сборки должна быть переинициализирована и связанные с ней</p>
<p>  &nbsp;фрагменты выкинуты всякий раз при истечении таймера сборки или</p>
<p>  &nbsp;с приходом новой датаграммы, чье значение в поле FRAG меньше,</p>
<p>  &nbsp;чем наибольшее значение поля FRAG датаграмм, обработанных</p>
<p>  &nbsp;при сборке фрагмента. Таймер сборки должен быть не менее 5 секунд.</p>
<p>  &nbsp;Приложениям рекомендуется избегать фрагментацию везде, где только</p>
<p>  &nbsp;это возможно.</p>
<p>  &nbsp;Реализация фрагментации опциональна, в реализациях где фрагментация </p>
<p>  &nbsp;не поддерживается, должны отбрасываться любые датаграммы, у которых</p>
<p>  &nbsp;поле FRAG отлично от X'00'.</p>
<p>Leech, et al &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Standards Track &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [Страница 8]</p>
<p>RFC 1928 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Протокол SOCKS 5 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Март 1996</p>
<p>  &nbsp;Программный интерфейс для UDP работающего через SOCKS должен сообщать</p>
<p>  &nbsp;о оставшемся свободном пространстве в буфере для UDP-датаграмы, которое</p>
<p>  &nbsp;меньше, чем действительный размер буфера, выделенный операционной</p>
<p>  &nbsp;системой:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;если ATYP равен X'01' - на 10+зависит_от_метода октетов меньше</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;если ATYP равен X'03' - на 262+зависит_от_метода октетов меньше</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; o &nbsp;если ATYP равен X'04' - на 20+зависит_от_метода октетов меньше</p>
<p>  &nbsp;Иными словами, так как в заголовке UDP-запроса, включенного в датаграмму,</p>
<p>  &nbsp;нет информации о длинне данных, то приложение должно помнить об этом</p>
<p>  &nbsp;самостоятельно.</p>
<p>8. &nbsp;Замечания по безопасности</p>
<p>  &nbsp;Этот документ описывает протокол для работы на прикладном уровне </p>
<p>  &nbsp;с файрволлами в IP-сетях. Безопасность такой работы в большой</p>
<p>  &nbsp;степени зависит от особенностей аутентификации и инкапсуляции</p>
<p>  &nbsp;методов, обеспеченных в конкретной реализации и выбранных</p>
<p>  &nbsp;во время соединения клиента с SOCKS-cервером.</p>
<p>  &nbsp;При выборе метода аутентификации администраторы должны проявить особое</p>
<p>  &nbsp;внимание. &nbsp; </p>
<p>  &nbsp;Careful consideration should be given by the administrator to the</p>
<p>  &nbsp;selection of authentication methods.</p>
<p>9. &nbsp;Ссылки</p>
<p>  &nbsp;[1] Koblas, D., "SOCKS", Proceedings: 1992 Usenix Security Symposium.</p>
<p>Адрес автора</p>
<p>  &nbsp; &nbsp; &nbsp;Marcus Leech</p>
<p>  &nbsp; &nbsp; &nbsp;Bell-Northern Research Ltd</p>
<p>  &nbsp; &nbsp; &nbsp;P.O. Box 3511, Stn. C,</p>
<p>  &nbsp; &nbsp; &nbsp;Ottawa, ON</p>
<p>  &nbsp; &nbsp; &nbsp;CANADA K1Y 4H7</p>
<p>  &nbsp; &nbsp; &nbsp;Phone: (613) 763-9145</p>
<p>  &nbsp; &nbsp; &nbsp;EMail: mleech@bnr.ca</p>

