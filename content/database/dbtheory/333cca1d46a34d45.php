<h1>Распределенные информационные системы и базы данных</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: Глеб Ладыженский</div>

<p>Введение</p>
Распределенные базы данных невозможно рассматривать вне контекста более общей и более значимой темы распределенных информационных систем. Процессы децентрализации и информационной интеграции, происходящие во всем мире, неизбежно должны рано или поздно затронуть нашу страну. Россия, в силу своего географического положения и размеров "обречена" на преимущественное использование распределенных систем. На мой взгляд, это направление может успешно развиваться лишь при выполнении двух главных условий - адекватном развитии глобальной сетевой инфраструктуры и применении реальных технологий создания распределенных информационных систем.<br>
Второе условие, рассматриваемое как ключевой фактор развития информационных технологий в нашей стране, составляет предмет предлагаемого в данной статье обсуждения.<br>
Важность этой темы осознают все. Действительно, страна прошла начальный этап локальной компьютеризации. Многие задачи "автоматизации в малом" или "автоматизации в среднем" уже решаются адекватными средствами на достаточно высоком технологическом уровне. Но вот задачи совершенно иного качества - задачи создания корпоративных информационных систем - нуждаются в осмыслении и анализе. Сложность нынешнего этапа во многом предопределена традиционализмом и инерционностью мышления, выражающейся в попытке переноса средств и решений локальной автоматизации в мир распределенных систем. Этот мир живет по своим законам, которые требуют иных технологий. <br>
Существует ли сейчас понимание того, какими должны быть эти технологии? Боюсь, что нет. В большинстве же случаев преобладает стремление использовать знакомые, понятные, испробованные и поэтому родные средства для решения новых задач, принципиально отличающихся от того, чем приходилось заниматься раньше. <br>
Поведение и мотивация разработчиков вполне понятны и оправданы. Ставится задача - построить информационную систему "клиент-сервер" на базе локальной сети с централизованной базой данных. Выбирается одна из популярных многопользовательских СУБД и какие-либо средства для быстрой разработки приложений. Наконец, создается сама система, представляющая собой комбинацию базы данных и обращающихся к ней приложений, в которых и реализована вся прикладная логика. Пока все это работает в ограниченном масштабе, все идет великолепно. Предположим, что организация, для которой выполнялась разработка, настолько выросла, что вновь возникшие задачи потребовали децентрализации хранения и обработки данных и, соответственно, развития информационной системы. Здесь и совершается ошибка. Подходы, хорошо зарекомендовавшие себя во вполне определенных условиях, автоматически переносятся в совершенно иную среду, с иными правилами жизнедеятельности. В результате система становится неработоспособной и должна быть создана заново, но уже с применением адекватных средств.<br>
<p>Статью можно рассматривать как очень краткое введение в распределенные базы данных. Сжато затронуты смежные темы, в частности, программное обеспечение промежуточного слоя. Предполагается, что читатель знаком с основами реляционных баз данных и языка sql. Статья носит скорее обзорный характер; рассматривая распределенные базы данных как отправную точку, я не удержался некоторых обобщений и высказал собственную точку зрения на архитектуру распределенных систем (с которой, возможно, многие не согласятся - но так интересней).</p>

<p>1. Распределенные базы данных</p>
Под распределенной (distributed database - ddb) обычно подразумевают базу данных, включающую фрагменты из нескольких баз данных, которые располагаются на различных узлах сети компьютеров, и, возможно управляются различными СУБД. Распределенная база данных выглядит с точки зрения пользователей и прикладных программ как обычная локальная база данных. В этом смысле слово "распределенная" отражает способ организации базы данных, но не внешнюю ее характеристику. ("распределенность" базы данных невидима извне).</p>

<p>1.1. Определение Дэйта.</p>
Лучшее, на мой взгляд, определение распределенных баз данных (ddb) предложил Дэйт (c.j. date). Он установил 12 свойств или качеств идеальной ddb:</p>

- Локальная автономия (local autonomy)<br>
- Независимость узлов (no reliance on central site)<br>
- Непрерывные операции (continuous operation)<br>
- Прозрачность расположения (location independence)<br>
- Прозрачная фрагментация (fragmentation independence)<br>
- Прозрачное тиражирование (replication independence)<br>
- Обработка распределенных запросов (distributed query processing)<br>
- Обработка распределенных транзакций (distributed transaction processing)<br>
- Независимость от оборудования (hardware independence)<br>
- Независимость от операционных систем (operationg system independence)<br>
- Прозрачность сети (network independence)<br>
- Независимость от баз данных (database independence)<br>

<p>Локальная автономия</p>

<p>Это качество означает, что управление данными на каждом из узлов распределенной системы выполняется локально. База данных, расположенная на одном из узлов, является неотъемлемым компонентом распределенной системы. Будучи фрагментом общего пространства данных, она, в то же время функционирует как полноценная локальная база данных; управление ею выполняется локально и независимо от других узлов системы.</p>
Независимость от центрального узла<br>
<p>В идеальной системе все узлы равноправны и независимы, а расположенные на них базы являются равноправными поставщиками данных в общее пространство данных. База данных на каждом из узлов самодостаточна - она включает полный собственный словарь данных и полностью защищена от несанкционированного доступа.</p>
Непрерывные операции<br>
<p>Это качество можно трактовать как возможность непрерывного доступа к данным (известное "24 часа в сутки, семь дней в неделю") в рамках ddb вне зависимости от их расположения и вне зависимости от операций, выполняемых на локальных узлах. Это качество можно выразить лозунгом "данные доступны всегда, а операции над ними выполняются непрерывно".</p>
Прозрачность расположения <br>
<p>Это свойство означает полную прозрачность расположения данных. Пользователь, обращающийся к ddb, ничего не должен знать о реальном, физическом размещении данных в узлах информационной системы. Все операции над данными выполняются без учета их местонахождения. Транспортировка запросов к базам данных осуществляется встроенными системными средствами.</p>
Прозрачная фрагментация<br>
Это свойство трактуется как возможность распределенного (то есть на различных узлах) размещения данных, логически представляющих собой единое целое. Существует фрагментация двух типов: горизонтальная и вертикальная. Первая означает хранение строк одной таблицы на различных узлах (фактически, хранение строк одной логической таблицы в нескольких идентичных физических таблицах на различных узлах). Вторая означает распределение столбцов логической таблицы по нескольким узлам. <br>
<p>Рассмотрим пример, иллюстрирующий оба типа фрагментации. Имеется таблица employee (emp_id, emp_name, phone), определенная в базе данных на узле в Фениксе. Имеется точно такая же таблица, определенная в базе данных на узле в Денвере. Обе таблицы хранят информацию о сотрудниках компании. Кроме того, в базе данных на узле в Далласе определена таблица emp_salary (emp_id, salary). Тогда запрос "получить информацию о сотрудниках компании" может быть сформулирован так:</p>
<pre>
select * from employee@phoenix, employee@denver order by emp_id
</pre>
В то же время запрос "получить информацию о заработной плате сотрудников компании" будет выглядеть следующим образом:</p>
<pre>
select employee.emp_id, emp_name, salary from employee@denver, employee@phoenix, emp_salary@dallas order by emp_id
</pre>

<p>Прозрачность тиражирования<br>
<p>Тиражирование данных - это асинхронный (в общем случае) процесс переноса изменений объектов исходной базы данных в базы, расположенные на других узлах распределенной системы. В данном контексте прозрачность тиражирования означает возможность переноса изменений между базами данных средствами, невидимыми пользователю распределенной системы. Данное свойство означает, что тиражирование возможно и достигается внутрисистемными средствами.</p>

<p>Обработка распределенных запросов<br>
<p>Это свойство ddb трактуется как возможность выполнения операций выборки над распределенной базой данных, сформулированных в рамках обычного запроса на языке sql. То есть операцию выборки из ddb можно сформулировать с помощью тех же языковых средств, что и операцию над локальной базой данных. Например,</p>
<pre>
select customer.name, customer.address, order.number, order.date from customer@london, order@paris where customer.cust_number = order.cust_number
</pre>

Обработка распределенных транзакций<br>
<p>Это качество ddb можно трактовать как возможность выполнения операций обновления распределенной базы данных (insert, update, delete), не разрушающее целостность и согласованность данных. Эта цель достигается применением двухфазового или двухфазного протокола фиксации транзакций (two-phase commit protocol), ставшего фактическим стандартом обработки распределенных транзакций. Его применение гарантирует согласованное изменение данных на нескольких узлах в рамках распределенной (или, как ее еще называют, глобальной) транзакции.</p>
<p>Независимость от оборудования<br>
<p>Это свойство означает, что в качестве узлов распределенной системы могут выступать компьютеры любых моделей и производителей - от мэйнфреймов до "персоналок".</p>
<p>Независимость от операционных систем<br>
<p>Это качество вытекает из предыдущего и означает многообразие операционных систем, управляющих узлами распределенной системы.</p>
<p>Прозрачность сети<br>
<p>Доступ к любым базам данных может осуществляться по сети. Спектр поддерживаемых конкретной СУБД сетевых протоколов не должен быть ограничением системы с распределенными базами данных. Данное качество формулируется максимально широко - в распределенной системе возможны любые сетевые протоколы.</p>
<p>Независимость от баз данных<br>
Это качество означает, что в распределенной системе могут мирно сосуществовать СУБД различных производителей, и возможны операции поиска и обновления в базах данных различных моделей и форматов.<br>
Исходя из определения Дэйта, можно рассматривать ddb как слабосвязанную сетевую структуру, узлы которой представляют собой локальные базы данных. Локальные базы данных автономны, независимы и самоопределены; доступ к ним обеспечиваются СУБД, в общем случае от различных поставщиков. Связи между узлами - это потоки тиражируемых данных. Топология ddb варьируется в широком диапазоне - возможны варианты иерархии, структур типа "звезда" и т.д. В целом топология ddb определяется географией информационной системы и направленностью потоков тиражирования данных. <br>
<p>Посмотрим, во что выливается некоторые наиболее важные свойства ddb, если рассматривать их практически.</p>

<p>1.2. Целостность данных</p>
В ddb поддержка целостности и согласованности данных, ввиду свойств 1-2, представляет собой сложную проблему. Ее решение - синхронное и согласованное изменение данных в нескольких локальных базах данных, составляющих ddb - достигается применением протокола двухфазной фиксации транзакций. Если ddb однородна - то есть на всех узлах данные хранятся в формате одной базы и на всех узлах функционирует одна и та же СУБД, то используется механизм двухфазной фиксации транзакций данной СУБД. В случае же неоднородности ddb для обеспечения согласованных изменений в нескольких базах данных используют менеджеры распределенных транзакций. Это, однако, возможно, если участники обработки распределенной транзакции - СУБД, функционирующие на узлах системы, поддерживают xa-интерфейс, определенный в спецификации dtp консорциума x/open. В настоящее время xa-интерфейс имеют ca-openingres, informix, microsoft sql server, oracle, sybase. <br>
<p>Если в ddb предусмотрено тиражирование данных, то это сразу предъявляет дополнительные жесткие требования к дисциплине поддержки целостности данных на узлах, куда направлены потоки тиражируемых данных. Проблема в том, что изменения в данных инициируются как локально - на данном узле - так и извне, посредством тиражирования. Неизбежно возникают конфликты по изменениям, которые необходимо отслеживать и разрешать.</p>

<p>1.3. Прозрачность расположения</p>
Это качество ddb в реальных продуктах должно поддерживаться соответствующими механизмами. Разработчики СУБД придерживаются различных подходов. Рассмотрим пример из oracle. Допустим, что ddb включает локальную базу данных, которая размещена на узле в Лондоне. Создадим вначале ссылку (database link), связав ее с символическим именем (london_unix), транслируемым в ip-адрес узла в Лондоне.</p>
<pre>
create public database link london.com connect to london_unix using oracle_user_id;
</pre>
Теперь мы можем явно обращаться к базе данных на этом узле, запрашивая, например, в операторе select таблицу, хранящуюся в этой базе:</p>
<pre>
select customer.cust_name, order.order_date from customer@london.com, order where customer.cust_number = order.cust_number;
</pre>
Очевидно, однако, что мы написали запрос, зависящий от расположения базы данных, поскольку явно использовали в нем ссылку. Определим customer и customer@london.com как синонимы:</p>
<pre>
create synonym customer for customer@london.com;
</pre>
и в результате можем написать полностью независимый от расположения базы данных запрос:</p>
<pre>
select customer.cust_name, order.order_date from customer, order where customer.cust_number = order.cust_number
</pre>
Задача решается с помощью оператора sql create synonym, который позволяет создавать новые имена для существующих таблиц. При этом оказывается возможным обращаться к другим базам данных и к другим компьютерам. Так, запись в СУБД informix</p>
<pre>
create synonym customer for client@central:smith.customer
</pre>
означает, что любое обращение к таблице customer в открытой базе данных будет автоматически переадресовано на компьютер central в базу данных client к таблице customer. Оказывается возможным переместить таблицу из одной базы данных в другую, оставив в первой базе ссылку на ее новое местонахождение, при этом все необходимые действия для доступа к содержимому таблицы будут сделаны автоматически.<br>
<p>Мы уже говорили выше о горизонтальной фрагментации. Рассмотрим пример иерархически организованной ddb, на каждом из узлов которой содержится некоторое подмножество записей таблицы customer:</p>
С помощью create synonym можно определить, например, таблицу структуры customer, в которой хранятся строки с записями о клиентах компании, находящихся в Японии:</p>
<pre>
create synonym japan_customer for customer@hq.sales.asia.japan
</pre>

<p>Во многих СУБД задача управления именами объектов ddb решается путем использования глобального словаря данных, хранящего информацию о ddb: расположение данных, возможности других СУБД (если используются шлюзы), сведения о скорости передачи по сети с различной топологией и т.д.</p>

<p>1.4. Обработка распределенных запросов</p>
Выше уже упоминалось это качество ddb. Обработка распределенных запросов (distributed query -dq) - задача, более сложная, нежели обработка локальных и она требует интеллектуального решения с помощью особого компонента - оптимизатора dq. Обратимся к базе данных, распределенной по двум узлам сети. Таблица detail хранится на одном узле, таблица supplier - на другом. Размер первой таблицы - 10000 строк, размер второй - 100 строк (множество деталей поставляется небольшим числом поставщиков). Допустим, что выполняется запрос:</p>
<pre>
select detail_name, supplier_name, supplier_address from detail, supplier where detail.supplier_number = supplier.supplier_number;
</pre>

Результирующая таблица представляет собой объединение таблиц detail и supplier, выполненное по столбцу detail.supplier_number (внешний ключ) и supplier.supplier_number (первичный ключ).<br>
<p>Данный запрос - распределенный, так как затрагивает таблицы, принадлежащие различным локальным базам данных. Для его нормального выполнения необходимо иметь обе исходные таблицы на одном узле. Следовательно, одна из таблиц должна быть передана по сети. Очевидно, что это должна быть таблица меньшего размера, то есть таблица supplier. Следовательно, оптимизатор dq запросов должен учитывать такие параметры, как, в первую очередь, размер таблиц, статистику распределения данных по узлам, объем данных, передаваемых между узлами, скорость коммуникационных линий, структуры хранения данных, соотношение производительности процессоров на разных узлах и т.д. От интеллекта оптимизатора dq впрямую зависит скорость выполнения распределенных запросов.</p>

<p>1.5. Межоперабельность</p>
В контексте ddb межоперабельность означает две вещи. Во-первых, - это качество, позволяющее обмениваться данными между базами данных различных поставщиков. Как, например, тиражировать данные из базы данных informix в oracle и наоборот? Известно, что штатные средства тиражирования в составе данной конкретной СУБД позволяют переносить данные в однородную базу. Так, средствами ca-ingres/replicator можно тиражировать данные только из ingres в ingres. Как быть в неоднородной ddb? Ответом стало появление продуктов, выполняющих тиражирование между разнородными базами данных.<br>
Во-вторых, это возможность некоторого унифицированного доступа к данным в ddb из приложения. Возможны как универсальные решения (стандарт odbc), так и специализированные подходы. Очевидный недостаток odbc - недоступность для приложения многих полезных механизмов каждой конкретной СУБД, поскольку они могут быть использованы в большинстве случаев только через расширения sql в диалекте языка данной СУБД, но в стандарте odbc эти расширения не поддерживаются. <br>
<p>Специальные подходы - это, например, использование шлюзов, позволяющее приложениям оперировать над базами данных в "чужом" формате так, как будто это собственные базы данных. Вообще, цель шлюза - организация доступа к унаследованным (legacy) базам данных и служит для решения задач согласования форматов баз данных при переходе к какой-либо одной СУБД. Так, если компания долгое время работала на СУБД ims и затем решила перейти на oracle, то ей очевидно потребуется шлюз в ims. Следовательно, шлюзы можно рассматривать как средство, облегчающее миграцию, но не как универсальное средство межоперабельности в распределенной системе. Вообще, универсального рецепта решения задачи межоперабельности в этом контексте не существует - все определяется конкретной ситуацией, историей информационной системы и массой других факторов. ddb конструирует архитектор, имеющий в своем арсенале отработанные интеграционные средства, которых на рынке сейчас очень много.</p>

<p>1.6. Технология тиражирования данных</p>
Принципиальная характеристика тиражирования данных (data replication - dr) заключается в отказе от физического распределения данных. Суть dr состоит в том, что любая база данных (как для СУБД, так и для работающих с ней пользователей) всегда является локальной; данные размещаются локально на том узле сети, где они обрабатываются; все транзакции в системе завершаются локально.<br>
Тиражирование данных - это асинхронный перенос изменений объектов исходной базы данных в базы, принадлежащим различным узлам распределенной системы. Функции dr выполняет, как правило, специальный модуль СУБД - сервер тиражирования данных, называемый репликатором (так устроены СУБД ca-openingres и sybase). В informix-online dynamic server репликатор встроен в сервер, в oracle 7 для использования dr необходимо приобрести дополнительно к oracle7 dbms опцию replication option. <br>
<p>Специфика механизмов dr зависит от используемой СУБД. Простейший вариант dr - использование "моментальных снимков" (snapshot). Рассмотрим пример из oracle:</p>
<pre>
create snapshot unfilled_orders refrash complete start with to_date ('dd-mon-yy hh23:mi:55') next sysdate + 7 as select customer_name, customer_address, order_date from customer@paris, order@london where customer.cust_name = order.customer_number and order_complete_flag = "n";
</pre>

"Моментальный снимок" в виде горизонтальной проекции объединения таблиц customer и order будет выполнен в 23:55 и будет повторятся каждые 7 дней. Каждый раз будут выбираться только завершенные заказы.<br>
Реальные схемы тиражирования, разумеется, устроены более сложно. В качестве базиса для тиражирования выступает транзакция к базе данных. В то же время возможен перенос изменений группами транзакций, периодически или в некоторый момент времени, что дает возможность исследовать состояние принимающей базы на определенный момент времени.<br>
Детали тиражирования данных полностью скрыты от прикладной программы; ее функционирование никак не зависят от работы репликатора, который целиком находится в ведении администратора базы данных. Следовательно, для переноса программы в распределенную среду с тиражируемыми данными не требуется ее модификации. В этом, собственно, состоит качество 6 в определении Дэйта.<br>
Синхронное обновление ddb и dr-технология - в определенном смысле антиподы. Краеугольный камень первой - синхронное завершение транзакций одновременно на нескольких узлах распределенной системы, то есть синхронная фиксация изменений в ddb. ee "Ахиллесова пята" - жесткие требования к производительности и надежности каналов связи. Если база данных распределена по нескольким территориально удаленным узлам, объединенным медленными и ненадежными каналами связи, а число одновременно работающих пользователей составляет сотни и выше, то вероятность того, что распределенная транзакция будет зафиксирована в обозримом временном интервале, становится чрезвычайно малой. В таких условиях (характерных, кстати, для большинства отечественных организаций) обработка распределенных данных практически невозможна.<br>
dr-технология не требует синхронной фиксации изменений, и в этом ее сильная сторона. В действительности далеко не во всех задачах требуется обеспечение идентичности БД на различных узлах в любое время. Достаточно поддерживать тождественность данных лишь в определенные критичные моменты времени. Можно накапливать изменения в данных в виде транзакций в одном узле и периодически копировать эти изменения на другие узлы.<br>
Налицо преимущества dr-технологии. Во-первых, данные всегда расположены там, где они обрабатываются - следовательно, скорость доступа к ним существенно увеличивается. Во-вторых, передача только операций, изменяющих данные (а не всех операций доступа к удаленным данным), и к тому же в асинхронном режиме позволяет значительно уменьшить трафик. В-третьих, со стороны исходной базы для принимающих баз репликатор выступает как процесс, инициированный одним пользователем, в то время как в физически распределенной среде с каждым локальным сервером работают все пользователи распределенной системы, конкурирующие за ресурсы друг с другом. Наконец, в-четвертых, никакой продолжительный сбой связи не в состоянии нарушить передачу изменений. Дело в том, что тиражирование предполагает буферизацию потока изменений (транзакций); после восстановления связи передача возобновляется с той транзакции, на которой тиражирование было прервано.<br>
<p>dr-технология данных не лишена недостатков. Например, невозможно полностью исключить конфликты между двумя версиями одной и той же записи. Он может возникнуть, когда вследствие все той же асинхронности два пользователя на разных узлах исправят одну и ту же запись в тот момент, пока изменения в данных из первой базы данных еще не были перенесены во вторую. При проектировании распределенной среды с использованием dr-технологии необходимо предусмотреть конфликтные ситуации и запрограммировать репликатор на какой-либо вариант их разрешения. В этом смысле применение dr-технологии - наиболее сильная угроза целостности ddb. На мой взгляд, dr-технологию нужно применять крайне осторожно, только для решения задач с жестко ограниченными условиями и по тщательно продуманной схеме, включающей осмысленный алгоритм разрешения конфликтов.</p>

<p>2. Архитектура "клиент-сервер"</p>
Распределенные системы - это системы "клиент-сервер". Существует по меньшей мере три модели "клиент-сервер":</p>
- Модель доступа к удаленным данным (rda-модель)<br>
- Модель сервера базы данных (dbs-модель)<br>
- Модель сервера приложений (as-модель)<br>
Первые две являются двухзвенными и не могут рассматриваться в качестве базовой модели распределенной системы (ниже будет показано, почему это так). Трехзвенная модель хороша тем, что в ней интерфейс с пользователем полностью независим от компонента обработки данных. Собственно, трехзвенной ее можно считать постольку, поскольку явно выделены:</p>

- Компонент интерфейса с пользователем<br>
- Компонент управления данными (и базами данных в том числе)<br>
а между ними расположено программное обеспечение промежуточного слоя (middleware), выполняющее функции управления транзакциями и коммуникациями, транспортировки запросов, управления именами и множество других. middleware - это ГЛАВНЫЙ компонент распределенных систем и, в частности, ddb-систем. Главная ошибка, которую мы совершаем на нынешнем этапе - полное игнорирование middleware и использование двухзвенных моделей "клиент-сервер" для реализации распределенных систем.<br>

<p>Существует фундаментальное различие между технологией "sql-клиент - sql-сервер" и технологией продуктов класса middleware (например, менеджера распределенных транзакций tuxedo system). В первом случае клиент явным образом запрашивает данные, зная структуру базы данных (имеет место так называемый data shipping, то есть "поставка данных" клиенту). Клиент передает СУБД sql-запрос, в ответ получает данные. Имеет место жесткая связь типа "точка- точка", для реализации которой все СУБД используют закрытый sql-канал (например, oracle sql*net). Он строится двумя процессами: sql/net на компьютере - клиенте и sql/net на компьютере-сервере и порождается по инициативе клиента оператором connect. Канал закрыт в том смысле, что невозможно, например, написать программу, которая будет шифровать sql- запросы по специальному алгоритму (стандартные алгоритмы шифрования, используемые, например, в oracle sql*net, вряд ли будут сертифицированы ФАПСИ). <br>
В случае трехзвенной схемы клиент явно запрашивает один из сервисов (предоставляемых прикладным компонентом), передавая ему некоторое сообщение (например) и получает ответ также в виде сообщения. Клиент направляет запрос в информационную шину (которую строит tuxedo system), ничего не зная о месте расположения сервиса. Имеет место так называемый function shipping (то есть "поставка функций" клиенту). Важно, что для Клиента база данных (в том числе и ddb) закрыта слоем Сервисов. Более того, он вообще ничего не знает о ее существовании, так как все операции над базой данных выполняются внутри сервисов. <br>
Сравним два подхода. В первом случае мы имеем жесткую схему связи "точка-точка" с передачей открытых sql-запросов и данных, исключающую возможность модификации и работающую только в синхронном режиме "запрос-ответ". Во втором случае определен гибкий механизм передачи сообщений между клиентами и серверами, позволяющий организовывать взаимодействие между ними многочисленными способами. <br>
Таким образом, речь идет о двух принципиально разных подходах к построению информационных систем "клиент-сервер". Первый из них устарел и явно уходит в прошлое. Дело в том, что sql (ставший фактическим стандартом общения с реляционными СУБД) был задуман и реализован как декларативный язык запросов, но отнюдь не как средство взаимодействия "клиент-сервер" (об этой технологии тогда речи не было). Только потом он был "притянут за уши" разработчиками СУБД в качестве такого средства. На волне успеха реляционных СУБД в последние годы появилось множество систем быстрой разработки приложений для реляционных баз данных (visualbasic, powerbuilder, sql windows, jam и т.д.). Все они опирались на принцип генерации кода приложения на основе связывания элементов интерфейса с пользователем (форм, меню и т.д.) с таблицами баз данных. И если для быстрого создания несложных приложений с небольшим числом пользователей этот метод подходит как нельзя лучше, то для создания корпоративных распределенных информационных систем он абсолютно непригоден. <br>
<p>Для этих задач необходимо применение существенно более гибких систем класса middleware (tuxedo system, teknekron), которые и составляют предмет нашей профессиональной деятельности и базовый инструментарий при реализации больших проектов.</p>

<p>Заключение</p>
Сегодня можно считать, что распределенные базы данных - тема достаточно локальная и далеко не так актуальная, как архитектура распределенных систем. В ddb-технологии за последние 2-3 года не было каких-либо существенных новаций (за исключением, быть может, технологии тиражирования данных). Можно считать, что в этой сфере информатики все более или менее устоялось и каких-либо революционных шагов не предвидится. Более интересное направление (включающее ddb) - архитектура, проектирование и реализация распределенных информационных систем. "Горячие" темы в этом направлении - системы с трехзвенной архитектурой, продукты класса middleware, объектно-ориентированные средства разработки распределенных приложений в стандарте corba. Их активное применение будет доминировать в отечественной информатике в ближайшие 3-5 лет и станет технологической базой реальных интеграционных проектов.<br>
<p>Мне кажется, что революция произойдет в архитектуре корпоративных информационных систем. Технологический взрыв в intertet, создание и супербурное развитие Всемирной паутины, технология java, неизбежно отразятся на организации инфраструктуры корпораций. На мой взгляд, очевидные преимущества гипертекстовой организации данных (гибкость, открытость, простота развития и расширения) перед жесткими структурами реляционных баз данных, по своей природе плохо приспособленными для расширения, предопределяют использование html в качестве одного из основных средств создания информационного пространства компании. Подход, опирающийся на гипертексты, позволяет без особых проблем интегрировать уже существующие информационные массивы, хранящиеся в базах данных. То, что сейчас называют intranet - это прообраз будущей корпоративной информационной системы.</p>

<p>Литература</p>
1. date c.j. 1987. what is distributed database? infodb, 2:7<br>
2. Г.М.Ладыженский. Технология "клиент-сервер" и мониторы транзакций. "Открытые системы"</p>

<p>Источник:<a href="https://hsoft.h15.ru/" target="_blank">https://hsoft.h15.ru/</a></p>
