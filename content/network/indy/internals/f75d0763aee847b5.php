<h1>Введение в сокеты</h1>
<div class="date">01.01.2007</div>

<p>3. Введение в сокеты</p>
3.1. Обзор</p>
Данная глава является введением в концепцию сокетов (TCP/IP сокеты). Это не означает, что мы рассмотрим все аспекты сокетов; это только начальное обучение читателя, что бы можно было начать программировать.</p>
Есть несколько концепций, которые должны быть объяснены в первую очередь. При возможности, концепции будут подобны концепция телефонных систем.</p>
3.2. Стек протоколов TCP/IP</p>
TCP/IP это сокращение от Transmission Control Protocol and Internet Protocol.</p>
TCP/IP может означать разные вещи. Очень часто в общем как слово «хватать все» (catch all). В большинстве других случаев, это относится к сетевому протоколу само по себе.</p>
3.3. Клиент</p>
Клиент &#8211; это процесс, который инициализирует соединение. Обычно, клиенты общаются с одним сервером за раз. Если процессу требуется общаться с несколькими серверами, то создаются несколько клиентов.</p>
Подобно, телефонному вызову, клиент это та персона, которая делает вызов.</p>
3.4. Сервер</p>
Сервер &#8211; это процесс, который отвечает на входящий запрос. Обычно сервер обслуживает некоторое количество запросов, от нескольких клиентов одновременно. Тем не менее, каждое соединение от сервера к клиенту является отдельным сокетом.</p>
Подобно, телефонному вызову, сервер это та персона, которая отвечает на звонок. Сервер обычно устроен так, что в состоянии отвечать на несколько телефонных звонков. Это подобно звонку в центр обслуживания, который может иметь сотен операторов и обслуживание передается первому свободному оператору.</p>
3.5. IP адрес</p>
Каждый компьютер в TCP/IP сети имеет свой уникальный адрес. Некоторые компьютеры могут иметь более одного адреса. IP адрес - это 32-битный номер и обычно представляется с помощью точечной нотации, например 192.168.0.1. Каждая секция представляет собой одни байт 32-битного адреса. IP адрес подобен телефонному номеру. Тем не менее, точно так же, как и в жизни, вы можете иметь более одного телефонного номера, вы можете иметь и более одного IP адрес, назначенного вам. Машины, которые имеют более одного IP адреса, называются multi-homed.</p>
Для разговора с кем-то, в определенном месте, делается попытка соединения (делается набор номера). Ответная сторона, услышав звонок, отвечает на него.</p>
Часто IP адрес для сокращения называют просто IP.</p>
3.6. Порт</p>
Порт &#8211; это целочисленный номер, который идентифицирует, с каким приложением или сервисом клиента будет соединение на обслуживание по данному IP адресу.</p>
Порт подобен расширению телефонного номера. Набрав телефонный номер, вы подсоединяетесь к клиенту, но в TCP/IP каждый клиент имеет расширение. Не существует расширений по умолчанию, как в случае с локальной телефонной станцией. В дополнении к IP адресу вы обязаны явно указать порт при соединении с сервером.</p>
Когда серверное приложение готово воспринимать входящие запросы, то оно начинает прослушивать порт. Поэтому приложение или протокол используют общие заранее известные мировые порты. Когда клиент желает пообщаться с сервером, он обязан знать, где приложение (IP адрес/телефонный номер) и какой порт (расширение телефонного номера), приложение прослушивает (отвечает).</p>
Обычно приложения имеют фиксированный номер, чтобы не было проблем для приложения. Например, HTTP использует порт 80, а FTP использует порт 21. Поэтому достаточно знать адрес компьютера, чтобы просмотреть web страницу.</p>
Порты ниже 1024 резервированы и должны использовать только для реализации известных протоколов, которые используют подобный порт для его использования. Большинство популярных протоколов используют резервированные номера портов.</p>
3.7. Протокол</p>
Слово протокол происходит от греческого слова protocollon. Это страница, которая приклеивалась к манускрипту, описывающая его содержимое.</p>
В терминах TCP/IP, протокол это описание как производить некоторые действия. НО в большинстве случаев это обычно одна из двух вещей:</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Тип сокета.</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Протокол более высокого командного уровня.</td></tr></table></div>Когда говорим о сокетах, то протокол описывает его тип. Распространенные типы сокетов следующие - TCP, UDP и ICMP</p>
Когда говорим о протоколах более высокого уровня, то это относится к командам и ответам, для реализации требуемых функций. Эти протоколы описаны в RFC. Примеры таких протоколов &#8211; это HTTP, FTP и SMTP.</p>
3.8. Сокет</p>
Все что здесь говорится об сокетах, относится к TCP/IP. Сокет это комбинация IP адреса, порта и протокола. Сокет также виртуальный коммуникационный трубопровод между двумя процессами. Эти процессы могут быть локальными (расположенными на одном и том же компьютере) или удаленными.</p>
Сокет подобен телефонному соединению, которое обеспечивает разговор. Для того чтобы осуществить разговор, вы обязаны в первую очередь сделать вызов, получить ответ с другой стороны; другими словами нет соединения (сокета) - нет разговора.</p>
3.9. Имя узла</p>
Имя узла это человеческий синоним, вместо IP адреса. Например, есть узел www.nevrona.com. Каждый узел имеет свой эквивалент в виде IP адреса. Для www.nevrona.com это 208.225.207.130.</p>
Использование имен узлов проще для человека, к тому же позволяет сменить IP адрес без проблем для потенциальных клиентов, без их потери.</p>
Имя узла подобно имени человека или названию фирмы. Человек или фирма могут сменить свой телефонный номер, но вы сможете продолжать связываться с ними.</p>
От переводчика: видимо тут намекают на телефонный справочник, как аналог DNS. Иначе, о какой возможности можно говорить.</p>
3.10. Сервис DNS</p>
DNS это сокращение от Domain Name Service.</p>
Задача DNS преобразовывать имена узлов в IP адреса. Для установки соединения, требуется IP адрес, DNS используется, чтобы сначала преобразовать имя в IP адрес.</p>
Что бы сделать телефонный звонок, вы должны набрать телефонный номер. Вы не можете для этого использовать его имя. Если вы не знаете номер человека или если он был изменен, то вы можете посмотреть его номер в телефонной книге. DNS является аналогом телефонной книги.</p>
3.11. Протокол TCP</p>
TCP это сокращение от Transmission Control Protocol.</p>
Иногда TCP также называют потоковым протоколом. TCP/IP включает много протоколов и множество путей для коммуникации. Наиболее часто используемые транспорты это TCP и UDP. TCP это протокол, основанный на соединении, вы должны соединиться с сервером, прежде чем сможете передавать данные. TCP также гарантирует доставку и точность передачи данных. TCP также гарантирует, что данные будут приняты в том же порядке, как и переданы. Большинство вещей, которые используют TCP/IP - используют TCP как транспорт.</p>
TCP соединения, подобны телефонному звонку для разговора.</p>
3.12. Протокол UDP</p>
UDP это сокращение от User Datagram Protocol.</p>
UDP предназначен для датаграмм, и он не требует соединения. UDP позволяет посылать облегченные пакеты на узел без установки соединения. Для UDP пакетов не гарантируется доставка и последовательность доставки. При передаче UDP пакетов, они отсылаются в блоке. Поэтому вы не должны превышать максимальный размер пакета, указанный в вашем TCP/IP стеке.</p>
Поэтому многие люди считают UDP малоприменим. Но это не так, многие потоковые протоколы, такие как RealAudio, используют UDP.</p>
Примечание: термин потоковый (streaming) может быть перепутан с термином потоковое соединение (stream connection), которое относится к TCP. Когда вы видите эти термины, вы должны определить, что именно имеется в виду.</p>
Надежность/достоверность UDP пакетов зависит надежности и перегрузки сети. UDP пакеты часто используются в локальных сетях (LAN), поскольку локальная сеть очень надежная и не перегруженная. UDP пакеты, проходящие через Интернет так же обычно надежны и могут использовать коррекцию ошибок передачи или интерполяцию. Доставка не может быть гарантирована в любой сети &#8211; потом не будем считать, что ваши данные всегда достигнут точки назначения.</p>
Поскольку UDP не имеет средств подтверждения доставки, то вообще нет гарантии этой доставки. Если вы посылаете UDP пакет на другой узел, то вы не имеете возможности узнать, доставлен пакет или нет. Стек не может определить это и не выдает никакой информации об ошибке, если пакет не доставлен. Если вам требуется подобная гарантия, то вы должны сами организовать ответ от удаленного узла.</p>
UDP аналогичен посылке сообщения на обычный пейджер. Вы знаете, что вы послали, но вы не знаете получено ли оно. Пейджер может не существовать, или находиться вне зоны приема, или может быть выключен, или не работоспособен, в дополнение сеть может потерять ваше сообщение. Пока обратная сторона не сообщит о приеме сообщения, вы этого не узнаете. В дополнение, если вы посылаете несколько сообщений, то возможно они поступят совсем в другом порядке.</p>
Дополнительная информация по UDP находится в главе 7.</p>
3.13. Протокол ICMP</p>
ICMP это сокращение от Internet Control Message Protocol.</p>
ICMP это протокол управления и обслуживания. Обычно, вам не потребуется использовать этот протокол. Обычно он используется для общения с маршрутизаторами и другим сетевым оборудованием. ICMP позволяет узлам получать статус и информацию об ошибке. ICMP используется для протоколов PING, TRACEROUTE и других подобных.</p>
3.14. Файл HOSTS</p>
Файл HOSTS это текстовый файл, который содержит локальную информацию об узлах.</p>
Когда стек пытается определить IP адрес для узла, то он сначала просматривает этот файл. Если информация будет найдена, то используется она, если же нет, то процесс продолжается с использованием DNS.</p>
Это пример файла HOSTS:</p>
# This is a sample HOSTS file</p>
Caesar&nbsp;&nbsp; 192.168.0.4&nbsp; # Server computer</p>
augustus 192.168.0.5&nbsp; # Firewall computer</p>
Имя узла и IP адрес должны быть разделены с помощью пробела или табуляции. Комментарии также могут быть вставлены в файл, для этого должен быть использован символ #.</p>
Файл HOSTS может быть использован для ввода ложных значений или для замены значений DNS. Файл HOSTS часто используется в малых сетях, которые не имеют DNS сервера. Файл HOSTS также используется для перекрытия IP адресов при отладке. Вам не требуется читать этот файл, поскольку стек протоколов делает это самостоятельно и прозрачно для вас.</p>
3.15. Файл SERVICES</p>
Файл SERVICES подобен файлу HOSTS. Вместо разрешения узлов в IP адреса, он разрешает имена сервисов в номера портов.</p>
Ниже пример, урезанный, файла SERVICES. Для полного списка сервисов вы можете обратиться к RFC 1700. RFC 1700 содержит определение сервисов и их портов:</p>
Echo &nbsp; &nbsp; &nbsp; &nbsp;7/tcp</p>
Echo &nbsp; &nbsp; &nbsp; &nbsp;7/udp</p>
Discard &nbsp; &nbsp; &nbsp; &nbsp;9/tcp &nbsp; &nbsp; &nbsp; &nbsp;sink null</p>
Discard &nbsp; &nbsp; &nbsp; &nbsp;9/udp &nbsp; &nbsp; &nbsp; &nbsp;sink null</p>
Systat &nbsp; &nbsp; &nbsp; &nbsp;11/tcp &nbsp; &nbsp; &nbsp; &nbsp;users &nbsp; &nbsp; &nbsp; &nbsp;#Active users</p>
Systat &nbsp; &nbsp; &nbsp; &nbsp;11/tcp &nbsp; &nbsp; &nbsp; &nbsp;users &nbsp; &nbsp; &nbsp; &nbsp;#Active users</p>
Daytime &nbsp; &nbsp; &nbsp; &nbsp;13/tcp</p>
Daytime &nbsp; &nbsp; &nbsp; &nbsp;13/udp</p>
Qotd &nbsp; &nbsp; &nbsp; &nbsp;17/tcp &nbsp; &nbsp; &nbsp; &nbsp;quote &nbsp; &nbsp; &nbsp; &nbsp;#Quote of the day</p>
qotd &nbsp; &nbsp; &nbsp; &nbsp;17/udp &nbsp; &nbsp; &nbsp; &nbsp;quote &nbsp; &nbsp; &nbsp; &nbsp;#Quote of the day</p>
chargen &nbsp; &nbsp; &nbsp; &nbsp;19/tcp &nbsp; &nbsp; &nbsp; &nbsp;ttytst source &nbsp; &nbsp; &nbsp; &nbsp;#Character generator</p>
chargen 19/udp &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ttytst source &nbsp; &nbsp; &nbsp; &nbsp;#Character generator</p>
ftp-data &nbsp; &nbsp; &nbsp; &nbsp;20/tcp &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;#FTP data</p>
ftp &nbsp; &nbsp; &nbsp; &nbsp;21/tcp &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;#FTP control</p>
telnet &nbsp; &nbsp; &nbsp; &nbsp;23/tcp</p>
smtp &nbsp; &nbsp; &nbsp; &nbsp;25/tcp &nbsp; &nbsp; &nbsp; &nbsp;mail &nbsp; &nbsp; &nbsp; &nbsp;#Simple Mail Transfer Protocol</p>
Формат файла следующий:</p>
&lt;service name&gt; &lt;port number&gt;/&lt;protocol&gt; [aliases...] [#&lt;comment&gt;]</p>
Вам не требуется читать данный файл, поскольку стек протоколов делает это самостоятельно и прозрачно для вас. Файл SERVICES может быть прочитан с помощью специальной функции стека, но большинство программ не используют эту функции и игнорируют их значения. Например, многие FTP программы используют порт по умолчанию без обращения к функциям стека, для определения номера порта по имени &#8216;FTP&#8217;.</p>
Обычно вы никогда не должны изменять этот файл. Некоторые программы, тем не менее, добавляют свои значения в него и реально используют его. Вы можете изменить их значения, чтобы заставить использовать программу другой порт. Одна из таких программ &#8211; это Interbase. Interbase добавляет в файл следующую строку:</p>
gds_db &nbsp; &nbsp; &nbsp; &nbsp;3050/tcp</p>
Вы можете изменить ее и Interbase будет использовать другой порт. Обычно это не слишком хорошая практика делать подобное. Но это может потребоваться, если вы пишите приложение с сокетами, обычно серверное приложение. Так же хорошей практикой при написании клиентов &#8211; это использование функций стека, для получения значений из файла SERVICES, особенно для нестандартных протоколов. Если вхождение не найдено, то можно использовать порт по умолчанию.</p>
3.16. Localhost (Loopback)</p>
LOCALHOST подобен "Self" в Delphi или "this" в C++. LOCALHOST ссылается на компьютер, на котором выполняется приложение. Это адрес обратной петли и это реальный физический IP адрес, со значением 127.0.0.1. Если 127.0.0.1 используется на клиенте, он всегда возвращает пакет обратно на тот же компьютер, для сервера на том же компьютере, что и клиент.</p>
Это очень полезно для отладки. Это также может быть использовано для связи с сервисами, запущенными на этом же компьютере. Если вы имеете локальный web сервер, то вам не надо знать его адрес и изменять свои скрипты, каждый раз как адрес будет изменен, вместо этого используйте 127.0.0.1.</p>
От переводчика: вообще то Localhost, может иметь и другой адрес, но как правило, это 127.0.0.1</p>
3.17. Программа Ping</p>
Ping - это протокол, который проверяет доступен ли узел с локального компьютера, или нет. Ping обычно используется в диагностических целях.</p>
Ping работает из командной строки, синтаксис использования следующий:</p>
ping &lt;host name or IP&gt;</p>
Если узел доступен, то вывод выглядит так:</p>
&nbsp;</p>
C:\ping localhost</p>
&nbsp;</p>
Обмен пакетами с xp.host.ru [127.0.0.1] по 32 байт:</p>
&nbsp;</p>
Ответ от 127.0.0.1: число байт=32 время&lt;1мс TTL=128</p>
Ответ от 127.0.0.1: число байт=32 время&lt;1мс TTL=128</p>
Ответ от 127.0.0.1: число байт=32 время&lt;1мс TTL=128</p>
Ответ от 127.0.0.1: число байт=32 время&lt;1мс TTL=128</p>
&nbsp;</p>
Статистика Ping для 127.0.0.1:</p>
 &nbsp;&nbsp; Пакетов: отправлено = 4, получено = 4, потеряно = 0 (0% потерь</p>
Приблизительное время приема-передачи в мс:</p>
 &nbsp;&nbsp; Минимальное = 0мсек, Максимальное = 0 мсек, Среднее = 0 мсек</p>
Если узел не доступен, то вывод выглядит так:</p>
C:\&gt;ping 192.168.0.200</p>
Pinging 192.168.0.200 with 32 bytes of data:</p>
Request timed out.</p>
Request timed out.</p>
Request timed out.</p>
Request timed out.</p>
Ping statistics for 192.168.0.200:</p>
 &nbsp;&nbsp; Packets: Sent = 4, Received = 0, Lost = 4 (100% loss),</p>
3.18. Программа TraceRoute</p>
TCP/IP пакеты не двигаются напрямую от узла к узлу. Пакеты маршрутизируются подобно движению автомобилей от одного дома до другого. Обычно, автомобиль должен двигаться более чем по одной дороге, пока не достигнет точки назначения. TCP/IP пакеты двигаются подобным образом. Каждый раз пакет сменяет «дорогу» от маршрутизатора (node) к маршрутизатору. Получив список маршрутизаторов можно определить список узлов (host), по которым путешествует пакет. Это очень полезно для диагностики, почему тот или другой узел недоступен.</p>
Traceroute работает из командной строки, Traceroute показывает список IP маршрутизаторов, через которые проходит трасса до узла назначения и сколько требуется времени на каждый прыжок, до каждого узла. Данное время пригодна для поиска узких мест. Traceroute показывает последний маршрутизатор, который нормально обработал пакет, в случае неудачной передачи. Traceroute используется для дальнейшей диагностики после пинга.</p>
Пример вывода работы Traceroute при удачном прохождении:</p>
C:\&gt;tracert www.atozedsoftware.com</p>
Tracing route to www.atozedsoftware.com [213.239.44.103]</p>
over a maximum of 30 hops:</p>
1 &lt;1 ms &lt;1 ms &lt;1 ms server.mshome.NET [192.168.0.1]</p>
2 54 ms 54 ms 50 ms 102.111.0.13</p>
3 54 ms 51 ms 53 ms 192.168.0.9</p>
4 55 ms 54 ms 54 ms 192.168.5.2</p>
5 55 ms 232 ms 53 ms 195.14.128.42</p>
6 56 ms 55 ms 54 ms cosmos-e.cytanet.NET [195.14.157.1]</p>
7 239 ms 237 ms 237 ms ds3-6-0-cr02.nyc01.pccwbtn.NET [63.218.9.1]</p>
8 304 ms 304 ms 303 ms ge-4-2-cr02.ldn01.pccwbtn.NET [63.218.12.66]</p>
9 304 ms 307 ms 307 ms linx.uk2net.com [195.66.224.19]</p>
10 309 ms 302 ms 306 ms gw12k-hex.uk2net.com [213.239.57.1]</p>
11 307 ms 306 ms 305 ms pop3 [213.239.44.103]</p>
Trace complete.</p>
3.19. LAN</p>
LAN это сокращение от Local Area Network.</p>
Что именно локальная сеть очень зависит от конкретной топологии сети и может варьироваться. Тем не менее, LAN относится ко всем системам, подключенным к Ethernet повторителям (hubs) и коммутаторам (switches), или в некоторых случаях к Token ring или другим. К LAN не относятся другие LAN, подключенные с помощью мостов или маршрутизаторов. То есть к LAN относятся только те части, до которых сетевой трафик доходит без использования мостов и маршрутизаторов.</p>
Можно думать об LAN, как об улицах, с мостами и маршрутизаторами, которые объединяют города скоростными трассами.</p>
3.20. WAN</p>
WAN это сокращение от Wide Area Network.</p>
WAN означает соединение нескольких LAN совместно, с помощью мостов и маршрутизаторов в одну большую сеть.</p>
Используя пример с городом, WAN состоит из множества городов (LAN) соединенных скоростными трассами. Интернет сам по себе классифицируются как WAN.</p>
3.21. IETF</p>
IETF (Internet Engineering Task Force) это открытое сообщество, которое&nbsp; продвигает функционирование, стабильность и развитие Интернет. IETF работает подобно Open Source разработке программ. IETF доступен на сайте http://www.ietf.org/.</p>
3.22. RFC</p>
RFC это сокращение от Request for Comments.</p>
RFC это набор официальных документов от IETF, которые описывают и детализируют протоколы Интернет. Документы RFC идентифицируются их номера, подобными RFC 822.</p>
Есть очень много зеркал, которые содержат документы RFC в Интернет. Лучший из них, который имеет поисковую системе находится на сайте http://www.rfc-editor.org/</p>
RFC редактор (web сайт указанный выше) описывает документы RFC как:</p>
Серия документов RFC &#8211; это набор технических и организационных заметок об Интернет (изначально ARPANET), начиная с 1969 года. Заметки в серии RFC документов дискутируют многие аспекты компьютерных сетей, включая протоколы, процедуры, программы и концепции, как заметки, мнения, а иногда и юмор.</p>
3.23. Кодовые потоки (thread)</p>
Кодовые потоки &#8211; это метод выполнения программы. Большинство программ имеют только один поток. Тем не менее, дополнительные потоки могут быть созданы для выполнения параллельных вычислений.</p>
На системах с несколькими CPU, потоки могут выполняться одновременно на разных CPU, для более быстрого выполнения.</p>
На системах с одним CPU, множество потоков могут выполняться с помощью вытесняющей многозадачности. При вытесняющей многозадачности, каждому потоку выделяется небольшой квант времени. Так что, кажется, что каждый поток выполняется на отдельном процессоре.</p>
3.24. Fork</p>
Unix до сих пор не имеет поддержки потоков. Вместо этого, Unix использует ветвление (forking). С потоками, каждая отдельная строка выполнения исполняется, но она существует в том же самом процессе, как и другие потоки и в том же адресном пространстве. При разветвлении каждый процесс должен сам себя разделять. Создается новый процесс и все хендлы (handles) передаются ему.</p>
Разветвление не так эффективно как потоки, но также имеется и преимущества. Разветвление более стабильно. В большинстве случаев - разветвление легче программировать.</p>
Разветвление типично для Unix,&nbsp; так как ядро использует и поддерживает его, в то время как потоки это более новое.</p>
3.25. Winsock</p>
Winsock &#8211; это сокращение от Windows Sockets.</p>
Winsock &#8211; это определенное и документированное стандартное API, для программирования сетевых протоколов. В основном используется для программирования TCP/IP, но может быть использовано и для программирования Novell (IPX/SPX) и других сетевых протоколов. Winsock реализован как набор DLL и является частью Win32.</p>
3.26. Стек протоколов</p>
Термин стек протоколов относится к слою операционной системы, которая сеть и предоставляет API&nbsp; для разработчика по доступу к сети.</p>
В Windows стек протоколов реализован с помощью Winsock.</p>
&nbsp;</p>
3.27. Сетевой порядок байт</p>
Различные компьютерные системы хранят числовые данные в различном порядке. Некоторые компьютеры хранят числа, начиная с самого наименее значимого байта (LSB), тогда как другие с наиболее значимого байта (MSB). В случае сети, не всегда известно, какой компьютер используется на другой стороне. Для решения этой проблемы был принят стандартный порядок байт для записи и передачи по сети, названый сетевой порядок байт. Сетевой порядок байт это фиксированный порядок байт, который должен использоваться в приложении при передаче двоичных чисел.</p>
&nbsp;</p>
&nbsp;</p>
