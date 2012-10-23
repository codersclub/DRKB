<h1>IPv6 или 667 квадрильонов адресов на квадратный миллиметр земной поверхности</h1>
<div class="date">21.03.2002</div>

<div class="author">Автор: Татьяна Хапаева, tmhapa@yahoo.com</div>

Оригинал: http://www.softerra.ru/review/technologies/16839/<br>

<p>&nbsp;</p>
Каждый компьютер в Интернете имеет уникальный IP-адрес. Формат (размером 32 бита) и протокол для него, введённый в 1973 году, носит название IPv4. Он был создан для того, чтобы обеспечить связь между математиками из Пентагона и их коллегами из американских ВУЗов. Кто же тогда мог даже вообразить, что сеть, объединявшая не более сотни машин, будет развивать такими дикими темпами, и к началу нового тысячелетия число ее обитателей достигнет нескольких миллионов человек! Увы, колличество IP-адресов ограничено, и 32-х битная длина неизбежно должна исчерпаться уже в ближайшее время. </p>
Над этой проблемой впервые задумались в середине 80-х, когда скачкообразно выросло число &#171;модемщиков&#187;. Ранее такое просто было невозможно из-за отвратительного качества и дороговизны связи. На заре своего существования Интернет был эдаким форумом для университетов, удобным для научной элиты, но совершенно непонятным для всех прочих. </p>
Сегодня Интернет развивается не только количественно, но и качественно. Доступ в сеть осуществляется уже не только по проводам, но и в условиях беспроводной связи. WAP &#8212; протокол для хэнди или ноутбук с радиомодемом стали частью обыденности. Естественно, что на этом прогресс не остановится Уже выпущена в производство интернет-кофеварка, которую можно подключить к компьютеру и получать кофе по клику, а также обмениваться рецептами по сети. Miele@home &#8212; сетевой дом выставлялся на экспозиции Domotechnica ещё в 2001 в Кёльне. Ожидается, что к концу 2002 года будет утверждён стандарт для европейской электронной индустрии, и такие комплексы пойдут в серийное производство. Что же будет, если каждая стиральная машина и холодильник будут подключены к сети? </p>
Как промежуточный вариант был разработан протокол IPv5. Он был в основном ориентирован на передачу аудио и видео данных, и как стандарт утверждён не был. </p>
В начале 90-х были начаты активные разработки нового протокола. Было предложено много конкурирующих вариантов, все они имели свои слабые и сильные стороны и имели право на существование. Их резюмировали в 1993 под заглавием &#8220;IP Next Generation&#8221; (IPNG). В 1995-1996 годах были представлены первые проекты, которые в 1996 были приравнены к Draft- (черновому) стандарту. </p>
Интернет сообществом велись оживлённые дискуссии по поводу проекта нового протокола. Ключевым вопросом было: на сколько же бит увеличить длину адреса? На определённом этапе за основу брался даже вариант произвольного размера. Так могла бы быть навсегда решена проблема расширения адресного пространства. Но, в конце концов, остановились на 128 битах. Тем самым размер адресного пространства расширился до 3,4*1038 адресов. Для наглядности: это 6,5*1028 на каждого человека, живущего на планете, или 667 квадрильонов адресов на квадратный миллиметр земной поверхности, т.е. 655,570,793,348,866,943,898,599 &#8212; на каждый квадратный метр. </p>
Новые адреса должны будут представляться: </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>в нормализованном виде: 128-битовый вид приводится к 16-битовому, все целые числа приводятся к 16-ричному виду и разделяются двоеточиями, начальные нули пропускаются, например 3ffe:675:53b:41:134:c35:ff:4; </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>в сжатом виде, когда двойное двоеточие заменяет группу из нулей. Например, 3ffe:353::1 вместо 3ffe:353:0:0:0:0:0:1; </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>в IPv4-сопоставимом &#8212; для представления старых адресов, т.е. например, 0:0:0:0:0:0:192.168.5.7 или ::192.168.5.7 вместо 192.168.5.7; </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>с фиксированным адрес-префиксом, например, адрес 3ffe:400:280::1/48 сообщает, что первые 48 бит в адресах подсети, к которой он принадлежит, зафиксированы. Пользователям в этой подсети выдаются адреса с изменением только оставшихся 80 бит. </td></tr></table></div>Естественно, новые адреса, как и старые, нельзя ни продать, ни сдать в аренду. Они будут абсолютно бесплатны. </p>
DoS (Denial of Service) атаки, в просторечии, &#171;забрасывание пингами&#187; или IP-пакетами, избежать которых не удалось даже Yahoo! и eBay, равно как и всякие трюки с адресами, по уверениям создателей IPv6 будут сильно затруднены или совсем канут в лету. </p>
До сегодняшнего дня разработкой и внедрением IPv6 занимались преимущественно европейские и азиатские институты и фирмы (Nokia, NTT, BT и Stealth Communications). Это объясняется тем, что около 75% адресного пространства IPv4 приходится на США. </p>
Насколько готов к введению нового стандарта современный мир? </p>
Windows 9x содержит TCP-стек для IPv6. Поддерживают его и FreeBSD / OpenBSD / NetBSD, Linux, HP-UX, SunOS, Solaris. Из Линуксов можно назвать Debian 2.2, SuSE 7.1, RedHat 7.1 и PLD. Само же ядро стабильно поддерживает новый стандарт, начиная с версии 2.2.14. Браузеры, совместимые с IPv6: MS Internet Explorer, начиная с 6 версии, Mozilla (с патчем), lynx и w3m (также с патчем). </p>
Переход к IPNG планируется базировать на сервисе Tunnel Broker. Он даёт провайдеру возможность создавать менее объёмные адресные пространства IPv6 пользователю с адресом IPv4 через туннель. Более подробная спецификация доступна по ссылке этой. </p>
Что касается IRC-клиентов (Internet Relay Chat), то, увы, покамест никто из них под Windows IPv6 не поддерживает. Разумеется, можно установить на компьютер так называемый &#8220;Bouncer&#8221; и подключиться к нему локально, а далее устанавливается туннель с сервером IPv6. К примеру, для Windows предназначен Bouncer под названием AsyBo. Для Linux/Unix ситуация существенно лучше: BitchX, X-Chat (начиная с версии 1.7.0) и kvlIRC поддерживают IPv6. Epic4 и ircll должны быть пропатчены. </p>
Отдельно стоит остановиться на IPSec. Это самостоятельный протокол, который делает возможным кодирование в IP-сетях. Теперь IPSec является интегральной составной частью IPv6, в отличие от IPv4. </p>
Развивается и служба, подобная базе данных &#8220;Ripe&#8221;. Для тех, кто не в курсе &#8212; это поиск доменных имён и персон. Подробнее на читайте на whois.6bone.net. </p>
Свежие новости по теме статьи доступны на сайте http://www.hs247.com/, а початиться можно в IRCnet (#ipv6). Интересен также русскоязычный сайт по Ipv6. Он так и называется http://www.ipv6.ru/. </p>
21 февраля сего года Европейская комиссия выступила с сообщением в прессе [1] под названием &#171;Интернет следующего поколения: первоочередные мероприятия при переходе к новому межсетевому протоколу IPv6&#187;. Выдержка из него: &#171;IPv6 даёт технические предпосылки для слияния Интернета и мобильных коммуникации, в этой области Европа занимает ключевые позиции&#187;. В результате проблема переходит в экономическую плоскость, так как поставщики мобильной связи всерьёз опасаются, что их службы могут стать ненужными в свете развития IP-телефонии. Ведь тогда практически любой желающий может получить адрес и установить с кем-либо непосредственный контакт. Таким образом, пришло время кардинальных политических решений. Какими они будут, покажет ближайшее время&#8230; </p>

