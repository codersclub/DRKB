<h1>Views</h1>
<div class="date">01.01.2007</div>


<p>Вьюверы: ограниченый доступ к данным</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Что такое вьверы?</td></tr></table></div>&nbsp;</p>
Вьювер - это альтернативный способ представления данных из одной или нескольких таблиц. Вьювер можно представлять себе как фильтр, через который пропускаются табличные данные, прежде чем их увидит пользователь. В этом смысле можно говорить о представлении или изменении данных “через” вьювер.</p>
Вьювер создается на базе одной или нескольких таблиц, расположенных в базе данных. Таблицы, из которых строится вьювер называются базовыми или основными. Вьювер может быть также построен на основе другого вьювера.</p>
Определение вьювера и названия его базовых таблиц сохраняется в базе данных. При определении вьювера не создается никаких копий табличных данных. Все данные, которые появляются во вьювере, на самом деле распологаются в базовых таблицах.</p>
По внешнему виду вьювер ничем не отличается от таблицы базы данных. С расположенными в нем данными можно работать почти также как с табличными данными. Язык Transact-SQL был расширен для того, чтобы снять все ограничения на выборку данных через вьювер и ослабить обычные ограничения на модификацию данных. Оставшиеся исключения и ограничения будут описаны в этой главе.</p>
Когда через вьювер происходит изменение видимых в нем данных, то на самом деле изменяются данные, находящиеся в базовых таблицах. Обратно, если изменяются данные в базовых таблицах, то автоматически происходят изменения во вьюверах, построенных на основе этих таблиц.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Преимущества вьюверов</td></tr></table></div>&nbsp;</p>
Примеры, которые приведены в этой главе, показывают, как вьюверы могут использоваться для выделения нужных данных и упрощения их восприятия. Вьюверы также обеспечивают простой в использовании механизм защиты данных. Кроме того, вьюверы могут быть полезны, когда изменяется структура базы данных, а пользователь предпочитает работать в привычном для себя стиле.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Фокусировка</td></tr></table></div> Вьюверы позволяют пользователю сосредоточиться на интересующих его данных и на задаче, которую ему надо решить. Данные, которые не имеют отношения к конкретному пользователю, могут быть скрыты из его поля зрения.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Более простая работа с данными</td></tr></table></div>&nbsp;</p>
Вьюверы облегчают не только восприятие данных, но и работу с ними, поскольку часто используемые объединения, проекции и выборки могут быть определены для вьюверов, что позволяет пользователю не указывать всех условий и уточнений каждый раз, когда выполняется очередная операция.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Гибкость</td></tr></table></div>Вьюверы позволяют различным пользователям иметь различные точки зрения на одни и те же данные. Это особенно важно, когда много различных пользователей с различной квалификацией работают с одной и той же базой данных.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Безопасность</td></tr></table></div>Через вьювер пользователи могут запрашивать и модифицировать только те данные, которые они видят. Остальная часть базы данных остается для них скрытой и недоступной.</p>
С помощью команд grant (предоставлять) и revoke (отнимать) можно разрешить доступ каждому пользователю только к определенным объектам базы данных, включая вьюверы. Если вьювер, а также все базовые таблицы и вьюверы, на которых он основан, принадлежат одному владельцу, то этот владелец может давать разрешение другим пользователям на использование этого вьювера и в то же время запретить непосредственное использование базовых таблиц и вьюверов. Это простой и вместе с тем эффективный механизм обеспечения защиты данных. Детальное описание команд grant и revoke дается в Руководстве по&nbsp; администрированию доступа к&nbsp; SQL Серверу.</p>
Определив различные вьюверы и задав различные права доступа к ним, можно разрешить доступ пользователей только к опеределенным подмножествам данных. Далее приводятся примеры использования вьюверов исходя из соображений безопасности:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Доступ может быть разрешен только к определенным строкам базовой таблицы, содержащих определенную информацию. Например, можно создать вьювер, в котором будут показаны только книги по бизнесу и психологии, а информация о всех других книгах будет скрыта;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Доступ может быть разрешен только к определенным столбцам базовой таблицы. Например, можно определить вьювер, в котором будут видны все строки из таблицы titles, но данные в столбцах royalty (гонорар) и advance (аванс) будут скрыты, поскольку они носят коммерческий характер;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Доступ может быть разрешен только к определенным строкам и столбцам базовой таблицы;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Доступ может быть разрешен только к тем строкам, которые удовлетворяют условиям соединения с несколькими базовыми таблицами. Например, можно определить вьювер, в котором соединяются данные из таблиц titles, authors и titleauthor, чтобы были видны фамилии авторов вместе с названиями книг, которые они написали. В этом вьювере можно не показывать персональную информацию об авторах и информацию коммерческого характера;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Доступ может быть разрешен только к итоговым данным в основной таблице. Например, через вьювер category_price (категория_цена) пользователь может узнать только средние цены по каждому виду книг;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Доступ может быть разрешен только к подмножеству строк в другом вьювере или к комбинации вьюверов и таблиц. Например, через вьювер hiprice_computer пользователь может узнать названия и цены книг по компьютерной тематике, которые удовлетворяют условиям, указанным в определении вьювера.</td></tr></table></div>Чтобы определить вьювер, пользователь должен получить разрешение на выполнение команды creat view (создать вьювер) от владельца базы данных и иметь соответствующие права доступа ко всем таблицам или вьюверам, которые используются в определении этого вьювера.</p>
Если в определении вьювера участвуют объекты из различных баз данных, то пользователь, создающий вьювер, должен иметь право доступа к этим базам или иметь гостевые права в этих базах.</p>
Пользователь, владеющий объектом в базе, должен сам следить за тем, как другие пользователи используют его информацию через вьюверы. Рассмотрим&nbsp; ситуацию, когда владелец базы данных разрешил “Гарольду” создавать вьюверы, а пользователь по имени “Моди” разрешила “Гарольду” выбирать данные из своей таблицы. С этими правами “Гарольд” может определить вьювер, через который будет открыта вся информация из таблицы, принадлежащей “Моди”. Если после этого “Моди” отберет у “Гарольда” права на чтение данных из своей таблицы, он тем не менее может увидеть их через свой вьювер.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Логическая независимость данных</td></tr></table></div>&nbsp;</p>
Вьюверы помогают защитить пользователей от изменений в структурах таблиц, если внесение таких изменений становится совершенно необходимым.</p>
Например, предположим, что база данных была реструктурирована с помощью оператора select into (выбрать в) и таблица titles была разделена на две новых таблицы titletext и titlenumbers с удалением таблицы titles:</p>
&nbsp;</p>
titletext (title_id, title, type, notes) </p>
titlenumbers (title_id, pub_id, price, advance, royalty, total_sales, pub_date)</p>
&nbsp;</p>
Заметим, что прежняя таблица titles может быть “восстановлена” с помощью соединения по столбцу title_id двух новых таблиц. Чтобы защитить от этого изменения пользователей, достаточно создать вьювер на основе двух новых таблиц. Можно даже назвать его прежним именем titles.</p>
Любой запрос или любая сохраняемая процедура, которая раньше обращалась к таблице titles теперь будет обращаться к вьюверу titles. Все операторы select (выбор) у пользователей будут работать как и раньше. Пользователям, которые только выбирают данные из этой таблицы, можно даже не сообщать о проишедшем изменении.</p>
К сожалению, вьюверы обеспечивают лишь частичную логическую независимость. Некоторые операторы модификации данных не будут выполняться с новым объектом titles, поскольку они не разрешены для вьюверов.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Примеры вьюверов</td></tr></table></div>&nbsp;</p>
В нашем первом примере вьювер будет получен из таблицы titles. Предположим, что пользователя интересуют только книги, цена которых выше 15 долларов и по которым был выплачен больший чем 5000 долларов. В соответствующем оператор выбора нужно указать следующие условия отбора строк:</p>
&nbsp;</p>
&nbsp;</p>
select * </p>
from titles </p>
where price &gt; $15 </p>
  and advance &gt; $5000 </p>
&nbsp;</p>
Предположим теперь, что необходимо выполнить много операций выборки и обновления на этом массиве данных. Можно, конечно, каждый раз указывать вышеприведенные условия в каждой выполняемой команде. Однако, удобней создать вьювер, в котором явно указать какие записи должны быть видны:</p>
&nbsp;</p>
create view hiprice </p>
as select * </p>
from titles </p>
where price &gt; $15 </p>
  and advance &gt; $5000</p>
&nbsp;</p>
Когда SQL Сервер получит эту команду, то вместо выполнения оператора выбора select, который указан здесь после ключевого слова as, сервер сохранит этот оператор, который фактически является определением вьювера hiprice, в системной таблице syscomments. Информация о каждом столбце вьювера будет также&nbsp; записана в системные таблицы sysobjects и syscolumns.</p>
Теперь, при обращении к вьюверу hiprice, SQL Сервер объединит выполняемый оператор с определением вьювера hiprice. Например, пользователь может изменить все цены в hiprice также, как и в любой другой таблице, с помощью следующего оператора:</p>
&nbsp;</p>
update hiprice </p>
set price = price * 2 </p>
&nbsp;</p>
SQL Сервер сам находит определение вьювера в системных таблицах и конвертирует этот оператор обновления следующим образом:</p>
&nbsp;</p>
update titles </p>
set price = price * 2 </p>
where price &gt; $15 </p>
  and advance &gt; $5000</p>
&nbsp;</p>
Другими словами, SQL Сервер, основываясь на определении вьювера, обновит таблицу titles. При этом, конечно, будут обновляться только те строки, которые удовлетворяют условиям по цене и авансу, которые также были указаны в определении вьювера и переписаны в оператор обновления.</p>
Последствия выполнения этого оператора обновления можно увидеть как через вьювер, так и непосредственно в таблице titles. И наоборот, если бы пользователь выполнил второй из указанных операторов обновления непосредственно с таблицей titles, то изменения можно было бы увидеть и через вьювер.</p>
Обновление базовой таблицы может привести к изменениям в данных, видимых через вьювер. Например, если увеличить цену книги “You can combat computer stress” до 25.95 долларов, то ее можно будет увидеть через вьювер, поскольку она будет удовлетворять условиям отбора данных в этом вьювере.</p>
Однако, если происходят изменения в структуре базовой таблицы, например к ней добавляются новые столбцы, то эти столбцы не будут отображены во вьювере, поскольку их нет в соответствующем операторе выбора select *. Для их появления необходимо переопределить вьювер, поскольку звездочка (*) является сокращением для списка столбцов, присутствующих в таблице в момент определения вьювера.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Создание вьюверов</td></tr></table></div>&nbsp;</p>
Название вьювера должно быть уникальным среди уже сущестующих названий таблиц и вьюверов. Если установлена опция командой set quoted_identifier on, то можно заключать название вьювера в кавычки. В противном случае, название должно удовлетворять правилам написания идентификаторов, изложенным в главе 1.</p>
Вьюверы можно строить из других вьюверов, а также на базе процедур, которые обращаются к вьюверам. На вьюверах можно определять главные, внешние (foreign) и общие ключи. С вьюверами нельзя связывать правил, значений по умолчанию, триггеров или индексов. Нельзя создавать временные вьюверы и нельзя строить вьювер на временной таблице.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Синтаксис команды создания вьюверов</td></tr></table></div>&nbsp;</p>
Оператор создания вьюверов имеет следующий общий вид:</p>
&nbsp;</p>
create view [[название_базы.]владелец.]название_вьювера </p>
 &nbsp;&nbsp;&nbsp;&nbsp; [(название_столбца [, название_столбца]...)] </p>
 &nbsp;&nbsp;&nbsp;&nbsp; as select [distinct] оператор_выбора</p>
 &nbsp;&nbsp;&nbsp;&nbsp; [with check option]</p>
&nbsp;</p>
Как было показано в примере, приведенном в предыдущем разделе, пользователь может не указывать названий столбцов в предложении create оператора создания вьювера. В этом случае SQL Сервер присваивает столбцам вьювера те же названия и те же типы данных, что приведены в списке выбора оператора select. Этот список может быть заменен звездочкой (*), как в предыдущем примере, или быть частью списка названий столбцов базовой таблицы.</p>
Пользователь может определить вьювер, в котором не будет повторяющихся строк. Для этого нужно указать ключевое слово distinct в операторе выбора select.</p>
Вьюверы, созданные с ключевым словом distinct нельзя обновлять.</p>
Всегда возможно явно указать названия столбцов. Однако, названия столбцов нужно указывать в предложении create для каждого столбца, если имеет место любое из следующих условий:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Если столбец получается в результате вычисления арифметической, агрегирующей или встроенной функции или содержит константу;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Если два или более столбца вьювера, в противном случае, получат одинаковое название. Это обычно происходит при построении вьювера на основе соединения, когда соединяемые таблицы имеют столбцы с одинаковым названием;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Когда желательно изменить название столбца вьювера по сравнению с его табличным названием. Пользователь может переименовать столбцы и в операторе выбора select, который определяет вьювер. Независимо от изменения названия столбец вьювера наследует тип данных из столбца таблицы, на котором он основан.</td></tr></table></div>&nbsp;</p>
Далее приводится пример определение вьювера, в котором изменено название столбца по сравнению с табличным названием:</p>
&nbsp;</p>
create view pub_view (Publisher, city, state) </p>
as select pub_name, city, state </p>
from publishers </p>
&nbsp;</p>
Далее приводится другой способ создание того же вьювера, в котором столбец переименовывается в операторе выбора:</p>
&nbsp;</p>
create view pub_view2 </p>
as select Publisher = pub_name, city, state </p>
from publishers</p>
&nbsp;</p>
В примерах, которые приводятся в следующих разделах, будут показаны остальные способы включения названий столбцов в предложение create view.</p>
В следующем разделе рассматривается оператор выбора, определяющий вьювер, ключевое слово distinct и опция with check option (опция проверки). После этого описывается команда удаления вьюверов drop.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td> Использование оператора выбора при создании вьюверов</td></tr></table></div>&nbsp;</p>
Команда выбора select в операторе создания вьювера по существу определяет вьювер. Пользователь должен иметь право доступа ко всем объектам, указанным в этой команде.</p>
Вьювер не обязан быть простым подмножеством строк или столбцов одной таблицы, как это было показано в нашем предыдущем примере. Вьювер можно строить из нескольких таблиц и вьюверов с помощью оператора выбора любой сложности.</p>
Имеется несколько следующих ограничений для оператора выбора в определении вьювера:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>В нем нельзя использовать предложения order by и compute;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>В нем нельзя использовать ключевое слово into;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>В нем нельзя использовать временные таблицы.</td></tr></table></div>&nbsp;</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Определение вьювера в виде проекции</td></tr></table></div>Чтобы создать вьювер, в котором отображаются все строки таблицы titles, содержащие информацию только из части столбцов (проекция), можно воспользоваться следующим оператором: </p>
&nbsp;</p>
create view titles_view </p>
as select title, type, price, pubdate </p>
from titles</p>
&nbsp;</p>
Заметим, что в предложении create view этого оператора нет названий столбцов, поскольку все они указаны в списке выбора.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td> Определение вьювера с вычисляемым столбцом</td></tr></table></div>Далее приводится определение вьювера, значение в одном из столбцов которого вычисляется из величин, содержащихся в столбцах price, royalty и total_sales:</p>
&nbsp;</p>
create view accounts (title, advance, amt_due) </p>
as select titles.title_id, advance, (price * royalty /100 ) * total_sales </p>
from titles, roysched </p>
where price &gt; $15 </p>
and advance &gt; $5000 </p>
and titles.title_id = roysched.title_id </p>
and total_sales between lorange and hirange </p>
&nbsp;</p>
В этом примере список столбцов должен быть указан в предложении creat, поскольку в данном случае нет названия для столбца, в котором перемножаются величины из столбцов price, royalty и total_sales. Вычисляемый столбец получил название amt_due, которое должно быть указано на том же по порядку месте в предложении creat, что и соответствующее ему вычисляемое выражение в предложении select.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Определение вьювера с агрегирующими и встроенными функциями</td></tr></table></div>Если в определении вьювера используются агрегирующие или встроенные функции, то в предложении creat нужно указывать названия столбцов. Например:</p>
&nbsp;</p>
create view categories (category, average_price) </p>
as select type, avg(price) </p>
from titles </p>
group by type</p>
&nbsp;</p>
Если вьювер создается из соображений безопасности данных, то нужно проявлять осторожность при использовании агрегирующих функций и группировки (group by). Поскольку в языке Transact SQL нет ограничений на использование столбцов при группировке в операторе выбора, то может возникнуть ситуация, когда вьювер возвратит больше информации чем нужно. Например:</p>
&nbsp;</p>
create view categories (category, average_price) </p>
as select type, avg(price) </p>
from titles </p>
where type = "business"</p>
&nbsp;</p>
В предыдущем примере возможно было бы целесообразно ограничиться только книгами по бизнесу, поскольку результаты будут выданы по всем категориям книг. Дополнительная информация о группировке была приведена в главе 3.</p>
&nbsp;</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Определение вьювера через соединение</td></tr></table></div>Пользователь может создать вьювер из нескольких базовых таблиц. Далее приводится пример вьювера, полученного из таблиц authors и publishers. В нем отображаются фамилии авторов книг, которые живут в одном городе с издателем, вместе с названием издателя и названием города.</p>
&nbsp;</p>
create view cities (authorname, acity, publishername, pcity) </p>
as select au_lname, authors.city, pub_name, publishers.city </p>
from authors, publishers </p>
where authors.city = publishers.city</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Построение вьювера из других вьюверов</td></tr></table></div>&nbsp;</p>
Вьювер можно определить на основе других вьюверов, например:</p>
&nbsp;</p>
create view hiprice_computer </p>
as select title, price </p>
from hiprice </p>
where type = 'popular_comp' </p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Построение вьювера с ключевым словом distinct</td></tr></table></div>&nbsp;</p>
Пользователь может определить вьювер, в котором не будут повторяться строки, например:</p>
&nbsp;</p>
create view author_codes</p>
as select distinct au_id</p>
from titleauthor</p>
&nbsp;</p>
Строка является дубликатом другой строки, если значения во всех столбцах этой строки в точности совпадают со значениями в другой строке. При этом неопределенные значения рассматриваются как одинаковые.</p>
SQL Сервер обеспечивает отсутствие дубликатов, когда вьювер открывается в первый раз и перед каждой проекцией или селекцией. Вьюверы выглядят и ведут себя как обычные таблицы. Если выполняется проекция во вьювере без повторений, т.е. выбираются все строки по некоторым столбцам, то могут появиться результаты, которые кажутся повторяющимися. Однако, каждая строка вьювера по прежнему будет уникальной. Например, предположим, что создается вьювер без повторений myview с тремя столбцами a,b, и c, которые содержат следующие величины:</p>
&nbsp;</p>
Таблица 9-1: Пример вьювера myview без повторений</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td ><p>a</p>
</td>
<td ><p>b</p>
</td>
<td ><p>c</p>
</td>
</tr>
<tr >
<td ><p>1</p>
</td>
<td ><p>1</p>
</td>
<td ><p>2</p>
</td>
</tr>
<tr >
<td ><p>1</p>
</td>
<td ><p>2</p>
</td>
<td ><p>3</p>
</td>
</tr>
<tr >
<td ><p>1</p>
</td>
<td ><p>1</p>
</td>
<td ><p>0
</td>
</tr>
</table>
&nbsp;</p>
Если появится запрос:</p>
&nbsp;</p>
select a,b from myview,</p>
&nbsp;</p>
то результаты будут выглядеть следующим образом:</p>
&nbsp;</p>
a&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; b</p>
---&nbsp;&nbsp;&nbsp; -----</p>
1 &nbsp; &nbsp; &nbsp; &nbsp;1</p>
1 &nbsp; &nbsp; &nbsp; &nbsp;2</p>
1 &nbsp; &nbsp; &nbsp; &nbsp;1</p>
&nbsp;</p>
Первая и третья строки выглядят здесь одинаково. Однако, исходные строки вьювера по прежнему уникальны.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Вьюверы со счетчиками</td></tr></table></div>Пользователь может определить вьювер со столбцом счетчика, например:</p>
&nbsp;</p>
create view sales_view</p>
as select syb_identity, stor_id</p>
from sales_daily</p>
&nbsp;</p>
В операторе выбора можно указать столбец счетчика с помощью ключевого слова syb_identity, если вьювер удовлетворяет следующим условиям:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>В операторе выбора указан только один столбец счетчик;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Вьювер строится на основе только одной таблицы;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Значение счетчика не используется в вычисляемых столбцах;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Вьювер не содержит агрегирующих функций.</td></tr></table></div>&nbsp;</p>
Если хотя бы одно из этих условий не имеет места, то SQL Сервер не будет определять этот столбец как счетчик вьювера. Если пользователь в этом случае посмотрит атрибуты вьювера с помощью системной процедуры sp_help, то атрибут IDENTITY для этого столбца будет равен 0.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Использование опции with check в определении вьювера&nbsp; </td></tr></table></div>&nbsp;</p>
Обычно, SQL Сервер не проверяет попадают ли модифицируемые&nbsp; операторами insert (вставка) и update (обновление) строки в область видимости вьювера или нет. Оператор может через вьювер вставить строку в базовую таблицу, которую не видно во вьювере, или изменить в строке данные таким образом, что строка не будет удовлетворять условиям отбора во вьювер.</p>
Если вьювер определяется с опцией with check (с проверкой), то при выполнении операторов модификации данных insert и update, будет проводиться проверка видимости данных. Другими словами, при вставке или модификации данных через этот вьювер, они должны оставаться видимыми, в противном случае оператор будет трактоваться как ошибочный.</p>
Далее приводится пример вьювера stores_cal, созданного с опцией with check. В этом вьювере содержатся данные о книжных магазинах, расположенных в Калифорнии, но нет информации о магазинах, расположенных в других штатах. В этот вьювер отбираются все строки из таблицы stores, в которых в поле штат указана величина “CA”: </p>
&nbsp;</p>
create view stores_cal</p>
as select * from stores</p>
where state = "CA"</p>
with check option</p>
&nbsp;</p>
Когда пользователь вставляет новую строку через вьювер stores_cal, SQL Сервер проверяет удовлетворяет ли новая строка условиям видимости в этом вьювере. Следующий оператор вставки является ошибочным, поскольку втавляется строка, в которой указан штат Нью-Йорк (NY), а не Калифорния:</p>
&nbsp;</p>
insert stores_cal</p>
values ("7100", "Castle Books", "351 West 24 St.", "New York", "NY", "USA",  &nbsp; &nbsp; &nbsp; &nbsp;"10011",  &nbsp; &nbsp; &nbsp; &nbsp;"Net 30")</p>
&nbsp;</p>
Когда пользователь модифицирует строку через вьювер stores_cal, SQL Сервер проверяет удовлетворяет ли эта строка условиям видимости в этом вьювере. Следующий оператор обновления является ошибочным, поскольку в нем код штата изменяется с “CA” на “MA”. Если допустить такое обновление, то новая строка не будет видна через этот вьювер.</p>
&nbsp;</p>
update stores_cal</p>
set state = "MA"</p>
where stor_id = "7066"</p>
&nbsp;</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Построение вьювера на основе другого вьювера с опцией with check</td></tr></table></div>Если вьювер был опеределен с опцией with check, то все вьюверы определенные на его базе (вторичные вьюверы) также будут удовлетворять этому условию. Каждая строка, вставляемая или обновляемая во вторичном (derived) вьювере должна быть видна в базовом вьювере.</p>
Рассмотрим вьювер stores_cal30, который определяется на основе вьювера stores_cal. Во вторичный вьювер включается информация о книжых магазинах в Калифорнии с атрибутом payterms, равным “Net 30”:</p>
&nbsp;</p>
create view stores_cal30</p>
as select * from stores_cal</p>
where payterms = "Net 30"</p>
&nbsp;</p>
Поскольку вьювер stores_cal создавался в опцией with check, то все строки вставляемые или обновляемые во вторичном вьювере stores_cal30 должны быть видны через базовый вьювер stores_cal, т.е. любая строка, в которой указан штат отличный от Калифорнии будет отвергнута.</p>
Заметим, что сам вторичный вьювер stores_cal30 был определен без опции with check. Отсюда следует, что через этот вьювер возможна вставка или обновление строк, у которых поле payterms не равно "Net 30". Следующий оператор обновления будет успешно выполнен, несмотря на то, что обновляемая строка не будет больше видна во вьювере stores_cal30:</p>
&nbsp;</p>
update stores_cal30</p>
set payterms = "Net 60"</p>
where stor_id = "7067"</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Ограничения вьюверов основанных на внешнем соединении</td></tr></table></div>&nbsp;</p>
Вьюверы, определенные через внешнее соединение, имеют некоторые ограничения, которые могут приводить к неожиданным результатам при выборке данных. При использовании таких вьюверов нужно быть особенно внимательным.</p>
Если вьювер определен через внешнее соединение и через него запрашиваются данные по значению в столбце внутренней (inner) таблицы внешнего соединения, то результаты могут отличаться от ожидаемых. Значение, указанное в запросе не будет ограничивать число возвращаемых строк, а будет влиять лишь на возвращение неопределенных значений. В тех строках, в которых значение отличается от указанного, появятся неопределенные значения в соответствующих столбцах внутренней таблицы. Это является следствием того факта, что Transact-SQL формирует внутреннее представление запроса к вьюверу в виде комбинации из определения вьювера и ограничений в запросе.</p>
Например, предположим, что имеются следующие таблицы:</p>
&nbsp;</p>
Таблица А</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >a</p>
</td>
</tr>
<tr >
<td >1</p>
</td>
</tr>
<tr >
<td >2</p>
</td>
</tr>
<tr >
<td >3
</td>
</tr>
</table>
&nbsp;</p>
Таблица В</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td ><p>b</p>
</td>
<td ><p>c</p>
</td>
</tr>
<tr >
<td ><p>1</p>
</td>
<td ><p>10</p>
</td>
</tr>
<tr >
<td ><p>2</p>
</td>
<td ><p>11</p>
</td>
</tr>
<tr >
<td ><p>6</p>
</td>
<td ><p>12
</td>
</tr>
</table>
&nbsp;</p>
Определим вьювер на основе этих двух таблиц с помощью внешнего соединения: </p>
&nbsp;</p>
create view A_B as </p>
select a,b,c from A,B&nbsp; </p>
where A.a*=B.b </p>
&nbsp;</p>
Если теперь обратиться к этому вьюверу с приведенным ниже запросом, то получим следующие результаты:</p>
&nbsp;</p>
select a,c from A_B where c = 10</p>
&nbsp;</p>
  a&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; с</p>
----&nbsp;&nbsp;&nbsp; ----</p>
  1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 10&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
  2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL </p>
  3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
&nbsp;</p>
(Выбрано 3 строки)</p>
&nbsp;</p>
Ограничение (с=10) не повлияло на число выводимых строк. Здесь появились неопределенные значения в столбце внутренней таблицы для каждой строки, в которой либо находиться другое значение (2 строка), либо во второй таблице отсутствует соответствующее внешнему соединению значение (3 строка).</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Выборка данных через вьювер</td></tr></table></div>&nbsp;</p>
Когда через вьювер пользователь выбирает данные, SQL Сервер проверяет существование всех запрашиваемых в операторе объектов и возможности доступа к ним из данного оператора. Если все проверки закончились успешно, то SQL Сервер объединяет этот оператор с определением вьювера и транслирует его в запрос к базовым таблицам, как уже отмечалось в предыдущем разделе. Этот процесс называется раскрытием вьювера (view resolution).</p>
Рассмотрим следующий оператор с определением вьювера, который уже приводился в этой главе, вместе с запросом к этому вьюверу:</p>
&nbsp;</p>
create view hiprice </p>
as select * </p>
from titles </p>
where price &gt; $15 </p>
and advance &gt; $5000 </p>
&nbsp;</p>
select title, type </p>
from hiprice </p>
where type = 'popular_comp' </p>
&nbsp;</p>
SQL Сервер объединяет запрос к вьюверу hiprice с его определением и в результате получается следующий запрос:</p>
&nbsp;</p>
select title, type </p>
from titles </p>
where price &gt; $15 </p>
and advance &gt; $5000 </p>
and type = 'popular_comp'</p>
&nbsp;</p>
В общем случае через вьювер можно запрашивать данные также как и через обычную таблицу. Здесь также можно использовать соединения, проводить группировку (в предложении group by), включать подзапросы в любых комбинациях. Однако, если вьювер определяется внешним соединением или с агрегирующими функциями, то запрос к этому вьюверу может привести к неожиданным результатам, как это было отмечено в предыдущем разделе “Ограничения вьюверов ...”.</p>
&nbsp;</p>
Замечание. Можно выбирать текстовую и графическую информацию из соответствующих столбцов вьювера, но не разрешается использовать команды readtext (считать текст) и writetext (записать текст). Кроме того, через вьювер нельзя выбирать текстовую информацию из столбца, в котором различается регистр символов.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Раскрытие вьювера</td></tr></table></div>&nbsp;</p>
Когда пользователь определяет вьювер, SQL Сервер проверяет существование базовых таблиц и вьюверов, преречисленных в предложении from, и выдает сообщение об ошибке при возникновении проблем. Аналогичная проверка проводится при появлении запроса через вьювер.</p>
Между определением вьювера и запросом к нему ситуация может измениться. Например, некоторые из базовых таблиц или вьюверов за это время могут быть уничтожены, или некоторые столбцы вьювера могут быть переименованы.</p>
Для полного раскрытия вьювера SQL Сервер проверяет следующие условия:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Все базовые таблицы и вьюверы, а также соответствующие столбцы, на которых основан данный вьювер, должны существовать;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Типы данных всех столбцов, от которых зависит данный вьювер, должны быть совместимы с типами данных соответствующих столбцов вьювера;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Если оператор изменяет данные (оператор обновления, вставки или удаления), то он не должен нарушать ограничений на изменение данных, установленных для данного вьювера. Этот вопрос также будет обсуждаться в следующем разделе этой главы.</td></tr></table></div>&nbsp;</p>
Если хотя бы одно из этих условий не выполнено, то SQL Сервер выдает сообщение об ошибке.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Переопределение вьюверов</td></tr></table></div>&nbsp;</p>
В отличие от многих других систем управления базами данных, SQL Сервер позволяет переопределять вьювер. При этом зависящие от него вьюверы нужно переопределять лишь в том случае, если SQL Сервер не сможет автоматически получить для них новых описаний.</p>
В качестве примера рассмотрим таблицу authors и три вьювера, определенные далее. Каждый последующий вьювер базируется на предыдущем, т.е. view2 базируется на view1, а view3 базируется на view2. В этом смысле view2 зависит от view1, а view3 от обеих предшествующих вьюверов.</p>
Далее после названия каждого вьювера приведено его определение:</p>
&nbsp;</p>
view1:</p>
create view view1 as</p>
select au_lname, phone from authors </p>
where postalcode like "94%"</p>
&nbsp;</p>
view2:</p>
create view view2 as</p>
select au_lname, phone from view1 </p>
where au_lname like "[M-Z]%"</p>
&nbsp;</p>
view3:</p>
create view view3 as</p>
select au_lname, phone from view2 </p>
where au_lname = "MacFeather"</p>
&nbsp;</p>
Таблица authors (авторы), на которой базируются эти вьюверы, состоит из столбцов au_id (код автора), au_lname (фамилия), au_ftname (имя), phone (телефон), address (адрес), city (город), state (штат), postalcode (почтовый код).</p>
Пользователь может удалить вьювер view2 или заменить его другим вьювером с тем же названием, но с другим критерием видимости данных, например, фамилии авторов должны начинаться с букв М-Р. При этом зависимый от него вьювер view3 останется правильным и его не нужно будет переопределять. Когда появляется запрос к view2 или к view3, то раскрытие вьювера происходит обычным образом.</p>
Если переопределить вьювер view2 таким образом, что вьювер view3 не может быть из него получен, то вьювер view3 становиться неправильным и его необходимо переопределить. Например, если в новой версии вьювера view2 содержится только один столбец au_lname вместо двух, то вьювер view3 нельзя будет использовать, поскольку он не имеет доступа к столбцу phone объекта, от которого он зависит.</p>
Тем не менее вьювер view3 будет существовать и его можно будет вновь использовать, если удалить новую версию вьювера view2 и восстановить верию view2 с двумя столбцами au_lname и phone.</p>
Другими словами, можно переопределить промежуточный вьювер без необходимости переопределения зависящих от него вьюверов, если только оператор выбора select в определении зависимого вьювера остается правильным. Если это условие нарушено, то на запрос, который обращается к ошибочному вьюверу, будет выдано сообщение об ошибке.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Переименование вьюверов</td></tr></table></div>&nbsp;</p>
Пользователь может переименовать вьювер с помощью системной процедуры sp_rename. Синтаксис вызова этой процедуры имеет следующий вид:</p>
&nbsp;</p>
sp_rename objname, newname </p>
&nbsp;</p>
Например, для переименования вьювера titleview в bookview можно использовать следующую команду:</p>
&nbsp;</p>
sp_rename titles_view, bookview</p>
&nbsp;</p>
Конечно, новое название вьювера должно удовлетворять правилам написания идентификаторов (нельзя использовать процедуру sp_rename для присвоения нового названия, заключенного в кавычки). Пользователь может переименовывать лишь те вьюверы, которыми он владеет. Владелец базы данных может переименовать любой вьювер пользователя. Вьювер, название которого изменяется, должен находиться в текущей базе данных.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Изменение и удаление базовых объектов</td></tr></table></div>&nbsp;</p>
Если изменяется название базовой таблицы, из которой получен вьювер, то у пользователя могут возникнуть проблемы. Вьюверы, зависящие от этой таблицы, могут продолжать успешно работать и дальше. На самом деле они будут работать до тех пор, пока SQL Сервер может перекомпилировать их. Перекомпиляция проводится по многим причинам, причем без уведомления пользователя, например, после загрузки базы данных, или если пользователь сначала удалил, а затем восстановил таблицу или индекс. Если по каким-либо&nbsp; причинам перекомпиляция не проводилась или оказалась невозможной, то обращение к вьюверу или попытка его модификации могут вызвать неожиданное сообщение об ошибке.</p>
В этом случае пользователь должен удалить этот вьювер, а затем снова определить его так, чтобы отразить в новом определении произошедшие изменения названий базовых объектов. Чтобы избежать этих проблем, лучше всего вообще не переименовывать таблицы и вьюверы, от которых зависят другие вьюверы, или сразу после переименования проводить переопределение всех зависимых объектов.</p>
Аналогичная ситуация возникает, если вьювер зависит от таблицы, которая была удалена. Если обратиться к такому вьюверу, то SQL Сервер выдаст сообщение об ошибке. Однако, если будет создана новая таблица, которая заменяет старую, то вьювер вновь можно будет использовать.</p>
Если вьювер определяется предложением select * и затем изменяется структура базовой таблицы путем добавления некоторых столбцов, то новые столбцы не будут видны в этом вьювере, поскольку звездочка интерпретируется как полный список столбцов существующих на момент создания вьювера. Чтобы увидеть новые столбцы, нужно удалить этот вьювер, а затем переопределить его.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Изменение данных через вьювер</td></tr></table></div>&nbsp;</p>
Хотя SQL Сервер не накладывает никаких ограничений на выборку данных через вьювер, и хотя язык Transact-SQL накладывает минимальные ограничения на изменение данных через вьювер по сравнению с другими версиями языка SQL, тем не менее существуют следующие виды модификации данных, которые нельзя проводить через вьювер:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Нельзя проводить обновление, вставку и удаление данных из столбцов, значения в которых вычисляются по формулам или с помощью встроенных функций;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Нельзя проводить обновление, вставку и удаление данных через вьювер, в котором вычисляются итоговые значения или групповые итоговые значения;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Нельзя проводить обновление, вставку и удаление данных через вьювер, который определяется с опцией distinct (различные);</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Оператор вставки insert можно использовать лишь в том случае, если все столбцы базовой таблицы, в которых не допускаются неопределенные значения (NOT NULL), включены во вьювер, через который происходит вставка, поскольку в противном случае SQL Сервер не может присвоить соответствующим полям базовой таблицы исходные значения;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Если вьювер определен с опцией with check option, то все вставляемые или обновляемые через него (или через любой зависимый от него вьювер) строки должны удовлетворять условиям видимости в этом вьювере;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Нельзя удалять (оператором delete) данные через мультитабличный (т.е. определенный на основе нескольких таблиц) вьювер;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Нельзя вставлять (оператором insert) данные через мультитабличный вьювер, определенный с опцией with check option;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Можно обновлять (оператором update) данные через мультитабличный вьювер, определенный с опцией with check option. Это обновление будет ошибочным лишь в том случае, если изменяется значение в столбце, который встречается в одном из выражений предложения where вместе с названиями столбцов из других таблиц;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Нельзя использовать операторы insert и update для мультитабличных вьюверов, определенных с опцией distinct (различные);</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Нельзя обновлять (оператором update) значение в поле счетчика (IDENTITY). Владелец таблицы или владелец базы данных или системный администратор могут вставлять точно указанное значение в поле счетчика, если для этой таблицы установлена опция identity_insert;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Если вставляется или обновляется строка через мультитабличный вьювер, то все изменяемые столбцы должны принадлежать к одной таблице;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Команду writetext нельзя применять к тектовым (text) или графическим (image) полям вьювера.</td></tr></table></div>&nbsp;</p>
Когда выполняется оператор обновления, вставки или удаления, то SQL Сервер проверяет, что ни одно из вышеупомянутых условий не&nbsp; имеет места и что не нарушаются условия целостности данных.</p>
Почему через некоторые вьюверы можно обновлять данные, а через другие нельзя ? Чтобы лучше понять возникающие здесь ограничения, рассмотрим по примеру на каждый тип вьювера, через который нельзя обновлять данные. </p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Ограничения на обновление через вьюверы</td></tr></table></div>&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Вычисляемые столбцы в определении вьювера</td></tr></table></div>&nbsp;</p>
Первое ограничение касается вычисляемых столбцов во вьюверах или столбцов, значения в которых вычисляются через встроенные функции. Рассмотрим, например, столбец amt_due во вьювере accounts, который был определен ранее следующим образом.</p>
&nbsp;</p>
create view accounts (title_id, advance, amt_due) </p>
as select titles.title_id, advance, (price * royalty/100) * total_sales </p>
from titles, roysched </p>
where price &gt; $15 </p>
  and advance &gt; $5000 </p>
  and titles.title_id = roysched.title_id </p>
  and total_sales between lorange and hirange </p>
&nbsp;</p>
Через этот вьювер видны следующие строки:</p>
&nbsp;</p>
select * from accounts</p>
&nbsp;</p>
title_id&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; advance&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; amt_due </p>
---------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------- </p>
PC1035&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7,000.00&nbsp;&nbsp;&nbsp; 32,240.16 </p>
PC8888&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 8,000.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 8,190.00 </p>
PS1372&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7,000.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 809.63 </p>
TC3218&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7,000.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 785.63</p>
&nbsp;</p>
(Выбрано 4 строки))</p>
&nbsp;</p>
Нельзя модифицировать и вставлять данные в столбец amt_due, поскольку невозможно определить соответсвующие значения для столбцов price и royalty, исходя из введенного в столбец amt_due значения. Операция удаления здесь вообще не имеет смысла, поскольку отсутствует само значение, которое надо удалить.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Предложения group by и compute by в определении вьювера</td></tr></table></div>&nbsp;</p>
Второе ограничение касается вьюверов, содержащих агрегирующие функции (подведение итогов), т.е. вьюверов, определение которых содержит конструкции group by или compute by. Далее приведен пример вьювера с конструкцией группировки (group by) и показаны видимые через него данные:</p>
&nbsp;</p>
create view categories (category, average_price) </p>
as select type, avg(price) </p>
from titles </p>
group by type </p>
&nbsp;</p>
select * from categories </p>
&nbsp;</p>
category&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; average_price </p>
-------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------- </p>
UNDECIDED&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL </p>
business&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 13.73 </p>
mod_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 11.49 </p>
popular_comp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 21.48 </p>
psychology&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 13.50 </p>
trad_cook&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 15.96</p>
&nbsp;</p>
(Выбрано 6 строк)</p>
&nbsp;</p>
Не имеет смысла вставлять строки через вьювер categories, поскольку непонятно к какой группе в базовой таблице отнести вставляемую строку. Кроме того, обновление значений в столбце average_price (средняя цена) также не имеет смысла, поскольку невозможно подогнать базовые значения цены под введенное значение.</p>
Теоретически можно представить себе обновление и удаление через этот вьювер, но SQL Сервер не поддерживает эти возможности.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Неопределенные значения в базовых объектах</td></tr></table></div>&nbsp;</p>
Третье ограничение касается оператора вставки (insert), когда в базовых таблицах или вьюверах имеются столбцы, в которых нельзя использовать неопределенное значение (NOT NULL).</p>
Например, предположим, что в некотором столбце базовой таблицы вьювера нельзя использовать неопределенное значение. Обычно, когда вставляются строки через вьювер, устанавливается неопределенное значение во всех столбцах базовой таблицы, которые не видны во вьювере. Если в столбце нельзя использовать неопределенное значение, то нельзя допускать и вставок через такой вьювер.</p>
Рассмотрим следующий вьювер:</p>
&nbsp;</p>
create view titleview </p>
as select title_id, price, total_sales </p>
from titles </p>
where type = 'business'</p>
&nbsp;</p>
Неопределенные значения не разрешены в столбце title базовой таблицы titles, поэтому и вставка через вьювер titleview не разрешена. Хотя столбец title даже не упоминается во вьювере, тем не менее запрет на использование в нем неопределенных значений делает любую вставку через этот вьювер ошибочной.</p>
Аналогично, если столбец title_id имеет уникальный индекс, то любое обновление или вставка через вьювер, которые приводят к потере уникальности значений в этом столбце базовой таблицы, будут ошибочными, хотя возможно во вьювере все значения в этом столбце будут различными.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Вьюверы, определенные с опцией with chek option</td></tr></table></div>&nbsp;</p>
Четвертое ограничение касается модификации данных через вьювер, определенный с опцией проверки (with check). В таком вьювере любая вставляемая или обновляемая строка должна быть видима через этот вьювер. Это правило действует как для модификации данных осуществляемой непосредственно через этот вьювер, так и для модификации данных, осуществляемой через зависимые от него вьюверы.</p>
&nbsp;</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Мультитабличные вьюверы</td></tr></table></div>Пятое ограничение касается модификации данных проводящейся, через вьюверы, в которых соединяются данные из нескольких таблиц (мультитабличные вьюверы). SQL Сервер не допускает удаления данных через такие вьюверы, но позволяет их вставлять и обновлять, что обычно не допускается в других системах.</p>
Пользователь может вставлять и обновлять данные через мультитабличный вьювер, если выполняются следующие условия:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Вьювер определен без опции with check option;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Все столбцы, в которые вставляются или в которых изменяются данные, должны принадлежать одной базовой таблице.</td></tr></table></div>&nbsp;</p>
Например, рассмотрим следующий вьювер, в который включены столбцы из таблиц titles и publishers и который не имеет опции проверки модификации with check option:</p>
&nbsp;</p>
create view multitable_view</p>
as select title, type, titles.pub_id, state</p>
from titles, publishers</p>
where titles.pub_id = publishers.pub_id</p>
&nbsp;</p>
Каждый оператор вставки или обновления должен модифицировать данные или только из таблицы titles или только из таблицы publishers. Следующий оператор обновления является правильным:</p>
&nbsp;</p>
update multitable_view</p>
set type = "user_friendly"</p>
where type = "popular_comp"</p>
&nbsp;</p>
Но нижеприведенный оператор является неправильным, поскольку в нем обновляются столбцы как из таблицы titles, так и из таблицы publishers:</p>
&nbsp;</p>
update multitable_view</p>
set type = "cooking_trad",</p>
state = "WA"</p>
where type = "trad_cook"</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Вьюверы со столбцами-счетчиками</td></tr></table></div>&nbsp;</p>
Последнее ограничение касается модификации данных через вьюверы, которые содержат столбцы-счетчики (IDENTITY column). По определению значения в таком столбце изменять нельзя. При обновлении через вьювер нельзя обновлять значение в столбце-счетчике.</p>
Вставка данных в столбец-счетчик разрешена только владельцу таблицы, владельцу базы данных или системному администратору. Чтобы вставить значение в столбец-счетчик через вьювер, нужно установить для этого вьювера опцию identity_insert.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Удаление вьюверов</td></tr></table></div>&nbsp;</p>
Чтобы удалить вьювер из базы данных, нужно выполнить команду drop view (удалить вьювер). Эта команда имеет следующий вид:</p>
&nbsp;</p>
drop view [[база_данных.]владелец.]название_вьювера </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [, [[база_данных.]владелец.]название_вьювера] ... </p>
&nbsp;</p>
Как видно из этого описания, пользователь может удалить сразу несколько вьюверов. Только владелец вьювера (или владелец базы данных) может удалить его.</p>
Далее приводится команда удаления вьювера hiprice:</p>
&nbsp;</p>
drop view hiprice</p>
&nbsp;</p>
Когда выполняется команда drop view, название указанного вьювера удаляется из системных таблиц sysprocedures, sysobjects, syscolumns, syscomments, sysprotects sysdepends. Все права на этот вьювер также анулируются.</p>
Если вьювер зависит от таблицы или от другого вьювера, которые были удалены, то SQL Сервер выдает сообщение об ошибке при попытке его использования. Если создается новая таблица или вьювер с тем же названием вместо удаленного, то зависимый вьювер можно вновь использовать, до тех пор пока существуют все столбцы, указанные в определении вьювера.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Использование вьюверов для обеспечения безопасности</td></tr></table></div>&nbsp;</p>
Права на доступ к данным через вьювер должны быть явно предоставлены или отняты независимо от прав доступа к базовым таблицам, на которых построен этот вьювер. Данные из базовой таблицы, которые не видны во вьювере, являются скрытыми для тех пользователей, кто имеет права доступа ко вьюверу, но не имеют прав доступа к базовой таблице.</p>
Например, можно ограничить доступ некоторым пользователям к столбцам таблицы titles, содержащим финансовую информацию. Для этого можно создать вьювер на базе этой таблицы, в котором не видны соответствующие столбцы, и предоставить всем пользователям право пользоваться этим вьювером, а к базовой таблице предоставить доступ только сотрудникам отдела продаж. Это можно сделать следующим образом:</p>
&nbsp;</p>
revoke all on titles to public </p>
grant all on bookview to public </p>
grant all on titles to sales</p>
&nbsp;</p>
Более подробную информацию о том, как предоставлять (grant) и отнимать (revoke) права, можно посмотреть в Руководстве пользователя по средствам ограничения доступа SQL Сервера.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Получение информации о вьюверах</td></tr></table></div>&nbsp;</p>
Несколько системных процедур предоставляют информацию из системных таблиц об имеющихся вьюверах.</p>
Пользователь может получить отчет о вьювере с помощью системной процедуры sp_help. Например:</p>
&nbsp;</p>
sp_help hiprice</p>
&nbsp;</p>
&nbsp;</p>
Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Owner&nbsp;&nbsp;&nbsp;&nbsp; type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Created_on </p>
---------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------------- </p>
hiprice&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dbo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; view&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Feb 12 1987 11:57AM </p>
&nbsp;</p>
&nbsp;</p>
Data_located_on_segment&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; When_created&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
----------------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------------------</p>
&nbsp;</p>
&nbsp;</p>
Column_name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Length&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Precision&nbsp;&nbsp;&nbsp; Scale</p>
------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ---------&nbsp;&nbsp;&nbsp;&nbsp; ---------</p>
title_id  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;tid &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 6&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
title &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;varchar &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 80&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp; NULL</p>
type &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;char &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;12&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp; NULL</p>
pub_id &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;char &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp; NULL</p>
price &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;money &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 8&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp; NULL</p>
advance &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;money &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 8&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp; NULL</p>
royalty &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;int &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp; NULL</p>
total_sales &nbsp; &nbsp; &nbsp; &nbsp;int &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp; NULL</p>
notes &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;varchar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 200&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp; NULL</p>
pubdate &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;datetime &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 8&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp; NULL</p>
&nbsp;</p>
Null&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Default_name&nbsp;&nbsp; Rule_name&nbsp;&nbsp;&nbsp; Identity</p>
------&nbsp;&nbsp;&nbsp; --------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ---------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------</p>
0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0</p>
0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0</p>
0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0</p>
1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0</p>
1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0</p>
1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0</p>
1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0</p>
1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0</p>
1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0</p>
0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0</p>
No defined keys for this object.</p>
(return status = 0)</p>
&nbsp;</p>
Чтобы увидеть определение вьювера, которое было помещено в оператор создания вьювера (creat view), нужно выполнить системную процедуру sp_helptext:</p>
&nbsp;</p>
sp_helptext hiprice </p>
---------- </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1 </p>
(1 row affected) </p>
&nbsp;</p>
text </p>
----------------------- </p>
create view hiprice </p>
as select * </p>
from titles </p>
where price &gt; $15 </p>
and advance &gt; $5000 </p>
&nbsp;</p>
Системная процедура sp_depends перечисляет все объекты, от которых зависит данная таблица или вьювер и которые расположены в текущей базе данных, а также все объекты, которые зависят от данной таблицы или вьювера. Например:</p>
&nbsp;</p>
sp_depends titles </p>
&nbsp;</p>
Things inside the current database that reference the object (Объекты текущей базы данных, которые зависят от данного объета). </p>
&nbsp;</p>
object&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; type </p>
-------------&nbsp;&nbsp; --------------------------</p>
dbo.hiprice&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; view </p>
dbo.titleview&nbsp;&nbsp;&nbsp; view </p>
dbo.reptq1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; stored procedure </p>
dbo.reptq2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; stored procedure </p>
dbo.reptq3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; stored procedure </p>
&nbsp;</p>

