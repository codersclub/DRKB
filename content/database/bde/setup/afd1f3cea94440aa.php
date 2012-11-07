<h1>Почему я должен устанавливать BDE?</h1>
<div class="date">01.01.2007</div>


<p>Есть один вопрос: как сделать так чтобы локальная база данных работала без бде  администратор. В моем проекте база альясы не использует.</p>
<p>Типичная ошибка! BDE это не поддержка alias! компоненты Дельфи такие как Table, Query, Database - почти вообще ничего не делают! - это только удобный интерфейс к BDE. Т.е. BDE реально читает и пишет в базы данных, обнавляет файлы, управляет транзакциями, сортирует данные, исполняет SQL запросы. BDE с одной стороны имеет BDE Admin для ее управления, а с другой API, которые и использует Дельфи в компонентах. Если вам надо обойтись без BDE вы должны использовать другие драйвера доступа к базам данных: ODBC, DAO, ADO, RDO - многие из них имеют свои API или COM интерфейсы которые вы можете использовать (напрямую, либо найти компоненты для этого, кроме того ADO входит в стандартную поставку дельфей, но через него приконнектится к парадоксу довольно затруднительно). Если же все эти драйвера вас не устраивают то вам надо написать свой драйвер к базе данных (можно прямо в коде программы), он должен обеспечивать:</p>
<p>1) Чтение и запись базы</p>
<p>2) Поддержка транзакций</p>
<p>3) Исполнение SQL запросов</p>
<p>4) Поддержка индексов и ключей</p>
<p>5) Поддержка многопользовательского доступа.</p>
<p>6) Стандартный набор API которые позволят подключаться компонентам типа Table, Query</p>
<p>Есть так же сторонние библиотеки для доступа к базам данных через свои собственные драйвера: HALCYON, или Апполо (Предложил МММ);</p>
<p>vkDBF- компонент для работы с ДБФ для Дельфы6/5 без БДЕ.(Предложил Free)</p>
<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

<hr />

<p>Допустим написал я программку для работы с некоторой базой данных, каким образом можно перетащить её на другой комп, если на нём нету никакого database desktop чтоб настроить Alias'ы, никаких библиотек нужных? Вы хотите сказать что никуда не деться и придётся заказчикам всем ставить с диска Delphi DB Desktop ?</p>
<p>Вы немного не понимаете архитектуру обращения к базе данных, BDE это вовсе не система настройки Alias'ов, не DB Desktop и не Database Administrator! Программа на Дельфи как и на любом другом языке общается с базами данных через особые драйвера баз данных, собственно компоненты TTablу/TQuery ничего не делают с базой данных, они только дают возможность в удобной форме послать запрос драйверу и интерпретировать ответ от драйвера, все запросы, все физические операции с базой данных делает вовсе не код вашего exe файла, а драйвер базы данных, который в данном случае входит в состав BDE. Примерно так же как когда вы сохраняете файл на диске вы же не даёте напрямую команду BIOSу записать на диск номер такой-то дорожку такую-то сектор такой-то, вы пишете имя файла, а драйвер диска входящий в состав операционной системы сам знает в какие сектора что писать. Точно то же и с базами данных - существует драйвер, который физически работает с таблицами, а вы лишь пользуетесь компонентами, которые знают как работать с драйвером (не с базой данных!) и позволяют Вам это делать довольно удобным способом. Чтобы унифицировать работу и не иметь отдельного совершенно разного интерфейса к разным базам данных используют так называемые системы доступа к базам данных - это наборы драйверов ко всем более или менее распространённым базам данных, которые имеют более или менее стандартный интерфейс для программиста, единые программы их конфигурирования и единую идеологию построения. Одной из таких систем является BDE - Borland Database Engine - по русски, в дословном переводе - Борландовский движок для баз данных - заметьте, не конфигурация и не DB Desktop - а "движок", ядро, именно то что и обеспечивает работу с базами данных. Компоненты TTable/TQuery без BDE работать не будут - там просто нет тех API с которыми они оперируют. Физически BDE представляет из себя:</p>
<p>1) Файл хранящий настрйки</p>
<p>2) Несколько DLL обеспечивающих общую работоспособность BDE</p>
<p>3) Драйвера для различных баз данных (Paradox, MS SQL Server, InterBase и т.д.)</p>
<p>4) Служебные утилиты для конфигурации и простых операций с базами данных (DB Desktop, BDE Administrator)</p>
<p>5) SQL Link - система специальных драйверов для серверных баз данных с улучшенной архитектурой под приложения клиент-сервер</p>
<p>Наличие файлов пунктов 1 и 2 - абсолютно необходимо, из пункта 3 - Вам в простейшем случае нужен лишь тот драйвер которым Вы пользуетесь. Файлы пунктов 4 и 5 - вспомогательные, для работоспособности BDE не имеют абсолютной необходимости.</p>
<p>Отвечая на Ваш вопрос - да, всем заказчикам надо поставить BDE, и ничего в этом страшного нет, так как любая маломальски сложная система обычно требует установки многих третьесторонних продуктов и ничего страшного в этом нет, во-вторых BDE бесплатна и вы можете её ставить где угодно и кому угодно, в третьих - BDE практически не мешает никаким другим программам, если они её не пользуют, практически не трогает реестр и занимает не так уж много места - по современным меркам - совсем мало, и в четвёртых - любой инсталлятор, например Install Shield "знает" как устанавливать BDE, поэтому если вы создадите нормальную инсталляцию Вашей программы, как любого серьёзного продукта, то инсталляция BDE будет проходить совершенно прозрачно и никому не будет мешать.</p>
<div class="author">Автор: Vit</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

