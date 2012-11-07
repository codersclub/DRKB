<h1>Доступ к базам данных</h1>
<div class="date">01.01.2007</div>


<p>Теперь, после работы руками, попробуем разобрать несколько менее призёмлённых вещей. Для начала следует упомянуть что Вы наверное уже прочуствовали что такое таблица. Теперь немного остановимся на базе данных. Базу данных можно очень упрощённо представить как несколько разных таблиц. Они могут быть связаны между собой, а могут и нет. Как физически хранятся таблицы? В трёх видах:</p>
<p>1) Каждая таблица это отдельный файл. Так работают наиболее древние базы данных, например Парадокс (который мы пока используем в примерах), Dbase, FoxPro. Все файлы таблиц лежат в отдельном каталоге на диске. Этот каталог и называется базой данных.</p>
<p>2) Все таблицы хранятся в одном файле - например MS Access - именно этот файл и называется базой данных</p>
<p>3)Таблицы хранятся на специальном сервере - например MS SQL Server, Oracle. В данном случае нас вообще не интересует как сервер хранит эти таблицы - для нас прямой доступ к ним закрыт, мы можем лишь послать запрос на сервер и получить ответ.</p>
<p>Несмотря на значительную разницу в организации, работа с разными базами данных очень сходная (во всяком случае до углубления в дебри). В целом, Вам нет смысла копаться в реальных форматах файлов, нет смысла искать что в файле biolife.db означает 10й байт. Может показаться что всю работу над этим файлом делает компонент TTable в нашем примере. Но это не так! Я наверное удивлю многих если скажу, что компонент TTable реально является только интерфейсом, для лёгкого доступа к данным из Дельфи. Оказывается, что всю работу над таблицей делает специальный драйвер базы данных (или его ещё называют провайдер). Итак упрощённая схема общения с таблицей из программы выглядит примерно следующим образом(для нашего примера):</p>
<p>База Данных &lt;-&gt; Драйвер Базы Данных &lt;-&gt; TTable &lt;-&gt; наш код или др. компоненты</p>
<p>Итак драйвер БД «знает» тонкости и детали строения файла таблицы, или знает конкретные форматы запроса к серверу на «входе», а на выходе имеет некий универсальный «интерфейс» (Я имею ввиду широкое понятие слова «интерфейс», вне контекста с COM) к которому и подключается TTable. Естественно что каждая база данных, и даже каждая версия базы данных имеет свой уникальный формат, свои уникальные особенности, поэтому драйвер для каждой разновидности баз данных тоже уникальный и обычно создаётся производителем баз данных. Интерфейс на «выходе» тоже должен быть стандартизованным - тогда работа с разными базами данных будет значительно облегчена, конечно до истиной переносимости кода далеко (хотя для простейших програм можно легко перенести код для работы с другой базой данных) - сказываются очень большие различия в архитектуре баз данных, которые просто невозможно свести 100% к одинаковому интерфейсу, но в любом случае знакомство с одной базой данных позволяет с лёгкостью разобраться с другой... Как всегда существует несколько стандартов таких «выходных интерфейсов». Наиболее широкораспространены следующие «стандарты» или системы доступа к базам данных:</p>
<p>1)BDE - Borland Database Engine (или по-старому IDAPI). Мы как раз работали в наших примерах именно через эту систему. Эта система является «родной» для Дельфи и отличается весьма высокой производительностью при работе с локальными базами данных. С серверными базами данных её производительность гораздо скромнее. Она же является «родной» для Парадокса, что обусловливает очень высокую производительность и удобство работы связки Delphi-BDE-Paradox (конечно для небольших систем с малым количеством пользователей). BDE имеет в своём составе драйвера практически ко всем более или менее известным базам данных в среде Windows. Позже мы подробнее остановимся на настройке BDE.</p>
<p>2)ODBC - продукт был создан Microsoft как конкурент BDE. На большинстве баз данных он показывает меньшую производительность чем BDE, из Дельфи с ним работать не так удобно, но он так же имеет в своём составе драйвера практически ко всем более или менее известным базам данных в среде Windows. Его настройки можно найти в «Панели Управления» Windows. Есть бесплатная библиотека компонентов для работы с ODBC с исходными кодами, её можно взять с моего сайта: <a href="https://www.delphist.com" target="_blank">https://www.delphist.com</a>. Для программиста на Дельфи представляет очень ограниченный интерес - большинство возможностей реализовано в BDE, причём BDE со многими базами работает быстрее и Дельфи имеет собственные компоненты для BDE.</p>
<p>3)DAO - это очень старая система для доступа к MS Access и MS Excel (она так же поддерживает ещё несколько баз данных), отличается высокой производительностью и богатым набором функций для работы именно с MS Access и MS Excel. Вообще не поддерживает работу с серверными базами данных. DAO можно использовать для работы с MS Access и MS Excel когда критична производительность приложений и/или требуется всё богатство возможностей доступа к MS Access и MS Excel. Есть бесплатная библиотека компонентов для работы с DAO с исходными кодами, её можно взять с моего сайта: <a href="https://www.delphist.com" target="_blank">https://www.delphist.com</a>.</p>
<p>4)ADO (ActiveX Data Object) - новая система от MS ориентированная прежде всего на работу с серверными базами данных. Довольно удобна в использовании, Дельфи начиная с 4й версии в модификации Enterprise/Professional имеет линейку собственных компонентов для работы через ADO. Позднее мы рассмотрим работу с ADO компонентами.</p>
<p>Кроме перечисленных есть ещё по крайней мере десяток других широкоизвестных систем доступа к базам данных, и огромное количество "отдельностоящих" драйверов для конкретной базы данных.</p>
