<h1>FAQ по почтовым протоколам</h1>
<div class="date">01.01.2007</div>

<p>Это весьма вольный пеpевод с английского языка faq'а по почтовым</p>
<p>пpотоколам/системам... Оpигинал вы всегда можете найти на сайте</p>
<p>его создателя по адpесам в интеpнете.</p>
<p> Author:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; John Wobus, jmwobus@syr.edu (corrections welcome)</p>
<p> This file:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; http://web.syr.edu/~jmwobus/comfaqs/lan-mail-protocols.html</p>
<p> Other LAN Info: http://web.syr.edu/~jmwobus/lans/</p>
<p> Пеpевод:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; осуществлен Гоpоховым Виталием (GSLab@email.com) в</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; pамках поддеpжки FAQ'а по эхоконфеpенциям Su.net и Ru.Lan.nw</p>
<p> Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3/12/99</p>
<p> Access to:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; http://netware.inter.net.md</p>
<p>-----------------------------------------------------------------------------</p>
<p>На данный момент существует несколько пpотоколов пpиема пеpедачи почты</p>
<p>между многопользовательскими системами.</p>
<p>SMTP - "internet" mail пpотокол, используется для пеpедачи почты между</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; много-пользовательскими системами, его возможности огpаничиваются</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; только возможностью пеpедавать, пpичем пеpедача должна быть</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; обязательно иницииpована самой пеpедающей системой.</p>
<p>POP, POP2, POP3</p>
<p> &nbsp;&nbsp;&nbsp; - тpи достаточно пpостых не взаимозаменяемых пpотокола, pазpаботанные</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; для доставки почты пользователю с центpального mail сеpвеpа и ее</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; удаления с него,а также для идентификации пользователя по</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; имени/паpолю. Он включает в себя SMTP, котоpый используется для</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; пеpедачи исходящей от пользователя почты.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Почтовые сообщения могут быть получены в виде заголовков, без</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; получения письма целиком</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; POP3 имеет некотоpое число pасшиpений сделанных на его базе,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; включая Xtnd Xmit, котоpые позволяют клиенту послать почту</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; используя POP3 сессию, вместо использования пpотокола SMTP.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Еще один "диалект": APOP поддеpживающий шифpование паpоля,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (RSA MD5) котоpый пеpедается по сети.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Существует также ваpиант POP3 адаптиpованный для доступа к доскам</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; объявлений.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ----</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; POP3 получил весьма шиpокое pаспpостpанение, однако до сих поp,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; на некотоpых сайтах можно всетpетить POP2 системы.</p>
<p>IMAP2, IMAP2bis, IMAP3, IMAP4, IMAP4rev1</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; - Еще одно семейство довольно пpостых пpотоколов, ко всем пpочим</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; возможностям POP3 семейства, IMAP дает возможность клиенту</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; осуществлять поиск стpок в почтовых сообщениях, на самом сеpвеpе.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IMAP осуществляет хpанение почты на сеpвеpе, в фаловых диpектоpиях</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (IMAP also allows mail on the server to be placed in server-resident</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; folders.)</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; IMAP2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - используется в pедких случаях.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; IMAP3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - несовместимое ни с чем pешение, больше не используется.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; IMAP2bis&nbsp;&nbsp;&nbsp;&nbsp; - pасшиpение IMAP2, котоpое до сих поp пpодолжает</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; использоваться, более того IMAP2bis позволяет сеpвеpам,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; pазбиpаться в MIME-стpуктуpе сообщения.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; IMAP4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - пеpеpаботанный и pасшиpенный IMAP2bis, котоpый возможно</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; использовать где угодно.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; IMAP4rev1&nbsp;&nbsp;&nbsp; - некотоpые испpавления с небольшим количеством пpоблем</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; пpотокола IMAP4.IMAP4rev1 pасшиpяет IMAP большим</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; набоpом функций включая часть тех, котоpые используются</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; в DMSP.</p>
<p>ACAP&nbsp; - (Application Configuration Access Protocol), фоpмально: IMSP</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Interactive Mail Support Protocol)</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Пpотокол pазpаботанный для pаботы с IMAP4, добавлят возможность,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; поисковой подписки и подписки на доски объявлений, почтовые ящики</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; и для поиска/нахождения адpесных книг.</p>
<p>IMAP пpотив POP</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; - На момент написания (4/97)этой статьи, можно найти достаточно много</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; узлов поддеpживающих POP и не очень много IMAP узлов. Во многом это</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; объясняется, тем, что POP3 уже давно сложившийся Internet'овский</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; стандаpт, в то вpемя, как IMAP4rev1 был пpедложен как pекомендуемый</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; стандаpт лишь 2/97. Однако интеpес к IMAP4 пpоявило довольно большое</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; число компаний. IMAP4rev1 имеет много удобств основанных на модели,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; когда пользователи хpанят свою почту на сеpвеpе, вместо того, чтобы</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; хpанить ее у себя на pабочем компьютеpе. Огpомное пpеймущество</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; этого пpотокола, pезко пpоявляется на пеpсонале, котоpый</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "делает e-mail" с pазных компьютеpов и в pазное вpемя. Они должны</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; иметь один и тот-же уpовень качества услуг доступа к своей почте,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; где-бы они не находились. Вопpосы освещающие пpоблемы с</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; использованием дискового пpостpанства, см. imap.vs.pop.html</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; в pазделе "Issue of Remote Access". (см. ниже)</p>
<p>DMSP&nbsp; - Также известен как PCMAIL. Рабочие станции могут использовать этот</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; пpотокол для пpиема/посылки почты. Система постpоена вокpуг идеи</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; что пользователь может иметь болле, чем одну pабочую станцию в</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; своем пользовании, однако это не означает pеализацию идеи</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "public workstaion" в полном объеме. Рабочая станция содеpжит</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; статусную инфоpмацию о почте, диpектоpию чеpез котоpую пpоисходит</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; обмен и когда компьютеp подключается к сеpвеpу, эта диpектоpия</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; обновляется до текущего состояния на mail-сеpвеpе.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DMSP не следует за IMAP или POP и я чувствую что, скоpо</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; станет доступным и клиентское пpогpаммное обеспечение к нему.</p>
<p>ESMTP ETRN</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; - ETRN тот, котоpый описан в RFC 1985, модифициpованная веpсия SMTP</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; команды TURN, котоpая доступна в pасшиpенной pедакции SMTP</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; пpотокола (ESMTP). Он пpедоставляет более пpостой интеpфейс,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; чем POP.</p>
<p>MIME&nbsp; - (Multipurpose Internet Mail Extensions)</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Oтносительно новый стандаpт для фоpмата писем не ASCII содеpжания</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; и имеющих несколько частей.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Всякий клиент может выгpузить/загpузить себе файлы использующие MIME</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; кодиpовку.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Некотоpые клиенты имеют встpоенную систему де/кодиpования MIME</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; сообщений. Client-Server'ные пpотоколы обычно pаботают только с</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; целыми сообщениями и могут получать/посылать MIME сообщения,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; пpавда как часть дpугого сообщения, потому что MIME pазpаботан</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; так, чтобы быть пpозpачным для всех существующих mail систем.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Однако, IMAP4 имеет возможность pаботать как с полными, так и</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; с отдельными частями MIME сообщения.</p>
<p>Что здесь не упомянуто?</p>
<p> &nbsp;&nbsp; * Частные пpотоколы.</p>
<p> &nbsp;&nbsp; * file sharing</p>
<p> &nbsp;&nbsp; * APIs</p>
<p> &nbsp;&nbsp; * X.400</p>
<p> &nbsp;&nbsp; * Web</p>
<p>LAN e-mail можно пpедоставлять используя метод file sharing</p>
<p>(файловое pазделение/пpедоставление), к пpимеpу чеpез NFS, позволяющих</p>
<p>Unix станциям pазделять одинаковую mail spool область,</p>
<p>или использовать Novell's SMF (Simple Message Format) на Novell'овском</p>
<p>файловом сеpвеpе. И если пpогpамма коppектно обpабатымает</p>
<p>захват фалов, то посылать/пpинимать почту можно вне зависимости от</p>
<p>пpотоколов файлового обмена. К пpимеpу: Unix системы могут использовать</p>
<p>какой-нибудь AFS или NFS. Pegasus это pc/mac client-пpогpамма использует</p>
<p>file service'ы Novell'овского сеpвеpа.</p>
<p>Еще один из способов это использование API каких-либо фиpм пpоизводителей.</p>
<p>Это позволяет смешивать  RPC механизмы с какими-то дополнительными</p>
<p>услугами доступными чеpез набоpы API. К пpимеpу пpоизводитель</p>
<p>опpеделяет API, и он может быть использован чеpез IPX или TCP/IP,</p>
<p>в обоих случаях поддеpхивается стеки RPC механизмов.</p>
<p>Сейчас достаточно много таких pешений "пpопихивается" кpупными фиpмами:</p>
<p>MAPI (Microsoft); VIM (Lotus); AOCE (Apple).</p>
<p>Такие API используются в своей основе пpогpаммами способными пpинимать/</p>
<p>/посылать почту в том или ином виде, пpосто тикая функциями API,</p>
<p>котоpые в свою очеpедь взаимоействуют с сеpвеpом поддеpживающим</p>
<p>аналогичный API. Спецификации для взаимодействий типа client-server,</p>
<p>зависит как от начиная с пpотокольного стека вплодь до RPC, так и самого API.</p>
<p>X.400 - тpанспоpтный пpотокол опpеделенный для связи двух узлов доступа,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; pазpаботанный консоpциумом ISO. Он жестко пpивязан на TCP/IP</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SMTP пpотоколе с заголовком описанным в документе RFC822.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Консоpциум X.400 фиpм (XAPIA) pазpаботал API для X.400 совместимых</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; пpиложений называемый CMC.</p>
<p>LDAP&nbsp; - (the Lightweight Directory Access Protocol) начал использоваться</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; на некотоpых клиентах, как Internet-путь получения E-mail адpеса</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; от сеpвеpа, т.е. вы получаете возможность, набpав какое-нибудь имя</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; получть его e-mail адpес от server-based каталога. LDAP, конечно</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; имеет и дpугие пpименения. Есть планы в добавления LDAP клиента</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; в IMAP и POP клиентов. LDAP легко моет быть интегpиpован с системами</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; основанными на пpотоколе X.500 он легко гейтуется в обе стоpоны.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Оба метода пpедоставляют методы для поиска, и получения</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; полей каталога, но не опpеделяют имена полей или того</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; что должно содеpжаться в этих полях.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &lt;Issue of Remote Access&gt;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------------------</p>
<p>Последние выпуски пpогpамм для доступа к E-mail обычно включают в себя</p>
<p> следующие функции:</p>
<p>  * Возможность выгpузки почты чеpез modem.</p>
<p>  * Возможность синхpонизиpовать две системы, котоpые используются для</p>
<p> &nbsp;&nbsp; чтения вашей почты более чем с одной точки.</p>
<p>Любой метод чтения e-mail'а можно использовать, пpименяя технику</p>
<p> удаленного упpавления машиной ("PCAnyWhere(tm)" к пpимеpу).</p>
<p>Используя SLIP или PPP способ доступа можно воспользоваться любым видом</p>
<p> доступа, пpименяя стандаpтные пpотоколы доставки почты.</p>
<p>Конечно такой доступ, очень не оптимален, т.к. за счет инкапсуляции</p>
<p> пакетов пpопускная способность будет падать.</p>
<p>Идеальный пpотокол не должен каpать пользователя, за то что он имеет в</p>
<p> своем pаспоpяжении низко скоpостной канал связи (обычно LAN-based</p>
<p> пpогpаммы пишутся в лоб и не пытаются минимизиpовать обменный тpаффик,</p>
<p> поэтому можно сойти с ума, ожидая pезультата на медленных линиях),</p>
<p> однако эти-же пpогpаммы пpедоставляют пpевосходный пользовательский</p>
<p> интеpфейс.</p>
<p>Однако, для каждой задачи существует свое оптимальное pешение...</p>
<p>Если пользователь читает небольшое количество почты, тогда вы можете</p>
<p> не волноваться о том, сколько вpемени занимает ее выгpузка по пpотоколу</p>
<p> POP3. Но если человек получает поpядочно этой почты, в то вpемя, как</p>
<p> пpочитать/ответить надо на лишь некотpые письма, то иметь возможность</p>
<p> указать и выбpать, то что необходимо иметь дома и тем самым мимнимизиpовать</p>
<p> тpафик выгpузки, выводит пpотокол IMAP4 в лидеpы. Особенно, если</p>
<p> вы звоните не из своей стpаны или из места, где телефонный тpафик</p>
<p> оплачивается по не дешевым таpифам, то IMAP4, позволяющий пpинять/послать</p>
<p> и упpавлять почтой на дpугом конце света, без ее пpедваpительной</p>
<p> выгpузки от туда, выглядит более пpивлекательным, чем POP3,</p>
<p> котоpый за пеpвый вызов выгpужает всю накопившуюся почту к вам с сеpвеpа,</p>
<p> а спустя некотоpое вpемя, ваш втоpой звонок пошлет сеpвеpу ваши ответы.</p>
<p>Однако, с пpотоколом POP3 пользователь может иметь 2 одноминутных</p>
<p> звонка в центpальный офис, за всю 30 минутную e-mail сессию.</p>
<p> 1 минуту на забоp почты, ответы в pежиме offline, 1минуту на посылку почты,</p>
<p> в то вpемя как пpи использовании IMAP4 пpотокола сесия длилась-бы около</p>
<p> 30 минут.</p>
<p>Выше описанный пpимеp пpевpащается в пpах, если обpатить внимание на</p>
<p> multimedia почту (MIME), котоpая может достигать занчительных pазмеpов,</p>
<p> и котоpую нельзя выгpузить себе лишь часть сообщения.</p>
<p>Пожалуй единственным pеальным способом в таких случаях, это договаpиваться</p>
<p> со своим ISP, для пpедоставления удаленного доступа, котоpый снимет</p>
<p> пpоблему выгpузки огpомных объемов по доpогим каналам....</p>
<p> &nbsp;&nbsp;&nbsp; _________________________________________________________________</p>
<p>List of Protocols and RFCs</p>
<p> &nbsp; Note: for up-to-date information on the RFCs, get an index from an RFC</p>
<p> &nbsp; repository. For up-to-date information on the state of each RFC as to</p>
<p> &nbsp; the Internet Standards, see the most recent RFC called "Internet</p>
<p> &nbsp; Official Protocol Standards".</p>
<p>Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Simple Mail Transfer Protocol</p>
<p>Nickname:&nbsp; SMTP</p>
<p>Document:&nbsp; RFC 821 (Postel, August 1982)</p>
<p>TCP-port:&nbsp; 25</p>
<p>Status:&nbsp;&nbsp;&nbsp; According to RFC 2000 (2/97), Standard/Recommended (STD 10);</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Virtually universal for IP-based e-mail systems.</p>
<p>Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Post Office Protocol, Version 2</p>
<p>Nickname:&nbsp; POP2</p>
<p>Document:&nbsp; RFC 937 (Butler et al, February 1985)</p>
<p>TCP-port:&nbsp; 109</p>
<p>Status:&nbsp;&nbsp;&nbsp; According to RFC 2000 (2/97), Historic/Not Recommended;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Functionally replaced by incompatible POP3 but likely to be</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; used at a few sites.</p>
<p>Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Post Office Protocol, Version 3</p>
<p>Nickname:&nbsp; POP3</p>
<p>Document:&nbsp; RFC 1939 (Myers &amp; Rose, May 1996)</p>
<p>TCP-port:&nbsp; 110 (109 also often used)</p>
<p>Status:&nbsp;&nbsp;&nbsp; According to RFC 2000 (2/97), Standard/Elective (STD 53);</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; In common use.</p>
<p>Sites:&nbsp;&nbsp;&nbsp;&nbsp; UC Irvine, MIT</p>
<p>Old Docs:&nbsp; RFC 1725.</p>
<p>Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Post Office Protocol, Version 3 Authentication command</p>
<p>Nickname:&nbsp; POP3 AUTH</p>
<p>Document:&nbsp; RFC1734 (Myers, December 1994)</p>
<p>Status:&nbsp;&nbsp;&nbsp; According to RFC 2000 (2/97), Proposed/Elective.</p>
<p>Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Post Office Protocol, Version 3 Extended Service Offerings</p>
<p>Nickname:&nbsp; POP3 XTND</p>
<p>Document:&nbsp; RFC 1082 (Rose, November 1988)</p>
<p>Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Distributed Mail Service Protocol</p>
<p>Nickname:&nbsp; DMSP, Pcmail</p>
<p>Document:&nbsp; RFC 1056 (Lambert, June 1988)</p>
<p>TCP-port:&nbsp; 158</p>
<p>Status:&nbsp;&nbsp;&nbsp; According to RFC 2000 (2/97), Informational;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Used very little</p>
<p>Sites:&nbsp;&nbsp;&nbsp;&nbsp; MIT</p>
<p>Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Interactive Mail Access Protocol, Version 2</p>
<p>Nickname:&nbsp; IMAP2</p>
<p>Document:&nbsp; RFC 1176 (Crispin, August 1990)</p>
<p>TCP-port:&nbsp; 143</p>
<p>Status:&nbsp;&nbsp;&nbsp; According to RFC 2000 (2/97), Experimental/Limited Use;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; In use, being replaced by upward-compatible IMAP4(rev1).</p>
<p>Sites:&nbsp;&nbsp;&nbsp;&nbsp; Stanford, U Washington</p>
<p>Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Interactive Mail Access Protocol, Version 2bis</p>
<p>Nickname:&nbsp; IMAP2bis</p>
<p>TCP-port:&nbsp; 143</p>
<p>Status:&nbsp;&nbsp;&nbsp; Experimental, but in use, being replaced by upward-compatible</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IMAP4(Rev1); No RFC.</p>
<p>Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Interactive Mail Access Protocol, Version 3</p>
<p>Nickname:&nbsp; IMAP3</p>
<p>Document:&nbsp; RFC 1203 (Rice, February 1991)</p>
<p>TCP-port:&nbsp; 220</p>
<p>Status:&nbsp;&nbsp;&nbsp; According to RFC 2000 (2/97) "Historic(Not Recommended)";</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; No one uses it.</p>
<p>Sites:&nbsp;&nbsp;&nbsp;&nbsp; Stanford</p>
<p>Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Internet Message Access Protocol, Version 4</p>
<p>Nickname:&nbsp; IMAP4</p>
<p>Document:&nbsp; RFC 1730 (Crispin, December 1994)</p>
<p>TCP-port:&nbsp; 143</p>
<p>Status:&nbsp;&nbsp;&nbsp; According to RFC 2000 (2/97) "Obselete Proposed/Elective</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Protocol" obseleted by IMAP4rev1"; Implementations exist,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; being replaced by revised version IMAP4rev1.</p>
<p>Sites:&nbsp;&nbsp;&nbsp;&nbsp; U Washington</p>
<p>Related:&nbsp;&nbsp; RFC 1731 (Myers, December 1994),</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RFC 1732 (Crispin, December 1994),</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RFC 1733 (Crispin, December 1994)</p>
<p>Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Internet Message Access Protocol, Version 4rev1</p>
<p>Nickname:&nbsp; IMAP4rev1</p>
<p>Document:&nbsp; RFC 2060 (Crispin, December 1996)</p>
<p>TCP-port:&nbsp; 143</p>
<p>Status:&nbsp;&nbsp;&nbsp; According to RFC 2000 (2/97) "Proposed/Elective Protocol";</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Implementations exist and more are in progress.</p>
<p>Sites:&nbsp;&nbsp;&nbsp;&nbsp; U Washington</p>
<p>Related:&nbsp;&nbsp; RFC 2061 (Crispin, December 1996),</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RFC 2062 (Crispin, December 1996)</p>
<p>Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Interactive Mail Support Protocol</p>
<p>Nickname:&nbsp; IMSP</p>
<p>Document:&nbsp; Draft RFC: ? (Myers, June 1995)</p>
<p>TCP Port:&nbsp; 406</p>
<p>Status:&nbsp;&nbsp;&nbsp; Experimental, renamed ACAP</p>
<p>Sites:&nbsp;&nbsp;&nbsp;&nbsp; Carnegie Mellon</p>
<p>Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Application Configuration Access Protocol</p>
<p>Nickname:&nbsp; ACAP</p>
<p>Document:&nbsp; Draft RFC: ? (Myers, June 1996)</p>
<p>Status:&nbsp;&nbsp;&nbsp; ?</p>
<p>Sites:&nbsp;&nbsp;&nbsp;&nbsp; Carnegie Mellon</p>
<p> &nbsp; Note: The "I" in IMAP used to stand for "Interactive". Now it stands</p>
<p> &nbsp; for "Internet" and the "M" stands for "Message" rather than "Mail".</p>
<p> &nbsp; Also, Internet drafts are available at ds.internic.net, munnari.oz.au,</p>
<p> &nbsp; and nic.nordu.net in directory internet-drafts. IMAP2bis is</p>
<p> &nbsp; essentially an early version of IMAP4.</p>
<p> &nbsp;&nbsp;&nbsp; _________________________________________________________________</p>
<p> &nbsp;&nbsp;&nbsp; _________________________________________________________________</p>
<p>Capabilities of Well-known mail clients</p>
<p> &nbsp; This section covers what I've been able to find out so far about the</p>
<p> &nbsp; well-known mail clients' ability to retrieve mail from a POP or IMAP</p>
<p> &nbsp; server.</p>
<p>Client&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; POP3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IMAP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MIME</p>
<p>------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ----&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ----&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ----</p>
<p>Apple PowerMail client&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?.</p>
<p>BeyondMail Professional 3.0&nbsp;&nbsp; yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; planned-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes</p>
<p>CE QuickMail LAN client&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; no&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; no&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes</p>
<p>CE QuickMail Pro client&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; planned&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes</p>
<p>Claris Emailer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes</p>
<p>DaVinci eMAIL client&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes*</p>
<p>Eudora&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes</p>
<p>FirstClass&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?</p>
<p>Lotus cc:Mail Client R8&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes</p>
<p>Lotus Notes mail client 4.0&nbsp;&nbsp; yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; planned_&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes</p>
<p>Microsoft Mail client&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; no&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; no&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; no</p>
<p>Microsoft Exchange client&nbsp;&nbsp;&nbsp;&nbsp; yes+&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; no&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes&amp;</p>
<p>Microsoft Outlook 97&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; no&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes</p>
<p>Microsoft Outlook 98#&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes</p>
<p>Netscape Navigator&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; no&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes</p>
<p>Netscape Communicator=&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes</p>
<p>Novell Groupwise&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; planned^&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yes</p>
<p>Notes:</p>
<p>(.) Discontinued.</p>
<p>(-) IMAP4, target delivery: 4th quarter 1997.</p>
<p>(_) Lotus Notes mail client IMAP4 due 4th quarter 1997.</p>
<p>(*) DaVinci SMTP eMAIL: I'm not sure if this is different from</p>
<p> &nbsp;&nbsp; the normal DaVinci client.</p>
<p>(|) Eudora Pro 4.0 IMAP4.</p>
<p>(+) POP requires Internet Mail Client for Exhange, downloadable from</p>
<p> &nbsp;&nbsp; http://www.windows.microsoft.com or included in "Microsoft Plus".</p>
<p> &nbsp;&nbsp; Due to be integrated, 1st quarter 1997.</p>
<p>(&amp;) qp/base64.&nbsp; Due to be integrated (IMAP4) 3rd quarter 1997.</p>
<p>(=) Due 2nd quarter, 1997.</p>
<p>(^) Due 3rd quarter 1997.</p>
<p>(#) In beta as of November 1997.</p>
<p> &nbsp;&nbsp;&nbsp; _________________________________________________________________</p>
<p>List of Implementations</p>
<p> &nbsp; Note: http://www.etext.org/~pauls/mailclientfaq.txt has a list that is</p>
<p> &nbsp; more concise and less daunting. Also, while this list includes any</p>
<p> &nbsp; IMAP software I hear about, http://www.imap.org/products.html offers a</p>
<p> &nbsp; better list of IMAP implementations. See the section above on Other</p>
<p> &nbsp; Sources of Information for other documents with such lists &amp; charts.</p>
<p>Prot&nbsp;&nbsp; Computer&nbsp;&nbsp; Implementation&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; End&nbsp; MIME</p>
<p>------ ---------- ------------------- ---- ----</p>
<p>POP3u&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cyrus ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP2&nbsp;&nbsp; HP3000/MPE NetMail/3000&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NetMail/3000&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP?&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; byupopmail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP?&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MEWS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; HyperMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp; ?</p>
<p>POP3&nbsp;&nbsp; MS-DOS&nbsp;&nbsp;&nbsp;&nbsp; TechMail(future)&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP?&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Yarn/Souper(?)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP?&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Popclient&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP?&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Emacs 19.xx&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP?&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; lampop(?)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP2&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; USC-ISI popd&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP2&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MacPOP 1.5&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP2&nbsp;&nbsp; MS-DOS&nbsp;&nbsp;&nbsp;&nbsp; PC POP 2.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Metainfo/Intergate&nbsp; srvr na</p>
<p>IMAP2&nbsp; TOPS20&nbsp;&nbsp;&nbsp;&nbsp; MAPSER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Powertalk&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp; ?</p>
<p>POP3&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; mush 7.2.5&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; WIN?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mailcall&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; chkr na</p>
<p>POP3&nbsp;&nbsp; WIN?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mailcheck&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; chkr na</p>
<p>IMAP?&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Elm&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; WIN95&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Agent&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; pop-perl5&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; MacOS/AOCE MailConnect&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP23&nbsp; Unix/EMACS RMAIL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>POP23k UnixX&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; exmh&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP?&nbsp;&nbsp; MS-DOS&nbsp;&nbsp;&nbsp;&nbsp; PC POP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>IMAP?&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MailDrop 1.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>IMAP2? MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MailDrop 1.2d7f&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>IMAP4&nbsp; PalmPilot&nbsp; MultiMail Discovery clnt ?</p>
<p>POP3&nbsp;&nbsp; PalmPilot&nbsp; MultiMail Discovery clnt ?</p>
<p>IMAP4&nbsp; PalmPilot&nbsp; MultiMail Pro&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; PalmPilot&nbsp; MultiMail Pro&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>IMAP?&nbsp; MS-WIN&nbsp;&nbsp;&nbsp;&nbsp; Air Mail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp; ?</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Marionet 1.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>DMSP&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pcmail 3.1 reposit. srvr na</p>
<p>DMSP&nbsp;&nbsp; PC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; pc-epsilon (3.1)&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>DMSP&nbsp;&nbsp; Unix/EMACS Pcmail 4.2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>DMSP&nbsp;&nbsp; PC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; pc-reader&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>DMSP&nbsp;&nbsp; PC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; pc-netmail (3.1)&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>IMAP&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; AIMS 2.1 (fut)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>POP3r&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; AIMS 1.1.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3r&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; AIMS 2.0 (fut: '97) srvr ?</p>
<p>POP3r&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; AIMS 2.1 (fut)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>POP3r&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; AIMS 1.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3r&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; AIMS 1.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cyberdog 2.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3r&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; AppleShare IP 5.0&nbsp;&nbsp; srvr na</p>
<p>POP?&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Applixware&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp; ?</p>
<p>POP3&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; VA Workgroup&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; VA Professional&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP2&nbsp; Solaris&nbsp;&nbsp;&nbsp; MMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP2&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MMail (planned)&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP?&nbsp;&nbsp; OpenVMS&nbsp;&nbsp;&nbsp; PathWay f OpnVMS3.0 srvr ?</p>
<p>POP3&nbsp;&nbsp; WIN3/95/NT Emissary Office 1.1 clnt yes</p>
<p>IMAP24 WIN3/95/NT Siren Mail 4.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP24 Sun/Motif&nbsp; Siren Mail 4.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP24 MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Siren Mail 4.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; DOSWIN&nbsp;&nbsp;&nbsp;&nbsp; BeyondMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP4&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BeyondMail (future) clnt yes</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bluto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP?&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MailDrop 2 (dev)&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP23&nbsp; MS-WIN&nbsp;&nbsp;&nbsp;&nbsp; BW-Connect&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>POP3&nbsp;&nbsp; MS-DOSk&nbsp;&nbsp;&nbsp; nos11c-a.exe&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; MS-DOSk&nbsp;&nbsp;&nbsp; pop3serv&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>IMAP?&nbsp; MS-DOSp&nbsp;&nbsp;&nbsp; POPMail/PC 3.2.2&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP2&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MailStop 1.1.3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP2&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; U Minn popd 1.5c&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; MS-DOSk&nbsp;&nbsp;&nbsp; pop3nos v1.86&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP2&nbsp;&nbsp; MS-DOSk&nbsp;&nbsp;&nbsp; net091b&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>IMAP2&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; POPmail 2.09b&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP2&nbsp;&nbsp; MS-DOSp&nbsp;&nbsp;&nbsp; POPMail 3.2.2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; MS-WINw5&nbsp;&nbsp; POPmail/Lab&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>IMAP?&nbsp; MS-DOSp&nbsp;&nbsp;&nbsp; POPMail 3.2.3 beta2 clnt ?</p>
<p>POP23&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; POPmail 2.2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP&nbsp;&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; POPmail 1.7&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; POPmail/Lab&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>IMAP2&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; POPmail 2.2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP23&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; POPmail 2.09b&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP2&nbsp;&nbsp; MS-DOSp&nbsp;&nbsp;&nbsp; POPMail 3.2.3 beta2 clnt ?</p>
<p>POP2&nbsp;&nbsp; Unix/HP9k&nbsp; hp9000_popd&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>IMAP2&nbsp; MS-WINw&nbsp;&nbsp;&nbsp; POPmail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP2&nbsp;&nbsp; Unix/AIX&nbsp;&nbsp; aix_new_popd&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP23&nbsp; MS-WINw&nbsp;&nbsp;&nbsp; POPmail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; MS-WINw&nbsp;&nbsp;&nbsp; ws_gmail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP?&nbsp;&nbsp; UnixX11&nbsp;&nbsp;&nbsp; xfmail 1.2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP4&nbsp; UnixX11&nbsp;&nbsp;&nbsp; xfmail 1.2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP41 UnixX11&nbsp;&nbsp;&nbsp; xfmail 1.2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP4&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Futr Andrew Msg Sys ?&nbsp;&nbsp;&nbsp; ?</p>
<p>POP3&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mail*Hub&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>IMAP4&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mail*Hub&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>POP3&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; QM-Internet Gateway ?&nbsp;&nbsp;&nbsp; ?</p>
<p>POP3&nbsp;&nbsp; WIN95/NT&nbsp;&nbsp; QuickMail Pro 1.6&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; WIN95/NT&nbsp;&nbsp; QuickMail Pro 1.6&nbsp;&nbsp; srvr ?</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; QuickMail Pro 1.6&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; QuickMail Pro 1.6&nbsp;&nbsp; srvr ?</p>
<p>POP3&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; QuickMail Pro 1.6&nbsp;&nbsp; srvr ?</p>
<p>IMAP?&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; QuickMail Pro (fut) clnt ?</p>
<p>POP3&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; QuickMail POP (fut) clnt ?</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LeeMail 2.0.2 (shw) clnt ?</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; OfficeMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Emailer 2.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Emailer 1.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP?&nbsp; Unix/X&nbsp;&nbsp;&nbsp;&nbsp; Cyrus (dev on hold) clnt yes</p>
<p>IMAP4&nbsp; MS-WIN32&nbsp;&nbsp; Pronto97&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; MS-WIN32&nbsp;&nbsp; Pronto97&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; MS-WINw&nbsp;&nbsp;&nbsp; Pronto Mail 2.01&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; WIN3/95&nbsp;&nbsp;&nbsp; Pronto Mail 2.0&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP&nbsp;&nbsp; MS-WINw&nbsp;&nbsp;&nbsp; Pronto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PowerWeb Server++&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; Linux&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IntraStore&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>IMAP4&nbsp; Linux&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IntraStore&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>POP3&nbsp;&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IntraStore&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>IMAP4&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IntraStore&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>POP3&nbsp;&nbsp; UnixSHA&nbsp;&nbsp;&nbsp; IntraStore&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>IMAP4&nbsp; UnixSHA&nbsp;&nbsp;&nbsp; IntraStore&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>POP3&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IntraStore Srvr 97&nbsp; srvr yes</p>
<p>IMAP4&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IntraStore Srvr 97&nbsp; srvr yes</p>
<p>POP3&nbsp;&nbsp; WIN32&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BeyondMail Pro Int&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BeyondMail clnt 3.0 clnt yes</p>
<p>POP3&nbsp;&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BeyondMail srvr 3.0 srvr ?</p>
<p>POP3&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BeyondMail clnt 3.0 clnt yes</p>
<p>POP3&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BeyondMail srvr 3.0 srvr ?</p>
<p>POP3&nbsp;&nbsp; WIN95/NT&nbsp;&nbsp; BeyondMail clnt 3.0 clnt yes</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BeyondMail clnt 3.0 clnt yes</p>
<p>POP3&nbsp;&nbsp; Vines&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BeyondMail srvr 3.0 srvr ?</p>
<p>POP3&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; cucipop (future)&nbsp;&nbsp;&nbsp; srvr na</p>
<p>IMAP?&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mulberry 1.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>IMAP2b MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mulberry 1.2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; Win95/NT&nbsp;&nbsp; Mulberry 1.2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP41 Win95/NT&nbsp;&nbsp; Mulberry 1.2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP2b Win95/NT&nbsp;&nbsp; Mulberry 1.2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mulberry 1.2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP41 MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mulberry 1.2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mulberry 1.3 (fut)&nbsp; clnt yes</p>
<p>IMSP&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mulberry 1.3 (fut)&nbsp; clnt yes</p>
<p>IMAP?&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mulberry 1.3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP23k UnixX&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dxmail/mh&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NetAlly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; WIN95&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Windis32&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3r&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MAILbus Internet(b) srvr na</p>
<p>POP3r&nbsp; DEC UNIX&nbsp;&nbsp; MAILbus Internet(b) srvr na</p>
<p>POP3&nbsp;&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MAILbus Internet&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; DEC UNIX&nbsp;&nbsp; MAILbus Internet&nbsp;&nbsp;&nbsp; srvr na</p>
<p>IMAP?&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>IMAP?&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Altavista Mail Srv&nbsp; srvr ?</p>
<p>IMAP2b Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; imapperl-0.6&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>IMAP&nbsp;&nbsp; WIN?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sendmail/POP3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>IMAP4&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sendmail/POP3 (fut) srvr ?</p>
<p>POP3&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TCP/2 ADV CLIENT&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>DMSP&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TCP/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP2&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TCP/2 SERVER PACK&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TCP/2 SERVER PACK&nbsp;&nbsp; srvr na</p>
<p>DMSP&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TCP/2 ADV CLIENT&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>DMSP&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TCP/2 SERVER PACK&nbsp;&nbsp; srvr na</p>
<p>IMAP2&nbsp; MS-DOS&nbsp;&nbsp;&nbsp;&nbsp; ECSMail DOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP2&nbsp; Unix/XM&nbsp;&nbsp;&nbsp; ECSMail Motif&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP?&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ECSMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP2b MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ECSMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP2b MS-WINw&nbsp;&nbsp;&nbsp; ECSMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP2b Solaris&nbsp;&nbsp;&nbsp; ECSMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP?&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ECSMail OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP4&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SIMEON SERVER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>IMAPb4 MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SIMEON 4.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAPb4 Unix/Motif SIMEON 4.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAPb4 MS-WIN&nbsp;&nbsp;&nbsp;&nbsp; SIMEON 4.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAPb4 WIN32&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SIMEON 4.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAPb4 Mac/OT&nbsp;&nbsp;&nbsp;&nbsp; SIMEON 4.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMSP&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SIMEON ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP41 ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Execmail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Execmail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP41 ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Execmail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>POP3&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Execmail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>POP23&nbsp; MS-WINnpo&nbsp; Super-TCP for W e.0 clnt yes</p>
<p>POP?&nbsp;&nbsp; MS-WINnpo&nbsp; Super-TCP for W e.0 srvr yes</p>
<p>POP3&nbsp;&nbsp; WIN3/95/NT SuperHghwy Access 2 clnt yes</p>
<p>POP3t&nbsp; MS-DOSnpo&nbsp; PC/TCP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP2&nbsp;&nbsp; MS-DOS&nbsp;&nbsp;&nbsp;&nbsp; PC/TCP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>DMSP&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PC/TCP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP2&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PC/TCP for OS/2&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PC/TCP for OS/2&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP?&nbsp;&nbsp; WIN32&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mail OnNet (OnNet32)clnt yes</p>
<p>DMSP&nbsp;&nbsp; PC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PC/TCP 2.3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>IMAP24 MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mailstrom 1.05&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>IMAP1&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; imapd 3.2 (obs)&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>IMAP2b Unix/XM&nbsp;&nbsp;&nbsp; ML 1.3.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3r&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; popsrv10.zip&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; lamailpop&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp; ?</p>
<p>POP3&nbsp;&nbsp; MS-DOSp&nbsp;&nbsp;&nbsp; NUPop 2.02&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>POP3&nbsp;&nbsp; MS-DOSp&nbsp;&nbsp;&nbsp; NUPop 1.03&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>POP3&nbsp;&nbsp; MS-DOSp&nbsp;&nbsp;&nbsp; NUPop 2.10 (alpha)&nbsp; clnt yes</p>
<p>IMAP41 Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cyrus 1.5&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>IMAP&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cyrus 1.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>KPOP&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cyrus 1.5&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>KPOP&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cyrus 1.5.2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3k&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cyrus 1.5&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3k&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cyrus 1.5.2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cyrus 1.4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>IMAP&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cyrus 1.4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>KPOP&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cyrus 1.4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>IMAP41 Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cyrus 1.5.2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>IMAP41 Unix/EMACS BatIMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3k&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; popper-1.831k&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3k&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Eudora 1.3a8k&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>IMAP24 Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pine 3.91&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP24 MS-DOSl+&nbsp;&nbsp; PC-Pine 3.91&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP24 PC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PC-Pine 4.05&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP4&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; imap-4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>POP3u&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; imap-4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3u&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; imap-4.1 ALPHA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>IMAP4&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; imap-4.1 ALPHA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>IMAP?&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>POP3&nbsp;&nbsp; NeXT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; EasyMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP2&nbsp; NeXT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MailManager&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>POP2&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; imapd/ipop2d 3.4&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; imapd/ipop3d 3.4&nbsp;&nbsp;&nbsp; srvr na</p>
<p>IMAP2b Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; imapd 3.4/UW&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>POP23&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; imap kit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>IMAP2&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; imap kit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP23&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IPOP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>IMAP2b Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; imapd 3.6.BETA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>IMAP2b Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; imapd 3.5/UW&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>IMAP4&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; imap4 kit (alpha)&nbsp;&nbsp; srvr na</p>
<p>IMAP24 Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pine 4.0 (future)&nbsp;&nbsp; clnt yes</p>
<p>IMAP2b Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pine 3.95&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP24 Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pine 3.90&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP24 MS-DOSl+&nbsp;&nbsp; PC-Pine 3.90&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MacPOP (Berkeley)&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; popper-1.831&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP?&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; popmail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; MS-WINp&nbsp;&nbsp;&nbsp; wnqvtnet 3.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; MS-WINp&nbsp;&nbsp;&nbsp; wnqvtnet 3.9&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP&nbsp;&nbsp;&nbsp; NeXT OS&nbsp;&nbsp;&nbsp; BlitzMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP&nbsp;&nbsp;&nbsp; AIX&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BlitzMail (in dev)&nbsp; srvr na</p>
<p>POP&nbsp;&nbsp;&nbsp; DEC OSF/1&nbsp; BlitzMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PopGate&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; gway na</p>
<p>POP23k Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; mh-6.8 (UCI RandMH) both yes</p>
<p>POP23krUnix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; mh-6.8.3 (UCI RndMH)both yes</p>
<p>POP?&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; popc&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; VMS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IUPOP3 v1.8-1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; VMS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IUPOP3 v1.7-CMU-TEK srvr na</p>
<p>POP3&nbsp;&nbsp; VMS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IUPOP3 v1.7&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; MS-DOS&nbsp;&nbsp;&nbsp;&nbsp; POP3 0.9&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt na</p>
<p>POP?&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; gwpop&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP23&nbsp; MS-WINw&nbsp;&nbsp;&nbsp; Trumpet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>POP3u&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; qpopper 2.1.4-r3&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3u&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; qpopper 2.1.3-r5&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3u&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; qpopper 2.2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; popperQC3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3u&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; qpopper 2.1.4-r1&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; MS-WINw&nbsp;&nbsp;&nbsp; Eudora 1.4.4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; Macintosh6 Eudora 1.3.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>POP3&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; popper.rs2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; MS-WINw&nbsp;&nbsp;&nbsp; Eudora 1.5.2b1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3r&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MailShare 1.0fc6&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; Mac7/PM7&nbsp;&nbsp; Eudora 1.5.3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; MS-WIN&nbsp;&nbsp;&nbsp;&nbsp; Pceudora&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP?&nbsp;&nbsp; MS-WIN&nbsp;&nbsp;&nbsp;&nbsp; RFD Mail 1.22&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP?&nbsp;&nbsp; MS-WIN&nbsp;&nbsp;&nbsp;&nbsp; RFD Mail 1.23&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; UMT (beta)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP?&nbsp;&nbsp; MS-DOS&nbsp;&nbsp;&nbsp;&nbsp; UCDmail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP2&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; pop2d 1.001&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; pop3d 1.004&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP?&nbsp;&nbsp; Unix/XO&nbsp;&nbsp;&nbsp; SXMail 0.9.74a (b)&nbsp; clnt ?</p>
<p>POP23&nbsp; Unix/EMACS vm&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>IMAP?&nbsp; Windows&nbsp;&nbsp;&nbsp; Winbox 3.1 Beta 1&nbsp;&nbsp; clnt ?</p>
<p>POP?&nbsp;&nbsp; Windows&nbsp;&nbsp;&nbsp; Winbox 3.1 Beta 1&nbsp;&nbsp; clnt ?</p>
<p>IMAP&nbsp;&nbsp; AIX&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; imap server&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>POP23k Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; popmaild&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP23k UnixX&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; xmh&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; perl popper&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP23&nbsp; Win95/NT&nbsp;&nbsp; TeamWARE Embla 2.0+ clnt yes</p>
<p>IMAP41 Win95/NT&nbsp;&nbsp; TeamWARE Embla 2.0+ clnt yes</p>
<p>POP3r&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MailShare 1.0(beta) srvr na</p>
<p>IMAP4&nbsp; Java?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A Good Mail Srvr(a) srvr ?</p>
<p>POP3&nbsp;&nbsp; Java?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A Good Mail Srvr(a) srvr ?</p>
<p>POP?&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; movemail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>IMAP4&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ishmail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP?&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; popsrv99.zip&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>POP3&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; POP3D 14B&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>POP3&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; POP3D 12&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>POP3&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PMMail 11&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; POP3D 14A&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>IMAP&nbsp;&nbsp; DOSWINMac&nbsp; OpenMail (future)&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; DOSWINMac&nbsp; OpenMail (future)&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; DSWNMcUnx&nbsp; OpenMail 4.10&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>?POP3&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NT MAIL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp; ?</p>
<p>POP3&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; WIG v2.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; gway ?</p>
<p>POP3&nbsp;&nbsp; MS-WIN&nbsp;&nbsp;&nbsp;&nbsp; Mi'Mail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mailcoach V1.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3r&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SLmailNT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3r&nbsp; WIN95&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SLmail95&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3u&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Exchpop(?) 1.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; gway yes</p>
<p>POP2&nbsp;&nbsp; VM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP2&nbsp;&nbsp; MS-WIN&nbsp;&nbsp;&nbsp;&nbsp; IBM TCP/IP for DOS&nbsp; clnt no</p>
<p>IMAP&nbsp;&nbsp; Java/JFC&nbsp;&nbsp; ICEMail 2.6&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP&nbsp;&nbsp;&nbsp; Java/JFC&nbsp;&nbsp; ICEMail 2.6&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>IMAP?&nbsp; MS-WIN&nbsp;&nbsp;&nbsp;&nbsp; EMBLA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp; ?</p>
<p>IMAP4&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Intrnt Msging Srvr&nbsp; srvr ?</p>
<p>POP3&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Intrnt Msging Srvr&nbsp; srvr ?</p>
<p>POP3&nbsp;&nbsp; NetWare4&nbsp;&nbsp; Connect2SMTP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>POP3&nbsp;&nbsp; DOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; C2SMTP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; WIN95/NT&nbsp;&nbsp; ExpressIT! 2000&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>IMAP&nbsp;&nbsp; WIN95/NT&nbsp;&nbsp; ExpressIT! 2000&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>IMAP?&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; InterChange&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>POP3&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PMDF E-mail Interc&nbsp; srvr ?</p>
<p>IMAP4&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PMDF E-mail Interc&nbsp; srvr ?</p>
<p>IMAP?&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PMDF E-mail Interc&nbsp; clnt ?</p>
<p>IMAP?&nbsp; MS-DOS&nbsp;&nbsp;&nbsp;&nbsp; PMDF E-mail Interc&nbsp; clnt ?</p>
<p>IMAP?&nbsp; VMS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pine in PMDF 4.3&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP?&nbsp;&nbsp; VMS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PMDF E-mail Interc&nbsp; ?&nbsp;&nbsp;&nbsp; ?</p>
<p>IMAP?&nbsp; OpenVMS&nbsp;&nbsp;&nbsp; PMDF 5.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>POP3r&nbsp; VMS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PMDF popstore&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; OpenVMS&nbsp;&nbsp;&nbsp; PMDF 5.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; VMS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PMDF 5.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>IMAP?&nbsp; Solaris&nbsp;&nbsp;&nbsp; PMDF 5.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>POP3&nbsp;&nbsp; DigUNIX&nbsp;&nbsp;&nbsp; PMDF 5.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>IMAP?&nbsp; DigUNIX&nbsp;&nbsp;&nbsp; PMDF 5.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>IMAP?&nbsp; VMS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PMDF 5.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>POP3&nbsp;&nbsp; Solaris&nbsp;&nbsp;&nbsp; PMDF 5.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>IMAP4&nbsp; Java&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; J Street Mailer&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; Java&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; J Street Mailer&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TCP/Connect II&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; MS-WIN&nbsp;&nbsp;&nbsp;&nbsp; TCP/Connect II f W&nbsp; clnt yes</p>
<p>IMAP4&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NTMail 3.02&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>POP3&nbsp;&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NTMail 3.02&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>POP3&nbsp;&nbsp; MS-WIN?&nbsp;&nbsp;&nbsp; IMAIL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; both ?</p>
<p>POP3&nbsp;&nbsp; MS-WINw&nbsp;&nbsp;&nbsp; IMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; MS-WINw&nbsp;&nbsp;&nbsp; IMAIL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IMail Srvr f NT 3.0 srvr na</p>
<p>IMAP4&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IMail Server 4.0&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>POP3&nbsp;&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IMail Server 4.0&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>POP3&nbsp;&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; N-Plex SMTP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>IMAP41 NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; N-Plex SMTP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MacMH&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ? (in testing)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr no</p>
<p>POP3r&nbsp; Java&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; shareware Java cls&nbsp; clnt ?</p>
<p>IMAP?&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mailstrom&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; MS-WINs&nbsp;&nbsp;&nbsp; winelm&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; MS-DOSs&nbsp;&nbsp;&nbsp; pcelm&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP?&nbsp;&nbsp; MS-WINw&nbsp;&nbsp;&nbsp; Windows ELM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lotus Notes 4.5 srv srvr ?</p>
<p>POP3&nbsp;&nbsp; WIN3/95/NT Lotus Nts ml cl 4.0 clnt yes</p>
<p>POP3&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lotus Nts ml cl 4.0 clnt yes</p>
<p>POP3&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lotus Nts ml cl 4.0 clnt yes</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lotus Nts ml cl 4.0 clnt yes</p>
<p>POP3&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; cc:Mail 8.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>IMAP4&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; cc:Mail 8.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>POP3&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; cc:Mail 8.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>IMAP4&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; cc:Mail 8.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP23&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; servers w Mail-IT&nbsp;&nbsp; srvr na</p>
<p>POP23&nbsp; MS-WINw&nbsp;&nbsp;&nbsp; Mail-IT 2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP23&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mail-IT 2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; MUSIC/SP&nbsp;&nbsp; POPD 1.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sendmail w POP3 1.1 srvr na</p>
<p>POP3&nbsp;&nbsp; WIN95/NT&nbsp;&nbsp; Calypso&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP4&nbsp; WIN95/NT&nbsp;&nbsp; Calypso&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP?&nbsp;&nbsp; MS-?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Exchange&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>IMAP4&nbsp; MS-?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Exch Server 5.5&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>POP3&nbsp;&nbsp; MS-?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Exch Server 5.5&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>POP3&nbsp;&nbsp; MS-?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Inter. Mail Service gway ?</p>
<p>POP3&nbsp;&nbsp; MS-?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Inter. Mail &amp; News&nbsp; clnt yes</p>
<p>IMAP4&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Internet Expl 4.0&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Internet Expl 4.0&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; Win95/NT&nbsp;&nbsp; Outlook Express&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP4&nbsp; Win95/NT&nbsp;&nbsp; Outlook Express&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; Win95/NT&nbsp;&nbsp; Outlook 97&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; Win95/NT&nbsp;&nbsp; Outlook 98&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP4&nbsp; Win95/NT&nbsp;&nbsp; Outlook 98&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP?&nbsp;&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MailSrv from Res K. srvr na</p>
<p>POP23&nbsp; MS-DOSp&nbsp;&nbsp;&nbsp; Minuet 1.0b18a(beta)clnt no</p>
<p>IMAP?&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mulberry (beta)&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>POP?&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; zpop&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP?&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; zync ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3k&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TechMail 2.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; MS-WINl&nbsp;&nbsp;&nbsp; TechMail for Wind.&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; OS/2l&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TechMail for Wind.&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; Java&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DartMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP4&nbsp; Java&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DartMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP4&nbsp; Win3/95/NT DART Mail 1.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP4&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DART Mail 1.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; Win3/95/NT DART Mail 1.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DART Mail 1.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DART Mail 1.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP4&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DART Mail 1.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP4&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DART Mail 1.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DART Mail 1.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP23&nbsp; MS-DOSni&nbsp;&nbsp; Chameleon beta&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP23&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Chameleon V5.0 f NT both ?</p>
<p>IMAP?&nbsp; Windows?&nbsp;&nbsp; Chameleon (future)&nbsp; clnt ?</p>
<p>POP23&nbsp; MS-WINw&nbsp;&nbsp;&nbsp; Internet Chameleon&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; WIN3/NT/95 JetMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP4&nbsp; WIN3/NT/95 JetMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Post.Office&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; Solaris&nbsp;&nbsp;&nbsp; Post.Office&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Z-Pop 1.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; SunOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Post.Office&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; WIN3/95/NT Z-Mail 4.0.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; Unix/line&nbsp; Z-Mail Lite 3.2&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; Unix/curs&nbsp; Z-Mail Lite 3.2&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; Unix/XM&nbsp;&nbsp;&nbsp; Z-Mail Motif 3.2.1&nbsp; clnt yes</p>
<p>POP23&nbsp; MS-DOSni&nbsp;&nbsp; ChameleonNFS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; both ?</p>
<p>IMAP4&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; post.office&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>POP3&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; post.office&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>IMAP4&nbsp; WIN3/95/NT Z-Mail Pro 6.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; WIN3/95/NT Z-Mail Pro 6.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Z-Mail Mac 3.3.1&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Z-Mail Unix 4.0&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Netscape Mail Srvr&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; Solaris&nbsp;&nbsp;&nbsp; Netscape Mail Srvr&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; SunOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Netscape Mail Srvr&nbsp; srvr na</p>
<p>IMAP4&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SuiteSpot M S&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>IMAP4&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Netscape M S 2.0(f) srvr ?</p>
<p>POP?&nbsp;&nbsp; Solaris&nbsp;&nbsp;&nbsp; Navigator 3.0b4(fut)clnt ?</p>
<p>POP3u&nbsp; Win3/95/NT Navigator 2.x&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP4&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Netscape M S 2.02&nbsp;&nbsp; srvr ?</p>
<p>IMAP4&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Communicator PR 2&nbsp;&nbsp; clnt yes</p>
<p>IMAP4&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Communicator PR 2&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Communicator PR 2&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Communicator PR 2&nbsp;&nbsp; clnt yes</p>
<p>IMAP4&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Communicator PR 2&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; WIN95/NT&nbsp;&nbsp; Communicator PR 2&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Communicator PR 2&nbsp;&nbsp; clnt yes</p>
<p>IMAP4&nbsp; WIN95/NT&nbsp;&nbsp; Communicator PR 2&nbsp;&nbsp; clnt yes</p>
<p>IMAP4&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Communicator 4.0x&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; NetWare 4&nbsp; LAN WorkGroup 5&nbsp;&nbsp;&nbsp;&nbsp; ???? na</p>
<p>POP3&nbsp;&nbsp; Java&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Novita Mail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>IMAP?&nbsp; Java&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Novita Mail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; DOSWINMac&nbsp; DaVinci SMTP eMAIL&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; WIN95/NT&nbsp;&nbsp; InterOffice 4.1&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>IMAP4&nbsp; WIN95/NT&nbsp;&nbsp; InterOffice 4.1&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>IMAP?&nbsp; Windows?&nbsp;&nbsp; pcMail (future)&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; MS-WIN&nbsp;&nbsp;&nbsp;&nbsp; Open Systems Mail&nbsp;&nbsp; clnt ?</p>
<p>POP?&nbsp;&nbsp; MS-WINls&nbsp;&nbsp; TCPMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; OpenVMS&nbsp;&nbsp;&nbsp; TCPware Internet Sr srvr na</p>
<p>POP3&nbsp;&nbsp; NetWare34&nbsp; SoftNet WEBserv&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3x&nbsp; MS-WIN&nbsp;&nbsp;&nbsp;&nbsp; WinQVT (2.1)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3r&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Vers of qpopper&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; WIN32&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Eudora Pro 2.2b8&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; Mac&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Eudora Light 3.1&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; Mac&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Eudora Pro 3.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP4&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Eudora Worldmail&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>POP3&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Eudora Worldmail&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>POP3mr Macintosh7 Eudora 2.0.2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3u&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; qpopper 2.1.4-r4&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; WIN3/95/NT Eudora Pro ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; Mac&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Eudora Pro 3.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3mrkMac7/PM7&nbsp;&nbsp; Eudora 2.1.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; MS-WINw&nbsp;&nbsp;&nbsp; Eudora 2.1.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3mrkMac7/PM7&nbsp;&nbsp; Eudora 2.1.3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3mrkMac7/PM7&nbsp;&nbsp; Eudora 2.1.2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3mr Mac7/PM7&nbsp;&nbsp; Eudora 2.0.3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3mrkMac7/PM7&nbsp;&nbsp; Eudora 2.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; MS-WINw&nbsp;&nbsp;&nbsp; Eudora 2.0.3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3r&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; EIMS 2.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>IMAP4&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Eudora Pro 4.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Eudora Pro 4.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Eudora 4.1 beta&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP4&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Eudora 4.1 beta&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAPb4 Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; popclient x.x (rep) clnt no</p>
<p>POP23r Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; popclient x.x (rep) clnt no</p>
<p>POP3&nbsp;&nbsp; MS-DOS&nbsp;&nbsp;&nbsp;&nbsp; Pegasus/DOS 3.22&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3t&nbsp; NetWare34&nbsp; Mercury 1.3.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; MS-Windows Pegasus/Win 2.2(r3) clnt ?</p>
<p>POP3&nbsp;&nbsp; MS-W32&nbsp;&nbsp;&nbsp;&nbsp; Pegasus/W32 2.5(r2) clnt yes</p>
<p>POP3t&nbsp; WIN32&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mercury32 099(b)&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pegasus/MAC 2.1.2&nbsp;&nbsp; clnt no</p>
<p>POP3&nbsp;&nbsp; MS-DOS&nbsp;&nbsp;&nbsp;&nbsp; Pegasus/DOS 3.11&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; MS-Windows Pegasus/Win 2.5(r3) clnt yes</p>
<p>POP3&nbsp;&nbsp; MS-DOS&nbsp;&nbsp;&nbsp;&nbsp; Pegasus/DOS 3.31&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; MS-DOS&nbsp;&nbsp;&nbsp;&nbsp; Pegasus/DOS 3.40&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3t&nbsp; NetWare34&nbsp; Mercury 1.3.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; MS-DOSl&nbsp;&nbsp;&nbsp; PMPOP (Pmail gw)&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; MS-DOSp&nbsp;&nbsp;&nbsp; POPgate (Pmail gw)&nbsp; clnt ?</p>
<p>POP?&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ucbmail clone&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; MS-WIN&nbsp;&nbsp;&nbsp;&nbsp; WinSmtp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ? (future)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Siren Mail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>POP3&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Siren Mail Server&nbsp;&nbsp; srvr ?</p>
<p>IMAP2&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Siren Mail Server&nbsp;&nbsp; srvr ?</p>
<p>POP3&nbsp;&nbsp; WIN3/95/NT Siren Mail 3.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Siren Mail 3.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FCIS 5.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FCIS 5.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>IMAP4&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FCIS future&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>IMAP4&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FCIS future&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>POP3&nbsp;&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Post.Office 2.0&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; Solaris&nbsp;&nbsp;&nbsp; Post.Office 2.0&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Post.Office 3.1&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; MS-WIN&nbsp;&nbsp;&nbsp;&nbsp; Air Series 2.06&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; POPGate 1.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; gway ?</p>
<p>IMAP41 MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CommuniGate IMAP&nbsp;&nbsp;&nbsp; gway ?</p>
<p>IMAP41 Linux&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CommuniGate Pro&nbsp;&nbsp;&nbsp;&nbsp; gway ?</p>
<p>IMAP24 Unix/XM&nbsp;&nbsp;&nbsp; ML 2.0 (future)&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP?&nbsp; Xrx Lsp Mc Yes-Way&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SIDIS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Quarterdeck Mail&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mail*Link UUCP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; gway yes</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mail*Link SMTP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ListSTAR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; both yes</p>
<p>IMAP24 MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mailstrom 1.04&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>IMAP1&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MacMS 2.2.1 (obs)&nbsp;&nbsp; clnt no</p>
<p>IMAP?&nbsp; Windows?&nbsp;&nbsp; Roam (Future)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>IMAP4&nbsp; SolarisX&nbsp;&nbsp; imapd (Future)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>IMAP4&nbsp; SolarisX&nbsp;&nbsp; Roam (Future)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>IMAP41 Java&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; JavaMail API&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; capi ?</p>
<p>POP23&nbsp; MS-DOS&nbsp;&nbsp;&nbsp;&nbsp; SelectMail 2.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP2&nbsp;&nbsp; MS-DOS&nbsp;&nbsp;&nbsp;&nbsp; LifeLine Mail 2.0&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; Linux&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; miniclient&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP?&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; pop-perl-1.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>IMAP4&nbsp; Win95&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Solstice 2.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>IMAP4&nbsp; Solaris&nbsp;&nbsp;&nbsp; Solstice IMS2.0&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>POP3&nbsp;&nbsp; Solaris&nbsp;&nbsp;&nbsp; Solstice IMS2.0&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>POP3&nbsp;&nbsp; Solaris&nbsp;&nbsp;&nbsp; Solstice IMS1.0&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>IMAP4&nbsp; Solaris&nbsp;&nbsp;&nbsp; Solstice IMS1.0&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>IMAP4&nbsp; MS-WIN3.11 Solstice IMC? (fut) clnt yes</p>
<p>IMAP4&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Solstice IMC0.9&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP4&nbsp; MS-WIN95&nbsp;&nbsp; Solstice IMC0.9&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP4&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Solstice IMC? (fut) clnt yes</p>
<p>IMAP4&nbsp; MS-WIN3.11 Solstice IMC0.9&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP4&nbsp; Solaris&nbsp;&nbsp;&nbsp; Solstice IMC? (fut) clnt yes</p>
<p>IMAP4&nbsp; MS-WIN95&nbsp;&nbsp; Solstice IMC? (fut) clnt yes</p>
<p>IMAP4&nbsp; Solaris&nbsp;&nbsp;&nbsp; Solstice IMC0.9&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; Solaris&nbsp;&nbsp;&nbsp; Sun IMS 3.1 (beta)&nbsp; srvr yes</p>
<p>IMAP41 Solaris&nbsp;&nbsp;&nbsp; Sun IMS 3.1 (beta)&nbsp; srvr yes</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; VersaTerm Link&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP2&nbsp;&nbsp; VM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP2&nbsp;&nbsp; OpenVMS&nbsp;&nbsp;&nbsp; MultiNet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; OpenVMS&nbsp;&nbsp;&nbsp; MultiNet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; both na</p>
<p>IMAP2&nbsp; MS-WIN&nbsp;&nbsp;&nbsp;&nbsp; PathWay&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>IMAP2&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PathWay&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>IMAP2&nbsp; Unix/X&nbsp;&nbsp;&nbsp;&nbsp; PathWay&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>POP3&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PathWay&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>POP3&nbsp;&nbsp; MS-WIN&nbsp;&nbsp;&nbsp;&nbsp; PathWay&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>POP3&nbsp;&nbsp; Unix/X&nbsp;&nbsp;&nbsp;&nbsp; PathWay&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>POP?&nbsp;&nbsp; MS-WIN&nbsp;&nbsp;&nbsp;&nbsp; PathWay Access 3.0&nbsp; clnt ?</p>
<p>IMAP24 MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mailstrom 2(beta)&nbsp;&nbsp; clnt yes</p>
<p>IMAP24 MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mailstrom 2.02&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP?&nbsp;&nbsp; VM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>POP23&nbsp; MS-WINw&nbsp;&nbsp;&nbsp; Turnpike&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP2&nbsp;&nbsp; MS-DOS&nbsp;&nbsp;&nbsp;&nbsp; MD/DOS-IP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>IMAP?&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; imapd 8.0(124)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>IMAP?&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; imapd 9.0(161)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>IMAP41 Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; imapd v10.164&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>IMAP2b Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; imapd 7.8(100)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>IMAP2b Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; imapd 4.0/UW (fut)&nbsp; srvr ?</p>
<p>POP3k&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; hacked ucbmail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>POP3k&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; hacked pine&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP2&nbsp;&nbsp; MS-DOSk&nbsp;&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>IMAP?&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; UMAIL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>IMAP?&nbsp; Unix/X&nbsp;&nbsp;&nbsp;&nbsp; Palm (in dev)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; NetWare&nbsp;&nbsp;&nbsp; Unoverica MT 2.90&nbsp;&nbsp; srvr na</p>
<p>POP3&nbsp;&nbsp; VM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; vmpop3.200&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>IMAP2&nbsp; Amiga&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pine 3.8x (in dev)&nbsp; clnt yes</p>
<p>POP23&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mail Serv f W NT&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>IMAP4&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mail Serv f W NT&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>POP?&nbsp;&nbsp; VM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?POPD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr na</p>
<p>IMAP2&nbsp; VMS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ImapD port&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr yes</p>
<p>IMAP2&nbsp; VMS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pine 3.88 port&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; NIN95/NT&nbsp;&nbsp; Rumba Mail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; WIN16/32&nbsp;&nbsp; Virtual Access&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; Be&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BeMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3s&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; fetchmail 4.7.9&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>IMAP2b Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; fetchmail 4.7.9&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>POP3u&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; fetchmail 4.7.9&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>POP23r Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; fetchmail 4.7.9&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>POP3k&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; fetchmail 4.7.9&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>IMAP41 Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; fetchmail 4.7.9&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>POP3&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; mutt-0.91 (alpha)&nbsp;&nbsp; clnt yes</p>
<p>IMAP&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; mutt&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP4&nbsp; UnixX11&nbsp;&nbsp;&nbsp; TkRat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP?&nbsp;&nbsp; UnixX11&nbsp;&nbsp;&nbsp; TkRat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; gcMail 081b (beta)&nbsp; clnt ?</p>
<p>IMAP?&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ELM patches&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; Java Aplt&nbsp; Yamp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP?&nbsp;&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NTMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>POP3&nbsp;&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NT Mail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; gway ?</p>
<p>POP3rutOS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; POP3s v1.01&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr ?</p>
<p>------ ---------- ------------------- ---- ----</p>
<p> &nbsp;&nbsp;&nbsp; _________________________________________________________________</p>
<p>Some web-based clients</p>
<p> &nbsp; Probably properly called 'gateways', they are or work in conjunction</p>
<p> &nbsp; with web servers, but act as a client to the IMAP or POP-based mail</p>
<p> &nbsp; server.</p>
<p>------ ---------- ------------------- ---- ----</p>
<p>POP3&nbsp;&nbsp; Perl&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; WWW-Mail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>IMAP?&nbsp; Perl&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; WWW-Mail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Win32&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Webmail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>IMAP?&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; VisualMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>POP3&nbsp;&nbsp; Unix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; VisualMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP?&nbsp; Win32&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Xwebmail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>IMAP?&nbsp; Apache/PHP IMP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>------ ---------- ------------------- ---- ----</p>
<p> &nbsp;&nbsp;&nbsp; _________________________________________________________________</p>
<p>Some other packages for desktop systems</p>
<p>------ ---------- ------------------- ---- ----</p>
<p>uucp&nbsp;&nbsp; MS-DOS&nbsp;&nbsp;&nbsp;&nbsp; waffle&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; peer ?</p>
<p>uucp&nbsp;&nbsp; MS-DOS&nbsp;&nbsp;&nbsp;&nbsp; UUPC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; peer ?</p>
<p>MAPI&nbsp;&nbsp; MS-WIN&nbsp;&nbsp;&nbsp;&nbsp; Air Mail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp; ?</p>
<p>?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PowerMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>MHS/G&nbsp; DOSWIN&nbsp;&nbsp;&nbsp;&nbsp; BeyondMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>SMTP&nbsp;&nbsp; MS-WINw&nbsp;&nbsp;&nbsp; ws_gmail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; peer ?</p>
<p>?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; QuickMail 3.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; QuickMail 4.0 (fut) clnt ?</p>
<p>?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; QuickMail 3.6&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MS-WIN&nbsp;&nbsp;&nbsp;&nbsp; QuickMail 3.5&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; QuickMail ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>SMTP&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LeeMail 2.0.2 (shw) peer ?</p>
<p>?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MS-DOSs&nbsp;&nbsp;&nbsp; CMM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; peer ?</p>
<p>PSS&nbsp;&nbsp;&nbsp; MS-DOS&nbsp;&nbsp;&nbsp;&nbsp; pMail 3.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>PSS&nbsp;&nbsp;&nbsp; MS-Win&nbsp;&nbsp;&nbsp;&nbsp; pMail 3.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DOSMac&nbsp;&nbsp;&nbsp;&nbsp; MailWorks&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>uucp&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; UUPC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; peer ?</p>
<p>?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DOSOS/2&nbsp;&nbsp;&nbsp; Higgins Mail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>MAPI&nbsp;&nbsp; MS-WIN&nbsp;&nbsp;&nbsp;&nbsp; SIMEON 4.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>MAPI&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ECSmail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>VIM&nbsp;&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ECSmail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>SMTP&nbsp;&nbsp; OS/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PC/TCP v1.3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; peer ?</p>
<p>?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MS-WINw&nbsp;&nbsp;&nbsp; Panda&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp; ?</p>
<p>PROP&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BlitzMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>PROP&nbsp;&nbsp; AIX&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BlitzMail (in dev)&nbsp; srvr no</p>
<p>PROP&nbsp;&nbsp; NeXT OS&nbsp;&nbsp;&nbsp; BlitzMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr no</p>
<p>PROP&nbsp;&nbsp; DEC OSF/1&nbsp; BlitzMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr no</p>
<p>Waffle MS-WIN&nbsp;&nbsp;&nbsp;&nbsp; Boxer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>prop&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MacPost&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; both ?</p>
<p>uucp&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Eudora &gt;1.3.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; peer yes</p>
<p>?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MS-WIN&nbsp;&nbsp;&nbsp;&nbsp; Team&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>P7uucp DOSWINMac&nbsp; OpenMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>SMTP&nbsp;&nbsp; MS-WINw&nbsp;&nbsp;&nbsp; Internt Ex for cc:m gway yes</p>
<p>MAPI&nbsp;&nbsp; WIN95/NT&nbsp;&nbsp; ExpressIT! 2000&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>VIM&nbsp;&nbsp;&nbsp; WIN95/NT&nbsp;&nbsp; ExpressIT! 2000&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>MHS&nbsp;&nbsp;&nbsp; WIN95/NT&nbsp;&nbsp; ExpressIT! 2000&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DOSWIN&nbsp;&nbsp;&nbsp;&nbsp; ExpressIT!&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>uucp&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; gnuucp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; peer ?</p>
<p>?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MS-?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; elm-pc&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>VIM&nbsp;&nbsp;&nbsp; DOSWINMac&nbsp; cc:mail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DOSWINMac&nbsp; Lotus Notes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>SMTP&nbsp;&nbsp; MS-WINw&nbsp;&nbsp;&nbsp; Mail-IT 2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; peer yes</p>
<p>MAPI&nbsp;&nbsp; MS-WINw&nbsp;&nbsp;&nbsp; Mail-IT 2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Microsoft Mail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>MAPI&nbsp;&nbsp; MS-DOS?&nbsp;&nbsp;&nbsp; Microsoft Mail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>SMTP&nbsp;&nbsp; MS-DOSni&nbsp;&nbsp; ChameleonNFS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; peer ?</p>
<p>MAPI&nbsp;&nbsp; WIN3/95/NT Z-Mail 4.0.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; GroupWise&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; cnlt ?</p>
<p>?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MS-DOSs&nbsp;&nbsp;&nbsp; WinMail 1.1a&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; peer ?</p>
<p>MHS/G&nbsp; DOSWINMac&nbsp; DaVinci eMAIL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>MAPI&nbsp;&nbsp; WIN3/95/NT Eudora Pro ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>SMTP&nbsp;&nbsp; MS-DOS&nbsp;&nbsp;&nbsp;&nbsp; Charon&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; gway ?</p>
<p>fshare MS-DOS&nbsp;&nbsp;&nbsp;&nbsp; Pegasus/DOS 3.31&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>fshare MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pegasus/MAC 2.1.2&nbsp;&nbsp; clnt no</p>
<p>fshare MS-Windows Pegasus/Win 2.2(r3) clnt ?</p>
<p>fshare MS-W32&nbsp;&nbsp;&nbsp;&nbsp; Pegasus/W32 2.5(r2) clnt yes</p>
<p>fshare MS-DOS&nbsp;&nbsp;&nbsp;&nbsp; Pegasus/DOS 2.35&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>fshare MS-DOS&nbsp;&nbsp;&nbsp;&nbsp; Pegasus/DOS 3.22&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>SMTP&nbsp;&nbsp; NetWare34&nbsp; Mercury 1.3.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; gway ?</p>
<p>fshare MS-DOS&nbsp;&nbsp;&nbsp;&nbsp; Pegasus/DOS 3.11&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>fshare MS-Windows Pegasus/Win 2.5(r3) clnt yes</p>
<p>fshare MS-DOS&nbsp;&nbsp;&nbsp;&nbsp; Pegasus/DOS 3.40&nbsp;&nbsp;&nbsp; clnt yes</p>
<p>SMTP&nbsp;&nbsp; NetWare34&nbsp; Mercury 1.3.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; gway ?</p>
<p>SMTP&nbsp;&nbsp; WIN32&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mercury32 099(b)&nbsp;&nbsp;&nbsp; gway ?</p>
<p>uucp&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FernMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; peer ?</p>
<p>SMTP&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LeeMail 1.2.4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; peer ?</p>
<p>?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MS-?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; pcelm&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt ?</p>
<p>MAPIs&nbsp; MS-WIN&nbsp;&nbsp;&nbsp;&nbsp; Siren Mail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp; ?</p>
<p>MAPIs&nbsp; WIN95&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Siren Mail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp; ?</p>
<p>MAPIs&nbsp; NTclient&nbsp;&nbsp; Siren Mail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp; ?</p>
<p>FCP&nbsp;&nbsp;&nbsp; WIN95/NT&nbsp;&nbsp; FCIC 5.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>FCP&nbsp;&nbsp;&nbsp; MS-WIN&nbsp;&nbsp;&nbsp;&nbsp; FCIC 5.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>FCP&nbsp;&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FCIC 5.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; clnt no</p>
<p>FCP&nbsp;&nbsp;&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FCIS 5.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr no</p>
<p>FCP&nbsp;&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FCIS 5.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr no</p>
<p>HTTP&nbsp;&nbsp; NT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FCIS 5.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr no</p>
<p>HTTP&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FCIS 5.0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; srvr no</p>
<p>SMPT&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SMTPGate&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; gway ?</p>
<p>UUCP&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; UUCPGate&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; gway ?</p>
<p>PROP&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CommuniGate&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; both ?</p>
<p>PROP&nbsp;&nbsp; MacOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Quarterdeck Mail&nbsp;&nbsp;&nbsp; both yes</p>
<p>PROP&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FreeMail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ?&nbsp;&nbsp;&nbsp; ?</p>
<p>?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DOSWINMac&nbsp; WordPerfect Office&nbsp; clnt ?</p>
<p>------ ---------- ------------------- ---- ----</p>
<p> &nbsp;&nbsp;&nbsp; _________________________________________________________________</p>
<p>Key and Other Issues</p>
<p>(a) What are the common extensions to POP3 and which clients/servers</p>
<p> support them?</p>
<p>POP3k - Kerberos</p>
<p>POP3a - AFS Kerberos</p>
<p>POP3x - ?</p>
<p>POP3t - xtnd xmit facility--allows client to send mail through additional</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; POP commands, thus allowing server to verify/log source of mail.</p>
<p>POP3r - APOP</p>
<p>POP3s - RPOP</p>
<p>POP3m - ?</p>
<p>POP3u - with UIDL command.</p>
<p> &nbsp; (b) What DOS protocol stacks are supported?</p>
<p>MS-DOSm - Lan Manager</p>
<p>MS-DOSn - NDIS Drivers</p>
<p>MS-DOSl - Lan Workplace for Dos</p>
<p>MS-DOSs - Sun PCNFS</p>
<p>MS-DOSp - Packet Drivers</p>
<p>MS-DOSo - ODI Drivers</p>
<p>MS-DOSi - IPXLink</p>
<p>MS-DOSf - FTP Software PC/TCP</p>
<p>MS-DOSk - KA9Q I think</p>
<p>MS-WIN? - similar</p>
<p>MS-WINw - WinSock compliant</p>
<p>MS-WIN5 - Windows 95</p>
<p>WIN3 - Windows 3.x winsock</p>
<p>WIN3/95/NT - Windows 3.x Winsock, Windows 95 and Windows NT</p>
<p>WIN3/95 - Windows 3.x Winsock and WIndows 95</p>
<p>NetWare3 - NetWare 3.x</p>
<p>NetWare4 - NetWare 4.x</p>
<p>NetWare34 - NetWare 3.x and 4.x</p>
<p>PHP3 - written in PHP scripting language.</p>
<p>Perl - written in Perl scripting language.</p>
<p>Java - written in Java programming language.</p>
<p>JavaApp - written as a Java Applet.</p>
<p>(c) Other notes</p>
<p>IMAP1&nbsp;&nbsp; - Original IMAP: I've heard that MacMS actually uses a unique</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dialect of it.&nbsp; Definitely obselete, unsupported, discouraged.</p>
<p>IMAP2b&nbsp; - IMAP2bis: name applied to various improved versions of IMAP2.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; This development effort culminated in IMAP4.</p>
<p>IMAP24&nbsp; - IMAP2 or IMAP4</p>
<p>fshare&nbsp; - uses file sharing.</p>
<p>IMAPb4&nbsp; - IMAP2, IMAP2bis, or IMAP4.</p>
<p>IMAP41&nbsp; - IMAP4rev1</p>
<p>MAPI&nbsp;&nbsp;&nbsp; - Microsoft's Messaging API</p>
<p>HTTP&nbsp;&nbsp;&nbsp; - Web-based e-mail.</p>
<p>MAPIs&nbsp;&nbsp; - Simple MAPI.</p>
<p>VIM&nbsp;&nbsp;&nbsp;&nbsp; - Lotus's Vendor Independent Messaging API</p>
<p>CMC&nbsp;&nbsp;&nbsp;&nbsp; - XAPIA's Common Message Calls API</p>
<p>AOCE&nbsp;&nbsp;&nbsp; - Apple Open Collaborative Environment</p>
<p>PROP&nbsp;&nbsp;&nbsp; - System-specific proprietary protocol</p>
<p>FCP&nbsp;&nbsp;&nbsp;&nbsp; - SoftArc's proprietary client-server protocol.</p>
<p>Unix/X&nbsp; - X Windows based</p>
<p>Unix/XM - Motif based</p>
<p>Unix/XO - OpenWindows based</p>
<p>UnixSHA - Solaris, HPUX &amp; AIX</p>
<p>PSS&nbsp;&nbsp;&nbsp;&nbsp; - PROFS Screen Scraper</p>

